<?php
/**
 * Avantex Demo Exporter Utility.
 *
 * Provides a high-fidelity admin dashboard to sanitize, placeholder-remap, and package
 * active local WordPress setups into production-ready demo content folders.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'AVANTEX_COMPANION_VERSION' ) ) {
	define( 'AVANTEX_COMPANION_VERSION', '0.2.8' );
}

/**
 * Avantex Demo Exporter Utility Class.
 */
if ( ! class_exists( 'Reavantex_Demo_Exporter' ) ) :
class Reavantex_Demo_Exporter {

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'admin_menu', array( $this, 'register_exporter_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
			add_action( 'wp_ajax_avantex_generate_demo_export', array( $this, 'ajax_generate_demo_export' ) );
			add_action( 'wp_ajax_avantex_delete_exported_demo', array( $this, 'ajax_delete_exported_demo' ) );
			add_action( 'wp_ajax_avantex_get_demo_list_table', array( $this, 'ajax_get_demo_list_table' ) );
		}
	}

	/**
	 * Register the admin menu page.
	 */
	public function register_exporter_page() {
		add_submenu_page(
			'themes.php',
			esc_html__( 'ReAvantex Demo Export', 'avantex' ),
			esc_html__( 'ReAvantex Demo Export', 'avantex' ),
			'manage_options',
			'avantex-demo-exporter',
			array( $this, 'render_exporter_page' )
		);
	}

	/**
	 * Enqueue developer admin bar styles and scripts.
	 *
	 * @param string $hook Admin page hook.
	 */
	public function enqueue_assets( $hook ) {
		if ( 'appearance_page_avantex-demo-exporter' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * AJAX endpoint to sanitize and compile the demo export.
	 */
	public function ajax_generate_demo_export() {
		check_ajax_referer( 'avantex-exporter-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_key( $_POST['demo_slug'] ) : '';
		if ( empty( $demo_slug ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Please provide a valid demo slug.', 'avantex' ) ) );
		}

		$demo_dir = get_stylesheet_directory() . '/demo-content/' . $demo_slug;
		if ( ! file_exists( $demo_dir ) ) {
			wp_mkdir_p( $demo_dir );
		}

		$site_url = untrailingslashit( get_option( 'siteurl' ) );

		// Ensure WordPress filesystem functions are loaded.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		// --- PHASE 1: SANITIZE CUSTOMIZER (.DAT) ---
		$theme_mods = get_theme_mods();
		if ( ! empty( $theme_mods ) ) {
			// Clean domain URLs and serialize safely.
			$cleaned_mods = $this->sanitize_nested_urls( $theme_mods, $site_url );

			// Package format matches standard Customizer Export/Import plugin (.dat).
			$dat_data = array(
				'template' => get_template(),
				'mods'     => $cleaned_mods,
			);

			// phpcs:ignore
			$serialized_dat = serialize( $dat_data );
			$wp_filesystem->put_contents( $demo_dir . '/' . $demo_slug . '.dat', $serialized_dat );
		}

		// --- PHASE 2: AUTO-GENERATE & SANITIZE WXR XML ---
		$xml_source = $demo_dir . '/' . $demo_slug . '.xml';

		// Auto-generate XML using WordPress core.
		ob_start();
		require_once ABSPATH . 'wp-admin/includes/export.php';
		export_wp( array( 'content' => 'all' ) );
		$xml_content = ob_get_clean();

		// Reset headers altered by export_wp() so JSON response doesn't break.
		header_remove( 'Content-Disposition' );
		header_remove( 'Content-Description' );
		header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );

		if ( ! empty( $xml_content ) ) {
			// Replace known remote hardcoded media URLs (including multisite paths like /sites/26/).
			$xml_content = preg_replace( '/https?:\/\/wpfrank\.com\/demo\/[a-zA-Z0-9\-]+\/wp-content\/uploads\/(sites\/\d+\/)?/', '%%WPFRANK_DEMO_URL%%/wp-content/uploads/', $xml_content );

			// Replace any remaining remote domain calls.
			$xml_content = preg_replace( '/https?:\/\/wpfrank\.com\/demo\/[a-zA-Z0-9\-]+/', '%%WPFRANK_DEMO_URL%%', $xml_content );

			// Replace local URLs with the placeholder.
			$xml_content = str_replace( $site_url, '%%WPFRANK_DEMO_URL%%', $xml_content );

			// Dynamically repair common corrupted closing tags.
			$xml_content = str_replace( '<link>%%WPFRANK_DEMO_URL%%/link>', '<link>%%WPFRANK_DEMO_URL%%</link>', $xml_content );
			$xml_content = str_replace( '<wp:base_site_url>%%WPFRANK_DEMO_URL%%/wp:base_site_url>', '<wp:base_site_url>%%WPFRANK_DEMO_URL%%</wp:base_site_url>', $xml_content );
			$xml_content = str_replace( '<wp:base_blog_url>%%WPFRANK_DEMO_URL%%/wp:base_blog_url>', '<wp:base_blog_url>%%WPFRANK_DEMO_URL%%</wp:base_blog_url>', $xml_content );

			$wp_filesystem->put_contents( $xml_source, $xml_content );
		}

		// --- PHASE 3: EXPORT ACTIVE WIDGETS (.WIE) ---
		$widgets_data = $this->export_active_widgets( $site_url );
		if ( ! empty( $widgets_data ) ) {
			$json_widgets = wp_json_encode( $widgets_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			$wp_filesystem->put_contents( $demo_dir . '/' . $demo_slug . '.wie', $json_widgets );
		}

		// --- PHASE 4: BUNDLE INTO ZIP ARCHIVE ---
		$zip_file = $demo_dir . '/' . $demo_slug . '.zip';

		if ( class_exists( 'ZipArchive' ) ) {
			$zip = new ZipArchive();
			if ( $zip->open( $zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE ) === true ) {
				// Add the data files.
				if ( file_exists( $demo_dir . '/' . $demo_slug . '.xml' ) ) {
					$zip->addFile( $demo_dir . '/' . $demo_slug . '.xml', $demo_slug . '.xml' );
				}
				if ( file_exists( $demo_dir . '/' . $demo_slug . '.dat' ) ) {
					$zip->addFile( $demo_dir . '/' . $demo_slug . '.dat', $demo_slug . '.dat' );
				}
				if ( file_exists( $demo_dir . '/' . $demo_slug . '.wie' ) ) {
					$zip->addFile( $demo_dir . '/' . $demo_slug . '.wie', $demo_slug . '.wie' );
				}

				// Add the uploads folder recursively.
				$uploads_dir  = wp_upload_dir();
				$uploads_base = $uploads_dir['basedir'];

				if ( file_exists( $uploads_base ) && is_dir( $uploads_base ) ) {
					$iterator = new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator( $uploads_base, RecursiveDirectoryIterator::SKIP_DOTS ),
						RecursiveIteratorIterator::SELF_FIRST
					);

					foreach ( $iterator as $file ) {
						$relative_path = str_replace( wp_normalize_path( $uploads_base ) . '/', '', wp_normalize_path( $file->getPathname() ) );

						// Skip the avantex-demos folder to prevent recursive bloat.
						if ( strpos( $relative_path, 'avantex-demos' ) === 0 ) {
							continue;
						}

						if ( $file->isDir() ) {
							$zip->addEmptyDir( 'uploads/' . $relative_path );
						} elseif ( $file->isFile() ) {
							$zip->addFile( $file->getPathname(), 'uploads/' . $relative_path );
						}
					}
				}

				$zip->close();
			}
		}

		$download_url = get_stylesheet_directory_uri() . '/demo-content/' . $demo_slug . '/' . $demo_slug . '.zip';
		wp_send_json_success(
			array(
				/* translators: 1: demo folder slug, 2: zip file name */
				'message'      => sprintf( esc_html__( 'Success! Cleaned demo pack compiled and zipped inside: /demo-content/%1$s/%2$s.zip', 'avantex' ), $demo_slug, $demo_slug ),
				'download_url' => $download_url,
			)
		);
	}

	/**
	 * AJAX endpoint to permanently delete an exported demo folder.
	 */
	public function ajax_delete_exported_demo() {
		check_ajax_referer( 'avantex-exporter-nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Permission denied.', 'avantex' ) ) );
		}

		$demo_slug = isset( $_POST['demo_slug'] ) ? sanitize_key( $_POST['demo_slug'] ) : '';
		if ( empty( $demo_slug ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Invalid demo slug.', 'avantex' ) ) );
		}

		$demo_dir = get_stylesheet_directory() . '/demo-content/' . $demo_slug;
		if ( file_exists( $demo_dir ) && is_dir( $demo_dir ) ) {
			$this->recursive_delete( $demo_dir );
			wp_send_json_success( array( 'message' => esc_html__( 'Demo folder deleted successfully.', 'avantex' ) ) );
		}

		wp_send_json_error( array( 'message' => esc_html__( 'Demo folder not found.', 'avantex' ) ) );
	}

	/**
	 * AJAX endpoint to fetch the refreshed demo list table HTML.
	 */
	public function ajax_get_demo_list_table() {
		check_ajax_referer( 'avantex-exporter-nonce', 'security' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( -1 );
		}
		$this->render_demo_list_table();
		wp_die();
	}

	/**
	 * Recursively delete a directory and its contents.
	 *
	 * @param string $dir Directory path.
	 * @return bool True on success, false on failure.
	 */
	private function recursive_delete( $dir ) {
		// Ensure WordPress filesystem functions are loaded.
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
		global $wp_filesystem;

		if ( ! $wp_filesystem ) {
			return false;
		}

		return $wp_filesystem->delete( $dir, true );
	}

	/**
	 * Scans the /demo-content/ folder for exported demo folders.
	 */
	private function get_exported_demos() {
		$demo_dir = get_stylesheet_directory() . '/demo-content';
		if ( ! is_dir( $demo_dir ) ) {
			return array();
		}
		$demos = array();
		$dirs  = glob( $demo_dir . '/*', GLOB_ONLYDIR );
		if ( $dirs ) {
			foreach ( $dirs as $dir ) {
				$slug      = basename( $dir );
				$zip_files = glob( $dir . '/*.zip' );
				$size      = 0;
				$zip_name  = '';
				if ( ! empty( $zip_files ) ) {
					$zip_name = basename( $zip_files[0] );
					$size     = filesize( $zip_files[0] );
				}
				$demos[] = array(
					'slug' => $slug,
					'zip'  => $zip_name,
					'size' => size_format( $size ),
					'path' => $dir,
				);
			}
		}
		return $demos;
	}

	/**
	 * Helper to recursively search and replace local URLs with placeholder.
	 *
	 * @param mixed  $data     Data to sanitize.
	 * @param string $site_url Local site URL.
	 * @return mixed Sanitized data.
	 */
	private function sanitize_nested_urls( $data, $site_url ) {
		if ( is_string( $data ) ) {
			// Check if it's a JSON string (like Customizer repeaters).
			$decoded = json_decode( $data, true );
			if ( is_array( $decoded ) ) {
				$cleaned_decoded = $this->sanitize_nested_urls( $decoded, $site_url );
				return wp_json_encode( $cleaned_decoded, JSON_UNESCAPED_SLASHES );
			}

			// Replace known remote hardcoded media URLs (including multisite paths like /sites/26/).
			$data = preg_replace( '/https?:\/\/wpfrank\.com\/demo\/[a-zA-Z0-9\-]+\/wp-content\/uploads\/(sites\/\d+\/)?/', '%%WPFRANK_DEMO_URL%%/wp-content/uploads/', $data );

			// Replace any remaining remote domain calls.
			$data = preg_replace( '/https?:\/\/wpfrank\.com\/demo\/[a-zA-Z0-9\-]+/', '%%WPFRANK_DEMO_URL%%', $data );

			return str_replace( $site_url, '%%WPFRANK_DEMO_URL%%', $data );
		} elseif ( is_array( $data ) ) {
			foreach ( $data as $key => $val ) {
				$data[ $key ] = $this->sanitize_nested_urls( $val, $site_url );
			}
		}
		return $data;
	}

	/**
	 * Export current sidebar widget configurations and replace local domain URLs.
	 *
	 * @param string $site_url Local site URL.
	 * @return array Exported widgets array.
	 */
	private function export_active_widgets( $site_url ) {
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		if ( empty( $sidebars_widgets ) ) {
			return array();
		}

		$exported_widgets = array();

		foreach ( $sidebars_widgets as $sidebar_id => $widgets ) {
			if ( 'wp_inactive_widgets' === $sidebar_id || empty( $widgets ) || ! is_array( $widgets ) ) {
				continue;
			}

			$exported_widgets[ $sidebar_id ] = array();

			foreach ( $widgets as $widget_instance_id ) {
				// Parse ID to find widget type and numeric index.
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				preg_match( '/-([0-9]+)$/', $widget_instance_id, $matches );
				$instance_index = isset( $matches[1] ) ? (int) $matches[1] : 0;

				if ( $instance_index ) {
					$widget_option = get_option( 'widget_' . $id_base );
					if ( isset( $widget_option[ $instance_index ] ) ) {
						$settings = $widget_option[ $instance_index ];

						// Replace local site URLs in widget settings.
						$cleaned_settings                                       = $this->sanitize_nested_urls( $settings, $site_url );
						$exported_widgets[ $sidebar_id ][ $widget_instance_id ] = $cleaned_settings;
					}
				}
			}
		}

		return $exported_widgets;
	}

	/**
	 * Render the developer page layout.
	 */
	public function render_exporter_page() {
		?>
		<div class="wrap avantex-exporter-wrap">
			<style>
				.avantex-exporter-wrap {
					max-width: 800px;
					margin: 40px auto 0;
					font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
				}
				.avantex-card {
					background: #111;
					border: 1px solid #222;
					border-radius: 12px;
					padding: 30px;
					box-shadow: 0 10px 30px rgba(0,0,0,0.3);
					color: #eee;
				}
				.avantex-title {
					font-size: 28px;
					font-weight: 700;
					background: linear-gradient(135deg, #ff8a00, #e52e71);
					-webkit-background-clip: text;
					-webkit-text-fill-color: transparent;
					margin-top: 0;
					margin-bottom: 10px;
				}
				.avantex-desc {
					font-size: 15px;
					color: #aaa;
					margin-bottom: 25px;
					line-height: 1.6;
				}
				.avantex-field-group {
					margin-bottom: 20px;
				}
				.avantex-label {
					display: block;
					font-weight: 600;
					margin-bottom: 8px;
					font-size: 14px;
					color: #ddd;
				}
				.avantex-select, .avantex-input {
					width: 100%;
					background: #222 !important;
					border: 1px solid #333 !important;
					color: #fff !important;
					border-radius: 6px !important;
					padding: 10px 12px !important;
					font-size: 14px !important;
					height: auto !important;
				}
				.avantex-btn {
					background: linear-gradient(135deg, #ff8a00, #e52e71) !important;
					border: none !important;
					color: #fff !important;
					font-weight: 600 !important;
					border-radius: 6px !important;
					padding: 12px 24px !important;
					cursor: pointer;
					transition: all 0.3s ease;
					font-size: 14px !important;
					display: inline-block;
					box-shadow: 0 4px 15px rgba(229, 46, 113, 0.4);
				}
				.avantex-btn:hover {
					transform: translateY(-2px);
					box-shadow: 0 6px 20px rgba(229, 46, 113, 0.6);
					opacity: 0.95;
				}
				.avantex-progress-box {
					margin-top: 25px;
					background: #181818;
					border: 1px solid #282828;
					border-radius: 8px;
					padding: 20px;
					display: none;
				}
				.progress-bar-container {
					height: 8px;
					background: #2c2c2c;
					border-radius: 4px;
					overflow: hidden;
					margin-bottom: 12px;
				}
				.progress-bar-fill {
					width: 0%;
					height: 100%;
					background: linear-gradient(90deg, #ff8a00, #e52e71);
					transition: width 0.4s ease;
				}
				.progress-status {
					font-size: 13px;
					color: #aaa;
				}
				.success-message {
					color: #2ecc71;
					font-weight: 600;
					margin-top: 15px;
					font-size: 14px;
					display: none;
				}
				.steps-list {
					margin: 0 0 20px 0;
					padding-left: 20px;
					font-size: 14px;
					color: #bbb;
					line-height: 1.8;
				}
			</style>

			<div class="avantex-card">
				<h1 class="avantex-title"><?php esc_html_e( 'Avantex Premium Demo Exporter', 'avantex' ); ?></h1>
				<p class="avantex-desc">
					<?php esc_html_e( 'Remap, sanitize, and bundle your active local WordPress database, Customizer, and active widgets into production-ready, CDN-aligned demo packs.', 'avantex' ); ?>
				</p>

				<div class="avantex-field-group">
					<h3 style="margin-top:0; color:#fff;"><?php esc_html_e( 'How to use:', 'avantex' ); ?></h3>
					<ol class="steps-list">
						<li><?php esc_html_e( 'Enter a unique name/slug for your new demo (e.g. avantex-business).', 'avantex' ); ?></li>
						<li><?php esc_html_e( 'Click Generate Pack. The exporter will automatically export your database, rewrite URLs, bundle Customizer/Widgets, and compress everything into a ZIP file!', 'avantex' ); ?></li>
						<li><?php esc_html_e( 'Upload the resulting [slug].zip file from the demo-content folder to your server.', 'avantex' ); ?></li>
					</ol>
				</div>

				<form id="avantex-exporter-form">
					<?php wp_nonce_field( 'avantex-exporter-nonce', 'security' ); ?>

					<div class="avantex-field-group">
						<label class="avantex-label" for="demo_slug"><?php esc_html_e( 'Demo Name / Slug (e.g. avantex-corporate)', 'avantex' ); ?></label>
						<input type="text" name="demo_slug" id="demo_slug" class="avantex-input" placeholder="avantex-corporate" required pattern="[a-z0-9\-]+" title="Only lowercase letters, numbers, and hyphens are allowed">
					</div>

					<button type="submit" class="avantex-btn" id="exporter-submit-btn">
						<?php esc_html_e( 'Generate & Save Demo Pack', 'avantex' ); ?>
					</button>
				</form>

				<div class="avantex-progress-box" id="exporter-progress-box">
					<div class="progress-bar-container">
						<div class="progress-bar-fill" id="exporter-bar-fill"></div>
					</div>
					<div class="progress-status" id="exporter-status"><?php esc_html_e( 'Initializing exporter...', 'avantex' ); ?></div>
					<div class="success-message" id="exporter-success-msg"></div>
				</div>
			</div>

			<div class="avantex-card" style="margin-top: 30px;">
				<h2 class="avantex-title" style="font-size:22px; background:linear-gradient(135deg, #00b09b, #96c93d); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom: 20px;">
					<?php esc_html_e( 'Manage Exported Demo Packages', 'avantex' ); ?>
				</h2>

				<div id="avantex-demo-list-wrapper">
					<?php $this->render_demo_list_table(); ?>
				</div>
			</div>
		</div>

		<script>
			jQuery(document).ready(function($) {
				function refreshDemoList() {
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action: 'avantex_get_demo_list_table',
							security: $('#security').val()
						},
						success: function(html) {
							$('#avantex-demo-list-wrapper').html(html);
						}
					});
				}

				$('#avantex-exporter-form').on('submit', function(e) {
					e.preventDefault();

					var form = $(this);
					var btn = $('#exporter-submit-btn');
					var progressBox = $('#exporter-progress-box');
					var barFill = $('#exporter-bar-fill');
					var statusText = $('#exporter-status');
					var successMsg = $('#exporter-success-msg');

					btn.prop('disabled', true).css('opacity', '0.7');
					progressBox.fadeIn();
					successMsg.hide();

					// Step 1
					barFill.css('width', '25%');
					statusText.text('Step 1/4: Harvesting and sanitizing Customizer theme mods...');

					setTimeout(function() {
						// Step 2
						barFill.css('width', '50%');
						statusText.text('Step 2/4: Rewriting and polishing WXR XML attachment paths...');

						setTimeout(function() {
							// Step 3
							barFill.css('width', '75%');
							statusText.text('Step 3/4: Bundling and formatting active widgets...');

							setTimeout(function() {
								// Step 4
								barFill.css('width', '90%');
								statusText.text('Step 4/4: Compressing assets into a ZIP package...');

								// Send AJAX
								$.ajax({
									url: ajaxurl,
									type: 'POST',
									data: {
										action: 'avantex_generate_demo_export',
										demo_slug: $('#demo_slug').val(),
										security: $('#security').val()
									},
									success: function(response) {
										if (response.success) {
											barFill.css('width', '100%');
											statusText.text('Compilation complete.');
											var html = '<p>' + response.data.message + '</p>';
											if (response.data.download_url) {
												html += '<p style="margin-top: 15px;"><a href="' + response.data.download_url + '" class="avantex-btn" style="text-decoration:none; background:linear-gradient(135deg, #00b09b, #96c93d) !important; box-shadow:0 4px 15px rgba(0, 176, 155, 0.4);" download><span class="dashicons dashicons-download" style="vertical-align: middle; margin-right: 5px;"></span>Download ZIP Package</a></p>';
											}
											successMsg.html(html).fadeIn();
											refreshDemoList();
										} else {
											statusText.text('Error: ' + response.data.message);
											barFill.css('background', '#e74c3c');
										}
										btn.prop('disabled', false).css('opacity', '1');
									},
									error: function() {
										statusText.text('AJAX server compilation failed.');
										barFill.css('background', '#e74c3c');
										btn.prop('disabled', false).css('opacity', '1');
									}
								});
							}, 800);
						}, 800);
					}, 800);
				});

				$(document).on('click', '.delete-demo-btn', function(e) {
					e.preventDefault();
					var btn = $(this);
					var slug = btn.data('slug');
					if (confirm('Are you sure you want to permanently delete the exported folder "' + slug + '"? This will free up server storage space.')) {
						btn.prop('disabled', true).text('Deleting...');
						$.ajax({
							url: ajaxurl,
							type: 'POST',
							data: {
								action: 'avantex_delete_exported_demo',
								demo_slug: slug,
								security: $('#security').val()
							},
							success: function(response) {
								if (response.success) {
									$('.demo-row-' + slug).fadeOut(400, function() {
										refreshDemoList();
									});
								} else {
									alert('Error: ' + response.data.message);
									btn.prop('disabled', false).html('<span class="dashicons dashicons-trash"></span>Delete');
								}
							}
						});
					}
				});
			});
		</script>
		<?php
	}

	/**
	 * Renders the table of exported demos.
	 */
	public function render_demo_list_table() {
		$demos = $this->get_exported_demos();
		if ( empty( $demos ) ) {
			?>
			<p style="color: #888; font-style: italic; margin: 0;"><?php esc_html_e( 'No exported demo packages found inside the /demo-content/ folder.', 'avantex' ); ?></p>
			<?php
			return;
		}
		?>
		<table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
			<thead>
				<tr style="border-bottom: 1px solid #333; color: #aaa;">
					<th style="padding: 12px 8px; font-weight: 600;"><?php esc_html_e( 'Demo Slug', 'avantex' ); ?></th>
					<th style="padding: 12px 8px; font-weight: 600;"><?php esc_html_e( 'ZIP Package', 'avantex' ); ?></th>
					<th style="padding: 12px 8px; font-weight: 600;"><?php esc_html_e( 'Size', 'avantex' ); ?></th>
					<th style="padding: 12px 8px; font-weight: 600; text-align: right;"><?php esc_html_e( 'Actions', 'avantex' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $demos as $demo ) : ?>
					<tr class="demo-row-<?php echo esc_attr( $demo['slug'] ); ?>" style="border-bottom: 1px solid #222; transition: background 0.3s;" onmouseover="this.style.background='#161616'" onmouseout="this.style.background='transparent'">
						<td style="padding: 12px 8px; font-weight: 600; color: #fff;"><?php echo esc_html( $demo['slug'] ); ?></td>
						<td style="padding: 12px 8px;">
							<?php if ( $demo['zip'] ) : ?>
								<a href="<?php echo esc_url( get_stylesheet_directory_uri() . '/demo-content/' . $demo['slug'] . '/' . $demo['zip'] ); ?>" style="color: #ff8a00; text-decoration: none;" download>
									<span class="dashicons dashicons-archive" style="vertical-align: middle; margin-right: 5px; font-size: 18px;"></span><?php echo esc_html( $demo['zip'] ); ?>
								</a>
							<?php else : ?>
								<span style="color: #666; font-style: italic;"><?php esc_html_e( 'No ZIP compiled', 'avantex' ); ?></span>
							<?php endif; ?>
						</td>
						<td style="padding: 12px 8px; color: #ccc;"><?php echo esc_html( $demo['size'] ); ?></td>
						<td style="padding: 12px 8px; text-align: right;">
							<?php if ( $demo['zip'] ) : ?>
								<a href="<?php echo esc_url( get_stylesheet_directory_uri() . '/demo-content/' . $demo['slug'] . '/' . $demo['zip'] ); ?>" class="button" style="background: linear-gradient(135deg, #00b09b, #96c93d); color: #fff; border: none; font-weight: 600; font-size: 12px; padding: 5px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; margin-right: 8px; line-height: 1.5; transition: all 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'" download>
									<span class="dashicons dashicons-download" style="font-size: 14px; width: 14px; height: 14px; vertical-align: middle; margin-right: 4px;"></span><?php esc_html_e( 'Download', 'avantex' ); ?>
								</a>
							<?php endif; ?>
							<button class="delete-demo-btn button" data-slug="<?php echo esc_attr( $demo['slug'] ); ?>" style="background: #c0392b; color: #fff; border: none; font-weight: 600; font-size: 12px; padding: 4px 10px; border-radius: 4px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#e74c3c'" onmouseout="this.style.background='#c0392b'">
								<span class="dashicons dashicons-trash" style="font-size: 14px; width: 14px; height: 14px; vertical-align: middle; margin-right: 4px;"></span><?php esc_html_e( 'Delete', 'avantex' ); ?>
							</button>

						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	}
}

new Reavantex_Demo_Exporter();
endif;

<?php
/**
 * HTML Template for Avantex Custom Demo Importer.
 *
 * @package avantex
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Google Font Outfit & Inter for high-end typography.
wp_enqueue_style( 'google-font-outfit-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;600;700;800&display=swap', array(), AVANTEX_COMPANION_VERSION );

$demo_uri = AVANTEX_COMPANION_PLUGIN_URL . "inc/avantex";
$demos    = array(
	array(
		'name'       => esc_html__( 'Avantex Business', 'avantex' ),
		'slug'       => 'avantex-business',
		'category'   => 'free',
		'preview'    => 'https://wpfrank.com/demo/avantex-business',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-business.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Market', 'avantex' ),
		'slug'       => 'avantex-market',
		'category'   => 'free',
		'preview'    => 'https://wpfrank.com/demo/avantex-market-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-market.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Pro', 'avantex' ),
		'slug'       => 'avantex-pro',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-pro',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-pro.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Automobile', 'avantex' ),
		'slug'       => 'avantex-automobile',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-automobile-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-automobile.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Yoga', 'avantex' ),
		'slug'       => 'avantex-yoga',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-yoga-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-yoga.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Metaverse', 'avantex' ),
		'slug'       => 'avantex-metaverse',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-metaverse-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-metaverse.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Medical', 'avantex' ),
		'slug'       => 'avantex-medical',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-medical-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-medical.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Construction', 'avantex' ),
		'slug'       => 'avantex-construction',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-construction-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-construction.webp',
	),
	array(
		'name'       => esc_html__( 'Avantex Education', 'avantex' ),
		'slug'       => 'avantex-education',
		'category'   => 'pro',
		'preview'    => 'https://wpfrank.com/demo/avantex-education-pro/',
		'screenshot' => $demo_uri . '/img/demo-screenshots/avantex-education.webp',
	),
);
?>

<div class="avantex-importer-wrap">
	<!-- Glassmorphism Header -->
	<header class="importer-header shadow-lg">
		<div class="header-content">
			<h1><?php esc_html_e( 'ReAvantex Demo Import', 'avantex' ); ?></h1>
			<p><?php esc_html_e( 'Transform your site instantly! Import our high-quality premium starter sites in one single click.', 'avantex' ); ?></p>
		</div>
	</header>

	<!-- Dashboard Control Panel -->
	<section class="importer-controls shadow-sm">
		<div class="filter-tabs">
			<button class="filter-tab active" data-filter="all"><?php esc_html_e( 'All Demos', 'avantex' ); ?></button>
			<button class="filter-tab" data-filter="free"><?php esc_html_e( 'Free Demos', 'avantex' ); ?></button>
			<button class="filter-tab" data-filter="pro"><?php esc_html_e( 'Pro Demos', 'avantex' ); ?></button>
		</div>

		<!-- Direct ZIP Upload Box -->
		<div class="manual-upload-box">
			<label class="manual-upload-btn btn" for="manual-zip-upload" style="background: #f4f6fa; color: var(--text-secondary); cursor: pointer; border-radius: 30px; font-weight: 600; padding: 10px 20px; font-size: 14px; display: inline-flex; align-items: center; gap: 8px;">
				<span class="dashicons dashicons-upload"></span> <?php esc_html_e( 'Upload Custom ZIP', 'avantex' ); ?>
			</label>
			<input type="file" id="manual-zip-upload" accept=".zip" style="display:none;" />
		</div>

		<div class="search-box">
			<span class="search-icon dashicons dashicons-search"></span>
			<input type="text" id="demo-search-input" placeholder="<?php esc_attr_e( 'Search starter sites...', 'avantex' ); ?>" autocomplete="off" />
		</div>
	</section>

	<!-- Dynamic Demo Grid -->
	<main class="demo-grid">
		<?php foreach ( $demos as $demo ) : ?>
			<article class="demo-card" data-slug="<?php echo esc_attr( $demo['slug'] ); ?>" data-category="<?php echo esc_attr( $demo['category'] ); ?>">
				<div class="card-screenshot">
					<img src="<?php echo esc_url( $demo['screenshot'] ); ?>" alt="<?php echo esc_attr( $demo['name'] ); ?>" loading="lazy" />
					<div class="card-overlay">
						<a href="<?php echo esc_url( $demo['preview'] ); ?>" class="btn btn-preview" target="_blank">
							<span class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'Live Preview', 'avantex' ); ?>
						</a>
					</div>
					<!-- Category Badge -->
					<span class="category-badge badge-<?php echo esc_attr( $demo['category'] ); ?>">
						<?php echo esc_html( ucfirst( $demo['category'] ) ); ?>
					</span>
				</div>
				<div class="card-body">
					<h3><?php echo esc_html( $demo['name'] ); ?></h3>
					<div class="card-footer-buttons">
						<button class="btn btn-import button-primary" data-slug="<?php echo esc_attr( $demo['slug'] ); ?>" data-name="<?php echo esc_attr( $demo['name'] ); ?>">
							<span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Import Demo', 'avantex' ); ?>
						</button>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</main>

	<!-- ============================== -->
	<!-- Theme Reset Section -->
	<!-- ============================== -->
	<?php
	$imported_slugs = class_exists( 'Reavantex_Theme_Reset' ) ? Reavantex_Theme_Reset::get_imported_demo_slugs() : array();
	$total_counts   = class_exists( 'Reavantex_Theme_Reset' ) ? Reavantex_Theme_Reset::count_tagged_content() : array(
		'posts'       => 0,
		'pages'       => 0,
		'attachments' => 0,
		'nav_menus'   => 0,
		'total'       => 0,
	);
	$has_demo_data  = ! empty( $total_counts['total'] ) && $total_counts['total'] > 0;
	?>
	<section class="theme-reset-section">
		<div class="reset-card <?php echo $has_demo_data ? '' : 'reset-card--empty'; ?>">
			<div class="reset-card-header">
				<div class="reset-icon-wrap">
					<span class="dashicons dashicons-image-rotate"></span>
				</div>
				<div class="reset-card-text">
					<h3><?php esc_html_e( 'Complete Theme Reset', 'avantex' ); ?></h3>
					<p><?php esc_html_e( 'Remove all demo-imported content, media, menus, customizer settings, and widgets. Returns the theme to its fresh-install state. Your own posts, pages, and media that were NOT imported by the theme will be preserved.', 'avantex' ); ?></p>
				</div>
			</div>

			<?php if ( $has_demo_data ) : ?>
				<div class="reset-stats-bar">
					<div class="reset-stat">
						<span class="reset-stat-count"><?php echo esc_html( $total_counts['posts'] ); ?></span>
						<span class="reset-stat-label"><?php esc_html_e( 'Posts', 'avantex' ); ?></span>
					</div>
					<div class="reset-stat">
						<span class="reset-stat-count"><?php echo esc_html( $total_counts['pages'] ); ?></span>
						<span class="reset-stat-label"><?php esc_html_e( 'Pages', 'avantex' ); ?></span>
					</div>
					<div class="reset-stat">
						<span class="reset-stat-count"><?php echo esc_html( $total_counts['attachments'] ); ?></span>
						<span class="reset-stat-label"><?php esc_html_e( 'Media', 'avantex' ); ?></span>
					</div>
					<div class="reset-stat">
						<span class="reset-stat-count"><?php echo esc_html( $total_counts['nav_menus'] ); ?></span>
						<span class="reset-stat-label"><?php esc_html_e( 'Menus', 'avantex' ); ?></span>
					</div>
					<div class="reset-stat reset-stat--total">
						<span class="reset-stat-count"><?php echo esc_html( $total_counts['total'] ); ?></span>
						<span class="reset-stat-label"><?php esc_html_e( 'Total Items', 'avantex' ); ?></span>
					</div>
				</div>

				<div class="reset-controls">
					<?php if ( count( $imported_slugs ) > 1 ) : ?>
						<div class="reset-scope-selector">
							<label for="reset-demo-scope"><?php esc_html_e( 'Reset scope:', 'avantex' ); ?></label>
							<select id="reset-demo-scope">
								<option value=""><?php esc_html_e( '— All Demos (Full Reset) —', 'avantex' ); ?></option>
								<?php foreach ( $imported_slugs as $slug ) : ?>
									<option value="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( ucwords( str_replace( '-', ' ', $slug ) ) ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>

					<button id="avantex-reset-btn" class="btn btn-reset">
						<span class="dashicons dashicons-warning"></span>
						<?php esc_html_e( 'Reset Theme to Default', 'avantex' ); ?>
					</button>
				</div>
			<?php else : ?>
				<div class="reset-empty-state">
					<span class="dashicons dashicons-yes-alt"></span>
					<p><?php esc_html_e( 'Your theme is already in its default state. No demo content has been imported.', 'avantex' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>
</div>

<!-- Immersive Dark Glassmorphism Progress Modal Overlay -->
<div id="avantex-import-overlay" class="avantex-import-overlay" style="display:none;">
	<div class="avantex-import-modal shadow-lg">
		<div class="modal-header">
			<h2><?php esc_html_e( 'Importing Starter Site', 'avantex' ); ?></h2>
			<h3><span id="modal-demo-name"></span></h3>
			<p><?php esc_html_e( 'Please keep this window open and do not refresh the page. We are preparing your design step-by-step.', 'avantex' ); ?></p>
		</div>

		<!-- Progress Bar Wrapper -->
		<div class="modal-progress-container">
			<div class="progress-bar-wrapper">
				<div id="progress-bar-fill" class="progress-bar-fill" style="width: 0%;"></div>
			</div>
			<span id="progress-percent" class="progress-percent">0%</span>
		</div>

		<!-- Task Steps List -->
		<div class="modal-steps">
			<div class="import-step" id="step-plugins">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Installing and activating required plugins...', 'avantex' ); ?></span>
			</div>
			<div class="import-step" id="step-download">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Downloading and deploying local demo package...', 'avantex' ); ?></span>
			</div>
			<div class="import-step" id="step-xml">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Importing content and sideloading physical media locally...', 'avantex' ); ?></span>
			</div>
			<div class="import-step" id="step-customizer">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Configuring Customizer settings and color architecture...', 'avantex' ); ?></span>
			</div>
			<div class="import-step" id="step-widgets">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Mapping widgets and sidebar columns...', 'avantex' ); ?></span>
			</div>
			<div class="import-step" id="step-finalize">
				<span class="step-status dashicons dashicons-ellipsis"></span>
				<span class="step-label"><?php esc_html_e( 'Finalizing dynamic menu and static front page allocations...', 'avantex' ); ?></span>
			</div>
		</div>

		<!-- Finished/Success Screen -->
		<div id="modal-success-state" class="modal-success-state" style="display:none;">
			<div class="success-icon-wrap">
				<span class="success-icon dashicons dashicons-yes-alt"></span>
			</div>
			<h3><?php esc_html_e( 'Congratulations!', 'avantex' ); ?></h3>
			<p><?php esc_html_e( 'Your brand-new starter site is fully loaded and ready to explore.', 'avantex' ); ?></p>
			<div class="success-buttons">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="btn btn-view-site">
					<span class="dashicons dashicons-external"></span> <?php esc_html_e( 'View Website', 'avantex' ); ?>
				</a>
				<button id="btn-close-modal" class="btn btn-close"><?php esc_html_e( 'Dismiss', 'avantex' ); ?></button>
			</div>
		</div>
	</div>
</div>

<!-- ============================== -->
<!-- Pre-Import Options Modal -->
<!-- ============================== -->
<div id="avantex-pre-import-overlay" class="avantex-import-overlay" style="display:none;">
	<div class="avantex-import-modal shadow-lg">
		<div class="modal-header">
			<div class="reset-modal-warning-icon" style="color: #0073aa; background: #e5f5fa; display: inline-flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; margin-bottom: 20px;">
				<span class="dashicons dashicons-info" style="font-size: 32px; width: 32px; height: 32px;"></span>
			</div>
			<h2><?php esc_html_e( 'Existing Demo Content Detected', 'avantex' ); ?></h2>
			<p id="pre-import-desc"></p>
		</div>
		<div class="pre-import-buttons" style="display: flex; flex-direction: column; gap: 15px; margin-top: 20px;">
			<button id="btn-pre-import-reset" class="btn button-primary" style="padding: 12px; font-size: 15px;">
				<span class="dashicons dashicons-update"></span> <?php esc_html_e( 'Reset first then continue import', 'avantex' ); ?>
			</button>
			<button id="btn-pre-import-continue" class="btn" style="padding: 12px; font-size: 15px; background: #f0f0f1; color: #3c434a;">
				<span class="dashicons dashicons-download"></span> <?php esc_html_e( 'Import on top of existing', 'avantex' ); ?>
			</button>
			<button id="btn-pre-import-cancel" class="btn btn-close" style="padding: 12px; font-size: 15px;">
				<?php esc_html_e( 'Cancel', 'avantex' ); ?>
			</button>
		</div>
	</div>
</div>

<!-- ============================== -->
<!-- Theme Reset Confirmation Modal -->
<!-- ============================== -->
<div id="avantex-reset-overlay" class="avantex-import-overlay" style="display:none;">
	<div class="avantex-import-modal shadow-lg reset-modal">
		<!-- Confirmation Screen -->
		<div id="reset-confirm-screen">
			<div class="modal-header reset-header">
				<div class="reset-modal-warning-icon">
					<span class="dashicons dashicons-warning"></span>
				</div>
				<h2><?php esc_html_e( 'Are you absolutely sure?', 'avantex' ); ?></h2>
				<p class="reset-modal-desc"><?php esc_html_e( 'This will permanently delete all demo-imported content, media files, customizer settings, menus, and widgets. A backup manifest will be saved before deletion.', 'avantex' ); ?></p>
				<p class="reset-modal-scope" id="reset-scope-label"></p>
			</div>

			<div class="reset-confirm-input">
				<label for="reset-confirm-text"><?php esc_html_e( 'Type RESET to confirm:', 'avantex' ); ?></label>
				<input type="text" id="reset-confirm-text" autocomplete="off" spellcheck="false" />
			</div>

			<div class="reset-modal-buttons">
				<button id="reset-confirm-btn" class="btn btn-danger" disabled>
					<span class="dashicons dashicons-trash"></span>
					<?php esc_html_e( 'Yes, Reset Everything', 'avantex' ); ?>
				</button>
				<button id="reset-cancel-btn" class="btn btn-close">
					<?php esc_html_e( 'Cancel', 'avantex' ); ?>
				</button>
			</div>
		</div>

		<!-- Reset Progress Screen -->
		<div id="reset-progress-screen" style="display:none;">
			<div class="modal-header">
				<h2><?php esc_html_e( 'Resetting Theme', 'avantex' ); ?></h2>
				<p><?php esc_html_e( 'Please wait while we safely remove demo content and restore defaults...', 'avantex' ); ?></p>
			</div>

			<div class="modal-progress-container">
				<div class="progress-bar-wrapper">
					<div id="reset-progress-fill" class="progress-bar-fill reset-progress-bar" style="width: 0%;"></div>
				</div>
				<span id="reset-progress-percent" class="progress-percent">0%</span>
			</div>

			<div class="modal-steps">
				<div class="import-step" id="reset-step-backup">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Creating backup manifest for recovery...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-posts">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Removing demo posts and pages...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-attachments">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Deleting demo media files from server...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-menus">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Removing demo navigation menus...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-terms">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Cleaning up demo taxonomy terms...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-customizer">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Resetting Customizer settings to defaults...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-widgets">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Clearing widget configurations...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-options">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Restoring default reading settings...', 'avantex' ); ?></span>
				</div>
				<div class="import-step" id="reset-step-cleanup">
					<span class="step-status dashicons dashicons-ellipsis"></span>
					<span class="step-label"><?php esc_html_e( 'Final cleanup and cache flush...', 'avantex' ); ?></span>
				</div>
			</div>

			<!-- Reset Success Screen -->
			<div id="reset-success-state" class="modal-success-state" style="display:none;">
				<div class="success-icon-wrap">
					<span class="success-icon dashicons dashicons-yes-alt"></span>
				</div>
				<h3><?php esc_html_e( 'Theme Reset Complete!', 'avantex' ); ?></h3>
				<p><?php esc_html_e( 'Your theme has been restored to its default state. All demo content has been safely removed.', 'avantex' ); ?></p>
				<p class="reset-backup-note" id="reset-backup-note"></p>
				<div class="success-buttons">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="btn btn-view-site">
						<span class="dashicons dashicons-external"></span> <?php esc_html_e( 'View Website', 'avantex' ); ?>
					</a>
					<button id="reset-done-btn" class="btn btn-close" onclick="location.reload();"><?php esc_html_e( 'Done', 'avantex' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

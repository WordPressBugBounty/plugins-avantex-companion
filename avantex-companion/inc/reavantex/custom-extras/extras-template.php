<?php
/**
 * Extras page template — renders the plugin and theme cards.
 *
 * @package avantex
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="avantex-extras-wrap">

	<!-- Full-page loader — visible until content finishes rendering -->
	<div id="avantex-extras-loader" class="avantex-extras-loader" role="status" aria-label="<?php esc_attr_e( 'Loading', 'avantex' ); ?>">
		<div class="avantex-extras-loader__inner">
			<div class="avantex-extras-loader__spinner"></div>
			<h2 class="avantex-extras-loader__title"><?php esc_html_e( 'Fetching Our Dedicated Work from WordPress', 'avantex' ); ?></h2>
			<p class="avantex-extras-loader__text"><?php esc_html_e( 'Loading plugin & theme data — this may take a moment, please wait…', 'avantex' ); ?></p>
		</div>
	</div>

	<!-- Page header -->
	<div class="avantex-extras-header">
		<h1><?php esc_html_e( 'ReAvantex Extras', 'avantex' ); ?></h1>
		<p class="avantex-extras-subtitle"><?php esc_html_e( 'Thanks for choosing ReAvantex. Explore our recommended plugins and themes!', 'avantex' ); ?></p>
	</div>

	<!-- Notification area for AJAX feedback -->
	<div id="avantex-extras-notice" class="avantex-extras-notice" role="alert" aria-live="polite" hidden></div>

	<!-- Tabs navigation -->
	<div class="avantex-extras-tabs-nav">
		<button type="button" class="avantex-extras-tab-btn avantex-extras-tab-btn--active" data-target="avantex-extras-plugins">
			<span class="dashicons dashicons-admin-plugins"></span>
			<?php esc_html_e( 'Plugins', 'avantex' ); ?>
		</button>
		<button type="button" class="avantex-extras-tab-btn" data-target="avantex-extras-themes">
			<span class="dashicons dashicons-admin-appearance"></span>
			<?php esc_html_e( 'Themes', 'avantex' ); ?>
		</button>
	</div>

	<!-- ──────────── PLUGINS ──────────── -->
	<div id="avantex-extras-plugins" class="avantex-extras-section avantex-extras-section--active">
		<h2 class="avantex-extras-section-title" style="display:none;">
			<span class="dashicons dashicons-admin-plugins"></span>
			<?php esc_html_e( 'Recommended Plugins', 'avantex' ); ?>
		</h2>

		<div class="avantex-extras-grid">
			<!-- Populated via AJAX -->
		</div>
	</div>

	<!-- ──────────── THEMES ──────────── -->
	<div id="avantex-extras-themes" class="avantex-extras-section">
		<h2 class="avantex-extras-section-title" style="display:none;">
			<span class="dashicons dashicons-admin-appearance"></span>
			<?php esc_html_e( 'Recommended Themes', 'avantex' ); ?>
		</h2>

		<div class="avantex-extras-grid">
			<!-- Populated via AJAX -->
		</div>
	</div>

</div>

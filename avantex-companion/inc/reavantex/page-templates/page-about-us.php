<?php
/**
 * Template Name: Avantex About-US
 *
 * @package avantex
 */

get_header();
?>
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<!-- About Template Start -->
	<?php
	$about_container_class = get_theme_mod( 'avantex-template-aboutus-container', 'container' );
	$about_show_main       = get_theme_mod( 'avantex-aboutpage-show-main', 1 );

	$about_image_default    = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'about.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/about.webp' : get_stylesheet_directory_uri() . '/assets/images/about.webp' );
	$about_image_val        = get_theme_mod( 'avantex-aboutpage-image', $about_image_default );
	$about_image            = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( $about_image_val ) : $about_image_val;



	$avantex_about_subtitle = get_theme_mod( 'avantex-aboutpage-subtitle', 'About Our Agency' );
	$avantex_about_title    = get_theme_mod( 'avantex-aboutpage-title', 'We are passionate developers creating outstanding digital experiences' );
	$avantex_about_info     = get_theme_mod( 'avantex-aboutpage-info', '<p>We specialize in crafting professional, speed-optimized, and beautiful themes and plugins. Our dedication is to provide top-tier web design solutions that help enterprises grow, scaling your brand and expanding your global footprint. We write clean code, adhere to standard web architectures, and design cohesive digital systems.</p>' );

	// Tabs Settings.
	$about_show_tabs      = get_theme_mod( 'avantex-aboutpage-show-tabs', 1 );
	$about_tabs_container = get_theme_mod( 'avantex-aboutpage-tabs-container', 'container' );

	// Values Settings.
	$about_show_values = get_theme_mod( 'avantex-aboutpage-show-values', 1 );
	$values_subtitle   = get_theme_mod( 'avantex-aboutpage-values-subtitle', 'Why Choose Us' );
	$values_title      = get_theme_mod( 'avantex-aboutpage-values-title', 'Values That Define Our Journey' );

	// Timeline Settings.
	$about_show_timeline = get_theme_mod( 'avantex-aboutpage-show-timeline', 1 );
	$timeline_subtitle   = get_theme_mod( 'avantex-aboutpage-timeline-subtitle', 'Our Journey' );
	$timeline_title      = get_theme_mod( 'avantex-aboutpage-timeline-title', 'Our Growth Timeline' );

	// CTA Settings.
	$about_show_cta = get_theme_mod( 'avantex-aboutpage-show-cta', 1 );
	$cta_tagline    = get_theme_mod( 'avantex-aboutpage-cta-tagline', 'Start Your Project' );
	$cta_title      = get_theme_mod( 'avantex-aboutpage-cta-title', 'Ready to collaborate on something magical?' );
	$cta_desc       = get_theme_mod( 'avantex-aboutpage-cta-desc', 'Whether you are launching a new startup, rebuilding an online shopping store, or upgrading your corporate presence, we have the expertise to make your digital presence thrive.' );
	$cta_btn_text   = get_theme_mod( 'avantex-aboutpage-cta-btn-text', 'Get In Touch' );
	$cta_btn_link   = get_theme_mod( 'avantex-aboutpage-cta-btn-link', '' );
	if ( empty( $cta_btn_link ) ) {
		$cta_btn_link = home_url( '/contact/' );
	}

	// Content Area Settings.
	$about_show_content = get_theme_mod( 'avantex-aboutpage-show-content', 1 );
	?>
	<div id="about-template" class="about-template-wrapper py-5">
		
		<!-- Redesigned About Section (Clean Single Image layout) -->
		<?php if ( 1 === intval( $about_show_main ) ) { ?>
			<section id="tmpl-about-section" class="about tmpl-about-section mb-5 py-5">
				<div class="<?php echo esc_attr( $about_container_class ); ?> sr-about">
					<div class="row align-items-center">
						
						<!-- Left Side: Single Image Showcase with clean Polaroid-style Frame -->
						<div class="col-xl-6 col-lg-6 col-md-12 col-xs-12 wow fadeInLeft animated" data-wow-delay="300ms">
							<div class="about-modern-image-wrapper">
								<div class="about-modern-image-main" data-title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
									<img src="<?php echo esc_url_raw( $about_image ); ?>" alt="<?php echo esc_attr( $avantex_about_title ); ?>">
								</div>
							</div>
						</div>

						<!-- Right Side: Native typography layout + Social icons -->
						<div class="col-xl-6 col-lg-6 col-md-12 col-xs-12 wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="tmpl-about-module">
								<p class="section-subtitle"><?php echo esc_html( $avantex_about_subtitle ); ?></p>
								<h2 class="title"><b><?php echo esc_html( $avantex_about_title ); ?></b></h2>
								<div class="mb-4 about-info-text"><?php echo wp_kses_post( $avantex_about_info ); ?></div>
							</div>

							<!-- Social Media Integration -->
							<?php if ( 1 === intval( get_theme_mod( 'avantex-aboutpage-show-social', 1 ) ) ) { ?>
								<div class="about-social-icons mt-4">
									<?php
										$topbar_default        = defined( 'REAVANTEX_TOPBAR_DEFAULTS' ) ? REAVANTEX_TOPBAR_DEFAULTS : '[]';
										$topbar_social_callout = get_theme_mod( 'avantex-topbar-social-repeater', $topbar_default );
										$topbar_social_decoded = json_decode( $topbar_social_callout );
									if ( $topbar_social_decoded ) {
										foreach ( $topbar_social_decoded as $topbar_member ) {
											if ( ! empty( $topbar_member->social_repeater ) ) {
												$topbar_social_repeater = json_decode( html_entity_decode( $topbar_member->social_repeater ) );
												foreach ( $topbar_social_repeater as $iconsdata ) {
													$icons_link = ! empty( $iconsdata->link ) ? $iconsdata->link : '#';
													$icons_data = $iconsdata->icon;
													?>
														<a href="<?php echo esc_url( $icons_link ); ?>" target="_blank" class="<?php echo esc_attr( $icons_data ); ?>"></a>
														<?php
												}
											}
										}
									}
									?>
								</div>
							<?php } ?>
						</div>
					</div>

					<!-- Custom features list in its own container row below left and right column -->
					<?php
					$features_default  = defined( 'REAVANTEX_TEMPLATE_ABOUTUS_FEATURES_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_FEATURES_DEFAULTS : '[]';
					$features_repeater = get_theme_mod( 'avantex-aboutpage-features-repeater', $features_default );
					if ( ! empty( $features_repeater ) ) {
						$decoded_features = json_decode( $features_repeater );
						if ( is_array( $decoded_features ) && ! empty( $decoded_features ) ) {
							$decoded_features = apply_filters( 'reavantex_pro_about_features', $decoded_features );
							$feat_max         = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 4;
							?>
							<div class="row mt-5 justify-content-center">
								<div class="col-lg-12">
									<div class="about-modern-features justify-content-center">
										<?php
										$feat_idx = 0;
										foreach ( $decoded_features as $item ) {
											if ( $feat_idx >= $feat_max ) {
												break;
											}
											$icon          = ! empty( $item->icon_value ) ? $item->icon_value : 'fas fa-check-circle';
											$feature_title = ! empty( $item->title ) ? $item->title : '';
											$desc          = ! empty( $item->text ) ? $item->text : '';
											?>
											<div class="feature-item mb-3">
												<div class="feature-icon-wrapper about-feature-icon">
													<i class="<?php echo esc_attr( $icon ); ?>"></i>
												</div>
												<div class="feature-text">
													<h5 class="about-feature-title"><?php echo esc_html( $feature_title ); ?></h5>
													<p class="about-feature-desc"><?php echo esc_html( $desc ); ?></p>
												</div>
											</div>
											<?php
											++$feat_idx;
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
				</div>
			</section>
		<?php } ?>

		<!-- Interactive Core Tabs Section -->
		<?php
		if ( 1 === intval( $about_show_tabs ) ) {
			$tabs_default  = defined( 'REAVANTEX_TEMPLATE_ABOUTUS_TABS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_TABS_DEFAULTS : '[]';
			$tabs_repeater = get_theme_mod( 'avantex-aboutpage-tabs-repeater', $tabs_default );

			if ( ! empty( $tabs_repeater ) ) {
				$decoded_tabs = json_decode( $tabs_repeater );
				if ( is_array( $decoded_tabs ) && ! empty( $decoded_tabs ) ) {
					$decoded_tabs = apply_filters( 'reavantex_pro_about_tabs', $decoded_tabs );
					$tabs_max     = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 3;
					?>
					<section class="about-tabs-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
						<div class="<?php echo esc_attr( $about_tabs_container ); ?> sr-about-tabs">
							<div class="row justify-content-center">
								<div class="col-lg-12">
									<div class="tabs-wrapper custom-about-tabs-card">
										<ul class="tabs-nav" id="about-tabs">
											<?php
											$index = 0;
											foreach ( $decoded_tabs as $item ) {
												if ( $index >= $tabs_max ) {
													break;
												}
												$icon         = ! empty( $item->icon_value ) ? $item->icon_value : 'fas fa-check';
												$tab_title    = ! empty( $item->title ) ? $item->title : '';
												$active_class = ( 0 === $index ) ? 'active' : '';
												?>
												<li class="tab-item <?php echo esc_attr( $active_class ); ?>" data-tab="tab-item-<?php echo esc_attr( $index ); ?>">
													<i class="<?php echo esc_attr( $icon ); ?>"></i>
													<span><?php echo esc_html( $tab_title ); ?></span>
												</li>
												<?php
												++$index;
											}
											?>
										</ul>
										<div class="tabs-content p-5">
											<?php
											$index = 0;
											foreach ( $decoded_tabs as $item ) {
												if ( $index >= $tabs_max ) {
													break;
												}
												$subtitle     = ! empty( $item->subtitle ) ? $item->subtitle : '';
												$desc         = ! empty( $item->text ) ? $item->text : '';
												$active_class = ( 0 === $index ) ? 'active' : '';
												?>
												<div class="tab-pane <?php echo esc_attr( $active_class ); ?>" id="tab-item-<?php echo esc_attr( $index ); ?>">
													<?php if ( ! empty( $subtitle ) ) { ?>
														<h3 class="mb-3 about-tab-title"><?php echo esc_html( $subtitle ); ?></h3>
													<?php } ?>
													<p class="about-tab-desc"><?php echo wp_kses_post( $desc ); ?></p>
												</div>
												<?php
												++$index;
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
					<?php
				}
			}
		}
		?>

		<!-- Core Values Grid Section -->
		<?php if ( 1 === intval( $about_show_values ) ) { ?>
			<section class="about-values-section py-5 my-5 wow fadeInUp animated" data-wow-delay="300ms">
				<div class="<?php echo esc_attr( $about_container_class ); ?>">
					
					<!-- Native Section Header & Divider -->
					<div class="section-header text-center mb-5">
						<p class="section-subtitle about-section-subtitle"><?php echo esc_html( $values_subtitle ); ?></p>
						<h2 class="section-title"><b><?php echo esc_html( $values_title ); ?></b></h2>
						<div class="divider-line"></div>
					</div>

					<div class="row">
						<?php
						$values_default  = defined( 'REAVANTEX_TEMPLATE_ABOUTUS_VALUES_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_VALUES_DEFAULTS : '[]';
						$values_repeater = get_theme_mod( 'avantex-aboutpage-values-repeater', $values_default );
						if ( ! empty( $values_repeater ) ) {
							$decoded_values = json_decode( $values_repeater );
							if ( is_array( $decoded_values ) ) {
								$decoded_values = apply_filters( 'reavantex_pro_about_values', $decoded_values );
								$val_max        = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 3;
								$val_idx        = 0;
								foreach ( $decoded_values as $item ) {
									if ( $val_idx >= $val_max ) {
										break;
									}
									$icon        = ! empty( $item->icon_value ) ? $item->icon_value : 'fas fa-lightbulb';
									$value_title = ! empty( $item->title ) ? $item->title : '';
									$desc        = ! empty( $item->text ) ? $item->text : '';
									?>
									<div class="col-lg-4 col-md-6 mb-4">
										<div class="value-card custom-about-value-card p-5 text-center">
											<div class="value-icon-holder mb-4 about-value-icon">
												<i class="<?php echo esc_attr( $icon ); ?>"></i>
											</div>
											<h4 class="about-value-title"><?php echo esc_html( $value_title ); ?></h4>
											<p class="about-value-desc"><?php echo esc_html( $desc ); ?></p>
										</div>
									</div>
									<?php
									++$val_idx;
								}
							}
						}
						?>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- Company Timeline/History Section -->
		<?php if ( 1 === intval( $about_show_timeline ) ) { ?>
			<section class="about-timeline-section py-5 my-5 wow fadeInUp animated" data-wow-delay="400ms">
				<div class="<?php echo esc_attr( $about_container_class ); ?>">
					
					<!-- Native Section Header & Divider -->
					<div class="section-header text-center mb-5">
						<p class="section-subtitle about-section-subtitle"><?php echo esc_html( $timeline_subtitle ); ?></p>
						<h2 class="section-title"><b><?php echo esc_html( $timeline_title ); ?></b></h2>
						<div class="divider-line"></div>
					</div>

					<div class="timeline-container">
						<div class="timeline-line"></div>
						
						<?php
						$timeline_default  = defined( 'REAVANTEX_TEMPLATE_ABOUTUS_TIMELINE_DEFAULTS' ) ? REAVANTEX_TEMPLATE_ABOUTUS_TIMELINE_DEFAULTS : '[]';
						$timeline_repeater = get_theme_mod( 'avantex-aboutpage-timeline-repeater', $timeline_default );

						if ( ! empty( $timeline_repeater ) ) {
							$decoded_timeline = json_decode( $timeline_repeater );
							if ( is_array( $decoded_timeline ) ) {
								$decoded_timeline = apply_filters( 'reavantex_pro_about_timeline', $decoded_timeline );
								$time_max         = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 3;
								$index            = 0;
								foreach ( $decoded_timeline as $item ) {
									if ( $index >= $time_max ) {
										break;
									}
									$timeline_year  = ! empty( $item->subtitle ) ? $item->subtitle : ''; // Subtitle is used for Year/Date.
									$timeline_title = ! empty( $item->title ) ? $item->title : '';
									$desc           = ! empty( $item->text ) ? $item->text : '';
									$item_class     = ( 0 === $index % 2 ) ? 'timeline-left' : 'timeline-right';
									?>
									<div class="timeline-item <?php echo esc_attr( $item_class ); ?>">
										<div class="timeline-circle"></div>
										<div class="timeline-content-card custom-about-timeline-card p-4">
											<span class="timeline-year"><?php echo esc_html( $timeline_year ); ?></span>
											<h4 class="about-timeline-title"><?php echo esc_html( $timeline_title ); ?></h4>
											<p class="about-timeline-desc"><?php echo esc_html( $desc ); ?></p>
										</div>
									</div>
									<?php
									++$index;
								}
							}
						}
						?>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- Meet Our Team Section -->
		<?php if ( 1 === intval( get_theme_mod( 'avantex-aboutpage-show-team', 1 ) ) ) { ?>
			<div class="about-team-section-wrapper">
				<?php get_template_part( 'avantex-index/index', 'team' ); ?>
			</div>
		<?php } ?>

		<!-- Client Testimonials Section -->
		<?php if ( 1 === intval( get_theme_mod( 'avantex-aboutpage-show-testimonials', 1 ) ) ) { ?>
			<div class="about-testimonials-section-wrapper">
				<?php get_template_part( 'avantex-index/index', 'testimonial' ); ?>
			</div>
		<?php } ?>

		<!-- Call to Action Section -->
		<?php if ( 1 === intval( $about_show_cta ) ) { ?>
			<section class="about-cta-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
				<div class="<?php echo esc_attr( $about_container_class ); ?>">
					<div class="row justify-content-center text-center">
						<div class="col-lg-10">
							<div class="about-cta-box custom-about-cta-card p-5 shadow">
								<span class="cta-tagline about-cta-tagline text-uppercase font-weight-bold"><?php echo esc_html( $cta_tagline ); ?></span>
								<h2 class="cta-title my-2 about-cta-heading"><b><?php echo esc_html( $cta_title ); ?></b></h2>
								<p class="cta-desc mb-5 mx-auto about-cta-text"><?php echo esc_html( $cta_desc ); ?></p>
								<div class="cta-btn-wrapper">
									<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn about-cta-btn" <?php echo empty( $cta_btn_text ) ? 'style="display: none;"' : ''; ?>><?php echo esc_html( $cta_btn_text ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- WordPress Page Content Area -->
		<?php if ( 1 === intval( $about_show_content ) ) { ?>
			<div class="about-user-content-wrapper my-5 pt-3">
				<div class="<?php echo esc_attr( $about_container_class ); ?>">
					<div class="row justify-content-center">
						<div class="col-lg-10">
							<?php
							if ( have_posts() ) :
								while ( have_posts() ) :
									the_post();
									if ( get_the_content() ) : // Check if content exists.
										?>
										<article id="post-<?php the_ID(); ?>" <?php post_class( 'custom-about-content-card p-5 border' ); ?>>
											<div class="entry-content">
												<?php the_content(); ?>
											</div>
										</article>
										<?php
									endif;
								endwhile;
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<!-- End Page Content -->

	</div>
	<!-- About Template End -->

	<!-- Simple jQuery-based Tabs Switcher script -->
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#about-tabs .tab-item').on('click', function() {
				var targetTab = $(this).attr('data-tab');
				
				// Remove active class from tabs
				$('#about-tabs .tab-item').removeClass('active');
				$(this).addClass('active');
				
				// Hide other panes and show target
				$('.tabs-content .tab-pane').removeClass('active');
				$('#' + targetTab).addClass('active');
			});
		});
	</script>
<?php
get_footer();

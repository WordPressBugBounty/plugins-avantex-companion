<?php
/**
 * Template Name: Avantex Services
 *
 * @package avantex
 */

get_header();

// Fetch settings.
$services_container_class = get_theme_mod( 'avantex-template-services-container', 'container' );
$services_show_hero       = get_theme_mod( 'avantex-servicespage-show-hero', 1 );
$services_show_grid       = get_theme_mod( 'avantex-servicespage-show-grid', 1 );
$services_show_details    = get_theme_mod( 'avantex-servicespage-show-details', 1 );
$services_show_process    = get_theme_mod( 'avantex-servicespage-show-process', 1 );
$services_show_cta        = get_theme_mod( 'avantex-servicespage-show-cta', 1 );
$services_show_content    = get_theme_mod( 'avantex-servicespage-show-content', 1 );

$service_hero_default = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'service/service1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/service/service1.webp' : get_stylesheet_directory_uri() . '/assets/images/service/service1.webp' );
$hero_image_val       = get_theme_mod( 'avantex-servicespage-hero-image', $service_hero_default );
$hero_image           = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( $hero_image_val ) : $hero_image_val;


$hero_subtitle = get_theme_mod( 'avantex-servicespage-hero-subtitle', __( 'What We Do', 'avantex' ) );
$hero_title    = get_theme_mod( 'avantex-servicespage-hero-title', __( 'Professional Services Built For Growth', 'avantex' ) );
$hero_desc     = get_theme_mod( 'avantex-servicespage-hero-desc', __( 'We combine strategic thinking with technical expertise to deliver digital solutions that drive real business results. Our team of specialists works closely with you to understand your unique challenges and craft tailored solutions.', 'avantex' ) );

$details_subtitle = get_theme_mod( 'avantex-servicespage-details-subtitle', __( 'In-Depth', 'avantex' ) );
$details_title    = get_theme_mod( 'avantex-servicespage-details-title', __( 'Services In Detail', 'avantex' ) );
$details_default  = defined( 'REAVANTEX_TEMPLATE_SERVICES_DETAILS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_SERVICES_DETAILS_DEFAULTS : '[]';
$details_repeater = get_theme_mod( 'avantex-servicespage-details-repeater', $details_default );

$process_subtitle = get_theme_mod( 'avantex-servicespage-process-subtitle', __( 'How It Works', 'avantex' ) );
$process_title    = get_theme_mod( 'avantex-servicespage-process-title', __( 'Our Working Process', 'avantex' ) );
$process_default  = defined( 'REAVANTEX_TEMPLATE_SERVICES_PROCESS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_SERVICES_PROCESS_DEFAULTS : '[]';
$process_repeater = get_theme_mod( 'avantex-servicespage-process-repeater', $process_default );


$cta_tagline  = get_theme_mod( 'avantex-servicespage-cta-tagline', __( 'Start Your Project', 'avantex' ) );
$cta_title    = get_theme_mod( 'avantex-servicespage-cta-title', __( 'Ready to get started?', 'avantex' ) );
$cta_desc     = get_theme_mod( 'avantex-servicespage-cta-desc', __( 'Let us help you transform your vision into reality. Our team is ready to discuss your next project.', 'avantex' ) );
$cta_btn_text = get_theme_mod( 'avantex-servicespage-cta-btn-text', __( 'Contact Us', 'avantex' ) );
$cta_btn_link = get_theme_mod( 'avantex-servicespage-cta-btn-link', '' );

if ( empty( $cta_btn_link ) ) {
	$cta_btn_link = home_url( '/contact/' );
}
?>
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<!-- Services Template Start -->
	<div id="services-template" class="services-template-wrapper py-5">

		<!-- Hero Intro Section -->
		<?php if ( 1 === intval( $services_show_hero ) ) { ?>
			<section class="services-hero-section py-5 my-5 wow fadeInUp animated" data-wow-delay="100ms">
				<div class="<?php echo esc_attr( $services_container_class ); ?>">
					<div class="row align-items-center">
						<div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
							<div class="services-hero-image-wrapper">
								<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="img-fluid shadow-lg">
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="services-hero-content pl-lg-4">
								<p class="section-subtitle services-hero-subtitle"><?php echo esc_html( $hero_subtitle ); ?></p>
								<h2 class="title services-hero-title mb-4"><b><?php echo esc_html( $hero_title ); ?></b></h2>
								<div class="services-hero-desc mb-4">
									<?php echo wp_kses_post( $hero_desc ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- Services Grid Embed Section -->
		<?php if ( 1 === intval( $services_show_grid ) ) { ?>
			<div class="services-grid-embed-section py-5 my-5">
				<?php get_template_part( 'avantex-index/index', 'service' ); ?>
			</div>
		<?php } ?>

		<!-- Detailed Service Cards Section -->
		<?php
		if ( 1 === intval( $services_show_details ) && ! empty( $details_repeater ) ) {
			$decoded_details = json_decode( $details_repeater );
			if ( is_array( $decoded_details ) && ! empty( $decoded_details ) ) {
				$decoded_details = apply_filters( 'reavantex_pro_service_details', $decoded_details );
				$details_max     = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 3;
				?>
				<section class="services-details-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
					<div class="<?php echo esc_attr( $services_container_class ); ?>">
						<div class="section-header text-center mb-5">
							<p class="section-subtitle"><?php echo esc_html( $details_subtitle ); ?></p>
							<h2 class="section-title"><b><?php echo esc_html( $details_title ); ?></b></h2>
							<div class="divider-line"></div>
						</div>

						<div class="services-details-list">
							<?php
							$index = 0;
							foreach ( $decoded_details as $item ) {
								if ( $index >= $details_max ) {
									break;
								}
								$card_title = ! empty( $item->title ) ? $item->title : '';
								$card_desc  = ! empty( $item->text ) ? $item->text : '';
								$card_image = ! empty( $item->image_url ) ? $item->image_url : ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'service/service1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/service/service1.webp' : get_stylesheet_directory_uri() . '/assets/images/service/service1.webp' ) );
								$card_sub   = ! empty( $item->subtitle ) ? $item->subtitle : '';

								$card_btn   = ! empty( $item->btntitle ) ? $item->btntitle : '';
								$card_link  = ! empty( $item->link ) ? $item->link : '#';
								$is_even    = ( 1 === ( $index % 2 ) );
								?>
								<div class="services-detail-card mb-5 p-4 shadow-sm">
									<div class="row align-items-center <?php echo $is_even ? 'flex-row-reverse' : ''; ?>">
										<div class="col-lg-5 col-md-12 mb-4 mb-lg-0">
											<div class="services-detail-image">
												<img src="<?php echo esc_url( $card_image ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" class="img-fluid shadow">
											</div>
										</div>
										<div class="col-lg-7 col-md-12">
											<div class="services-detail-content px-lg-4">
												<h3 class="services-detail-title mb-3"><?php echo esc_html( $card_title ); ?></h3>
												<p class="services-detail-desc mb-4"><?php echo esc_html( $card_desc ); ?></p>
												<?php
												if ( ! empty( $card_sub ) ) {
													$features = explode( ',', $card_sub );
													?>
													<div class="services-detail-features mb-4">
														<?php
														foreach ( $features as $feat ) {
															if ( '' !== trim( $feat ) ) {
																?>
																<span class="badge badge-service-feature mr-2 mb-2 p-2 px-3 border"><i class="fas fa-check mr-1"></i> <?php echo esc_html( trim( $feat ) ); ?></span>
																<?php
															}
														}
														?>
													</div>
												<?php } ?>
												<a href="<?php echo esc_url( $card_link ); ?>" class="thm-btn services-detail-btn" <?php echo empty( $card_btn ) ? 'style="display: none;"' : ''; ?>><?php echo esc_html( $card_btn ); ?></a>
											</div>
										</div>
									</div>
								</div>
								<?php
								++$index;
							}
							?>
						</div>
					</div>
				</section>
				<?php
			}
		}
		?>

		<!-- Work Process Section -->
		<?php
		if ( 1 === intval( $services_show_process ) && ! empty( $process_repeater ) ) {
			$decoded_process = json_decode( $process_repeater );
			if ( is_array( $decoded_process ) && ! empty( $decoded_process ) ) {
				$decoded_process = apply_filters( 'reavantex_pro_service_process', $decoded_process );
				$process_max     = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 4;
				?>
				<section class="services-process-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
					<div class="<?php echo esc_attr( $services_container_class ); ?>">
						<div class="section-header text-center mb-5">
							<p class="section-subtitle"><?php echo esc_html( $process_subtitle ); ?></p>
							<h2 class="section-title"><b><?php echo esc_html( $process_title ); ?></b></h2>
							<div class="divider-line"></div>
						</div>

						<div class="row services-process-steps-row">
							<?php
							$step_num = 1;
							foreach ( $decoded_process as $item ) {
								if ( $step_num > $process_max ) {
									break;
								}
								$step_title = ! empty( $item->title ) ? $item->title : '';
								$step_desc  = ! empty( $item->text ) ? $item->text : '';
								$step_icon  = ! empty( $item->icon_value ) ? $item->icon_value : 'fas fa-cog';
								?>
								<div class="col-lg-3 col-md-6 col-sm-12 mb-4">
									<div class="process-step-card text-center p-4 shadow-sm h-100 position-relative">
										<div class="process-step-number-wrap position-absolute" style="top: -15px; left: 50%; transform: translateX(-50%);">
											<span class="process-step-number d-flex align-items-center justify-content-center shadow" style="width: 35px; height: 35px; font-weight: bold;"><?php echo esc_html( $step_num ); ?></span>
										</div>
										<div class="process-step-icon my-4" style="font-size: 2.5rem;">
											<i class="<?php echo esc_attr( $step_icon ); ?>"></i>
										</div>
										<h4 class="process-step-title mb-3"><?php echo esc_html( $step_title ); ?></h4>
										<p class="process-step-desc mb-0"><?php echo esc_html( $step_desc ); ?></p>
									</div>
								</div>
								<?php
								++$step_num;
							}
							?>
						</div>
					</div>
				</section>
				<?php
			}
		}
		?>

		<!-- Call to Action Section -->
		<?php if ( 1 === intval( $services_show_cta ) ) { ?>
			<section class="services-cta-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
				<div class="<?php echo esc_attr( $services_container_class ); ?>">
					<div class="row justify-content-center text-center">
						<div class="col-lg-10">
							<div class="services-cta-box custom-about-cta-card p-5 shadow">
								<span class="cta-tagline services-cta-tagline text-uppercase font-weight-bold"><?php echo esc_html( $cta_tagline ); ?></span>
								<h2 class="cta-title my-2 services-cta-heading"><b><?php echo esc_html( $cta_title ); ?></b></h2>
								<p class="cta-desc mb-5 mx-auto services-cta-text"><?php echo esc_html( $cta_desc ); ?></p>
								<div class="cta-btn-wrapper">
									<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn services-cta-btn" <?php echo empty( $cta_btn_text ) ? 'style="display: none;"' : ''; ?>><?php echo esc_html( $cta_btn_text ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- WordPress Page Content Area -->
		<?php if ( 1 === intval( $services_show_content ) ) { ?>
			<div class="services-user-content-wrapper my-5 pt-3">
				<div class="<?php echo esc_attr( $services_container_class ); ?>">
					<div class="row justify-content-center">
						<div class="col-lg-10">
							<?php
							if ( have_posts() ) :
								while ( have_posts() ) :
									the_post();
									if ( get_the_content() ) : // Check if content exists.
										?>
										<article id="post-<?php the_ID(); ?>" <?php post_class( 'custom-about-content-card p-5 border shadow-sm' ); ?>>
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

	</div>
	<!-- Services Template End -->

	<div class="clearfix"></div>
<?php
get_footer();

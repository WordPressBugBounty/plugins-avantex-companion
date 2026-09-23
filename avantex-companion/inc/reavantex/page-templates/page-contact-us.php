<?php
/**
 * Template Name: Avantex Contact US
 *
 * @package avantex
 */

get_header();
?>
<!--Page Title-->
<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->
	<div class="clearfix"></div>

	<!-- Contact Us Template Section -->
	<div id="contact-template" class="contact-template-wrapper py-5">
		<?php
		$contactus_container_class = get_theme_mod( 'avantex-template-contactus-container', 'container' );
		$contactus_temp_title      = get_theme_mod( 'avantex-template-contactus-title-tag', 'Contact Now!' );
		$contactus_temp_subtitle   = get_theme_mod( 'avantex-template-contactus-title', 'Get in touch with us today' );
		?>

		<!-- Section 1: Header -->
		<section class="contact-intro-section py-5 wow fadeInUp animated" data-wow-delay="100ms">
			<div class="<?php echo esc_attr( $contactus_container_class ); ?>">
				<div class="section-header text-center mb-5">
					<p class="section-subtitle"><?php echo esc_html( $contactus_temp_title ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $contactus_temp_subtitle ); ?></b></h2>
					<div class="divider-line"></div>
				</div>

				<?php if ( have_posts() ) : ?>
					<div class="row justify-content-center">
						<div class="col-lg-8 text-center">
							<?php
							while ( have_posts() ) :
								the_post();
								if ( get_the_content() ) :
									?>
									<div class="entry-content contact-entry-content">
										<?php the_content(); ?>
									</div>
									<?php
								endif;
							endwhile;
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<!-- Top Section: Centered Form -->
		<section class="contact-form-section mb-5 pb-4 wow fadeInUp animated" data-wow-delay="200ms">
			<div class="<?php echo esc_attr( $contactus_container_class ); ?>">
				<div class="row justify-content-center">
					<div class="col-lg-8">
						<div class="custom-contact-form-card p-5">
						<span class="contact-form-subtitle"><?php echo esc_html( get_theme_mod( 'avantex-template-contactus-form-tag', 'Write To Us' ) ); ?></span>
						<h3 class="contact-form-title"><?php echo esc_html( get_theme_mod( 'avantex-template-contactus-form-title', 'Send a Message' ) ); ?></h3>

							<div class="contact-form-wrapper-inner">
								<?php
								$avantex_form_shortcode = get_theme_mod( 'avantex-template-contactus-form', "[WLFG id='1']" );
								if ( ! empty( $avantex_form_shortcode ) ) {
									echo do_shortcode( $avantex_form_shortcode );
								} else {
									echo '<p class="contact-form-fallback-text">Configure your contact form shortcode in the Customizer.</p>';
								}
								?>
							</div>

							<!-- Social Icons (native theme pattern) -->
							<div class="contact-social-icons-container">
								<?php
								if ( 1 === intval( get_theme_mod( 'avantex-contactpage-show-social', 1 ) ) ) {
									$social_align = get_theme_mod( 'avantex-contactpage-social-align', 'center' );
									$align_class  = 'justify-content-center';
									if ( 'left' === $social_align ) {
										$align_class = 'justify-content-start';
									} elseif ( 'right' === $social_align ) {
										$align_class = 'justify-content-end';
									}
									?>
									<div class="about-social-icons mt-5 pt-4 d-flex <?php echo esc_attr( $align_class ); ?> contact-social-icons-wrap">
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
					</div>
				</div>
			</div>
		</section>

		<!-- Middle Section: Map with custom header -->
		<section class="contact-map-section mb-5 pb-5 wow fadeInUp animated" data-wow-delay="300ms">
			<div class="<?php echo esc_attr( $contactus_container_class ); ?>">
				<div class="section-header text-center mb-5">
					<?php
					$map_title    = get_theme_mod( 'avantex-template-contactus-map-title', 'Where We Are Located' );
					$map_subtitle = get_theme_mod( 'avantex-template-contactus-map-subtitle', 'Want to visit where actually we are doing it !' );
					?>
					<p class="section-subtitle contact-section-subtitle"><?php echo esc_html( $map_title ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $map_subtitle ); ?></b></h2>
					<div class="divider-line"></div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="custom-contact-map-card h-100">
							<?php
							$avantex_map_content = get_theme_mod( 'avantex-template-contactus-map', 'https://maps.app.goo.gl/WXk5rQcjxQFSiyKm9' );
							if ( ! empty( $avantex_map_content ) ) {
								$trimmed_map = trim( $avantex_map_content );
								if ( strpos( $trimmed_map, '[' ) !== false ) {
									echo do_shortcode( $trimmed_map );
								} elseif ( strpos( $trimmed_map, '<iframe' ) !== false ) {
									$allowed_tags = array(
										'iframe' => array(
											'src'         => true,
											'width'       => true,
											'height'      => true,
											'style'       => true,
											'allowfullscreen' => true,
											'loading'     => true,
											'referrerpolicy' => true,
											'frameborder' => true,
											'allow'       => true,
										),
									);
									echo wp_kses( $trimmed_map, $allowed_tags );
								} else {
									$map_url = '';
									$is_url  = filter_var( $trimmed_map, FILTER_VALIDATE_URL ) || ( strpos( $trimmed_map, 'http://' ) === 0 || strpos( $trimmed_map, 'https://' ) === 0 );

									if ( $is_url ) {
										if ( strpos( $trimmed_map, 'output=embed' ) !== false || strpos( $trimmed_map, '/maps/embed' ) !== false ) {
											$map_url = $trimmed_map;
										} else {
											$place = '';
											if ( preg_match( '/google\.[a-z\.]+\/maps\/place\/([^\/@\?]+)/i', $trimmed_map, $matches ) ) {
												$place = rawurldecode( $matches[1] );
											} else {
												$parsed_url = wp_parse_url( $trimmed_map );
												if ( ! empty( $parsed_url['query'] ) ) {
													wp_parse_str( $parsed_url['query'], $query_args );
													if ( ! empty( $query_args['q'] ) ) {
														$place = $query_args['q'];
													}
												}
											}

											if ( empty( $place ) && preg_match( '/@(-?\d+\.\d+),(-?\d+\.\d+)/', $trimmed_map, $coord_matches ) ) {
												$place = $coord_matches[1] . ',' . $coord_matches[2];
											}

											if ( ! empty( $place ) ) {
												$map_url = 'https://maps.google.com/maps?q=' . rawurlencode( $place ) . '&output=embed';
											} else {
												if ( false !== strpos( $trimmed_map, 'goo.gl' ) ) {
													$transient_key = 'avantex_map_url_' . md5( $trimmed_map );
													$resolved_url  = get_transient( $transient_key );
													if ( false === $resolved_url ) {
														$response = wp_remote_head(
															$trimmed_map,
															array(
																'redirection' => 0,
																'sslverify'   => false,
															)
														);
														if ( ! is_wp_error( $response ) ) {
															$location_header = wp_remote_retrieve_header( $response, 'location' );
															if ( ! empty( $location_header ) ) {
																$resolved_url = $location_header;
																set_transient( $transient_key, $resolved_url, DAY_IN_SECONDS );
															} else {
																$resolved_url = $trimmed_map;
															}
														} else {
															$resolved_url = $trimmed_map;
														}
													}

													if ( ! empty( $resolved_url ) && $resolved_url !== $trimmed_map ) {
														if ( preg_match( '/google\.[a-z\.]+\/maps\/place\/([^\/@\?]+)/i', $resolved_url, $matches ) ) {
															$place   = rawurldecode( $matches[1] );
															$map_url = 'https://maps.google.com/maps?q=' . rawurlencode( $place ) . '&output=embed';
														} elseif ( preg_match( '/@(-?\d+\.\d+),(-?\d+\.\d+)/', $resolved_url, $coord_matches ) ) {
															$coords  = $coord_matches[1] . ',' . $coord_matches[2];
															$map_url = 'https://maps.google.com/maps?q=' . rawurlencode( $coords ) . '&output=embed';
														}
													}
												}

												if ( empty( $map_url ) ) {
													$map_url = $trimmed_map;
												}
											}
										}
									} else {
										// Plain text (coordinates or address).
										$map_url = 'https://maps.google.com/maps?q=' . rawurlencode( $trimmed_map ) . '&output=embed';
									}

									if ( ! empty( $map_url ) ) {
										?>
										<iframe class="contact-map-iframe" src="<?php echo esc_url( $map_url ); ?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
										<?php
									}
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Bottom Section: Cards Grid (4 columns) -->
		<section class="contact-cards-section mb-5 wow fadeInUp animated" data-wow-delay="400ms">
			<div class="<?php echo esc_attr( $contactus_container_class ); ?>">
				<div class="row justify-content-center">
					<?php
					$contactus_default           = defined( 'REAVANTEX_TEMPLATE_CONTACTUS_DEFAULTS' ) ? REAVANTEX_TEMPLATE_CONTACTUS_DEFAULTS : '[]';
					$contactus_location_repeater = get_theme_mod( 'avantex-template-contactus-repeater', $contactus_default );

					if ( ! empty( $contactus_location_repeater ) ) {
						$decoded_lcr = json_decode( $contactus_location_repeater );
						if ( is_array( $decoded_lcr ) ) {
							$decoded_lcr = apply_filters( 'reavantex_pro_contact_locations', $decoded_lcr );
							$lcr_max     = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 4;
							$lcr_idx     = 0;
							foreach ( $decoded_lcr as $location ) {
								if ( $lcr_idx >= $lcr_max ) {
									break;
								}
								$location_title     = ! empty( $location->title ) && 'undefined' !== $location->title ? $location->title : '';
								$location_text      = ! empty( $location->text ) && 'undefined' !== $location->text ? $location->text : '';
								$location_shortcode = ! empty( $location->shortcode ) && 'undefined' !== $location->shortcode ? $location->shortcode : '';
								$location_icon      = ! empty( $location->icon_value ) && 'undefined' !== $location->icon_value ? $location->icon_value : '';
								if ( empty( $location_icon ) ) {
									$location_icon = ! empty( $location->icon ) && 'undefined' !== $location->icon ? $location->icon : 'fas fa-map-marker-alt';
								}
								?>
								<div class="col-xl-6 col-lg-6 col-md-6 mb-4">
									<div class="contact-detail-card custom-contact-card p-5 text-center h-100">
										<div class="contact-card-icon mb-4">
											<i class="<?php echo esc_attr( $location_icon ); ?>"></i>
										</div>
										<h4 class="contact-card-title">
											<?php echo esc_html( $location_title ); ?>
										</h4>
										<p class="contact-card-text"><?php echo esc_html( $location_text ); ?></p>

										<?php if ( ! empty( $location_shortcode ) ) : ?>
											<div class="mt-4 pt-4 contact-card-shortcode-wrap">
												<?php echo do_shortcode( wp_kses_post( $location_shortcode ) ); ?>
											</div>
										<?php endif; ?>
									</div>
								</div>
								<?php
								++$lcr_idx;
							}
						}
					}
					?>
				</div>
			</div>
		</section>


	</div>
	<!-- /Contact Us Template -->

	<div class="clearfix"></div>

<?php
get_footer();

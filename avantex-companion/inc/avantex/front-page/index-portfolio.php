<?php
/**
 * Portfolio Section
 *
 * @package avantex
 */
?>

<!-- Portfolio Section -->
<?php
if ( get_theme_mod( 'avantex-portfolio-show', 1 ) === 1 ) {
	$portfolio_container = get_theme_mod( 'avantex-portfolio-size', 'container-fluid' );
	?>
		<section id="portfolio-section" class="portfolio">
			<div class="<?php echo esc_html( $portfolio_container ); ?> sr-portfolio">

				<div class="row">
					<div class="col-md-12">
						<div class="section-header">
							<h2 class="section-title" style="color:<?php echo esc_html( get_theme_mod( 'avantex-portfolio-title-color' ) ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-portfolio-title', 'OUR RECENT PROJECTS' ) ); ?></h2>
							<p class="section-subtitle" style="color:<?php echo esc_html( get_theme_mod( 'avantex-portfolio-description-color' ) ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-portfolio-subtitle', 'Checkout what we are doing!' ) ); ?></p>
							<div class="divider-line"></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div id="portfolio-demo" class="owl-carousel owl-theme col-md-12">
						<?php
						$fpportfolio_callout = get_theme_mod( 'avantex-portfolio-repeater', PORTFOLIO_DEFAULTS );
						if ( ! empty( $fpportfolio_callout ) ) {
							$fpportfolio_callout_decoded = json_decode( $fpportfolio_callout );
							foreach ( $fpportfolio_callout_decoded as $fpportfolio_item ) {
								$fpportfolioimg      = $fpportfolio_item->image_url;
								$fpportfoliosubtitle = $fpportfolio_item->subtitle;
								$fpportfoliotitle    = $fpportfolio_item->title;
								$fpportfoliolink     = $fpportfolio_item->link;
								?>
								<div class="item wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
									<article class="post">
										<figure class="portfolio-thumbnail">
											<img src="<?php echo esc_html( $fpportfolioimg ); ?>" alt="Print Media">
											<figcaption>
												<div class="portfolio-overlay">
													<div class="portfolio-overlay-inner">
														<div class="portfolio-icons">
														<?php $pf_icons_color = get_theme_mod( 'avantex-portfolio-icons-color' ); ?>
															<a href="<?php echo esc_html( $fpportfolioimg ); ?>" data-lightbox="image" class="click" style="color:<?php echo esc_html( $pf_icons_color ); ?>"><i class="fas fa-eye"></i></a>
															<a href="<?php echo esc_html( $fpportfoliolink ); ?>" style="color:<?php echo esc_html( $pf_icons_color ); ?>"><i class="fas fa-link"></i></a>
														</div>
													</div>
												</div>
												<p class="branding" style="color:<?php echo esc_html( get_theme_mod( 'avantex-portfolio-tag-color' ) ); ?>"><?php echo esc_html( $fpportfoliotitle ); ?></p>
												<h5 class="entry-title" ><a href="#" style="color:<?php echo esc_html( get_theme_mod( 'avantex-portfolio-project-title-color' ) ); ?>"><?php echo esc_html( $fpportfoliosubtitle ); ?></a></h5>
											</figcaption>
											<!--<a href="images/item1.jpg" data-lightbox="image" class="click"><i class="fa fa-search"></i></a>-->
										</figure>
									</article>
								</div>
								<?php
							}
						}
						?>

					</div>

				</div>

			</div>
		</section>

	<script>
		jQuery(window).load(function() {
			jQuery("#portfolio-demo").owlCarousel({
				navigation: false,
				autoplay: <?php echo esc_html( get_theme_mod( 'avantex-portfolio-autoplay', 1 ) ); ?>,
				autoplayTimeout: 3000,
				autoplayHoverPause: true,
				smartSpeed: 700,
				loop: true, // loop is true up to 1199px screen.
				nav: <?php echo esc_html( get_theme_mod( 'avantex-portfolio-prevnext', 'true' ) ); ?>, // is true across all sizes
				margin: 30, // margin 10px till 960 breakpoint
				autoHeight: true,
				responsiveClass: true,
				dots: false,
				navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
				responsive: {
					100: { items: 1 },
					480: { items: 1 },
					768: { items: 2 },
					1000: { items: 3 },
					<?php
					if ( $portfolio_container !== 'container' ) {
						echo '1200: { items: 4 },';
					}
					?>
				}

			});
			<?php if ( 'false' !== get_theme_mod( 'avantex-portfolio-prevnext' ) ) { ?>
				jQuery('#portfolio-demo').find('.owl-nav').removeClass('disabled');
				jQuery('#portfolio-demo').on('changed.owl.carousel', function(event) {
					jQuery(this).find('.owl-nav').removeClass('disabled');
				});
			<?php } ?>
		});
	</script>
<?php } ?>

		<!-- /Portfolio Section -->

		<div class="clearfix"></div>

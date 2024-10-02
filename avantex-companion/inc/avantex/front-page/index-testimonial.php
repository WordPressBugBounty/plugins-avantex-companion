<?php
/**
 * Section Testimonial
 *
 * @package avantex
 */
?>

<!-- Testimonial Section -->
<?php
if ( get_theme_mod( 'avantex-testimonial-show', 1 ) === 1 ) {
	$testimonial_title_color     = get_theme_mod( 'avantex-testimonial-title-color' );
	$testimonial_title_tag_color = get_theme_mod( 'avantex-testimonial-description-color' );
	?>
<section id="testimonial-section" class="testimonial theme-light">
	<div class="container sr-testimonial">
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-md-12 col-xs-12">
				<div class="section-header">
					<p class="section-subtitle" style="color:<?php echo esc_html( $testimonial_title_tag_color ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-testimonial-title-tag', 'Happy Customers!' ) ); ?></p>
					<h1 class="section-title" style="color:<?php echo esc_html( $testimonial_title_color ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-testimonial-title', 'CUSTOMER FEEDBACKS ABOUT US' ) ); ?></h1>
				</div>
			</div>

			<div class="col-xl-8 col-lg-8 col-md-12 col-xs-12">

				<div class="owl-carousel owl-theme col-md-12" id="testimonial-demo">
					<?php
					$testimonial_review_title_color = get_theme_mod( 'avantex-testimonial-review-title-color' );
					$testimonial_review_text_color  = get_theme_mod( 'avantex-testimonial-review-color' );
					$testimonial_client_name_color  = get_theme_mod( 'avantex-testimonial-client-color' );
					$testimonial_client_desig_color = get_theme_mod( 'avantex-testimonial-client-desig-color' );
					$testimonial_callout            = get_theme_mod( 'avantex-testimonial-repeater', TESTIMONIAL_DEFAULTS );
						/*This returns a json so we have to decode it*/
					if ( ! empty( $testimonial_callout ) ) {
						$testimonial_callout_decoded = json_decode( $testimonial_callout );
						foreach ( $testimonial_callout_decoded as $testimonial ) {
							$testimonial_img       = $testimonial->image_url;
							$testimonial_subtitle  = $testimonial->subtitle;
							$testimonial_title     = $testimonial->title;
							$testimonial_btntitle  = $testimonial->btntitle;
							$testimonial_shortcode = $testimonial->shortcode;
							?>
								<div class="item">
									<div class="review">
										<aside class="wt-content">
											<h4 class="wt-title" style="color:<?php echo esc_html( $testimonial_review_title_color ); ?>"><?php echo esc_html( $testimonial_title ); ?></h4>
											<p style="color:<?php echo esc_html( $testimonial_review_text_color ); ?>"><?php echo esc_html( $testimonial_subtitle ); ?></p>
										</aside>
										<article class="client-info">
											<figure class="client-thumbnail"><img src="<?php echo esc_html( $testimonial_img ); ?>" class="img-circle" alt="testimonial"></figure>
											<cite class="client-name" style="color:<?php echo esc_html( $testimonial_client_name_color ); ?>"><?php echo esc_html( $testimonial_btntitle ); ?></cite>
											<span class="client-designation" style="color:<?php echo esc_html( $testimonial_client_desig_color ); ?>"><?php echo esc_html( $testimonial_shortcode ); ?></span>
										</article>
										<div class="icon-quote">
											<img src="<?php echo esc_html( AVANTEX_TEMPLATE_URL ); ?>/assets/images/testimonial/quote.png">
										</div>
									</div>
								</div>
							<?php
						}
					}
					?>

				</div>

			</div>

		</div>

	</div>
</section>
<script>
	jQuery(document).ready(function(){
		jQuery("#testimonial-demo").owlCarousel({
			navigation: false,
			autoplay: true,
			autoplayTimeout: 3000,
			autoplayHoverPause: true,
			smartSpeed: 1000,
			loop: false,
			nav: false,
			margin: 30,
			autoHeight: true,
			responsiveClass: true,
			dots: false,
			navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
			responsive: {
				200: { items: 1 },
				480: { items: 1 },
				768: { items: 2 },
				1000: { items: 2 }
			}
		});
	});
</script>
<?php } ?>
<!--/Testimonial Section -->

<div class="clearfix"></div>

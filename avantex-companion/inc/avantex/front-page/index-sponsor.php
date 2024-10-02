<?php
/**
 * Sponsor Section
 *
 * @package avantex
 */

?>

<!-- Sponsors Section -->
<?php
if ( get_theme_mod( 'avantex-sponsors-show', 1 ) === 1 ) {
	$avantex_sponsors_title       = get_theme_mod( 'avantex-sponsors-title', 'MEET THE PARTNERS' );
	$avantex_sponsors_description = get_theme_mod( 'avantex-sponsors-title-tag', 'Sponsors' );
	$avantex_sponsors_title_color = get_theme_mod( 'avantex-sponsors-title-color' );
	$avantex_sponsors_desc_color  = get_theme_mod( 'avantex-sponsors-description-color' );
	?>
	<section id="sponsors-section" class="sponsors theme-light">
		<div class="container sr-sponsor">
			<div class="row">
				<div class="section-header">
					<p class="section-subtitle" style="color:<?php echo esc_html( $avantex_sponsors_desc_color ); ?>"><?php echo esc_html( $avantex_sponsors_description ); ?></p>
					<h1 class="section-title" style="color:<?php echo esc_html( $avantex_sponsors_title_color ); ?>"><?php echo esc_html( $avantex_sponsors_title ); ?></h1>
					<div class="divider-line"></div>
				</div>
				<div class="owl-carousel owl-theme col-md-12" id="sponsors-demo">
					<?php
					$sponsors_callout = get_theme_mod( 'avantex-sponsors-repeater', SPONSORS_DEFAULT );
							/*This returns a json so we have to decode it*/
					if ( ! empty( $sponsors_callout ) ) {
						$sponsors_callout_decoded = json_decode( $sponsors_callout );
						foreach ( $sponsors_callout_decoded as $sponsors_client ) {
							$clientimg   = $sponsors_client->image_url;
							$clienttitle = $sponsors_client->title;
							$clientlink  = $sponsors_client->link;
							?>
							<div class="item">
								<a href="<?php echo esc_html( $clientlink ); ?>"><img src="<?php echo esc_html( $clientimg ); ?>" alt="<?php echo esc_html( $clienttitle ); ?>"></a>
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
		jQuery(document).ready(function(){
			jQuery("#sponsors-demo").owlCarousel({
				navigation: false,
				autoplay: <?php echo esc_html( get_theme_mod( 'avantex-sponsors-autoplay', 'true' ) ); ?>,
				autoplayTimeout: 3000,
				autoplayHoverPause: true,
				smartSpeed: 700,
				loop: true,
				nav: false,
				margin: 30,
				autoHeight: true,
				responsiveClass: true,
				dots: false,
				responsive: {
					200: { items: 1 },
					480: { items: 1 },
					768: { items: 3 },
					1000: { items: 5 }
				}
			});
		});
	</script>
<?php } ?>
<!-- /Sponsors Section -->

<div class="clearfix"></div>

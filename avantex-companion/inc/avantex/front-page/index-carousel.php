<?php
/**
 * Carousel Section
 *
 * @package avantex
 */
?>

<!-- Slider Section -->
<?php if ( get_theme_mod( 'avantex_slider_overlay', 'itembf' ) === 'itembf' ) { ?>
	<?php $slider_overlay_color = get_theme_mod( 'avantex_slider_overlay_color', 'rgba(0,0,0,0.6)' ); ?>
<style>
	#slider-demo .itembf::before {
	content: "";
	display: block;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 0;
	background-color: <?php echo esc_html( $slider_overlay_color ); ?>;
}
</style>
<?php } ?>
<?php if ( get_theme_mod( 'avantex-slider-show', 1 ) === 1 ) { ?>
		<section id="slider-section" class="hero-slider sr-slider">
			<div id="slider-demo" class="owl-carousel owl-theme">
			<?php
			$fpcarouselitems = get_theme_mod( 'avantex-slider-repeater', SLIDER_DEFAULTS );
					/*This returns a json so we have to decode it*/
			if ( ! empty( $fpcarouselitems ) ) {
				$fpcarouselitems_decoded = json_decode( $fpcarouselitems );
				foreach ( $fpcarouselitems_decoded as $fpcarouselitems_item ) {
					$fpcarouselimgurl   = $fpcarouselitems_item->image_url;
					$fpcarouseltitle    = $fpcarouselitems_item->title;
					$fpcarouselsubtitle = $fpcarouselitems_item->subtitle;
					$fpcarouseltext     = $fpcarouselitems_item->text;
					$fpcarouselbtntext  = $fpcarouselitems_item->btntitle;
					$fpcarouselbtnlink  = isset( $fpcarouselitems_item->link ) ? $fpcarouselitems_item->link : '#';
					?>
				<div class="item home-section home-full-height <?php echo esc_html( get_theme_mod( 'avantex_slider_overlay', 'itembf' ) ); ?>" style="background-image:url('<?php echo esc_html( $fpcarouselimgurl ); ?>');">
					<div class="container slider-caption">
						<figcaption class="caption-content text-center">
							<?php
							if ( ! empty( $fpcarouseltitle ) ) {
								$slide_tag_color = get_theme_mod( 'avantex_slider_titletag_color' );
								?>
								<span class="subtitle" style="color:<?php echo esc_html( $slide_tag_color ); ?>;"><?php echo esc_html( $fpcarouseltitle ); ?></span>
								<?php
							}
							if ( ! empty( $fpcarouselsubtitle ) ) {
								$slide_title_color = get_theme_mod( 'avantex_slider_title_color' );
								?>
								<h2 class="title" style="color:<?php echo esc_html( $slide_title_color ); ?>;"><?php echo esc_html( $fpcarouselsubtitle ); ?></h2>
								<?php
							}
							if ( ! empty( $fpcarouseltext ) ) {
								$slide_description_color = get_theme_mod( 'avantex_slider_description_color' );
								?>
								<p style="color:<?php echo esc_html( $slide_description_color ); ?>;"><?php echo esc_html( $fpcarouseltext ); ?></p>
								<?php
							}
							if ( ! empty( $fpcarouselbtntext ) ) {
								$slide_btntxt_color = get_theme_mod( 'avantex_slider_btntext_color' );
								?>
									<div class="m-top-40">
										<a href="<?php echo esc_url( $fpcarouselbtnlink ); ?>" class="thm-btn" style="color:<?php echo esc_html( $slide_btntxt_color ); ?>;"><?php echo esc_html( $fpcarouselbtntext ); ?></a>
									</div>
							<?php } ?>
						</figcaption>
					</div>
				</div>
					<?php
				}
			}
			?>
			</div>
		</section>

	<script>
		jQuery(window).load(function() {
			jQuery("#slider-demo").owlCarousel({
			navigation: true, // Show next and prev buttons	
			autoplay: <?php echo esc_html( get_theme_mod( 'avantex_slider_autoplay', 1 ) ); ?>, // autoplay
			autoplayTimeout: <?php echo esc_html( get_theme_mod( 'avantex_slider_speed', '3000' ) ); ?>, // autoplay speed
			autoplayHoverPause: <?php echo esc_html( get_theme_mod( 'avantex_slider_pauseonhover', 'true' ) ); ?>,
			smartSpeed: 800,
			singleItem: true,
			autoHeight: true,
			loop: <?php echo esc_html( get_theme_mod( 'avantex_slider_loop', 'true' ) ); ?>, // loop is true up to 1199px screen.
			nav: <?php echo esc_html( get_theme_mod( 'avantex_slider_prevnext', 'true' ) ); ?>, // is true across all sizes
			margin: 0, // margin 10px till 960 breakpoint
			responsiveClass: true, // Optional helper class. Add 'owl-reponsive-' + 'breakpoint' class to main element.
			items: 1,
			dots: false,
			navText: ["PREV", "NEXT"]

		});
		});
	</script>
<?php } ?>
		<!-- /Slider Section -->
		<div class="clearfix"></div>

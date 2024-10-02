<?php
/**
 * About Section
 *
 * @package avantex
 */

?>

<!--About Section---->
<?php if ( get_theme_mod( 'avantex-about-show', 1 ) === 1 ) { ?>
	<section id="about-section" class="about">
		<?php
			$about_container_class  = get_theme_mod( 'avantex-about-container', 'container' );
			$about_image            = get_theme_mod( 'avantex-about-image', ABOUT_IMAGE );
			$avantex_about_subtitle = get_theme_mod( 'avantex-about-subtitle', ABOUT_TITLE_TAG );
			$avantex_about_info     = get_theme_mod( 'avantex-about-info', ABOUT_TEXT );
			$avantex_about_title    = get_theme_mod( 'avantex-about-title', ABOUT_TITLE );

		?>
		<div class="<?php echo esc_attr( $about_container_class ); ?> sr-about">
			<div class="row v-center">
				<div class="col-xl-6 col-lg-6 col-md-12 col-xs-12 wow fadeInLeft animated" data-wow-delay="300ms" style="visibility: visible; animation-delay: 300ms; animation-name: fadeInLeft;">
					<div class="about-wrap">
						<div class="about-img-holder card-holder double base">
							<div class="card__image">
								<img src="<?php echo esc_url_raw( $about_image ); ?>">
							</div>
						</div>
						<div class="about-img-holder card-holder holder-small double base">
							<div class="card__image">
								<img src="<?php echo esc_url_raw( $about_image ); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-12 col-xs-12  wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
					<div class="about-module">
					<?php echo esc_html( '' ); ?>
						<h6 class="subtitle text-grey"><?php echo esc_html( $avantex_about_subtitle ); ?></h6>
						<h2 class="title"><b><?php echo esc_html( $avantex_about_title ); ?></b></h2>
						<p><?php echo wp_kses_post( $avantex_about_info ); ?></p>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

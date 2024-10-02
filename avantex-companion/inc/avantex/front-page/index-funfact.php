<?php
/**
 * Funfact Section
 *
 * @package avantex
 */
?>

<!-- Funfact Section ---->
<?php if ( get_theme_mod( 'avantex-funfact-show', 1 ) === 1 ) { ?>
<section id="funfact-section" class="funfact">
	<div class="funfact-shape"></div>
	<div class="container sr-funfact">

		<div class="row ">
			<?php
			$funfact_title_color    = get_theme_mod( 'avantex-funfact-title-color' );
			$funfact_subtitle_color = get_theme_mod( 'avantex-funfact-numbers-color' );
			$funfact_callout        = get_theme_mod( 'avantex-funfact-repeater', FUNFACT_DEFAULTS );
			$funfact_grid           = get_theme_mod( 'avantex-funfact-grid', 'col-lg-3' );
					/*This returns a json so we have to decode it*/
			if ( ! empty( $funfact_callout ) ) {
				$funfact_callout_decoded = json_decode( $funfact_callout );
				foreach ( $funfact_callout_decoded as $funfact ) {
					$funfact_subtitle = $funfact->subtitle;
					$funfact_title    = $funfact->title;
					$funfact_icon     = $funfact->icon_value;
					?>
					<div class="<?php echo esc_attr( $funfact_grid ); ?> col-md-4 col-sm-6">
						<div class="funfact-inner text-center">
							<i class="<?php echo esc_html( $funfact_icon ); ?> funfact-icon"></i>
							<h3 class="funfact-title odometer" data-count="<?php echo esc_html( $funfact_subtitle ); ?>" style="color:<?php echo esc_html( $funfact_subtitle_color ); ?>"><?php echo esc_html( $funfact_subtitle ); ?></h3>
							<p class="description" style="color:<?php echo esc_html( $funfact_title_color ); ?>"><?php echo esc_html( $funfact_title ); ?></p>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>

	</div>
</section>
<?php } ?>
<!-- /End of Funfact Section ---->

<div class="clearfix"></div>

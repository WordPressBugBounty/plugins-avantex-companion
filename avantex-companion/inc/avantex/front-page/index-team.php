<?php
/**
 * Team Section
 *
 * @package avantex
 */
?>

<!-- Team Section -->
<?php
if ( get_theme_mod( 'avantex-team-show', 1 ) === 1 ) {
	$team_container       = get_theme_mod( 'avantex-team-size', 'container-fluid' );
	$team_title_color     = get_theme_mod( 'avantex-team-title-color' );
	$team_title_tag_color = get_theme_mod( 'avantex-team-description-color' );
	?>
<section id="team-section" class="team theme-grey">
	<div class="<?php echo esc_html( $team_container ); ?> sr-team">
		<div class="row">
			<div class="col-md-12">
				<div class="section-header">
					<p class="section-subtitle" style="color:<?php echo esc_html( $team_title_tag_color ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-team-title-tag', 'Our Team' ) ); ?></p>
					<h1 class="section-title" style="color:<?php echo esc_html( $team_title_color ); ?>"><?php echo esc_html( get_theme_mod( 'avantex-team-title', 'MEET THE TEAM' ) ); ?></h1>
					<div class="divider-line"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div id="team-demo" class="owl-carousel owl-theme col-md-12">
				<?php
						$socialiconcolor     = get_theme_mod( 'avantex-team-icons-color' );
						$memberpositioncolor = get_theme_mod( 'avantex-team-position-color' );
						$membernamecolor     = get_theme_mod( 'avantex-team-member-title-color' );
						$team_callout        = get_theme_mod( 'avantex-team-repeater', TEAM_DEFAULTS );
				if ( ! empty( $team_callout ) ) {
					$team_callout_decoded = json_decode( $team_callout );
					foreach ( $team_callout_decoded as $team_member ) {
						$memberimg      = $team_member->image_url;
						$membersubtitle = $team_member->subtitle;
						$membertitle    = $team_member->title;
						?>
						<div class="item wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
							<div class="team-module">
								<figure class="team-avatar">
									<img class="img-responsive" src="<?php echo esc_html( $memberimg ); ?>" alt="<?php echo esc_html( $membersubtitle ); ?>">
									<div class="team-overlay">
										<div class="team-overlay-inner">
											<div class="team-social-icons">
												<?php
													/*Social repeater is also a repeater so we need to decode it*/
												if ( ! empty( $team_member->social_repeater ) ) {
													$social_repeater = json_decode( html_entity_decode( $team_member->social_repeater ) );
													foreach ( $social_repeater as $member_icondata ) {
														$members_icon_link = $member_icondata->link;
														$member_icon       = $member_icondata->icon;
														?>
														<a href="<?php echo esc_html( $members_icon_link ); ?>" style="color:<?php echo esc_html( $socialiconcolor ); ?>"><i class="<?php echo esc_html( $member_icon ); ?>"></i></a>
															<?php
													}
												}
												?>
											</div>
										</div>
									</div>
								</figure>
								<figcaption class="team-caption">
									<p class="designation" style="color:<?php echo esc_html( $memberpositioncolor ); ?>"><?php echo esc_html( $membertitle ); ?></p>
									<h4 class="name" style="color:<?php echo esc_html( $membernamecolor ); ?>"><?php echo esc_html( $membersubtitle ); ?></h4>
								</figcaption>
							</div>
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
		jQuery("#team-demo").owlCarousel({
			navigation: false,
			autoplay: <?php echo esc_html( get_theme_mod( 'avantex-team-autoplay', 1 ) ); ?>,
			autoplayTimeout: 3000,
			autoplayHoverPause: true,
			smartSpeed: 700,
			loop: true, // loop is true up to 1199px screen.
			nav: <?php echo esc_html( get_theme_mod( 'avantex-team-prevnext', 'true' ) ); ?>,
			margin: 30, // margin 10px till 960 breakpoint
			autoHeight: true,
			responsiveClass: true,
			dots: false,
			navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
			responsive: {
				100: { items: 1 },
				480: { items: 1 },
				768: { items: 2 },
				1000: { items: 4 }
			}
		});
			<?php if ( 'false' !== get_theme_mod( 'avantex-team-prevnext' ) ) { ?>
				jQuery('#team-demo').find('.owl-nav').removeClass('disabled');
				jQuery('#team-demo').on('changed.owl.carousel', function(event) {
					jQuery(this).find('.owl-nav').removeClass('disabled');
				});
			<?php } ?>
	});
</script>
<?php } ?>
<!--/ Team Section-->
<div class="clearfix"></div>

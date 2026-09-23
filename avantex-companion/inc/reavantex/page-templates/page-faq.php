<?php
/**
 * Template Name: Avantex FAQ
 *
 * @package avantex
 */

get_header();

// Fetch settings.
$faq_container_class = get_theme_mod( 'avantex-template-faq-container', 'container' );
$faq_show_content    = get_theme_mod( 'avantex-faqpage-show-content', 1 );
$faq_show_cta        = get_theme_mod( 'avantex-faqpage-show-cta', 1 );

$faq_subtitle = get_theme_mod( 'avantex-faqpage-subtitle', __( 'FAQ', 'avantex' ) );
$faq_title    = get_theme_mod( 'avantex-faqpage-title', __( 'Frequently Asked Questions', 'avantex' ) );
$faq_desc     = get_theme_mod( 'avantex-faqpage-desc', __( 'Find answers to the most commonly asked questions below. If you cannot find what you are looking for, feel free to contact us.', 'avantex' ) );

$faq_default  = defined( 'REAVANTEX_TEMPLATE_FAQ_DEFAULTS' ) ? REAVANTEX_TEMPLATE_FAQ_DEFAULTS : '[]';
$faq_repeater = get_theme_mod( 'avantex-faqpage-repeater', $faq_default );


$cta_title    = get_theme_mod( 'avantex-faqpage-cta-title', __( 'Still have questions?', 'avantex' ) );
$cta_desc     = get_theme_mod( 'avantex-faqpage-cta-desc', __( 'We are here to help. Reach out to our team for personalized assistance.', 'avantex' ) );
$cta_btn_text = get_theme_mod( 'avantex-faqpage-cta-btn-text', __( 'Contact Us', 'avantex' ) );
$cta_btn_link = get_theme_mod( 'avantex-faqpage-cta-btn-link', '' );

if ( empty( $cta_btn_link ) ) {
	$cta_btn_link = home_url( '/contact/' );
}
?>
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<!-- FAQ Template Start -->
	<div id="faq-template" class="faq-template-wrapper py-5">

		<!-- FAQ Header Section -->
		<section class="faq-header-section py-5 my-3 wow fadeInUp animated" data-wow-delay="100ms">
			<div class="<?php echo esc_attr( $faq_container_class ); ?>">
				<div class="section-header text-center mb-4">
					<p class="section-subtitle"><?php echo esc_html( $faq_subtitle ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $faq_title ); ?></b></h2>
					<div class="divider-line"></div>
				</div>
				<?php if ( ! empty( $faq_desc ) ) { ?>
					<div class="faq-header-desc text-center mb-5">
						<?php echo wp_kses_post( $faq_desc ); ?>
					</div>
				<?php } ?>
			</div>
		</section>

		<!-- FAQ Accordion Section -->
		<?php
		if ( ! empty( $faq_repeater ) ) {
			$decoded_faq = json_decode( $faq_repeater );
			if ( is_array( $decoded_faq ) && ! empty( $decoded_faq ) ) {
				$decoded_faq = apply_filters( 'reavantex_pro_faq_items', $decoded_faq );
				$faq_max     = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 6;
				?>
				<section class="faq-accordion-section pb-5 mb-5 wow fadeInUp animated" data-wow-delay="200ms">
					<div class="<?php echo esc_attr( $faq_container_class ); ?>">
						<?php do_action( 'reavantex_pro_faq_search_bar' ); ?>
						<div class="row justify-content-center">
							<div class="col-lg-8 col-md-10 col-sm-12">
								<div class="faq-accordion-wrapper">
									<?php
									$index = 0;
									foreach ( $decoded_faq as $item ) {
										if ( $index >= $faq_max ) {
											break;
										}
										$q_title       = ! empty( $item->title ) ? $item->title : '';
										$q_desc        = ! empty( $item->text ) ? $item->text : '';
										$q_cat         = ! empty( $item->subtitle ) ? $item->subtitle : 'General';
										$active_class  = ( 0 === $index ) ? 'active' : '';
										$display_style = ( 0 === $index ) ? 'display: block;' : 'display: none;';
										?>
										<div class="faq-accordion-item shadow-sm <?php echo esc_attr( $active_class ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
											<div class="faq-accordion-header">
												<span class="faq-category-badge"><?php echo esc_html( $q_cat ); ?></span>
												<h4 class="faq-question"><?php echo esc_html( $q_title ); ?></h4>
												<span class="faq-accordion-icon"><i class="fas fa-chevron-down"></i></span>
											</div>
											<div class="faq-accordion-body" style="<?php echo esc_attr( $display_style ); ?>">
												<p class="faq-answer"><?php echo esc_html( $q_desc ); ?></p>
											</div>
										</div>
										<?php
										++$index;
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}
		}
		?>

		<!-- Call to Action Section -->
		<?php if ( 1 === intval( $faq_show_cta ) ) { ?>
			<section class="faq-cta-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
				<div class="<?php echo esc_attr( $faq_container_class ); ?>">
					<div class="row justify-content-center text-center">
						<div class="col-lg-10">
							<div class="faq-cta-box custom-about-cta-card p-5 shadow">
								<h1 class="cta-title my-2 faq-cta-heading"><b><?php echo esc_html( $cta_title ); ?></b></h1>
								<p class="cta-desc mb-5 mx-auto faq-cta-text"><?php echo esc_html( $cta_desc ); ?></p>
								<div class="cta-btn-wrapper">
									<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn faq-cta-btn" <?php echo empty( $cta_btn_text ) ? 'style="display: none;"' : ''; ?>><?php echo esc_html( $cta_btn_text ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>

		<!-- WordPress Page Content Area -->
		<?php if ( 1 === intval( $faq_show_content ) ) { ?>
			<div class="faq-user-content-wrapper my-5 pt-3">
				<div class="<?php echo esc_attr( $faq_container_class ); ?>">
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
	<!-- FAQ Template End -->

	<div class="clearfix"></div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.faq-accordion-header').on('click', function() {
			var $item = $(this).closest('.faq-accordion-item');
			var wasActive = $item.hasClass('active');

			// Close all items
			$('.faq-accordion-item').removeClass('active');
			$('.faq-accordion-body').slideUp(300);

			// Toggle clicked item
			if (!wasActive) {
				$item.addClass('active');
				$item.find('.faq-accordion-body').slideDown(300);
			}
		});
	});
	</script>
<?php
get_footer();

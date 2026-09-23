<?php
/**
 * Template Name: Avantex Terms of Service
 *
 * @package avantex
 */

get_header();

// Fetch settings.
$legal_container_class = get_theme_mod( 'avantex-template-terms-of-service-container', 'container' );
$legal_subtitle        = get_theme_mod( 'avantex-terms-of-service-subtitle', __( 'Legal', 'avantex' ) );
$legal_title           = get_theme_mod( 'avantex-terms-of-service-title', __( 'Terms of Service', 'avantex' ) );
$legal_show_toc        = get_theme_mod( 'avantex-terms-of-service-show-toc', 1 );
$legal_show_cta        = get_theme_mod( 'avantex-terms-of-service-show-cta', 1 );

$cta_title    = get_theme_mod( 'avantex-terms-of-service-cta-title', __( 'Have questions about our terms?', 'avantex' ) );
$cta_desc     = get_theme_mod( 'avantex-terms-of-service-cta-desc', __( 'If you have any questions or concerns about our terms of service, please do not hesitate to contact us.', 'avantex' ) );
$cta_btn_text = get_theme_mod( 'avantex-terms-of-service-cta-btn-text', __( 'Contact Us', 'avantex' ) );
$cta_btn_link = get_theme_mod( 'avantex-terms-of-service-cta-btn-link', '' );

if ( empty( $cta_btn_link ) ) {
	$cta_btn_link = home_url( '/contact/' );
}
?>
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<!-- Terms of Service Template Start -->
	<div id="terms-of-service-template" class="terms-of-service-template-wrapper py-5">

		<!-- Terms of Service Header Section -->
		<section class="terms-of-service-header-section py-5 my-3 wow fadeInUp animated" data-wow-delay="100ms">
			<div class="<?php echo esc_attr( $legal_container_class ); ?>">
				<div class="section-header text-center mb-4">
					<p class="section-subtitle legal-header-subtitle"><?php echo esc_html( $legal_subtitle ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $legal_title ); ?></b></h2>
					<div class="divider-line"></div>
				</div>
				<p class="legal-last-updated text-center mt-3">
					<i class="fas fa-calendar-alt"></i>
					<span class="legal-last-updated-text">
					<?php
						$legal_date = get_theme_mod( 'avantex-terms-of-service-date', '' );
					if ( empty( $legal_date ) ) {
						$legal_date = get_the_modified_date();
					}
						/* translators: %s: date */
						printf( esc_html__( 'Last Updated: %s', 'avantex' ), esc_html( $legal_date ) );
					?>
					</span>
				</p>
			</div>
		</section>

		<!-- Terms of Service Content & Sidebar Section -->
		<section class="terms-of-service-content-section pb-5 mb-5 wow fadeInUp animated" data-wow-delay="200ms">
			<div class="<?php echo esc_attr( $legal_container_class ); ?>">
				<div class="row">
					<?php if ( 1 === intval( $legal_show_toc ) ) { ?>
						<!-- Sidebar: TOC -->
						<div class="col-lg-4 col-md-12 mb-4 mb-lg-0 legal-toc-sidebar">
							<div class="legal-toc-card p-4 shadow-sm">
								<h5 class="legal-toc-heading"><?php esc_html_e( 'Table of Contents', 'avantex' ); ?></h5>
								<nav class="legal-toc-nav" id="terms-of-service-toc-nav">
									<!-- Auto-populated by jQuery -->
								</nav>
							</div>
						</div>
						<!-- Content Area -->
						<div class="col-lg-8 col-md-12">
					<?php } else { ?>
						<div class="col-lg-10 mx-auto col-md-12">
					<?php } ?>
							<div class="legal-content-body p-5 shadow-sm border">
								<article id="post-<?php the_ID(); ?>" <?php post_class( 'legal-article' ); ?>>
									<div class="entry-content">
										<?php
										$default_terms_content = '<h2>1. Acceptance of Terms</h2><p>By accessing or using our website and services, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p><h2>2. Use License and Restrictions</h2><p>Permission is granted to temporarily view the materials on this website for personal, non-commercial transitory viewing only. You may not modify or copy the materials, use them for commercial purposes, or attempt to decompile or reverse engineer any software contained on the website.</p><h2>3. User Account and Responsibilities</h2><p>If you create an account on our platform, you are responsible for maintaining the confidentiality of your credentials and for all activities that occur under your account.</p><h2>4. Intellectual Property Rights</h2><p>All content, features, branding, logos, and functionality on this website are the exclusive property of our company and are protected by international copyright, trademark, and other intellectual property laws.</p><h2>5. Disclaimer of Warranties</h2><p>The materials on this website are provided on an "as is" and "as available" basis without any warranties of any kind, either expressed or implied, including fitness for a particular purpose.</p><h2>6. Limitation of Liability</h2><p>In no event shall our company or its partners be liable for any damages arising out of the use or inability to use the materials on this website.</p><h2>7. Modifications and Governing Law</h2><p>We reserve the right to revise these terms of service at any time without prior notice. By continuing to use this website, you agree to be bound by the current version of these terms.</p>';

										$terms_content = get_theme_mod( 'avantex-terms-of-service-content', '' );
										if ( ! empty( $terms_content ) ) {
											echo wp_kses_post( $terms_content );
										} else {
											$has_content = false;
											if ( have_posts() ) {
												while ( have_posts() ) :
													the_post();
													$post_body = get_the_content();
													if ( ! empty( trim( $post_body ) ) ) {
														the_content();
														$has_content = true;
													}
												endwhile;
											}
											if ( ! $has_content ) {
												echo wp_kses_post( $default_terms_content );
											}
										}
										?>
									</div>
								</article>
							</div>
						</div>
				</div>
			</div>
		</section>

		<!-- Call to Action Section -->
		<?php if ( 1 === intval( $legal_show_cta ) ) { ?>
			<section class="terms-of-service-cta-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
				<div class="<?php echo esc_attr( $legal_container_class ); ?>">
					<div class="row justify-content-center text-center">
						<div class="col-lg-10">
							<div class="legal-cta-box custom-about-cta-card p-5 shadow">
								<h1 class="cta-title my-2 legal-cta-heading"><b><?php echo esc_html( $cta_title ); ?></b></h1>
								<p class="cta-desc mb-5 mx-auto legal-cta-text"><?php echo esc_html( $cta_desc ); ?></p>
								<div class="cta-btn-wrapper">
									<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn legal-cta-btn" <?php echo empty( $cta_btn_text ) ? 'style="display: none;"' : ''; ?>><?php echo esc_html( $cta_btn_text ); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>

	</div>
	<!-- Terms of Service Template End -->

	<div class="clearfix"></div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $toc = $('#terms-of-service-toc-nav');
		if (!$toc.length) return;

		var headings = $('.legal-article').find('h2, h3');
		if (headings.length === 0) {
			$toc.closest('.legal-toc-sidebar').hide();
			return;
		}

		$toc.empty();
		headings.each(function(i) {
			var $heading = $(this);
			var id = $heading.attr('id');
			if (!id) {
				id = 'terms-section-' + i;
				$heading.attr('id', id);
			}

			var tag = $heading.prop('tagName').toLowerCase();
			var isSub = tag === 'h3';
			var linkClass = 'legal-toc-link' + (isSub ? ' toc-sub-item' : ' toc-main-item');
			var headingText = $heading.text().trim();
			
			$toc.append('<a href="#' + id + '" class="' + linkClass + '"><span class="toc-icon"><i class="fas fa-chevron-right"></i></span><span class="toc-title">' + headingText + '</span></a>');
		});

		// Set initial active item
		$toc.find('a').first().addClass('active');

		// Smooth scroll on click
		$toc.on('click', 'a', function(e) {
			e.preventDefault();
			var target = $(this).attr('href');
			var $target = $(target);
			if ($target.length) {
				$toc.find('a').removeClass('active');
				$(this).addClass('active');
				$('html, body').stop().animate({ scrollTop: $target.offset().top - 120 }, 400);
			}
		});

		// Scrollspy for active heading highlight
		$(window).on('scroll', function() {
			var scrollPos = $(document).scrollTop() + 150;
			headings.each(function() {
				var top = $(this).offset().top;
				var bottom = top + $(this).outerHeight() + ($(this).nextUntil('h2, h3').last().length ? $(this).nextUntil('h2, h3').last().offset().top + $(this).nextUntil('h2, h3').last().outerHeight() - $(this).offset().top : 400);
				
				if (scrollPos >= top && scrollPos < bottom) {
					var id = $(this).attr('id');
					$toc.find('a').removeClass('active');
					$toc.find('a[href="#' + id + '"]').addClass('active');
				}
			});
		});
	});
	</script>
<?php
get_footer();

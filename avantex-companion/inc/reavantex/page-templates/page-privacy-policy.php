<?php
/**
 * Template Name: Avantex Privacy Policy
 *
 * @package avantex
 */

get_header();

// Fetch settings.
$legal_container_class = get_theme_mod( 'avantex-template-privacy-policy-container', 'container' );
$legal_subtitle        = get_theme_mod( 'avantex-privacy-policy-subtitle', __( 'Legal', 'avantex' ) );
$legal_title           = get_theme_mod( 'avantex-privacy-policy-title', __( 'Privacy Policy', 'avantex' ) );
$legal_show_toc        = get_theme_mod( 'avantex-privacy-policy-show-toc', 1 );
$legal_show_cta        = get_theme_mod( 'avantex-privacy-policy-show-cta', 1 );

$cta_title    = get_theme_mod( 'avantex-privacy-policy-cta-title', __( 'Have questions about our privacy policies?', 'avantex' ) );
$cta_desc     = get_theme_mod( 'avantex-privacy-policy-cta-desc', __( 'If you have any questions or concerns about our privacy policy, please do not hesitate to contact us.', 'avantex' ) );
$cta_btn_text = get_theme_mod( 'avantex-privacy-policy-cta-btn-text', __( 'Contact Us', 'avantex' ) );
$cta_btn_link = get_theme_mod( 'avantex-privacy-policy-cta-btn-link', '' );

if ( empty( $cta_btn_link ) ) {
	$cta_btn_link = home_url( '/contact/' );
}
?>
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<!-- Privacy Policy Template Start -->
	<div id="privacy-policy-template" class="privacy-policy-template-wrapper py-5">

		<!-- Privacy Policy Header Section -->
		<section class="privacy-policy-header-section py-5 my-3 wow fadeInUp animated" data-wow-delay="100ms">
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
						$legal_date = get_theme_mod( 'avantex-privacy-policy-date', '' );
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

		<!-- Privacy Policy Content & Sidebar Section -->
		<section class="privacy-policy-content-section pb-5 mb-5 wow fadeInUp animated" data-wow-delay="200ms">
			<div class="<?php echo esc_attr( $legal_container_class ); ?>">
				<div class="row">
					<?php if ( 1 === intval( $legal_show_toc ) ) { ?>
						<!-- Sidebar: TOC -->
						<div class="col-lg-4 col-md-12 mb-4 mb-lg-0 legal-toc-sidebar">
							<div class="legal-toc-card p-4 shadow-sm">
								<h5 class="legal-toc-heading"><?php esc_html_e( 'Table of Contents', 'avantex' ); ?></h5>
								<nav class="legal-toc-nav" id="privacy-policy-toc-nav">
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
										$default_privacy_content = '<h2>1. Information Collection</h2><p>We collect information you provide directly to us when you register, make a purchase, subscribe to our newsletter, or contact our support team. This may include your name, email address, phone number, and transaction details.</p><h2>2. How We Use Your Information</h2><p>We use the information we collect to deliver, maintain, and enhance our services, process customer transactions, send service updates, and communicate important account notifications.</p><h2>3. Data Protection and Security</h2><p>We implement industry-standard administrative, technical, and physical safeguards designed to protect your personal information against unauthorized access, loss, or alteration.</p><h2>4. Third-Party Disclosures</h2><p>We do not sell or trade your personal information. We may share necessary data with trusted service providers who assist us in operating our website and conducting our business under confidentiality agreements.</p><h2>5. Cookies and Tracking Technologies</h2><p>We use cookies and similar technologies to enhance navigation, analyze site performance, and deliver personalized user experiences. You can control cookie preferences through your browser settings.</p><h2>6. Your Privacy Rights</h2><p>You have the right to access, update, or request the deletion of your personal data at any time by contacting our data protection team.</p>';

										$privacy_content = get_theme_mod( 'avantex-privacy-policy-content', '' );
										if ( ! empty( $privacy_content ) ) {
											echo wp_kses_post( $privacy_content );
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
												echo wp_kses_post( $default_privacy_content );
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
			<section class="privacy-policy-cta-section py-5 my-5 wow fadeInUp animated" data-wow-delay="200ms">
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
	<!-- Privacy Policy Template End -->

	<div class="clearfix"></div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		var $toc = $('#privacy-policy-toc-nav');
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
				id = 'privacy-section-' + i;
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

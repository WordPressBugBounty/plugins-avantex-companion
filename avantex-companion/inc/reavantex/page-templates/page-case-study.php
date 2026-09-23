<?php
/**
 * Template Name: Avantex Case Study Template
 *
 * @package avantex
 */

get_header();

if ( ! function_exists( 'reavantex_is_pro' ) || ! reavantex_is_pro() ) {
	get_template_part(
		'template-parts/pro-notice',
		null,
		array(
			'feature_name' => __( 'Case Study Template', 'avantex' ),
			'feature_desc' => __( 'The interactive Case Study deep-dive showcase is exclusively available with ReAvantex Pro.', 'avantex' ),
		)
	);
	get_footer();
	return;
}

// Fetch portfolio page container settings.
$portfolio_container_class = get_theme_mod( 'avantex-template-portfolio-container', 'container' );

$portfolio_default = defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]';
$fpportfolio_callout = get_theme_mod( 'avantex-portfoliopage-repeater', $portfolio_default );

$decoded             = ! empty( $fpportfolio_callout ) ? json_decode( $fpportfolio_callout ) : array();
$case_id             = isset( $_GET['case_id'] ) ? intval( $_GET['case_id'] ) : -1;

if ( $case_id >= 0 && is_array( $decoded ) && isset( $decoded[ $case_id ] ) ) {
	// Mode 1: Customizer Repeater Item (case_id parameter).
	$item             = $decoded[ $case_id ];
	$case_title       = ! empty( $item->subtitle ) ? $item->subtitle : ( ! empty( $item->title ) ? $item->title : __( 'Featured Project', 'avantex' ) );
	$case_category    = ! empty( $item->title ) ? $item->title : __( 'Case Study', 'avantex' );
	$case_img_default = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/portfolio/project-1.webp' : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' );
	$case_image       = ! empty( $item->image_url ) ? $item->image_url : $case_img_default;

	$case_client   = ! empty( $item->button_title ) ? $item->button_title : ( 'Acme Corp for ' . $case_title );
	$case_timeline = '3 Months (2026)';
	$case_role     = 'UI/UX & Frontend Development';
	$case_tech     = 'WordPress, HTML5, CSS3, JS';
	$case_link_url = ! empty( $item->link ) && '#' !== $item->link ? $item->link : home_url();

	$case_challenge = ! empty( $item->text ) ? $item->text : ( 'The primary challenge for ' . $case_title . ' was to consolidate complex user workflows into a single, intuitive interface. The client experienced drop-offs in user engagement due to high learning curves and cognitive overload.' );
	$case_solution  = ! empty( $item->text2 ) ? $item->text2 : ( 'Our team conducted thorough user research and developed wireframes focused on content hierarchy. By introducing streamlined navigation paths and a unified color system, we delivered a seamless interactive system.' );
	$case_results   = 'The redesign resulted in immediate positive outcomes, including a 40% reduction in user task completion times, a 25% increase in user retention, and outstanding client feedback on the upgraded interface aesthetics.';
} elseif ( is_page() && get_the_ID() ) {
	// Mode 2: Individual WordPress Page (Pages -> Add New).
	$case_img_default = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/portfolio/project-1.webp' : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' );
	$page_obj      = get_post();
	$case_title    = get_the_title();
	$case_category = __( 'Case Study', 'avantex' );
	$case_image    = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : $case_img_default;
	$case_client   = get_post_meta( get_the_ID(), '_case_client', true );
	if ( empty( $case_client ) ) {
		$case_client = 'Client for ' . $case_title;
	}
	$case_timeline = '2026';
	$case_role     = 'Design & Development';
	$case_tech     = 'WordPress';
	$case_link_url = get_permalink();

	$page_body      = apply_filters( 'the_content', $page_obj->post_content );
	$case_challenge = ! empty( $page_body ) ? $page_body : ( 'No case study details entered yet. Edit this page in WP Admin to add your writeup.' );
	$case_solution  = '';
	$case_results   = '';
} else {
	// Mode 3: Default Project details from unified Portfolio dataset.
	$case_img_default = function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/portfolio/project-1.webp' : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' );
	$first_project = ( is_array( $decoded ) && count( $decoded ) > 0 ) ? $decoded[0] : null;
	$case_title    = ( $first_project && ! empty( $first_project->subtitle ) ) ? $first_project->subtitle : ( ( $first_project && ! empty( $first_project->title ) ) ? $first_project->title : __( 'Featured Project Overview', 'avantex' ) );
	$case_category = ( $first_project && ! empty( $first_project->title ) ) ? $first_project->title : __( 'Portfolio Showcase', 'avantex' );
	$case_image    = ( $first_project && ! empty( $first_project->image_url ) ) ? ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( $first_project->image_url ) : $first_project->image_url ) : $case_img_default;


	$case_client   = ! empty( $first_project->btntitle ) ? $first_project->btntitle : __( 'Enterprise Client', 'avantex' );
	$case_timeline = '3 Months (2026)';
	$case_role     = 'Lead UI/UX & Frontend Development';
	$case_tech     = 'WordPress, HTML5, CSS3, JS';
	$case_link_url = ! empty( $first_project->link ) && '#' !== $first_project->link ? $first_project->link : home_url();

	$case_challenge = ! empty( $first_project->text ) ? $first_project->text : __( 'Consolidated complex user workflows into an intuitive interface, eliminating cognitive load and task friction.', 'avantex' );
	$case_solution  = ! empty( $first_project->text2 ) ? $first_project->text2 : __( 'Designed a modern component system with real-time data flow, clear visual hierarchy, and fast page load speeds.', 'avantex' );
	$case_results   = __( 'Delivered outstanding user adoption lift, reduced task completion times by 45%, and achieved 99% client satisfaction.', 'avantex' );
}
?>

<div class="case-study-template-wrapper">
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<!-- Page Title / Hero Area -->
	<section class="case-study-hero py-4 mb-5">
		<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
			<div class="row align-items-center">
				<div class="col-lg-8 col-md-12">
					<div class="case-study-hero-content pr-lg-5">
						<span class="case-study-badge px-3 py-2 text-uppercase mb-3 d-inline-block"><?php echo esc_html( $case_category ); ?></span>
						<h1 class="title case-study-title mb-4"><b><?php echo esc_html( $case_title ); ?></b></h1>
						<p class="case-study-subtitle lead">A comprehensive look into our design, development, and delivery process.</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 text-lg-right mt-4 mt-lg-0">
					<a href="<?php echo esc_url( $case_link_url ); ?>" target="_blank" class="thm-btn px-4 py-3 btn-lg shadow-sm">
						Launch Project <i class="fas fa-external-link-alt ml-2"></i>
					</a>
				</div>
			</div>
		</div>
	</section>

	<div class="clearfix"></div>

	<!-- Main Details Split Section -->
	<section class="case-study-details py-5">
		<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
			<div class="row">
				<!-- Left Column: Case Writeup -->
				<div class="col-lg-8 col-md-12 pr-lg-5">
					<div class="case-study-content-block mb-5">
						<h3 class="mb-3"><b>The Challenge</b></h3>
						<p class="lead-text"><?php echo wp_kses_post( $case_challenge ); ?></p>
					</div>

					<div class="case-study-content-block mb-5">
						<h3 class="mb-3"><b>Our Approach & Solution</b></h3>
						<p class="lead-text"><?php echo wp_kses_post( $case_solution ); ?></p>
					</div>

					<div class="case-study-content-block mb-5">
						<h3 class="mb-3"><b>The Impact & Results</b></h3>
						<p class="lead-text"><?php echo wp_kses_post( $case_results ); ?></p>
						
						<!-- Highlights Grid -->
						<div class="row mt-4">
							<div class="col-md-4 col-sm-6 mb-3">
								<div class="metric-card p-4 text-center border shadow-sm">
									<h2 class="metric-number mb-1"><b>+40%</b></h2>
									<span class="metric-label text-uppercase small">Efficiency Boost</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 mb-3">
								<div class="metric-card p-4 text-center border shadow-sm">
									<h2 class="metric-number mb-1"><b>-55%</b></h2>
									<span class="metric-label text-uppercase small">Task Friction</span>
								</div>
							</div>
							<div class="col-md-4 col-sm-12 mb-3">
								<div class="metric-card p-4 text-center border shadow-sm">
									<h2 class="metric-number mb-1"><b>100%</b></h2>
									<span class="metric-label text-uppercase small">User Satisfaction</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Right Column: Sidebar Meta Card -->
				<div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
					<div class="case-study-sidebar-card p-5 border shadow-sm sticky-top" style="top: 100px; z-index: 10;">
						<h4 class="mb-4 pb-2 border-bottom"><b>Project Overview</b></h4>
						
						<div class="meta-info-item mb-4">
							<span class="d-block text-uppercase small font-weight-bold">Client</span>
							<strong class="d-block mt-1"><?php echo esc_html( $case_client ); ?></strong>
						</div>
						
						<div class="meta-info-item mb-4">
							<span class="d-block text-uppercase small font-weight-bold">Timeline</span>
							<strong class="d-block mt-1"><?php echo esc_html( $case_timeline ); ?></strong>
						</div>
						
						<div class="meta-info-item mb-4">
							<span class="d-block text-uppercase small font-weight-bold">Our Role</span>
							<strong class="d-block mt-1"><?php echo esc_html( $case_role ); ?></strong>
						</div>
						
						<div class="meta-info-item mb-4">
							<span class="d-block text-uppercase small font-weight-bold">Technologies</span>
							<strong class="d-block mt-1"><?php echo esc_html( $case_tech ); ?></strong>
						</div>

						<a href="<?php echo esc_url( $case_link_url ); ?>" target="_blank" class="thm-btn btn-block py-3 mt-4 text-uppercase font-weight-bold">
							Visit Website <i class="fas fa-chevron-right ml-1"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Image Showcase Gallery Section -->
	<?php if ( ! empty( $case_image ) ) : ?>
		<section class="case-study-gallery py-5 my-5 border-top border-bottom">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				<h3 class="mb-4 text-center"><b>Interface Design & Visual Assets</b></h3>
				<div class="row justify-content-center">
					<div class="col-md-10 text-center">
						<div class="gallery-image-wrapper p-3 shadow-sm border">
							<img src="<?php echo esc_url( $case_image ); ?>" alt="<?php echo esc_attr( $case_title ); ?> Mockup" class="img-fluid">
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- "Other Case Studies" Grid Section -->
	<?php if ( is_array( $decoded ) && count( $decoded ) > 0 ) : ?>
		<section class="other-cases-section py-5 mb-5">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				<div class="row mb-5">
					<div class="col-md-12 text-center">
						<h2 class="section-title"><b>Explore Other Case Studies</b></h2>
						<p>Discover more of our successful digital transformations</p>
						<div class="divider-line mx-auto my-3" style="width: 50px; height: 3px;"></div>
					</div>
				</div>

				<div class="row">
					<?php
					$case_study_pages = get_pages(
						array(
							'meta_key'   => '_wp_page_template',
							'meta_value' => 'reavantex-companion/page-case-study.php',
							'number'     => 1,
						)
					);
					if ( empty( $case_study_pages ) ) {
						$case_study_pages = get_pages(
							array(
								'meta_key'   => '_wp_page_template',
								'meta_value' => 'templates/avantex-case-study.php',
								'number'     => 1,
							)
						);
					}
					$case_study_base_url = ! empty( $case_study_pages ) ? get_permalink( $case_study_pages[0]->ID ) : '#';


					$count = 0;
					foreach ( $decoded as $index => $case_item ) {
						// Skip the current active case study.
						if ( $index === $case_id || ( -1 === $case_id && $case_item->title === $case_title ) ) {
							continue;
						}
						if ( $count >= 3 ) {
							break;
						}
						$c_image = ! empty( $case_item->image_url ) ? ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( $case_item->image_url ) : $case_item->image_url ) : $case_img_default;
						$c_title = ! empty( $case_item->title ) ? $case_item->title : '';
						$c_tag   = ! empty( $case_item->subtitle ) ? $case_item->subtitle : '';
						$c_url   = ( '#' !== $case_study_base_url ) ? add_query_arg( 'case_id', $index, $case_study_base_url ) : '#';

						?>
						<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
							<div class="other-case-card border shadow-sm overflow-hidden h-100 d-flex flex-column transition-card">
								<div class="other-case-img-wrapper" style="position: relative; height: 200px; overflow: hidden;">
									<img src="<?php echo esc_url( $c_image ); ?>" alt="<?php echo esc_attr( $c_title ); ?>" class="w-100 h-100 object-fit-cover" style="object-fit: cover;">
									<div class="other-case-overlay d-flex align-items-center justify-content-center">
										<a href="<?php echo esc_url( $c_url ); ?>" class="thm-btn px-4 py-2 font-weight-bold text-uppercase">View Case Study</a>
									</div>
								</div>
								<div class="other-case-body p-4 flex-grow-1 d-flex flex-column justify-content-between">
									<div>
										<span class="other-case-badge text-uppercase font-weight-bold small d-block mb-2"><?php echo esc_html( $c_tag ); ?></span>
										<h4 class="other-case-title"><b><?php echo esc_html( $c_title ); ?></b></h4>
									</div>
									<a href="<?php echo esc_url( $c_url ); ?>" class="other-case-link text-uppercase font-weight-bold small mt-3 d-inline-block">Read Full Story <i class="fas fa-arrow-right ml-1"></i></a>
								</div>
							</div>
						</div>
						<?php
						++$count;
					}
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>

<?php
get_footer();

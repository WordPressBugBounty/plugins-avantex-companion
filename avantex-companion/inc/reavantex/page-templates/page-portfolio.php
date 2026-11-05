<?php
/**
 * Template Name: Avantex Portfolio
 *
 * @package avantex
 */

if ( ! wp_doing_ajax() ) {
	get_header();
}

// Fetch general settings.
$portfolio_container_class = get_theme_mod( 'avantex-template-portfolio-container', 'container' );
$portfolio_grid_class      = get_theme_mod( 'avantex-portfoliopage-grid', 'col-lg-6' );
$portfolio_show_hero       = get_theme_mod( 'avantex-portfoliopage-show-hero', 1 );
$hero_layout               = get_theme_mod( 'avantex-portfoliopage-hero-layout', 'layout_light' );

$hero_subtitle = get_theme_mod( 'avantex-portfoliopage-hero-subtitle', __( 'Portfolio & Projects', 'avantex' ) );
$hero_title    = get_theme_mod( 'avantex-portfoliopage-hero-title', __( 'Innovative Projects Built with Excellence', 'avantex' ) );
$hero_desc     = get_theme_mod( 'avantex-portfoliopage-hero-desc', __( 'Explore our collection of successful projects and digital products. We work closely with our clients to transform ideas into robust, high-performing solutions.', 'avantex' ) );

// Section Banner Titles.
$viewer_subtitle = get_theme_mod( 'avantex-portfolio-viewer-subtitle', __( 'Interactive Viewer', 'avantex' ) );
$viewer_title    = get_theme_mod( 'avantex-portfolio-viewer-title', __( 'In-Depth Project Breakdown', 'avantex' ) );
$viewer_desc     = get_theme_mod( 'avantex-portfolio-viewer-desc', __( 'Viewing full details for selected project', 'avantex' ) );

// Fetch Repeater (Manage Portfolio items).
$portfolio_default = defined( 'REAVANTEX_PORTFOLIO_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_DEFAULTS : '[]';
$cards_data        = get_theme_mod( 'avantex-portfoliopage-repeater', $portfolio_default );
$decoded_cards = ! empty( $cards_data ) ? json_decode( $cards_data ) : array();
if ( is_array( $decoded_cards ) ) {
	$decoded_cards = apply_filters( 'reavantex_pro_portfolio_items', $decoded_cards );
	$port_max      = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 4;
	if ( count( $decoded_cards ) > $port_max ) {
		$decoded_cards = array_slice( $decoded_cards, 0, $port_max );
	}
}

// Fetch In-Depth Breakdown Writeup Details.
$breakdown_default     = defined( 'REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS' ) ? REAVANTEX_PORTFOLIO_PROJECT_DETAILS_DEFAULTS : '[]';
$breakdown_details_raw = get_theme_mod( 'avantex-portfolio-project-details', $breakdown_default );
$breakdown_details     = ! empty( $breakdown_details_raw ) ? json_decode( $breakdown_details_raw, true ) : array();
if ( empty( $breakdown_details ) || ! is_array( $breakdown_details ) ) {
	$breakdown_details = json_decode( $breakdown_default, true );
}


// Grid section titles and toggle.
$show_grid     = get_theme_mod( 'avantex-portfoliopage-show-grid', 1 );
$grid_subtitle = get_theme_mod( 'avantex-portfoliopage-subtitle', __( 'Featured Works', 'avantex' ) );
$grid_title    = get_theme_mod( 'avantex-portfoliopage-title', __( 'Our Featured Projects', 'avantex' ) );

// Combine into unified Projects dataset.
$projects_dataset = array();
if ( is_array( $decoded_cards ) && count( $decoded_cards ) > 0 ) {
	foreach ( $decoded_cards as $idx => $card ) {
		$card_title    = ! empty( $card->subtitle ) ? $card->subtitle : ( ! empty( $card->title ) ? $card->title : ( 'Project #' . ( $idx + 1 ) ) );
		$card_tag      = ! empty( $card->title ) ? $card->title : __( 'Portfolio', 'avantex' );
		$client        = ! empty( $card->btntitle ) ? $card->btntitle : ( ! empty( $card->button_title ) ? $card->button_title : ( 'Client for ' . $card_title ) );
		$img           = ! empty( $card->image_url ) ? $card->image_url : ( function_exists( 'reavantex_get_asset_url' ) ? reavantex_get_asset_url( 'portfolio/project-1.webp' ) : ( defined( 'AVANTEX_COMPANION_REAVANTEX_URL' ) ? AVANTEX_COMPANION_REAVANTEX_URL . 'assets/images/portfolio/project-1.webp' : get_stylesheet_directory_uri() . '/assets/images/portfolio/project-1.webp' ) );

		$excerpt       = ! empty( $card->text ) ? wp_trim_words( $card->text, 22, '...' ) : ( 'Streamlined user workflows and modernized visual layout hierarchy for ' . $card_title . '.' );
		$card_link_url = ! empty( $card->link ) && '#' !== trim( $card->link ) ? trim( $card->link ) : '';
		$read_btn_text = isset( $card->link2 ) ? trim( $card->link2 ) : 'Read Project';

		// Detailed Writeup fields directly from Customizer breakdown setting.
		$bd = isset( $breakdown_details[ $idx ] ) ? $breakdown_details[ $idx ] : ( isset( $breakdown_details[ (string) $idx ] ) ? $breakdown_details[ (string) $idx ] : array() );

		$detailed_desc  = ! empty( $bd['detailed_desc'] ) ? $bd['detailed_desc'] : ( ! empty( $bd['description'] ) ? $bd['description'] : ( ! empty( $card->text2 ) ? $card->text2 : ( 'Our team conducted extensive user research and architectural planning to build a high-performing digital platform for ' . $card_title . '.' ) ) );
		$challenge      = ! empty( $bd['challenge'] ) ? $bd['challenge'] : ( ! empty( $card->text ) ? $card->text : ( 'The primary challenge for ' . $card_title . ' was to consolidate complex user workflows into a single intuitive interface.' ) );
		$solution       = ! empty( $bd['solution'] ) ? $bd['solution'] : ( 'Our team conducted thorough user research and developed wireframes focused on content hierarchy, introducing streamlined navigation paths and real-time data visualizers.' );
		$metric_1       = ! empty( $bd['metric_1'] ) ? $bd['metric_1'] : '+40% Efficiency Boost';
		$metric_1_label = ! empty( $bd['metric_1_label'] ) ? $bd['metric_1_label'] : __( 'Primary Performance Metric', 'avantex' );
		$metric_2       = ! empty( $bd['metric_2'] ) ? $bd['metric_2'] : '-55% Task Friction';
		$metric_2_label = ! empty( $bd['metric_2_label'] ) ? $bd['metric_2_label'] : __( 'Task Friction Reduction', 'avantex' );
		$quote          = ! empty( $bd['quote'] ) ? $bd['quote'] : ( '"The redesigned platform cut our transaction friction in half and received unanimous praise from our enterprise clients." — ' . $client );
		$timeline       = ! empty( $bd['timeline'] ) ? $bd['timeline'] : '3 Months (2026)';
		$card_role      = ! empty( $bd['role'] ) ? $bd['role'] : 'Lead UI/UX & Full-stack';
		$card_status    = ! empty( $bd['status'] ) ? $bd['status'] : 'Completed & Live';
		$meta_sub       = $client . ' | ' . $timeline . ' | ' . $card_role;
		$showcase_img   = $img;

		$deliv_input      = ! empty( $bd['deliverables'] ) ? $bd['deliverables'] : 'Responsive Design System, API Pipeline Architecture, Micro-interactions Library, User Journey Mapping';
		$deliverables_arr = array_map( 'trim', explode( ',', $deliv_input ) );

		$projects_dataset[] = array(
			'index'          => $idx,
			'title'          => $card_title,
			'tag'            => $card_tag,
			'client'         => $client,
			'meta_sub'       => $meta_sub,
			'img'            => $img,
			'showcase_img'   => $showcase_img,
			'excerpt'        => $excerpt,
			'detailed_desc'  => $detailed_desc,
			'challenge'      => $challenge,
			'solution'       => $solution,
			'deliverables'   => $deliverables_arr,
			'quote'          => $quote,
			'metric_1'       => $metric_1,
			'metric_1_label' => $metric_1_label,
			'metric_2'       => $metric_2,
			'metric_2_label' => $metric_2_label,
			'timeline'       => $timeline,
			'role'           => $card_role,
			'status'         => $card_status,
			'read_btn_text'  => $read_btn_text,
			'link'           => $card_link_url,
		);
	}
}

// Extract unique categories for filter buttons.
$categories = array();
foreach ( $projects_dataset as $p_item ) {
	if ( ! empty( $p_item['tag'] ) ) {
		$categories[] = trim( $p_item['tag'] );
	}
}
$categories = array_unique( $categories );

$initial_project = count( $projects_dataset ) > 0 ? $projects_dataset[0] : null;

// Stats Section Settings.
$show_stats     = get_theme_mod( 'avantex-portfoliopage-show-stats', 1 );
$stats_subtitle = get_theme_mod( 'avantex-portfoliopage-stats-subtitle', __( 'Our Metrics', 'avantex' ) );
$stats_title    = get_theme_mod( 'avantex-portfoliopage-stats-title', __( 'Numbers That Represent Our Success', 'avantex' ) );
$stats_repeater = get_theme_mod( 'avantex-portfoliopage-stats-repeater' );

// Embeds & CTA Settings.
$show_testimonials = get_theme_mod( 'avantex-portfoliopage-show-testimonials', 1 );
$show_sponsors     = get_theme_mod( 'avantex-portfoliopage-show-sponsors', 1 );
$show_cta          = get_theme_mod( 'avantex-portfoliopage-show-cta', 1 );

$cta_title    = get_theme_mod( 'avantex-portfoliopage-cta-title', __( 'Have a Project in Mind? Let’s Build Something Amazing Together', 'avantex' ) );
$cta_desc     = get_theme_mod( 'avantex-portfoliopage-cta-desc', __( 'Partner with our expert design and engineering team to bring your digital vision to life.', 'avantex' ) );
$cta_btn_text = get_theme_mod( 'avantex-portfoliopage-cta-btn-text', __( 'Start a Project Inquiry', 'avantex' ) );
$cta_btn_link = get_theme_mod( 'avantex-portfoliopage-cta-btn-link', '#' );

$show_content = get_theme_mod( 'avantex-portfoliopage-show-content', 1 );
?>

<div id="portfolio-template" class="portfolio-template-wrapper">

	<!-- Page Title Module -->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<div class="clearfix"></div>

	<!-- 1. Hero Section -->
	<?php if ( 1 === intval( $portfolio_show_hero ) ) : ?>
		<?php get_template_part( 'template-parts/portfolio', 'hero' ); ?>
	<?php endif; ?>

	<!-- 2. Portfolio Gallery & Dynamic Project Cards Grid Section -->
	<?php if ( 1 === intval( $show_grid ) ) : ?>
		<section class="portfolio-gallery-section py-5 my-4 wow fadeInUp animated" data-wow-delay="100ms">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				
				<!-- Section Header -->
				<div class="section-header text-center mb-5">
					<p class="section-subtitle small d-block mb-1"><?php echo esc_html( $grid_subtitle ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $grid_title ); ?></b></h2>
					<div class="divider-line mx-auto my-3"></div>
				</div>

				<!-- Category Filter Buttons -->
				<?php if ( count( $categories ) > 0 && function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) : ?>
					<div class="portfolio-filter-wrapper text-center mb-5">
						<div class="portfolio-filter-buttons" role="group">
							<button type="button" class="portfolio-filter-btn active" data-filter="all">All Projects</button>
							<?php foreach ( $categories as $filter_cat ) : ?>
								<button type="button" class="portfolio-filter-btn" data-filter="<?php echo esc_attr( sanitize_title( $filter_cat ) ); ?>"><?php echo esc_html( $filter_cat ); ?></button>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Projects Grid Cards -->
				<div class="row portfolio-grid-wrapper">
					<?php
					foreach ( $projects_dataset as $p_item ) :
						$cat_slug = sanitize_title( $p_item['tag'] );
						?>
						<div class="<?php echo esc_attr( $portfolio_grid_class ); ?> col-md-6 col-sm-12 mb-4 portfolio-filter-item cat-<?php echo esc_attr( $cat_slug ); ?>">
							<div class="project-card-item h-100 border overflow-hidden shadow-sm transition-all d-flex flex-column" data-project-index="<?php echo esc_attr( $p_item['index'] ); ?>">
								<div class="project-card-img-wrapper position-relative overflow-hidden">
									<img src="<?php echo esc_url( $p_item['img'] ); ?>" alt="<?php echo esc_attr( $p_item['title'] ); ?>" class="project-card-img w-100 transition-scale">
									<div class="project-card-tag-overlay position-absolute top-0 left-0 m-3">
										<span class="badge badge-portfolio-tag px-3 py-2 text-uppercase font-weight-bold shadow-sm"><?php echo esc_html( $p_item['tag'] ); ?></span>
									</div>
								</div>
								<div class="project-card-content p-4 d-flex flex-column flex-grow-1 justify-content-between">
									<div>
										<span class="text-uppercase font-weight-bold small d-block mb-1 tracking-wider project-card-client"><?php echo esc_html( $p_item['client'] ); ?></span>
										<h4 class="project-card-title font-weight-bold mb-2"><b><?php echo esc_html( $p_item['title'] ); ?></b></h4>
										<p class="project-card-desc small mb-3 text-clamp-2"><?php echo esc_html( $p_item['excerpt'] ); ?></p>
									</div>
									<div class="project-card-footer pt-3 border-top d-flex justify-content-between align-items-center mt-auto">
										<?php if ( ! empty( $p_item['read_btn_text'] ) ) : ?>
											<?php if ( ! empty( $p_item['link'] ) ) : ?>
												<a href="<?php echo esc_url( $p_item['link'] ); ?>" class="px-3 read-project-trigger btn thm-btn shadow-none py-1 border-0" target="_blank">
													<?php echo esc_html( $p_item['read_btn_text'] ); ?>
												</a>
											<?php else : ?>
												<button type="button" class="px-3 read-project-trigger">
													<?php echo esc_html( $p_item['read_btn_text'] ); ?>
												</button>
											<?php endif; ?>
										<?php endif; ?>
										<?php if ( ! empty( $p_item['metric_1'] ) ) : ?>
											<span class="project-card-metric font-weight-bold px-2"><i class="fas fa-chart-line mr-1"></i> <?php echo esc_html( $p_item['metric_1'] ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
	<?php endif; ?>

	<!-- Interactive In-Page Detailed Project Breakdown Viewer (Hidden by default) -->
	<?php if ( $initial_project ) : ?>
		<section id="project-detail-viewer" class="project-viewer-section py-5 border-top border-bottom" style="display: none;">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				
				<!-- Section Banner Title -->
				<div class="row mb-4 text-center">
					<div class="col-md-12">
						<span class="section-subtitle text-uppercase font-weight-bold small d-block mb-1" id="v-sec-subtitle"><?php echo esc_html( $viewer_subtitle ); ?></span>
						<h2 class="section-title"><b><span id="v-sec-title"><?php echo esc_html( $viewer_title ); ?></span></b></h2>
						<p class="small" id="v-sec-desc"><?php echo esc_html( $viewer_desc ); ?></p>
					</div>
				</div>

				<div class="viewer-card p-4 p-lg-5 border shadow-lg position-relative">
					
					<!-- Header Bar inside Viewer -->
					<div class="row align-items-center mb-4 pb-3 border-bottom">
						<div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
							<span class="text-uppercase mb-2 viewer-tag"><?php echo esc_html( $initial_project['tag'] ); ?></span>
							<h2 class="viewer-title mb-1"><b><span id="v-title"><?php echo esc_html( $initial_project['title'] ); ?></span></b></h2>
							<span class="small font-weight-bold text-uppercase d-block" id="v-meta-sub"><?php echo esc_html( $initial_project['meta_sub'] ); ?></span>
						</div>
						<div class="col-lg-4 col-md-12 text-lg-right d-flex gap-3 align-items-center justify-content-lg-end">
							<a href="<?php echo esc_url( $initial_project['link'] ); ?>" id="v-link" target="_blank" class="btn thm-btn px-3 py-2 font-weight-bold mr-3 viewer-launch-btn">
								Launch Project <i class="fas fa-external-link-alt ml-1 small"></i>
							</a>
							<div class="viewer-nav-group btn-group border p-1 mr-2 shadow-sm">
								<button type="button" class="btn thm-btn viewer-nav-btn px-2 py-1 mr-1" id="v-prev-btn" title="Previous Project"><i class="fas fa-chevron-left"></i></button>
								<button type="button" class="btn thm-btn viewer-nav-btn px-2 py-1" id="v-next-btn" title="Next Project"><i class="fas fa-chevron-right"></i></button>
							</div>
							<button type="button" class="btn thm-btn viewer-close-btn" id="v-close-btn" title="Close Breakdown"><i class="fas fa-times"></i></button>
						</div>
					</div>

					<!-- Viewer Split Content -->
					<div class="row">
						<!-- Left Column: Detailed Description, Challenge, Solution, Deliverables & Quote -->
						<div class="col-lg-8 col-md-12 pr-lg-5">
							
							<!-- Detailed Project Description -->
							<div class="viewer-block mb-4 p-4 border">
								<h4 class="mb-3"><b><i class="fas fa-file-alt mr-2"></i> Detailed Project Description</b></h4>
								<p class="lead-text" id="v-detailed-desc"><?php echo wp_kses_post( $initial_project['detailed_desc'] ); ?></p>
							</div>

							<!-- Challenge -->
							<div class="viewer-block mb-4 p-4 border">
								<h4 class="mb-3"><b><i class="fas fa-bullseye mr-2"></i> The Challenge</b></h4>
								<p class="lead-text" id="v-challenge"><?php echo wp_kses_post( $initial_project['challenge'] ); ?></p>
							</div>

							<!-- Approach & Solution -->
							<div class="viewer-block mb-4 p-4 border">
								<h4 class="mb-3"><b><i class="fas fa-lightbulb mr-2"></i> Our Approach & Solution</b></h4>
								<p class="lead-text" id="v-solution"><?php echo wp_kses_post( $initial_project['solution'] ); ?></p>
							</div>

							<!-- Key Deliverables & Tech Stack -->
							<div class="viewer-block mb-4 p-4 border">
								<h4 class="mb-3"><b><i class="fas fa-cubes mr-2"></i> Key Deliverables</b></h4>
								<div class="deliverables-pills-wrapper d-flex flex-wrap" id="v-deliverables">
									<?php foreach ( $initial_project['deliverables'] as $d_item ) : ?>
										<span class="badge-deliverable p-2"><i class="fas fa-check mr-1"></i> <?php echo esc_html( $d_item ); ?></span>
									<?php endforeach; ?>
								</div>
							</div>

							<!-- Quantifiable Results Metrics -->
							<div class="row mb-4">
								<div class="col-sm-6 mb-3">
									<div class="metric-card p-4 text-center border shadow-sm">
										<h3 class="metric-number mb-1"><b><span id="v-metric1"><?php echo esc_html( $initial_project['metric_1'] ); ?></span></b></h3>
										<span class="metric-label text-uppercase small font-weight-bold" id="v-metric1-label"><?php echo esc_html( $initial_project['metric_1_label'] ); ?></span>
									</div>
								</div>
								<div class="col-sm-6 mb-3">
									<div class="metric-card p-4 text-center border shadow-sm">
										<h3 class="metric-number mb-1"><b><span id="v-metric2"><?php echo esc_html( $initial_project['metric_2'] ); ?></span></b></h3>
										<span class="metric-label text-uppercase small font-weight-bold" id="v-metric2-label"><?php echo esc_html( $initial_project['metric_2_label'] ); ?></span>
									</div>
								</div>
							</div>

							<!-- Testimonial Quote -->
							<div class="viewer-quote-box p-2 border-left position-relative">
								<i class="fas fa-quote-left mb-2 opacity-50 display-6 d-block"></i>
								<p class="mb-0" id="v-quote"><?php echo esc_html( $initial_project['quote'] ); ?></p>
							</div>

						</div>

						<!-- Right Column: Sticky Overview Sidebar & Mockup -->
						<div class="col-lg-4 col-md-12 mt-4 mt-lg-0">
							<div class="overview-sidebar-card p-4 border mb-4 shadow-sm">
								<h5 class="mb-3 font-weight-bold pb-2 border-bottom"><i class="fas fa-info-circle mr-2"></i> Project Overview</h5>
								<div class="sidebar-meta-item py-2 border-bottom d-flex justify-content-between">
									<span class="font-weight-bold">Client:</span>
									<span id="v-client"><?php echo esc_html( $initial_project['client'] ); ?></span>
								</div>
								<div class="sidebar-meta-item py-2 border-bottom d-flex justify-content-between">
									<span class="font-weight-bold">Timeline:</span>
									<span id="v-timeline"><?php echo esc_html( $initial_project['timeline'] ); ?></span>
								</div>
								<div class="sidebar-meta-item py-2 border-bottom d-flex justify-content-between">
									<span class="font-weight-bold">Role:</span>
									<span id="v-role"><?php echo esc_html( $initial_project['role'] ); ?></span>
								</div>
								<div class="sidebar-meta-item py-2 d-flex justify-content-between">
									<span class="font-weight-bold">Status:</span>
									<span id="v-status"><?php echo esc_html( $initial_project['status'] ); ?></span>
								</div>
							</div>

							<div class="viewer-mockup-wrapper border overflow-hidden shadow-sm">
								<img src="<?php echo esc_url( $initial_project['showcase_img'] ); ?>" id="v-img" alt="Project Mockup" class="w-100 img-fluid">
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 3. Portfolio Statistics Counter Section -->
	<?php
	if ( 1 === intval( $show_stats ) ) :
		$stats_data = array();
		if ( ! empty( $stats_repeater ) ) {
			$stats_data = json_decode( $stats_repeater );
		}
		if ( empty( $stats_data ) || ! is_array( $stats_data ) ) {
			$stats_data = array(
				(object) array(
					'icon_value' => 'fas fa-check-circle',
					'title'      => '150',
					'subtitle'   => 'Projects Completed',
					'text'       => '+',
				),
				(object) array(
					'icon_value' => 'fas fa-smile',
					'title'      => '99',
					'subtitle'   => 'Client Satisfaction',
					'text'       => '%',
				),
				(object) array(
					'icon_value' => 'fas fa-trophy',
					'title'      => '15',
					'subtitle'   => 'Design Awards',
					'text'       => '+',
				),
				(object) array(
					'icon_value' => 'fas fa-calendar-alt',
					'title'      => '8',
					'subtitle'   => 'Years Experience',
					'text'       => '+',
				),
			);
		}
		if ( is_array( $stats_data ) ) {
			$stats_data = apply_filters( 'reavantex_pro_portfolio_stats', $stats_data );
			$stats_max  = ( function_exists( 'reavantex_is_pro' ) && reavantex_is_pro() ) ? 999 : 4;
			if ( count( $stats_data ) > $stats_max ) {
				$stats_data = array_slice( $stats_data, 0, $stats_max );
			}
		}
		?>
		<section class="portfolio-stats-section py-5 my-4 border-top border-bottom wow fadeInUp animated" data-wow-delay="100ms">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				<div class="section-header text-center mb-5">
					<p class="section-subtitle text-uppercase font-weight-bold small d-block mb-1"><?php echo esc_html( $stats_subtitle ); ?></p>
					<h2 class="section-title"><b><?php echo esc_html( $stats_title ); ?></b></h2>
					<div class="divider-line mx-auto my-3" style="width: 50px; height: 3px;"></div>
				</div>
				
				<div class="row text-center">
					<?php
					foreach ( $stats_data as $stat ) :
						$s_icon  = ! empty( $stat->icon_value ) ? $stat->icon_value : 'fas fa-chart-bar';
						$s_num   = ! empty( $stat->title ) ? $stat->title : '0';
						$s_label = ! empty( $stat->subtitle ) ? $stat->subtitle : '';
						$s_suff  = isset( $stat->text ) ? $stat->text : '';
						?>
						<div class="col-lg-3 col-md-6 col-sm-12 mb-4">
							<div class="portfolio-stat-card p-4 border shadow-sm">
								<div class="portfolio-stat-icon mb-3" style="font-size: 2.2rem;">
									<i class="<?php echo esc_attr( $s_icon ); ?>"></i>
								</div>
								<div class="portfolio-stat-number mb-2 h2 font-weight-bold">
									<span class="counter"><?php echo esc_html( $s_num ); ?></span><?php echo esc_html( $s_suff ); ?>
								</div>
								<h5 class="portfolio-stat-label mb-0 font-weight-normal"><?php echo esc_html( $s_label ); ?></h5>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 4. Testimonials & Sponsors Embed Section -->
	<?php if ( 1 === intval( $show_testimonials ) ) : ?>
		<div class="portfolio-testimonials-embed py-4">
			<?php get_template_part( 'avantex-index/index', 'testimonial' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( 1 === intval( $show_sponsors ) ) : ?>
		<div class="portfolio-sponsors-embed py-4">
			<?php get_template_part( 'avantex-index/index', 'sponsor' ); ?>
		</div>
	<?php endif; ?>

	<!-- 5. Call to Action Section -->
	<?php if ( 1 === intval( $show_cta ) ) : ?>
		<section class="portfolio-cta-section py-5 my-4 wow fadeInUp animated" data-wow-delay="200ms">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				<div class="row justify-content-center text-center">
					<div class="col-lg-10">
						<div class="portfolio-cta-box p-5 shadow">
							<h2 class="cta-title my-2 font-weight-bold"><b><?php echo esc_html( $cta_title ); ?></b></h2>
							<p class="cta-desc mb-4 mx-auto max-w-700"><?php echo esc_html( $cta_desc ); ?></p>
							<div class="cta-btn-wrapper">
								<a href="<?php echo esc_url( $cta_btn_link ); ?>" class="thm-btn portfolio-cta-btn"><?php echo esc_html( $cta_btn_text ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- 6. Page Content Area (WP Editor) -->
	<?php if ( 1 === intval( $show_content ) ) : ?>
		<div class="portfolio-user-content-wrapper my-5 pt-3">
			<div class="<?php echo esc_attr( $portfolio_container_class ); ?>">
				<div class="row justify-content-center">
					<div class="col-lg-10">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								if ( get_the_content() ) :
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
	<?php endif; ?>

	<!-- Interactive In-Page Viewer JS Engine -->
	<script type="text/javascript">
		var projectsData = <?php echo wp_json_encode( $projects_dataset ); ?>;
		var currentProjectIdx = 0;

		function loadProjectIntoViewer(idx) {
			if (!projectsData || !projectsData[idx]) return;
			var item = projectsData[idx];
			currentProjectIdx = idx;

			jQuery('#v-title').text(item.title);
			jQuery('#v-meta-sub').text(item.meta_sub);
			jQuery('#v-detailed-desc').text(item.detailed_desc || '');
			jQuery('#v-challenge').text(item.challenge);
			jQuery('#v-solution').text(item.solution);
			jQuery('#v-metric1').text(item.metric_1);
			jQuery('#v-metric1-label').text(item.metric_1_label || 'Primary Performance Metric');
			jQuery('#v-metric2').text(item.metric_2);
			jQuery('#v-metric2-label').text(item.metric_2_label || 'Task Friction Reduction');
			jQuery('#v-client').text(item.client);
			jQuery('#v-timeline').text(item.timeline || '3 Months (2026)');
			jQuery('#v-role').text(item.role || 'Lead UI/UX & Full-stack');
			jQuery('#v-status').text(item.status || 'Completed & Live');
			jQuery('#v-quote').text(item.quote);
			jQuery('#v-img').attr('src', item.showcase_img);
			jQuery('#v-link').attr('href', item.link);
			jQuery('.viewer-tag').text(item.tag);

			var delivHtml = '';
			if (item.deliverables && item.deliverables.length) {
				jQuery.each(item.deliverables, function(i, dText) {
					if (dText) {
						delivHtml += '<span class="badge-deliverable p-2"><i class="fas fa-check mr-1"></i> ' + dText + '</span>';
					}
				});
			}
			jQuery('#v-deliverables').html(delivHtml);
			jQuery('.project-card-item').removeClass('active-project-card');
			jQuery('.project-card-item[data-project-index="' + idx + '"]').addClass('active-project-card');
		}

		jQuery(document).ready(function($) {
			// Click on Read Project button only
			$('body').off('click.projectCardTrigger').on('click.projectCardTrigger', '.read-project-trigger', function(e) {
				var $btn = $(this);
				if ($btn.is('a') && $btn.attr('href') && $btn.attr('href') !== '#') {
					return; // Allow standard navigation for custom link
				}
				e.preventDefault();
				e.stopPropagation();
				var $card = $btn.closest('.project-card-item');
				var idx = parseInt($card.data('project-index'));
				if (!isNaN(idx)) {
					loadProjectIntoViewer(idx);
					$('#project-detail-viewer').slideDown(400, function() {
						$('html, body').animate({
							scrollTop: $('#project-detail-viewer').offset().top - 80
						}, 400);
					});
				}
			});

			// Prev / Next buttons inside viewer
			$('#v-prev-btn').on('click', function() {
				var nextIdx = (currentProjectIdx - 1 + projectsData.length) % projectsData.length;
				loadProjectIntoViewer(nextIdx);
			});
			$('#v-next-btn').on('click', function() {
				var nextIdx = (currentProjectIdx + 1) % projectsData.length;
				loadProjectIntoViewer(nextIdx);
			});
			$('#v-close-btn').on('click', function() {
				$('#project-detail-viewer').slideUp(400);
			});

			// Category filter buttons
			$('body').off('click.projectsFilter').on('click.projectsFilter', '.portfolio-filter-buttons .portfolio-filter-btn', function() {
				var filterVal = $(this).data('filter');
				var $wrapper = $(this).closest('#portfolio-template');
				
				$wrapper.find('.portfolio-filter-buttons .portfolio-filter-btn').removeClass('active');
				$(this).addClass('active');

				if (filterVal === 'all') {
					$wrapper.find('.portfolio-filter-item').removeClass('filtered-out');
				} else {
					$wrapper.find('.portfolio-filter-item').each(function() {
						if ($(this).hasClass('cat-' + filterVal)) {
							$(this).removeClass('filtered-out');
						} else {
							$(this).addClass('filtered-out');
						}
					});
				}
			});
		});
	</script>
</div>

<?php
if ( ! wp_doing_ajax() ) {
	get_footer();
}
?>

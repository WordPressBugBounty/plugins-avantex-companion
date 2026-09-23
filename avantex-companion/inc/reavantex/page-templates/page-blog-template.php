<?php
/**
 * Template Name: Avantex Blog Template
 *
 * @package avantex
 */

get_header();
?>	
	<!--Page Title-->
	<?php get_template_part( 'template-parts/title', 'module' ); ?>
	<!--/ Page Title-->

	<div class="clearfix"></div>

	<?php
	// Load Customizer Settings.
	$layout          = get_theme_mod( 'avantex-blog-template-layout', 'grid' );
	$columns         = get_theme_mod( 'avantex-blog-template-columns', '3' );
	$sidebar_pos     = get_theme_mod( 'avantex-blog-template-sidebar', 'right-sidebar' );
	$container_class = get_theme_mod( 'avantex-blog-template-container', 'container' );
	$posts_per_page  = get_theme_mod( 'avantex-blog-template-posts-per-page', '9' );

	$my_paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => intval( $posts_per_page ),
		'paged'               => $my_paged,
		'ignore_sticky_posts' => true,
	);

	$query = new WP_Query( $args );

	$section_class = ( 'grid' === $layout ) ? 'blog-grid' : 'site-content';

	if ( 'none-sidebar' === $sidebar_pos ) {
		$content_cols = 'col-md-12 col-sm-12 col-xs-12';
		$sidebar_cols = '';
	} elseif ( 'grid' === $layout ) {
		$content_cols = 'col-lg-9 col-md-8 col-sm-12';
		$sidebar_cols = 'col-lg-3 col-md-4 col-sm-12';
	} else {
		$content_cols = 'col-md-8 col-sm-8 col-xs-12';
		$sidebar_cols = 'col-md-4 col-sm-4 col-xs-12';
	}

	$grid_col = 'col-xl-4 col-lg-4 col-md-6'; // 3 columns default
	if ( '2' === $columns ) {
		$grid_col = 'col-xl-6 col-lg-6 col-md-6';
	} elseif ( '4' === $columns ) {
		$grid_col = 'col-xl-3 col-lg-3 col-md-6';
	}
	?>

	<!-- Blog Section -->
	<section id="blog-template-section" class="blog-template-section py-5 <?php echo esc_attr( $section_class ); ?>">
		<div class="<?php echo esc_attr( $container_class ); ?>">
			<div class="row">
				<!--Sidebar Left-->
				<?php if ( 'left-sidebar' === $sidebar_pos ) { ?>
					<div class="<?php echo esc_attr( $sidebar_cols ); ?>">
						<div class="sidebar space-right">
							<?php get_sidebar( 'avantex_blogwidget' ); ?>
						</div>
					</div>
				<?php } ?>

				<!--Blog Posts-->
				<div class="<?php echo esc_attr( $content_cols ); ?>">
					<div class="blog">
						<?php if ( 'grid' === $layout ) { ?>
							<div class="row baseline">
								<?php
								if ( $query->have_posts() ) :
									while ( $query->have_posts() ) :
										$query->the_post();
										?>
										<div class="<?php echo esc_attr( $grid_col ); ?> wow fadeInUp animated" data-wow-delay="0ms" data-wow-duration="1500ms">
											<article class="post">
												<figure class="post-thumbnail">
													<a href="<?php the_permalink(); ?>"><?php reavantex_post_thumbnail( 'large' ); ?></a>
												</figure>
												<div class="blog-head">
													<div class="news-date">
														<span><?php echo get_the_date( 'F - j' ); ?></span>
													</div>
													<div class="entry-meta">
														<?php $avantex_author_name = get_the_author_meta( 'display_name' ); ?>
														<span class="byline"> by <span class="author vcard"><a class="url fn n" href="#"><?php echo esc_html( $avantex_author_name ); ?></a></span></span>
													</div>
													<header class="entry-header">
														<?php $post_title_trimmed = wp_trim_words( get_the_title(), 8, '...' ); ?>
														<h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html( $post_title_trimmed ); ?></a></h5>
													</header>
												</div>

												<div class="full-content">
													<div class="entry-content">
														<?php
														$avantex_post_excerpt  = get_the_excerpt();
														$avantex_post_excerpt  = substr( $avantex_post_excerpt, 0, 160 );
														$avantex_exerpt_result = substr( $avantex_post_excerpt, 0, strrpos( $avantex_post_excerpt, ' ' ) );
														?>
														<p><?php echo esc_html( $avantex_exerpt_result ); ?></p>
														<p><a href="<?php the_permalink(); ?>" class="more-link">READ MORE</a></p>
													</div>
												</div>
											</article>
										</div>
										<?php
									endwhile;
								else :
									get_template_part( 'template-parts/content-none', get_post_type() );
								endif;
								?>
							</div>
						<?php } else { ?>
							<?php
							if ( $query->have_posts() ) :
								while ( $query->have_posts() ) :
									$query->the_post();
									get_template_part( 'template-parts/content', get_post_type() );
								endwhile;
							else :
								get_template_part( 'template-parts/content-none', get_post_type() );
							endif;
							?>
						<?php } ?>
					</div>

					<?php if ( $query->max_num_pages > 1 ) { ?>
						<nav class="navigation pagination" aria-label="Posts">
							<h2 class="screen-reader-text">Posts navigation</h2>
							<div class="nav-links">
								<?php
								$big = 999999999;
								echo wp_kses_post(
									paginate_links(
										array(
											'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
											'format'    => '?paged=%#%',
											'current'   => $my_paged,
											'total'     => $query->max_num_pages,
											'prev_text' => '&laquo;',
											'next_text' => '&raquo;',
										)
									)
								);
								?>
							</div>
						</nav>
					<?php } ?>
				</div>
				<!--/Blog Posts-->

				<!--Sidebar Right-->
				<?php if ( 'right-sidebar' === $sidebar_pos ) { ?>
					<div class="<?php echo esc_attr( $sidebar_cols ); ?>">
						<div class="sidebar space-left">
							<?php get_sidebar( 'avantex_blogwidget' ); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>

	<?php wp_reset_postdata(); ?>

	<div class="clearfix"></div>

<?php
get_footer();

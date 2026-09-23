<?php
/**
 * ReAvantex Default Content & Setup Engine
 *
 * Automatically creates default pages with their proper page templates,
 * configures WordPress reading settings, sets up the primary navigation menu,
 * starter blog posts, and default widgets upon Avantex Companion activation.
 *
 * @package avantex-companion
 * @since   0.2.6
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup default theme pages with their assigned templates.
 *
 * @return void
 */
function reavantex_companion_setup_default_pages() {
	if ( get_option( 'reavantex_default_pages_created' ) ) {
		return;
	}

	$default_privacy_content = '<h2>1. Information Collection</h2><p>We collect information you provide directly to us when you register, make a purchase, subscribe to our newsletter, or contact our support team. This may include your name, email address, phone number, and transaction details.</p><h2>2. How We Use Your Information</h2><p>We use the information we collect to deliver, maintain, and enhance our services, process customer transactions, send service updates, and communicate important account notifications.</p><h2>3. Data Protection and Security</h2><p>We implement industry-standard administrative, technical, and physical safeguards designed to protect your personal information against unauthorized access, loss, or alteration.</p><h2>4. Third-Party Disclosures</h2><p>We do not sell or trade your personal information. We may share necessary data with trusted service providers who assist us in operating our website and conducting our business under confidentiality agreements.</p><h2>5. Cookies and Tracking Technologies</h2><p>We use cookies and similar technologies to enhance navigation, analyze site performance, and deliver personalized user experiences. You can control cookie preferences through your browser settings.</p><h2>6. Your Privacy Rights</h2><p>You have the right to access, update, or request the deletion of your personal data at any time by contacting our data protection team.</p>';

	$default_terms_content = '<h2>1. Acceptance of Terms</h2><p>By accessing or using our website and services, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using or accessing this site.</p><h2>2. Use License and Restrictions</h2><p>Permission is granted to temporarily view the materials on this website for personal, non-commercial transitory viewing only. You may not modify or copy the materials, use them for commercial purposes, or attempt to decompile or reverse engineer any software contained on the website.</p><h2>3. User Account and Responsibilities</h2><p>If you create an account on our platform, you are responsible for maintaining the confidentiality of your credentials and for all activities that occur under your account.</p><h2>4. Intellectual Property Rights</h2><p>All content, features, branding, logos, and functionality on this website are the exclusive property of our company and are protected by international copyright, trademark, and other intellectual property laws.</p><h2>5. Disclaimer of Warranties</h2><p>The materials on this website are provided on an "as is" and "as available" basis without any warranties of any kind, either expressed or implied, including fitness for a particular purpose.</p><h2>6. Limitation of Liability</h2><p>In no event shall our company or its partners be liable for any damages arising out of the use or inability to use the materials on this website.</p><h2>7. Modifications and Governing Law</h2><p>We reserve the right to revise these terms of service at any time without prior notice. By continuing to use this website, you agree to be bound by the current version of these terms.</p>';

	$theme_pages = array(
		array(
			'title'    => __( 'Home', 'avantex-companion' ),
			'slug'     => 'home',
			'template' => 'templates/avantex-frontpage.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'About', 'avantex-companion' ),
			'slug'     => 'about',
			'template' => 'reavantex-companion/page-about-us.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'Services', 'avantex-companion' ),
			'slug'     => 'services',
			'template' => 'reavantex-companion/page-services.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'Portfolio', 'avantex-companion' ),
			'slug'     => 'portfolio',
			'template' => 'reavantex-companion/page-portfolio.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'Blog', 'avantex-companion' ),
			'slug'     => 'blog',
			'template' => 'default',
			'content'  => '',
		),
		array(
			'title'    => __( 'Contact', 'avantex-companion' ),
			'slug'     => 'contact',
			'template' => 'reavantex-companion/page-contact-us.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'FAQ', 'avantex-companion' ),
			'slug'     => 'faq',
			'template' => 'reavantex-companion/page-faq.php',
			'content'  => '',
		),
		array(
			'title'    => __( 'Privacy Policy', 'avantex-companion' ),
			'slug'     => 'privacy-policy',
			'template' => 'reavantex-companion/page-privacy-policy.php',
			'content'  => $default_privacy_content,
		),
		array(
			'title'    => __( 'TOS', 'avantex-companion' ),
			'slug'     => 'terms-of-service',
			'template' => 'reavantex-companion/page-terms-of-service.php',
			'content'  => $default_terms_content,
		),
		array(
			'title'    => __( 'Case Study', 'avantex-companion' ),
			'slug'     => 'case-study',
			'template' => 'reavantex-companion/page-case-study.php',
			'content'  => '',
		),
	);

	$page_ids = array();

	foreach ( $theme_pages as $page_data ) {
		$existing_page = get_page_by_path( $page_data['slug'] );

		// Fallback slug checks for existing installations.
		if ( ! $existing_page && 'about' === $page_data['slug'] ) {
			$existing_page = get_page_by_path( 'about-us' );
		}
		if ( ! $existing_page && 'contact' === $page_data['slug'] ) {
			$existing_page = get_page_by_path( 'contact-us' );
		}
		if ( ! $existing_page && 'terms-of-service' === $page_data['slug'] ) {
			$existing_page = get_page_by_path( 'tos' );
		}

		if ( ! $existing_page ) {
			$page_id = wp_insert_post(
				array(
					'post_title'   => $page_data['title'],
					'post_name'    => $page_data['slug'],
					'post_content' => $page_data['content'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_author'  => 1,
				)
			);

			if ( ! is_wp_error( $page_id ) ) {
				$page_ids[ $page_data['slug'] ] = $page_id;
				if ( ! empty( $page_data['template'] ) && 'default' !== $page_data['template'] ) {
					update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
				}
			}
		} else {
			$page_ids[ $page_data['slug'] ] = $existing_page->ID;
			if ( ! empty( $page_data['template'] ) && 'default' !== $page_data['template'] ) {
				update_post_meta( $existing_page->ID, '_wp_page_template', $page_data['template'] );
			}
			// If existing page has empty content and starter content is available, populate it.
			if ( empty( trim( $existing_page->post_content ) ) && ! empty( $page_data['content'] ) ) {
				wp_update_post(
					array(
						'ID'           => $existing_page->ID,
						'post_content' => $page_data['content'],
					)
				);
			}
		}
	}

	// Configure WordPress Reading Settings.
	if ( ! empty( $page_ids['home'] ) && ! empty( $page_ids['blog'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_ids['home'] );
		update_option( 'page_for_posts', $page_ids['blog'] );
	}

	update_option( 'reavantex_default_pages_created', true );

	// Setup navigation menu and widgets.
	reavantex_companion_setup_default_menu();
	reavantex_companion_setup_default_widgets();
}

/**
 * Setup default navigation menu with direct links to newly created pages.
 *
 * Header Menu: Home, About, Services, Portfolio, Blog, Contact
 * Footer Menu: Contact, FAQ, Privacy Policy, TOS
 *
 * @return void
 */
function reavantex_companion_setup_default_menu() {
	$menu_name   = 'ReAvantex Header Menu';
	$menu_exists = wp_get_nav_menu_object( $menu_name );

	if ( $menu_exists ) {
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		if ( empty( $locations['primary'] ) ) {
			$locations['primary'] = $menu_exists->term_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
		if ( get_option( 'reavantex_default_menu_created' ) ) {
			return;
		}
	}

	if ( get_option( 'reavantex_default_menu_created' ) ) {
		return;
	}

	$menu_id = $menu_exists ? $menu_exists->term_id : wp_create_nav_menu( $menu_name );

	// Helper URLs resolution.
	$about_page   = get_page_by_path( 'about' );
	if ( ! $about_page ) {
		$about_page = get_page_by_path( 'about-us' );
	}
	$about_url    = $about_page ? get_permalink( $about_page->ID ) : home_url( '/about/' );

	$services_page = get_page_by_path( 'services' );
	$services_url  = $services_page ? get_permalink( $services_page->ID ) : home_url( '/services/' );

	$portfolio_page = get_page_by_path( 'portfolio' );
	$portfolio_url  = $portfolio_page ? get_permalink( $portfolio_page->ID ) : home_url( '/portfolio/' );

	$blog_page = get_page_by_path( 'blog' );
	$blog_url  = $blog_page ? get_permalink( $blog_page->ID ) : home_url( '/blog/' );

	$contact_page = get_page_by_path( 'contact' );
	if ( ! $contact_page ) {
		$contact_page = get_page_by_path( 'contact-us' );
	}
	$contact_url  = $contact_page ? get_permalink( $contact_page->ID ) : home_url( '/contact/' );

	if ( ! is_wp_error( $menu_id ) ) {
		// Header Menu: Home, About, Services, Portfolio, Blog, Contact (sequence maintained).
		$menu_items = array(
			array(
				'title' => __( 'Home', 'avantex-companion' ),
				'url'   => home_url( '/' ),
			),
			array(
				'title' => __( 'About', 'avantex-companion' ),
				'url'   => $about_url,
			),
			array(
				'title' => __( 'Services', 'avantex-companion' ),
				'url'   => $services_url,
			),
			array(
				'title' => __( 'Portfolio', 'avantex-companion' ),
				'url'   => $portfolio_url,
			),
			array(
				'title' => __( 'Blog', 'avantex-companion' ),
				'url'   => $blog_url,
			),
			array(
				'title' => __( 'Contact', 'avantex-companion' ),
				'url'   => $contact_url,
			),
		);

		$order = 1;
		foreach ( $menu_items as $item ) {
			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-title'    => $item['title'],
					'menu-item-url'      => $item['url'],
					'menu-item-status'   => 'publish',
					'menu-item-type'     => 'custom',
					'menu-item-position' => $order,
				)
			);
			++$order;
		}
	}

	// Create and populate ReAvantex Footer Menu.
	// Footer Menu: Contact, FAQ, Privacy Policy, TOS
	$footer_menu_name   = 'ReAvantex Footer Menu';
	$footer_menu_exists = wp_get_nav_menu_object( $footer_menu_name );
	$footer_menu_id     = $footer_menu_exists ? $footer_menu_exists->term_id : wp_create_nav_menu( $footer_menu_name );

	if ( ! is_wp_error( $footer_menu_id ) && ! $footer_menu_exists ) {
		$faq_page     = get_page_by_path( 'faq' );
		$faq_url      = $faq_page ? get_permalink( $faq_page->ID ) : home_url( '/faq/' );

		$privacy_page = get_page_by_path( 'privacy-policy' );
		$privacy_url  = $privacy_page ? get_permalink( $privacy_page->ID ) : home_url( '/privacy-policy/' );

		$tos_page     = get_page_by_path( 'terms-of-service' );
		if ( ! $tos_page ) {
			$tos_page = get_page_by_path( 'tos' );
		}
		$tos_url      = $tos_page ? get_permalink( $tos_page->ID ) : home_url( '/terms-of-service/' );

		$footer_items = array(
			array(
				'title' => __( 'Contact', 'avantex-companion' ),
				'url'   => $contact_url,
			),
			array(
				'title' => __( 'FAQ', 'avantex-companion' ),
				'url'   => $faq_url,
			),
			array(
				'title' => __( 'Privacy Policy', 'avantex-companion' ),
				'url'   => $privacy_url,
			),
			array(
				'title' => __( 'TOS', 'avantex-companion' ),
				'url'   => $tos_url,
			),
		);

		$f_order = 1;
		foreach ( $footer_items as $f_item ) {
			wp_update_nav_menu_item(
				$footer_menu_id,
				0,
				array(
					'menu-item-title'    => $f_item['title'],
					'menu-item-url'      => $f_item['url'],
					'menu-item-status'   => 'publish',
					'menu-item-type'     => 'custom',
					'menu-item-position' => $f_order,
				)
			);
			++$f_order;
		}
	}

	// Create and populate ReAvantex Services Menu for Footer Our Services column.
	$services_menu_name   = 'ReAvantex Services Menu';
	$services_menu_exists = wp_get_nav_menu_object( $services_menu_name );
	$services_menu_id     = $services_menu_exists ? $services_menu_exists->term_id : wp_create_nav_menu( $services_menu_name );

	if ( ! is_wp_error( $services_menu_id ) && ! $services_menu_exists ) {
		$service_items = array(
			array(
				'title' => __( 'Web Development', 'avantex-companion' ),
				'url'   => home_url( '/services/' ),
			),
			array(
				'title' => __( 'UI/UX Design', 'avantex-companion' ),
				'url'   => home_url( '/services/' ),
			),
			array(
				'title' => __( 'Digital Marketing', 'avantex-companion' ),
				'url'   => home_url( '/services/' ),
			),
			array(
				'title' => __( 'Brand Strategy', 'avantex-companion' ),
				'url'   => home_url( '/services/' ),
			),
			array(
				'title' => __( 'Cloud Solutions', 'avantex-companion' ),
				'url'   => home_url( '/services/' ),
			),
		);

		$s_order = 1;
		foreach ( $service_items as $s_item ) {
			wp_update_nav_menu_item(
				$services_menu_id,
				0,
				array(
					'menu-item-title'    => $s_item['title'],
					'menu-item-url'      => $s_item['url'],
					'menu-item-status'   => 'publish',
					'menu-item-type'     => 'custom',
					'menu-item-position' => $s_order,
				)
			);
			++$s_order;
		}
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}
	if ( ! is_wp_error( $menu_id ) ) {
		$locations['primary'] = (int) $menu_id;
	}
	if ( ! is_wp_error( $footer_menu_id ) ) {
		$locations['footer'] = (int) $footer_menu_id;
	}

	set_theme_mod( 'nav_menu_locations', $locations );
	update_option( 'nav_menu_locations', $locations );

	update_option( 'reavantex_default_menu_created', true );
}

/**
 * Setup default sidebar and footer widgets.
 *
 * @return void
 */
function reavantex_companion_setup_default_widgets() {
	if ( get_option( 'reavantex_default_widgets_created' ) ) {
		return;
	}

	$sidebars_widgets = get_option( 'sidebars_widgets', array() );
	if ( ! is_array( $sidebars_widgets ) ) {
		$sidebars_widgets = array();
	}

	// Populate blog sidebar if empty.
	if ( empty( $sidebars_widgets['avantex_blogwidget'] ) ) {
		$search_widget                          = get_option( 'widget_search', array() );
		$search_widget[1]                       = array( 'title' => __( 'Search', 'avantex-companion' ) );
		$search_widget['_multiwidget']          = 1;
		$recent_posts                           = get_option( 'widget_recent-posts', array() );
		$recent_posts[1]                        = array(
			'title'  => __( 'Recent Posts', 'avantex-companion' ),
			'number' => 5,
		);
		$recent_posts['_multiwidget']           = 1;
		$categories                             = get_option( 'widget_categories', array() );
		$categories[1]                          = array(
			'title' => __( 'Categories', 'avantex-companion' ),
			'count' => 1,
		);
		$categories['_multiwidget']             = 1;
		$sidebars_widgets['avantex_blogwidget'] = array( 'search-1', 'recent-posts-1', 'categories-1' );
		update_option( 'widget_search', $search_widget );
		update_option( 'widget_recent-posts', $recent_posts );
		update_option( 'widget_categories', $categories );
	}

	// Populate footer widget 2 (Our Services) with navigation menu widget if empty.
	if ( empty( $sidebars_widgets['avantex_fwidget_2'] ) ) {
		$services_menu = wp_get_nav_menu_object( 'ReAvantex Services Menu' );
		if ( $services_menu ) {
			$nav_widget                   = get_option( 'widget_nav_menu', array() );
			$nav_index                    = count( $nav_widget ) + 1;
			$nav_widget[ $nav_index ]     = array(
				'title'    => __( 'Our Services', 'avantex-companion' ),
				'nav_menu' => (int) $services_menu->term_id,
			);
			$nav_widget['_multiwidget']   = 1;
			$sidebars_widgets['avantex_fwidget_2'] = array( 'nav_menu-' . $nav_index );
			update_option( 'widget_nav_menu', $nav_widget );
		}
	}

	update_option( 'sidebars_widgets', $sidebars_widgets );
	update_option( 'reavantex_default_widgets_created', true );
}

/**
 * Create starter blog posts on activation.
 *
 * @return void
 */
function reavantex_companion_create_default_blog_posts() {
	if ( get_option( 'reavantex_default_posts_created' ) ) {
		return;
	}

	$existing_posts = wp_count_posts( 'post' );
	if ( isset( $existing_posts->publish ) && $existing_posts->publish > 1 ) {
		update_option( 'reavantex_default_posts_created', true );
		return;
	}

	$default_posts = array(
		array(
			'title'    => __( 'The Future of Web Development: Designing Scalable Digital Experiences', 'avantex-companion' ),
			'content'  => '<p>Building modern web experiences requires a clean architecture, responsive design tokens, and modular components. In this article, we explore best practices for enterprise web development and user engagement.</p>',
			'category' => 'Web Design',
		),
		array(
			'title'    => __( 'Maximizing Brand Impact with Modern Typography and Micro-Interactions', 'avantex-companion' ),
			'content'  => '<p>Typography is the foundation of high-converting web interfaces. Learn how subtle animations and curated font pairings enhance usability and build lasting customer trust.</p>',
			'category' => 'Digital Agency',
		),
		array(
			'title'    => __( 'Optimizing Performance and Core Web Vitals for E-Commerce Platforms', 'avantex-companion' ),
			'content'  => '<p>Speed is critical for retention and conversion rates. Discover key strategies to optimize assets, streamline stylesheets, and achieve 95+ performance scores.</p>',
			'category' => 'Technology Tips',
		),
	);

	foreach ( $default_posts as $post_data ) {
		$existing_post = get_posts(
			array(
				'post_type'      => 'post',
				'title'          => $post_data['title'],
				'post_status'    => 'all',
				'posts_per_page' => 1,
			)
		);

		if ( ! empty( $existing_post ) ) {
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_title'   => $post_data['title'],
				'post_content' => $post_data['content'],
				'post_status'  => 'publish',
				'post_type'    => 'post',
				'post_author'  => 1,
			)
		);

		if ( ! is_wp_error( $post_id ) ) {
			$category = get_term_by( 'name', $post_data['category'], 'category' );
			if ( ! $category ) {
				$new_category = wp_insert_term( $post_data['category'], 'category' );
				if ( ! is_wp_error( $new_category ) ) {
					$category_id = $new_category['term_id'];
				}
			} else {
				$category_id = $category->term_id;
			}

			if ( ! empty( $category_id ) ) {
				wp_set_post_categories( $post_id, array( $category_id ) );
			}
		}
	}

	update_option( 'reavantex_default_posts_created', true );
}

/**
 * Ensure defaults are initialized when Avantex Companion is active with ReAvantex.
 *
 * @return void
 */
function reavantex_companion_ensure_defaults_on_init() {
	$theme_name = wp_get_theme()->get( 'Name' );
	if ( 'ReAvantex' !== $theme_name && 'reavantex' !== strtolower( $theme_name ) ) {
		return;
	}

	if ( ! get_option( 'reavantex_default_pages_created' ) ) {
		reavantex_companion_setup_default_pages();
	}
	if ( ! get_option( 'reavantex_default_posts_created' ) ) {
		reavantex_companion_create_default_blog_posts();
	}
}
add_action( 'init', 'reavantex_companion_ensure_defaults_on_init', 20 );

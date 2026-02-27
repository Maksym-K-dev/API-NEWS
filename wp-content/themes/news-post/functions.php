<?php

/**
 * News Post functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package News Post
 */

if ( ! defined( 'NEWS_POST_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'NEWS_POST_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function news_post_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on News Post, use a find and replace
		* to change 'news-post' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'news-post', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'register_block_style' );

	add_theme_support( 'register_block_pattern' );

	add_theme_support( 'responsive-embeds' );

	add_theme_support( 'align-wide' );

	add_theme_support( 'editor-styles' );

	add_theme_support( 'wp-block-styles' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'news-post' ),
			'social'  => esc_html__( 'Social Menu', 'news-post' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'news_post_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support( 'woocommerce' );
	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;

		if ( version_compare( $woocommerce->version, '3.0.0', '>=' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'small', 'news-post' ),
				'shortName' => esc_html__( 'S', 'news-post' ),
				'size'      => 12,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'regular', 'news-post' ),
				'shortName' => esc_html__( 'M', 'news-post' ),
				'size'      => 16,
				'slug'      => 'regular',
			),
			array(
				'name'      => esc_html__( 'larger', 'news-post' ),
				'shortName' => esc_html__( 'L', 'news-post' ),
				'size'      => 36,
				'slug'      => 'larger',
			),
			array(
				'name'      => esc_html__( 'huge', 'news-post' ),
				'shortName' => esc_html__( 'XL', 'news-post' ),
				'size'      => 48,
				'slug'      => 'huge',
			),
		)
	);
}
add_action( 'after_setup_theme', 'news_post_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function news_post_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'news_post_content_width', 640 );
}
add_action( 'after_setup_theme', 'news_post_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function news_post_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'news-post' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'news-post' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Primary Widgets Area', 'news-post' ),
			'id'            => 'primary-widgets-area',
			'description'   => esc_html__( 'Add primary widgets here.', 'news-post' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Secondary Widgets Area', 'news-post' ),
			'id'            => 'secondary-widgets-area',
			'description'   => esc_html__( 'Add secondary widgets here.', 'news-post' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Above Footer Widgets Area', 'news-post' ),
			'id'            => 'above-footer-widgets-area',
			'description'   => esc_html__( 'Add above footer widgets here.', 'news-post' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer Widget Area ', 'news-post' ) . $i,
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Add widgets here.', 'news-post' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'news_post_widgets_init' );

// Fonts Register.
require get_template_directory() . '/inc/custom-fonts.php';

/**
 * Enqueue scripts and styles.
 */
function news_post_scripts() {

	require get_template_directory() . '/inc/enqueue.php';
}
add_action( 'wp_enqueue_scripts', 'news_post_scripts' );


require get_template_directory() . '/inc/require.php';

// Debug BTN

add_action('wp_footer', function () {

    if (!current_user_can('administrator')) return;

    global $post, $wp_styles, $wp_scripts;

    $theme = wp_get_theme();
    $template_path = get_page_template();
    $template_file = basename($template_path);

    $post_id  = $post->ID ?? 'none';
    $slug     = $post->post_name ?? 'none';
    $type     = get_post_type() ?? 'none';

    $page_template = get_page_template_slug() ?: 'default';

    // Conditions
    $conditions = [];
    foreach ([
                 'front_page','home','page','single','singular',
                 'archive','category','tag','tax','search','404'
             ] as $cond) {
        if (function_exists("is_$cond") && call_user_func("is_$cond")) {
            $conditions[] = $cond;
        }
    }

    // Template hierarchy
    $hierarchy = [];
    if (is_page()) {
        $hierarchy = [
            "page-{$slug}.php",
            "page-{$post_id}.php",
            "page.php",
            "singular.php",
            "index.php"
        ];
    } elseif (is_single()) {
        $hierarchy = [
            "single-{$type}.php",
            "single.php",
            "singular.php",
            "index.php"
        ];
    } elseif (is_archive()) {
        $hierarchy = [
            "archive-{$type}.php",
            "archive.php",
            "index.php"
        ];
    }

    // Styles
    $styles = [];
    if (!empty($wp_styles->queue)) {
        foreach ($wp_styles->queue as $handle) {
            $styles[] = $handle;
        }
    }

    // Scripts
    $scripts = [];
    if (!empty($wp_scripts->queue)) {
        foreach ($wp_scripts->queue as $handle) {
            $scripts[] = $handle;
        }
    }

    // ACF fields
    $acf_output = '';
    if (function_exists('get_fields') && $post_id !== 'none') {
        $fields = get_fields($post_id);
        if ($fields) {
            foreach ($fields as $key => $value) {
                $acf_output .= $key . '<br>';
            }
        } else {
            $acf_output = 'No ACF fields';
        }
    } else {
        $acf_output = 'ACF not active';
    }

    ?>

    <div id="wp-dev-toggle" style="position:fixed;bottom:0;right:0;background:#111;color:#fff;padding:8px 12px;cursor:pointer;z-index:999999;font-size:13px;">
        DEV
    </div>

    <div id="wp-dev-panel" style="
        display:none;
        position:fixed;
        bottom:40px;
        right:0;
        width:500px;
        max-height:80vh;
        overflow:auto;
        background:#0d1117;
        color:#58a6ff;
        padding:20px;
        font-size:12px;
        font-family:monospace;
        z-index:999998;
        box-shadow:0 0 20px rgba(0,0,0,0.7);
        border-left:3px solid #58a6ff;
    ">
        <strong style="color:#fff;">WP DEV PANEL 2.0</strong><br><br>

        Theme: <span style="color:#fff;"><?php echo $theme->get('Name'); ?></span><br>
        Template file: <span style="color:#fff;"><?php echo $template_file; ?></span><br>
        Template path:<br><span style="color:#aaa;"><?php echo $template_path; ?></span><br>
        Page Template: <?php echo $page_template; ?><br><br>

        ID: <?php echo $post_id; ?><br>
        Slug: <?php echo $slug; ?><br>
        Post Type: <?php echo $type; ?><br><br>

        Conditions:<br>
        <span style="color:#fff;"><?php echo implode(', ', $conditions); ?></span><br><br>

        Template Hierarchy:<br>
        <span style="color:#aaa;"><?php echo implode('<br>', $hierarchy); ?></span><br><br>

        Loaded Styles:<br>
        <span style="color:#aaa;"><?php echo implode('<br>', $styles); ?></span><br><br>

        Loaded Scripts:<br>
        <span style="color:#aaa;"><?php echo implode('<br>', $scripts); ?></span><br><br>

        ACF Fields:<br>
        <span style="color:#aaa;"><?php echo $acf_output; ?></span>
    </div>

    <script>
        document.getElementById('wp-dev-toggle').onclick = function() {
            var panel = document.getElementById('wp-dev-panel');
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        };
    </script>

    <?php
});

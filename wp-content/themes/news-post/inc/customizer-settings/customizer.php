<?php
/**
 * News Post Theme Customizer
 *
 * @package News Post
 */

// upgrade to pro.
require get_template_directory() . '/inc/customizer-settings/upgrade-to-pro/class-customize.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function news_post_customize_register( $wp_customize ) {

	// Custom Controls.
	require get_template_directory() . '/inc/customizer-settings/custom-controller.php';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'news_post_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'news_post_customize_partial_blogdescription',
			)
		);
	}

	// Header text display setting.
	$wp_customize->add_setting(
		'news_post_header_text_display',
		array(
			'default'           => true,
			'sanitize_callback' => 'news_post_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'news_post_header_text_display',
		array(
			'section' => 'title_tagline',
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Display Site Title and Tagline', 'news-post' ),
		)
	);

	// Archive Page title.
	$wp_customize->add_setting(
		'news_post_archive_page_title',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'news_post_archive_page_title',
		array(
			'label'           => esc_html__( 'Archive Posts Title', 'news-post' ),
			'section'         => 'static_front_page',
			'active_callback' => 'news_post_is_latest_posts',
		)
	);

	// Abort if selective refresh is not available.
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'news_post_archive_page_title',
			array(
				'selector'            => '.home .site-main h3.section-title',
				'settings'            => 'news_post_archive_page_title',
				'container_inclusive' => false,
				'fallback_refresh'    => true,
				'render_callback'     => 'news_post_archive_page_title_text_partial',
			)
		);
	}

	/*========================Partial Refresh==============================*/
	if ( ! function_exists( 'news_post_archive_page_title_text_partial' ) ) :
		// Archive Page Title.
		function news_post_archive_page_title_text_partial() {
			return esc_html( get_theme_mod( 'news_post_archive_page_title' ) );
		}
	endif;

	// Enable Homepage Content.
	$wp_customize->add_setting(
		'news_post_enable_frontpage_content',
		array(
			'default'           => false,
			'sanitize_callback' => 'news_post_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'news_post_enable_frontpage_content',
		array(
			'label'           => esc_html__( 'Enable Homepage Content', 'news-post' ),
			'description'     => esc_html__( 'Check to enable the selected homepage content on the front page.', 'news-post' ),
			'section'         => 'static_front_page',
			'type'            => 'checkbox',
			'active_callback' => 'news_post_is_static_homepage_enabled',
		)
	);

	// Color Customizer Setting.
	require get_template_directory() . '/inc/customizer-settings/color.php';

	// frontpage customizer section.
	require get_template_directory() . '/inc/customizer-settings/frontpage-customizer/customizer-sections.php';

	// theme options customizer section.
	require get_template_directory() . '/inc/customizer-settings/theme-options/theme-options-sections.php';
}
add_action( 'customize_register', 'news_post_customize_register' );

// Sanitize callback.
require get_template_directory() . '/inc/sanitize-callback.php';

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function news_post_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function news_post_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function news_post_customize_preview_js() {
	wp_enqueue_script( 'news-post-customizer', get_template_directory_uri() . '/assets/js/customizer.min.js', array( 'customize-preview' ), NEWS_POST_VERSION, true );
}
add_action( 'customize_preview_init', 'news_post_customize_preview_js' );

/**
 * Binds JS handlers for Customizer controls.
 */
function news_post_customize_control_js() {
	wp_enqueue_style( 'news-post-customize-style', get_template_directory_uri() . '/assets/css/customize-controls.min.css', array(), '1.0.0' );
	wp_enqueue_style( 'news-post-fontawesome-controls-css', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '6.7.2' );
	wp_enqueue_script( 'news-post-customize-control', get_template_directory_uri() . '/assets/js/customize-control.min.js', array( 'jquery', 'customize-controls' ), '1.0.0', true );
	$localized_data = array(
		'refresh_msg' => esc_html__( 'Refresh the page after Save and Publish.', 'news-post' ),
		'reset_msg'   => esc_html__( 'Warning!!! This will reset all the settings. Refresh the page after Save and Publish to reset all.', 'news-post' ),
	);
	wp_localize_script( 'news-post-customize-control', 'localized_data', $localized_data );
}
add_action( 'customize_controls_enqueue_scripts', 'news_post_customize_control_js' );

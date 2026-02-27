<?php

/**
 * Theme Options.
 */

$wp_customize->add_panel(
	'news_post_theme_options_panel',
	array(
		'title'    => esc_html__( 'Theme Options', 'news-post' ),
		'priority' => 150,
	)
);

$theme_options = array( 'header-options', 'font-options', 'breadcrumb', 'post-meta', 'archive-options', 'single-post', 'sidebar-layout', 'pagination', 'footer' );

foreach ( $theme_options as $customizer ) {
	require get_template_directory() . '/inc/customizer-settings/theme-options/' . $customizer . '.php';

}

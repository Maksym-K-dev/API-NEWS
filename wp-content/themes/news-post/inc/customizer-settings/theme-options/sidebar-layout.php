<?php
/**
 * Sidebar settings
 */

$wp_customize->add_section(
	'news_post_sidebar_option',
	array(
		'title' => esc_html__( 'Sidebar Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Sidebar Option - Archive Sidebar Position.
$wp_customize->add_setting(
	'news_post_archive_sidebar_position',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_post_archive_sidebar_position',
	array(
		'label'   => esc_html__( 'Archive Sidebar Position', 'news-post' ),
		'section' => 'news_post_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-post' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-post' ),
		),
	)
);

// Sidebar Option - Post Sidebar Position.
$wp_customize->add_setting(
	'news_post_post_sidebar_position',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_post_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Post Sidebar Position', 'news-post' ),
		'section' => 'news_post_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-post' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-post' ),
		),
	)
);

// Sidebar Option - Page Sidebar Position.
$wp_customize->add_setting(
	'news_post_page_sidebar_position',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'news_post_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Page Sidebar Position', 'news-post' ),
		'section' => 'news_post_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'news-post' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'news-post' ),
		),
	)
);

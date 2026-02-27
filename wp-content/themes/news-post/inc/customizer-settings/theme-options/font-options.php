<?php

/**
 * Font section
 */

// Font section.
$wp_customize->add_section(
	'news_post_font_options',
	array(
		'title' => esc_html__( 'Font ( Typography ) Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Typography - Site Title Font.
$wp_customize->add_setting(
	'news_post_site_title_font',
	array(
		'default'           => '',
		'sanitize_callback' => 'news_post_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'news_post_site_title_font',
	array(
		'label'    => esc_html__( 'Site Title Font Family', 'news-post' ),
		'section'  => 'news_post_font_options',
		'settings' => 'news_post_site_title_font',
		'type'     => 'select',
		'choices'  => news_post_font_choices(),
	)
);

// Typography - Site Description Font.
$wp_customize->add_setting(
	'news_post_site_description_font',
	array(
		'default'           => '',
		'sanitize_callback' => 'news_post_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'news_post_site_description_font',
	array(
		'label'    => esc_html__( 'Site Description Font Family', 'news-post' ),
		'section'  => 'news_post_font_options',
		'settings' => 'news_post_site_description_font',
		'type'     => 'select',
		'choices'  => news_post_font_choices(),
	)
);

// Typography - Header Font.
$wp_customize->add_setting(
	'news_post_header_font',
	array(
		'default'           => '',
		'sanitize_callback' => 'news_post_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'news_post_header_font',
	array(
		'label'    => esc_html__( 'Header Font Family', 'news-post' ),
		'section'  => 'news_post_font_options',
		'settings' => 'news_post_header_font',
		'type'     => 'select',
		'choices'  => news_post_font_choices(),
	)
);

// Typography - Body Font.
$wp_customize->add_setting(
	'news_post_body_font',
	array(
		'default'           => '',
		'sanitize_callback' => 'news_post_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'news_post_body_font',
	array(
		'label'    => esc_html__( 'Body Font Family', 'news-post' ),
		'section'  => 'news_post_font_options',
		'settings' => 'news_post_body_font',
		'type'     => 'select',
		'choices'  => news_post_font_choices(),
	)
);

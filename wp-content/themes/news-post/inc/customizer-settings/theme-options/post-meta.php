<?php

$wp_customize->add_section(
	'news_post_posts_meta_options',
	array(
		'title' => esc_html__( 'Post Meta Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Enable post category setting.
$wp_customize->add_setting(
	'news_post_enable_category',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_enable_category',
		array(
			'label'    => esc_html__( 'Enable Category', 'news-post' ),
			'settings' => 'news_post_enable_category',
			'section'  => 'news_post_posts_meta_options',
			'type'     => 'checkbox',
		)
	)
);

// Enable post author setting.
$wp_customize->add_setting(
	'news_post_enable_author',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_enable_author',
		array(
			'label'    => esc_html__( 'Enable Author', 'news-post' ),
			'settings' => 'news_post_enable_author',
			'section'  => 'news_post_posts_meta_options',
			'type'     => 'checkbox',
		)
	)
);

// Enable post date setting.
$wp_customize->add_setting(
	'news_post_enable_date',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_enable_date',
		array(
			'label'    => esc_html__( 'Enable Date', 'news-post' ),
			'settings' => 'news_post_enable_date',
			'section'  => 'news_post_posts_meta_options',
			'type'     => 'checkbox',
		)
	)
);

// Enable post tag setting.
$wp_customize->add_setting(
	'news_post_enable_tag',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_enable_tag',
		array(
			'label'    => esc_html__( 'Enable Post Tag', 'news-post' ),
			'settings' => 'news_post_enable_tag',
			'section'  => 'news_post_posts_meta_options',
			'type'     => 'checkbox',
		)
	)
);

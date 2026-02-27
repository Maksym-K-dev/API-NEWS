<?php
/**
 * Breadcrumb settings
 */

$wp_customize->add_section(
	'news_post_breadcrumb_section',
	array(
		'title' => esc_html__( 'Breadcrumb Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Breadcrumb enable setting.
$wp_customize->add_setting(
	'news_post_breadcrumb_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_breadcrumb_enable',
		array(
			'label'    => esc_html__( 'Enable breadcrumb.', 'news-post' ),
			'type'     => 'checkbox',
			'settings' => 'news_post_breadcrumb_enable',
			'section'  => 'news_post_breadcrumb_section',
		)
	)
);

// Breadcrumb - Separator.
$wp_customize->add_setting(
	'news_post_breadcrumb_separator',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '/',
	)
);

$wp_customize->add_control(
	'news_post_breadcrumb_separator',
	array(
		'label'           => esc_html__( 'Separator', 'news-post' ),
		'section'         => 'news_post_breadcrumb_section',
		'active_callback' => function( $control ) {
			return ( $control->manager->get_setting( 'news_post_breadcrumb_enable' )->value() );
		},
	)
);

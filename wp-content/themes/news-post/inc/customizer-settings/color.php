<?php

/**
 * Color Options
 */

// Site tagline color setting.
$wp_customize->add_setting(
	'news_post_header_tagline',
	array(
		'default'           => '#141414',
		'sanitize_callback' => 'news_post_sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'news_post_header_tagline',
		array(
			'label'   => esc_html__( 'Site tagline Color', 'news-post' ),
			'section' => 'colors',
		)
	)
);

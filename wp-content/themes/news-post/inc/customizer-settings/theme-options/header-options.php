<?php
/**
 * Header Options
 */

// Header Options.
$wp_customize->add_section(
	'news_post_header_section',
	array(
		'title' => esc_html__( 'Header Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Enable Topbar Section.
$wp_customize->add_setting(
	'news_post_topbar_section_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_topbar_section_enable',
		array(
			'label'    => esc_html__( 'Enable Topbar Section.', 'news-post' ),
			'settings' => 'news_post_topbar_section_enable',
			'section'  => 'news_post_header_section',
			'type'     => 'checkbox',
		)
	)
);

// Header Button label setting.
$wp_customize->add_setting(
	'news_post_header_button_label',
	array(
		'default'           => __( 'Sign In', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_header_button_label',
	array(
		'label'    => esc_html__( 'Header Button Label', 'news-post' ),
		'section'  => 'news_post_header_section',
		'settings' => 'news_post_header_button_label',
		'type'     => 'text',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_post_header_button_label',
		array(
			'selector'            => '.header-button a',
			'settings'            => 'news_post_header_button_label',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Header Button URL setting.
$wp_customize->add_setting(
	'news_post_header_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'news_post_header_button_url',
	array(
		'label'    => esc_html__( 'Header Button Link', 'news-post' ),
		'section'  => 'news_post_header_section',
		'settings' => 'news_post_header_button_url',
		'type'     => 'url',
	)
);

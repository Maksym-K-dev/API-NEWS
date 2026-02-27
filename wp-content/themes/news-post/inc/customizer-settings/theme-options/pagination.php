<?php
/**
 * Pagination setting
 */

// Pagination setting.
$wp_customize->add_section(
	'news_post_pagination',
	array(
		'title' => esc_html__( 'Pagination', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Pagination enable setting.
$wp_customize->add_setting(
	'news_post_pagination_enable',
	array(
		'default'           => true,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);

$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_pagination_enable',
		array(
			'label'    => esc_html__( 'Enable Pagination.', 'news-post' ),
			'settings' => 'news_post_pagination_enable',
			'section'  => 'news_post_pagination',
			'type'     => 'checkbox',
		)
	)
);

// Pagination - Pagination Style.
$wp_customize->add_setting(
	'news_post_pagination_type',
	array(
		'default'           => 'numeric',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Style', 'news-post' ),
		'section'         => 'news_post_pagination',
		'type'            => 'select',
		'choices'         => array(
			'default' => __( 'Default (Older/Newer)', 'news-post' ),
			'numeric' => __( 'Numeric', 'news-post' ),
		),
		'active_callback' => 'news_post_pagination_enabled',
	)
);

/*========================Active Callback==============================*/
function news_post_pagination_enabled( $control ) {
	return $control->manager->get_setting( 'news_post_pagination_enable' )->value();
}

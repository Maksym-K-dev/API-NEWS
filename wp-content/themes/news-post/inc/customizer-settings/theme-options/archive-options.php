<?php
/**
 * Blog / Archive Options
 */

$wp_customize->add_section(
	'news_post_archive_page_options',
	array(
		'title' => esc_html__( 'Blog / Archive Pages Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'news_post_excerpt_length',
	array(
		'default'           => 15,
		'sanitize_callback' => 'news_post_sanitize_number_range',
	)
);

$wp_customize->add_control(
	'news_post_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'news-post' ),
		'section'     => 'news_post_archive_page_options',
		'settings'    => 'news_post_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 5,
			'max'  => 200,
			'step' => 1,
		),
	)
);

// Archive Column layout options.
$wp_customize->add_setting(
	'news_post_archive_column_layout',
	array(
		'default'           => 'double-column',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_archive_column_layout',
	array(
		'label'   => esc_html__( 'Column Layout', 'news-post' ),
		'section' => 'news_post_archive_page_options',
		'type'    => 'select',
		'choices' => array(
			'double-column' => __( 'Column 2', 'news-post' ),
			'triple-column' => __( 'Column 3', 'news-post' ),
		),
	)
);

// Editor Choice Read more Button Label settings.
$wp_customize->add_setting(
	'news_post_archive_readmore_btn',
	array(
		'default'           => __( 'Read More', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_archive_readmore_btn',
	array(
		'label'    => esc_html__( 'Read More Button', 'news-post' ),
		'section'  => 'news_post_archive_page_options',
		'settings' => 'news_post_archive_readmore_btn',
		'type'     => 'text',
	)
);

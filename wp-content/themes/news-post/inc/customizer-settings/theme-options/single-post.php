<?php
/**
 * Single Post Options
 */

$wp_customize->add_section(
	'news_post_single_page_options',
	array(
		'title' => esc_html__( 'Single Post Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

// Single post related Posts title label.
$wp_customize->add_setting(
	'news_post_related_posts_title',
	array(
		'default'           => __( 'Related Posts', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_related_posts_title',
	array(
		'label'    => esc_html__( 'Related Posts Title', 'news-post' ),
		'section'  => 'news_post_single_page_options',
		'settings' => 'news_post_related_posts_title',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_post_related_posts_title',
		array(
			'selector'            => '.theme-wrapper h2.related-title',
			'settings'            => 'news_post_related_posts_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

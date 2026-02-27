<?php
/**
 * Footer copyright
 */

// Footer copyright
$wp_customize->add_section(
	'news_post_footer_section',
	array(
		'title' => esc_html__( 'Footer Options', 'news-post' ),
		'panel' => 'news_post_theme_options_panel',
	)
);

$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'news-post' ), '[the-year]', '[site-link]' );

// Footer copyright setting.
$wp_customize->add_setting(
	'news_post_copyright_txt',
	array(
		'default'           => $copyright_default,
		'sanitize_callback' => 'news_post_sanitize_html',
	)
);

$wp_customize->add_control(
	'news_post_copyright_txt',
	array(
		'label'   => esc_html__( 'Copyright text', 'news-post' ),
		'section' => 'news_post_footer_section',
		'type'    => 'textarea',
	)
);

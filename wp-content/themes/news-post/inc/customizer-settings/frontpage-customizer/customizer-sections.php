<?php

// Home Page Customizer panel.
$wp_customize->add_panel(
	'news_post_frontpage_panel',
	array(
		'title'    => esc_html__( 'Frontpage Sections', 'news-post' ),
		'priority' => 140,
	)
);

$customizer_settings = array( 'highlights', 'banner', 'editor-choice' );

foreach ( $customizer_settings as $customizer ) {

	require get_template_directory() . '/inc/customizer-settings/frontpage-customizer/' . $customizer . '.php';

}

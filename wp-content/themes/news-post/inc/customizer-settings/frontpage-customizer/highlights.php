<?php
/**
 * Highlights Options
 */

// Highlights Options.
$wp_customize->add_section(
	'news_post_highlights_section',
	array(
		'title' => esc_html__( 'Highlights Section', 'news-post' ),
		'panel' => 'news_post_frontpage_panel',
	)
);


// Highlights News section enable settings.
$wp_customize->add_setting(
	'news_post_highlights_news_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_highlights_news_section_enable',
		array(
			'label'    => esc_html__( 'Enable Highlights News Section', 'news-post' ),
			'type'     => 'checkbox',
			'settings' => 'news_post_highlights_news_section_enable',
			'section'  => 'news_post_highlights_section',
		)
	)
);

// Highlights news content type settings.
$wp_customize->add_setting(
	'news_post_highlights_news_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_highlights_news_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-post' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-post' ),
		'section'         => 'news_post_highlights_section',
		'type'            => 'select',
		'active_callback' => 'news_post_if_highlights_news_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-post' ),
			'category' => esc_html__( 'Category', 'news-post' ),
		),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// Highlights news post setting.
	$wp_customize->add_setting(
		'news_post_highlights_news_post_' . $i,
		array(
			'sanitize_callback' => 'news_post_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_post_highlights_news_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-post' ), $i ),
			'section'         => 'news_post_highlights_section',
			'type'            => 'select',
			'choices'         => news_post_get_post_choices(),
			'active_callback' => 'news_post_highlights_news_section_content_type_post_enabled',
		)
	);

}

// Highlights news category setting.
$wp_customize->add_setting(
	'news_post_highlights_news_category',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_highlights_news_category',
	array(
		'label'           => esc_html__( 'Category', 'news-post' ),
		'section'         => 'news_post_highlights_section',
		'type'            => 'select',
		'choices'         => news_post_get_post_cat_choices(),
		'active_callback' => 'news_post_highlights_news_section_content_type_category_enabled',
	)
);

/*========================Active Callback==============================*/
function news_post_if_highlights_news_enabled( $control ) {
	return $control->manager->get_setting( 'news_post_highlights_news_section_enable' )->value();
}
function news_post_highlights_news_section_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_highlights_news_content_type' )->value();
	return news_post_if_highlights_news_enabled( $control ) && ( 'post' === $content_type );
}
function news_post_highlights_news_section_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_highlights_news_content_type' )->value();
	return news_post_if_highlights_news_enabled( $control ) && ( 'category' === $content_type );
}

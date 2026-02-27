<?php
/**
 * Frontpage Customizer Settings
 *
 * @package News Post
 *
 * Banner Section
 */

$wp_customize->add_section(
	'news_post_banner_section',
	array(
		'title' => esc_html__( 'Banner Section', 'news-post' ),
		'panel' => 'news_post_frontpage_panel',
	)
);

// Banner section enable settings.
$wp_customize->add_setting(
	'news_post_banner_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_banner_section_enable',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'news-post' ),
			'type'     => 'checkbox',
			'settings' => 'news_post_banner_section_enable',
			'section'  => 'news_post_banner_section',
		)
	)
);

// Banner Main News Sub Heading.
$wp_customize->add_setting(
	'news_post_banner_main_news_sub_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new News_Post_Section_Sub_Heading_Control(
		$wp_customize,
		'news_post_banner_main_news_sub_heading',
		array(
			'label'           => esc_html__( 'Banner Main News Section', 'news-post' ),
			'settings'        => 'news_post_banner_main_news_sub_heading',
			'section'         => 'news_post_banner_section',
			'active_callback' => 'news_post_if_banner_enabled',
		)
	)
);

// Banner Main News title settings.
$wp_customize->add_setting(
	'news_post_banner_main_news_title',
	array(
		'default'           => __( 'Main News', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_post_banner_main_news_title',
		array(
			'selector'            => '.blog-editors-choice h3.section-title',
			'settings'            => 'news_post_banner_main_news_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Banner Main News Button Label settings.
$wp_customize->add_setting(
	'news_post_banner_main_news_button_label',
	array(
		'default'           => __( 'View All', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_main_news_button_label',
		'type'            => 'text',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Banner Main News Button URL settings.
$wp_customize->add_setting(
	'news_post_banner_main_news_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_button_url',
	array(
		'label'           => esc_html__( 'Button Link', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_main_news_button_url',
		'type'            => 'url',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Banner excerpt length.
$wp_customize->add_setting(
	'news_post_banner_main_news_excerpt_length',
	array(
		'default'           => 25,
		'sanitize_callback' => 'news_post_sanitize_number_range',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_excerpt_length',
	array(
		'label'           => esc_html__( 'Number of excerpt length:', 'news-post' ),
		'description'     => esc_html__( 'Min: 1', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'type'            => 'number',
		'input_attrs'     => array(
			'min' => 1,
		),
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// banner content type settings.
$wp_customize->add_setting(
	'news_post_banner_main_news_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-post' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'type'            => 'select',
		'active_callback' => 'news_post_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-post' ),
			'page'     => esc_html__( 'Page', 'news-post' ),
			'category' => esc_html__( 'Category', 'news-post' ),
			'recent'   => esc_html__( 'Recent', 'news-post' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'news_post_banner_main_news_post_' . $i,
		array(
			'sanitize_callback' => 'news_post_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_post_banner_main_news_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-post' ), $i ),
			'section'         => 'news_post_banner_section',
			'type'            => 'select',
			'choices'         => news_post_get_post_choices(),
			'active_callback' => 'news_post_banner_main_news_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'news_post_banner_main_news_category',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_category',
	array(
		'label'           => esc_html__( 'Category', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'type'            => 'select',
		'choices'         => news_post_get_post_cat_choices(),
		'active_callback' => 'news_post_banner_main_news_content_type_category_enabled',
	)
);

// Banner Main News Button Label settings.
$wp_customize->add_setting(
	'news_post_banner_main_news_readmore_btn',
	array(
		'default'           => __( 'Read More', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_main_news_readmore_btn',
	array(
		'label'           => esc_html__( 'Button Label', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_main_news_readmore_btn',
		'type'            => 'text',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Banner News Sub Heading.
$wp_customize->add_setting(
	'news_post_banner_posts_sub_heading',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new News_Post_Section_Sub_Heading_Control(
		$wp_customize,
		'news_post_banner_posts_sub_heading',
		array(
			'label'           => esc_html__( 'Banner News Section', 'news-post' ),
			'settings'        => 'news_post_banner_posts_sub_heading',
			'section'         => 'news_post_banner_section',
			'active_callback' => 'news_post_if_banner_enabled',
		)
	)
);

// Banner News News title settings.
$wp_customize->add_setting(
	'news_post_banner_posts_news_title',
	array(
		'default'           => __( 'Featured News', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_news_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_post_banner_posts_news_title',
		array(
			'selector'            => '.blog-editors-choice h3.section-title',
			'settings'            => 'news_post_banner_posts_news_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Banner News News Button Label settings.
$wp_customize->add_setting(
	'news_post_banner_posts_news_button_label',
	array(
		'default'           => __( 'View All', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_news_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_posts_news_button_label',
		'type'            => 'text',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// Banner News News Button URL settings.
$wp_customize->add_setting(
	'news_post_banner_posts_news_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_news_button_url',
	array(
		'label'           => esc_html__( 'Button Link', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_posts_news_button_url',
		'type'            => 'url',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

// banner content type settings.
$wp_customize->add_setting(
	'news_post_banner_posts_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-post' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'type'            => 'select',
		'active_callback' => 'news_post_if_banner_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-post' ),
			'category' => esc_html__( 'Category', 'news-post' ),
		),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// banner post setting.
	$wp_customize->add_setting(
		'news_post_banner_posts_post_' . $i,
		array(
			'sanitize_callback' => 'news_post_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_post_banner_posts_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-post' ), $i ),
			'section'         => 'news_post_banner_section',
			'type'            => 'select',
			'choices'         => news_post_get_post_choices(),
			'active_callback' => 'news_post_banner_posts_content_type_post_enabled',
		)
	);

}

// banner category setting.
$wp_customize->add_setting(
	'news_post_banner_posts_category',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_category',
	array(
		'label'           => esc_html__( 'Category', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'type'            => 'select',
		'choices'         => news_post_get_post_cat_choices(),
		'active_callback' => 'news_post_banner_posts_content_type_category_enabled',
	)
);

// Banner News News Button Label settings.
$wp_customize->add_setting(
	'news_post_banner_posts_news_readmore_btn',
	array(
		'default'           => __( 'Read More', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_banner_posts_news_readmore_btn',
	array(
		'label'           => esc_html__( 'Button Label', 'news-post' ),
		'section'         => 'news_post_banner_section',
		'settings'        => 'news_post_banner_posts_news_readmore_btn',
		'type'            => 'text',
		'active_callback' => 'news_post_if_banner_enabled',
	)
);

/*========================Active Callback==============================*/
function news_post_if_banner_enabled( $control ) {
	return $control->manager->get_setting( 'news_post_banner_section_enable' )->value();
}
//Banner Main News.
function news_post_banner_main_news_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_banner_main_news_content_type' )->value();
	return news_post_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function news_post_banner_main_news_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_banner_main_news_content_type' )->value();
	return news_post_if_banner_enabled( $control ) && ( 'category' === $content_type );
}
//Banner News.
function news_post_banner_posts_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_banner_posts_content_type' )->value();
	return news_post_if_banner_enabled( $control ) && ( 'post' === $content_type );
}
function news_post_banner_posts_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_banner_posts_content_type' )->value();
	return news_post_if_banner_enabled( $control ) && ( 'category' === $content_type );
}

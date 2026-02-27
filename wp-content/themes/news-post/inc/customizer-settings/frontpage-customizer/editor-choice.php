<?php
/**
 * Frontpage Customizer Settings
 *
 * @package News Post
 *
 * Editor Choice Section
 */

$wp_customize->add_section(
	'news_post_editor_choice_section',
	array(
		'title' => esc_html__( 'Editor Choice Section', 'news-post' ),
		'panel' => 'news_post_frontpage_panel',
	)
);

// Editor Choice section enable settings.
$wp_customize->add_setting(
	'news_post_editor_choice_section_enable',
	array(
		'default'           => false,
		'sanitize_callback' => 'news_post_sanitize_checkbox',
	)
);
$wp_customize->add_control(
	new News_Post_Toggle_Checkbox_Custom_control(
		$wp_customize,
		'news_post_editor_choice_section_enable',
		array(
			'label'    => esc_html__( 'Enable Editor Choice Section', 'news-post' ),
			'type'     => 'checkbox',
			'settings' => 'news_post_editor_choice_section_enable',
			'section'  => 'news_post_editor_choice_section',
		)
	)
);

// Editor Choice title settings.
$wp_customize->add_setting(
	'news_post_editor_choice_title',
	array(
		'default'           => __( 'Editor Choice', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_title',
	array(
		'label'           => esc_html__( 'Section Title', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'active_callback' => 'news_post_if_editor_choice_enabled',
	)
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'news_post_editor_choice_title',
		array(
			'selector'            => '.blog-editors-choice h3.section-title',
			'settings'            => 'news_post_editor_choice_title',
			'container_inclusive' => false,
			'fallback_refresh'    => true,
		)
	);
}

// Editor Choice Button Label settings.
$wp_customize->add_setting(
	'news_post_editor_choice_button_label',
	array(
		'default'           => __( 'View All', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'settings'        => 'news_post_editor_choice_button_label',
		'type'            => 'text',
		'active_callback' => 'news_post_if_editor_choice_enabled',
	)
);

// Editor Choice Button URL settings.
$wp_customize->add_setting(
	'news_post_editor_choice_button_url',
	array(
		'default'           => '#',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_button_url',
	array(
		'label'           => esc_html__( 'Button Link', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'settings'        => 'news_post_editor_choice_button_url',
		'type'            => 'url',
		'active_callback' => 'news_post_if_editor_choice_enabled',
	)
);

// editor_choice content type settings.
$wp_customize->add_setting(
	'news_post_editor_choice_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_content_type',
	array(
		'label'           => esc_html__( 'Content type:', 'news-post' ),
		'description'     => esc_html__( 'Choose where you want to render the content from.', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'type'            => 'select',
		'active_callback' => 'news_post_if_editor_choice_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'news-post' ),
			'category' => esc_html__( 'Category', 'news-post' ),
		),
	)
);

for ( $i = 1; $i <= 3; $i++ ) {
	// editor_choice post setting.
	$wp_customize->add_setting(
		'news_post_editor_choice_post_' . $i,
		array(
			'sanitize_callback' => 'news_post_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'news_post_editor_choice_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Post %d', 'news-post' ), $i ),
			'section'         => 'news_post_editor_choice_section',
			'type'            => 'select',
			'choices'         => news_post_get_post_choices(),
			'active_callback' => 'news_post_editor_choice_section_content_type_post_enabled',
		)
	);

}

// editor_choice category setting.
$wp_customize->add_setting(
	'news_post_editor_choice_category',
	array(
		'sanitize_callback' => 'news_post_sanitize_select',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_category',
	array(
		'label'           => esc_html__( 'Category', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'type'            => 'select',
		'choices'         => news_post_get_post_cat_choices(),
		'active_callback' => 'news_post_editor_choice_section_content_type_category_enabled',
	)
);

// Editor Choice Read more Button Label settings.
$wp_customize->add_setting(
	'news_post_editor_choice_readmore_btn',
	array(
		'default'           => __( 'Read More', 'news-post' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'news_post_editor_choice_readmore_btn',
	array(
		'label'           => esc_html__( 'Read More Button', 'news-post' ),
		'section'         => 'news_post_editor_choice_section',
		'settings'        => 'news_post_editor_choice_readmore_btn',
		'type'            => 'text',
		'active_callback' => 'news_post_if_editor_choice_enabled',
	)
);

/*========================Active Callback==============================*/
function news_post_if_editor_choice_enabled( $control ) {
	return $control->manager->get_setting( 'news_post_editor_choice_section_enable' )->value();
}
function news_post_editor_choice_section_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_editor_choice_content_type' )->value();
	return news_post_if_editor_choice_enabled( $control ) && ( 'post' === $content_type );
}
function news_post_editor_choice_section_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'news_post_editor_choice_content_type' )->value();
	return news_post_if_editor_choice_enabled( $control ) && ( 'category' === $content_type );
}

/*========================Partial Refresh==============================*/
if ( ! function_exists( 'news_post_editor_choice_title_text_partial' ) ) :
	// Title.
	function news_post_editor_choice_title_text_partial() {
		return esc_html( get_theme_mod( 'news_post_editor_choice_title' ) );
	}
endif;

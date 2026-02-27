<?php
/**
 * Frontpage Banner Section.
 *
 * @package News Post
 */

// Banner Section.
$banner_section = get_theme_mod( 'news_post_banner_section_enable', false );

if ( false === $banner_section ) {
	return;
}

$banner_main_news_content_ids  = $banner_posts_content_ids = array();
$banner_main_news_content_type = get_theme_mod( 'news_post_banner_main_news_content_type', 'post' );
$banner_posts_content_type     = get_theme_mod( 'news_post_banner_posts_content_type', 'post' );

if ( $banner_main_news_content_type === 'post' ) {

	for ( $i = 1; $i <= 3; $i++ ) {
		$banner_main_news_content_ids[] = get_theme_mod( 'news_post_banner_main_news_post_' . $i );
	}

	$banner_main_news_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( array_filter( $banner_main_news_content_ids ) ) ) {
		$banner_main_news_args['post__in'] = array_filter( $banner_main_news_content_ids );
		$banner_main_news_args['orderby']  = 'post__in';
	} else {
		$banner_main_news_args['orderby'] = 'date';
	}

} else {
	$cat_content_id     = get_theme_mod( 'news_post_banner_main_news_category' );
	$banner_main_news_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}

if ( $banner_posts_content_type === 'post' ) {

	for ( $i = 1; $i <= 5; $i++ ) {
		$banner_posts_content_ids[] = get_theme_mod( 'news_post_banner_posts_post_' . $i );
	}

	$banner_posts_args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( array_filter( $banner_posts_content_ids ) ) ) {
		$banner_posts_args['post__in'] = array_filter( $banner_posts_content_ids );
		$banner_posts_args['orderby']  = 'post__in';
	} else {
		$banner_posts_args['orderby'] = 'date';
	}

} else {
	$cat_content_id    = get_theme_mod( 'news_post_banner_posts_category' );
	$banner_posts_args = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 5 ),
	);
}
?>

<section id="news_post_banner_section" class="banner-section banner-layout-2">
	<div class="site-container-width">
		<div class="banner-section-wrapper">
			
			<?php require get_template_directory() . '/inc/frontpage-sections/banner/banner-main-news.php'; ?>
			
			<?php require get_template_directory() . '/inc/frontpage-sections/banner/banner-posts.php'; ?>
			
		</div>
	</div>
</section>
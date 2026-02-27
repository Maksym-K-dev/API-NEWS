<?php
/**
 * Frontpage Editor Choice Section.
 *
 * @package News Post
 */

// Editor Choice Section.
$editor_choice_section = get_theme_mod( 'news_post_editor_choice_section_enable', false );

if ( false === $editor_choice_section ) {
	return;
}

$content_ids                = array();
$editor_choice_content_type = get_theme_mod( 'news_post_editor_choice_content_type', 'post' );

if ( $editor_choice_content_type === 'post' ) {

	for ( $i = 1; $i <= 3; $i++ ) {
		$content_ids[] = get_theme_mod( 'news_post_editor_choice_post_' . $i );
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 3 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( array_filter( $content_ids ) ) ) {
		$args['post__in'] = array_filter( $content_ids );
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} else {
	$cat_content_id = get_theme_mod( 'news_post_editor_choice_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 3 ),
	);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	$section_title = get_theme_mod( 'news_post_editor_choice_title', __( 'Editor Choice', 'news-post' ) );
	$button_label  = get_theme_mod( 'news_post_editor_choice_button_label', __( 'View All', 'news-post' ) );
	$button_url    = get_theme_mod( 'news_post_editor_choice_button_url', __( '#', 'news-post' ) );
	$readmore_btn  = get_theme_mod( 'news_post_editor_choice_readmore_btn', __( 'Read More', 'news-post' ) );
	?>
	
	<section id="news_post_editor_choice_section" class="blog-editors-choice section-divider">
		<div class="site-container-width">
			<?php if ( ! empty( $section_title || $button_label ) ) : ?>
				<div class="header-title">
					<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
					<?php if ( ! empty( $button_label ) ) : ?>
						<a href="<?php echo esc_url( $button_url ); ?>" class="view-all"><?php echo esc_html( $button_label ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="container-wrap">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					$excerpt = wp_trim_words( get_the_content(), 20 );
					?>
					<div class="single-card-container grid-card">
						<div class="single-card-image">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
						<div class="single-card-detail">
							<?php news_post_categories_list(); ?>
							<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="card-meta">
								<?php
									news_post_posted_by();
									news_post_posted_on();
								?>
							</div>
							<?php if( ! empty( $excerpt ) ) { ?>
								<div class="post-exerpt">
									<p><?php echo wp_kses_post( $excerpt ); ?></p>
								</div>
								<?php if ( ! empty( $readmore_btn ) ) : ?>
									<div class="post-button">
										<a href="<?php the_permalink(); ?>" class="read-more-button"><?php echo esc_html( $readmore_btn ); ?></a>
									</div>
								<?php endif; ?>
							<?php } ?>
						</div>
					</div>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>

	<?php
}

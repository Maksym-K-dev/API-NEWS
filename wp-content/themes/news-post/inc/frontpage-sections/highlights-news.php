<?php
/**
 * Frontpage Highlights News Section.
 *
 * @package News Post
 */

// Highlights News Section.
$highlights_news_section = get_theme_mod( 'news_post_highlights_news_section_enable', false );

if ( false === $highlights_news_section ) {
	return;
}

$content_ids                  = $section_content = array();
$highlights_news_content_type = get_theme_mod( 'news_post_highlights_news_content_type', 'post' );

if ( $highlights_news_content_type === 'post' ) {

	for ( $i = 1; $i <= 5; $i++ ) {
		$content_ids[] = get_theme_mod( 'news_post_highlights_news_post_' . $i );
	}

	$args = array(
		'post_type'           => 'post',
		'posts_per_page'      => absint( 5 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( array_filter( $content_ids ) ) ) {
		$args['post__in'] = array_filter( $content_ids );
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}
} else {
	$cat_content_id = get_theme_mod( 'news_post_highlights_news_category' );
	$args           = array(
		'cat'            => $cat_content_id,
		'posts_per_page' => absint( 5 ),
	);
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) :
	?>
	<div id="news_post_highlights_news_section" class="news-highlights">
		<div class="site-container-width">
			<div class="news-highlights-container">
				<div class="js-conveyor">
					<ul>
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();
							?>
							<li>
								<div class="highlights-content">
									<?php if ( has_post_thumbnail() ) { ?>
										<div class="content-img">
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array( 40, 40 ) ); ?></a>
										</div>
									<?php } ?>
									<div class="content-detail">
										<div class="content-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</div>
										<?php news_post_posted_on(); ?>
									</div>
								</div>
							</li>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
endif;

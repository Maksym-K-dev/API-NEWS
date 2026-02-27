<?php
$banner_posts_query = new WP_Query( $banner_posts_args );
if ( $banner_posts_query->have_posts() ) {
	$section_title = get_theme_mod( 'news_post_banner_posts_news_title', __( 'Featured News', 'news-post' ) );
	$viewall_btn   = get_theme_mod( 'news_post_banner_posts_news_button_label', __( 'View All', 'news-post' ) );
	$button_url    = get_theme_mod( 'news_post_banner_posts_news_button_url', __( '#', 'news-post' ) );
	$banner_btn    = get_theme_mod( 'news_post_banner_posts_news_readmore_btn', __( 'Read More', 'news-post' ) );
		?>
	<div class="banner-slider-area">
		<?php if ( ! empty( $section_title || $viewall_btn ) ) : ?>
			<div class="header-title">
				<h3 class="section-title"><?php echo esc_html( $section_title ); ?></h3>
				<?php if( ! empty( $viewall_btn ) ) { ?>
					<a href="<?php echo esc_url( $button_url ); ?>" class="view-all"><?php echo esc_html( $viewall_btn );?></a>
				<?php } ?>
			</div>
		<?php endif; ?>
		<div class="container-wrap banner-carousel">
			<?php
			while ( $banner_posts_query->have_posts() ) :
				$banner_posts_query->the_post();
				$excerpt = wp_trim_words( get_the_content(), 15 );
				?>
				<div class="slider-container">
					<div class="single-card-container grid-card">
						<div class="single-card-image">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
						<div class="single-card-detail">
							<div class="card-categories">
								<?php news_post_categories_list(); ?>
							</div>
							<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="card-meta">
								<?php
									news_post_posted_by();
									news_post_posted_on();
								?>
							</div>
							<div class="post-exerpt">
								<p><?php echo wp_kses_post( $excerpt ); ?></p>
							</div>
							<div class="post-button">
								<a href="<?php the_permalink(); ?>" class="read-more-button"><?php echo esc_html( $banner_btn ); ?></a>
							</div>
						</div>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>

	<?php
}

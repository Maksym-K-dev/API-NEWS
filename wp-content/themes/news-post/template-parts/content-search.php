<?php
/**
 * Template part for displaying posts search
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package News Post
 */

$readmore_btn   = get_theme_mod( 'news_post_archive_readmore_btn', __( 'Read More', 'news-post' ) );
$excerpt_length = get_theme_mod( 'news_post_excerpt_length', 15 );
$excerpt        = wp_trim_words( get_the_excerpt(), $excerpt_length );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="single-card-container grid-card">
		<div class="single-card-image">
			<?php news_post_post_thumbnail(); ?>
		</div>
		<div class="single-card-detail">
			<?php news_post_categories_list(); ?>
			<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="card-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
			?>
			<?php
			if ( 'post' === get_post_type() ) :
				?>
				<div class="card-meta">
					<?php
						news_post_posted_by();
						news_post_posted_on();
					?>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $excerpt ) ) : ?>
				<div class="post-exerpt">
					<?php echo wp_kses_post( $excerpt ); ?>
				</div><!-- post-exerpt -->
				<?php if ( ! empty( $readmore_btn ) ) : ?>
					<div class="post-button">
						<a href="<?php the_permalink(); ?>" class="read-more-button"><?php echo esc_html( $readmore_btn ); ?></a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

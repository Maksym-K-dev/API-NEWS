<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package News Post
 */

if ( ! function_exists( 'news_post_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function news_post_posted_on() {

		if ( get_theme_mod( 'news_post_enable_date', true ) === false ) {
			return;
		}

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="post-date"><span class="posted-on">' . $posted_on . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'news_post_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function news_post_posted_by() {

		if ( get_theme_mod( 'news_post_enable_author', true ) === false ) {
			return;
		}

		$byline = sprintf(
		/* translators: %s: post author. */
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="post-author"><span class="byline"><span>' . esc_html__( 'by', 'news-post' ) . '</span>' . $byline . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'news_post_categories_list' ) ) :
	/**
	 * Prints HTML with meta information for the categories.
	 */
	function news_post_categories_list() {

		if ( get_theme_mod( 'news_post_enable_category', true ) === false ) {
			return;
		}

		if ( 'post' === get_post_type() ) {
			$categories = get_the_category();

			if ( ! empty( $categories ) ) {
				echo '<div class="card-categories"><span class="cat-links">';
				foreach ( $categories as $category ) {
					// Fetch category color from term meta.
					$color = get_term_meta( $category->term_id, 'news_post_custom_category_hue', true );
					if ( ! $color ) {
						$color = 'var(--theme-primary-hue)'; // fallback if no color is set.
					}

					printf(
						'<a href="%1$s" class="post-category cat-%4$s" style="--custom-categories-hue:%2$s;">%3$s</a>',
						esc_url( get_category_link( $category->term_id ) ),
						esc_attr( $color ),
						esc_html( $category->name ),
						esc_attr( $category->slug )
					);
				}
				echo '</span></div>';
			}
		}
	}
endif;


if ( ! function_exists( 'news_post_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function news_post_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'news-post' ) );
			if ( $tags_list ) {
					/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'news-post' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'news-post' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'news-post' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'news_post_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.

	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function news_post_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

			<?php
	endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.

	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

<?php

/**
 * Enqueue WordPress color picker for category edit screen.
 */
function news_post_enqueue_category_color_picker( $hook ) {
	if ( 'edit-tags.php' === $hook || 'term.php' === $hook ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'news-post-category-color-picker', get_template_directory_uri() . '/assets/js/category-hue.min.js', array( 'wp-color-picker' ), false, true );
	}
}
add_action( 'admin_enqueue_scripts', 'news_post_enqueue_category_color_picker' );

/**
 * Add field to "Add Category" form
 */
function news_post_custom_category_hue_add_field() {
	?>
	<div class="form-field">
		<label for="news_post_custom_category_hue"><?php esc_html_e( 'Category Color', 'news-post' ); ?></label>
		<input type="text" name="news_post_custom_category_hue" id="news_post_custom_category_hue" value="" class="custom-category-color-picker" />
		<p class="description"><?php esc_html_e( 'Select a color for this category.', 'news-post' ); ?></p>
	</div>
	<?php
}
add_action( 'category_add_form_fields', 'news_post_custom_category_hue_add_field' );

/**
 * Add field to "Edit Category" form
 */
function news_post_custom_category_hue_edit_field( $term ) {
	$color = get_term_meta( $term->term_id, 'news_post_custom_category_hue', true );
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="news_post_custom_category_hue"><?php esc_html_e( 'Category Color', 'news-post' ); ?></label></th>
		<td>
			<input type="text" name="news_post_custom_category_hue" id="news_post_custom_category_hue" value="<?php echo esc_attr( $color ); ?>" class="custom-category-color-picker" />
			<p class="description"><?php esc_html_e( 'Select a color for this category.', 'news-post' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'news_post_custom_category_hue_edit_field' );

/**
 * Save category color
 */
function news_post_save_category_color( $term_id ) {
	if ( isset( $_POST['news_post_custom_category_hue'] ) ) {
		update_term_meta( $term_id, 'news_post_custom_category_hue', sanitize_hex_color( $_POST['news_post_custom_category_hue'] ) );
	}
}
add_action( 'created_category', 'news_post_save_category_color' );
add_action( 'edited_category', 'news_post_save_category_color' );

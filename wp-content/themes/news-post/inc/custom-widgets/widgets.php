<?php

// Featured Posts Widget.
require get_template_directory() . '/inc/custom-widgets/mini-list-widget.php';

// Grid List Posts Widget.
require get_template_directory() . '/inc/custom-widgets/grid-list-posts-widget.php';

// Grid Posts Widget.
require get_template_directory() . '/inc/custom-widgets/grid-posts-widget.php';

// List Posts Widget.
require get_template_directory() . '/inc/custom-widgets/list-posts-widget.php';

// Social Widget.
require get_template_directory() . '/inc/custom-widgets/social-widget.php';

// Tile Posts Widget.
require get_template_directory() . '/inc/custom-widgets/tile-posts-widget.php';

/**
 * Register Widgets
 */
function news_post_pro_register_widgets() {

	register_widget( 'News_Post_Mini_List_Widget' );

	register_widget( 'News_Post_Grid_List_Posts_Widget' );

	register_widget( 'News_Post_Grid_Posts_Widget' );

	register_widget( 'News_Post_List_Posts_Widget' );

	register_widget( 'News_Post_Social_Widget' );

	register_widget( 'News_Post_Tile_Posts_Widget' );

}
add_action( 'widgets_init', 'news_post_pro_register_widgets' );

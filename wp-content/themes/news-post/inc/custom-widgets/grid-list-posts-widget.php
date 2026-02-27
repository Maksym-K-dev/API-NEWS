<?php
if ( ! class_exists( 'News_Post_Grid_List_Posts_Widget' ) ) {
	/**
	 * Adds News Post Grid List Widget.
	 */
	class News_Post_Grid_List_Posts_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		public function __construct() {
			$grid_list_widget = array(
				'classname'   => 'news-post-widget grid-list-posts-widget',
				'description' => __( 'Retrive Grid List Widgets', 'news-post' ),
			);
			parent::__construct(
				'news_post_grid_list_posts_widget',
				__( 'Artify Widget: Grid List Widget', 'news-post' ),
				$grid_list_widget
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! isset( $args['widget_id'] ) ) {
				$args['widget_id'] = $this->id;
			}
			$grid_list_title        = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			$grid_list_title        = apply_filters( 'widget_title', $grid_list_title, $instance, $this->id_base );
			$grid_list_button_label = ( ! empty( $instance['button_label'] ) ) ? $instance['button_label'] : '';
			$grid_list_readmore_btn = ( ! empty( $instance['readmore_btn'] ) ) ? $instance['readmore_btn'] : '';
			$grid_list_post_offset  = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$grid_list_category     = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			$grid_list_button_link  = ( ! empty( $instance['button_link'] ) ) ? $instance['button_link'] : esc_url( get_category_link( $grid_list_category ) );

			echo $args['before_widget'];

			if ( ! empty( $grid_list_title || $grid_list_button_label ) ) {
				?>
				<div class="header-title">
					<?php echo $args['before_title'] . esc_html( $grid_list_title ) . $args['after_title']; ?>
					<?php if ( ! empty( $grid_list_button_label ) ) : ?>
						<a href="<?php echo esc_url( $grid_list_button_link ); ?>" class="view-all"><?php echo esc_html( $grid_list_button_label ); ?></a>
					<?php endif; ?>
				</div>
			<?php } ?>
			<div class="widget-content-area">

				<?php
				$grid_list_widgets_args = array(
					'post_type'      => 'post',
					'posts_per_page' => absint( 4 ),
					'offset'         => absint( $grid_list_post_offset ),
					'cat'            => absint( $grid_list_category ),
				);

				$query = new WP_Query( $grid_list_widgets_args );
				if ( $query->have_posts() ) :
					$i = 1;
					while ( $query->have_posts() ) :
						$query->the_post();
						$excerpt = wp_trim_words( get_the_content(), 15 );
						?>
						<div class="single-card-container <?php echo esc_attr( $i === 1 ? 'grid-card' : 'list-card' ); ?>">
							<div class="single-card-image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>							
								</a>
							</div>
							<div class="single-card-detail">
								<?php news_post_categories_list(); ?>								
								<h3 class="card-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>  
								<div class="card-meta">
									<?php
										news_post_posted_by();
										news_post_posted_on();
									?>
								</div>
								<?php if ( $i === 1 ) { ?>
									<div class="post-exerpt">
										<p><?php echo wp_kses_post( $excerpt ); ?></p>
									</div>
									<?php if ( ! empty( $grid_list_readmore_btn ) ) : ?>
										<div class="post-button">
											<a href="<?php the_permalink(); ?>" class="read-more-button"><?php echo esc_html( $grid_list_readmore_btn ); ?></a>
										</div>
									<?php endif; ?>
								<?php } ?>
							</div>
						</div>
						<?php
						$i++;
					endwhile;
					wp_reset_postdata();
				endif;
				?>

			</div>
			<?php
			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {
			$grid_list_title        = isset( $instance['title'] ) ? $instance['title'] : '';
			$grid_list_button_label = isset( $instance['button_label'] ) ? $instance['button_label'] : '';
			$grid_list_button_link  = isset( $instance['button_link'] ) ? $instance['button_link'] : '';
			$grid_list_readmore_btn = isset( $instance['readmore_btn'] ) ? $instance['readmore_btn'] : '';
			$grid_list_post_offset  = isset( $instance['offset'] ) ? absint( $instance['offset'] ) : '';
			$grid_list_category     = isset( $instance['category'] ) ? absint( $instance['category'] ) : '';
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Section Title:', 'news-post' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $grid_list_title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>"><?php esc_html_e( 'View All Button:', 'news-post' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_label' ) ); ?>" type="text" value="<?php echo esc_attr( $grid_list_button_label ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'View All Button URL:', 'news-post' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" type="text" value="<?php echo esc_attr( $grid_list_button_link ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'readmore_btn' ) ); ?>"><?php esc_html_e( 'Read More Button:', 'news-post' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_btn' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_btn' ) ); ?>" type="text" value="<?php echo esc_attr( $grid_list_readmore_btn ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Number of posts to displace or pass over:', 'news-post' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" step="1" min="0" value="<?php echo absint( $grid_list_post_offset ); ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php esc_html_e( 'Select the category to show posts:', 'news-post' ); ?></label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>" class="widefat" style="width:100%;">
					<?php
					$categories = news_post_get_post_cat_choices();
					foreach ( $categories as $category => $value ) {
						?>
						<option value="<?php echo absint( $category ); ?>" <?php selected( $grid_list_category, $category ); ?>><?php echo esc_html( $value ); ?></option>
					<?php } ?>      
				</select>
			</p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			$instance                 = $old_instance;
			$instance['title']        = sanitize_text_field( $new_instance['title'] );
			$instance['button_label'] = sanitize_text_field( $new_instance['button_label'] );
			$instance['button_link']  = esc_url_raw( $new_instance['button_link'] );
			$instance['readmore_btn'] = sanitize_text_field( $new_instance['readmore_btn'] );
			$instance['offset']       = (int) $new_instance['offset'];
			$instance['category']     = (int) $new_instance['category'];
			return $instance;
		}
	}
}

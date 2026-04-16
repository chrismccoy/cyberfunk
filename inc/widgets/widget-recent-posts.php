<?php
/**
 * Recent Posts widget — RECENT_TRANSMISSIONS block.
 *
 * @package Cyberfunk
 */

/**
 * Recent Posts widget — thumbnail/placeholder, category, title, and date.
 */
class Cyberfunk_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Registers the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_recent_posts',
			esc_html__( 'ND: Recent Posts', 'cyberfunk' ),
			[ 'description' => esc_html__( 'Cyberfunk styled recent transmissions list.', 'cyberfunk' ) ]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : __( 'RECENT_TRANSMISSIONS', 'cyberfunk' );
		$status = ! empty( $instance['status'] ) ? $instance['status'] : __( 'LIVE', 'cyberfunk' );
		$count  = ! empty( $instance['count'] )  ? absint( $instance['count'] ) : 5;

		$recent_posts = new WP_Query( [
			'post_type'      => 'post',
			'posts_per_page' => $count,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
		] );

		if ( ! $recent_posts->have_posts() ) {
			return;
		}

		echo $args['before_widget'];
		cyberfunk_widget_header( $label, $status );
		?>
		<div class="recent-posts-list">
			<?php
			while ( $recent_posts->have_posts() ) :
				$recent_posts->the_post();

				// Primary category for [SYS::CATEGORY] label.
				$categories = get_the_category();
				$cat_name   = ! empty( $categories ) ? strtoupper( $categories[0]->name ) : 'UNCATEGORIZED';
				?>
				<div class="recent-post-item">

					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" class="recent-thumb-link" tabindex="-1" aria-hidden="true">
							<?php
							the_post_thumbnail(
								'cyberfunk-mini',
								[
									'class'   => 'recent-thumb',
									'loading' => 'lazy',
									'alt'     => '',
								]
							);
							?>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>" class="recent-thumb-link recent-thumb-placeholder" tabindex="-1" aria-hidden="true">
							<i class="fa-solid fa-image" aria-hidden="true"></i>
						</a>
					<?php endif; ?>

					<div class="recent-meta">
						<div class="recent-cat">[SYS::<?php echo esc_html( $cat_name ); ?>]</div>
						<a href="<?php the_permalink(); ?>" class="recent-title"><?php the_title(); ?></a>
						<div class="recent-date">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
							</time>
						</div>
					</div>

				</div>
			<?php endwhile; ?>
		</div>
		</div>
		<?php
		wp_reset_postdata();
		echo $args['after_widget'];
	}

	/**
	 * Sanitizes and saves widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		return [
			'label'  => sanitize_text_field( $new_instance['label'] ),
			'status' => sanitize_text_field( $new_instance['status'] ),
			'count'  => absint( $new_instance['count'] ),
		];
	}

	/**
	 * Admin settings form.
	 */
	public function form( $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : 'RECENT_TRANSMISSIONS';
		$status = ! empty( $instance['status'] ) ? $instance['status'] : 'LIVE';
		$count  = ! empty( $instance['count'] )  ? absint( $instance['count'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Widget Label:', 'cyberfunk' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>"><?php esc_html_e( 'Status Badge:', 'cyberfunk' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'status' ) ); ?>" type="text" value="<?php echo esc_attr( $status ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'cyberfunk' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="20" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php
	}
}

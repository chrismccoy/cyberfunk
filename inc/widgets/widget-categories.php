<?php
/**
 * Categories widget — SECTORS block.
 *
 * @package Cyberfunk
 */

/**
 * Categories widget — colored icon list with post count badges.
 */
class Cyberfunk_Categories_Widget extends WP_Widget {

	/**
	 * Registers the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_categories',
			esc_html__( 'ND: Categories', 'cyberfunk' ),
			[ 'description' => esc_html__( 'Cyberfunk styled category list with colored icons and counts.', 'cyberfunk' ) ]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : __( 'SECTORS', 'cyberfunk' );
		$status = ! empty( $instance['status'] ) ? $instance['status'] : __( 'INDEXED', 'cyberfunk' );

		$categories = get_categories( [
			'orderby'    => 'count',
			'order'      => 'DESC',
			'hide_empty' => true,
		] );

		if ( empty( $categories ) ) {
			return;
		}

		echo $args['before_widget'];
		cyberfunk_widget_header( $label, $status );
		?>
		<ul class="cat-list">
			<?php foreach ( $categories as $category ) :
				$color_class = cyberfunk_category_color_class( $category->slug );
				$icon_class  = cyberfunk_category_icon( $category->slug );
			?>
				<li class="cat-item">
					<a
						href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
						class="cat-link <?php echo esc_attr( $color_class ); ?>"
					>
						<i class="<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
						<?php echo esc_html( $category->name ); ?>
					</a>
					<span class="cat-count"><?php echo absint( $category->count ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Sanitizes and saves widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		return [
			'label'  => sanitize_text_field( $new_instance['label'] ),
			'status' => sanitize_text_field( $new_instance['status'] ),
		];
	}

	/**
	 * Admin settings form.
	 */
	public function form( $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : 'SECTORS';
		$status = ! empty( $instance['status'] ) ? $instance['status'] : 'INDEXED';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>"><?php esc_html_e( 'Widget Label:', 'cyberfunk' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label' ) ); ?>" type="text" value="<?php echo esc_attr( $label ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>"><?php esc_html_e( 'Status Badge:', 'cyberfunk' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'status' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'status' ) ); ?>" type="text" value="<?php echo esc_attr( $status ); ?>">
		</p>
		<?php
	}
}

<?php
/**
 * Tag Cloud widget — TAG_MATRIX block.
 *
 * @package Cyberfunk
 */

/**
 * Tag Cloud widget — cloud-tag links with relative size variants.
 */
class Cyberfunk_Tag_Cloud_Widget extends WP_Widget {

	/**
	 * Registers the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_tag_cloud',
			esc_html__( 'ND: Tag Cloud', 'cyberfunk' ),
			[ 'description' => esc_html__( 'Cyberfunk styled tag cloud with size variants.', 'cyberfunk' ) ]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : __( 'TAG_MATRIX', 'cyberfunk' );
		$status = ! empty( $instance['status'] ) ? $instance['status'] : __( 'MAPPED', 'cyberfunk' );
		$count  = ! empty( $instance['count'] )  ? absint( $instance['count'] ) : 18;

		$tags = get_terms( [
			'taxonomy'   => 'post_tag',
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => $count,
			'hide_empty' => true,
		] );

		if ( is_wp_error( $tags ) || empty( $tags ) ) {
			return;
		}

		// Compute size thresholds from the fetched set.
		$counts    = wp_list_pluck( $tags, 'count' );
		$max_count = (int) max( $counts );
		$min_count = (int) min( $counts );
		$range     = max( 1, $max_count - $min_count );
		$lg_floor  = $min_count + ( $range * 0.67 );
		$sm_ceil   = $min_count + ( $range * 0.33 );

		echo $args['before_widget'];
		cyberfunk_widget_header( $label, $status );
		?>
		<div class="tag-cloud">
			<?php foreach ( $tags as $tag ) :
				$size_class = '';
				if ( $tag->count >= $lg_floor ) {
					$size_class = 'lg';
				} elseif ( $tag->count <= $sm_ceil ) {
					$size_class = 'sm';
				}
				$classes = 'cloud-tag' . ( $size_class ? ' ' . $size_class : '' );
			?>
				<a
					href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
					class="<?php echo esc_attr( $classes ); ?>"
				><?php echo esc_html( $tag->name ); ?></a>
			<?php endforeach; ?>
		</div>
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
			'count'  => absint( $new_instance['count'] ),
		];
	}

	/**
	 * Admin settings form.
	 */
	public function form( $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : 'TAG_MATRIX';
		$status = ! empty( $instance['status'] ) ? $instance['status'] : 'MAPPED';
		$count  = ! empty( $instance['count'] )  ? absint( $instance['count'] ) : 18;
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Max tags to show:', 'cyberfunk' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" max="50" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php
	}
}

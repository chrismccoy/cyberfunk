<?php
/**
 * Recently Viewed widget
 *
 * @package Cyberfunk
 */

/**
 * Displays the last N posts the visitor has viewed, read from localStorage.
 */
class Cyberfunk_Recently_Viewed_Widget extends WP_Widget {

	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_recently_viewed',
			esc_html__( 'Cyberfunk — Recently Viewed', 'cyberfunk' ),
			[
				'description' => esc_html__( 'Posts the visitor has recently viewed, rendered from browser history (localStorage).', 'cyberfunk' ),
			]
		);
	}

	/**
	 * Outputs the widget front end.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] )
			? $instance['title']
			: esc_html__( 'RECENTLY VIEWED', 'cyberfunk' );

		echo $args['before_widget'];
		cyberfunk_widget_header( esc_html( $title ), esc_html__( 'LOCAL_CACHE', 'cyberfunk' ) );
		?>
		<div
			class="recently-viewed-widget"
			id="cf-recently-viewed"
			data-empty="<?php esc_attr_e( 'No posts viewed yet.', 'cyberfunk' ); ?>"
		></div>
		<?php
		echo '</div>'; // Close .widget-body opened by cyberfunk_widget_header().
		echo $args['after_widget'];
	}

	/**
	 * Outputs the widget settings form in wp-admin.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'cyberfunk' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $title ); ?>"
			>
		</p>
		<?php
	}

	/**
	 * Sanitises and saves the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		return [ 'title' => sanitize_text_field( $new_instance['title'] ) ];
	}
}

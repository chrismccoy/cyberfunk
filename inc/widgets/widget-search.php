<?php
/**
 * Search widget — SEARCH_MODULE block.
 *
 * @package Cyberfunk
 */

/**
 * Search widget — reproduces the SEARCH_MODULE block from the source design.
 */
class Cyberfunk_Search_Widget extends WP_Widget {

	/**
	 * Registers the widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_search',
			esc_html__( 'ND: Search', 'cyberfunk' ),
			[ 'description' => esc_html__( 'Cyberfunk styled search form.', 'cyberfunk' ) ]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : __( 'SEARCH_MODULE', 'cyberfunk' );
		$status = ! empty( $instance['status'] ) ? $instance['status'] : __( 'ACTIVE', 'cyberfunk' );

		echo $args['before_widget'];
		cyberfunk_widget_header( $label, $status );
		?>
		<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div class="search-input-wrap">
				<i class="fa-solid fa-magnifying-glass search-icon" aria-hidden="true"></i>
				<label for="widget-s-<?php echo esc_attr( $this->id ); ?>" class="sr-only">
					<?php esc_html_e( 'Search', 'cyberfunk' ); ?>
				</label>
				<input
					type="search"
					id="widget-s-<?php echo esc_attr( $this->id ); ?>"
					name="s"
					class="search-input"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					placeholder="<?php esc_attr_e( 'QUERY THE ARCHIVE…', 'cyberfunk' ); ?>"
					autocomplete="off"
				>
			</div>
			<button type="submit" class="search-btn" aria-label="<?php esc_attr_e( 'Execute search', 'cyberfunk' ); ?>">
				<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i><span class="search-btn-text">&nbsp;<?php esc_html_e( 'EXECUTE SEARCH', 'cyberfunk' ); ?></span>
			</button>
		</form>
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
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : 'SEARCH_MODULE';
		$status = ! empty( $instance['status'] ) ? $instance['status'] : 'ACTIVE';
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

<?php
/**
 * Archives widget — DATA_VAULT block.
 *
 * @package Cyberfunk
 */

/**
 * Archives widget — year accordion with monthly links.
 */
class Cyberfunk_Archives_Widget extends WP_Widget {

	/**
	 * Registers the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_archives',
			esc_html__( 'ND: Archives', 'cyberfunk' ),
			[ 'description' => esc_html__( 'Cyberfunk styled year/month accordion archive.', 'cyberfunk' ) ]
		);
	}

	/**
	 * Front-end output.
	 */
	public function widget( $args, $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : __( 'DATA_VAULT', 'cyberfunk' );
		$status = ! empty( $instance['status'] ) ? $instance['status'] : __( 'SEALED', 'cyberfunk' );

		global $wpdb;

		$months = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT YEAR(post_date) AS year, MONTH(post_date) AS month, COUNT(ID) AS count
				 FROM {$wpdb->posts}
				 WHERE post_status = %s AND post_type = %s
				 GROUP BY YEAR(post_date), MONTH(post_date)
				 ORDER BY post_date DESC",
				'publish',
				'post'
			)
		);

		if ( empty( $months ) ) {
			return;
		}

		// Group results by year.
		$by_year = [];
		foreach ( $months as $row ) {
			$yr = (int) $row->year;
			if ( ! isset( $by_year[ $yr ] ) ) {
				$by_year[ $yr ] = [];
			}
			$by_year[ $yr ][] = $row;
		}

		echo $args['before_widget'];
		cyberfunk_widget_header( $label, $status );
		?>
		<div class="archives-accordion">
			<?php
			$first = true;
			foreach ( $by_year as $year => $year_months ) :
				$is_open    = $first;
				$item_class = 'archive-item' . ( $is_open ? ' open' : '' );
				$aria_exp   = $is_open ? 'true' : 'false';
			?>
			<div class="<?php echo esc_attr( $item_class ); ?>">
				<button
					class="archive-toggle"
					aria-expanded="<?php echo esc_attr( $aria_exp ); ?>"
					type="button"
				>
					<span class="archive-year"><?php echo absint( $year ); ?></span>
					<i class="fa-solid fa-chevron-right archive-toggle-icon" aria-hidden="true"></i>
				</button>
				<div class="archive-months">
					<?php foreach ( $year_months as $month_row ) :
						$month_url  = get_month_link( absint( $month_row->year ), absint( $month_row->month ) );
						$month_name = date_i18n( 'F', mktime( 0, 0, 0, (int) $month_row->month, 1, (int) $month_row->year ) );
					?>
						<a href="<?php echo esc_url( $month_url ); ?>">
							<?php echo esc_html( $month_name ); ?>
							<span><?php echo absint( $month_row->count ); ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
				$first = false;
			endforeach;
			?>
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
		];
	}

	/**
	 * Admin settings form.
	 */
	public function form( $instance ) {
		$label  = ! empty( $instance['label'] )  ? $instance['label']  : 'DATA_VAULT';
		$status = ! empty( $instance['status'] ) ? $instance['status'] : 'SEALED';
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

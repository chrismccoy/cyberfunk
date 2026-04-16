<?php
/**
 * Series Progress widget — shows read progress through the current post's series.
 *
 * @package Cyberfunk
 */

/**
 * Displays progress through the series the current post belongs to.
 */
class Cyberfunk_Series_Progress_Widget extends WP_Widget {

	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_series_progress',
			esc_html__( 'Cyberfunk — Series Progress', 'cyberfunk' ),
			[
				'description' => esc_html__( 'Shows how far into the current series the visitor has read. Only visible on single posts that belong to a series.', 'cyberfunk' ),
			]
		);
	}

	/**
	 * Outputs the widget front end.
	 */
	public function widget( $args, $instance ) {
		// Only render on single posts.
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$series = get_the_terms( get_the_ID(), 'post_series' );
		if ( empty( $series ) || is_wp_error( $series ) ) {
			return;
		}

		$series_term = $series[0];

		$posts = get_posts( [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'numberposts'    => -1,
			'tax_query'      => [
				[
					'taxonomy' => 'post_series',
					'field'    => 'term_id',
					'terms'    => $series_term->term_id,
				],
			],
			'meta_key'       => '_cyberfunk_series_order',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		] );

		if ( empty( $posts ) ) {
			return;
		}

		$current_id = get_the_ID();

		echo $args['before_widget'];
		cyberfunk_widget_header( esc_html( strtoupper( $series_term->name ) ), esc_html__( 'SERIES', 'cyberfunk' ) );
		?>
		<div class="sp-bar-wrap" aria-hidden="true">
			<div class="sp-bar" id="sp-bar"></div>
		</div>
		<p class="sp-status" id="sp-status" aria-live="polite"></p>
		<ol class="sp-list">
			<?php foreach ( $posts as $sp_post ) :
				$is_current = ( $sp_post->ID === $current_id );
			?>
				<li
					class="sp-item<?php echo $is_current ? ' sp-current' : ''; ?>"
					data-post-id="<?php echo absint( $sp_post->ID ); ?>"
				>
					<a
						href="<?php echo esc_url( get_permalink( $sp_post->ID ) ); ?>"
						class="sp-title"
						<?php if ( $is_current ) : ?>aria-current="page"<?php endif; ?>
					><?php echo esc_html( strtoupper( get_the_title( $sp_post->ID ) ) ); ?></a>
					<span class="sp-check" aria-hidden="true">
						<i class="fa-solid fa-check"></i>
					</span>
				</li>
			<?php endforeach; ?>
		</ol>
		<?php
		echo '</div>'; // Close .widget-body.
		echo $args['after_widget'];
	}

	/**
	 * Outputs the widget settings form in wp-admin.
	 */
	public function form( $instance ) {
		?>
		<p><?php esc_html_e( 'No settings — the widget automatically displays progress for the series of the post being viewed.', 'cyberfunk' ); ?></p>
		<?php
	}

	/**
	 * Sanitises and saves the widget settings (none for this widget).
	 */
	public function update( $new_instance, $old_instance ) {
		return [];
	}
}

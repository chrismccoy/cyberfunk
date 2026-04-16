<?php
/**
 * Cyberfunk Most Viewed Posts Widget.
 *
 * @package Cyberfunk
 */

/**
 * Class Cyberfunk_Most_Viewed_Widget
 */
class Cyberfunk_Most_Viewed_Widget extends WP_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_most_viewed',
			esc_html__( 'Cyberfunk: Most Viewed', 'cyberfunk' ),
			[
				'description' => esc_html__( 'Displays the most-viewed posts based on the theme view counter.', 'cyberfunk' ),
				'classname'   => 'widget-most-viewed',
			]
		);
	}

	/**
	 * Outputs the widget content on the front end.
	 */
	public function widget( $args, $instance ) {
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$number = max( 1, min( 10, $number ) );

		$posts = new WP_Query( [
			'post_type'           => 'post',
			'posts_per_page'      => $number,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'meta_key'            => 'cyberfunk_view_count',
			'orderby'             => 'meta_value_num',
			'order'               => 'DESC',
			'meta_query'          => [
				[
					'key'     => 'cyberfunk_view_count',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'NUMERIC',
				],
			],
		] );

		if ( ! $posts->have_posts() ) {
			return;
		}

		echo wp_kses_post( $args['before_widget'] );
		cyberfunk_widget_header(
			esc_html__( 'TOP_TRANSMISSIONS', 'cyberfunk' ),
			esc_html__( 'MOST_VIEWED', 'cyberfunk' )
		);
		?>
		<ul class="recent-posts-list">
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<li class="recent-post-item">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" class="rp-thumb-link">
							<?php the_post_thumbnail( 'cyberfunk-mini', [ 'loading' => 'lazy', 'alt' => '' ] ); ?>
						</a>
					<?php endif; ?>
					<div class="rp-content">
						<?php cyberfunk_category_badge(); ?>
						<a href="<?php the_permalink(); ?>" class="rp-title">
							<?php echo esc_html( strtoupper( get_the_title() ) ); ?>
						</a>
						<div class="rp-meta">
							<span class="rp-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
							<span class="rp-views">
								<i class="fa-solid fa-eye" aria-hidden="true"></i>
								<?php
								printf(
									esc_html__( '%d VIEWS', 'cyberfunk' ),
									absint( get_post_meta( get_the_ID(), 'cyberfunk_view_count', true ) )
								);
								?>
							</span>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</ul>
		<?php
		echo '</div>';
		echo wp_kses_post( $args['after_widget'] );
	}

	/**
	 * Outputs the widget settings form in wp-admin.
	 */
	public function form( $instance ) {
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php esc_html_e( 'Number of posts to show (1–10):', 'cyberfunk' ); ?>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>"
				type="number"
				min="1"
				max="10"
				value="<?php echo absint( $number ); ?>"
			>
		</p>
		<?php
	}

	/**
	 * Saves widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = [];
		$instance['number'] = max( 1, min( 10, absint( $new_instance['number'] ?? 5 ) ) );
		return $instance;
	}
}

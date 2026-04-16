<?php
/**
 * Recently Commented widget
 *
 * @package Cyberfunk
 */

/**
 * Lists posts that have received the most recent approved comments.
 */
class Cyberfunk_Recently_Commented_Widget extends WP_Widget {

	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		parent::__construct(
			'cyberfunk_recently_commented',
			esc_html__( 'Cyberfunk — Recently Commented', 'cyberfunk' ),
			[
				'description' => esc_html__( 'Posts that have received the most recent comments.', 'cyberfunk' ),
			]
		);
	}

	/**
	 * Outputs the widget front end.
	 */
	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] )
			? $instance['title']
			: esc_html__( 'ACTIVE_THREADS', 'cyberfunk' );
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
		$count = min( 10, max( 1, $count ) );

		// Fetch recent approved comments and deduplicate by post.
		$comments = get_comments( [
			'number'      => $count * 3, // Over-fetch to allow for deduplication.
			'status'      => 'approve',
			'post_status' => 'publish',
			'type'        => 'comment',
		] );

		$seen  = [];
		$items = [];
		foreach ( $comments as $comment ) {
			$pid = (int) $comment->comment_post_ID;
			if ( ! isset( $seen[ $pid ] ) ) {
				$seen[ $pid ] = true;
				$items[]      = $comment;
				if ( count( $items ) >= $count ) {
					break;
				}
			}
		}

		if ( empty( $items ) ) {
			return;
		}

		echo $args['before_widget'];
		cyberfunk_widget_header( esc_html( $title ), esc_html__( 'ACTIVE', 'cyberfunk' ) );
		?>
		<ul class="rc-widget-list">
			<?php foreach ( $items as $comment ) :
				$pid        = (int) $comment->comment_post_ID;
				$post_title = get_the_title( $pid );
				$post_url   = get_permalink( $pid ) . '#comment-' . absint( $comment->comment_ID );
				$time_ago = sprintf(
					esc_html__( '%s ago', 'cyberfunk' ),
					human_time_diff( strtotime( $comment->comment_date_gmt ), time() )
				);
			?>
				<li class="rc-item">
					<a href="<?php echo esc_url( $post_url ); ?>" class="rc-title">
						<?php echo esc_html( strtoupper( $post_title ) ); ?>
					</a>
					<span class="rc-by">
						<?php echo esc_html( $comment->comment_author ); ?>
						&mdash;
						<?php echo esc_html( $time_ago ); ?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
		echo '</div>'; // Close .widget-body.
		echo $args['after_widget'];
	}

	/**
	 * Outputs the widget settings form in wp-admin.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 5;
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
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
				<?php esc_html_e( 'Number of posts to show (1–10):', 'cyberfunk' ); ?>
			</label>
			<input
				class="tiny-text"
				id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
				type="number"
				min="1"
				max="10"
				value="<?php echo absint( $count ); ?>"
			>
		</p>
		<?php
	}

	/**
	 * Sanitises and saves the widget settings.
	 */
	public function update( $new_instance, $old_instance ) {
		return [
			'title' => sanitize_text_field( $new_instance['title'] ),
			'count' => min( 10, max( 1, absint( $new_instance['count'] ) ) ),
		];
	}
}

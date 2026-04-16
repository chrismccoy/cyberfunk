<?php
/**
 * Comments callback
 *
 * @package Cyberfunk
 */

/**
 * Renders a single comment in the cyberpunk HUD style.
 */
if ( ! function_exists( 'cyberfunk_comment_callback' ) ) :
	function cyberfunk_comment_callback( $comment, $args, $depth ) {
		$depth_class = 'depth-' . absint( $depth );

		// Build initials from commenter display name.
		$name    = get_comment_author( $comment );
		$parts   = explode( ' ', trim( $name ), 2 );
		$initial = strtoupper( substr( $parts[0], 0, 1 ) );
		if ( isset( $parts[1] ) ) {
			$initial .= strtoupper( substr( $parts[1], 0, 1 ) );
		}

		$avatar_html = get_avatar( $comment, 40, '', esc_attr( $name ), [ 'class' => 'comment-avatar-img' ] );
		$is_mod      = user_can( (int) $comment->user_id, 'moderate_comments' );
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( [ 'comment', $depth_class ], $comment ); ?>>
		<div class="comment-inner">

			<div class="comment-header">
				<div class="comment-avatar-wrap" aria-hidden="true">
					<?php if ( $avatar_html ) : ?>
						<?php echo $avatar_html; ?>
					<?php else : ?>
						<div class="comment-avatar-initials"><?php echo esc_html( $initial ); ?></div>
					<?php endif; ?>
				</div>
				<div class="comment-meta">
					<div class="comment-author-name <?php echo esc_attr( $is_mod ? 'is-mod' : '' ); ?>">
						<?php echo esc_html( $name ); ?>
						<?php if ( $is_mod ) : ?>
							<span class="mod-badge" aria-label="<?php esc_attr_e( 'Moderator', 'cyberfunk' ); ?>">
								<?php esc_html_e( '[MOD]', 'cyberfunk' ); ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="comment-date">
						<i class="fa-solid fa-signal" aria-hidden="true"></i>
						<time datetime="<?php echo esc_attr( get_comment_date( 'c', $comment ) ); ?>">
							<?php
							printf(
								esc_html_x( '%1$s // %2$s', 'comment date and time', 'cyberfunk' ),
								esc_html( get_comment_date( 'Y.m.d', $comment ) ),
								esc_html( get_comment_time( 'H:i', false, false, $comment ) )
							);
							?>
						</time>
					</div>
				</div>
			</div>

			<?php if ( '0' === $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation">
					<?php esc_html_e( 'TRANSMISSION PENDING CLEARANCE.', 'cyberfunk' ); ?>
				</p>
			<?php endif; ?>

			<div class="comment-body">
				<?php comment_text(); ?>
			</div>

			<div class="comment-actions">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						[
							'depth'     => $depth,
							'before'    => '<div class="comment-reply-wrap">',
							'after'     => '</div>',
							'reply_text' => '<i class="fa-solid fa-reply" aria-hidden="true"></i> ' . esc_html__( 'REPLY', 'cyberfunk' ),
						]
					)
				);
				?>
			</div>

		</div>
		<?php
		// Note: li closing tag is handled by wp_list_comments().
	}
endif;

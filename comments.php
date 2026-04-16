<?php
/**
 * Comments template.
 *
 * @package Cyberfunk
 */

if ( post_password_required() ) {
	?>
	<div class="comment-list-wrap">
		<p class="comments-password-notice">
			<?php esc_html_e( 'This transmission is encrypted. Enter the password to decode.', 'cyberfunk' ); ?>
		</p>
	</div>
	<?php
	return;
}
?>

<section id="comments" class="comments-section">

	<?php if ( have_comments() ) : ?>

		<div class="comments-header-wrap">
			<div class="section-title">
				<?php
				$comment_count = get_comments_number();
				printf(
					esc_html( _nx(
						'%s TRANSMISSION RECEIVED',
						'%s TRANSMISSIONS RECEIVED',
						$comment_count,
						'comment count heading',
						'cyberfunk'
					) ),
					number_format_i18n( $comment_count )
				);
				?>
			</div>
		</div>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 40,
				'callback'    => 'cyberfunk_comment_callback',
			] );
			?>
		</ol>

		<?php
		the_comments_navigation( [
			'prev_text' => '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i> ' . esc_html__( 'OLDER', 'cyberfunk' ),
			'next_text' => esc_html__( 'NEWER', 'cyberfunk' ) . ' <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
		] );
		?>

		<div class="neon-line" aria-hidden="true"></div>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="comments-closed-notice">
			<?php esc_html_e( 'TRANSMISSION CHANNEL CLOSED.', 'cyberfunk' ); ?>
		</p>
	<?php endif; ?>

	<?php
	if ( comments_open() ) :
		$commenter    = wp_get_current_commenter();
		$req          = get_option( 'require_name_email' );
		$aria_req     = $req ? ' aria-required="true"' : '';

		comment_form( [
			'id_form'              => 'commentform',
			'class_form'           => 'comment-form-section',
			'title_reply_before'   => '<div class="form-header">',
			'title_reply'          => esc_html__( 'TRANSMIT_RESPONSE', 'cyberfunk' ),
			'title_reply_to'       => esc_html__( 'REPLY TO %s', 'cyberfunk' ),
			'title_reply_after'    => '</div>',
			'cancel_reply_before'  => '',
			'cancel_reply_after'   => '',
			'cancel_reply_link'    => esc_html__( '[CANCEL]', 'cyberfunk' ),
			'label_submit'         => esc_html__( 'TRANSMIT RESPONSE', 'cyberfunk' ),
			'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn-primary"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> %4$s</button>',
			'submit_field'         => '<div class="form-footer">%1$s %2$s</div>',
			'comment_field'        => '<div class="form-field full"><label class="form-label" for="comment">' . esc_html__( 'TRANSMISSION_BODY', 'cyberfunk' ) . ' <span class="required" aria-hidden="true">*</span></label><textarea id="comment" name="comment" class="form-textarea" aria-required="true" placeholder="' . esc_attr__( 'COMPOSE YOUR TRANSMISSION…', 'cyberfunk' ) . '"></textarea></div>',
			'fields'               => [
				'author' => '<div class="form-grid"><div class="form-field"><label class="form-label" for="author">' . esc_html__( 'OPERATIVE_ID', 'cyberfunk' ) . ( $req ? ' <span class="required" aria-hidden="true">*</span>' : '' ) . '</label><input id="author" name="author" type="text" class="form-input" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" autocomplete="name"' . $aria_req . ' placeholder="' . esc_attr__( 'YOUR HANDLE OR ALIAS', 'cyberfunk' ) . '"></div>',
				'email'  => '<div class="form-field"><label class="form-label" for="email">' . esc_html__( 'ENCRYPTED_CHANNEL', 'cyberfunk' ) . ( $req ? ' <span class="required" aria-hidden="true">*</span>' : '' ) . '</label><input id="email" name="email" type="email" class="form-input" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" autocomplete="email"' . $aria_req . ' placeholder="' . esc_attr__( 'YOUR EMAIL (NOT PUBLISHED)', 'cyberfunk' ) . '"></div>',
				'url'    => '<div class="form-field"><label class="form-label" for="url">' . esc_html__( 'SIGNAL_ORIGIN', 'cyberfunk' ) . '</label><input id="url" name="url" type="url" class="form-input" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" autocomplete="url" placeholder="' . esc_attr__( 'YOUR SITE OR PROFILE (OPTIONAL)', 'cyberfunk' ) . '"></div></div>',
			],
			'comment_notes_before' => '',
			'comment_notes_after'  => '<p class="form-disclaimer">' . esc_html__( 'Your email address will not be published.', 'cyberfunk' ) . ( $req ? ' ' . esc_html__( 'Required fields are marked *', 'cyberfunk' ) : '' ) . '</p>',
		] );
	endif;
	?>

</section>

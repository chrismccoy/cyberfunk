<?php
/**
 * Template part: password-protected post card.
 *
 * @package Cyberfunk
 */
?>
<div class="post-wrap">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

		<div class="post-content">

			<?php cyberfunk_category_badge(); ?>

			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php cyberfunk_posted_on(); ?>

			<div class="password-required">
				<p class="password-notice">
					<i class="fa-solid fa-lock" aria-hidden="true"></i>
					<?php esc_html_e( 'CLASSIFIED :: AUTHENTICATION REQUIRED', 'cyberfunk' ); ?>
				</p>
				<?php echo get_the_password_form(); ?>
			</div>

		</div>

	</article>
</div>

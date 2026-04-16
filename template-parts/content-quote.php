<?php
/**
 * Template part: quote post format card.
 *
 * @package Cyberfunk
 */
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>
<div class="post-wrap post-format-quote<?php echo is_sticky() ? ' sticky' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card post-card--quote' ); ?>>

		<div class="post-content">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<span class="format-badge format-badge--quote">
				<i class="fa-solid fa-quote-left" aria-hidden="true"></i>
				<?php esc_html_e( 'QUOTE', 'cyberfunk' ); ?>
			</span>

			<a href="<?php the_permalink(); ?>" class="quote-card-body">
				<span class="quote-mark" aria-hidden="true">&ldquo;</span>
				<blockquote class="quote-card-text">
					<?php echo wp_kses_post( get_the_excerpt() ); ?>
				</blockquote>
			</a>

			<?php cyberfunk_posted_on(); ?>

			<div class="post-footer">
				<a href="<?php the_permalink(); ?>" class="read-more-btn">
					<?php esc_html_e( 'FULL_QUOTE', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

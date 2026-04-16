<?php
/**
 * Template part: aside post format card.
 *
 * @package Cyberfunk
 */
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>
<div class="post-wrap post-format-aside<?php echo is_sticky() ? ' sticky' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card post-card--aside' ); ?>>

		<div class="post-content">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<span class="format-badge format-badge--aside">
				<i class="fa-solid fa-sticky-note" aria-hidden="true"></i>
				<?php esc_html_e( 'NOTE', 'cyberfunk' ); ?>
			</span>

			<?php if ( get_the_title() ) : ?>
				<h2 class="post-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
			<?php endif; ?>

			<?php cyberfunk_posted_on(); ?>

			<div class="aside-body">
				<?php the_excerpt(); ?>
			</div>

			<div class="post-footer">
				<a href="<?php the_permalink(); ?>" class="read-more-btn">
					<?php esc_html_e( 'READ_NOTE', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

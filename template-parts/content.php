<?php
/**
 * Template part: archive post card.
 *
 * @package Cyberfunk
 */
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>
<div class="post-wrap<?php echo is_sticky() ? ' sticky' : ''; ?>" data-reading-time="<?php echo absint( cyberfunk_reading_time() ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php
				the_post_thumbnail(
					'cyberfunk-card',
					[
						'class'   => 'post-thumbnail',
						'loading' => 'lazy',
						'alt'     => '',
					]
				);
				?>
			</a>
		<?php endif; ?>

		<div class="post-content">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<?php cyberfunk_category_badge(); ?>
			<?php cyberfunk_difficulty_badge(); ?>

			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php cyberfunk_posted_on(); ?>

			<p class="post-excerpt"><?php the_excerpt(); ?></p>

			<div class="post-footer">
				<a href="<?php the_permalink(); ?>" class="read-more-btn">
					<?php esc_html_e( 'DECRYPT', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_queue_button(); ?>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

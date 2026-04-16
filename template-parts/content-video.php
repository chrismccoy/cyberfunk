<?php
/**
 * Template part: video post format card.
 *
 * @package Cyberfunk
 */
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>
<div class="post-wrap post-format-video<?php echo is_sticky() ? ' sticky' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-thumb-video-wrap" tabindex="-1" aria-hidden="true">
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
				<span class="video-play-overlay" aria-hidden="true">
					<i class="fa-solid fa-play"></i>
				</span>
			</a>
		<?php endif; ?>

		<div class="post-content">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<span class="format-badge format-badge--video">
				<i class="fa-solid fa-film" aria-hidden="true"></i>
				<?php esc_html_e( 'VIDEO', 'cyberfunk' ); ?>
			</span>

			<?php cyberfunk_category_badge(); ?>

			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php cyberfunk_posted_on(); ?>

			<p class="post-excerpt"><?php the_excerpt(); ?></p>

			<div class="post-footer">
				<a href="<?php the_permalink(); ?>" class="read-more-btn">
					<?php esc_html_e( 'PLAY_FEED', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-play" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

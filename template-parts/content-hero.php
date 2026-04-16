<?php
/**
 * Template part: featured hero post card.
 *
 * @package Cyberfunk
 */
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>

<div class="post-wrap hero-wrap" data-reading-time="<?php echo absint( cyberfunk_reading_time() ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-hero-card' ); ?>>

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="hero-card-image-link" tabindex="-1" aria-hidden="true">
				<?php
				the_post_thumbnail(
					'cyberfunk-hero',
					[
						'class'         => 'hero-card-image',
						'fetchpriority' => 'high',
						'decoding'      => 'async',
						'alt'           => '',
					]
				);
				?>
				<div class="hero-card-overlay" aria-hidden="true"></div>
			</a>
		<?php endif; ?>

		<div class="hero-card-body">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<span class="hero-eyebrow" aria-hidden="true"><?php esc_html_e( 'FEATURED_TRANSMISSION', 'cyberfunk' ); ?></span>

			<?php cyberfunk_category_badge(); ?>

			<h2 class="hero-card-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<?php cyberfunk_posted_on(); ?>

			<p class="hero-card-excerpt"><?php the_excerpt(); ?></p>

			<div class="hero-card-footer">
				<a href="<?php the_permalink(); ?>" class="read-more-btn">
					<?php esc_html_e( 'DECRYPT', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

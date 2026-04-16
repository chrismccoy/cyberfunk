<?php
/**
 * Template part: single post content.
 *
 * @package Cyberfunk
 */
?>
<?php cyberfunk_breadcrumb(); ?>

<?php get_template_part( 'template-parts/series', 'nav' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="post-header">

		<?php cyberfunk_category_badge(); ?>
		<?php cyberfunk_difficulty_badge(); ?>

		<h1 class="post-main-title"><?php the_title(); ?></h1>

		<?php cyberfunk_single_meta(); ?>
		<?php cyberfunk_updated_notice(); ?>
		<?php cyberfunk_post_age_notice(); ?>

	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="post-hero-wrap">
			<?php
			the_post_thumbnail(
				'cyberfunk-hero',
				[
					'class'         => 'post-hero-img',
					'fetchpriority' => 'high',
					'decoding'      => 'async',
				]
			);
			?>
			<div class="post-hero-hud" aria-hidden="true">
				<span class="hero-hud-label">
					<?php
					$hud_cat  = get_the_category();
					$hud_name = ! empty( $hud_cat ) ? strtoupper( $hud_cat[0]->name ) : 'ARCHIVE';
					printf(
						'IMG::FEED // %s // %s',
						esc_html( $hud_name ),
						esc_html( get_the_date( 'Y' ) )
					);
					?>
				</span>
				<span class="hero-hud-counter">
					<?php
					printf(
						esc_html__( 'FILE_REF: POST_%d', 'cyberfunk' ),
						absint( get_the_ID() )
					);
					?>
				</span>
			</div>
		</div>
	<?php endif; ?>

	<div class="post-body">
		<?php the_content(); ?>

		<?php
		wp_link_pages( [
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'PAGES::', 'cyberfunk' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span class="page-link">',
			'link_after'  => '</span>',
		] );
		?>
	</div>

	<footer class="post-footer-meta">
		<?php cyberfunk_font_size_controls(); ?>
		<?php cyberfunk_post_tags_row(); ?>
		<?php cyberfunk_share_buttons(); ?>
		<?php cyberfunk_queue_button(); ?>
		<?php cyberfunk_reaction_buttons(); ?>
	</footer>

</article>

<?php get_template_part( 'template-parts/series', 'nav' ); ?>

<?php cyberfunk_related_posts(); ?>

<div class="neon-line" aria-hidden="true"></div>

<?php cyberfunk_author_bio(); ?>

<div class="neon-line" aria-hidden="true"></div>

<?php cyberfunk_post_navigation(); ?>

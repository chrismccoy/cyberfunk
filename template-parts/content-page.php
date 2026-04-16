<?php
/**
 * Template part: static page content.
 *
 * @package Cyberfunk
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-article' ); ?>>

	<header class="page-header">
		<h1 class="section-title"><?php the_title(); ?></h1>
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

	<?php
	edit_post_link(
		esc_html__( '[EDIT]', 'cyberfunk' ),
		'<div class="edit-link">',
		'</div>'
	);
	?>

</article>

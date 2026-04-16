<?php
/**
 * Single post template.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="post-outer">

	<div class="post-main">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'single' );
			comments_template();
		endwhile;
		?>
	</div>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>

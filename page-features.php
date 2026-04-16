<?php
/**
 * Static page template.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="page-content-full">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'features' );

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		endwhile;
		?>

	</div>
</div>

<?php get_footer(); ?>

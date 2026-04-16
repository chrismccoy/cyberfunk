<?php
/**
 * Search results template.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="blog-layout">

		<div class="main-col">

			<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<div class="archive-title-row">
						<h1 class="section-title">
							<?php
							printf(
								esc_html__( 'QUERY::%s', 'cyberfunk' ),
								'<em>' . esc_html( get_search_query() ) . '</em>'
							);
							?>
						</h1>
						<?php cyberfunk_archive_count( $GLOBALS['wp_query']->found_posts ); ?>
					</div>
				</header>

				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_format() ?: get_post_type() );
				endwhile;
				?>

				<?php get_template_part( 'template-parts/pagination' ); ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content', 'none' ); ?>

			<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>

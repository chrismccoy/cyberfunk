<?php
/**
 * Generic archive template — date and author archives.
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
							<?php the_archive_title(); ?>
						</h1>
						<?php cyberfunk_archive_count( $wp_query->found_posts ); ?>
					</div>
					<?php cyberfunk_archive_filter(); ?>
					<?php cyberfunk_archive_difficulty_filter(); ?>
					<?php
					$archive_description = get_the_archive_description();
					if ( $archive_description ) :
					?>
						<div class="archive-description">
							<?php echo wp_kses_post( $archive_description ); ?>
						</div>
					<?php endif; ?>
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

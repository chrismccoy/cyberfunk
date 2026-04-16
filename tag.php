<?php
/**
 * Tag archive template.
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
					<div class="archive-tag-label">
						<span class="tag-chip"><?php echo esc_html( strtoupper( single_tag_title( '', false ) ) ); ?></span>
					</div>

					<div class="archive-title-row">
						<h1 class="section-title">
							<?php
							printf(
								esc_html__( 'TAG::%s', 'cyberfunk' ),
								esc_html( strtoupper( single_tag_title( '', false ) ) )
							);
							?>
						</h1>
						<?php cyberfunk_archive_count( $wp_query->found_posts ); ?>
					</div>

					<?php cyberfunk_archive_filter(); ?>
					<?php cyberfunk_archive_difficulty_filter(); ?>

					<?php
					$tag_description = tag_description();
					if ( $tag_description ) :
					?>
						<div class="archive-description">
							<?php echo wp_kses_post( $tag_description ); ?>
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

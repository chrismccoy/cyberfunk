<?php
/**
 * Category archive template.
 *
 * @package Cyberfunk
 */

get_header();

$category = get_queried_object();
?>

<div class="page-wrapper">
	<div class="blog-layout">

		<div class="main-col">

			<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<?php if ( $category instanceof WP_Term ) : ?>
						<span class="post-category-badge <?php echo esc_attr( cyberfunk_category_badge_class( $category->slug ) ); ?>">
							[SYS::<?php echo esc_html( strtoupper( $category->name ) ); ?>]
						</span>
					<?php endif; ?>

					<div class="archive-title-row">
						<h1 class="section-title">
							<?php
							printf(
								esc_html__( '%s_TRANSMISSIONS', 'cyberfunk' ),
								esc_html( strtoupper( single_cat_title( '', false ) ) )
							);
							?>
						</h1>
						<?php cyberfunk_archive_count( $wp_query->found_posts ); ?>
					</div>
					<?php cyberfunk_archive_filter(); ?>
					<?php cyberfunk_archive_difficulty_filter(); ?>

					<?php
					$cat_description = category_description();
					if ( $cat_description ) :
					?>
						<div class="archive-description">
							<?php echo wp_kses_post( $cat_description ); ?>
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

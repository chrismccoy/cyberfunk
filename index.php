<?php
/**
 * Main template file — blog archive / front page fallback.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="blog-layout">

		<div class="main-col">

			<?php $index_heading = get_theme_mod( 'cyberfunk_index_heading', 'INCOMING_TRANSMISSIONS' ); ?>
			<div class="archive-title-row">
				<?php if ( is_home() && ! is_front_page() ) : ?>
					<h1 class="section-title sr-only"><?php echo esc_html( $index_heading ); ?></h1>
				<?php else : ?>
					<h2 class="section-title"><?php echo esc_html( $index_heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $wp_query->found_posts > 0 ) : ?>
					<?php cyberfunk_archive_count( $wp_query->found_posts ); ?>
				<?php endif; ?>
			</div>
			<?php cyberfunk_archive_filter(); ?>
			<?php cyberfunk_archive_difficulty_filter(); ?>

			<?php if ( have_posts() ) : ?>

				<?php
				while ( have_posts() ) :
					the_post();
					if ( 0 === $wp_query->current_post && ! is_paged() ) {
						get_template_part( 'template-parts/content', 'hero' );
					} else {
						get_template_part( 'template-parts/content', get_post_format() ?: get_post_type() );
					}
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

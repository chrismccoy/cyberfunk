<?php
/**
 * Author archive template.
 *
 * @package Cyberfunk
 */

get_header();

$author = get_queried_object();
?>

<div class="page-wrapper">
	<div class="blog-layout">

		<div class="main-col">

			<?php if ( $author instanceof WP_User ) : ?>
				<div class="author-archive-header">
					<?php
					echo get_avatar(
						$author->ID,
						80,
						'',
						esc_attr( strtoupper( $author->display_name ) ),
						[ 'class' => 'author-archive-avatar' ]
					);
					?>
					<div class="author-archive-info">
						<h1 class="section-title"><?php echo esc_html( strtoupper( $author->display_name ) ); ?></h1>
						<?php
						$handle = cyberfunk_get_author_meta( $author->ID, 'handle' );
						if ( $handle ) :
						?>
							<p class="author-archive-handle"><?php echo esc_html( $handle ); ?></p>
						<?php endif; ?>
						<?php if ( $author->description ) : ?>
							<p class="author-archive-bio"><?php echo esc_html( $author->description ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

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

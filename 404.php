<?php
/**
 * 404 Not Found template.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="error-404-wrap">

		<div class="error-404-inner">

			<div class="error-404-code" aria-hidden="true">404</div>

			<h1 class="error-404-title">
				<?php esc_html_e( 'SIGNAL_LOST', 'cyberfunk' ); ?>
			</h1>

			<p class="error-404-message">
				<?php esc_html_e( 'Transmission not found. The signal you requested has been moved, encrypted, or wiped from the grid. Try querying the archive.', 'cyberfunk' ); ?>
			</p>

			<div class="error-404-search">
				<?php get_search_form(); ?>
			</div>

			<?php
			$recent = new WP_Query( [
				'post_type'      => 'post',
				'posts_per_page' => 5,
				'no_found_rows'  => true,
			] );

			if ( $recent->have_posts() ) :
			?>
				<div class="error-404-recent">
					<h2 class="error-404-recent-title">
						<?php esc_html_e( 'RECENT_TRANSMISSIONS', 'cyberfunk' ); ?>
					</h2>
					<ul class="error-404-post-list">
						<?php
						while ( $recent->have_posts() ) :
							$recent->the_post();
							?>
							<li>
								<a href="<?php the_permalink(); ?>">
									<?php echo esc_html( strtoupper( get_the_title() ) ); ?>
								</a>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">
				<i class="fa-solid fa-house" aria-hidden="true"></i>
				<?php esc_html_e( 'RETURN TO BASE', 'cyberfunk' ); ?>
			</a>

		</div>

	</div>
</div>

<?php get_footer(); ?>

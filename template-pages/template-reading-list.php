<?php
/**
 * Template Name: Reading List
 *
 * Displays the visitor's personal reading queue, populated from
 * localStorage by reading-list.js.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="blog-layout">

		<main id="primary" class="main-col">

			<?php cyberfunk_breadcrumb(); ?>

			<header class="archive-header">
				<div class="archive-title-row">
					<h1 class="section-title"><?php esc_html_e( 'READING_QUEUE', 'cyberfunk' ); ?></h1>
				</div>
				<p class="archive-description">
					<?php esc_html_e( 'Transmissions you have bookmarked for later. Saved privately in your browser.', 'cyberfunk' ); ?>
				</p>
			</header>

			<div id="reading-list-container" class="reading-list-wrap">
				<p class="rl-loading">
					<i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
					<?php esc_html_e( 'LOADING_QUEUE_DATA...', 'cyberfunk' ); ?>
				</p>
			</div>

		</main>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>

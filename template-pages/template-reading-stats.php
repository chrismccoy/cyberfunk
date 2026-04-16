<?php
/**
 * Template Name: Reading Stats
 *
 * Displays the visitor's personal reading statistics, populated from
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
					<h1 class="section-title"><?php esc_html_e( 'OPERATIVE_STATS', 'cyberfunk' ); ?></h1>
				</div>
				<p class="archive-description">
					<?php esc_html_e( 'Your personal reading data. Stored privately in your browser — never sent to a server.', 'cyberfunk' ); ?>
				</p>
			</header>

			<div id="reading-stats-container" class="reading-stats-wrap">
				<p class="rl-loading">
					<i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
					<?php esc_html_e( 'LOADING_PROFILE_DATA...', 'cyberfunk' ); ?>
				</p>
			</div>

		</main>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>

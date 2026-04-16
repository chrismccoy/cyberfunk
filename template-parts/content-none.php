<?php
/**
 * Template part: no results found.
 *
 * @package Cyberfunk
 */
?>
<div class="no-results">

	<div class="no-results-code" aria-hidden="true">NULL</div>

	<h2 class="no-results-title">
		<?php
		if ( is_search() ) :
			printf(
				esc_html__( 'NO SIGNAL FOR "%s"', 'cyberfunk' ),
				esc_html( get_search_query() )
			);
		else :
			esc_html_e( 'NO_TRANSMISSIONS_FOUND', 'cyberfunk' );
		endif;
		?>
	</h2>

	<p class="no-results-message">
		<?php
		if ( is_search() ) :
			esc_html_e( 'Your query returned no transmissions. Check your spelling or try a broader search term.', 'cyberfunk' );
		else :
			esc_html_e( 'No transmissions have been logged in this sector yet.', 'cyberfunk' );
		endif;
		?>
	</p>

	<div class="no-results-search">
		<?php get_search_form(); ?>
	</div>

</div>

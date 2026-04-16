<?php
/**
 * Custom search form template.
 *
 * @package Cyberfunk
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-input-wrap">
		<i class="fa-solid fa-magnifying-glass search-icon" aria-hidden="true"></i>
		<label for="s" class="sr-only"><?php esc_html_e( 'Search', 'cyberfunk' ); ?></label>
		<input
			type="search"
			id="s"
			name="s"
			class="search-input"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'QUERY THE ARCHIVE…', 'cyberfunk' ); ?>"
			autocomplete="off"
		>
	</div>
	<button type="submit" class="search-btn">
		<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>&nbsp;<?php esc_html_e( 'EXECUTE SEARCH', 'cyberfunk' ); ?>
	</button>
</form>

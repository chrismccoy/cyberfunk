<?php
/**
 * Post series — taxonomy registration and helper functions.
 *
 * @package Cyberfunk
 */

/**
 * Registers the 'series' taxonomy for posts.
 */
function cyberfunk_register_series_taxonomy() {
	register_taxonomy(
		'series',
		'post',
		[
			'labels'            => [
				'name'          => esc_html__( 'Series', 'cyberfunk' ),
				'singular_name' => esc_html__( 'Series', 'cyberfunk' ),
				'add_new_item'  => esc_html__( 'Add New Series', 'cyberfunk' ),
				'new_item_name' => esc_html__( 'New Series Name', 'cyberfunk' ),
				'edit_item'     => esc_html__( 'Edit Series', 'cyberfunk' ),
				'update_item'   => esc_html__( 'Update Series', 'cyberfunk' ),
				'search_items'  => esc_html__( 'Search Series', 'cyberfunk' ),
				'all_items'     => esc_html__( 'All Series', 'cyberfunk' ),
				'menu_name'     => esc_html__( 'Series', 'cyberfunk' ),
			],
			'public'            => true,
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'show_in_rest'      => true,
			'rewrite'           => [ 'slug' => 'series' ],
		]
	);
}

/**
 * Returns the estimated reading time in minutes for a given post ID.
 */
function cyberfunk_reading_time_for_post( $post_id, $words_per_minute = 200 ) {
	$content    = get_post_field( 'post_content', absint( $post_id ) );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $word_count / absint( $words_per_minute ) ) );
}

/**
 * Returns data about the series the current post belongs to.
 */
function cyberfunk_get_series_data() {
	$terms = get_the_terms( get_the_ID(), 'series' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return false;
	}

	$term = $terms[0];

	$series_post_ids = get_posts( [
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'tax_query'      => [
			[
				'taxonomy' => 'series',
				'field'    => 'term_id',
				'terms'    => $term->term_id,
			],
		],
		'orderby'        => 'date',
		'order'          => 'ASC',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	] );

	if ( empty( $series_post_ids ) ) {
		return false;
	}

	$position = array_search( get_the_ID(), $series_post_ids, true );

	if ( false === $position ) {
		return false;
	}

	$position = (int) $position;
	$total    = count( $series_post_ids );

	// Build full post list with titles, permalinks, and accumulated read time.
	$all_posts         = [];
	$total_read_time   = 0;

	foreach ( $series_post_ids as $pid ) {
		$all_posts[]      = [
			'id'        => (int) $pid,
			'title'     => get_the_title( $pid ),
			'permalink' => get_permalink( $pid ),
		];
		$total_read_time += cyberfunk_reading_time_for_post( $pid );
	}

	return [
		'term'             => $term,
		'position'         => $position + 1,
		'total'            => $total,
		'total_read_time'  => $total_read_time,
		'all_posts'        => $all_posts,
		'prev'             => $position > 0 ? get_post( $series_post_ids[ $position - 1 ] ) : null,
		'next'             => $position < $total - 1 ? get_post( $series_post_ids[ $position + 1 ] ) : null,
	];
}

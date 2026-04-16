<?php
/**
 * Helper and utility functions.
 *
 * @package Cyberfunk
 */

/**
 * Outputs the theme's custom paginated post navigation.
 */
function cyberfunk_pagination( $query = null ) {
	global $wp_query;

	if ( null === $query ) {
		$query = $wp_query;
	}

	$total   = (int) $query->max_num_pages;
	$current = max( 1, (int) get_query_var( 'paged' ) );

	if ( $total <= 1 ) {
		return;
	}

	// Preserve active filter (reading-time or difficulty) across page links.
	$rtf = get_query_var( 'rtf' );
	if ( ! in_array( $rtf, [ 'short', 'medium', 'long' ], true ) ) {
		$rtf = '';
	}
	$dif = get_query_var( 'dif' );
	if ( ! in_array( $dif, [ 'beginner', 'intermediate', 'advanced' ], true ) ) {
		$dif = '';
	}

	/**
	 * Returns a page URL, inserting the active filter endpoint segment
	 * (/rtf/{filter}/ or /dif/{filter}/) before any /page/{n}/ suffix.
	 */
	$page_url = function ( $page ) use ( $rtf, $dif ) {
		$base = trailingslashit( cyberfunk_get_archive_base_url() );
		if ( $rtf ) {
			$base .= 'rtf/' . $rtf . '/';
		} elseif ( $dif ) {
			$base .= 'dif/' . $dif . '/';
		} else {
			return get_pagenum_link( (int) $page );
		}
		if ( (int) $page > 1 ) {
			$base .= 'page/' . absint( $page ) . '/';
		}
		return $base;
	};

	// Sliding window of 8: keep the current page centred, clamped to valid range.
	$window_size = 8;
	$half        = (int) floor( $window_size / 2 );
	$win_start   = max( 1, $current - $half );
	$win_end     = min( $total, $win_start + $window_size - 1 );
	$win_start   = max( 1, $win_end - $window_size + 1 );

	echo '<nav class="pagination" aria-label="' . esc_attr__( 'Posts navigation', 'cyberfunk' ) . '">';

	if ( $current > 1 ) {
		printf(
			'<a href="%s" class="page-btn" aria-label="%s"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></a>',
			esc_url( $page_url( $current - 1 ) ),
			esc_attr__( 'Previous page', 'cyberfunk' )
		);
	}

	if ( $win_start > 1 ) {
		printf(
			'<a href="%s" class="page-btn">%s</a>',
			esc_url( $page_url( 1 ) ),
			esc_html( sprintf( '%02d', 1 ) )
		);
		if ( $win_start > 2 ) {
			echo '<span class="page-btn" aria-hidden="true">&hellip;</span>';
		}
	}

	for ( $page = $win_start; $page <= $win_end; $page++ ) {
		$label = sprintf( '%02d', $page );
		if ( $page === $current ) {
			printf(
				'<span class="page-btn active" aria-current="page">%s</span>',
				esc_html( $label )
			);
		} else {
			printf(
				'<a href="%s" class="page-btn">%s</a>',
				esc_url( $page_url( $page ) ),
				esc_html( $label )
			);
		}
	}

	if ( $win_end < $total ) {
		if ( $win_end < $total - 1 ) {
			echo '<span class="page-btn" aria-hidden="true">&hellip;</span>';
		}
		printf(
			'<a href="%s" class="page-btn">%s</a>',
			esc_url( $page_url( $total ) ),
			esc_html( sprintf( '%02d', $total ) )
		);
	}

	if ( $current < $total ) {
		printf(
			'<a href="%s" class="page-btn" aria-label="%s"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></a>',
			esc_url( $page_url( $current + 1 ) ),
			esc_attr__( 'Next page', 'cyberfunk' )
		);
	}

	echo '</nav>';
}

/**
 * Registers the /rtf/ rewrite endpoint for reading-time filter URLs.
 */
function cyberfunk_register_reading_time_endpoint() {
	// EP_ALL_ARCHIVES covers categories, tags, authors, date archives.
	// EP_ROOT covers the blog index when it is the site root.
	// EP_PAGES covers the blog index when it lives at a sub-page (e.g. /blog/).
	// EP_SEARCH covers search result pages.
	$mask = EP_ALL_ARCHIVES | EP_ROOT | EP_PAGES | EP_SEARCH;
	add_rewrite_endpoint( 'rtf', $mask ); // Reading-time filter.
	add_rewrite_endpoint( 'dif', $mask ); // Difficulty filter.
}

/**
 * Flushes rewrite rules once when the theme is activated.
 */
function cyberfunk_flush_rewrite_rules() {
	cyberfunk_register_reading_time_endpoint();
	flush_rewrite_rules();
}

/**
 * Returns the base URL of the current archive or index page, with no
 * pagination or /rtf/ endpoint suffix.
 */
function cyberfunk_get_archive_base_url() {
	if ( is_category() ) {
		return get_category_link( get_queried_object_id() );
	}
	if ( is_tag() ) {
		return get_tag_link( get_queried_object_id() );
	}
	if ( is_author() ) {
		return get_author_posts_url( get_queried_object_id() );
	}
	if ( is_day() ) {
		return get_day_link(
			(int) get_query_var( 'year' ),
			(int) get_query_var( 'monthnum' ),
			(int) get_query_var( 'day' )
		);
	}
	if ( is_month() ) {
		return get_month_link(
			(int) get_query_var( 'year' ),
			(int) get_query_var( 'monthnum' )
		);
	}
	if ( is_year() ) {
		return get_year_link( (int) get_query_var( 'year' ) );
	}
	if ( is_search() ) {
		return get_search_link( get_search_query() );
	}
	if ( is_home() ) {
		$blog_page = (int) get_option( 'page_for_posts' );
		if ( $blog_page ) {
			return get_permalink( $blog_page );
		}
		return home_url( '/' );
	}
	return home_url( '/' );
}

/**
 * Saves the calculated reading time as post meta whenever a post is saved.
 */
function cyberfunk_save_post_reading_time( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}
	$content    = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = max( 1, (int) ceil( $word_count / 200 ) );
	update_post_meta( $post_id, '_cyberfunk_reading_time', $minutes );
}

/**
 * Backfills _cyberfunk_reading_time meta for any published posts that are
 * missing it. Runs once on admin_init and stores a completion flag so it
 * never runs again.
 */
function cyberfunk_maybe_backfill_reading_times() {
	if ( get_option( 'cyberfunk_rt_backfilled' ) ) {
		return;
	}

	$posts = get_posts( [
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'numberposts'    => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_query'     => [
			[
				'key'     => '_cyberfunk_reading_time',
				'compare' => 'NOT EXISTS',
			],
		],
	] );

	foreach ( $posts as $post_id ) {
		cyberfunk_save_post_reading_time( $post_id );
	}

	update_option( 'cyberfunk_rt_backfilled', '1', false );
}

/**
 * Filters the main archive/index query by reading time or difficulty level.
 */
function cyberfunk_filter_by_reading_time( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( ! ( $query->is_home() || $query->is_archive() || $query->is_search() ) ) {
		return;
	}

	// Reading-time filter via /rtf/{value}/ endpoint.
	$rtf = sanitize_key( (string) $query->get( 'rtf' ) );
	if ( in_array( $rtf, [ 'short', 'medium', 'long' ], true ) ) {
		$ranges = [
			'short'  => [ 1,  5  ],
			'medium' => [ 6,  15 ],
			'long'   => [ 16, 9999 ],
		];
		list( $min, $max ) = $ranges[ $rtf ];
		$query->set( 'meta_query', [
			[
				'key'     => '_cyberfunk_reading_time',
				'value'   => [ $min, $max ],
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			],
		] );
		return;
	}

	// Difficulty filter via /dif/{value}/ endpoint.
	$dif = sanitize_key( (string) $query->get( 'dif' ) );
	if ( in_array( $dif, [ 'beginner', 'intermediate', 'advanced' ], true ) ) {
		$query->set( 'meta_query', [
			[
				'key'     => '_cyberfunk_difficulty',
				'value'   => $dif,
				'compare' => '=',
			],
		] );
	}
}

/**
 * Strips code blocks from post content before WordPress auto-generates the excerpt.
 */
function cyberfunk_strip_code_from_excerpt( $content ) {
	if ( ! doing_filter( 'get_the_excerpt' ) ) {
		return $content;
	}
	// Remove everything between <pre> tags (including the tags themselves).
	$content = preg_replace( '#<pre[\s\S]*?</pre>#i', '', $content );
	// Remove any remaining inline <code> elements.
	$content = preg_replace( '#<code[\s\S]*?</code>#i', '', $content );
	return $content;
}

/**
 * Shortcode: [codeblock] / [codeblock lang="php"]
 */
function cyberfunk_code_shortcode( $atts, $content = '' ) {
	$atts = shortcode_atts(
		[ 'lang' => '' ],
		$atts,
		'codeblock'
	);

	// Normalise: trim, strip any auto-p tags WordPress may have injected.
	$content = wp_strip_all_tags( $content );
	$content = html_entity_decode( $content, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$content = trim( $content );

	$lang_raw  = sanitize_key( $atts['lang'] ); // lowercase, e.g. "php"
	$lang_label = strtoupper( $lang_raw );       // uppercase label, e.g. "PHP"

	$data_lang  = ( '' !== $lang_raw )
		? ' data-lang="' . esc_attr( $lang_label ) . '"'
		: '';

	// Prism requires class="language-{lang}" on the <code> element.
	$lang_class = ( '' !== $lang_raw )
		? ' class="language-' . esc_attr( $lang_raw ) . '"'
		: '';

	return '<pre' . $data_lang . '><code' . $lang_class . '>' . esc_html( $content ) . '</code></pre>';
}

/**
 * Limits the auto-generated excerpt to 30 words.
 */
function cyberfunk_excerpt_length() {
	return 30;
}

/**
 * Replaces the default "[&hellip;]" excerpt trailing text with a clean ellipsis.
 */
function cyberfunk_excerpt_more() {
	return '&hellip;';
}

/**
 * Redirects ugly search URLs (?s=keyword) to the pretty form (/search/keyword/).
 */
function cyberfunk_redirect_search_url() {
	if ( is_search() && ! empty( $_GET['s'] ) ) {
		$query = sanitize_text_field( wp_unslash( $_GET['s'] ) );
		wp_redirect( trailingslashit( home_url( '/search/' . urlencode( $query ) ) ), 301 );
		exit;
	}
}

/**
 * Returns the estimated reading time for the current post in minutes.
 */
function cyberfunk_reading_time( $words_per_minute = 200 ) {
	$content    = get_post_field( 'post_content', get_the_ID() );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes    = (int) ceil( $word_count / absint( $words_per_minute ) );

	return max( 1, $minutes );
}

/**
 * Maps a category slug to a badge modifier CSS class.
 */
function cyberfunk_category_badge_class( $slug ) {
	$map = [
		'culture'    => 'badge-cyan',
		'net'        => 'badge-cyan',
		'network'    => 'badge-cyan',
		'dark-net'   => 'badge-cyan',
		'darknet'    => 'badge-cyan',
		'world'      => 'badge-magenta',
		'security'   => 'badge-magenta',
		'science'    => 'badge-green',
		'biotech'    => 'badge-green',
	];

	return $map[ sanitize_key( $slug ) ] ?? '';
}

/**
 * Returns an array of social share URLs for the current post.
 */
function cyberfunk_get_share_urls() {
	$url   = rawurlencode( get_permalink() );
	$title = rawurlencode( get_the_title() );

	return [
		'x'        => 'https://x.com/intent/tweet?url=' . $url . '&text=' . $title,
		'mastodon' => 'https://mastodon.social/share?text=' . $title . '%20' . $url,
		'telegram' => 'https://t.me/share/url?url=' . $url . '&text=' . $title,
		'copy'     => get_permalink(),
	];
}

/**
 * Returns the breadcrumb trail for the current page as an array of items.
 */
function cyberfunk_breadcrumb_trail() {
	$trail = [];

	$trail[] = [
		'label' => __( 'HOME', 'cyberfunk' ),
		'url'   => home_url( '/' ),
	];

	if ( is_single() ) {
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$trail[] = [
				'label' => strtoupper( $categories[0]->name ),
				'url'   => get_category_link( $categories[0]->term_id ),
			];
		}
		$trail[] = [
			'label' => strtoupper( wp_trim_words( get_the_title(), 5, '...' ) ),
		];
	} elseif ( is_category() ) {
		$trail[] = [
			'label' => strtoupper( single_cat_title( '', false ) ),
		];
	} elseif ( is_tag() ) {
		$trail[] = [
			'label' => strtoupper( single_tag_title( '', false ) ),
		];
	} elseif ( is_page() ) {
		$trail[] = [
			'label' => strtoupper( get_the_title() ),
		];
	} elseif ( is_search() ) {
		$trail[] = [
			'label' => sprintf( __( 'SEARCH: %s', 'cyberfunk' ), get_search_query() ),
		];
	} elseif ( is_archive() ) {
		$trail[] = [
			'label' => strtoupper( get_the_archive_title() ),
		];
	}

	return $trail;
}

/**
 * Retrieves a custom author meta value stored by this theme.
 */
function cyberfunk_get_author_meta( $user_id, $key ) {
	$value = get_user_meta( absint( $user_id ), 'cyberfunk_' . sanitize_key( $key ), true );
	return $value ? (string) $value : '';
}

/**
 * Renders custom author meta fields on the WP user profile screen.
 */
function cyberfunk_add_author_meta_fields( $user ) {
	if ( ! current_user_can( 'edit_user', $user->ID ) ) {
		return;
	}
	?>
	<h3><?php esc_html_e( 'Cyberfunk — Operative Profile', 'cyberfunk' ); ?></h3>
	<table class="form-table">
		<tr>
			<th>
				<label for="cyberfunk_handle">
					<?php esc_html_e( 'Handle / Alias', 'cyberfunk' ); ?>
				</label>
			</th>
			<td>
				<input
					type="text"
					name="cyberfunk_handle"
					id="cyberfunk_handle"
					value="<?php echo esc_attr( cyberfunk_get_author_meta( $user->ID, 'handle' ) ); ?>"
					class="regular-text"
				>
				<p class="description">
					<?php esc_html_e( 'Displayed below the author name, e.g. @handle // UNIT 7', 'cyberfunk' ); ?>
				</p>
			</td>
		</tr>
		<tr>
			<th>
				<label for="cyberfunk_social_twitter">
					<?php esc_html_e( 'X / Twitter Profile URL', 'cyberfunk' ); ?>
				</label>
			</th>
			<td>
				<input
					type="url"
					name="cyberfunk_social_twitter"
					id="cyberfunk_social_twitter"
					value="<?php echo esc_attr( cyberfunk_get_author_meta( $user->ID, 'social_twitter' ) ); ?>"
					class="regular-text"
				>
			</td>
		</tr>
		<tr>
			<th>
				<label for="cyberfunk_social_mastodon">
					<?php esc_html_e( 'Mastodon Profile URL', 'cyberfunk' ); ?>
				</label>
			</th>
			<td>
				<input
					type="url"
					name="cyberfunk_social_mastodon"
					id="cyberfunk_social_mastodon"
					value="<?php echo esc_attr( cyberfunk_get_author_meta( $user->ID, 'social_mastodon' ) ); ?>"
					class="regular-text"
				>
			</td>
		</tr>
		<tr>
			<th>
				<label for="cyberfunk_social_telegram">
					<?php esc_html_e( 'Telegram Profile URL', 'cyberfunk' ); ?>
				</label>
			</th>
			<td>
				<input
					type="url"
					name="cyberfunk_social_telegram"
					id="cyberfunk_social_telegram"
					value="<?php echo esc_attr( cyberfunk_get_author_meta( $user->ID, 'social_telegram' ) ); ?>"
					class="regular-text"
				>
			</td>
		</tr>
	</table>
	<?php
}

/**
 * Saves custom author meta fields submitted from the user profile screen.
 */
function cyberfunk_save_author_meta_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return;
	}

	// Verify nonce — WP user-edit screens use 'update-user_{id}'.
	if (
		! isset( $_POST['_wpnonce'] ) ||
		! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ),
			'update-user_' . $user_id
		)
	) {
		return;
	}

	$fields = [ 'handle', 'social_twitter', 'social_mastodon', 'social_telegram' ];

	foreach ( $fields as $field ) {
		$meta_key = 'cyberfunk_' . $field;
		$raw      = isset( $_POST[ $meta_key ] ) ? wp_unslash( $_POST[ $meta_key ] ) : '';
		$value    = in_array( $field, [ 'social_twitter', 'social_mastodon', 'social_telegram' ], true )
			? esc_url_raw( $raw )
			: sanitize_text_field( $raw );

		update_user_meta( $user_id, $meta_key, $value );
	}
}

/**
 * Overrides the [gallery] shortcode output with the theme's grid design.
 */
function cyberfunk_gallery_shortcode( $output, $attr ) {
	$post = get_post();

	if ( ! empty( $attr['ids'] ) ) {
		$ids         = array_map( 'absint', explode( ',', $attr['ids'] ) );
		$attachments = get_posts( [
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'post__in'    => $ids,
			'orderby'     => 'post__in',
			'numberposts' => count( $ids ),
		] );
	} elseif ( $post ) {
		$attachments = get_posts( [
			'post_type'    => 'attachment',
			'post_parent'  => $post->ID,
			'post_status'  => 'inherit',
			'numberposts'  => -1,
			'orderby'      => 'menu_order',
			'order'        => 'ASC',
			'post_mime_type' => 'image',
		] );
	} else {
		return $output;
	}

	if ( empty( $attachments ) ) {
		return $output;
	}

	$html  = '<div class="gallery-section">';
	$html .= '<p class="gallery-label">' . esc_html__( 'VISUAL_ARCHIVE :: FIELD_DOCUMENTATION', 'cyberfunk' ) . '</p>';
	$html .= '<div class="gallery-grid">';

	foreach ( $attachments as $attachment ) {
		$full_url = wp_get_attachment_image_url( $attachment->ID, 'full' );
		$alt      = esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) );
		$img      = wp_get_attachment_image(
			$attachment->ID,
			'cyberfunk-card',
			false,
			[
				'loading' => 'lazy',
				'alt'     => $alt,
			]
		);

		$html .= '<div class="gallery-item">';
		if ( $full_url ) {
			$html .= '<a href="' . esc_url( $full_url ) . '">' . $img . '</a>';
		} else {
			$html .= $img;
		}
		$html .= '<div class="gallery-overlay" aria-hidden="true"><i class="fa-solid fa-expand"></i></div>';
		$html .= '</div>';
	}

	$html .= '</div>';
	$html .= '</div>';

	return $html;
}

/**
 * Adds preconnect resource hints for Google Fonts origins.
 */
function cyberfunk_resource_hints( $hints, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$hints[] = [ 'href' => 'https://fonts.googleapis.com' ];
		$hints[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ];
	}
	return $hints;
}

/**
 * Wraps <table> elements in the post content with a .table-wrap scrolling container.
 */
function cyberfunk_wrap_tables( $content ) {
	if ( '' === $content || ! is_singular() ) {
		return $content;
	}
	$content = str_replace( '<table', '<div class="table-wrap"><table', $content );
	$content = str_replace( '</table>', '</table></div>', $content );
	return $content;
}

/**
 * Increments the view count for the current singular post.
 */
function cyberfunk_increment_view_count() {
	if ( ! is_singular( 'post' ) || is_preview() || current_user_can( 'manage_options' ) ) {
		return;
	}
	$post_id = (int) get_the_ID();
	if ( ! $post_id ) {
		return;
	}
	$count = (int) get_post_meta( $post_id, 'cyberfunk_view_count', true );
	update_post_meta( $post_id, 'cyberfunk_view_count', $count + 1 );
}

/**
 * Returns the stored view count for a post.
 */
function cyberfunk_get_view_count( $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	return (int) get_post_meta( absint( $post_id ), 'cyberfunk_view_count', true );
}

/**
 * Wraps search-query words in <mark> tags inside excerpt text on search pages.
 */
function cyberfunk_highlight_search_terms( $text ) {
	if ( ! is_search() || is_admin() ) {
		return $text;
	}

	$query = get_search_query();
	if ( '' === $query ) {
		return $text;
	}

	$words = array_unique( array_filter(
		array_map( 'trim', preg_split( '/\s+/', $query ) ),
		function ( $w ) { return mb_strlen( $w ) >= 3; }
	) );

	if ( empty( $words ) ) {
		return $text;
	}

	foreach ( $words as $word ) {
		$pattern = '/(?<![<\w\/\'\"])(' . preg_quote( $word, '/' ) . ')(?![^<>]*>)/iu';
		$text    = preg_replace( $pattern, '<mark class="search-highlight">$1</mark>', $text );
	}

	return $text;
}

/**
 * Injects an auto-generated table of contents before single post content.
 */
function cyberfunk_toc_inject( $content ) {
	if ( ! is_singular( 'post' ) || is_admin() ) {
		return $content;
	}

	// Match h2/h3 — capture level, existing attributes, and inner HTML.
	preg_match_all( '/<h([23])([^>]*)>(.*?)<\/h\1>/is', $content, $matches, PREG_SET_ORDER );

	if ( count( $matches ) < 3 ) {
		return $content;
	}

	$toc_items = [];
	$used_ids  = [];
	$replacements = [];

	foreach ( $matches as $match ) {
		$level = $match[1];
		$attrs = $match[2];
		$inner = $match[3];
		$text  = wp_strip_all_tags( $inner );

		// Reuse existing id attribute if present; otherwise generate one.
		if ( preg_match( '/\bid=["\']([^"\']+)["\']/', $attrs, $id_match ) ) {
			$id = $id_match[1];
		} else {
			$base_id = sanitize_title( $text );
			$id      = $base_id;
			$counter = 1;
			while ( in_array( $id, $used_ids, true ) ) {
				$id = $base_id . '-' . $counter++;
			}
			// Queue a replacement to inject the id attribute into the heading tag.
			$new_tag            = '<h' . $level . ' id="' . esc_attr( $id ) . '"' . $attrs . '>' . $inner . '</h' . $level . '>';
			$replacements[ $match[0] ] = $new_tag;
		}

		$used_ids[]  = $id;
		$toc_items[] = [
			'level' => (int) $level,
			'id'    => $id,
			'text'  => $text,
		];
	}

	// Apply heading id injections.
	foreach ( $replacements as $original => $replacement ) {
		$content = str_replace( $original, $replacement, $content );
	}

	// Build TOC markup.
	$toc  = '<div class="toc-widget" id="toc-widget">';
	$toc .= '<div class="toc-header">';
	$toc .= '<span class="toc-title">' . esc_html__( 'SYS::INDEX', 'cyberfunk' ) . '</span>';
	$toc .= '<button type="button" class="toc-toggle js-toc-toggle" aria-expanded="true" aria-controls="toc-list" aria-label="' . esc_attr__( 'Toggle table of contents', 'cyberfunk' ) . '">';
	$toc .= '<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>';
	$toc .= '</button>';
	$toc .= '</div>';
	$toc .= '<ol class="toc-list" id="toc-list">';

	foreach ( $toc_items as $i => $item ) {
		$sub_class = ( 3 === $item['level'] ) ? ' toc-sub' : '';
		$toc .= '<li class="toc-item' . $sub_class . '">';
		$toc .= '<a href="#' . esc_attr( $item['id'] ) . '">';
		$toc .= '<span class="toc-num">' . sprintf( '%02d', $i + 1 ) . '</span>';
		$toc .= '<span class="toc-text">' . esc_html( strtoupper( $text = $item['text'] ) ) . '</span>';
		$toc .= '</a>';
		$toc .= '</li>';
	}

	$toc .= '</ol>';
	$toc .= '<a href="#top" class="toc-back-top" aria-label="' . esc_attr__( 'Back to top', 'cyberfunk' ) . '">';
	$toc .= '<i class="fa-solid fa-arrow-up" aria-hidden="true"></i>';
	$toc .= esc_html__( 'BACK_TO_TOP', 'cyberfunk' );
	$toc .= '</a>';
	$toc .= '</div>';

	return $toc . $content;
}

/**
 * Wraps oEmbed video output in the theme's .video-section HUD markup.
 */
function cyberfunk_embed_oembed_html( $html, $url, $attr, $post_id ) {
	$video_hosts = [
		'youtube.com',
		'youtu.be',
		'vimeo.com',
		'dailymotion.com',
		'twitch.tv',
		'wistia.com',
		'wistia.net',
	];

	$is_video = false;
	foreach ( $video_hosts as $host ) {
		if ( false !== strpos( $url, $host ) ) {
			$is_video = true;
			break;
		}
	}

	if ( ! $is_video ) {
		return $html;
	}

	// Attempt to pull the iframe title attribute for the HUD bar.
	$title = '';
	if ( preg_match( '/\btitle=["\']([^"\']+)["\']/', $html, $matches ) ) {
		$title = $matches[1];
	}

	if ( '' === $title ) {
		$title = esc_html__( 'VIDEO FEED', 'cyberfunk' );
	}

	$wrapped  = '<div class="video-section">';
	$wrapped .= '<p class="video-label">' . esc_html__( 'VIDEO_FEED :: EXTRACTED_BROADCAST', 'cyberfunk' ) . '</p>';
	$wrapped .= '<div class="video-outer">';
	$wrapped .= '<div class="video-hud-bar">';
	$wrapped .= '<span class="video-hud-title">' . esc_html( strtoupper( $title ) ) . '</span>';
	$wrapped .= '<span class="video-hud-badge">&#9679; ' . esc_html__( 'REC', 'cyberfunk' ) . '</span>';
	$wrapped .= '</div>';
	$wrapped .= '<div class="video-wrapper">' . $html . '</div>';
	$wrapped .= '</div>';
	$wrapped .= '</div>';

	return $wrapped;
}

/**
 * Wraps [video] shortcode output in the theme's .video-section HUD markup.
 */
function cyberfunk_video_shortcode( $output, $atts, $video, $post_id, $library ) {
	// Derive a display title from the src filename if no explicit title is set.
	$title = '';
	$src   = ! empty( $atts['src'] ) ? $atts['src'] : $video;
	if ( $src ) {
		$basename = wp_basename( $src );
		// Strip query string and extension.
		$basename = preg_replace( '/\?.*$/', '', $basename );
		$basename = preg_replace( '/\.[a-z0-9]+$/i', '', $basename );
		// Convert hyphens and underscores to spaces.
		$title = str_replace( [ '-', '_' ], ' ', $basename );
	}

	if ( '' === $title ) {
		$title = esc_html__( 'VIDEO FEED', 'cyberfunk' );
	}

	$wrapped  = '<div class="video-section">';
	$wrapped .= '<p class="video-label">' . esc_html__( 'VIDEO_FEED :: EXTRACTED_BROADCAST', 'cyberfunk' ) . '</p>';
	$wrapped .= '<div class="video-outer">';
	$wrapped .= '<div class="video-hud-bar">';
	$wrapped .= '<span class="video-hud-title">' . esc_html( strtoupper( $title ) ) . '</span>';
	$wrapped .= '<span class="video-hud-badge">&#9679; ' . esc_html__( 'REC', 'cyberfunk' ) . '</span>';
	$wrapped .= '</div>';
	$wrapped .= '<div class="video-wrapper">' . $output . '</div>';
	$wrapped .= '</div>';
	$wrapped .= '</div>';

	return $wrapped;
}

/**
 * Returns the reaction counts for a post.
 */
function cyberfunk_get_reactions( $post_id ) {
	$valid    = [ 'fire', 'hype', 'intel', 'confused' ];
	$defaults = array_fill_keys( $valid, 0 );
	$stored   = get_post_meta( absint( $post_id ), '_cyberfunk_reactions', true );

	if ( ! is_array( $stored ) ) {
		return $defaults;
	}

	return array_merge( $defaults, array_intersect_key( $stored, $defaults ) );
}

/**
 * Shortcode: [callout type="info|warning|danger|tip"]content[/callout]
 */
function cyberfunk_callout_shortcode( $atts, $content = '' ) {
	$atts    = shortcode_atts( [ 'type' => 'info' ], $atts, 'callout' );
	$type    = sanitize_key( $atts['type'] );
	$allowed = [ 'info', 'warning', 'danger', 'tip' ];

	if ( ! in_array( $type, $allowed, true ) ) {
		$type = 'info';
	}

	$icons = [
		'info'    => 'fa-circle-info',
		'warning' => 'fa-triangle-exclamation',
		'danger'  => 'fa-skull-crossbones',
		'tip'     => 'fa-lightbulb',
	];

	$labels = [
		'info'    => __( 'INTEL', 'cyberfunk' ),
		'warning' => __( 'WARNING', 'cyberfunk' ),
		'danger'  => __( 'DANGER', 'cyberfunk' ),
		'tip'     => __( 'TIP', 'cyberfunk' ),
	];

	$html  = '<div class="callout callout-' . esc_attr( $type ) . '" role="note">';
	$html .= '<div class="callout-label">';
	$html .= '<i class="fa-solid ' . esc_attr( $icons[ $type ] ) . '" aria-hidden="true"></i>';
	$html .= '<span>' . esc_html( $labels[ $type ] ) . '</span>';
	$html .= '</div>';
	$html .= '<div class="callout-body">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
	$html .= '</div>';

	return $html;
}

/**
 * Shortcode: [spoiler]content[/spoiler]
 */
function cyberfunk_spoiler_shortcode( $atts, $content = '' ) {
	$html  = '<span class="spoiler" data-revealed="false" role="button" tabindex="0" ';
	$html .= 'aria-label="' . esc_attr__( 'Reveal spoiler — click to show', 'cyberfunk' ) . '">';
	$html .= wp_kses_post( do_shortcode( $content ) );
	$html .= '</span>';
	return $html;
}

/**
 * Global footnote registry — reset on each new post via cyberfunk_footnotes_reset().
 */
$GLOBALS['cyberfunk_footnotes'] = [];

/**
 * Shortcode: [fn]note text[/fn]
 */
function cyberfunk_footnote_shortcode( $atts, $content = '' ) {
	// Don't collect footnotes when building an auto-excerpt.
	if ( doing_filter( 'get_the_excerpt' ) ) {
		return '';
	}

	$GLOBALS['cyberfunk_footnotes'][] = do_shortcode( trim( $content ) );
	$idx     = count( $GLOBALS['cyberfunk_footnotes'] );
	$post_id = get_the_ID();
	$ref_id  = 'fn-' . $idx . '-' . $post_id;
	$back_id = 'fnref-' . $idx . '-' . $post_id;

	return '<sup class="fn-ref" id="' . esc_attr( $back_id ) . '">' .
		'<a href="#' . esc_attr( $ref_id ) . '">' . $idx . '</a>' .
		'</sup>';
}

/**
 * Appends the collected footnote list to single post content.
 */
function cyberfunk_footnotes_append( $content ) {
	if ( doing_filter( 'get_the_excerpt' ) || ! is_singular() ) {
		return $content;
	}

	$notes = $GLOBALS['cyberfunk_footnotes'];
	if ( empty( $notes ) ) {
		return $content;
	}

	$post_id = get_the_ID();
	$list    = '<div class="footnotes"><p class="footnotes-label">' . esc_html__( 'FOOTNOTES', 'cyberfunk' ) . '</p><ol class="footnotes-list">';

	foreach ( $notes as $i => $note ) {
		$idx     = $i + 1;
		$ref_id  = 'fn-' . $idx . '-' . $post_id;
		$back_id = 'fnref-' . $idx . '-' . $post_id;
		$list   .= '<li id="' . esc_attr( $ref_id ) . '" class="footnote-item">';
		$list   .= wp_kses_post( $note );
		$list   .= ' <a href="#' . esc_attr( $back_id ) . '" class="fn-backref" aria-label="' . esc_attr__( 'Back to reference', 'cyberfunk' ) . '">&#x21A9;</a>';
		$list   .= '</li>';
	}

	$list .= '</ol></div>';

	// Reset for next post in case the loop continues.
	$GLOBALS['cyberfunk_footnotes'] = [];

	return $content . $list;
}

/**
 * Resets the footnotes registry when a new post is set up in the loop.
 */
function cyberfunk_footnotes_reset() {
	$GLOBALS['cyberfunk_footnotes'] = [];
}

/**
 * AJAX increment a reaction count for a post.
 */
function cyberfunk_react_ajax_handler() {
	check_ajax_referer( 'cyberfunk_react', 'nonce' );

	$post_id  = absint( $_POST['post_id'] ?? 0 );
	$reaction = sanitize_key( $_POST['reaction'] ?? '' );
	$valid    = [ 'fire', 'hype', 'intel', 'confused' ];

	if ( ! $post_id || ! in_array( $reaction, $valid, true ) ) {
		wp_send_json_error( [ 'message' => 'Invalid request.' ] );
	}

	$reactions              = cyberfunk_get_reactions( $post_id );
	$reactions[ $reaction ] = absint( $reactions[ $reaction ] ) + 1;
	update_post_meta( $post_id, '_cyberfunk_reactions', $reactions );

	wp_send_json_success( [
		'reaction' => $reaction,
		'count'    => $reactions[ $reaction ],
	] );
}

/**
 * Returns the word count for a post.
 */
function cyberfunk_get_word_count( $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	$content = get_post_field( 'post_content', absint( $post_id ) );
	return str_word_count( wp_strip_all_tags( $content ) );
}

/**
 * Shortcode: [pullquote align="left|right"]text[/pullquote]
 */
function cyberfunk_pullquote_shortcode( $atts, $content = '' ) {
	$atts  = shortcode_atts( [ 'align' => 'right' ], $atts, 'pullquote' );
	$align = in_array( $atts['align'], [ 'left', 'right' ], true ) ? $atts['align'] : 'right';

	return '<blockquote class="pullquote pullquote--' . esc_attr( $align ) . '">' .
		wp_kses_post( do_shortcode( $content ) ) .
		'</blockquote>';
}

/**
 * Shortcode: [diff lang="php"]...diff output...[/diff]
 */
function cyberfunk_diff_shortcode( $atts, $content = '' ) {
	$atts = shortcode_atts( [ 'lang' => '' ], $atts, 'diff' );
	$lang = sanitize_key( $atts['lang'] );

	// Strip any auto-p tags WordPress may have injected.
	$raw   = wp_strip_all_tags( html_entity_decode( $content, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	$lines = explode( "\n", trim( $raw ) );

	$html = '<div class="diff-block">';
	$html .= '<div class="diff-header">';
	$html .= '<span class="diff-badge">DIFF</span>';
	if ( $lang ) {
		$html .= '<span class="diff-lang">' . esc_html( strtoupper( $lang ) ) . '</span>';
	}
	$html .= '</div><pre class="diff-pre">';

	foreach ( $lines as $line ) {
		$first = isset( $line[0] ) ? $line[0] : '';
		if ( '+' === $first ) {
			$html .= '<span class="diff-add">' . esc_html( $line ) . "\n" . '</span>';
		} elseif ( '-' === $first ) {
			$html .= '<span class="diff-remove">' . esc_html( $line ) . "\n" . '</span>';
		} elseif ( '@' === $first ) {
			$html .= '<span class="diff-hunk">' . esc_html( $line ) . "\n" . '</span>';
		} else {
			$html .= '<span class="diff-ctx">' . esc_html( $line ) . "\n" . '</span>';
		}
	}

	$html .= '</pre></div>';
	return $html;
}

/**
 * Shortcode: [kbd]Ctrl+Shift+K[/kbd]
 */
function cyberfunk_kbd_shortcode( $atts, $content = '' ) {
	$keys   = explode( '+', wp_strip_all_tags( $content ) );
	$output = '<span class="kbd-combo">';
	foreach ( $keys as $i => $key ) {
		if ( $i > 0 ) {
			$output .= '<span class="kbd-sep" aria-hidden="true">+</span>';
		}
		$output .= '<kbd class="kbd-key">' . esc_html( trim( $key ) ) . '</kbd>';
	}
	$output .= '</span>';
	return $output;
}

/**
 * Shortcode: [changelog]...[/changelog]
 */
function cyberfunk_changelog_shortcode( $atts, $content = '' ) {
	$html  = '<div class="changelog-block">';
	$html .= '<div class="changelog-header">';
	$html .= '<i class="fa-solid fa-code-commit" aria-hidden="true"></i>';
	$html .= '<span>' . esc_html__( 'CHANGELOG', 'cyberfunk' ) . '</span>';
	$html .= '</div>';
	$html .= '<div class="changelog-body">' . do_shortcode( $content ) . '</div>';
	$html .= '</div>';
	return $html;
}

/**
 * Shortcode: [version num="1.2.0" date="2026-04-15"]notes[/version]
 */
function cyberfunk_version_shortcode( $atts, $content = '' ) {
	$atts = shortcode_atts( [ 'num' => '', 'date' => '' ], $atts, 'version' );

	$html  = '<div class="changelog-version">';
	$html .= '<div class="cv-header">';
	if ( $atts['num'] ) {
		$html .= '<span class="cv-num">' . esc_html( $atts['num'] ) . '</span>';
	}
	if ( $atts['date'] ) {
		$html .= '<span class="cv-date">' . esc_html( $atts['date'] ) . '</span>';
	}
	$html .= '</div>';
	$html .= '<div class="cv-body">' . wp_kses_post( wpautop( $content ) ) . '</div>';
	$html .= '</div>';
	return $html;
}

/**
 * Renders the difficulty meta box content in the post editor sidebar.
 */
function cyberfunk_difficulty_meta_box_render( $post ) {
	wp_nonce_field( 'cyberfunk_save_difficulty', 'cyberfunk_difficulty_nonce' );
	$current = sanitize_key( (string) get_post_meta( $post->ID, '_cyberfunk_difficulty', true ) );
	$options = [
		''             => __( '— Not set —', 'cyberfunk' ),
		'beginner'     => __( 'Beginner', 'cyberfunk' ),
		'intermediate' => __( 'Intermediate', 'cyberfunk' ),
		'advanced'     => __( 'Advanced', 'cyberfunk' ),
	];
	echo '<select name="cyberfunk_difficulty" id="cyberfunk_difficulty" style="width:100%">';
	foreach ( $options as $val => $label ) {
		printf(
			'<option value="%s"%s>%s</option>',
			esc_attr( $val ),
			selected( $current, $val, false ),
			esc_html( $label )
		);
	}
	echo '</select>';
	echo '<p class="description" style="margin-top:6px">' . esc_html__( 'Reader skill level required for this post.', 'cyberfunk' ) . '</p>';
}

/**
 * Registers the difficulty meta box on the post editor screen.
 */
function cyberfunk_register_difficulty_meta_box() {
	add_meta_box(
		'cyberfunk-difficulty',
		esc_html__( 'Post Difficulty', 'cyberfunk' ),
		'cyberfunk_difficulty_meta_box_render',
		'post',
		'side',
		'default'
	);
}

/**
 * Saves the difficulty post meta from the editor meta box.
 */
function cyberfunk_save_difficulty_meta( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}
	if (
		! isset( $_POST['cyberfunk_difficulty_nonce'] ) ||
		! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['cyberfunk_difficulty_nonce'] ) ),
			'cyberfunk_save_difficulty'
		)
	) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$difficulty = isset( $_POST['cyberfunk_difficulty'] )
		? sanitize_key( wp_unslash( $_POST['cyberfunk_difficulty'] ) )
		: '';
	$allowed = [ '', 'beginner', 'intermediate', 'advanced' ];
	if ( ! in_array( $difficulty, $allowed, true ) ) {
		return;
	}
	if ( $difficulty ) {
		update_post_meta( $post_id, '_cyberfunk_difficulty', $difficulty );
	} else {
		delete_post_meta( $post_id, '_cyberfunk_difficulty' );
	}
}

/**
 * Adds a view-count node to the admin bar on single post pages.
 */
function cyberfunk_admin_bar_view_count( $wp_admin_bar ) {
	if ( ! is_singular( 'post' ) || ! is_admin_bar_showing() ) {
		return;
	}
	$post_id = get_the_ID();
	if ( ! $post_id ) {
		return;
	}
	$views = cyberfunk_get_view_count( $post_id );
	$label = sprintf( esc_html__( '%s views', 'cyberfunk' ), number_format_i18n( $views ) );
	$wp_admin_bar->add_node( [
		'id'    => 'cyberfunk-view-count',
		'title' => '<span class="ab-icon dashicons dashicons-visibility" aria-hidden="true"></span> ' . esc_html( $label ),
		'href'  => false,
		'meta'  => [ 'title' => esc_attr( $label ) ],
	] );
}

/**
 * Appends the active visual-style class to <body>.
 */
function cyberfunk_body_style_class( $classes ) {
	$style     = get_theme_mod( 'cyberfunk_visual_style', 'cyberpunk' );
	$allowed   = [ 'cyberpunk', 'scifi-hud' ];
	$style     = in_array( $style, $allowed, true ) ? $style : 'cyberpunk';
	$classes[] = 'style-' . $style;
	return $classes;
}

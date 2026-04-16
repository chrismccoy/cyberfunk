<?php
/**
 * Theme functions and definitions.
 *
 * @package Cyberfunk
 */

define( 'CYBERFUNK_VERSION', wp_get_theme()->get( 'Version' ) );

if ( ! isset( $content_width ) ) {
	$content_width = 1240;
}

require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/comments.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/series.php';

add_action( 'after_setup_theme',        'cyberfunk_setup' );
add_action( 'widgets_init',             'cyberfunk_widgets_init' );
add_action( 'wp_enqueue_scripts',       'cyberfunk_scripts' );
add_action( 'customize_register',       'cyberfunk_customize_register' );
add_action( 'show_user_profile',        'cyberfunk_add_author_meta_fields' );
add_action( 'edit_user_profile',        'cyberfunk_add_author_meta_fields' );
add_action( 'personal_options_update',  'cyberfunk_save_author_meta_fields' );
add_action( 'edit_user_profile_update', 'cyberfunk_save_author_meta_fields' );
add_filter( 'post_gallery',             'cyberfunk_gallery_shortcode', 10, 2 );
add_action( 'wp_head',                  'cyberfunk_meta_tags', 1 );
add_action( 'template_redirect',        'cyberfunk_redirect_search_url' );
add_filter( 'the_content',             'cyberfunk_strip_code_from_excerpt', 12 );
add_filter( 'the_content',             'cyberfunk_footnotes_append', 15 );
add_action( 'the_post',               'cyberfunk_footnotes_reset' );
add_shortcode( 'codeblock',  'cyberfunk_code_shortcode' );
add_shortcode( 'callout',    'cyberfunk_callout_shortcode' );
add_shortcode( 'spoiler',    'cyberfunk_spoiler_shortcode' );
add_shortcode( 'fn',         'cyberfunk_footnote_shortcode' );
add_shortcode( 'pullquote',  'cyberfunk_pullquote_shortcode' );
add_shortcode( 'diff',       'cyberfunk_diff_shortcode' );
add_shortcode( 'kbd',        'cyberfunk_kbd_shortcode' );
add_shortcode( 'changelog',  'cyberfunk_changelog_shortcode' );
add_shortcode( 'version',    'cyberfunk_version_shortcode' );
add_filter( 'excerpt_length',           'cyberfunk_excerpt_length', 99 );
add_filter( 'excerpt_more',             'cyberfunk_excerpt_more', 99 );
add_filter( 'embed_oembed_html',        'cyberfunk_embed_oembed_html', 10, 4 );
add_filter( 'wp_video_shortcode',       'cyberfunk_video_shortcode', 10, 5 );
add_filter( 'the_content',             'cyberfunk_toc_inject' );
add_filter( 'the_content',             'cyberfunk_wrap_tables' );
add_filter( 'the_excerpt',             'cyberfunk_highlight_search_terms', 20 );
add_filter( 'wp_resource_hints',       'cyberfunk_resource_hints', 10, 2 );
add_action( 'wp_head',                 'cyberfunk_increment_view_count' );
add_action( 'init',                    'cyberfunk_register_series_taxonomy' );
add_action( 'init',                    'cyberfunk_register_reading_time_endpoint' );
add_action( 'after_switch_theme',      'cyberfunk_flush_rewrite_rules' );
add_action( 'save_post',              'cyberfunk_save_post_reading_time' );
add_action( 'pre_get_posts',          'cyberfunk_filter_by_reading_time' );
add_action( 'admin_init',             'cyberfunk_maybe_backfill_reading_times' );
add_action( 'wp_ajax_cyberfunk_react',        'cyberfunk_react_ajax_handler' );
add_action( 'wp_ajax_nopriv_cyberfunk_react', 'cyberfunk_react_ajax_handler' );
add_action( 'add_meta_boxes',                 'cyberfunk_register_difficulty_meta_box' );
add_action( 'save_post',                      'cyberfunk_save_difficulty_meta' );
add_action( 'admin_bar_menu',                 'cyberfunk_admin_bar_view_count', 100 );
add_filter( 'body_class',                     'cyberfunk_body_style_class' );

/**
 * Sets up theme defaults and registers theme features.
 */
function cyberfunk_setup() {
	load_theme_textdomain( 'cyberfunk', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-logo', [
		'height'      => 58,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );

	register_nav_menus( [
		'primary'        => esc_html__( 'Primary Menu', 'cyberfunk' ),
		'footer-sectors' => esc_html__( 'Footer — Sectors', 'cyberfunk' ),
		'footer-system'  => esc_html__( 'Footer — System', 'cyberfunk' ),
	] );

	add_theme_support( 'post-formats', [ 'aside', 'link', 'quote', 'video' ] );

	add_image_size( 'cyberfunk-hero', 1200, 600, true );
	add_image_size( 'cyberfunk-card', 900, 420, true );
	add_image_size( 'cyberfunk-mini', 120, 100, true );
}

/**
 * Enqueues scripts and styles.
 */
function cyberfunk_scripts() {
	// Google Fonts — Orbitron + Rajdhani + Share Tech Mono
	wp_enqueue_style(
		'cyberfunk-fonts',
		'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800&family=Rajdhani:wght@400;500;600;700&family=Share+Tech+Mono&display=swap',
		[],
		null
	);

	// Font Awesome via CDN.
	wp_enqueue_style(
		'cyberfunk-fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css',
		[],
		'6.5.0'
	);

	// Primary stylesheet — compiled Tailwind output.
	$css_path = get_template_directory() . '/assets/css/theme.css';
	$version  = file_exists( $css_path )
		? filemtime( $css_path )
		: CYBERFUNK_VERSION;

	wp_enqueue_style(
		'cyberfunk-style',
		get_template_directory_uri() . '/assets/css/theme.css',
		[ 'cyberfunk-fonts', 'cyberfunk-fontawesome' ],
		$version
	);

	// Global — navigation, accordion, read tracker, back-to-top, command palette.
	wp_enqueue_script(
		'cyberfunk-theme',
		get_template_directory_uri() . '/assets/js/theme.js',
		[],
		CYBERFUNK_VERSION,
		[ 'in_footer' => true, 'strategy' => 'defer' ]
	);

	// Global — reading list queue buttons (needed on archive cards + single posts).
	wp_enqueue_script(
		'cyberfunk-reading-list',
		get_template_directory_uri() . '/assets/js/reading-list.js',
		[],
		CYBERFUNK_VERSION,
		[ 'in_footer' => true, 'strategy' => 'defer' ]
	);

	// Pass REST API root and home URL to the command palette.
	wp_localize_script( 'cyberfunk-theme', 'cyberfunkData', [
		'restUrl'    => esc_url_raw( rest_url() ),
		'homeUrl'    => esc_url_raw( home_url( '/' ) ),
		'ajaxUrl'    => esc_url_raw( admin_url( 'admin-ajax.php' ) ),
		'reactNonce' => wp_create_nonce( 'cyberfunk_react' ),
	] );

	// Singular — reading progress, share, TOC, lightbox, code copy.
	if ( is_singular() ) {
		// Pass post data to single.js for recently-viewed tracking.
		if ( is_singular( 'post' ) ) {
			wp_localize_script( 'cyberfunk-single', 'cyberfunkPost', [
				'id'    => (string) absint( get_the_ID() ),
				'title' => esc_html( get_the_title() ),
				'url'   => esc_url( get_permalink() ),
				'thumb' => esc_url( (string) ( get_the_post_thumbnail_url( null, 'cyberfunk-mini' ) ?: '' ) ),
				'time'  => (string) absint( cyberfunk_reading_time() ),
			] );
		}

		wp_enqueue_script(
			'cyberfunk-single',
			get_template_directory_uri() . '/assets/js/single.js',
			[],
			CYBERFUNK_VERSION,
			[ 'in_footer' => true, 'strategy' => 'defer' ]
		);

		// Prism.js syntax highlighting via CDN — core + common languages.
		wp_enqueue_script(
			'cyberfunk-prism',
			'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js',
			[],
			'1.29.0',
			[ 'in_footer' => true, 'strategy' => 'defer' ]
		);
		wp_enqueue_script(
			'cyberfunk-prism-autoloader',
			'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js',
			[ 'cyberfunk-prism' ],
			'1.29.0',
			[ 'in_footer' => true, 'strategy' => 'defer' ]
		);
	}

	// Archives — scroll reveal, keyboard shortcuts, reading-time filter.
	if ( ! is_singular() ) {
		wp_enqueue_script(
			'cyberfunk-archive',
			get_template_directory_uri() . '/assets/js/archive.js',
			[],
			CYBERFUNK_VERSION,
			[ 'in_footer' => true, 'strategy' => 'defer' ]
		);
	}

	// Comment reply — threaded comments on singular views.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

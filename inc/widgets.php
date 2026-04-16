<?php
/**
 * Widget area registration, shared helpers, and widget file loader.
 *
 * @package Cyberfunk
 */

require get_template_directory() . '/inc/widgets/widget-search.php';
require get_template_directory() . '/inc/widgets/widget-recent-posts.php';
require get_template_directory() . '/inc/widgets/widget-categories.php';
require get_template_directory() . '/inc/widgets/widget-tag-cloud.php';
require get_template_directory() . '/inc/widgets/widget-archives.php';
require get_template_directory() . '/inc/widgets/widget-most-viewed.php';
require get_template_directory() . '/inc/widgets/widget-recently-viewed.php';
require get_template_directory() . '/inc/widgets/widget-recently-commented.php';
require get_template_directory() . '/inc/widgets/widget-series-progress.php';

/**
 * Outputs the .widget-header row and opens the .widget-body div.
 */
function cyberfunk_widget_header( $label, $status ) {
	?>
	<div class="widget-header">
		<span class="widget-prefix" aria-hidden="true">//</span>
		<span class="widget-title"><?php echo esc_html( $label ); ?></span>
		<span class="widget-status" aria-hidden="true"><?php echo esc_html( $status ); ?></span>
	</div>
	<div class="widget-body">
	<?php
}

/**
 * Maps a category slug to a color modifier class for .cat-link.
 *
 * Returns one of: 'yellow', 'cyan', 'magenta', 'green'.
 * Falls back to 'yellow' for unmapped slugs.
 */
function cyberfunk_category_color_class( $slug ) {
	$map = [
		'world'      => 'cyan',
		'technology' => 'yellow',
		'tech'       => 'yellow',
		'culture'    => 'magenta',
		'opinion'    => 'cyan',
		'science'    => 'yellow',
		'biotech'    => 'yellow',
		'dark-net'   => 'magenta',
		'darknet'    => 'magenta',
		'net'        => 'cyan',
		'network'    => 'green',
		'security'   => 'magenta',
	];

	return $map[ sanitize_key( $slug ) ] ?? 'yellow';
}

/**
 * Maps a category slug to a Font Awesome icon class.
 *
 * Falls back to fa-signal for unmapped slugs.
 */
function cyberfunk_category_icon( $slug ) {
	$map = [
		'world'      => 'fa-solid fa-globe',
		'technology' => 'fa-solid fa-microchip',
		'tech'       => 'fa-solid fa-microchip',
		'culture'    => 'fa-solid fa-masks-theater',
		'opinion'    => 'fa-solid fa-comment-dots',
		'science'    => 'fa-solid fa-flask',
		'biotech'    => 'fa-solid fa-flask',
		'dark-net'   => 'fa-solid fa-eye-slash',
		'darknet'    => 'fa-solid fa-eye-slash',
		'net'        => 'fa-solid fa-network-wired',
		'network'    => 'fa-solid fa-network-wired',
		'security'   => 'fa-solid fa-shield-halved',
	];

	return $map[ sanitize_key( $slug ) ] ?? 'fa-solid fa-signal';
}

/**
 * Registers the Primary Sidebar widget area and all custom widget classes.
 */
function cyberfunk_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Primary Sidebar', 'cyberfunk' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Widgets displayed in the sidebar on archive and single post pages.', 'cyberfunk' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '', // Custom widgets output their own header markup.
		'after_title'   => '',
	] );

	register_widget( 'Cyberfunk_Search_Widget' );
	register_widget( 'Cyberfunk_Recent_Posts_Widget' );
	register_widget( 'Cyberfunk_Categories_Widget' );
	register_widget( 'Cyberfunk_Tag_Cloud_Widget' );
	register_widget( 'Cyberfunk_Archives_Widget' );
	register_widget( 'Cyberfunk_Most_Viewed_Widget' );
	register_widget( 'Cyberfunk_Recently_Viewed_Widget' );
	register_widget( 'Cyberfunk_Recently_Commented_Widget' );
	register_widget( 'Cyberfunk_Series_Progress_Widget' );
}

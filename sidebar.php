<?php
/**
 * Primary sidebar template.
 *
 * @package Cyberfunk
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'cyberfunk' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>

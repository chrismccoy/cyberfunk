<?php
/**
 * Site header template.
 *
 * @package Cyberfunk
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-post-id="<?php echo is_singular( 'post' ) ? absint( get_the_ID() ) : '0'; ?>">
<?php wp_body_open(); ?>

<a class="skip-link sr-only focus-visible-only" href="#primary">
	<?php esc_html_e( 'Skip to content', 'cyberfunk' ); ?>
</a>

<?php
$announce_on   = get_theme_mod( 'cyberfunk_announce_enabled', false );
$announce_text = get_theme_mod( 'cyberfunk_announce_text', '' );
if ( $announce_on && $announce_text ) :
	$announce_type = get_theme_mod( 'cyberfunk_announce_type', 'info' );
?>
<div
	class="announce-bar announce-bar--<?php echo esc_attr( $announce_type ); ?>"
	id="announceBar"
	role="note"
>
	<p class="announce-text"><?php echo wp_kses_post( $announce_text ); ?></p>
	<button
		type="button"
		class="announce-close"
		aria-label="<?php esc_attr_e( 'Dismiss announcement', 'cyberfunk' ); ?>"
	><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
</div>
<?php endif; ?>

<?php if ( get_theme_mod( 'cyberfunk_scanline', true ) ) : ?>
	<div class="scan-line" aria-hidden="true"></div>
<?php endif; ?>

<?php if ( is_single() ) : ?>
	<div class="read-progress" id="readProgress"
		data-reading-time="<?php echo absint( cyberfunk_reading_time() ); ?>"
		aria-hidden="true"></div>
	<div class="read-progress-label" id="readProgressLabel" aria-live="polite" aria-hidden="true"></div>
<?php endif; ?>

<nav class="site-nav" aria-label="<?php esc_attr_e( 'Primary', 'cyberfunk' ); ?>">
	<div class="hazard-stripe" aria-hidden="true"></div>
	<div class="nav-bar">
		<div class="nav-inner">

			<?php cyberfunk_logo(); ?>

			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-links',
				'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				'fallback_cb'    => false,
				'depth'          => 2,
			] );
			?>

			<button
				class="nav-hamburger"
				id="navToggle"
				aria-controls="mobileMenu"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Open navigation menu', 'cyberfunk' ); ?>"
			>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</button>

		</div>

		<div class="mobile-menu" id="mobileMenu" aria-hidden="true">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'fallback_cb'    => false,
				'depth'          => 2,
			] );
			?>
		</div>

	</div>
</nav>

<?php cyberfunk_status_strip(); ?>

<main id="primary">

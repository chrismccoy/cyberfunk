<?php
/**
 * Template part: link post format card.
 *
 * @package Cyberfunk
 */

// Extract the first external URL from the post content for display.
$content     = get_the_content();
$link_url    = '';
$link_domain = '';

if ( preg_match( '/<a\s[^>]*href=["\']([^"\']+)["\'][^>]*>/i', $content, $link_match ) ) {
	$candidate = $link_match[1];
	// Only use if it's an external URL
	if ( 0 !== strpos( $candidate, home_url() ) && 0 === strpos( $candidate, 'http' ) ) {
		$link_url    = $candidate;
		$parsed      = wp_parse_url( $candidate );
		$link_domain = isset( $parsed['host'] ) ? $parsed['host'] : $candidate;
	}
}

// Fall back to post permalink for the card action.
$target_url = $link_url ?: get_permalink();
$is_external = ! empty( $link_url );
?>
<?php if ( post_password_required() ) : ?>
	<?php get_template_part( 'template-parts/content', 'password' ); ?>
<?php return; endif; ?>
<div class="post-wrap post-format-link<?php echo is_sticky() ? ' sticky' : ''; ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card post-card--link' ); ?>>

		<div class="post-content">

			<?php if ( is_sticky() ) : ?>
				<span class="sticky-badge" aria-label="<?php esc_attr_e( 'Pinned post', 'cyberfunk' ); ?>">
					<i class="fa-solid fa-thumbtack" aria-hidden="true"></i>
					<?php esc_html_e( 'SYS::PINNED', 'cyberfunk' ); ?>
				</span>
			<?php endif; ?>

			<span class="format-badge format-badge--link">
				<i class="fa-solid fa-link" aria-hidden="true"></i>
				<?php esc_html_e( 'LINK', 'cyberfunk' ); ?>
			</span>

			<h2 class="post-title">
				<a
					href="<?php echo esc_url( $target_url ); ?>"
					<?php if ( $is_external ) : ?>
						target="_blank"
						rel="noopener noreferrer"
					<?php endif; ?>
				><?php the_title(); ?></a>
			</h2>

			<?php if ( $link_domain ) : ?>
				<p class="link-domain">
					<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
					<?php echo esc_html( $link_domain ); ?>
				</p>
			<?php endif; ?>

			<?php cyberfunk_posted_on(); ?>

			<p class="post-excerpt"><?php the_excerpt(); ?></p>

			<div class="post-footer">
				<a
					href="<?php echo esc_url( $target_url ); ?>"
					class="read-more-btn"
					<?php if ( $is_external ) : ?>
						target="_blank"
						rel="noopener noreferrer"
					<?php endif; ?>
				>
					<?php esc_html_e( 'OPEN_LINK', 'cyberfunk' ); ?>&nbsp;<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
				</a>
				<?php cyberfunk_post_tags(); ?>
			</div>

		</div>

	</article>
</div>

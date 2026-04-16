<?php
/**
 * Site footer template.
 *
 * @package Cyberfunk
 */
?>
</main>

<footer class="site-footer">

	<div class="footer-hazard" aria-hidden="true"></div>

	<div class="footer-inner">
		<div class="footer-grid">

			<div class="footer-brand">
				<?php
				$footer_brand = get_theme_mod( 'cyberfunk_footer_brand', '' );
				$footer_brand = $footer_brand ? $footer_brand : get_bloginfo( 'name' );
				$footer_blurb = get_theme_mod( 'cyberfunk_footer_blurb', '' );
				$footer_blurb = $footer_blurb ? $footer_blurb : get_bloginfo( 'description' );
				?>
				<p class="footer-brand-title">[<?php echo esc_html( $footer_brand ); ?>]</p>
				<?php if ( $footer_blurb ) : ?>
					<p><?php echo wp_kses_post( $footer_blurb ); ?></p>
				<?php endif; ?>
			</div>

			<div class="footer-col">
				<p class="footer-col-title">// <?php esc_html_e( 'SECTORS', 'cyberfunk' ); ?></p>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer-sectors',
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
					'fallback_cb'    => false,
					'depth'          => 1,
				] );
				?>
			</div>

			<div class="footer-col">
				<p class="footer-col-title">// <?php esc_html_e( 'SYSTEM', 'cyberfunk' ); ?></p>
				<?php
				wp_nav_menu( [
					'theme_location' => 'footer-system',
					'container'      => false,
					'items_wrap'     => '<ul>%3$s</ul>',
					'fallback_cb'    => false,
					'depth'          => 1,
				] );
				?>
			</div>

		</div>

		<div class="footer-bottom">
			<p><?php echo cyberfunk_footer_copyright(); ?></p>
			<?php cyberfunk_footer_social(); ?>
		</div>

	</div>

</footer>

<button
	class="back-to-top"
	id="backToTop"
	aria-label="<?php esc_attr_e( 'Back to top', 'cyberfunk' ); ?>"
	hidden
>
	<i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>

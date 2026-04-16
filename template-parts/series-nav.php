<?php
/**
 * Template part: series navigation banner.
 *
 * @package Cyberfunk
 */

$series = cyberfunk_get_series_data();
if ( ! $series ) {
	return;
}
?>
<nav class="series-nav" aria-label="<?php esc_attr_e( 'Post series navigation', 'cyberfunk' ); ?>">

	<div class="series-nav-header">
		<span class="series-nav-eyebrow"><?php esc_html_e( 'SERIES //', 'cyberfunk' ); ?></span>
		<a href="<?php echo esc_url( get_term_link( $series['term'] ) ); ?>" class="series-nav-name">
			<?php echo esc_html( strtoupper( $series['term']->name ) ); ?>
		</a>
		<span class="series-nav-count">
			<?php
			printf(
				esc_html__( 'PART %1$d OF %2$d', 'cyberfunk' ),
				absint( $series['position'] ),
				absint( $series['total'] )
			);
			?>
		</span>
		<span class="series-nav-time">
			<?php
			printf(
				esc_html__( '%d MIN TOTAL', 'cyberfunk' ),
				absint( $series['total_read_time'] )
			);
			?>
		</span>
	</div>

	<?php if ( $series['prev'] || $series['next'] ) : ?>
		<div class="series-nav-links">

			<?php if ( $series['prev'] ) : ?>
				<a href="<?php echo esc_url( get_permalink( $series['prev'] ) ); ?>" class="series-nav-btn series-prev">
					<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
					<span class="series-btn-inner">
						<span class="series-btn-label"><?php esc_html_e( 'PREV', 'cyberfunk' ); ?></span>
						<span class="series-btn-title"><?php echo esc_html( get_the_title( $series['prev'] ) ); ?></span>
					</span>
				</a>
			<?php endif; ?>

			<?php if ( $series['next'] ) : ?>
				<a href="<?php echo esc_url( get_permalink( $series['next'] ) ); ?>" class="series-nav-btn series-next">
					<span class="series-btn-inner">
						<span class="series-btn-label"><?php esc_html_e( 'NEXT', 'cyberfunk' ); ?></span>
						<span class="series-btn-title"><?php echo esc_html( get_the_title( $series['next'] ) ); ?></span>
					</span>
					<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
				</a>
			<?php endif; ?>

		</div>
	<?php endif; ?>

	<details class="series-toc">
		<summary class="series-toc-toggle">
			<i class="fa-solid fa-list" aria-hidden="true"></i>
			<?php esc_html_e( 'ALL_PARTS', 'cyberfunk' ); ?>
			<i class="fa-solid fa-chevron-down series-toc-caret" aria-hidden="true"></i>
		</summary>
		<ol class="series-toc-list">
			<?php foreach ( $series['all_posts'] as $post_item ) : ?>
				<?php $is_current = absint( $post_item['id'] ) === get_the_ID(); ?>
				<li
					class="series-toc-item<?php echo $is_current ? ' series-toc-current' : ''; ?>"
					data-post-id="<?php echo absint( $post_item['id'] ); ?>"
				>
					<?php if ( $is_current ) : ?>
						<span class="series-toc-link series-toc-active">
							<i class="fa-solid fa-chevron-right series-toc-curr-icon" aria-hidden="true"></i>
							<?php echo esc_html( get_the_title( $post_item['id'] ) ); ?>
						</span>
					<?php else : ?>
						<a href="<?php echo esc_url( $post_item['permalink'] ); ?>" class="series-toc-link">
							<?php echo esc_html( get_the_title( $post_item['id'] ) ); ?>
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</details>

</nav>

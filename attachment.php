<?php
/**
 * Media attachment template.
 *
 * @package Cyberfunk
 */

get_header();
?>

<div class="page-wrapper">
	<div class="attachment-page">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php cyberfunk_breadcrumb(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'attachment-article' ); ?>>

				<header class="attachment-header">
					<span class="attachment-label" aria-hidden="true">
						<?php
						echo esc_html(
							wp_attachment_is_image()
								? __( 'SYS::IMAGE_ASSET', 'cyberfunk' )
								: __( 'SYS::FILE_ASSET', 'cyberfunk' )
						);
						?>
					</span>
					<h1 class="post-main-title"><?php the_title(); ?></h1>
					<div class="post-header-meta">
						<span>
							<i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
							</time>
						</span>
					</div>
				</header>

				<?php if ( wp_attachment_is_image() ) : ?>
					<div class="attachment-image-wrap">
						<?php
						echo wp_get_attachment_image(
							get_the_ID(),
							'full',
							false,
							[
								'class'         => 'attachment-full-img',
								'loading'       => 'lazy',
								'fetchpriority' => 'high',
							]
						);
						?>
					</div>

					<?php
					$meta = wp_get_attachment_metadata( get_the_ID() );
					if ( ! empty( $meta['image_meta'] ) ) :
						$exif = array_filter( [
							__( 'CAMERA', 'cyberfunk' )   => $meta['image_meta']['camera'] ?? '',
							__( 'APERTURE', 'cyberfunk' ) => $meta['image_meta']['aperture'] ?? '',
							__( 'FOCAL', 'cyberfunk' )    => $meta['image_meta']['focal_length'] ? $meta['image_meta']['focal_length'] . 'mm' : '',
							__( 'ISO', 'cyberfunk' )       => $meta['image_meta']['iso'] ?? '',
							__( 'SHUTTER', 'cyberfunk' )  => $meta['image_meta']['shutter_speed'] ? $meta['image_meta']['shutter_speed'] . 's' : '',
						] );
					?>
						<?php if ( ! empty( $exif ) ) : ?>
							<div class="attachment-exif">
								<p class="attachment-exif-label"><?php esc_html_e( 'EXIF_DATA', 'cyberfunk' ); ?></p>
								<dl class="attachment-exif-grid">
									<?php foreach ( $exif as $label => $value ) : ?>
										<dt><?php echo esc_html( $label ); ?></dt>
										<dd><?php echo esc_html( $value ); ?></dd>
									<?php endforeach; ?>
								</dl>
							</div>
						<?php endif; ?>
					<?php endif; ?>

				<?php else : ?>

					<div class="attachment-file-info">
						<i class="fa-solid fa-file" aria-hidden="true"></i>
						<p class="attachment-filename"><?php echo esc_html( basename( get_attached_file( get_the_ID() ) ) ); ?></p>
						<a
							href="<?php echo esc_url( wp_get_attachment_url( get_the_ID() ) ); ?>"
							class="btn-primary"
							download
						>
							<i class="fa-solid fa-download" aria-hidden="true"></i>
							<?php esc_html_e( 'DOWNLOAD_FILE', 'cyberfunk' ); ?>
						</a>
					</div>

				<?php endif; ?>

				<?php if ( has_excerpt() || get_the_content() ) : ?>
					<div class="attachment-description post-body">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

				<?php
				$parent_id = wp_get_post_parent_id( get_the_ID() );
				if ( $parent_id ) :
				?>
					<a
						href="<?php echo esc_url( get_permalink( $parent_id ) ); ?>"
						class="attachment-back"
					>
						<i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
						<?php esc_html_e( 'RETURN_TO_SOURCE', 'cyberfunk' ); ?>
					</a>
				<?php endif; ?>

			</article>

		<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>

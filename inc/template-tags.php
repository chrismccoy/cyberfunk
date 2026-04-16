<?php
/**
 * Template tag functions.
 *
 * @package Cyberfunk
 */

/**
 * Outputs the site logo with a text fallback.
 */
if ( ! function_exists( 'cyberfunk_logo' ) ) :
	function cyberfunk_logo() {
		if ( has_custom_logo() ) {
			the_custom_logo();
			return;
		}
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home">
			[<?php bloginfo( 'name' ); ?>]
		</a>
		<?php
	}
endif;

/**
 * Outputs the status strip bar below the nav.
 */
if ( ! function_exists( 'cyberfunk_status_strip' ) ) :
	function cyberfunk_status_strip() {
		$status_label   = get_theme_mod( 'cyberfunk_status_label',   'SYS::ONLINE' );
		$status_tagline = get_theme_mod( 'cyberfunk_status_tagline', 'SIGNAL THROUGH THE STATIC' );
		?>
		<div class="page-header-strip">
			<p>
				<span class="status-dot" aria-hidden="true"></span>
				<?php if ( is_single() ) : ?>
					<?php echo esc_html( $status_label ); ?>
					&nbsp;&middot;&nbsp;
					<span><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time></span>
					&nbsp;&middot;&nbsp;
					<?php echo esc_html( $status_tagline ); ?>
					&nbsp;&middot;&nbsp;
					<span>
						<?php
						printf(
							esc_html__( '%d RESPONSES LOGGED', 'cyberfunk' ),
							absint( get_comments_number() )
						);
						?>
					</span>
				<?php else : ?>
					<?php echo esc_html( $status_label ); ?>
					&nbsp;&middot;&nbsp;
					<span><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span>
					&nbsp;&middot;&nbsp;
					<?php echo esc_html( $status_tagline ); ?>
					&nbsp;&middot;&nbsp;
					<span>
						<?php
						printf(
							esc_html__( '%d TRANSMISSIONS THIS CYCLE', 'cyberfunk' ),
							absint( wp_count_posts()->publish )
						);
						?>
					</span>
				<?php endif; ?>
			</p>
		</div>
		<?php
	}
endif;

/**
 * Outputs the category badge for the current post.
 */
if ( ! function_exists( 'cyberfunk_category_badge' ) ) :
	function cyberfunk_category_badge() {
		$categories = get_the_category();
		if ( empty( $categories ) ) {
			return;
		}

		$cat       = $categories[0];
		$mod_class = cyberfunk_category_badge_class( $cat->slug );
		$classes   = 'post-category-badge' . ( $mod_class ? ' ' . $mod_class : '' );
		?>
		<a
			href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
			class="<?php echo esc_attr( $classes ); ?>"
		>[SYS::<?php echo esc_html( strtoupper( $cat->name ) ); ?>]</a>
		<?php
	}
endif;

/**
 * Outputs the post meta row: author, date, reading time, comment count.
 */
if ( ! function_exists( 'cyberfunk_posted_on' ) ) :
	function cyberfunk_posted_on() {
		?>
		<div class="post-meta">
			<span>
				<i class="fa-solid fa-user-secret" aria-hidden="true"></i>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo esc_html( strtoupper( get_the_author() ) ); ?>
				</a>
			</span>
			<span>
				<i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
				</time>
			</span>
			<span>
				<i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
				<?php
				printf(
					esc_html__( '%d MIN READ', 'cyberfunk' ),
					absint( cyberfunk_reading_time() )
				);
				?>
			</span>
			<span>
				<i class="fa-solid fa-align-left" aria-hidden="true"></i>
				<?php
				printf(
					/* translators: %s: formatted word count */
					esc_html__( '%s WORDS', 'cyberfunk' ),
					number_format_i18n( cyberfunk_get_word_count() )
				);
				?>
			</span>
			<span>
				<i class="fa-regular fa-comment" aria-hidden="true"></i>
				<?php
				printf(
					esc_html__( '%d REPLIES', 'cyberfunk' ),
					absint( get_comments_number() )
				);
				?>
			</span>
		</div>
		<?php
	}
endif;

/**
 * Outputs the post meta row for single posts (author, date, read time, replies, views).
 */
if ( ! function_exists( 'cyberfunk_single_meta' ) ) :
	function cyberfunk_single_meta() {
		?>
		<div class="post-header-meta">
			<span>
				<i class="fa-solid fa-user-secret" aria-hidden="true"></i>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
					<?php echo esc_html( strtoupper( get_the_author() ) ); ?>
				</a>
			</span>
			<span>
				<i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
				</time>
			</span>
			<span>
				<i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
				<?php
				printf(
					esc_html__( '%d MIN READ', 'cyberfunk' ),
					absint( cyberfunk_reading_time() )
				);
				?>
			</span>
			<span>
				<i class="fa-solid fa-align-left" aria-hidden="true"></i>
				<?php
				printf(
					/* translators: %s: formatted word count */
					esc_html__( '%s WORDS', 'cyberfunk' ),
					number_format_i18n( cyberfunk_get_word_count() )
				);
				?>
			</span>
			<span>
				<i class="fa-regular fa-comment" aria-hidden="true"></i>
				<?php
				printf(
					esc_html__( '%d REPLIES', 'cyberfunk' ),
					absint( get_comments_number() )
				);
				?>
			</span>
			<span>
				<i class="fa-solid fa-eye" aria-hidden="true"></i>
				<?php
				$view_count = cyberfunk_get_view_count();
				printf(
					esc_html__( '%d VIEWS', 'cyberfunk' ),
					absint( $view_count )
				);
				$milestones = [ 5000 => 'LEGENDARY', 1000 => 'VIRAL', 500 => 'TRENDING', 100 => 'HOT' ];
				foreach ( $milestones as $threshold => $milestone_label ) {
					if ( $view_count >= $threshold ) {
						echo ' <span class="view-milestone view-milestone--' . esc_attr( strtolower( $milestone_label ) ) . '">' . esc_html( $milestone_label ) . '</span>';
						break;
					}
				}
				?>
			</span>
		</div>
		<?php
	}
endif;

/**
 * Outputs a "last updated" notice when the post was significantly modified after publication.
 */
if ( ! function_exists( 'cyberfunk_updated_notice' ) ) :
	function cyberfunk_updated_notice( $threshold_days = 30 ) {
		$published   = (int) get_the_date( 'U' );
		$modified    = (int) get_the_modified_date( 'U' );
		$diff_days   = ( $modified - $published ) / DAY_IN_SECONDS;

		if ( $diff_days < $threshold_days ) {
			return;
		}
		?>
		<div class="updated-notice">
			<i class="fa-solid fa-rotate" aria-hidden="true"></i>
			<?php
			printf(
				esc_html__( 'UPDATED: %s', 'cyberfunk' ),
				esc_html( get_the_modified_date( 'Y.m.d' ) )
			);
			?>
		</div>
		<?php
	}
endif;

/**
 * Outputs the breadcrumb navigation for the current page.
 */
if ( ! function_exists( 'cyberfunk_breadcrumb' ) ) :
	function cyberfunk_breadcrumb() {
		$trail = cyberfunk_breadcrumb_trail();
		if ( count( $trail ) <= 1 ) {
			return;
		}
		?>
		<nav class="breadcrumb-bar" aria-label="<?php esc_attr_e( 'Breadcrumb', 'cyberfunk' ); ?>">
			<?php foreach ( $trail as $i => $crumb ) : ?>
				<?php if ( $i > 0 ) : ?>
					<span class="breadcrumb-sep" aria-hidden="true">&rsaquo;</span>
				<?php endif; ?>
				<?php if ( isset( $crumb['url'] ) ) : ?>
					<a href="<?php echo esc_url( $crumb['url'] ); ?>">
						<?php echo esc_html( $crumb['label'] ); ?>
					</a>
				<?php else : ?>
					<span class="current" aria-current="page">
						<?php echo esc_html( $crumb['label'] ); ?>
					</span>
				<?php endif; ?>
			<?php endforeach; ?>
		</nav>
		<?php
	}
endif;

/**
 * Outputs the tag chip links for the current post (archive card style).
 */
if ( ! function_exists( 'cyberfunk_post_tags' ) ) :
	function cyberfunk_post_tags() {
		$tags = get_the_tags();
		if ( empty( $tags ) ) {
			return;
		}
		?>
		<div class="post-tags">
			<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-chip">
					<?php echo esc_html( $tag->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}
endif;

/**
 * Outputs the post tags row with label for single post footers.
 */
if ( ! function_exists( 'cyberfunk_post_tags_row' ) ) :
	function cyberfunk_post_tags_row() {
		$tags = get_the_tags();
		if ( empty( $tags ) ) {
			return;
		}
		?>
		<div class="post-tags-row">
			<span class="tags-label"><?php esc_html_e( 'TAGS::', 'cyberfunk' ); ?></span>
			<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">
					<?php echo esc_html( $tag->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
		<?php
	}
endif;

/**
 * Outputs the social share buttons row for the current post.
 */
if ( ! function_exists( 'cyberfunk_share_buttons' ) ) :
	function cyberfunk_share_buttons() {
		$urls = cyberfunk_get_share_urls();
		?>
		<div class="share-row">
			<span class="share-label"><?php esc_html_e( 'SHARE::', 'cyberfunk' ); ?></span>
			<a
				href="<?php echo esc_url( $urls['x'] ); ?>"
				class="share-btn"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on X', 'cyberfunk' ); ?>"
			><i class="fab fa-x-twitter" aria-hidden="true"></i></a>
			<a
				href="<?php echo esc_url( $urls['mastodon'] ); ?>"
				class="share-btn"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on Mastodon', 'cyberfunk' ); ?>"
			><i class="fab fa-mastodon" aria-hidden="true"></i></a>
			<a
				href="<?php echo esc_url( $urls['telegram'] ); ?>"
				class="share-btn"
				target="_blank"
				rel="noopener noreferrer"
				aria-label="<?php esc_attr_e( 'Share on Telegram', 'cyberfunk' ); ?>"
			><i class="fab fa-telegram" aria-hidden="true"></i></a>
			<button
				type="button"
				class="share-btn js-copy-link"
				data-copy-url="<?php echo esc_attr( $urls['copy'] ); ?>"
				aria-label="<?php esc_attr_e( 'Copy link', 'cyberfunk' ); ?>"
			><i class="fa-solid fa-link" aria-hidden="true"></i></button>
		</div>
		<?php
	}
endif;

/**
 * Outputs the author bio box for the current post.
 */
if ( ! function_exists( 'cyberfunk_author_bio' ) ) :
	function cyberfunk_author_bio() {
		$user_id  = (int) get_the_author_meta( 'ID' );
		$name     = strtoupper( get_the_author() );
		$bio      = get_the_author_meta( 'description' );
		$handle   = cyberfunk_get_author_meta( $user_id, 'handle' );
		$twitter  = cyberfunk_get_author_meta( $user_id, 'social_twitter' );
		$mastodon = cyberfunk_get_author_meta( $user_id, 'social_mastodon' );
		$telegram = cyberfunk_get_author_meta( $user_id, 'social_telegram' );
		?>
		<div class="author-bio">
			<div class="author-bio-header"><?php esc_html_e( 'OPERATIVE_PROFILE', 'cyberfunk' ); ?></div>
			<div class="author-bio-inner">
				<?php echo get_avatar( $user_id, 64, '', esc_attr( $name ), [ 'class' => 'author-avatar' ] ); ?>
				<div class="author-info">
					<h4><?php echo esc_html( $name ); ?></h4>
					<?php if ( $handle ) : ?>
						<p class="author-handle"><?php echo esc_html( $handle ); ?></p>
					<?php endif; ?>
					<?php if ( $bio ) : ?>
						<p class="author-bio-text"><?php echo esc_html( $bio ); ?></p>
					<?php endif; ?>
					<?php if ( $twitter || $mastodon || $telegram ) : ?>
						<div class="author-social">
							<?php if ( $twitter ) : ?>
								<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'X / Twitter', 'cyberfunk' ); ?>">
									<i class="fab fa-x-twitter" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
							<?php if ( $mastodon ) : ?>
								<a href="<?php echo esc_url( $mastodon ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Mastodon', 'cyberfunk' ); ?>">
									<i class="fab fa-mastodon" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
							<?php if ( $telegram ) : ?>
								<a href="<?php echo esc_url( $telegram ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Telegram', 'cyberfunk' ); ?>">
									<i class="fab fa-telegram" aria-hidden="true"></i>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
endif;

/**
 * Outputs the previous/next post navigation for single posts.
 */
if ( ! function_exists( 'cyberfunk_post_navigation' ) ) :
	function cyberfunk_post_navigation() {
		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if ( ! $prev_post && ! $next_post ) {
			return;
		}
		?>
		<nav class="post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'cyberfunk' ); ?>">
			<?php if ( $prev_post ) : ?>
				<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-nav-card prev">
					<div class="post-nav-dir">
						<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
						<?php esc_html_e( 'PREV TRANSMISSION', 'cyberfunk' ); ?>
					</div>
					<div class="post-nav-title">
						<?php echo esc_html( strtoupper( get_the_title( $prev_post ) ) ); ?>
					</div>
				</a>
			<?php else : ?>
				<span class="post-nav-card prev post-nav-card--empty"></span>
			<?php endif; ?>

			<?php if ( $next_post ) : ?>
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-nav-card next">
					<div class="post-nav-dir">
						<?php esc_html_e( 'NEXT TRANSMISSION', 'cyberfunk' ); ?>
						<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
					</div>
					<div class="post-nav-title">
						<?php echo esc_html( strtoupper( get_the_title( $next_post ) ) ); ?>
					</div>
				</a>
			<?php else : ?>
				<span class="post-nav-card next post-nav-card--empty"></span>
			<?php endif; ?>
		</nav>
		<?php
	}
endif;

/**
 * Outputs Open Graph and Twitter Card meta tags in <head>.
 */
if ( ! function_exists( 'cyberfunk_meta_tags' ) ) :
	function cyberfunk_meta_tags() {
		// Defer to active SEO plugins to avoid duplicate tags.
		if (
			defined( 'WPSEO_VERSION' ) ||
			defined( 'RANK_MATH_VERSION' ) ||
			defined( 'AIOSEO_VERSION' ) ||
			class_exists( 'The_SEO_Framework\Load' )
		) {
			return;
		}

		$site_name = get_bloginfo( 'name' );
		$og_type   = 'website';
		$og_title  = wp_get_document_title();
		$og_url    = home_url( '/' );
		$og_desc   = '';
		$og_image  = '';

		if ( is_singular() ) {
			$og_type  = 'article';
			$og_url   = get_permalink();
			$og_desc  = has_excerpt()
				? wp_strip_all_tags( get_the_excerpt() )
				: wp_trim_words( wp_strip_all_tags( get_the_content() ), 30, '...' );
			if ( has_post_thumbnail() ) {
				$og_image = get_the_post_thumbnail_url( null, 'cyberfunk-hero' );
			}
		} elseif ( is_home() || is_front_page() ) {
			$og_url  = home_url( '/' );
			$og_desc = get_bloginfo( 'description' );
		} elseif ( is_category() ) {
			$og_url  = get_category_link( get_queried_object_id() );
			$og_desc = wp_strip_all_tags( category_description() );
		} elseif ( is_tag() ) {
			$og_url  = get_tag_link( get_queried_object_id() );
			$og_desc = wp_strip_all_tags( tag_description() );
		} elseif ( is_author() ) {
			$og_url  = get_author_posts_url( get_queried_object_id() );
			$og_desc = get_the_author_meta( 'description', get_queried_object_id() );
		} elseif ( is_search() ) {
			$og_url = get_search_link();
		}

		// Fall back to site icon when no post thumbnail is available.
		if ( ! $og_image ) {
			$og_image = get_site_icon_url( 512 );
		}

		echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
		echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $og_title ) . '">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( $og_url ) . '">' . "\n";

		if ( $og_desc ) {
			echo '<meta name="description" content="' . esc_attr( $og_desc ) . '">' . "\n";
			echo '<meta property="og:description" content="' . esc_attr( $og_desc ) . '">' . "\n";
			echo '<meta name="twitter:description" content="' . esc_attr( $og_desc ) . '">' . "\n";
		}

		if ( $og_image ) {
			echo '<meta property="og:image" content="' . esc_url( $og_image ) . '">' . "\n";
			echo '<meta name="twitter:image" content="' . esc_url( $og_image ) . '">' . "\n";
			echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
		} else {
			echo '<meta name="twitter:card" content="summary">' . "\n";
		}

		echo '<meta name="twitter:title" content="' . esc_attr( $og_title ) . '">' . "\n";

		// Canonical URL.
		echo '<link rel="canonical" href="' . esc_url( $og_url ) . '">' . "\n";

		// Robots — noindex search results and 404.
		if ( is_search() || is_404() ) {
			echo '<meta name="robots" content="noindex, follow">' . "\n";
		}

		// JSON-LD structured data.
		if ( is_singular( 'post' ) ) {
			$author_name = get_the_author();
			$author_url  = get_author_posts_url( (int) get_the_author_meta( 'ID' ) );
			$pub_date    = get_the_date( 'c' );
			$mod_date    = get_the_modified_date( 'c' );

			$schema = [
				'@context'         => 'https://schema.org',
				'@type'            => 'NewsArticle',
				'headline'         => get_the_title(),
				'description'      => $og_desc,
				'url'              => get_permalink(),
				'datePublished'    => $pub_date,
				'dateModified'     => $mod_date,
				'author'           => [
					'@type' => 'Person',
					'name'  => $author_name,
					'url'   => $author_url,
				],
				'publisher'        => [
					'@type' => 'Organization',
					'name'  => $site_name,
					'url'   => home_url( '/' ),
				],
			];

			if ( $og_image ) {
				$schema['image'] = [
					'@type' => 'ImageObject',
					'url'   => $og_image,
				];
			}
		} elseif ( is_front_page() || is_home() ) {
			$schema = [
				'@context'    => 'https://schema.org',
				'@type'       => 'WebSite',
				'name'        => $site_name,
				'url'         => home_url( '/' ),
				'description' => get_bloginfo( 'description' ),
				'potentialAction' => [
					'@type'       => 'SearchAction',
					'target'      => [
						'@type'       => 'EntryPoint',
						'urlTemplate' => home_url( '/search/{search_term_string}/' ),
					],
					'query-input' => 'required name=search_term_string',
				],
			];
		} else {
			$schema = null;
		}

		if ( $schema ) {
			echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
		}

		// BreadcrumbList JSON-LD — output on any page with a trail longer than 1 item.
		$trail = cyberfunk_breadcrumb_trail();
		if ( count( $trail ) > 1 ) {
			$list_items = [];
			foreach ( $trail as $position => $crumb ) {
				$item = [
					'@type'    => 'ListItem',
					'position' => $position + 1,
					'name'     => $crumb['label'],
				];
				if ( isset( $crumb['url'] ) ) {
					$item['item'] = $crumb['url'];
				}
				$list_items[] = $item;
			}
			$breadcrumb_schema = [
				'@context'        => 'https://schema.org',
				'@type'           => 'BreadcrumbList',
				'itemListElement' => $list_items,
			];
			echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
		}
	}
endif;

/**
 * Outputs related posts from the same category below the single post body.
 */
if ( ! function_exists( 'cyberfunk_related_posts' ) ) :
	function cyberfunk_related_posts() {
		$cats = get_the_category();
		if ( empty( $cats ) ) {
			return;
		}

		$related = new WP_Query( [
			'category__in'        => wp_list_pluck( $cats, 'term_id' ),
			'post__not_in'        => [ get_the_ID() ],
			'posts_per_page'      => 3,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		] );

		if ( ! $related->have_posts() ) {
			return;
		}
		?>
		<div class="related-posts">
			<p class="related-label"><?php esc_html_e( 'RELATED_TRANSMISSIONS', 'cyberfunk' ); ?></p>
			<div class="related-grid">
				<?php while ( $related->have_posts() ) : $related->the_post(); ?>
					<div class="related-item">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>" class="related-thumb-link" tabindex="-1" aria-hidden="true">
								<?php the_post_thumbnail( 'cyberfunk-card', [ 'loading' => 'lazy', 'class' => 'related-thumb', 'alt' => '' ] ); ?>
							</a>
						<?php endif; ?>
						<div class="related-content">
							<a href="<?php the_permalink(); ?>" class="related-title">
								<?php echo esc_html( strtoupper( get_the_title() ) ); ?>
							</a>
							<span class="related-date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></span>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
		<?php
	}
endif;

/**
 * Outputs footer social icons
 */
if ( ! function_exists( 'cyberfunk_footer_social' ) ) :
	function cyberfunk_footer_social() {
		$networks = [
			'twitter'  => [ 'icon' => 'fab fa-x-twitter', 'label' => __( 'X / Twitter', 'cyberfunk' ) ],
			'mastodon' => [ 'icon' => 'fab fa-mastodon',  'label' => __( 'Mastodon', 'cyberfunk' ) ],
			'telegram' => [ 'icon' => 'fab fa-telegram',  'label' => __( 'Telegram', 'cyberfunk' ) ],
			'rss'      => [ 'icon' => 'fa-solid fa-rss',  'label' => __( 'RSS Feed', 'cyberfunk' ) ],
		];

		$has_links = false;
		foreach ( $networks as $key => $config ) {
			if ( cyberfunk_get_social_url( $key ) ) {
				$has_links = true;
				break;
			}
		}

		if ( ! $has_links ) {
			return;
		}
		?>
		<div class="footer-social">
			<?php foreach ( $networks as $key => $config ) : ?>
				<?php $url = cyberfunk_get_social_url( $key ); ?>
				<?php if ( $url ) : ?>
					<a
						href="<?php echo esc_url( $url ); ?>"
						class="social-btn"
						<?php if ( 'rss' !== $key ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
						aria-label="<?php echo esc_attr( $config['label'] ); ?>"
					><i class="<?php echo esc_attr( $config['icon'] ); ?>" aria-hidden="true"></i></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'cyberfunk_archive_count' ) ) :
	/**
	 * Output the archive post count badge.
	 */
	function cyberfunk_archive_count( $found_posts ) {
		$count = absint( $found_posts );
		?>
		<span class="archive-count">
			<?php
			printf(
				_n( '%s_RECORD', '%s_RECORDS', $count, 'cyberfunk' ),
				'<strong>' . $count . '</strong>'
			);
			?>
		</span>
		<?php
	}
endif;

/**
 * Outputs the reading-time filter links for archive pages.
 */
if ( ! function_exists( 'cyberfunk_archive_filter' ) ) :
	function cyberfunk_archive_filter() {
		// Active filter comes from the /rtf/ rewrite endpoint, not a GET param.
		$current = sanitize_key( (string) get_query_var( 'rtf' ) );
		if ( ! in_array( $current, [ 'short', 'medium', 'long' ], true ) ) {
			$current = 'all';
		}

		// Base URL: page 1 of the current archive, no /rtf/ segment.
		$base = trailingslashit( cyberfunk_get_archive_base_url() );

		$filters = [
			'all'    => __( 'ALL', 'cyberfunk' ),
			'short'  => __( '&le;5&nbsp;MIN', 'cyberfunk' ),
			'medium' => __( '6&ndash;15&nbsp;MIN', 'cyberfunk' ),
			'long'   => __( '15+&nbsp;MIN', 'cyberfunk' ),
		];
		?>
		<nav class="archive-filter" aria-label="<?php esc_attr_e( 'Filter posts by reading time', 'cyberfunk' ); ?>">
			<?php foreach ( $filters as $key => $label ) :
				$url       = ( 'all' === $key ) ? $base : $base . 'rtf/' . $key . '/';
				$is_active = ( $key === $current );
			?>
				<a
					href="<?php echo esc_url( $url ); ?>"
					class="filter-btn<?php echo $is_active ? ' filter-active' : ''; ?>"
					<?php if ( $is_active ) : ?>aria-current="page"<?php endif; ?>
				><?php echo wp_kses( $label, [ 'span' => [] ] ); ?></a>
			<?php endforeach; ?>
		</nav>
		<?php
	}
endif;

/**
 * Outputs a warning banner when the post is older than the threshold.
 */
if ( ! function_exists( 'cyberfunk_post_age_notice' ) ) :
	function cyberfunk_post_age_notice( $threshold_years = 2 ) {
		$published  = (int) get_the_date( 'U' );
		$age_years  = ( time() - $published ) / YEAR_IN_SECONDS;

		if ( $age_years < $threshold_years ) {
			return;
		}

		$years = (int) floor( $age_years );
		?>
		<div class="post-age-warning" role="note">
			<i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
			<strong>
				<?php
				printf(
					esc_html( _n( 'SIGNAL IS %d YEAR OLD', 'SIGNAL IS %d YEARS OLD', $years, 'cyberfunk' ) ),
					$years
				);
				?>
			</strong>
			&mdash;
			<?php esc_html_e( 'CONTENT MAY BE OUTDATED', 'cyberfunk' ); ?>
		</div>
		<?php
	}
endif;

/**
 * Outputs the reading-list queue button for the current post.
 */
if ( ! function_exists( 'cyberfunk_queue_button' ) ) :
	function cyberfunk_queue_button() {
		$thumb = get_the_post_thumbnail_url( null, 'cyberfunk-mini' );
		?>
		<button
			type="button"
			class="queue-btn js-queue-btn"
			data-post-id="<?php echo absint( get_the_ID() ); ?>"
			data-title="<?php echo esc_attr( get_the_title() ); ?>"
			data-link="<?php echo esc_attr( get_permalink() ); ?>"
			data-time="<?php echo absint( cyberfunk_reading_time() ); ?>"
			data-thumb="<?php echo esc_attr( $thumb ? $thumb : '' ); ?>"
			aria-label="<?php esc_attr_e( 'Add to reading list', 'cyberfunk' ); ?>"
			aria-pressed="false"
		>
			<i class="fa-regular fa-bookmark" aria-hidden="true"></i>
		</button>
		<?php
	}
endif;

/**
 * Outputs the difficulty badge for the current post.
 */
if ( ! function_exists( 'cyberfunk_difficulty_badge' ) ) :
	function cyberfunk_difficulty_badge( $post_id = null ) {
		if ( null === $post_id ) {
			$post_id = get_the_ID();
		}
		$difficulty = sanitize_key( (string) get_post_meta( absint( $post_id ), '_cyberfunk_difficulty', true ) );
		if ( ! $difficulty ) {
			return;
		}
		$labels = [
			'beginner'     => __( 'BEGINNER', 'cyberfunk' ),
			'intermediate' => __( 'INTERMEDIATE', 'cyberfunk' ),
			'advanced'     => __( 'ADVANCED', 'cyberfunk' ),
		];
		if ( ! isset( $labels[ $difficulty ] ) ) {
			return;
		}
		?>
		<span class="difficulty-badge difficulty-<?php echo esc_attr( $difficulty ); ?>">
			<i class="fa-solid fa-signal" aria-hidden="true"></i>
			<?php echo esc_html( $labels[ $difficulty ] ); ?>
		</span>
		<?php
	}
endif;

/**
 * Outputs the difficulty level filter links for archive pages.
 */
if ( ! function_exists( 'cyberfunk_archive_difficulty_filter' ) ) :
	function cyberfunk_archive_difficulty_filter() {
		$current = sanitize_key( (string) get_query_var( 'dif' ) );
		if ( ! in_array( $current, [ 'beginner', 'intermediate', 'advanced' ], true ) ) {
			$current = 'all';
		}
		$base = trailingslashit( cyberfunk_get_archive_base_url() );

		$filters = [
			'all'          => __( 'ALL', 'cyberfunk' ),
			'beginner'     => __( 'BEGINNER', 'cyberfunk' ),
			'intermediate' => __( 'INTERMEDIATE', 'cyberfunk' ),
			'advanced'     => __( 'ADVANCED', 'cyberfunk' ),
		];
		?>
		<nav class="archive-filter archive-filter--difficulty" aria-label="<?php esc_attr_e( 'Filter posts by difficulty', 'cyberfunk' ); ?>">
			<span class="filter-label" aria-hidden="true"><?php esc_html_e( 'LVL::', 'cyberfunk' ); ?></span>
			<?php foreach ( $filters as $key => $label ) :
				$url       = ( 'all' === $key ) ? $base : $base . 'dif/' . $key . '/';
				$is_active = ( $key === $current );
			?>
				<a
					href="<?php echo esc_url( $url ); ?>"
					class="filter-btn<?php echo $is_active ? ' filter-active' : ''; ?>"
					<?php if ( $is_active ) : ?>aria-current="page"<?php endif; ?>
				><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>
		<?php
	}
endif;

/**
 * Outputs font size control buttons for single post pages.
 */
if ( ! function_exists( 'cyberfunk_font_size_controls' ) ) :
	function cyberfunk_font_size_controls() {
		?>
		<div class="font-size-controls" role="group" aria-label="<?php esc_attr_e( 'Text size', 'cyberfunk' ); ?>">
			<span class="fsc-label" aria-hidden="true"><?php esc_html_e( 'SIZE::', 'cyberfunk' ); ?></span>
			<button type="button" class="fsc-btn" data-font-size="fs-small" aria-label="<?php esc_attr_e( 'Small text', 'cyberfunk' ); ?>">A</button>
			<button type="button" class="fsc-btn" data-font-size="fs-medium" aria-label="<?php esc_attr_e( 'Medium text', 'cyberfunk' ); ?>">A</button>
			<button type="button" class="fsc-btn fsc-large" data-font-size="fs-large" aria-label="<?php esc_attr_e( 'Large text', 'cyberfunk' ); ?>">A</button>
		</div>
		<?php
	}
endif;

/**
 * Outputs the post reaction buttons (SIGNAL_BOOST row).
 */
if ( ! function_exists( 'cyberfunk_reaction_buttons' ) ) :
	function cyberfunk_reaction_buttons() {
		$post_id   = get_the_ID();
		$reactions = cyberfunk_get_reactions( $post_id );
		$types     = [
			'fire'    => [ 'icon' => 'fa-fire',            'label' => 'FIRE'    ],
			'hype'    => [ 'icon' => 'fa-bolt',            'label' => 'HYPE'    ],
			'intel'   => [ 'icon' => 'fa-brain',           'label' => 'INTEL'   ],
			'confused'=> [ 'icon' => 'fa-circle-question', 'label' => 'CORRUPT' ],
		];
		?>
		<div class="reaction-row" data-post-id="<?php echo absint( $post_id ); ?>">
			<span class="reaction-label"><?php esc_html_e( 'SIGNAL_BOOST //', 'cyberfunk' ); ?></span>
			<?php foreach ( $types as $key => $type ) : ?>
				<button
					type="button"
					class="reaction-btn"
					data-reaction="<?php echo esc_attr( $key ); ?>"
					aria-label="<?php echo esc_attr( $type['label'] ); ?>"
				>
					<i class="fa-solid <?php echo esc_attr( $type['icon'] ); ?>" aria-hidden="true"></i>
					<span class="reaction-name"><?php echo esc_html( $type['label'] ); ?></span>
					<span class="reaction-count"><?php echo absint( $reactions[ $key ] ); ?></span>
				</button>
			<?php endforeach; ?>
		</div>
		<?php
	}
endif;

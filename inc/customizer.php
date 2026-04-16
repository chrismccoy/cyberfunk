<?php
/**
 * Theme Customizer settings and controls.
 *
 * @package Cyberfunk
 */

/**
 * Registers Customizer settings, sections, and controls.
 */
function cyberfunk_customize_register( $wp_customize ) {

	// Section: Visual Style
	$wp_customize->add_section(
		'cyberfunk_visual_style',
		[
			'title'       => esc_html__( 'Visual Style', 'cyberfunk' ),
			'description' => esc_html__( 'Choose the overall visual style for the theme. Changes are applied site-wide instantly — no rebuild required.', 'cyberfunk' ),
			'priority'    => 25,
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_visual_style',
		[
			'default'           => 'cyberpunk',
			'sanitize_callback' => 'cyberfunk_sanitize_visual_style',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_visual_style',
		[
			'label'   => esc_html__( 'Theme Style', 'cyberfunk' ),
			'section' => 'cyberfunk_visual_style',
			'type'    => 'select',
			'choices' => [
				'cyberpunk'  => esc_html__( 'Cyberpunk (default)', 'cyberfunk' ),
				'scifi-hud'  => esc_html__( 'Sci-Fi HUD', 'cyberfunk' ),
			],
		]
	);

	// Section: Social Links
	$wp_customize->add_section(
		'cyberfunk_social',
		[
			'title'       => esc_html__( 'Social Links', 'cyberfunk' ),
			'description' => esc_html__( 'Social media URLs displayed in the site footer.', 'cyberfunk' ),
			'priority'    => 120,
		]
	);

	$social_fields = [
		'twitter'  => esc_html__( 'X / Twitter URL', 'cyberfunk' ),
		'mastodon' => esc_html__( 'Mastodon URL', 'cyberfunk' ),
		'telegram' => esc_html__( 'Telegram URL', 'cyberfunk' ),
		'rss'      => esc_html__( 'RSS Feed URL (leave blank for default feed)', 'cyberfunk' ),
	];

	foreach ( $social_fields as $key => $label ) {
		$setting_id = 'cyberfunk_social_' . $key;

		$wp_customize->add_setting(
			$setting_id,
			[
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			]
		);

		$wp_customize->add_control(
			$setting_id,
			[
				'label'   => $label,
				'section' => 'cyberfunk_social',
				'type'    => 'url',
			]
		);
	}

	// Section: Announcement Bar
	$wp_customize->add_section(
		'cyberfunk_announce',
		[
			'title'       => esc_html__( 'Announcement Bar', 'cyberfunk' ),
			'description' => esc_html__( 'Optional dismissible banner displayed above the navigation. Cleared on browser session end.', 'cyberfunk' ),
			'priority'    => 105,
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_announce_enabled',
		[
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_announce_enabled',
		[
			'label'   => esc_html__( 'Enable Announcement Bar', 'cyberfunk' ),
			'section' => 'cyberfunk_announce',
			'type'    => 'checkbox',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_announce_text',
		[
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_announce_text',
		[
			'label'       => esc_html__( 'Announcement Message', 'cyberfunk' ),
			'description' => esc_html__( 'HTML links are allowed.', 'cyberfunk' ),
			'section'     => 'cyberfunk_announce',
			'type'        => 'textarea',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_announce_type',
		[
			'default'           => 'info',
			'sanitize_callback' => function ( $v ) {
				return in_array( $v, [ 'info', 'warning', 'alert' ], true ) ? $v : 'info';
			},
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_announce_type',
		[
			'label'   => esc_html__( 'Bar Style', 'cyberfunk' ),
			'section' => 'cyberfunk_announce',
			'type'    => 'select',
			'choices' => [
				'info'    => esc_html__( 'Info (cyan)', 'cyberfunk' ),
				'warning' => esc_html__( 'Warning (yellow)', 'cyberfunk' ),
				'alert'   => esc_html__( 'Alert (red)', 'cyberfunk' ),
			],
		]
	);

	// Section: Display Effects
	$wp_customize->add_section(
		'cyberfunk_effects',
		[
			'title'       => esc_html__( 'Display Effects', 'cyberfunk' ),
			'description' => esc_html__( 'Visual overlay effects. Disable if they cause distraction or motion sensitivity issues.', 'cyberfunk' ),
			'priority'    => 115,
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_scanline',
		[
			'default'           => true,
			'sanitize_callback' => 'rest_sanitize_boolean',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_scanline',
		[
			'label'       => esc_html__( 'Show CRT Scan-Line Effect', 'cyberfunk' ),
			'description' => esc_html__( 'Animated horizontal line that scrolls over the page. Disable for reduced motion or a cleaner look.', 'cyberfunk' ),
			'section'     => 'cyberfunk_effects',
			'type'        => 'checkbox',
		]
	);

	// Section: Status Strip
	$wp_customize->add_section(
		'cyberfunk_status_strip',
		[
			'title'       => esc_html__( 'Status Strip', 'cyberfunk' ),
			'description' => esc_html__( 'The thin bar below the navigation. Shown on every page.', 'cyberfunk' ),
			'priority'    => 110,
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_status_label',
		[
			'default'           => 'SYS::ONLINE',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_status_label',
		[
			'label'       => esc_html__( 'Status Label', 'cyberfunk' ),
			'description' => esc_html__( 'Left-most text, e.g. SYS::ONLINE or NET::ACTIVE', 'cyberfunk' ),
			'section'     => 'cyberfunk_status_strip',
			'type'        => 'text',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_status_tagline',
		[
			'default'           => 'SIGNAL THROUGH THE STATIC',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_status_tagline',
		[
			'label'       => esc_html__( 'Tagline', 'cyberfunk' ),
			'description' => esc_html__( 'Middle text, e.g. SIGNAL THROUGH THE STATIC', 'cyberfunk' ),
			'section'     => 'cyberfunk_status_strip',
			'type'        => 'text',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_index_heading',
		[
			'default'           => 'INCOMING_TRANSMISSIONS',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_index_heading',
		[
			'label'       => esc_html__( 'Index Page Heading', 'cyberfunk' ),
			'description' => esc_html__( 'Heading above the post list on the front page, e.g. INCOMING_TRANSMISSIONS', 'cyberfunk' ),
			'section'     => 'cyberfunk_status_strip',
			'type'        => 'text',
		]
	);

	// Section: Footer
	$wp_customize->add_section(
		'cyberfunk_footer',
		[
			'title'    => esc_html__( 'Footer', 'cyberfunk' ),
			'priority' => 130,
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_footer_brand',
		[
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_footer_brand',
		[
			'label'       => esc_html__( 'Brand Label', 'cyberfunk' ),
			'description' => esc_html__( 'Text shown inside brackets, e.g. CYBERFUNK. Leave blank to use the site name.', 'cyberfunk' ),
			'section'     => 'cyberfunk_footer',
			'type'        => 'text',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_footer_blurb',
		[
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_footer_blurb',
		[
			'label'       => esc_html__( 'Brand Blurb', 'cyberfunk' ),
			'description' => esc_html__( 'Paragraph below the brand label. Leave blank to use the site tagline.', 'cyberfunk' ),
			'section'     => 'cyberfunk_footer',
			'type'        => 'textarea',
		]
	);

	$wp_customize->add_setting(
		'cyberfunk_footer_copyright',
		[
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		]
	);

	$wp_customize->add_control(
		'cyberfunk_footer_copyright',
		[
			'label'       => esc_html__( 'Copyright Text', 'cyberfunk' ),
			'description' => esc_html__( 'Leave blank to use site name + current year automatically.', 'cyberfunk' ),
			'section'     => 'cyberfunk_footer',
			'type'        => 'text',
		]
	);
}

/**
 * Returns a social link URL from Customizer settings.
 */
function cyberfunk_get_social_url( $network ) {
	$value = get_theme_mod( 'cyberfunk_social_' . sanitize_key( $network ), '' );

	if ( 'rss' === $network && '' === $value ) {
		return esc_url( get_feed_link() );
	}

	return $value ? esc_url( $value ) : '';
}

/**
 * Sanitizes the visual style setting — only allows known style slugs.
 */
function cyberfunk_sanitize_visual_style( $value ) {
	$allowed = [ 'cyberpunk', 'scifi-hud' ];
	return in_array( $value, $allowed, true ) ? $value : 'cyberpunk';
}

/**
 * Returns the footer copyright string.
 */
function cyberfunk_footer_copyright() {
	$custom = get_theme_mod( 'cyberfunk_footer_copyright', '' );

	if ( $custom ) {
		return esc_html( $custom );
	}

	return sprintf(
		esc_html__( '&copy; %1$s %2$s &nbsp;&middot;&nbsp; ALL RIGHTS RESERVED', 'cyberfunk' ),
		esc_html( gmdate( 'Y' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}

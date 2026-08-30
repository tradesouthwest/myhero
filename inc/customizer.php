<?php 
/**
 * Register Hero Section Customizer Controls
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function myhero_hero_customizer( $wp_customize ) {

	// 1. Add Hero Section Panel/Section
	$wp_customize->add_section(
		'hero_section',
		array(
			'title'       => __( 'Hero Section', 'hello-theme' ),
			'priority'    => 30,
			'description' => __( 'Customize the front page hero layout.', 'hello-theme' ),
		)
	);

	// 2. Title Control
	$wp_customize->add_setting(
		'hero_title',
		array(
			'default'           => get_bloginfo( 'name' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hero_title',
		array(
			'label'    => __( 'Hero Title', 'hello-theme' ),
			'section'  => 'hero_section',
			'type'     => 'text',
		)
	);

	// 3. Subtitle Control
	$wp_customize->add_setting(
		'hero_subtitle',
		array(
			'default'           => get_bloginfo( 'description' ),
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hero_subtitle',
		array(
			'label'    => __( 'Hero Subtitle', 'hello-theme' ),
			'section'  => 'hero_section',
			'type'     => 'textarea',
		)
	);

	// 4. Primary Button Text
	$wp_customize->add_setting(
		'hero_btn_primary_text',
		array(
			'default'           => __( 'Get Started', 'hello-theme' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_btn_primary_text',
		array(
			'label'   => __( 'Primary Button Text', 'hello-theme' ),
			'section' => 'hero_section',
			'type'    => 'text',
		)
	);

	// 5. Primary Button URL
	$wp_customize->add_setting(
		'hero_btn_primary_url',
		array(
			'default'           => '#primary-cta',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'hero_btn_primary_url',
		array(
			'label'   => __( 'Primary Button URL', 'hello-theme' ),
			'section' => 'hero_section',
			'type'    => 'url',
		)
	);

	// 6. Secondary Button Text
	$wp_customize->add_setting(
		'hero_btn_secondary_text',
		array(
			'default'           => __( 'Learn More', 'hello-theme' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_btn_secondary_text',
		array(
			'label'   => __( 'Secondary Button Text', 'hello-theme' ),
			'section' => 'hero_section',
			'type'    => 'text',
		)
	);

	// 7. Secondary Button URL
	$wp_customize->add_setting(
		'hero_btn_secondary_url',
		array(
			'default'           => '#secondary-cta',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'hero_btn_secondary_url',
		array(
			'label'   => __( 'Secondary Button URL', 'hello-theme' ),
			'section' => 'hero_section',
			'type'    => 'url',
		)
	);
	// 8. Background Type Selector
$wp_customize->add_setting(
	'hero_bg_type',
	array(
		'default'           => 'none',
		'sanitize_callback' => 'myhero_sanitize_bg_type',
	)
);
$wp_customize->add_control(
	'hero_bg_type',
	array(
		'label'   => __( 'Background Media Type', 'hello-theme' ),
		'section' => 'hero_section',
		'type'    => 'select',
		'choices' => array(
			'none'  => __( 'None (Color Only)', 'hello-theme' ),
			'image' => __( 'Image', 'hello-theme' ),
			'video' => __( 'Video (MP4)', 'hello-theme' ),
		),
	)
);

// 9. Background Image Upload
$wp_customize->add_setting(
	'hero_bg_image',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'hero_bg_image',
		array(
			'label'    => __( 'Hero Background Image', 'hello-theme' ),
			'section'  => 'hero_section',
			'settings' => 'hero_bg_image',
		)
	)
);

// 10. Background Video URL
$wp_customize->add_setting(
	'hero_bg_video',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control(
	'hero_bg_video',
	array(
		'label'       => __( 'Hero Background Video URL (.mp4)', 'hello-theme' ),
		'description' => __( 'Direct link to an MP4 video file.', 'hello-theme' ),
		'section'     => 'hero_section',
		'type'        => 'url',
	)
);

}
add_action( 'customize_register', 'myhero_hero_customizer' );


// Sanitization Callback for Select Control
function myhero_sanitize_bg_type( $input ) {
	$valid = array( 'none', 'image', 'video' );
	return in_array( $input, $valid, true ) ? $input : 'none';
}
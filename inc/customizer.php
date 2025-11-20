<?php
/**
 * Theme Customizer additions.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'aurora_borealis_customize_register' ) ) :
function aurora_borealis_customize_register( $wp_customize ) {
    /**
     * 1. Accent colors exposed via the default Colors section.
     */
    $wp_customize->add_setting( 'aurora_accent_color', array(
        'default'           => '#6be7a7',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aurora_accent_color_control', array(
        'label'    => __( 'Accent color', 'aurora-borealis' ),
        'section'  => 'colors',
        'settings' => 'aurora_accent_color',
    ) ) );

    $wp_customize->add_setting( 'aurora_accent_color_2', array(
        'default'           => '#79f0ff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aurora_accent_color_2_control', array(
        'label'    => __( 'Accent color (secondary)', 'aurora-borealis' ),
        'section'  => 'colors',
        'settings' => 'aurora_accent_color_2',
    ) ) );

    /**
     * 2. Theme palette (backgrounds, panels, etc.).
     */
    $wp_customize->add_section( 'aurora_palette_section', array(
        'title'    => __( 'Theme Palette', 'aurora-borealis' ),
        'priority' => 120,
    ) );

    $palette_controls = array(
        'aurora_primary_color'   => __( 'Primary', 'aurora-borealis' ),
        'aurora_secondary_color' => __( 'Secondary', 'aurora-borealis' ),
        'aurora_bg_color'        => __( 'Background', 'aurora-borealis' ),
        'aurora_bg_color_2'      => __( 'Background (stop 2)', 'aurora-borealis' ),
        'aurora_panel_color'     => __( 'Panel', 'aurora-borealis' ),
        'aurora_text_color'      => __( 'Text', 'aurora-borealis' ),
        'aurora_muted_color'     => __( 'Muted text', 'aurora-borealis' ),
        'aurora_link_color'      => __( 'Link', 'aurora-borealis' ),
        'aurora_button_color'    => __( 'Button background', 'aurora-borealis' ),
    );

    $palette_defaults = array(
        'aurora_primary_color'   => '#6be7a7',
        'aurora_secondary_color' => '#79f0ff',
        'aurora_bg_color'        => '#071a2b',
        'aurora_bg_color_2'      => '#0b2a3f',
        'aurora_panel_color'     => 'rgba(8,14,20,0.82)',
        'aurora_text_color'      => '#e8f1f5',
        'aurora_muted_color'     => 'rgba(255,255,255,0.72)',
        'aurora_link_color'      => '#0b7bbf',
        'aurora_button_color'    => '#6be7a7',
    );

    foreach ( $palette_controls as $setting_id => $label ) {
        $sanitize = ( 'aurora_panel_color' === $setting_id ) ? 'aurora_sanitize_color' : 'sanitize_hex_color';
        $wp_customize->add_setting( $setting_id, array(
            'default'           => isset( $palette_defaults[ $setting_id ] ) ? $palette_defaults[ $setting_id ] : '#79f0ff',
            'sanitize_callback' => $sanitize,
            'transport'         => 'postMessage',
        ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id . '_control', array(
            'label'    => $label,
            'section'  => 'aurora_palette_section',
            'settings' => $setting_id,
        ) ) );
    }

    /**
     * 3. Typography controls.
     */
    $wp_customize->add_section( 'aurora_typography_section', array(
        'title'    => __( 'Typography', 'aurora-borealis' ),
        'priority' => 122,
    ) );

    $font_choices = array(
        'system-ui'  => 'System UI',
        'Montserrat' => 'Montserrat',
        'Open Sans'  => 'Open Sans',
        'Roboto'     => 'Roboto',
        'Lora'       => 'Lora',
        'Georgia'    => 'Georgia',
    );

    $wp_customize->add_setting( 'aurora_body_font', array(
        'default'           => 'Open Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_body_font_control', array(
        'label'    => __( 'Body font', 'aurora-borealis' ),
        'section'  => 'aurora_typography_section',
        'settings' => 'aurora_body_font',
        'type'     => 'select',
        'choices'  => $font_choices,
    ) );

    $wp_customize->add_setting( 'aurora_heading_font', array(
        'default'           => 'Montserrat',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_heading_font_control', array(
        'label'    => __( 'Heading font', 'aurora-borealis' ),
        'section'  => 'aurora_typography_section',
        'settings' => 'aurora_heading_font',
        'type'     => 'select',
        'choices'  => $font_choices,
    ) );

    /**
     * 4. Layout sizing.
     */
    $wp_customize->add_section( 'aurora_layout_section', array(
        'title'    => __( 'Layout', 'aurora-borealis' ),
        'priority' => 128,
    ) );

    $wp_customize->add_setting( 'aurora_site_max_width', array(
        'default'           => 1200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_site_max_width_control', array(
        'label'       => __( 'Site max width (px)', 'aurora-borealis' ),
        'section'     => 'aurora_layout_section',
        'settings'    => 'aurora_site_max_width',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 960, 'max' => 1600 ),
    ) );

    /**
     * 5. Header + logo controls.
     */
    $wp_customize->add_section( 'aurora_header_section', array(
        'title'    => __( 'Header', 'aurora-borealis' ),
        'priority' => 130,
    ) );

    $wp_customize->add_setting( 'aurora_header_opacity', array(
        'default'           => 0.55,
        'sanitize_callback' => 'aurora_sanitize_opacity',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_header_opacity_control', array(
        'label'       => __( 'Header background opacity', 'aurora-borealis' ),
        'section'     => 'aurora_header_section',
        'settings'    => 'aurora_header_opacity',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 0, 'max' => 1, 'step' => 0.05 ),
    ) );

    $wp_customize->add_setting( 'aurora_logo_max_width', array(
        'default'           => 200,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_logo_max_width_control', array(
        'label'       => __( 'Logo max width (px)', 'aurora-borealis' ),
        'section'     => 'aurora_header_section',
        'settings'    => 'aurora_logo_max_width',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 64, 'max' => 800 ),
    ) );

    $wp_customize->add_setting( 'aurora_logo_fit_mode', array(
        'default'           => 'height',
        'sanitize_callback' => 'aurora_sanitize_logo_fit_mode',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_logo_fit_mode_control', array(
        'label'    => __( 'Logo fit mode', 'aurora-borealis' ),
        'section'  => 'aurora_header_section',
        'settings' => 'aurora_logo_fit_mode',
        'type'     => 'radio',
        'choices'  => array(
            'height' => __( 'Fit by height (keep within header)', 'aurora-borealis' ),
            'width'  => __( 'Fit by width (respect max width)', 'aurora-borealis' ),
        ),
    ) );

    $wp_customize->add_setting( 'aurora_base_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_base_font_size_control', array(
        'label'       => __( 'Base font size (px)', 'aurora-borealis' ),
        'section'     => 'aurora_header_section',
        'settings'    => 'aurora_base_font_size',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 22 ),
    ) );

    $wp_customize->add_setting( 'aurora_heading_scale', array(
        'default'           => 1.8,
        'sanitize_callback' => 'floatval',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_heading_scale_control', array(
        'label'       => __( 'Heading scale (multiplier)', 'aurora-borealis' ),
        'section'     => 'aurora_header_section',
        'settings'    => 'aurora_heading_scale',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 1.1, 'max' => 2.4, 'step' => 0.05 ),
    ) );

    /**
     * 6. Hero settings.
     */
    $wp_customize->add_section( 'aurora_hero_section', array(
        'title'    => __( 'Hero', 'aurora-borealis' ),
        'priority' => 140,
    ) );

    $wp_customize->add_setting( 'aurora_hero_enable', array(
        'default'           => true,
        'sanitize_callback' => 'aurora_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_hero_enable_control', array(
        'label'    => __( 'Show hero on front page', 'aurora-borealis' ),
        'section'  => 'aurora_hero_section',
        'settings' => 'aurora_hero_enable',
        'type'     => 'checkbox',
    ) );

    $wp_customize->add_setting( 'aurora_hero_min_height', array(
        'default'           => 360,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_hero_min_height_control', array(
        'label'       => __( 'Hero minimum height (px)', 'aurora-borealis' ),
        'section'     => 'aurora_hero_section',
        'settings'    => 'aurora_hero_min_height',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 200, 'max' => 1200 ),
    ) );

    /**
     * 7. Navigation & menu controls.
     */
    $wp_customize->add_section( 'aurora_menu_section', array(
        'title'    => __( 'Menus', 'aurora-borealis' ),
        'priority' => 150,
    ) );

    $wp_customize->add_setting( 'aurora_menu_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aurora_menu_text_color_control', array(
        'label'    => __( 'Menu text color', 'aurora-borealis' ),
        'section'  => 'aurora_menu_section',
        'settings' => 'aurora_menu_text_color',
    ) ) );

    $wp_customize->add_setting( 'aurora_menu_hover_color', array(
        'default'           => '#6be7a7',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'aurora_menu_hover_color_control', array(
        'label'    => __( 'Menu hover color', 'aurora-borealis' ),
        'section'  => 'aurora_menu_section',
        'settings' => 'aurora_menu_hover_color',
    ) ) );

    $wp_customize->add_setting( 'aurora_menu_bg_color', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_menu_bg_color_control', array(
        'label'    => __( 'Menu background (CSS color or transparent)', 'aurora-borealis' ),
        'section'  => 'aurora_menu_section',
        'settings' => 'aurora_menu_bg_color',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'aurora_menu_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_menu_font_size_control', array(
        'label'       => __( 'Menu font size (px)', 'aurora-borealis' ),
        'section'     => 'aurora_menu_section',
        'settings'    => 'aurora_menu_font_size',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 12, 'max' => 24 ),
    ) );

    $wp_customize->add_setting( 'aurora_mobile_menu_align', array(
        'default'           => 'right',
        'sanitize_callback' => function ( $value ) {
            return in_array( $value, array( 'left', 'center', 'right' ), true ) ? $value : 'right';
        },
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_mobile_menu_align_control', array(
        'label'    => __( 'Mobile menu alignment', 'aurora-borealis' ),
        'section'  => 'aurora_menu_section',
        'settings' => 'aurora_mobile_menu_align',
        'type'     => 'radio',
        'choices'  => array(
            'left'   => __( 'Left', 'aurora-borealis' ),
            'center' => __( 'Center', 'aurora-borealis' ),
            'right'  => __( 'Right', 'aurora-borealis' ),
        ),
    ) );

    $wp_customize->add_setting( 'aurora_mobile_full_bleed', array(
        'default'           => true,
        'sanitize_callback' => 'aurora_sanitize_checkbox',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_mobile_full_bleed_control', array(
        'label'    => __( 'Mobile menu full-bleed', 'aurora-borealis' ),
        'section'  => 'aurora_menu_section',
        'settings' => 'aurora_mobile_full_bleed',
        'type'     => 'checkbox',
    ) );

    $wp_customize->add_setting( 'aurora_mobile_breakpoint', array(
        'default'           => 780,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_mobile_breakpoint_control', array(
        'label'       => __( 'Mobile menu breakpoint (px)', 'aurora-borealis' ),
        'section'     => 'aurora_menu_section',
        'settings'    => 'aurora_mobile_breakpoint',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 480, 'max' => 1200 ),
    ) );

    /**
     * 8. Homepage content strings.
     */
    $wp_customize->add_section( 'aurora_homepage_content', array(
        'title'    => __( 'Homepage Content', 'aurora-borealis' ),
        'priority' => 160,
    ) );

    $homepage_text = array(
        'aurora_hero_eyebrow'     => array( __( 'Hero eyebrow', 'aurora-borealis' ), 'sanitize_text_field', __( 'NORTHERN LIGHTS.', 'aurora-borealis' ) ),
        'aurora_hero_title'       => array( __( 'Hero title', 'aurora-borealis' ), 'sanitize_text_field', __( 'Lorem ipsum dolor sit amet', 'aurora-borealis' ) ),
        'aurora_latest_heading'   => array( __( 'Latest articles heading', 'aurora-borealis' ), 'sanitize_text_field', __( 'Latest Articles', 'aurora-borealis' ) ),
        'aurora_cta_title'        => array( __( 'CTA title', 'aurora-borealis' ), 'sanitize_text_field', __( 'Lorem ipsum dolor sit amet', 'aurora-borealis' ) ),
        'aurora_concept_eyebrow'  => array( __( 'Concept eyebrow', 'aurora-borealis' ), 'sanitize_text_field', __( 'Lorem ipsum', 'aurora-borealis' ) ),
        'aurora_concept_title'    => array( __( 'Concept title', 'aurora-borealis' ), 'sanitize_text_field', __( 'Dolor sit amet, consectetur', 'aurora-borealis' ) ),
        'aurora_concept_caption'  => array( __( 'Concept caption', 'aurora-borealis' ), 'sanitize_text_field', __( 'Lorem ipsum dolor sit amet.', 'aurora-borealis' ) ),
        'aurora_cta_button_text'  => array( __( 'CTA button text', 'aurora-borealis' ), 'sanitize_text_field', __( 'Learn more', 'aurora-borealis' ) ),
        'aurora_hero_button_text' => array( __( 'Hero button text', 'aurora-borealis' ), 'sanitize_text_field', __( 'Learn more', 'aurora-borealis' ) ),
    );

    foreach ( $homepage_text as $setting_id => $args ) {
        $wp_customize->add_setting( $setting_id, array(
            'default'           => $args[2],
            'sanitize_callback' => $args[1],
        ) );
        $wp_customize->add_control( $setting_id . '_control', array(
            'label'    => $args[0],
            'section'  => 'aurora_homepage_content',
            'settings' => $setting_id,
            'type'     => 'text',
        ) );
    }

    $homepage_paragraphs = array(
        'aurora_hero_subtitle'      => array( __( 'Hero description', 'aurora-borealis' ), __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'aurora-borealis' ) ),
        'aurora_feature_one_text'   => array( __( 'Feature one text', 'aurora-borealis' ), __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.', 'aurora-borealis' ) ),
        'aurora_feature_two_text'   => array( __( 'Feature two text', 'aurora-borealis' ), __( 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.', 'aurora-borealis' ) ),
        'aurora_feature_three_text' => array( __( 'Feature three text', 'aurora-borealis' ), __( 'Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.', 'aurora-borealis' ) ),
        'aurora_cta_text'           => array( __( 'CTA description', 'aurora-borealis' ), __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.', 'aurora-borealis' ) ),
        'aurora_concept_text'       => array( __( 'Concept description', 'aurora-borealis' ), __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.', 'aurora-borealis' ) ),
    );

    foreach ( $homepage_paragraphs as $setting_id => $args ) {
        $wp_customize->add_setting( $setting_id, array(
            'default'           => $args[1],
            'sanitize_callback' => 'wp_kses_post',
        ) );
        $wp_customize->add_control( $setting_id . '_control', array(
            'label'    => $args[0],
            'section'  => 'aurora_homepage_content',
            'settings' => $setting_id,
            'type'     => 'textarea',
        ) );
    }

    $homepage_feature_titles = array(
        'aurora_feature_one_title'   => array( __( 'Feature one title', 'aurora-borealis' ), __( 'Lorem ipsum', 'aurora-borealis' ) ),
        'aurora_feature_two_title'   => array( __( 'Feature two title', 'aurora-borealis' ), __( 'Dolor sit amet', 'aurora-borealis' ) ),
        'aurora_feature_three_title' => array( __( 'Feature three title', 'aurora-borealis' ), __( 'Consectetur', 'aurora-borealis' ) ),
    );

    foreach ( $homepage_feature_titles as $setting_id => $args ) {
        $wp_customize->add_setting( $setting_id, array(
            'default'           => $args[1],
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( $setting_id . '_control', array(
            'label'    => $args[0],
            'section'  => 'aurora_homepage_content',
            'settings' => $setting_id,
            'type'     => 'text',
        ) );
    }

    $wp_customize->add_setting( 'aurora_hero_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'aurora_hero_button_url_control', array(
        'label'    => __( 'Hero button URL', 'aurora-borealis' ),
        'section'  => 'aurora_homepage_content',
        'settings' => 'aurora_hero_button_url',
        'type'     => 'url',
    ) );

    $wp_customize->add_setting( 'aurora_cta_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'aurora_cta_button_url_control', array(
        'label'    => __( 'CTA button URL', 'aurora-borealis' ),
        'section'  => 'aurora_homepage_content',
        'settings' => 'aurora_cta_button_url',
        'type'     => 'url',
    ) );

    /**
     * 9. Footer text.
     */
    $wp_customize->add_section( 'aurora_footer_section', array(
        'title'    => __( 'Footer', 'aurora-borealis' ),
        'priority' => 190,
    ) );

    $wp_customize->add_setting( 'aurora_footer_text', array(
        'default'           => esc_html__( '© Your Site Name', 'aurora-borealis' ),
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'aurora_footer_text_control', array(
        'label'    => __( 'Footer text', 'aurora-borealis' ),
        'section'  => 'aurora_footer_section',
        'settings' => 'aurora_footer_text',
        'type'     => 'text',
    ) );

    /**
     * Selective refresh for footer text.
     */
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'aurora_footer_text', array(
            'selector'        => '.site-footer-text',
            'render_callback' => function () {
                echo wp_kses_post( get_theme_mod( 'aurora_footer_text' ) );
            },
        ) );
    }
}
add_action( 'customize_register', 'aurora_borealis_customize_register' );
endif;

if ( ! function_exists( 'aurora_sanitize_checkbox' ) ) :
function aurora_sanitize_checkbox( $checked ) {
    return ( isset( $checked ) && true === $checked );
}
endif;

if ( ! function_exists( 'aurora_sanitize_opacity' ) ) :
function aurora_sanitize_opacity( $value ) {
    $value = is_numeric( $value ) ? floatval( $value ) : 0;
    return min( 1, max( 0, $value ) );
}
endif;

if ( ! function_exists( 'aurora_sanitize_logo_fit_mode' ) ) :
function aurora_sanitize_logo_fit_mode( $value ) {
    return in_array( $value, array( 'height', 'width' ), true ) ? $value : 'height';
}
endif;

if ( ! function_exists( 'aurora_sanitize_color' ) ) :
function aurora_sanitize_color( $color ) {
    $color = trim( (string) $color );

    if ( '' === $color ) {
        return '';
    }

    if ( 0 === strpos( $color, 'rgba' ) ) {
        if ( preg_match( '/^rgba\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3}),\s*(0|0?\.\d+|1)\)$/', $color ) ) {
            return $color;
        }
        return 'rgba(0,0,0,0.5)';
    }

    return sanitize_hex_color( $color );
}
endif;

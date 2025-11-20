<?php
// Aurora Borealis theme functions
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'AURORA_BOREALIS_VERSION' ) ) {
    define( 'AURORA_BOREALIS_VERSION', '1.0.1' );
}

if ( ! defined( 'AURORA_BOREALIS_DIR' ) ) {
    define( 'AURORA_BOREALIS_DIR', trailingslashit( get_stylesheet_directory() ) );
}

if ( ! defined( 'AURORA_BOREALIS_URI' ) ) {
    define( 'AURORA_BOREALIS_URI', trailingslashit( get_stylesheet_directory_uri() ) );
}

if ( ! function_exists( 'aurora_borealis_setup' ) ) {
function aurora_borealis_setup() {
    load_theme_textdomain( 'aurora-borealis', AURORA_BOREALIS_DIR . 'languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    // Enable editor styles so the block editor matches the front-end
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
    add_theme_support( 'customize-selective-refresh-widgets' );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'aurora-borealis' ),
        'social'  => __( 'Social Links Menu', 'aurora-borealis' ),
    ) );
}
add_action( 'after_setup_theme', 'aurora_borealis_setup' );
}

/**
 * Enqueue styles and scripts with cache-busting using filemtime().
 */
if ( ! function_exists( 'aurora_borealis_enqueue_assets' ) ) {
function aurora_borealis_enqueue_assets() {
    // Google Fonts: build URL from Customizer-selected fonts (minimal set)
    $font_map = array(
        'Montserrat' => 'Montserrat:wght@400;600;700',
        'Open Sans'  => 'Open+Sans:wght@300;400;600',
        'Roboto'     => 'Roboto:wght@400;700',
        'Lora'       => 'Lora:wght@400;700',
    );
    $fonts_to_load = array();
    $body_font = get_theme_mod( 'aurora_body_font', 'Open Sans' );
    $heading_font = get_theme_mod( 'aurora_heading_font', 'Montserrat' );
    if ( isset( $font_map[ $body_font ] ) ) {
        $fonts_to_load[] = $font_map[ $body_font ];
    }
    if ( isset( $font_map[ $heading_font ] ) && $heading_font !== $body_font ) {
        $fonts_to_load[] = $font_map[ $heading_font ];
    }
    if ( ! empty( $fonts_to_load ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $fonts_to_load ) . '&display=swap';
        wp_enqueue_style( 'aurora-borealis-fonts', esc_url_raw( $fonts_url ), array(), null );
    }

    $style_file = AURORA_BOREALIS_DIR . 'style.css';
    $style_ver  = file_exists( $style_file ) ? filemtime( $style_file ) : AURORA_BOREALIS_VERSION;
    wp_enqueue_style( 'aurora-borealis-style', get_stylesheet_uri(), array( 'aurora-borealis-fonts' ), $style_ver );

    // Theme navigation script
    $nav_file = AURORA_BOREALIS_DIR . 'assets/js/navigation.js';
    $nav_ver  = file_exists( $nav_file ) ? filemtime( $nav_file ) : AURORA_BOREALIS_VERSION;
    wp_enqueue_script( 'aurora-borealis-nav', AURORA_BOREALIS_URI . 'assets/js/navigation.js', array(), $nav_ver, true );

    // Provide accent color to JS if needed
    wp_localize_script( 'aurora-borealis-nav', 'AuroraTheme', array(
        'accent' => get_theme_mod( 'aurora_accent_color', '#6be7a7' ),
    ) );

    // Small helper to fit logos into the header (limits by header height and logo max width)
    $logo_file = AURORA_BOREALIS_DIR . 'assets/js/logo-fit.js';
    $logo_ver  = file_exists( $logo_file ) ? filemtime( $logo_file ) : AURORA_BOREALIS_VERSION;
    wp_enqueue_script( 'aurora-borealis-logo-fit', AURORA_BOREALIS_URI . 'assets/js/logo-fit.js', array(), $logo_ver, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'aurora_borealis_enqueue_assets' );
}

/**
 * Include helper files (if present).
 */
if ( file_exists( AURORA_BOREALIS_DIR . 'inc/customizer.php' ) ) {
    require_once AURORA_BOREALIS_DIR . 'inc/customizer.php';
}

if ( file_exists( AURORA_BOREALIS_DIR . 'inc/block-patterns.php' ) ) {
    require_once AURORA_BOREALIS_DIR . 'inc/block-patterns.php';
}

// Patterns in the `patterns/` folder are auto-discovered by WordPress when
// they contain the header metadata (Title/Slug/Categories). Do not `require`
// those files here — keep them as header + block markup so WP can register
// them automatically.

/**
 * Output dynamic CSS from Customizer values (very small critical CSS snippet).
 */
if ( ! function_exists( 'aurora_borealis_customizer_css' ) ) {
function aurora_borealis_customizer_css() {
    // Prefer explicit accent settings, fall back to the theme palette primary/secondary.
    $accent = get_theme_mod( 'aurora_accent_color', get_theme_mod( 'aurora_primary_color', '#6be7a7' ) );
    $accent2 = get_theme_mod( 'aurora_accent_color_2', get_theme_mod( 'aurora_secondary_color', '#79f0ff' ) );
        $header_opacity = get_theme_mod( 'aurora_header_opacity', 0.55 );
        $header_opacity2 = max( 0, $header_opacity - 0.2 );
        $hero_min = intval( get_theme_mod( 'aurora_hero_min_height', 360 ) );
        $logo_max = intval( get_theme_mod( 'aurora_logo_max_width', 200 ) );
        $base_font = intval( get_theme_mod( 'aurora_base_font_size', 16 ) );
        $h_scale = floatval( get_theme_mod( 'aurora_heading_scale', 1.8 ) );
        $site_max_w = intval( get_theme_mod( 'aurora_site_max_width', 1200 ) );
            $menu_text = get_theme_mod( 'aurora_menu_text_color', '#ffffff' );
            $menu_hover = get_theme_mod( 'aurora_menu_hover_color', '#6be7a7' );
            $menu_bg = get_theme_mod( 'aurora_menu_bg_color', 'transparent' );
            $menu_font = intval( get_theme_mod( 'aurora_menu_font_size', 16 ) );
            $mobile_align = get_theme_mod( 'aurora_mobile_menu_align', 'right' );
            $mobile_full = get_theme_mod( 'aurora_mobile_full_bleed', true ) ? '1' : '0';
            $mobile_bp = intval( get_theme_mod( 'aurora_mobile_breakpoint', 780 ) );
            // Palette
            $primary = get_theme_mod( 'aurora_primary_color', $accent );
            $secondary = get_theme_mod( 'aurora_secondary_color', $accent2 );
            $bg = get_theme_mod( 'aurora_bg_color', '#071a2b' );
            // Use requested lighter panel and darker text defaults
            // Dark semi-transparent panel default to match design
            $panel = get_theme_mod( 'aurora_panel_color', 'rgba(8,14,20,0.82)' );
            $text_color = get_theme_mod( 'aurora_text_color', '#222222' );
            $muted = get_theme_mod( 'aurora_muted_color', '#555555' );
            $link = get_theme_mod( 'aurora_link_color', '#0b7bbf' );
            $button = get_theme_mod( 'aurora_button_color', $primary );
            // Typography stacks
            $body_font_choice = get_theme_mod( 'aurora_body_font', 'Open Sans' );
            $heading_font_choice = get_theme_mod( 'aurora_heading_font', 'Montserrat' );
            $font_stacks = array(
                'system-ui' => "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif",
                'Montserrat' => "Montserrat, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif",
                'Open Sans' => "'Open Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif",
                'Roboto' => "Roboto, system-ui, -apple-system, 'Segoe UI', 'Helvetica Neue', Arial, sans-serif",
                'Lora' => "Lora, Georgia, 'Times New Roman', Times, serif",
                'Georgia' => "Georgia, serif",
            );
            $body_font_stack = isset( $font_stacks[ $body_font_choice ] ) ? $font_stacks[ $body_font_choice ] : $font_stacks['system-ui'];
            $heading_font_stack = isset( $font_stacks[ $heading_font_choice ] ) ? $font_stacks[ $heading_font_choice ] : $font_stacks['Montserrat'];
        ?>
        <style id="aurora-dynamic-css" type="text/css">
        :root{ 
            --accent: <?php echo esc_attr( $accent ); ?>; 
            --accent-2: <?php echo esc_attr( $accent2 ); ?>; 
            --header-opacity: <?php echo esc_attr( $header_opacity ); ?>; 
            --header-opacity-2: <?php echo esc_attr( $header_opacity2 ); ?>; 
            --hero-min-height: <?php echo esc_attr( $hero_min ); ?>px; 
            --logo-max-width: <?php echo esc_attr( $logo_max ); ?>px;
            --base-font-size: <?php echo esc_attr( $base_font ); ?>px;
            --h1-scale: <?php echo esc_attr( $h_scale ); ?>;
            --site-max-width: <?php echo esc_attr( $site_max_w ); ?>px;
            --menu-text-color: <?php echo esc_attr( $menu_text ); ?>;
            --menu-hover-color: <?php echo esc_attr( $menu_hover ); ?>;
            --menu-bg-color: <?php echo esc_attr( $menu_bg ); ?>;
            --menu-font-size: <?php echo esc_attr( $menu_font ); ?>px;
            --mobile-menu-align: <?php echo esc_attr( $mobile_align ); ?>;
            --mobile-menu-full: <?php echo esc_attr( $mobile_full ); ?>;
            --mobile-breakpoint: <?php echo esc_attr( $mobile_bp ); ?>px;
            /* Theme palette variables */
            --primary: <?php echo esc_attr( $primary ); ?>;
            --secondary: <?php echo esc_attr( $secondary ); ?>;
            --bg-1: <?php echo esc_attr( $bg ); ?>;
            --bg-2: <?php echo esc_attr( get_theme_mod( 'aurora_bg_color_2', '#0b2a3f' ) ); ?>;
            --panel: <?php echo esc_attr( $panel ); ?>;
            --text: <?php echo esc_attr( $text_color ); ?>;
            --muted: <?php echo esc_attr( $muted ); ?>;
            --link-color: <?php echo esc_attr( $link ); ?>;
            --button-bg: <?php echo esc_attr( $button ); ?>;
            /* Typography stacks */
            --body-font: <?php echo esc_attr( $body_font_stack ); ?>;
            --heading-font: <?php echo esc_attr( $heading_font_stack ); ?>;
        }
        a:focus, a:focus-visible, button:focus, .mobile-toggle:focus{ outline: 3px solid var(--primary, <?php echo esc_attr( $accent ); ?>); outline-offset: 3px; }
        </style>
        <?php
}
add_action( 'wp_head', 'aurora_borealis_customizer_css', 11 );

/**
 * Add resource hints (preconnect) for Google Fonts to speed up font loading.
 */
if ( ! function_exists( 'aurora_resource_hints' ) ) {
function aurora_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => true,
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'aurora_resource_hints', 10, 2 );
}

/**
 * Preload main stylesheet to improve render performance (safe pattern with onload).
 */
if ( ! function_exists( 'aurora_preload_main_style' ) ) {
    function aurora_preload_main_style() {
        if ( is_admin() ) {
            return;
        }
        $style_file = AURORA_BOREALIS_DIR . 'style.css';
        $style_ver  = file_exists( $style_file ) ? filemtime( $style_file ) : AURORA_BOREALIS_VERSION;
        $href = esc_url( get_stylesheet_uri() . '?ver=' . $style_ver );
        echo "<link rel=\"preload\" as=\"style\" href=\"" . $href . "\" onload=\"this.rel='stylesheet'\">\n";
        echo "<noscript><link rel=\"stylesheet\" href=\"" . $href . "\"></noscript>\n";
    }
    add_action( 'wp_head', 'aurora_preload_main_style', 3 );
}

/**
 * Output minimal critical CSS for above-the-fold content.
 */
if ( ! function_exists( 'aurora_output_critical_css' ) ) {
function aurora_output_critical_css() {
    // Keep critical CSS very small to improve first paint.
    ?>
    <style id="aurora-critical-css">
    /* Basic background and header */
    html,body{background:linear-gradient(180deg,var(--bg-1,#071a2b) 0%,var(--bg-2,#0b2a3f) 50%,var(--bg-1,#071a2b) 100%);}
    .site-header{background:linear-gradient(180deg, rgba(2,8,12,var(--header-opacity,0.55)), rgba(2,8,12,var(--header-opacity-2,0.35)));backdrop-filter:blur(6px)}
    .container{background:var(--panel,rgba(8,14,20,0.82));padding:1.25rem;border-radius:12px}
    .hero{min-height:var(--hero-min-height,360px);padding-top:var(--header-height,72px)}
    a{color:var(--accent,#6be7a7)}
    .btn-outline{border-radius:28px}
    </style>
    <?php
}
add_action( 'wp_head', 'aurora_output_critical_css', 5 );
}

/**
 * Register widget areas (sidebars) for theme.
 */
if ( ! function_exists( 'aurora_borealis_widgets_init' ) ) {
function aurora_borealis_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'aurora-borealis' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar that appears on blog and archive pages.', 'aurora-borealis' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Area', 'aurora-borealis' ),
        'id'            => 'footer-1',
        'description'   => __( 'Widget area in the footer.', 'aurora-borealis' ),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Header Right', 'aurora-borealis' ),
        'id'            => 'header-1',
        'description'   => __( 'Optional widget area to the right of the header.', 'aurora-borealis' ),
        'before_widget' => '<div id="%1$s" class="header-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="screen-reader-text">',
        'after_title'   => '</span>',
    ) );
}
add_action( 'widgets_init', 'aurora_borealis_widgets_init' );
}

/**
 * Enqueue Customizer live preview script (postMessage transport handlers).
 */
if ( ! function_exists( 'aurora_borealis_customizer_preview' ) ) {
function aurora_borealis_customizer_preview() {
    $file = AURORA_BOREALIS_DIR . 'assets/js/customizer-preview.js';
    $ver  = file_exists( $file ) ? filemtime( $file ) : AURORA_BOREALIS_VERSION;
    wp_enqueue_script( 'aurora-borealis-customize-preview', AURORA_BOREALIS_URI . 'assets/js/customizer-preview.js', array( 'customize-preview', 'jquery' ), $ver, true );
}
add_action( 'customize_preview_init', 'aurora_borealis_customizer_preview' );
}

/**
 * Enqueue editor styles for block editor to better match front-end.
 */
if ( ! function_exists( 'aurora_borealis_enqueue_editor_assets' ) ) {
function aurora_borealis_enqueue_editor_assets() {
    $file = AURORA_BOREALIS_DIR . 'assets/css/editor-style.css';
    $ver  = file_exists( $file ) ? filemtime( $file ) : AURORA_BOREALIS_VERSION;
    wp_enqueue_style( 'aurora-borealis-editor-style', AURORA_BOREALIS_URI . 'assets/css/editor-style.css', array(), $ver );
}
add_action( 'enqueue_block_editor_assets', 'aurora_borealis_enqueue_editor_assets' );
}

/**
 * Register simple block styles for editor (button, group) to match theme.
 */
if ( ! function_exists( 'aurora_borealis_register_block_styles' ) ) {
function aurora_borealis_register_block_styles() {
    if ( function_exists( 'register_block_style' ) ) {
        // Button styles
        register_block_style( 'core/button', array(
            'name'  => 'aurora',
            'label' => __( 'Aurora', 'aurora-borealis' ),
        ) );
        register_block_style( 'core/button', array(
            'name'  => 'aurora-small',
            'label' => __( 'Aurora Small', 'aurora-borealis' ),
        ) );

        // Group / panel style
        register_block_style( 'core/group', array(
            'name'  => 'aurora-panel',
            'label' => __( 'Aurora Panel', 'aurora-borealis' ),
        ) );
    }
}
add_action( 'init', 'aurora_borealis_register_block_styles' );
}

/**
 * Add body class to reflect logo fit mode on front-end.
 */
if ( ! function_exists( 'aurora_logo_fit_body_class' ) ) {
function aurora_logo_fit_body_class( $classes ) {
    $mode = get_theme_mod( 'aurora_logo_fit_mode', 'height' );
    if ( 'width' === $mode ) {
        $classes[] = 'logo-fit-width';
    }
    if ( get_theme_mod( 'aurora_mobile_full_bleed', true ) ) {
        $classes[] = 'mobile-menu-full-bleed';
    }
    return $classes;
}
add_filter( 'body_class', 'aurora_logo_fit_body_class' );
}

/*
 * Contact form handler — processes submissions sent to admin-post.php?action=aurora_contact_submit
 */
if ( ! function_exists( 'aurora_handle_contact_form' ) ) {
function aurora_handle_contact_form() {
    // Verify nonce
    if ( empty( $_POST['aurora_contact_nonce_field'] ) || ! wp_verify_nonce( wp_unslash( $_POST['aurora_contact_nonce_field'] ), 'aurora_contact_nonce' ) ) {
        $redirect = wp_get_referer() ? add_query_arg( 'contact', 'error', wp_get_referer() ) : home_url();
        wp_safe_redirect( $redirect );
        exit;
    }

    // Raw inputs (unslashed)
    $name_raw    = wp_unslash( $_POST['aurora_name'] ?? '' );
    $email_raw   = wp_unslash( $_POST['aurora_email'] ?? '' );
    $subject_raw = wp_unslash( $_POST['aurora_subject'] ?? '' );
    $message_raw = wp_unslash( $_POST['aurora_message'] ?? '' );
    $honeypot_raw = wp_unslash( $_POST['aurora_hp'] ?? '' );
    $form_time_raw = wp_unslash( $_POST['aurora_form_time'] ?? '' );

    // Basic sanitization
    $name    = sanitize_text_field( $name_raw );
    // Prevent header injection via newlines
    $name    = preg_replace( '/[\r\n]+/', ' ', $name );
    $name    = mb_substr( $name, 0, 255 );

    $email   = sanitize_email( $email_raw );
    // Honeypot check: if filled, treat as spam
    if ( ! empty( $honeypot_raw ) ) {
        // Minimal form data for logging
        $form_data = array(
            'name'    => sanitize_text_field( $name_raw ),
            'email'   => $email,
            'subject' => sanitize_text_field( $subject_raw ),
            'message' => sanitize_textarea_field( $message_raw ),
            'to'      => get_option( 'admin_email' ),
        );
        do_action( 'aurora_contact_form_submitted', $form_data, false, 'honeypot' );
        $redirect = wp_get_referer() ? add_query_arg( 'contact', 'error', wp_get_referer() ) : home_url();
        wp_safe_redirect( $redirect );
        exit;
    }

    // Time-based check: submissions that are too fast are likely bots
    $min_seconds = absint( apply_filters( 'aurora_contact_honeypot_min_time', 3 ) );
    $form_time = intval( $form_time_raw );
    if ( $form_time > 0 ) {
        $elapsed = time() - $form_time;
        if ( $elapsed < $min_seconds ) {
            $form_data = array(
                'name'    => sanitize_text_field( $name_raw ),
                'email'   => $email,
                'subject' => sanitize_text_field( $subject_raw ),
                'message' => sanitize_textarea_field( $message_raw ),
                'to'      => get_option( 'admin_email' ),
            );
            do_action( 'aurora_contact_form_submitted', $form_data, false, 'too_fast' );
            $redirect = wp_get_referer() ? add_query_arg( 'contact', 'error', wp_get_referer() ) : home_url();
            wp_safe_redirect( $redirect );
            exit;
        }
    }
    if ( empty( $email ) || ! is_email( $email ) ) {
        $redirect = wp_get_referer() ? add_query_arg( 'contact', 'error', wp_get_referer() ) : home_url();
        wp_safe_redirect( $redirect );
        exit;
    }

    $subject = sanitize_text_field( $subject_raw );
    $subject = preg_replace( '/[\r\n]+/', ' ', $subject );
    $subject = trim( $subject );
    if ( empty( $subject ) ) {
        /* translators: %s: site title */
        $subject = sprintf( __( 'Contact form submission — %s', 'aurora-borealis' ), get_bloginfo( 'name' ) );
    } else {
        $subject = mb_substr( $subject, 0, 200 );
    }

    $message = sanitize_textarea_field( $message_raw );

    $to = get_option( 'admin_email' );
    $body = "Name: " . $name . "\n";
    $body .= "Email: " . $email . "\n\n";
    $body .= "Message:\n" . $message . "\n";

    // Build safe headers. Do NOT set arbitrary From headers — keep Reply-To only.
    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );
    $safe_name = str_replace( array( "\r", "\n" ), '', $name );
    $headers[] = 'Reply-To: ' . $safe_name . ' <' . $email . '>';

    // Provide a hook so other code can log, modify, or short-circuit the send.
    $form_data = array(
        'name'    => $name,
        'email'   => $email,
        'subject' => $subject,
        'message' => $message,
        'to'      => $to,
    );

    $sent = wp_mail( $to, $subject, $body, $headers );

    /**
     * Action: aurora_contact_form_submitted
     *
     * Allow plugins/themes to log or process submissions.
     *
     * @param array $form_data Submission data (sanitized).
     * @param bool  $sent      Whether wp_mail returned true.
     */
    do_action( 'aurora_contact_form_submitted', $form_data, $sent );

    $redirect = wp_get_referer() ? remove_query_arg( 'contact', wp_get_referer() ) : home_url();
    $redirect = add_query_arg( 'contact', $sent ? 'success' : 'error', $redirect );
    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_nopriv_aurora_contact_submit', 'aurora_handle_contact_form' );
add_action( 'admin_post_aurora_contact_submit', 'aurora_handle_contact_form' );
}
}

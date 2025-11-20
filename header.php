<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class( ( is_front_page() && get_theme_mod( 'aurora_hero_enable', true ) ) ? 'has-hero' : '' ); ?>>

<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'aurora-borealis' ); ?></a>

<header class="site-header">
  <button class="mobile-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'aurora-borealis' ); ?>" aria-expanded="false" aria-controls="mobile-navigation">
    <span aria-hidden="true">☰</span>
  </button>
  <div class="site-nav">
    <div class="brand">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { the_custom_logo(); } else { bloginfo( 'name' ); } ?>
      </a>
    </div>
    <nav class="primary-nav" id="primary-navigation" aria-label="Primary">
      <?php
        if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu' ) );
        } else {
          wp_page_menu( array( 'menu_class' => 'menu' ) );
        }
      ?>
    </nav>
    <div id="mobile-navigation" class="mobile-nav" aria-hidden="true">
      <?php
        if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'mobile-menu' ) );
        } else {
          wp_page_menu( array( 'menu_class' => 'mobile-menu' ) );
        }
      ?>
    </div>
    <div class="nav-search">
      <?php $aurora_search_id = 'header-search-' . wp_unique_id(); ?>
      <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label class="screen-reader-text" for="<?php echo esc_attr( $aurora_search_id ); ?>">
          <?php esc_html_e( 'Search for:', 'aurora-borealis' ); ?>
        </label>
        <input
          type="search"
          id="<?php echo esc_attr( $aurora_search_id ); ?>"
          class="search-field"
          placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'aurora-borealis' ); ?>"
          value="<?php echo esc_attr( get_search_query() ); ?>"
          name="s"
        />
        <button class="search-submit" type="submit">
          <span aria-hidden="true">🔍</span>
          <span class="screen-reader-text"><?php esc_html_e( 'Submit search', 'aurora-borealis' ); ?></span>
        </button>
      </form>
    </div>
  </div>
</header>

<?php if ( is_front_page() ) : ?>
<section class="hero" role="banner">
  <div class="hero-auroras">
    <div class="aurora aurora-1"></div>
    <div class="aurora aurora-2"></div>
    <div class="aurora aurora-3"></div>
  </div>
  <div class="hero-inner">
    <div class="hero-content">
      <h2 class="eyebrow">NORTHERN LIGHTS.</h2>
      <h1 class="hero-title">Lorem ipsum dolor sit amet</h1>
      <p class="hero-sub">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
      <p><a class="btn-outline" href="#">Learn more</a></p>
    </div>
  </div>
  <svg class="hero-mountains" viewBox="0 0 1440 220" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="mtnGrad" x1="0" x2="0" y1="0" y2="1">
        <stop offset="0%" stop-color="#072033" />
        <stop offset="100%" stop-color="#021521" />
      </linearGradient>
    </defs>
    <path d="M0,160 L140,120 L260,140 L420,80 L540,140 L720,60 L900,120 L1100,40 L1280,120 L1440,100 L1440,220 L0,220 Z" fill="url(#mtnGrad)" />
  </svg>
  </section>
<?php endif; ?>

<div class="container">
  <main id="content">
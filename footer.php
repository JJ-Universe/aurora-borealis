<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
  </main>
  <footer class="site-footer">
    <div class="footer-inner">
      <section class="footer-panel footer-brand">
        <?php if ( get_bloginfo( 'description' ) ) : ?>
          <p class="footer-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
        <?php endif; ?>
      </section>

      <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
        <section class="footer-panel footer-widgets" aria-label="<?php esc_attr_e( 'Footer widgets', 'aurora-borealis' ); ?>">
          <?php dynamic_sidebar( 'footer-1' ); ?>
        </section>
      <?php endif; ?>

      <?php if ( has_nav_menu( 'social' ) ) : ?>
        <section class="footer-panel footer-social" aria-label="<?php esc_attr_e( 'Social links', 'aurora-borealis' ); ?>">
          <p class="footer-panel-label"><?php esc_html_e( 'Follow us', 'aurora-borealis' ); ?></p>
          <?php
            wp_nav_menu( array(
              'theme_location' => 'social',
              'container'      => false,
              'menu_class'     => 'footer-social-menu',
              'depth'          => 1,
            ) );
          ?>
        </section>
      <?php endif; ?>
    </div>

    <div class="footer-bottom">
      <?php if ( get_theme_mod( 'aurora_footer_text', '' ) ) : ?>
        <p class="site-footer-text"><?php echo wp_kses_post( get_theme_mod( 'aurora_footer_text' ) ); ?></p>
      <?php endif; ?>
      <p class="site-info">
        &copy; <?php esc_html_e( 'All rights reserved.', 'aurora-borealis' ); ?>
      </p>
      <a class="back-to-top" href="#content"><?php esc_html_e( 'Back to top', 'aurora-borealis' ); ?></a>
    </div>
  </footer>
</div><!-- .container -->
<?php wp_footer(); ?>
</body>
</html>
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
          <header class="page-header">
            <h1><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
              <p class="page-intro"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
          </header>
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="page-featured">
              <?php the_post_thumbnail( 'large' ); ?>
            </div>
          <?php endif; ?>
          <div class="entry-content">
            <?php the_content(); ?>
          </div>
        </article>
        <?php
    endwhile;
endif;

get_footer();

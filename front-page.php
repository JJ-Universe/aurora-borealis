<?php
/*
Template Name: Front Page (Landing)
*/
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

  <section class="section section-hero">
    <!-- hero is handled in header.php -->
  </section>

  <section class="section bg-ghost">
    <div class="features container-inner">
      <div class="feature">
        <h3>Lorem ipsum</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.</p>
      </div>
      <div class="feature">
        <h3>Dolor sit amet</h3>
        <p>Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.</p>
      </div>
      <div class="feature">
        <h3>Consectetur</h3>
        <p>Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.</p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container-inner cta">
      <div class="cta-text">
        <h2>Lorem ipsum dolor sit amet</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.</p>
      </div>
      <div class="cta-cta">
        <a class="btn-outline" href="#">Learn more</a>
      </div>
    </div>
  </section>

  <section class="section bg-ghost">
    <div class="container-inner">
      <h2>Latest Articles</h2>
        <?php
          $aurora_latest = new WP_Query( array(
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
          ) );
        ?>
        <?php if ( $aurora_latest->have_posts() ) : ?>
          <div class="posts">
            <?php while ( $aurora_latest->have_posts() ) : $aurora_latest->the_post(); ?>
              <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                <div class="post-card__meta">
                  <span class="post-card__date"><?php echo esc_html( get_the_date() ); ?></span>
                  <?php if ( has_category() ) : ?>
                    <span class="post-card__categories"><?php the_category( ', ' ); ?></span>
                  <?php endif; ?>
                </div>
                <h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="post-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24, '...' ) ); ?></p>
                <a class="post-card__read" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read article', 'aurora-borealis' ); ?></a>
              </article>
            <?php endwhile; ?>
          </div>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <p><?php esc_html_e( 'No posts yet.', 'aurora-borealis' ); ?></p>
        <?php endif; ?>
    </div>
  </section>

  <section class="section section-concept">
    <div class="container-inner concept">
      <div class="concept-copy">
        <p class="eyebrow">Lorem ipsum</p>
        <h2>Dolor sit amet, consectetur</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.</p>
      </div>
      <figure class="concept-figure">
        <figcaption>Lorem ipsum dolor sit amet.</figcaption>
      </figure>
    </div>
  </section>

<?php
get_footer();

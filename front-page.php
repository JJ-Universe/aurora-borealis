<?php
/*
Template Name: Front Page (Landing)
*/
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$aurora_feature_titles = array(
  get_theme_mod( 'aurora_feature_one_title', __( 'Lorem ipsum', 'aurora-borealis' ) ),
  get_theme_mod( 'aurora_feature_two_title', __( 'Dolor sit amet', 'aurora-borealis' ) ),
  get_theme_mod( 'aurora_feature_three_title', __( 'Consectetur', 'aurora-borealis' ) ),
);

$aurora_feature_texts = array(
  get_theme_mod( 'aurora_feature_one_text', __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.', 'aurora-borealis' ) ),
  get_theme_mod( 'aurora_feature_two_text', __( 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.', 'aurora-borealis' ) ),
  get_theme_mod( 'aurora_feature_three_text', __( 'Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.', 'aurora-borealis' ) ),
);

$aurora_cta_title = get_theme_mod( 'aurora_cta_title', __( 'Lorem ipsum dolor sit amet', 'aurora-borealis' ) );
$aurora_cta_text  = get_theme_mod( 'aurora_cta_text', __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.', 'aurora-borealis' ) );
$aurora_cta_btn_text = get_theme_mod( 'aurora_cta_button_text', __( 'Learn more', 'aurora-borealis' ) );
$aurora_cta_btn_url  = get_theme_mod( 'aurora_cta_button_url', '#' );

$aurora_latest_heading = get_theme_mod( 'aurora_latest_heading', __( 'Latest Articles', 'aurora-borealis' ) );

$aurora_concept = array(
  'eyebrow' => get_theme_mod( 'aurora_concept_eyebrow', __( 'Lorem ipsum', 'aurora-borealis' ) ),
  'title'   => get_theme_mod( 'aurora_concept_title', __( 'Dolor sit amet, consectetur', 'aurora-borealis' ) ),
  'text'    => get_theme_mod( 'aurora_concept_text', __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.', 'aurora-borealis' ) ),
  'caption' => get_theme_mod( 'aurora_concept_caption', __( 'Lorem ipsum dolor sit amet.', 'aurora-borealis' ) ),
);
?>

  <section class="section section-hero">
    <!-- hero is handled in header.php -->
  </section>

  <section class="section bg-ghost">
    <div class="features container-inner">
      <?php foreach ( $aurora_feature_titles as $index => $title ) :
        $feature_text = isset( $aurora_feature_texts[ $index ] ) ? $aurora_feature_texts[ $index ] : '';
      ?>
        <div class="feature">
          <?php if ( $title ) : ?><h3><?php echo esc_html( $title ); ?></h3><?php endif; ?>
          <?php if ( ! empty( $feature_text ) ) : ?>
            <p><?php echo wp_kses_post( $feature_text ); ?></p>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section">
    <div class="container-inner cta">
      <div class="cta-text">
        <?php if ( $aurora_cta_title ) : ?><h2><?php echo esc_html( $aurora_cta_title ); ?></h2><?php endif; ?>
        <?php if ( $aurora_cta_text ) : ?><p><?php echo wp_kses_post( $aurora_cta_text ); ?></p><?php endif; ?>
      </div>
      <div class="cta-cta">
        <?php if ( $aurora_cta_btn_text ) : ?>
          <a class="btn-outline" href="<?php echo esc_url( $aurora_cta_btn_url ? $aurora_cta_btn_url : '#' ); ?>"><?php echo esc_html( $aurora_cta_btn_text ); ?></a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <section class="section bg-ghost">
    <div class="container-inner">
      <?php if ( $aurora_latest_heading ) : ?><h2><?php echo esc_html( $aurora_latest_heading ); ?></h2><?php endif; ?>
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
        <?php if ( $aurora_concept['eyebrow'] ) : ?><p class="eyebrow"><?php echo esc_html( $aurora_concept['eyebrow'] ); ?></p><?php endif; ?>
        <?php if ( $aurora_concept['title'] ) : ?><h2><?php echo esc_html( $aurora_concept['title'] ); ?></h2><?php endif; ?>
        <?php if ( $aurora_concept['text'] ) : ?><p><?php echo wp_kses_post( $aurora_concept['text'] ); ?></p><?php endif; ?>
      </div>
      <figure class="concept-figure">
        <?php if ( $aurora_concept['caption'] ) : ?><figcaption><?php echo esc_html( $aurora_concept['caption'] ); ?></figcaption><?php endif; ?>
      </figure>
    </div>
  </section>

<?php
get_footer();

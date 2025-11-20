<?php
// Minimal index for Aurora Borealis
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile;
else : ?>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi.</p>
<?php
endif;
get_footer();
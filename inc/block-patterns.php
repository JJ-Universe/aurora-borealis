<?php
/**
 * Block patterns for the theme.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'aurora_register_pattern_categories' ) ) :
function aurora_register_pattern_categories() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }

    $categories = array(
        'hero'           => __( 'Hero', 'aurora-borealis' ),
        'features'       => __( 'Features', 'aurora-borealis' ),
        'call-to-action' => __( 'Call to Action', 'aurora-borealis' ),
        'testimonials'   => __( 'Testimonials', 'aurora-borealis' ),
        'pricing'        => __( 'Pricing', 'aurora-borealis' ),
        'team'           => __( 'Team', 'aurora-borealis' ),
    );

    foreach ( $categories as $slug => $label ) {
        register_block_pattern_category( $slug, array( 'label' => $label ) );
    }
}
add_action( 'init', 'aurora_register_pattern_categories', 9 );
endif;

if ( ! function_exists( 'aurora_get_pattern_content' ) ) :
function aurora_get_pattern_content( $relative_path ) {
    $file = get_theme_file_path( $relative_path );

    if ( empty( $file ) || ! file_exists( $file ) ) {
        return '';
    }

    $content = file_get_contents( $file );
    return $content ? trim( $content ) : '';
}
endif;

if ( ! function_exists( 'aurora_register_block_patterns' ) ) :
function aurora_register_block_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $patterns = array(
        array(
            'slug'        => 'aurora/hero',
            'title'       => __( 'Hero (Centered)', 'aurora-borealis' ),
            'categories'  => array( 'hero' ),
            'keywords'    => array( 'hero', 'cover' ),
            'file'        => 'patterns/pattern-hero.html',
        ),
        array(
            'slug'        => 'aurora/hero-variant',
            'title'       => __( 'Hero Variant', 'aurora-borealis' ),
            'categories'  => array( 'hero' ),
            'keywords'    => array( 'hero', 'intro' ),
            'file'        => 'patterns/pattern-hero-variant.html',
        ),
        array(
            'slug'        => 'aurora/cta',
            'title'       => __( 'CTA (Wide)', 'aurora-borealis' ),
            'categories'  => array( 'call-to-action' ),
            'file'        => 'patterns/pattern-cta.html',
        ),
        array(
            'slug'        => 'aurora/cta-variant',
            'title'       => __( 'CTA Variant', 'aurora-borealis' ),
            'categories'  => array( 'call-to-action' ),
            'file'        => 'patterns/pattern-cta-variant.html',
        ),
        array(
            'slug'        => 'aurora/features',
            'title'       => __( 'Features (Three Columns)', 'aurora-borealis' ),
            'categories'  => array( 'features' ),
            'file'        => 'patterns/pattern-features.html',
        ),
        array(
            'slug'        => 'aurora/features-grid',
            'title'       => __( 'Features Grid', 'aurora-borealis' ),
            'categories'  => array( 'features' ),
            'file'        => 'patterns/pattern-features-grid.html',
        ),
        array(
            'slug'        => 'aurora/pricing',
            'title'       => __( 'Pricing Cards', 'aurora-borealis' ),
            'categories'  => array( 'pricing' ),
            'file'        => 'patterns/pattern-pricing.html',
        ),
        array(
            'slug'        => 'aurora/team',
            'title'       => __( 'Team Profiles', 'aurora-borealis' ),
            'categories'  => array( 'team' ),
            'file'        => 'patterns/pattern-team.html',
        ),
        array(
            'slug'        => 'aurora/testimonial',
            'title'       => __( 'Testimonial', 'aurora-borealis' ),
            'categories'  => array( 'testimonials' ),
            'file'        => 'patterns/pattern-testimonial.html',
        ),
    );

    foreach ( $patterns as $pattern ) {
        $content = aurora_get_pattern_content( $pattern['file'] );

        if ( empty( $content ) ) {
            continue;
        }

        $args = array(
            'title'      => $pattern['title'],
            'content'    => $content,
            'categories' => $pattern['categories'],
        );

        if ( ! empty( $pattern['keywords'] ) ) {
            $args['keywords'] = $pattern['keywords'];
        }

        if ( ! empty( $pattern['description'] ) ) {
            $args['description'] = $pattern['description'];
        }

        register_block_pattern( $pattern['slug'], $args );
    }
}
add_action( 'init', 'aurora_register_block_patterns', 11 );
endif;

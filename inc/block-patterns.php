<?php
/**
 * Block patterns for the theme.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register block pattern categories used by this theme.
 */
if ( ! function_exists( 'aurora_register_pattern_categories' ) ) {
    function aurora_register_pattern_categories() {
        if ( function_exists( 'register_block_pattern_category' ) ) {
            register_block_pattern_category( 'hero', array( 'label' => __( 'Hero', 'aurora-borealis' ) ) );
            register_block_pattern_category( 'features', array( 'label' => __( 'Features', 'aurora-borealis' ) ) );
            register_block_pattern_category( 'call-to-action', array( 'label' => __( 'Call to Action', 'aurora-borealis' ) ) );
            register_block_pattern_category( 'testimonials', array( 'label' => __( 'Testimonials', 'aurora-borealis' ) ) );
            register_block_pattern_category( 'pricing', array( 'label' => __( 'Pricing', 'aurora-borealis' ) ) );
            register_block_pattern_category( 'team', array( 'label' => __( 'Team', 'aurora-borealis' ) ) );
        }
    }
    add_action( 'init', 'aurora_register_pattern_categories', 9 );
}

<?php
/**
 * Plugin Name: Real Estate Core
 * Description: Registers custom post type "Real Estate Object" and taxonomy "District". Adds filtering and API functionality.
 * Version: 1.0
 * Author: Kate Kulikova
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define( 'REC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'REC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include core files
$includes = [
    'includes/post-type.php',
    'includes/taxonomy.php',
    'includes/api.php',
    'includes/filter-ui.php',
    'includes/ajax.php',
    'includes/class-query-modifier.php',
    'includes/widget.php',
];

foreach ( $includes as $file ) {
    $filepath = REC_PLUGIN_PATH . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    }
}

// Initialize main query modifier class
if ( class_exists( 'Real_Estate_Query_Modifier' ) ) {
    new Real_Estate_Query_Modifier();
}

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_script( 'real-estate-filter', REC_PLUGIN_URL . 'assets/js/filter.js', [], null, true );
    wp_enqueue_style( 'real-estate-style', REC_PLUGIN_URL . 'assets/css/filter.css' );

    wp_localize_script( 'real-estate-filter', 'real_estate_ajax', [
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ] );
});

// Load ACF fields
if ( function_exists( 'acf_add_local_field_group' ) ) {
    require_once REC_PLUGIN_PATH . 'acf-fields.php';
} else {
    add_action( 'admin_notices', function () {
        echo '<div class="notice notice-error"><p><strong>ACF PRO is required for the Real Estate Core plugin to work properly.</strong></p></div>';
    });
}

// Admin notice for template copy
add_action( 'admin_notices', function () {
    $theme_dir = get_stylesheet_directory();

    $single_missing = ! file_exists( $theme_dir . '/single-real_estate.php' );
    $archive_missing = ! file_exists( $theme_dir . '/archive-real_estate.php' );

    if ( $single_missing || $archive_missing ) {
        echo '<div class="notice notice-warning"><p><strong>Real Estate Core:</strong>';

        if ( $single_missing ) {
            echo '<br>To display <strong>single</strong> real estate objects, please copy <code>plugins/real-estate-core/templates/single-real_estate.php</code> to your theme.';
        }

        if ( $archive_missing ) {
            echo '<br>To display the <strong>archive</strong> of real estate objects, copy <code>plugins/real-estate-core/templates/archive-real_estate.php</code> to your theme.';
        }

        echo '</p></div>';
    }
});

// Register shortcode
add_shortcode( 'real_estate_filter', 'rec_render_filter_form' );
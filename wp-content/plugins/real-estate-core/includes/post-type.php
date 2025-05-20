<?php
/**
 * Register custom post type: Real Estate
 */
function rec_register_post_type() {
    register_post_type( 'real_estate', [
        'labels' => [
            'name'               => 'Real Estate Objects',
            'singular_name'      => 'Real Estate Object',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Real Estate Object',
            'edit_item'          => 'Edit Real Estate Object',
            'new_item'           => 'New Real Estate Object',
            'view_item'          => 'View Real Estate Object',
            'search_items'       => 'Search Real Estate Objects',
            'not_found'          => 'No objects found',
            'not_found_in_trash' => 'No objects found in Trash',
            'menu_name'          => 'Real Estate',
        ],
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => [ 'slug' => 'real-estate' ],
        'menu_icon'     => 'dashicons-admin-multisite',
        'supports'      => [ 'title', 'editor', 'thumbnail' ],
        'show_in_rest'  => true,
    ] );
}
add_action( 'init', 'rec_register_post_type' );
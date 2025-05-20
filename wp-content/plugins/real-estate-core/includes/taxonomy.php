<?php
/**
 * Register taxonomy: District
 */
function rec_register_taxonomy() {
    register_taxonomy( 'district', 'real_estate', [
        'labels' => [
            'name'              => 'Districts',
            'singular_name'     => 'District',
            'search_items'      => 'Search Districts',
            'all_items'         => 'All Districts',
            'edit_item'         => 'Edit District',
            'update_item'       => 'Update District',
            'add_new_item'      => 'Add New District',
            'new_item_name'     => 'New District Name',
            'menu_name'         => 'Districts',
        ],
        'public'        => true,
        'hierarchical'  => true,
        'rewrite'       => [ 'slug' => 'district' ],
        'show_in_rest'  => true,
    ] );
}
add_action( 'init', 'rec_register_taxonomy' );
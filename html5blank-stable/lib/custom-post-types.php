<?php

// Create custom post

// TODO is this post type every used?

function create_post_type_html5()
{
    register_taxonomy_for_object_type('category', 'custom-post'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'custom-post');
    register_post_type('custom-post', // Register custom post type
        array(
        'labels' => array(
            'name' => __('Anpassade inlägg', 'mxmcom'), // Rename these to suit
            'singular_name' => __('Anpassade inlägg', 'mxmcom'),
            'add_new' => __('Lägg till nytt', 'mxmcom'),
            'add_new_item' => __('Lägg till nytt', 'mxmcom'),
            'edit' => __('Redigera', 'mxmcom'),
            'edit_item' => __('Redigera', 'mxmcom'),
            'new_item' => __('Nytt', 'mxmcom'),
            'view' => __('Visa anpassat inlägg', 'mxmcom'),
            'view_item' => __('Visa', 'mxmcom'),
            'search_items' => __('Sök', 'mxmcom'),
            'not_found' => __('Inga inlägg funna', 'mxmcom'),
            'not_found_in_trash' => __('Inga inlägg funna i papperskorg', 'mxmcom')
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'custom-post' ), // Ersätt denna med din slug
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail'
        ), // Go to Dashboard post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}
add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Anpassat inlägg Type

// News

function create_post_type_news() {
    register_post_type('news', // Register custom post type
        array(
            'labels' => array(
                'name' => __('Nyheter', 'mxmcom'), // Rename these to suit
                'singular_name' => __('Nyhet', 'mxmcom'),
                'add_new' => __('Lägg till nyhet', 'mxmcom'),
                'add_new_item' => __('Lägg till nyhet', 'mxmcom'),
                'edit' => __('Redigera', 'mxmcom'),
                'edit_item' => __('Redigera nyhet', 'mxmcom'),
                'new_item' => __('Ny nyhet', 'mxmcom'),
                'view' => __('Visa nyhet', 'mxmcom'),
                'view_item' => __('Visa', 'mxmcom'),
                'search_items' => __('Sök', 'mxmcom'),
                'not_found' => __('Inga nyheter funna', 'mxmcom'),
                'not_found_in_trash' => __('Inga nyheter funna i papperskorg', 'mxmcom')
            ),
            'public' => true,
            'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'nyheter' ), // Ersätt denna med din slug
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard post for supports
            'can_export' => true // Allows export in Tools > Export
        ));
}
add_action('init', 'create_post_type_news'); // Add news post type

// Program center (Utbildningscenter)

function create_post_type_program_center() {
    register_post_type('program_center', // Register custom post type
        array(
            'labels' => array(
                'name' => __('Utbildningscenter', 'mxmcom'), // Rename these to suit
                'singular_name' => __('Utbildningscenter', 'mxmcom'),
                'add_new' => __('Lägg till utbildningscenter', 'mxmcom'),
                'add_new_item' => __('Lägg till utbildningscenter', 'mxmcom'),
                'edit' => __('Redigera', 'mxmcom'),
                'edit_item' => __('Redigera utbildningcenter', 'mxmcom'),
                'new_item' => __('Ny utbildningcenter', 'mxmcom'),
                'view' => __('Visa utbildningcenter', 'mxmcom'),
                'view_item' => __('Visa', 'mxmcom'),
                'search_items' => __('Sök', 'mxmcom'),
                'not_found' => __('Inga utbildningcenter funna', 'mxmcom'),
                'not_found_in_trash' => __('Inga utbildningcenter funna i papperskorg', 'mxmcom')
            ),
            'public' => true,
            'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'utbildningscenter' ), // Ersätt denna med din slug
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard post for supports
            'can_export' => true // Allows export in Tools > Export
        ));
}
add_action('init', 'create_post_type_program_center'); // Add news post type

// Schools

function create_post_type_schools() {
    register_post_type('school', // Register custom post type
        array(
            'labels' => array(
                'name' => __('Skolor', 'mxmcom'), // Rename these to suit
                'singular_name' => __('Skola', 'mxmcom'),
                'add_new' => __('Lägg till skolor', 'mxmcom'),
                'add_new_item' => __('Lägg till skolor', 'mxmcom'),
                'edit' => __('Redigera', 'mxmcom'),
                'edit_item' => __('Redigera skolor', 'mxmcom'),
                'new_item' => __('Ny skolor', 'mxmcom'),
                'view' => __('Visa skolor', 'mxmcom'),
                'view_item' => __('Visa', 'mxmcom'),
                'search_items' => __('Sök', 'mxmcom'),
                'not_found' => __('Inga skolor funna', 'mxmcom'),
                'not_found_in_trash' => __('Inga skolor funna i papperskorg', 'mxmcom')
            ),
            'public' => true,
            'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'schools' ), // Ersätt denna med din slug
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard post for supports
            'can_export' => true // Allows export in Tools > Export
        ));
}
add_action('init', 'create_post_type_schools'); // Add news post type

// Volunteer shift (Programtillfällen)

function create_post_type_volunteer_shift() {
    register_post_type('volunteer_shift', // Register custom post type
        array(
            'labels' => array(
                'name' => __('Programtillfällen', 'mxmcom'), // Rename these to suit
                'singular_name' => __('Programtillfälle', 'mxmcom'),
                'add_new' => __('Lägg till Programtillfälle', 'mxmcom'),
                'add_new_item' => __('Lägg till Programtillfälle', 'mxmcom'),
                'edit' => __('Redigera', 'mxmcom'),
                'edit_item' => __('Redigera Programtillfälle', 'mxmcom'),
                'new_item' => __('Nytt Programtillfälle', 'mxmcom'),
                'view' => __('Visa Programtillfälle', 'mxmcom'),
                'view_item' => __('Visa', 'mxmcom'),
                'search_items' => __('Sök', 'mxmcom'),
                'not_found' => __('Inga Programtillfällen funna', 'mxmcom'),
                'not_found_in_trash' => __('Inga Programtillfällen funna i papperskorg', 'mxmcom')
            ),
            'public' => true,
            'show_in_rest' => true,
            'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'programtillfallen' ), // Ersätt denna med din slug
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard post for supports
            'can_export' => true // Allows export in Tools > Export
        ));
}
add_action('init', 'create_post_type_volunteer_shift'); // Add news post type

// Volunteer Hours (Bokade programtillfällen, tillhör en användare)

function create_post_type_booked_shift() {
    register_post_type('booked_shift', // Register custom post type
        array(
            'labels' => array(
                'name' => __('Volontärbokningar', 'mxmcom'), // Rename these to suit
                'singular_name' => __('Bokat volontärpass', 'mxmcom'),
                'add_new' => __('Boka volontärpass', 'mxmcom'),
                'add_new_item' => __('Boka volontärpass', 'mxmcom'),
                'edit' => __('Redigera', 'mxmcom'),
                'edit_item' => __('Redigera bokning', 'mxmcom'),
                'new_item' => __('Ny bokning av volontärpass', 'mxmcom'),
                'view' => __('Visa bokning av volontärpass', 'mxmcom'),
                'view_item' => __('Visa', 'mxmcom'),
                'search_items' => __('Sök', 'mxmcom'),
                'not_found' => __('Inga bokade volontärpass funna', 'mxmcom'),
                'not_found_in_trash' => __('Inga bokade volontärpass funna i papperskorg', 'mxmcom')
            ),
            'public' => true,
            'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'bokningar' ), // Ersätt denna med din slug
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'thumbnail'
            ), // Go to Dashboard post for supports
            'can_export' => true // Allows export in Tools > Export
        ));
}
add_action('init', 'create_post_type_booked_shift'); // Add news post type

/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' cfmeta ON '. $wpdb->posts . '.ID = cfmeta.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (cfmeta.meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

// Add custom columns for the custom post types
include 'custom-post-type-columns.php';

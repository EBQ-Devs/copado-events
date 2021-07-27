<?php
/**
 * Plugin Name: Copado Events
 * Plugin URI: https://www.copado.com/.com/copado-events
 * Description: Copado events plugin custom
 * Version: 1.0
 * Author: EBQ
 * Author URI: https://www.copado.com/
 */
// custom post type function
function create_posttype() {
 
    register_post_type( 'events',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Events' ),
                'singular_name' => __( 'Event' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'events'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Events', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Events', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Event', 'twentytwenty' ),
        'all_items'           => __( 'All Events', 'twentytwenty' ),
        'view_item'           => __( 'View Event', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Event', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Event', 'twentytwenty' ),
        'update_item'         => __( 'Update Event', 'twentytwenty' ),
        'search_items'        => __( 'Search Events', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'events', 'twentytwenty' ),
        'description'         => __( 'Copado Events', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 
        'title', 
        'editor', 
        'excerpt', 
        'thumbnail', 
        'custom-fields', 
        'revisions' ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'eventType' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering Custom Post Type
    register_post_type( 'events', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );
//create short code for test list
add_shortcode( 'copado-test-list', 'create_copado_test_list' ); 

    
// add fields to RSS
add_action('rss2_item', 'yoursite_rss2_item');
function yoursite_rss2_item() {
  if (get_post_type()=='events') {
    $fields = array( 'dateTime','clockTime','location','image','summary','register' );
    $post_id = get_the_ID();
    foreach($fields as $field)
      if ($value = get_post_meta($post_id,$field,true))
        echo "<{$field}>{$value}</{$field}>\n";
  }
}
?>

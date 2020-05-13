<?php

/*
 *
 * Plugin Name: Common - Initiatives CPT
 * Description: Initiatives Plugin for Create
 * Author: Kalonte Jackson-Tate
 *
 */

/* Events Custom Post Type ------------------- */

 //ini_set('display_errors', 1);
 //ini_set('display_startup_errors', 1);
 //error_reporting(E_ALL);

function scripts_to_queue() {
    if (is_page('live')) {
        wp_enqueue_script( 'feed-select', get_stylesheet_directory_uri() . '/library/js/feed-select.js', array('jquery'), '20170412', true);
    }
}

add_action( 'wp_enqueue_scripts', 'scripts_to_queue' );

//Custom Art Events
add_action('init', 'custom_create');

function custom_create() {
    $args = array(
      'label' => 'Initiatives',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'initiatives'),
        'query_var' => true,
        'supports' => array(
            'title',
            'revisions',
            'thumbnail',
            'editor',
            'excerpt')
    );


    register_post_type( 'initiatives' , $args );
    flush_rewrite_rules();
}


//add subtitle
function initiatives_wp_subtitle_page_part_support() { add_post_type_support( 'initiatives', 'wps_subtitle' ); } 

add_action( 'init', 'initiatives_wp_subtitle_page_part_support' );
// end of adding subtitle
// end of adding subtitle


function admin_init(){
    //Events
    add_meta_box("initiatives-meta", "Options", "initiatives_meta_options", "initiatives", "normal", "low");
}
add_action('admin_init', 'admin_init');

function initiatives_meta_options(){
    global $post;
    $custom = get_post_custom($post->ID);
    $past_init = $custom["past_init"][0];

?>

<table>
 <tr><td>
    <input type="checkbox" name="past_init" value="past_init" <?=($past_init == "past_init" ? "checked" : "");?>> Past Initiative    
      </td>         
</tr>
</table>

<?php
}
function save_custom(){
    global $post;
    // Past Initiative
    //if(isset($post))
    update_post_meta($post->ID, "past_init", $_POST['past_init']);
}
add_action('save_post', 'save_custom');

add_action('admin_head', 'fix_table_width');
function fix_table_width() {
  echo '<style>
    .column-date_occur {
        width:10%;
        }
  </style>';
}

?>
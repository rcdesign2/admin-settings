<?php
/**
 * Plugin Name:       Admin Settings
 * Plugin URI:        https://github.com/rcdesign2/admin-settings
 * Description:       Demonstrates how to write custom administration pages in WordPress.
 * Version:           1.0.1
 * Author:            Ben Ross
 * Text Domain:       github-updater
 * GitHub Plugin URI: https://github.com/rcdesign2/admin-settings
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
    include_once $file;
}
// Include the shared dependency.
include_once( plugin_dir_path( __FILE__ ) . 'shared/class-deserializer.php' );

// Include cron dependency
include_once( plugin_dir_path( __FILE__ ) . 'API/instagram.php' );
include_once( plugin_dir_path( __FILE__ ) . 'cron/cron-update-posts.php' );

//Dashbaord Widget
include_once( plugin_dir_path( __FILE__ ) . 'admin/views/dashboard.php' );


//Enqueue
add_action('admin_enqueue_scripts','rc_init');

function rc_init() {
    wp_enqueue_script( 'rc_social_js', plugin_dir_url( __FILE__ ) . "js/script.js" );
}



add_action( 'plugins_loaded', 'rc_custom_admin_settings' );
/**
 * Starts the plugin.
 *
 * @since 1.0.0
 */
function rc_custom_admin_settings() {

    $serializer = new Serializer();
    $serializer->init();

    $deserializer = new Deserializer();


    $plugin = new Submenu( new Submenu_Page( $deserializer ) );
    $plugin->init();



}

add_action('wp','check_posts');
function check_posts(){
    $checker = new Checker('insta');
    $checker->begin();
}


add_action( 'wp_ajax_refresh_feed', 'refresh_feed' );
/**
 * AJAX call for dashboard button
 */
function refresh_feed() {
    global $wpdb; // this is how you get access to the database

    Update_rc_social_posts();

    json_encode("updated");

    wp_die(); // this is required to terminate immediately and return a proper response
}


add_shortcode( 'instagram-posts','instagram_posts' );
/**
 * Shortcode adds a row of Instagram images with links to full post
 */
function instagram_posts() {

    global $wp_query,
           $post;
    $loop = new WP_Query( array(
        'posts_per_page'    => -1,
        'post_type'         => 'rc_social_post',
        'orderby'           => 'title',
        'order'             => 'ASC',
    ) );

    if( ! $loop->have_posts() ) {
        return false;
    }

    $count = $loop->found_posts;
    //Bootstrap columns
    if($count<=12){
        $column = 12/$count;
        //If number has decimal
        //Round down
        if(floor( $column ) != $column){
            $column = floor( $column );
            if($column==0) $column = 1;
        }
    }else{
        $column = 4;
    }
    $content = '<div class="row row-eq-height">';
    while( $loop->have_posts() ) {
        $loop->the_post();
        $content .= '<div class="col-'.$column.'">';
        $content .= '<a href="https://www.instagram.com/p/'.get_field("rc_social_data").'" target="_blank">';
        $content .= '<img src="'.get_field("rc_social_image").'" style="height: 100%;-o-object-fit: cover;object-fit: cover;width: 100%;">';
        $content .= '</a>';
        $content .= '</div>';
    }
    $content .= '</div>';
    wp_reset_postdata();
    return $content;
}


/**
 * Dump Die
 *
 * @param mixed $data Data to print_r.
 */
function ddd( $data ) {
    ppp( $data );
    die;
}

/**
 * Pre Print
 *
 * @param mixed $data Data to print_r.
 */
function ppp( $data ) {
    echo '<pre>', print_r( $data, 1 ), '</pre>';
}


<?php

/**************************************************************************

Plugin Name:  Eliteprospects Link Generator
Plugin URI:   https://wordpress.org/plugins/eliteprospects-player-link/
Description:  Link to Eliteprospects profile pages for players and staff
Version:      0.6.4
Author:       Carl Grundberg
Author URI:   https://github.com/carlgrundberg

 **************************************************************************

 */

function ep_add_buttons() {
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
        return;

    // Add only in Rich Editor mode
    if ( get_user_option('rich_editing') != 'true') {
        return;
    }

    add_filter("mce_external_plugins", "add_ep_tinymce_plugin");
    add_filter('mce_buttons', 'register_ep_button');
}

function register_ep_button($buttons) {
    array_push($buttons, "ep_link");
    return $buttons;
}

function add_ep_tinymce_plugin($plugin_array) {
    $plugin_array['ep_link'] = plugins_url( 'ep_link.js' , __FILE__ );
    return $plugin_array;
}

add_action('admin_init', 'ep_add_buttons');

function ep_add_admin_scripts( $hook ) {
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        wp_enqueue_script('wpdialogs');
        wp_enqueue_script( 'eptooltips', plugins_url('eptooltips.min.js', __FILE__), array('jquery'), null, true);
        wp_enqueue_style('ep_link', plugins_url( 'ep_link.css' , __FILE__ ));
    }
}
add_action( 'admin_enqueue_scripts', 'ep_add_admin_scripts', 10, 1 );

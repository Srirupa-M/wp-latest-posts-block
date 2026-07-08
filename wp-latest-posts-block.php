<?php
/*
Plugin Name: Fetch Posts using REST API
Plugin URI : 
Description: Custom Gutenberg Block that fetches posts using WP REST API
Version: 1.0
Author: Srirupa
*/

if (!defined('ABSPATH')) exit;

define( 'WPLPB_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPLPB_URL', plugin_dir_url( __FILE__ ) );

require_once WPLPB_PATH . 'includes/enqueue.php';

function block_register() {
    register_block_type(
        WPLPB_PATH . 'src'
    );
}
add_action('init', 'block_register');
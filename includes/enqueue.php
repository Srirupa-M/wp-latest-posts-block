<?php
if ( !defined( 'ABSPATH' ) ) exit;

function wplpb_register_block() {
    register_block_type(
        WPLPB_PATH . 'src'
    );
}
add_action('init', 'wplpb_register_block');
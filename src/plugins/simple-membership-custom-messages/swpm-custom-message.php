<?php
/*
Plugin Name: Simple Membership Custom Messages
Description: Simple Membership Addon to customize various content protection messages.
Plugin URI: https://simple-membership-plugin.com/simple-membership-custom-messages-addon/
Author: wp.insider
Author URI: https://simple-membership-plugin.com/
Version: 1.5
*/

//Slug - swpm_cm_

define('SWPM_CUSTOM_MSG_VERSION', '1.5' );
define('SWPM_CUSTOM_MSG_PATH', dirname(__FILE__) . '/');
define('SWPM_CUSTOM_MSG_URL', plugins_url('',__FILE__));
add_action('plugins_loaded', 'swpm_load_custom_message');
require_once(SWPM_CUSTOM_MSG_PATH . 'classes/class.swpm-custom-message.php');
require_once(SWPM_CUSTOM_MSG_PATH . 'classes/class.swpm-custom-message-settings.php');
function swpm_load_custom_message(){
    if (class_exists('SimpleWpMembership')) {
        new SwpmCustomMessage();        
    }
}

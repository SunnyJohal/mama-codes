<?php

/**
 * Description of SwpmCustomMessage
 *
 * @author nur
 */
class SwpmCustomMessage {

    public function __construct() {
        add_action('swpm_after_main_admin_menu', array(&$this, 'swpm_custom_msg_do_admin_menu'));
        add_action('admin_init', array(&$this, 'admin_init_hook'));
        add_filter('swpm_restricted_post_msg', array(&$this, 'swpm_restricted_post_msg'));
        add_filter('swpm_not_logged_in_post_msg', array(&$this, 'swpm_not_logged_in_post_msg'));
        add_filter('swpm_restricted_comment_msg', array(&$this, 'swpm_restricted_comment_msg'));
        add_filter('swpm_not_logged_in_comment_msg', array(&$this, 'swpm_not_logged_in_comment_msg'));
        add_filter('swpm_restricted_more_tag_msg', array(&$this, 'swpm_restricted_more_tag_msg'));
        add_filter('swpm_not_logged_in_more_tag_msg', array(&$this, 'swpm_not_logged_in_more_tag_msg'));
        add_filter('swpm_registration_success_msg', array(&$this, 'swpm_registration_success_msg'));
        add_filter('swpm_account_expired_msg', array(&$this, 'swpm_account_expired_msg'));
    }

    public function swpm_registration_success_msg($output) {
        return $this->dispatch_message('swpm_registration_success_msg', $output);
    }
    
    public function swpm_account_expired_msg($output) {
        return $this->dispatch_message('swpm_account_expired_msg', $output);
    }

    public function swpm_restricted_post_msg($output) {
        return $this->dispatch_message('swpm_restricted_post_msg', $output);
    }

    public function swpm_not_logged_in_post_msg($output) {
        return $this->dispatch_message('swpm_not_logged_in_post_msg', $output);
    }

    public function swpm_restricted_comment_msg($output) {
        return $this->dispatch_message('swpm_restricted_comment_msg', $output);
    }

    public function swpm_not_logged_in_comment_msg($output) {
        return $this->dispatch_message('swpm_not_logged_in_comment_msg', $output);
    }

    public function swpm_restricted_more_tag_msg($output) {
        return $this->dispatch_message('swpm_restricted_more_tag_msg', $output);
    }

    public function swpm_not_logged_in_more_tag_msg($output) {
        return $this->dispatch_message('swpm_not_logged_in_more_tag_msg', $output);
    }

    private function dispatch_message($level, $default) {
        $msg = SwpmCustomMessageSettings::get_instance()->get_value($level);
        return empty($msg) ? $default : do_shortcode($msg);
    }

    public function swpm_custom_msg_do_admin_menu($menu_parent_slug) {
        add_submenu_page($menu_parent_slug, __("Custom Message", 'simple-membership'), __("Custom Message", 'simple-membership'), 'manage_options', 'swpm-custom-message', array(&$this, 'custom_message_admin_interface'));
    }

    public function custom_message_admin_interface() {
        $current_tab = SwpmCustomMessageSettings::get_instance()->current_tab;
        include(SWPM_CUSTOM_MSG_PATH . 'views/custom-message-settings.php');
    }

    public function admin_init_hook() {
        SwpmCustomMessageSettings::get_instance()->init_config_hooks();
    }

}

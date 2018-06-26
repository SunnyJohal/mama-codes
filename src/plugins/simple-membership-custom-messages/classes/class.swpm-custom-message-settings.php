<?php

class SwpmCustomMessageSettings {

    private static $_this;
    private $settings;
    public $current_tab;

    private function __construct() {
        $this->settings = (array) get_option('swpm-custom-message-settings');
    }

    public function init_config_hooks() {
        if (is_admin()) { // for frontend just load settings but dont try to render settings page.
            $tab = filter_input(INPUT_GET, 'tab');
            $tab = empty($tab) ? filter_input(INPUT_POST, 'tab') : $tab;
            $this->current_tab = empty($tab) ? 1 : $tab;
            add_action('swpm-custom-message-tab', array(&$this, 'draw_tabs'));
            $method = 'tab_' . $this->current_tab;
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    private function tab_1() {
        register_setting('swpm-custom-message-tab-1', 'swpm-custom-message-settings', array(&$this, 'sanitize_tab_1'));
        
        add_settings_section('swpm-documentation', BUtils::_('Plugin Documentation'), array(&$this, 'swpm_documentation_callback'), 'swpm-custom-message-settings');

        add_settings_section('pages-settings', BUtils::_('Custom Message Settings'), array(&$this, 'swpm_cm_general_settings_callback'), 'swpm-custom-message-settings');

        add_settings_field('swpm_restricted_post_msg', BUtils::_('Restricted Post'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_restricted_post_msg',
            'message' => 'Members who do not have access to this post/page content will see this message.'));
        add_settings_field('swpm_not_logged_in_post_msg', BUtils::_('Restricted Post (Not Logged-in)'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_not_logged_in_post_msg',
            'message' => 'Non logged in users will see this message on your protected posts/pages. If you customize this message then the "Enable Redirection to the Last Page" feature of the after login redirection addon won\'t work.'));
        add_settings_field('swpm_restricted_comment_msg', BUtils::_('Restricted Comment'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_restricted_comment_msg',
            'message' => 'Members who do not have access to protected comments will see this message.'));
        add_settings_field('swpm_not_logged_in_comment_msg', BUtils::_('Restricted Comment (Not Logged-in)'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_not_logged_in_comment_msg',
            'message' => 'Non logged in users will see this message on protected comments.'));
        add_settings_field('swpm_restricted_more_tag_msg', BUtils::_('Restricted More Tag'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_restricted_more_tag_msg',
            'message' => 'This message is shown on more tag protected posts (to members who do not have access to the post).'));
        add_settings_field('swpm_not_logged_in_more_tag_msg', BUtils::_('Restricted More Tag (Not Logged-in)'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_not_logged_in_more_tag_msg',
            'message' => 'Non logged in users will see this message on more tag protected posts.'));
        
        add_settings_field('swpm_registration_success_msg', BUtils::_('Registration Successful'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_registration_success_msg',
            'message' => 'This message gets displayed to the user after they submit the registration form.'));
        add_settings_field('swpm_account_expired_msg', BUtils::_('Account Expired'), array(&$this, 'textfield_long_callback'), 'swpm-custom-message-settings', 'pages-settings', array('item' => 'swpm_account_expired_msg',
            'message' => 'This message gets shown to members with expired accounts.'));

    }

    public static function get_instance() {
        self::$_this = empty(self::$_this) ? new SwpmCustomMessageSettings() : self::$_this;
        return self::$_this;
    }

    public function checkbox_callback($args) {
        $item = $args['item'];
        $msg = isset($args['message']) ? $args['message'] : '';
        $is = esc_attr($this->get_value($item));
        echo "<input type='checkbox' $is name='swpm-custom-message-settings[" . $item . "]' value=\"checked='checked'\" />";
        echo '<br/><i>' . $msg . '</i>';
    }

    public function textarea_callback($args) {
        $item = $args['item'];
        $msg = isset($args['message']) ? $args['message'] : '';
        $text = esc_attr($this->get_value($item));
        echo "<textarea name='swpm-custom-message-settings[" . $item . "]'  rows='6' cols='60' >" . $text . "</textarea>";
        echo '<br/><i>' . $msg . '</i>';
    }

    public function textfield_small_callback($args) {
        $item = $args['item'];
        $msg = isset($args['message']) ? $args['message'] : '';
        $text = esc_attr($this->get_value($item));
        echo "<input type='text' name='swpm-custom-message-settings[" . $item . "]'  size='5' value='" . $text . "' />";
        echo '<br/><i>' . $msg . '</i>';
    }

    public function textfield_callback($args) {
        $item = $args['item'];
        $msg = isset($args['message']) ? $args['message'] : '';
        $text = esc_attr($this->get_value($item));
        echo "<input type='text' name='swpm-custom-message-settings[" . $item . "]'  size='50' value='" . $text . "' />";
        echo '<br/><i>' . $msg . '</i>';
    }

    public function textfield_long_callback($args) {
        $item = $args['item'];
        $msg = isset($args['message']) ? $args['message'] : '';
        $text = esc_attr($this->get_value($item));
        echo "<input type='text' name='swpm-custom-message-settings[" . $item . "]'  size='100' value='" . $text . "' />";
        echo '<br/><i>' . $msg . '</i>';
    }

    public function swpm_documentation_callback() {
        ?>
        <div style="background: none repeat scroll 0 0 #FFF6D5;border: 1px solid #D1B655;color: #3F2502;margin: 10px 0;padding: 5px 5px 5px 10px;text-shadow: 1px 1px #FFFFFF;">
            <p>Please visit the
                <a target="_blank" href="https://simple-membership-plugin.com/simple-membership-custom-messages-addon/">custom messages addon page</a>
                to read setup and configuration documentation.
            </p>
        </div>
        <?php
    }

    public function swpm_cm_general_settings_callback() {
        echo '<p>Core plugin message will only be overwritten if you specify a value in any of the following fields.<p>';
    }

    public function sanitize_tab_1($input) {
        if (empty($this->settings)) {
            $this->settings = (array) get_option('swpm-custom-message-settings');
        }
        $output = $this->settings;

        $output['swpm_restricted_post_msg'] = ($input['swpm_restricted_post_msg']);
        $output['swpm_not_logged_in_post_msg'] = ($input['swpm_not_logged_in_post_msg']);
        $output['swpm_restricted_comment_msg'] = ($input['swpm_restricted_comment_msg']);
        $output['swpm_not_logged_in_comment_msg'] = ($input['swpm_not_logged_in_comment_msg']);
        $output['swpm_restricted_more_tag_msg'] = ($input['swpm_restricted_more_tag_msg']);
        $output['swpm_not_logged_in_more_tag_msg'] = ($input['swpm_not_logged_in_more_tag_msg']);
        $output['swpm_registration_success_msg'] = ($input['swpm_registration_success_msg']);
        $output['swpm_account_expired_msg'] = ($input['swpm_account_expired_msg']);

        return $output;
    }

    public function get_value($key, $default = "") {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }
        return $default;
    }

    public function set_value($key, $value) {
        $this->settings[$key] = $value;
        return $this;
    }

    public function save() {
        update_option('swpm-custom-message-settings', $this->settings);
    }

    public function draw_tabs() {
        $current = $this->current_tab;
        ?>
        <h3 class="nav-tab-wrapper">
            <a class="nav-tab <?php echo ($current == 1) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=swpm-custom-message">General Settings</a>
        </h3>
        <?php
    }

}

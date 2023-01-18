<?php

class Settings_page
{

    /**
     * Register the settings page for the admin area.
     *
     * @since    1.0
     */
    public function register_settings_page()
    {
        // Create our settings page as a submenu page.
        add_submenu_page(
            'tools.php',                             // parent slug
            __('Car Builder', 'builder-tools'),      // page title
            __('Car Builder', 'builder-tools'),      // menu title
            'manage_options',                        // capability
            'builder-tools',                           // menu_slug
            array($this, 'display_settings_page')  // callable function
        );
    }

    /**
     * Display the settings page content for the page we have created.
     *
     * @since    1.0
     */
    public function display_settings_page()
    {

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/admin-display.php';
    }
}

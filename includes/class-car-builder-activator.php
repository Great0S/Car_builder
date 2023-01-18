<?php
/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    car_builder
 * @subpackage car_builder/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    car_builder
 * @subpackage car_builder/includes
 * @author     GreatOS <greatos@outlook.com>
 */
class Car_Builder_Activator {

public static function activate($path) {
        $feedback = activate_plugin($path);
        if(is_wp_error($feedback)){
            echo 'Activation failed';
        }
}

}
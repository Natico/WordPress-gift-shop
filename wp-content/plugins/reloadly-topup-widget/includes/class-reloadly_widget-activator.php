<?php

/**
 * Fired during plugin activation
 *
 * @link       https://reloadly.com
 * @since      1.0.0
 *
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/includes
 * @author     Reloadly <hello@reloadly.com>
 */
class Reloadly_widget_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'reloadly_widget_table';
        $table_exists = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

        if (!$wpdb->get_var($table_exists) == $table_name) {

            $charset_collate = $wpdb->get_charset_collate();

            $sql = "CREATE TABLE $table_name (
                    `id` INT NOT NULL , `widget_id` TEXT(1500) NOT NULL, PRIMARY KEY (`id`)
                ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );


            // Insert row 0
            $insert = $wpdb->insert( $table_name, array( 'id' => '0', 'widget_id' => ''));
            dbDelta( $insert );

        }

	}

}

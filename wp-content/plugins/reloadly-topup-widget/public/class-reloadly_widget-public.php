<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://reloadly.com
 * @since      1.0.0
 *
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/public
 * @author     Reloadly <hello@reloadly.com>
 */
class Reloadly_widget_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Reloadly_widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Reloadly_widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        global $wpdb;

        $table_name = $wpdb->prefix . 'reloadly_widget_table';

        $table_exists = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

        if ($wpdb->get_var($table_exists) == $table_name) {

            // Select
            $results = $wpdb->get_results("SELECT * FROM  $table_name WHERE id = 0");
            $results = $results[0];

            if (strlen($results->widget_id) > 0 ) {

                wp_enqueue_script('ReloadlyWidget','https://cdn.reloadly.com/widget/v2/reloadly-widget.js', false, false, true);
            }

        }

    }

    public function add_data_attribute($tag, $handle, $src) {
        if ( 'ReloadlyWidget' !== $handle )
            return $tag;


        global $wpdb;

        $table_name = $wpdb->prefix . 'reloadly_widget_table';

        $table_exists = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );

        if ($wpdb->get_var($table_exists) == $table_name) {

            // Select
            $results = $wpdb->get_results("SELECT * FROM  $table_name WHERE id = 0");
            $results = $results[0];

            if (strlen($results->widget_id) > 0 ) {

				echo $tag;

				return $tag = '<reloadly-widget data-widget-id="' . $results->widget_id . '"></reloadly-widget>';
            }

        }

        return $tag;
    }

}

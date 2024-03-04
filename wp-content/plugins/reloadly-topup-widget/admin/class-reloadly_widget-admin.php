<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://reloadly.com
 * @since      1.0.0
 *
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Reloadly_widget
 * @subpackage Reloadly_widget/admin
 * @author     Reloadly <hello@reloadly.com>
 */
class Reloadly_widget_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

        //get the current screen
        $screen = get_current_screen();

        //return if not plugin settings page
        if ( $screen->id !== 'toplevel_page_reloadly-widget') return;

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/reloadly_widget-admin.css', array(), $this->version, 'all' );
        // Css rules for Color Picker
        wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
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

         //get the current screen
        $screen = get_current_screen();

        //return if not plugin settings page
        if ( $screen->id !== 'toplevel_page_reloadly-widget') return;

        wp_enqueue_script( 'wp-color-picker');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/reloadly_widget-admin.js', array(), $this->version, false );
    }

    /**
     * Register the page name on the admin menu
     *
     */
    public function reloadly_custom_menu_item() {

            add_menu_page(  'Reloadly Plugin > Settings',
                            'Reloadly Plugin',
                            'manage_options',
                            'reloadly-plugin',
                            array($this, "reloadly_admin_page") ,
                            "https://cdn.reloadly.com/favicon-wp.ico",
                            30);
    }


    public function reloadly_widget_admin_notice() {

        //get the current screen
        $screen = get_current_screen();

        //return if not plugin settings page
        if ( $screen->id !== 'toplevel_page_reloadly-widget') return;

        //if settings updated successfully
        if ( isset($_POST['submit']) ) { ?>

            <div class="notice notice-success is-dismissible">
                <p><?php _e('Settings saved.', 'reloadly_widget') ?></p>
            </div>

        <?php
        }

    }


    public function reloadly_admin_page(){

        global $wpdb;

        $table_name = $wpdb->prefix . 'reloadly_widget_table';


        // Select
        $results = $wpdb->get_results("SELECT * FROM  $table_name WHERE id = 0");
        $results = $results[0];

        if(isset($_POST['submit'])) {

            // Insert
            $update = $wpdb->update(
                $table_name,
                array(
                    'id' => '0',
                    'widget_id' => sanitize_text_field(str_replace(' ', '', $_POST['widgetScript']))
                ),
                array(
                    'id' => '0'
                )
            );

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $update );

            $results->widget_id = esc_textarea($_POST['widgetScript']);

        } ?>

        <div class="wrap">
            <h2>Reloadly plugin</h2>
            <p class="description" id="tagline-description">
            Steps to fallow in order to connect the Reloadly plugin to your website:<br/>
            1. Go to <a href="http://reloadly.com" target="_blank">http://reloadly.com</a> and log into your account<br/>
            2. Navigate to <em>Developers>Plugin</em> settings page<br/>
            3. Copy your plugin id<br/>
            4. Paste it in the field below and click <em>Save</em>.</p>
        <div>
        </div>
            <table class="form-table" role="presentation">
                <tbody>
                    <form  action="" method="POST">
                        <tr>
                            <th scope="row">
                                <label for="widgetScript">Plugin ID:</label>
                            </th>
                            <td>
                                <input name="widgetScript" type="text" id="widgetScript" class="regular-text" value="<?php echo $results->widget_id ?> ">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
                            </th>
                        </tr>
                    </form>
                </tbody>
            </table>
        </div>
        <?php
    }

}

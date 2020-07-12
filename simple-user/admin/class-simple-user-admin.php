<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/kanafghan
 * @since      1.0.0
 *
 * @package    Simple_User
 * @subpackage Simple_User/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_User
 * @subpackage Simple_User/admin
 * @author     Ismail Faizi <kanafghan@gmail.com>
 */
class Simple_User_Admin {

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
		 * defined in Simple_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-user-admin.css', array(), $this->version, 'all' );

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
		 * defined in Simple_User_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_User_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-user-admin.js', array( 'jquery' ), $this->version, true );

		$create_user_nonce = wp_create_nonce( 'create_user' );
		wp_localize_script( $this->plugin_name, 'simple_user_ajax', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => $create_user_nonce,
		) );

	}

	public function add_menu() {
		add_users_page(
			__( 'Add Simple User', $this->plugin_name ),
			__( 'Add Simple User', $this->plugin_name ),
			'create_users',
			'simple-user-manager',
			array( $this, 'users_page' )
		);
	}

	public function users_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/simple-user-admin-display.php';
	}

	public function create_user_ajax_handler() {
		check_ajax_referer( 'create_user' );
		try {
			$first_name = sanitize_text_field($_POST['first_name']);
			$last_name = sanitize_text_field($_POST['last_name']);
			$role = sanitize_text_field($_POST['role']);

			if (empty($first_name) || empty($last_name) || empty($role)) {
				wp_send_json_error(array( 'error' => 'Invalid or empty first name, last name or role!'), 400);

				return;
			}

			$result = $this->create_user($first_name, $last_name, $role);

			if ($result === TRUE) {
				wp_send_json_success();
			} else {
				wp_send_json_error(array( 'error' => $result), 500);
			}
		} catch (Exception $e) {
			wp_send_json_error(array( 'error' => $e->getMessage()), 500);
		}
	}

	protected function create_user($first_name, $last_name, $role) {
		$username = $this->generate_username($first_name, $last_name);
		$password = $this->generate_password();
		$email_address = $this->generate_email($username);

		$userdata = array(
			'user_pass'    => $password,
			'user_login'   => $username,
			'user_email'   => $email_address,
			'display_name' => $first_name . ' ' . $last_name,
			'first_name'   => $first_name,
			'last_name'    => $last_name,
			'role'         => $role,
		);

		$result = wp_insert_user($userdata);
		if (is_wp_error($result)) {
			return $result->get_error_message();
		}

		return TRUE;
	}

	protected function generate_username($first_name, $last_name) {
		$chars = strtolower(preg_replace('/[^a-z]+/i', '', $first_name . $last_name));

		$username = $this->generate_random_string($chars);
		while (username_exists($username)) {
			$username = $this->generate_random_string($chars);
		}

		return $username;
	}

	protected function generate_password() {
		return wp_generate_password();
	}

	protected function generate_email($username) {
		return $username . '@simpleuser.net';
	}

	private function generate_random_string($chars, $length = 10) {
		$total = strlen($chars);
		$random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $chars[rand(0, $total - 1)];
		}

        return $random_string;
    }
}

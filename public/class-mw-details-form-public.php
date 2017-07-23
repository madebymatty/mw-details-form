<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.madebymatty.com
 * @since      1.0.0
 *
 * @package    Mw_Details_Form
 * @subpackage Mw_Details_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mw_Details_Form
 * @subpackage Mw_Details_Form/public
 * @author     Matt Woods <mjaywoods@gmail.com>
 */
class Mw_Details_Form_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/main.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mw-details-form-public.js', array( 'jquery' ), $this->version, false );

	}

    public function mw_details_form_update(){

        function mw_shortcode($atts, $content, $submit = null){

            extract( shortcode_atts( array(), $atts ) );

            global $user_ID;
            $user = get_currentuserinfo();

            if ($user_ID) {

                $user_info = get_userdata($user_ID);
                $username = $user_info->user_login;
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
                $user_email = $user_info->user_email;
                $user_twitter = $user_info->twitter_handle;
                $birthday_month = $user_info->birthday_month;

                if(isset($submit['fieldData'])) {
                    $first_name = $submit['fieldData']['firstname'];
                    $last_name = $submit['fieldData']['lastname'];
                    $user_email = $submit['fieldData']['email'];
                }

                for($m = 1;$m <= 12; $m++){
                    $months[$m] =  date("F", mktime(0, 0, 0, $m));
                }

                ob_start();
                include_once( 'partials/mw-details-form-form.php' );
                $string = ob_get_clean();

            } else {
                $string = 'Access Denied';
            }

            return $string;
        }

        function register_shortcode($atts, $content = null) {
            $postData = submit_form();
            $string = mw_shortcode($atts, $content, $postData);
            return $string;
        }

        function submit_form() {

            if ( isset( $_POST['mw-submitted'] ) && $_SERVER["REQUEST_METHOD"] == "POST" ) {
                global $user_ID;
                $user = get_currentuserinfo();

                // sanitize form values
                $firstnameData = sanitize_text_field( $_POST["cf-firstname"] );
                $lastnameData = sanitize_text_field( $_POST["cf-lastname"] );
                $emailData = sanitize_email( $_POST["cf-email"] );
                $twitterData = sanitize_text_field( $_POST["cf-twitter"] );
                $birthdayMonthData = sanitize_text_field( $_POST["cf-birthdaymonth"] );

                $fieldData = array(
                    'firstname' => $firstnameData,
                    'lastname' => $lastnameData,
                    'email' => $emailData,
                    'twitter' => $twitterData,
                    'birthdayMonth' => $birthdayMonthData
                );

                if (!isset($_POST['cf-firstname']) || empty($_POST['cf-firstname'])) {
                    $errors[] = 'You need to add a first name';
                } else {
                    $firstname = get_user_meta( $user_ID, 'first_name', true );
                    if ( isset($firstname) ){
                        update_user_meta($user_ID, "first_name", $firstnameData );
                    } else {
                        add_user_meta( $user_ID, 'first_name', $firstnameData);
                    }
                }

                if (!isset($_POST['cf-lastname']) || empty($_POST['cf-lastname'])) {
                    $errors[] = 'You need to add a last name';
                } else {
                    $lastname = get_user_meta( $user_ID, 'last_name', true );
                    if ( isset($lastname) ){
                        update_user_meta($user_ID, "last_name", $lastnameData );
                    } else {
                        add_user_meta( $user_ID, 'last_name', $lastnameData);
                    }
                }

                if (!isset($_POST['cf-email']) || empty($_POST['cf-email'])) {
                    $errors[] = 'You need to add a email address';
                } else {
                    $email = get_user_meta( $user_ID, 'email', true );
                    if ( isset($email) ){
                        update_user_meta($user_ID, "email", $emailData );
                    } else {
                        add_user_meta( $user_ID, 'email', $emailData);
                    }
                }

        		$twitter = get_user_meta( $user_ID, 'twitter_handle', true );
                if ( isset($twitter) ){
                    update_user_meta($user_ID, "twitter_handle", $twitterData );
                } else {
                    add_user_meta( $user_ID, 'twitter_handle', $twitterData);
                }

                $birthdayMonth = get_user_meta( $user_ID, 'birthday_month', true );
                if ( isset($birthdayMonth) ){
                    update_user_meta($user_ID, "birthday_month", $birthdayMonthData );
                } else {
                    add_user_meta( $user_ID, 'birthday_month', $birthdayMonthData);
                }

                if(isset($errors)) {
                    return array(
                        'errors' => $errors,
                        'fieldData' => $fieldData
                    );
                } else {
                    return array(
                        'fieldData' => $fieldData,
                        'success' => TRUE
                    );
                }
            }
        }
        add_shortcode("mw-details-form", "register_shortcode");
   }
}

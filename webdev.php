<?php
/*
Plugin Name: WebDev AJAX
Plugin URI: http://#
Description: Quick AJAX Tutorial
Version: 0.1a
Author: Anonymous
Author URI: http://#
*/

class WebDev {
	function hooks(){
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_webdev', array( $this, 'handle_ajax' ) );
		add_action( 'wp_ajax_nopriv_webdev', array( $this, 'handle_ajax' ) );

		add_shortcode( 'webdev_tut', array( $this, 'shortcode_output' ) );
	}

	function handle_ajax(){
		if( ! wp_verify_nonce( $_REQUEST['nonce'], 'webdev' ) ){
			wp_send_json_error();
		}

		wp_send_json_success( array(
			'script_response' => 'AJAX Request Recieved',
			'nonce'           => wp_create_nonce( 'webdev' ),
		) );
	}

	function enqueue_scripts(){
		wp_enqueue_script( 'webdev_js', plugins_url( '/js/webdev.js', __FILE__ ), array( 'jquery' ), '1.0', true );
		wp_localize_script( 'webdev_js', 'webdev', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'nonce'	   => wp_create_nonce( 'webdev' ),
		) );
	}

	function shortcode_output( $atts ){
		$output  = '<form action="" method="POST" class="ajax_tut_form">';
		$output .= '	<input type="text" name="ajax_tut">';
		$output .= '	<input type="submit" value="submit">';
		$output .= '</form>';

		return $output;
	}
}
$web_dev_plugin = new WebDev();
$web_dev_plugin->hooks();
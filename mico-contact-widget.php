<?php
/*
Plugin Name: Mico Contact Widget
Plugin URI: http://www.mico.dk
Description: A simple widget that allows you to display an optional image with a title, name, phone number and email address.
Author: Malthe Milthers
Version: 0.1.0
Author URI: http://www.malthemilthers.dk
Text Domain: mico-contact-widget
*/

// Require the widget class.
require('class-contact-info.php');

// Load the text domain
add_action( 'plugins_loaded', function() {
	$domain = 'mico-contact-widget';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	$fullpath = dirname( basename( plugins_url() ) ) . '/' . basename(dirname(__FILE__))  . '/languages/';

	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, false, $fullpath );
});

// Enqueue scripts
add_action('admin_enqueue_scripts', function() {
	// Make sure the media select styles and scripts are enqueued.
	wp_enqueue_media();
	wp_enqueue_script('contact-widget-js', plugin_dir_url(__FILE__) . '/assets/js/contact-widget.js', array('jquery'));
	
	$translations = array(
		'remove_image' => __('Remove Image', 'mico-contact-widget'),
		);

	wp_localize_script( 'contact-widget-js', 'translations', $translations );

});

// Register the widget with WordPress
add_action( 'widgets_init', function(){
	register_widget( 'mico\widget\contact_info' );
} );
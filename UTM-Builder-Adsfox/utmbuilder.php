<?php
/**
  * Plugin Name: UTM Builder Ads Fox
  * Author: Adsfox.com
  * Author URI:https://adsfox.com/
  * Description: UTM Parameter for created short links
  * Tags: UTM Builder
  * Version: 1.0
  * License: GPLv2 or later
  * License URI: http://www.gnu.org/licenses/gpl-2.0.html

 **/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define("mt_utmadfox_root", plugin_dir_url( __FILE__ ));
define("mt_utmadfox_root_include", plugin_dir_path(__FILE__));
define("mt_utmadfox_ajax_url", admin_url('admin-ajax.php'));


if (  is_admin() ) {

	register_activation_hook ( __FILE__, 'mt_utmadfox_on_activate' );

	  function mt_utmadfox_on_activate() {
	  global $wpdb;
	  $create_table_query = "
	        CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}mt_utmadfox` (
	          `id` bigint(20) NOT NULL AUTO_INCREMENT,
	          `shorturl` text NOT NULL,
	          `longurl` text NOT NULL,
						PRIMARY KEY  (id)
	        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
	  ";
	  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	  dbDelta( $create_table_query );
	  }

		// custom css and js
		add_action('admin_enqueue_scripts', 'adfox_css_and_js');

		function adfox_css_and_js($hook) {

		    if ( 'toplevel_page_mt-utmadfox-dashboard' != $hook ) {
		        return;
		    }

		    wp_enqueue_style('mt_boot_css', plugins_url('static/bootstrap.css',__FILE__ ));
		    wp_enqueue_script('mt_ang_js', plugins_url('static/angular.js',__FILE__ ));
				wp_enqueue_script('mt_main_js', plugins_url('static/main.js',__FILE__ ));
		}



		require plugin_dir_path(__FILE__) . 'class/menu.php';
		require plugin_dir_path(__FILE__) . 'ajax/ajax.php';


}

if(!is_admin()){
	$mt_base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
	$mt_url = $mt_base_url . $_SERVER["REQUEST_URI"];

	global $wpdb;
	$wpdb_prefix = $wpdb->prefix;
	$wpdb_tablename = $wpdb_prefix.'mt_utmadfox';
	$result = $wpdb->get_results('SELECT longurl FROM '. $wpdb_tablename . ' WHERE shorturl="'.$mt_url.'"');
	if(count($result) !== 0){
		header('Location: '.$result[0]->longurl);
		exit;
	}

}

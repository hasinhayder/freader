<?php
include_once("lib/superfeedr/superfeedr.php");
/**
 * Scripts And Stylesheets
 */
add_filter("wp_enqueue_scripts","scripts_and_styles");
function scripts_and_styles(){
	
	wp_register_script( "modernizer", "//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js", "jquery", null );
	wp_register_script( "app-js", get_template_directory_uri(). "/js/main.js", "jquery", null );
	
	wp_enqueue_script( "jquery" );
	wp_enqueue_script( "modernizer" );
	wp_enqueue_script( "app-js" );

	wp_enqueue_style( "app-style", get_template_directory_uri()."/css/app.css" );
	wp_enqueue_style( "lato", '//fonts.googleapis.com/css?family=Lato:400', false, null);


}

/* Hide admin bar during development */
show_admin_bar( false );


/**
 * Superfeedr feed subscription Ajax Callback for admin
 */
function subscribe_feed(){
	$username = 'ironhide'; // your superfeedr username
	$password = 'c0mm0n123'; // your superfeedr password
	$callback = admin_url("admin-ajax.php")."?action=feed_subscription_callback"; // your callback URL
	//$callback = "http://reader.themio.net/wp-admin/admin-ajax.php?action=feed_subscription_callback"; // your callback URL
	$feed =  $_REQUEST['feed']; //'http://hasin.me/feed';

	$superfeedr = new Superfeedr($username, $password, $callback);
	try{
		if ($superfeedr->subscribe($feed)) {
			die(1);
		}
	}catch(Exception $e){}
	die();
}

/**
 * Superfeedr subscription callback for echoing hub challenge to complete the subscription process
 */
function feed_subscription_callback(){
	$username = 'ironhide'; // your superfeedr username
	$password = 'c0mm0n123'; // your superfeedr password
	$callback = admin_url("admin-ajax.php")."?action=feed_subscription_callback"; 
	$superfeedr = new Superfeedr($username, $password, $callback);
	$superfeedr->verify();
	die();
}

/**
 * Superfeedr new feed callback
 */
function incoming_feed(){
	$username = ''; // your superfeedr username
	$password = ''; // your superfeedr password
	$callback = admin_url("admin-ajax.php")."?action=feed_subscription_callback"; // your callback URL

	$superfeedr = new Superfeedr($username, $password, $callback);

	if (!$res = $superfeedr->verify()) {
		$json = $superfeedr->callback();
	    //now process this json
	    file_put_contents("/root/data/feed.txt", $json);
	}
}

add_action("wp_ajax_subscribe_feed", "subscribe_feed");
add_action("wp_ajax_nopriv_subscribe_feed", "subscribe_feed");
add_action("wp_ajax_nopriv_feed_subscription_callback", "feed_subscription_callback");
add_action("wp_ajax_feed_subscription_callback", "feed_subscription_callback");
add_action("wp_ajax_nopriv_incoming_feed", "incoming_feed");


/**
 * Feed parser routine with the help of google feed parser API
 */
function parse_feed($feed, $count=10){
	$feed = urlencode($feed);
	$gfeed_parse_url = "http://www.google.com/uds/Gfeeds?num={$count}&hl=en&output=json&q={$feed}&v=1.0";
	$json = json_decode(file_get_contents($gfeed_parse_url),true);
	file_put_contents("/root/data/feed.txt", $json);
	return  $json["responseData"]["feed"];
}

/**
 * Theme activation hook. Create necessary DB Tables
 */
function theme_activated($oldname,$oldtheme){
	global $wpdb;
	$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}freader_summary (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`tag_id` int(11) DEFAULT NULL,
		`tag_name` varchar(250) DEFAULT NULL,
		`tag_url` varchar(250) DEFAULT NULL,
		`modified` int(11) DEFAULT NULL,
		`unread` int(11) DEFAULT NULL,
		`total` int(11) DEFAULT NULL,
		`created` int(11) DEFAULT NULL,
		PRIMARY KEY (`id`),
		KEY `tag_id` (`tag_id`),
		KEY `tag_name` (`tag_name`),
		KEY `modified` (`modified`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
	$wpdb->query($sql);
}

add_action("after_switch_theme", "theme_activated", 10 ,  2);

?>
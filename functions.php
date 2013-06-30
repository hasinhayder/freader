<?php
include_once("lib/superfeedr/superfeedr.php");
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

show_admin_bar( false );

function subscribe_feed(){
	$username = ''; // your superfeedr username
	$password = ''; // your superfeedr password
	$callback = get_site_url(); // your callback URL
	$feed =  $_REQUEST['feed']; //'http://hasin.me/feed';

	$superfeedr = new Superfeedr($username, $password, $callback);
	try{
		if ($superfeedr->subscribe($feed)) {
			die(1);
		}
	}catch(Exception $e){}
}

function feed_subscription_callback(){
	die($_REQUEST['hub_challenge']);
}

add_action("wp_ajax_subscribe_feed", "subscribe_feed");
add_action("wp_ajax_nopriv_feed_subscription_callback", "feed_subscription_callback");

function parse_feed($feed, $count=10){
	$feed = urlencode($feed);
	$gfeed_parse_url = "http://www.google.com/uds/Gfeeds?num={$count}&hl=en&output=json&q={$feed}&v=1.0";
	$json = json_decode(file_get_contents($gfeed_parse_url),true);
	return  $json["responseData"]["feed"];
}

?>
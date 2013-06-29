<?php
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
?>
<?php
/*
Plugin Name: Facebook Live Chat
Description: Add Facebook Messenger Live Chat to your site.
Version:     1.0
Author:      Lewis Boyles-White
*/
if ( ! defined( 'ABSPATH' ) )
exit;
/*** 										SETUP AND OPTIONS 										***/
//Define IRIS color picker
  function color_picker_assets($hook_suffix) {
      // $hook_suffix to apply a check for admin page.
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'script-handle', plugins_url('/assets/js/colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
  }
  add_action( 'admin_enqueue_scripts', 'color_picker_assets' );
	//load external JS
	wp_register_script( 'slide_animations', plugins_url('/assets/js/main.js', __FILE__), array('jquery'));
	wp_enqueue_script( 'slide_animations' );
	wp_register_script( 'facebook', plugins_url('/assets/js/facebook.js', __FILE__));
	wp_enqueue_script( 'facebook' );
	//Add messenger options menu to main nav
  function gon_messenger_menu() {
  	add_menu_page( 'Facebook Live Chat Settings', 'FB Messenger Live Chat', 'manage_options', 'my-unique-identifier', 'gon_messenger_options' );
  }
	//Options page
  function gon_messenger_options() {
  	if ( !current_user_can( 'manage_options' ) )  {
  		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  	}
  	echo '<div class="wrap">';
		echo '<h1>Facebook Live Chat</h1>';
    echo '<form method="post" action="options.php">';
    settings_fields( 'gon_messenger_settings' );
    do_settings_sections( 'gon_messenger_settings' );
		echo '<table class="form-table">';
    echo '<tr valign="top">
		      	<th scope="row">Background Color</th>
		      	<td><input type="text" name="gon_background_color" value="' . esc_attr( get_option('gon_background_color') ) . '" class="gon-color-field" data-default-color="#0084ff" /></td>
		      </tr>';
		echo '<tr valign="top">
						<th scope="row">Icon Color</th>
						<td><input type="text" name="gon_icon_color" value="' . esc_attr( get_option('gon_icon_color') ) . '" class="gon-color-field" data-default-color="#ffffff" /></td>
					</tr>';
		echo '<tr valign="top">
						<th scope="row">Facebook page URL</th>
						<td><input type="text" name="gon_page_url" value="' . esc_attr( get_option('gon_page_url') ) . '" /></td>
					</tr>';
		echo '<tr valign="top">
						<th scope="row">Chat button text</th>
						<td><input type="text" name="gon_title" value="' . esc_attr( get_option('gon_title') ) . '" /></td>
					</tr>';
		echo '</table>';
    submit_button();
    echo '</form>';
  }
  //Add action for options page
  add_action( 'admin_menu', 'gon_messenger_menu' );
  //Create settings options
  function gon_settings(){
    register_setting('gon_messenger_settings' , 'gon_background_color');
		register_setting('gon_messenger_settings' , 'gon_icon_color');
    register_setting('gon_messenger_settings' , 'gon_page_url');
		register_setting('gon_messenger_settings' , 'gon_title');
  }
  add_action( 'admin_init', 'gon_settings' );
	/*** 										END SETUP AND OPTIONS 										***/
	/*** 										FRONTEND SETUP 										***/
	function gon_messenger_dependencies() {
 		wp_register_style( 'gon-messenger-style', plugins_url('assets/css/style.css', __FILE__) );
 		wp_enqueue_style( 'gon-messenger-style' );
 	}
 	add_action( 'wp_enqueue_scripts', 'gon_messenger_dependencies' );
	/*** 										END FRONTEND SETUP 										***/
	/*** 										FRONTEND SCRIPT AND HTML 										***/

	function gon_messenger(){ ?>
		<div id="gon-messenger-container">
			<div id="gon-messenger-header" style="background-color:<?php echo esc_attr( get_option('gon_background_color')); ?>;">
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 class="chat-icon" viewBox="0 0 224 226" enable-background="new 0 0 224 226" xml:space="preserve">
					<path fill="<?php echo esc_attr( get_option('gon_icon_color') ) ?>" d="M112,0C50.144,0,0,46.786,0,104.5c0,32.68,16.078,61.86,41.255,81.02v0v40.2l37.589-21.37
					C89.322,207.37,100.46,209,112,209c61.86,0,112-46.79,112-104.5C224,46.786,173.86,0,112,0z M123.33,139.83l-28.721-30.16
					l-54.97,30.16l60.401-63.952l28.99,29.632l54.36-29.632L123.33,139.83z"/>
				</svg>
				<span><?php echo esc_attr( get_option('gon_title') ); ?></span><span id="gon-toggle-button" class="gon-open"></span>
			</div>
			<div id="gon-messenger-body" class="gon-hide">
				<div class="fb-page" data-href="<?php echo get_option('gon_page_url'); ?>" data-tabs="messages" data-width="360px" data-height="360px" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false"><blockquote cite="<?php echo get_option('gon_page_url'); ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo get_option('gon_page_url'); ?>">View page</a></blockquote></div>
				<a class="powered-by" href="http://www.geekofnature.co.uk">Powered by Geek of Nature</a>
			</div>
		</div>
	<?php
	}
	add_action( 'wp_footer', 'gon_messenger', 10 );
	/***										 END FRONTEND SCRIPT AND HTML 										***/

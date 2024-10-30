<?php
	/**
	* Plugin Name: Mobile Phone Verification
	* Description: This is the first level qualification to address random registrations and provide your users a two factor authentication,You can position this API anywhere on your website or inside a form and customise the look and feel to suit the style of your website
	* Author: Identity Verification Services
	* Author URI: https://profiles.wordpress.org/identity-verification-services
	* Version: 1.0
	*/

	// Plugin Activation Block

	register_activation_hook( __FILE__,'mcv_activation');

	function mcv_activation(){
		global $wpdb;
		$table_name = $wpdb->prefix . "mcv_api_credentials";
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		     $sql = "CREATE TABLE $table_name (
		      credentials_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		      client_id VARCHAR(200) NOT NULL,
		      client_secret VARCHAR(200) NOT NULL,
		      auth_token VARCHAR(150),
		      redirect_url VARCHAR(200),
		      error_url VARCHAR(200)
		    );";
		    //reference to upgrade.php file
		    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		    dbDelta( $sql );
		}
		
		$mcv_verification_data = "IDV_mcv_verification_data";
		if($wpdb->get_var("SHOW TABLES LIKE '$mcv_verification_data'") != $mcv_verification_data) {
		     $sql = "CREATE TABLE $mcv_verification_data (
		      verification_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		      mobile_number VARCHAR(200) NOT NULL,
		      country VARCHAR(200) NOT NULL,
		      is_verified VARCHAR(150)
		    );";
		    //reference to upgrade.php file
		    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		    dbDelta( $sql );
		}
	}

	register_deactivation_hook( __FILE__,'mcv_deactivation');
	function mcv_deactivation(){
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix. "mcv_api_credentials");
		$wpdb->query("DROP Table IF EXISTS ".$wpdb->prefix."mcv_verification_data");
	}

	add_action('admin_menu',"mcv_admin_menu");
	function mcv_admin_menu(){
		add_menu_page("Mobile Cell Verification","Mobile Cell Verification",'manage_options','mcv_authentication',"mcv_authentication");
		add_submenu_page('mcv_authentication',"Verified Mobiles","Verified Mobiles",'manage_options','verified_mobiles',"verified_mobiles");
		add_submenu_page('mcv_authentication',"Non-Verified Mobiles","Non-Verified Mobiles",'manage_options','non_verified_mobiles',"non_verified_mobiles");
		
	}


	// Verified Users List will be displayed

	function verified_mobiles(){
		global $wpdb;
		$type_users="Verified Mobiles";
		$verified_users=$wpdb->get_results("select * from IDV_mcv_verification_data where is_verified=1");
		
		include("verified_mobiles.php");
	}


	// Non Verified Users list will be displayed

	function non_verified_mobiles(){
		global $wpdb;
		$type_users="Non-Verified Mobiles";
		$verified_users=$wpdb->get_results("select * from IDV_mcv_verification_data where is_verified=0");
		include("verified_mobiles.php");
	}

	function mcv_authentication(){
		global $wpdb;

		if($_POST){
			$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
			if(count($api_credentials)>0)
				$wpdb->query("update ".$wpdb->prefix."mcv_api_credentials set client_id='".$_POST['client_id']."',client_secret='".$_POST['client_secret']."',redirect_url='".$_POST['redirect_url']."',error_url='".$_POST['error_url']."' where credentials_id=".$api_credentials[0]->credentials_id);
			else	
			$wpdb->insert($wpdb->prefix ."mcv_api_credentials",$_POST);
		}
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
		include("api_credentials_form.php");
		
	}


	function mcv_information(){
		global $wpdb;
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
		
		include("mcv_information_form.php");
	}

	function mcv_sendPostData_api($url, $post){
		  $ch = curl_init($url);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		  $resulty = curl_exec($ch);
		  curl_close($ch);  // Seems like good practice
		  return json_decode($resulty);
	}
	add_action("wp_ajax_mcv_country_code", "mcv_country_code");
	add_action("wp_ajax_nopriv_mcv_country_code", "mcv_country_code");


	function mcv_country_code(){
		$country_code=mcv_sendPostData_api("https://api.identityverification.com/get_verified/get_country_code",json_encode(array("country"=>$_POST['country'])));
		
		echo json_encode($country_code);
		exit;
	}

	
	// Style Sheets

	add_action('wp_enqueue_scripts', 'mcv_styles');
	function mcv_styles() { 
		wp_register_style('mcv_style_name', plugins_url('css/mcv_style.css', __FILE__));
		wp_enqueue_style('mcv_style_name');
		
	}

	add_action('admin_enqueue_scripts', 'mcv_styles');
	// Scripts

	add_action('wp_enqueue_scripts', 'mcv_scripts');
	function mcv_scripts() { 
		wp_enqueue_script('jquery');
		?>
<script>
	var site_url='<?php echo site_url()?>'
</script/>
	<?php
		wp_register_script('mcv_script', plugins_url('js/mcv_scripts.js', __FILE__));

		wp_enqueue_script('mcv_script');
		
	}


	// Ajax call to send SMS Code to Phone Number

	add_action("wp_ajax_mcv_send_sms", "mcv_send_sms_function");
	add_action("wp_ajax_nopriv_mcv_send_sms", "mcv_send_sms_function");

	function mcv_send_sms_function(){
		global $wpdb;
		$url='https://api.identityverification.com/get_verified/get_auth_token/';
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
		$config_auth['client_id']=$api_credentials[0]->client_id;
		$config_auth['client_secret']=$api_credentials[0]->client_secret;
		
		$auth_token_result=mcv_sendPostData_api($url,json_encode($config_auth));


		// Mobile Number Verification 
		$_POST['auth_token']=$auth_token_result->auth_token;

		$mobile_verification_url='https://api.identityverification.com/get_verified/mobile';
		$mobile_authentication_response=mcv_sendPostData_api($mobile_verification_url,json_encode($_POST));
		echo $result=json_encode($mobile_authentication_response);
		exit;
	}

	// Ajax call to Verify SMS Code With Phone Number

	add_action("wp_ajax_mcv_send_sms_verify", "mcv_send_sms_verify_function");
	add_action("wp_ajax_nopriv_mcv_send_sms_verify", "mcv_send_sms_verify_function");
	function mcv_send_sms_verify_function(){
		global $wpdb;
		$url='https://api.identityverification.com/get_verified/get_auth_token/';
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
		$config_auth['client_id']=$api_credentials[0]->client_id;
		$config_auth['client_secret']=$api_credentials[0]->client_secret;
		
		$auth_token_result=mcv_sendPostData_api($url,json_encode($config_auth));
		$_POST['auth_token']=$auth_token_result->auth_token;
		$mobile_cod_verification_url='https://api.identityverification.com/get_verified/sms';
		
		$mobile_code_authentication_response=mcv_sendPostData_api($mobile_cod_verification_url,json_encode($_POST));
		//echo "<pre>";print_r($mobile_code_authentication_response);
		$verified_data=array(
						'mobile_number'=>$mobile_code_authentication_response->mobile_number,
						'country'=>$mobile_code_authentication_response->country,
						'is_verified'=>($mobile_code_authentication_response->is_mobile_number_verified==1?'1':'0'),
					);
		$wpdb->insert("IDV_mcv_verification_data",$verified_data);
		//echo json_encode($mobile_code_authentication_response);
		$site_url=site_url();
		$redirect_url=$api_credentials[0]->redirect_url;
		$error_url=$api_credentials[0]->error_url;
		include("thankyou.php");
		exit;
	}

	// Ajax call to Resend SMS Code

	add_action("wp_ajax_mcv_resend", "mcv_resend_function");
	add_action("wp_ajax_nopriv_mcv_resend", "mcv_resend_function");
	function mcv_resend_function(){
		global $wpdb;
		$url='https://api.identityverification.com/get_verified/get_auth_token/';
		$api_credentials=$wpdb->get_results("select * from ".$wpdb->prefix ."mcv_api_credentials");
		$config_auth['client_id']=$api_credentials[0]->client_id;
		$config_auth['client_secret']=$api_credentials[0]->client_secret;
		
		$auth_token_result=mcv_sendPostData_api($url,json_encode($config_auth));
		$_POST['auth_token']=$auth_token_result->auth_token;
		$mobile_cod_verification_url='https://api.identityverification.com/get_verified/resend_sms';
		
		$mobile_code_authentication_response=mcv_sendPostData_api($mobile_cod_verification_url,json_encode($_POST));
		echo json_encode($mobile_code_authentication_response);
		exit;
	}
	
	add_shortcode( 'IVS_MOBILE_VERIFICATION', 'mcv_information' );

?>
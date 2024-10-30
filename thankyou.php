<?php
/**
* Template Name:Thank You Page
* Description:This will page return the result
*/
global $wpdb;


$response=$mobile_code_authentication_response;

?>

	<div class="content-element-1">
		<div id="content">
			<?php
			if($response->status=='Invalid'){
			?>
				<div style="padding:10px;marign-bottom:5px;">
					<h3><?php echo $response->message?></h3>
				</div>
			<?php
			}if($response->status=='valid'){
			?>
			<div class="main-form-plg mobls">
				<div class="ivs-form response-tbl-ivs">
					<h5 style="text-align:center;">Your Mobile Number Verification details</h5>
					<div><span>Mobile Number:</span><span><?php echo ucwords(str_replace("_"," ",$response->mobile_number))?></span>	</div>
					<div><span>Status:</span><span><?php echo ($response->is_mobile_number_verified=='true'?'<img src="'.plugins_url("images/icons/tick_105.png" , __FILE__).'">':'<img src="'.plugins_url("images/icons/close-icon.gif" , __FILE__).'" style="width:19px;height:19px">')?></span>	</div>
				
					<div>
						<form action="<?php echo ($response->is_mobile_number_verified=='true'?$redirect_url:$error_url)?>" method="post"  style ="text-align:center">
							<input type="hidden" value='<?php echo json_encode($response)?>' name="response">
							<button type="submit">CONTINUE</button>
						</form>	
					</div>
				</div>
			</div>

			
			<?php
			}
			?>
		</div>
	</div>



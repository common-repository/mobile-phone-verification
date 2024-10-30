jQuery(document).ready(function(){


	
	jQuery("#country_name").change(function(){
		jQuery(".loader_image").css("display","block");
		jQuery("body").css("opacity",'0.5');
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=mcv_country_code',
			type:'post',
			data:'country='+jQuery(this).val(),
			success:function(result){
					jQuery(".loader_image").css("display","none");
					jQuery("body").css("opacity",'1');
				var d = JSON.parse(result);
				jQuery("#mcv_code").val("+"+d.country_code);
			}
		})
	});
	jQuery("#verify_mcv").click(function(){
			var regex_number=/^[0-9]+$/;
		if(jQuery("#country_name").val()==''){
			jQuery("#country_name").css("border","1px solid red");
			jQuery("#country_name").focus();
			jQuery(".err_country").text("Please Select Country");
			return false;

		}else{
			jQuery("#country_name").css("border","1px solid #dfdfdf");
			jQuery(".err_country").text("");	
		}
		if(jQuery("#mobile_number").val()==''){
			jQuery("#mobile_number").css("border","1px solid red");
			jQuery("#mobile_number").focus();
			jQuery(".err_number").text("Please Enter Mobile Number to be verified");
			return false;

		}
		if(!regex_number.test(jQuery("#mobile_number").val())){
			
			jQuery("#mobile_number").css("border","1px solid red");
			jQuery("#mobile_number").focus();
			jQuery(".err_number").text("Please Enter Valid Format of Mobile Number to be verified");			
			return false;
		}
		else{
			jQuery("#mobile_number").css("border","1px solid #dfdfdf");
			
			jQuery(".err_number").text("");

		}
	
	
		jQuery(".loader_image").css("display","block");
		jQuery("body").css("opacity",'0.5');
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=mcv_send_sms',
			type:'post',
			data:'country='+jQuery("#country_name").val()+"&mobile_number="+jQuery("#mobile_number").val(),
			success:function(result_mcv){
				
				jQuery(".loader_image").css("display","none");
				jQuery("body").css("opacity",'1');
				var d = JSON.parse(result_mcv);
				jQuery("#mobile_number_result").val(d.mobile_number);
				jQuery("#country_result").val(d.country);
				if(d.status=='Invalid'){
					jQuery(".ivs-message").slideDown("slow");
					
					jQuery(".ivs-message").text(d.message);
				}else{
					jQuery(".result_mcv").css("display","block");
					jQuery(".ivs-message").slideDown("slow");
					
					jQuery(".ivs-message").text("Verification Code has been sent your Mobile Number");
				}
				//$(".result_mcv").html(result_mcv);
			}
		})

	});
	jQuery("#verify_mcv_code").click(function(){
		var regex_number=/^[0-9]+$/	;
		if(jQuery("#sms_code").val()==''){
			jQuery("#sms_code").css("border","1px solid red");
			jQuery("#err_sms_code").css("color","red");
			jQuery("#sms_code").focus();
			jQuery(".err_sms_code").text("Please Enter SMS Code");
			return false;
		}
		else if(!regex_number.test(jQuery("#sms_code").val())){
			jQuery("#sms_code").css("border","1px solid red");
			jQuery("#err_sms_code").css("color","red");
			jQuery("#sms_code").focus();
			jQuery(".err_sms_code").text("Please Enter Valid SMS Code");
			return false;
		}
		else{
			jQuery("#sms_code").css("border","1px solid #dfdfdf");
			
			jQuery(".err_sms_code").text("");

		}
		jQuery(".loader_image").css("display","block");
		jQuery("body").css("opacity",'0.5');
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=mcv_send_sms_verify',
			type:'post',
			data:'country='+jQuery("#country_result").val()+"&mobile_number="+jQuery("#mobile_number_result").val()+"&sms_code="+jQuery("#sms_code").val(),
			success:function(result_mcv){
				
				jQuery(".loader_image").css("display","none");
				jQuery("body").css("opacity",'1');
				jQuery(".result_mcv").css("display","none");
				jQuery(".ivs-inner-form").slideUp("slow");
				jQuery(".ivs-message").slideUp("slow");	
				jQuery(".ivs-message").text("");	
				jQuery(".result").slideDown("slow");
				jQuery(".result").html(result_mcv);
				/*var d = JSON.parse(result_mcv);
				$(".ivs-message").slideDown("slow");
				if(d.status=='valid'){
					$(".ivs-message").text("Your Mobile number is verified");	
					$(".result_mcv").css("display","none");
				}else{
					$(".ivs-message").text("Failed to Verify your number");
				}*/
				//$(".result_msg").text(result_mcv);
			}
		})
	});
	/*$("#sms_code").keyup(function(){
		$(".ivs-message").slideUp("slow");
	});*/
	jQuery(".resend_sms").click(function(){
		jQuery(".loader_image").css("display","block");
		jQuery("body").css("opacity",'0.5');
		jQuery.ajax({
			url:site_url+'/wp-admin/admin-ajax.php?action=mcv_resend',
			type:'post',
			data:'country='+jQuery("#country_result").val()+"&mobile_number="+jQuery("#mobile_number_result").val(),
			success:function(result_mcv){
				jQuery(".ivs-message").html(result_mcv);
				
				jQuery(".loader_image").css("display","none");
				jQuery("body").css("opacity",'1');
				jQuery(".ivs-message").slideDown("slow");
				var d = JSON.parse(result_mcv);
				if(d.status=='valid'){
					jQuery(".ivs-message").text("Verification Code has been re-sent to your Mobile Number");	
					jQuery(".result_mcv").slideDown("slow");
				}else{
					jQuery(".ivs-message").text("Failed to Send Verification Code");
				}
				//$(".result_msg").text(result_mcv);
			}
		})
	});
})
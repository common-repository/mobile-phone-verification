	<img src="<?php echo plugins_url('/images/loader.gif' , __FILE__)?>" style="display:none" class="loader_image">

	<?php

	if(count($api_credentials)>0 && in_array  ('curl', get_loaded_extensions())){
	?>
	<div class="main-form-plg mobls">
		<div class="ivs-form">
		<h5>Mobile Verification</h5>
		<div class="ivs-message alert-static"></div>
			<form action="" method="post">
			<div class="ivs-inner">
			<div class="ivs-field">
				<label for="country">Country</label>
				<div class="ivs-input">
					<select id="country_name" name="country_name" required="required" class="valid"><option value="">Select Country</option><option value="Algeria">Algeria</option>
						<option value="Andorra">Andorra</option>
						<option value="Argentina">Argentina</option>
						<option value="Australia">Australia</option>
						<option value="Austria">Austria</option>
						<option value="Bahamas">Bahamas</option>
						<option value="Bangladesh">Bangladesh</option>
						<option value="Belgium">Belgium</option>
						<option value="Brazil">Brazil</option>
						<option value="Bulgaria">Bulgaria</option>
						<option value="Cameroon">Cameroon</option>
						<option value="Canada">Canada</option>
						<option value="Chile">Chile</option>
						<option value="China">China</option>
						<option value="Colombia">Colombia</option>
						<option value="Costa Rica">Costa Rica</option>
						<option value="Croatia">Croatia</option>
						<option value="Cuba">Cuba</option>
						<option value="Cyprus">Cyprus</option>
						<option value="Czech Republic">Czech Republic</option>
						<option value="Denmark">Denmark</option>
						<option value="Ecuador">Ecuador</option>
						<option value="Egypt">Egypt</option>
						<option value="El Salvador">El Salvador</option>
						<option value="Estonia">Estonia</option>
						<option value="Ethiopia">Ethiopia</option>
						<option value="Finland">Finland</option>
						<option value="France">France</option>
						<option value="Germany">Germany</option>
						<option value="Ghana">Ghana</option>
						<option value="Greece">Greece</option>
						<option value="Guatemala">Guatemala</option>
						<option value="Haiti">Haiti</option>
						<option value="Honduras">Honduras</option>
						<option value="Hong Kong">Hong Kong</option>
						<option value="Hungary">Hungary</option>
						<option value="Iceland">Iceland</option>
						<option value="India">India</option>
						<option value="Indonesia">Indonesia</option>
						<option value="Iran">Iran</option>
						<option value="Iraq">Iraq</option>
						<option value="Ireland">Ireland</option>
						<option value="Isle of Man">Isle of Man</option>
						<option value="Israel">Israel</option>
						<option value="Italy">Italy</option>
						<option value="Jamaica">Jamaica</option>
						<option value="Japan">Japan</option>
						<option value="Jordan">Jordan</option>
						<option value="Kazakhstan">Kazakhstan</option>
						<option value="Kenya">Kenya</option>
						<option value="Korea, Republic of">Korea, Republic of</option>
						<option value="Latvia">Latvia</option>
						<option value="Liechtenstein">Liechtenstein</option>
						<option value="Lithuania">Lithuania</option>
						<option value="Luxembourg">Luxembourg</option>
						<option value="Macao">Macao</option>
						<option value="Macedonia">Macedonia</option>
						<option value="Malaysia">Malaysia</option>
						<option value="Malta">Malta</option>
						<option value="Mexico">Mexico</option>
						<option value="Moldova">Moldova</option>
						<option value="Mongolia">Mongolia</option>
						<option value="Montenegro">Montenegro</option>
						<option value="Morocco">Morocco</option>
						<option value="Nepal">Nepal</option>
						<option value="Netherlands">Netherlands</option>
						<option value="New Zealand">New Zealand</option>
						<option value="Nigeria">Nigeria</option>
						<option value="Norway">Norway</option>
						<option value="Pakistan">Pakistan</option>
						<option value="Paraguay">Paraguay</option>
						<option value="Peru">Peru</option>
						<option value="Philippines">Philippines</option>
						<option value="Poland">Poland</option>
						<option value="Portugal">Portugal</option>
						<option value="Romania">Romania</option>
						<option value="Russian Federation">Russian Federation</option>
						<option value="Saudi Arabia">Saudi Arabia</option>
						<option value="Serbia">Serbia</option>
						<option value="Singapore">Singapore</option>
						<option value="Slovakia">Slovakia</option>
						<option value="Slovenia">Slovenia</option>
						<option value="South Africa">South Africa</option>
						<option value="Spain">Spain</option>
						<option value="Sri Lanka">Sri Lanka</option>
						<option value="Sweden">Sweden</option>
						<option value="Switzerland">Switzerland</option>
						<option value="Taiwan">Taiwan</option>
						<option value="Thailand">Thailand</option>
						<option value="Trinidad and Tobago">Trinidad and Tobago</option>
						<option value="Tunisia">Tunisia</option>
						<option value="Turkey">Turkey</option>
						<option value="Uganda">Uganda</option>
						<option value="Ukraine">Ukraine</option>
						<option value="United Arab Emirates">United Arab Emirates</option>
						<option value="United Kingdom">United Kingdom</option>
						<option value="United States">United States</option>
						<option value="Uruguay">Uruguay</option>
						<option value="Venezuela">Venezuela</option>
						<option value="Vietnam">Vietnam</option></select>
				
					<span class="err_country err"></span>
				</div>
					
				<div class="clear"></div>
			</div>

			<div class="ivs-field">
				<label for="driving_license">Mobile Number</label>
				<div class="ivs-input">	
					<input type="text" readonly="" name="country_code" size="2" id="mcv_code" style="width:19% !important;float:left"/> <input placeholder="Mobile Number" type="text" name="mobile_number" id="mobile_number" style="width:79%!important;float:right;margin-left:5px" maxlength="10">
					<span class="err err_number"></span>
				</div>		
				<div class="clear"></div>
			</div>

			

			
			<div class="ivs-field ivs-btn">	
					<button type="button"  id="verify_mcv" >VERIFY</button>
				<div class="clear"></div>
			</div>	

			</div>
			</form>
		<div class="clear"></div>
		<div class="result_mcv " style="display:none;width:100%">
		<form >
		<div class="ivs-inner">
			<div class="ivs-field">
				<label for="driving_license">SMS Code	</label>
				<div class="ivs-input">	
					<input type="hidden" id="mobile_number_result">
						<input type="hidden" id="country_result">
						<input type="text" id="sms_code" maxlength="6" placeholder="SMS Code">
						<span class="err_sms_code err"></span>
				</div>		
				<div class="clear"></div>
			</div>
			<div class="ivs-field ivs-btn">	
					<button type="button"  class="" href="#" id="verify_mcv_code" >SUBMIT</button>
				<div class="clear"></div>
			</div>	
			</div>
		</form>
		<div class="clear"></div>
		<div class="text-center">
			<div class="resend-block">
				
				Still waiting for your SMS Code? <button type="button" class="resend_sms">CLICK HERE</button> to Resend<br/><br/>
				Time to receive your code varies from carriers and countries and may take up to 30sec.
			</div>
		</div>
	</div>
	<div class="clear"></div>
	</div>

	<?php
	}else{

		echo "API Credentials Not Yet Configured";
	}
	?>
	<div class="result">
	</div>

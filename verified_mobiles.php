<h3 class="update-nag"><?php echo $type_users?></h3>
<?php

if(count($verified_users)>0){
?>
<table class="tbl-list">
	<tr>
		<th>
			Mobile
		</th>
		<th>
			Country
		</th>
		
	</tr>
<?php
	for($r=0;$r<count($verified_users);$r++){
?>
	<tr>
		<td>
			<?php echo $verified_users[$r]->mobile_number?>
		</td>
		<td>
			<?php echo $verified_users[$r]->country?>
		</td>
		
	</tr>
<?php		
	}
?>
</table>
<?php
}else{
	echo "<br/>No Data Found";
}
?>
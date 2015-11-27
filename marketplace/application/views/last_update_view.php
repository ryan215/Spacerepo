<div class="alert alert-info fade in">
	<button data-dismiss="alert" class="close close-sm" type="button">
    	<i class="fa fa-times"></i>
    </button>    
	<?php
	if(!empty($last_modifed))
	{
		?>
		<strong>
			Last Modified by : 
		</strong>
		<?php
			echo $last_modifed->last_modified_name.' At '.date("d-m-Y h:i",$last_modifed->last_modified_time)
		?><br />
		<strong>
		Change :       
		</strong>
		<?php
		echo $last_modifed->message;
	}
	elseif(!empty($modified_by))
	{
		echo ' <strong>Last Modified by</strong> : '.$modified_by.' At '.date("d-m-Y h:i",$modified_time);
	}
	?>
</div>

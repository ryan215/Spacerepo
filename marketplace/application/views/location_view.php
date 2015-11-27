<script type="text/javascript">

function state_list(countryId,stateId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/home/stateCountryPhoneCodeList'; ?>',
		data:'countryId='+countryId+'&stateId='+stateId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		dataType:'json',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result.view);
			
			$('#countryCode').val(result.phoneCode);	
			
			city_list($('#stateId').val());		
					
		}
	});
}

function city_list(stateId,cityId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/home/cityStateList'; ?>',
		data:'stateId='+stateId+'&cityId='+cityId+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
			  $('.selectpicker').selectpicker();
		}
	});
}



</script>
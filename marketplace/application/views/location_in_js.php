<script type="text/javascript">
function state_list(countryId)
{	//alert('<?php //echo base_url().$this->session->userdata('userType').'/location_management/stateCountryList'; ?>');
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo $result['stateId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);
			area_list($('#stateId').val());	
			$('.selectpicker').selectpicker({  style: 'btn-default' });		
			//console.log(result);
		}
	});
}

function area_list(stateId)
{	//alert(stateId);
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo $result['areaId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
			city_list($('#areaId').val());	
			$('.selectpicker').selectpicker({  style: 'btn-default' });	
		}
	});
}

function city_list(areaId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo $result['cityId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
			$('.selectpicker').selectpicker({  style: 'btn-default' });
		}
	});
}

<?php
if($result['countryId'])
{
?>
state_list('<?php echo $result['countryId']; ?>');
<?php
}
if($result['stateId'])
{
?>
area_list('<?php echo $result['stateId']; ?>');
<?php
}
if($result['areaId'])
{
?>
city_list('<?php echo $result['areaId']; ?>');
<?php
}
?>
</script>
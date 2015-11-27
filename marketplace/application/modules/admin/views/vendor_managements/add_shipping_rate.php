<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />

<section id="main-content">
	<section class="wrapper">
  		<div class="row">
    		<div class="col-md-12">
      			<ul class="breadcrumbs-alt animated fadeInLeft">
        			<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>">
							Shipping Vendor List
						</a>
					</li>
					<li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($shippingOrgId); ?>">
							View
						</a>
					</li>
                    <li>
						<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId); ?>">
							Shipping Rates List
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">
							Add Rate List
						</a>
					</li>
      			</ul>
    		</div>
  		</div>
  		
		<div class="row">
      		<div class="col-md-12" style="padding:0;">
        		<div class="col-lg-12">
					<section class="panel" style="">
						<?php $this->load->view('success_error_message'); ?>
          				<header class="panel-heading panel-heading1">Add Shipping Rate</header>
          				<?php echo form_open();?>
						<div class="panel-body" style="line-height:21px;">
            				<div style="max-width:70%; margin:0 auto; padding-top:30px;">
            					<div class="form-group col-sm-12">
									<div class="col-sm-4">
										<label for="countryName" style="float:left; line-height:33px;">
											Select Dropship Center
										</label>
										&nbsp;<span class="error">*</span>
									</div>
									<div class="col-sm-8 padding_left_zero">
										<select id="example-post" name="dropShipCenter[]" multiple="multiple"  class="form-control">								<?php
											if(!empty($result['dropShipCenterList']))
											{
												foreach($result['dropShipCenterList'] as $row)
												{
											?>
											<option value="<?php echo $row->dropCenterId; ?>" <?php echo set_select('dropShipCenter[]',$row->dropCenterId); ?>>
												<?php echo $row->dropCenterName; ?>
											</option>
											<?php	
												}
											}
											?>
										</select>
									</div> 
									<?php echo form_error('dropShipCenter[]'); ?>
								</div>
								
					            <div class="form-group col-sm-12">
                					<div class="col-sm-4">
				                		<label for="countryName" style="float:left; line-height:33px;">
											Select State
										</label>&nbsp;
									</div>
									
									<div class="col-sm-8 padding_left_zero">
										<select class="form-control selectpicker" data-live-search="true" name="stateId" onchange="area_list(this.value);">
											<option value="">State</option>
											<?php 
											if(!empty($result['stateList']))
											{
												foreach($result['stateList'] as $row)
												{
											?>
												<option value="<?php echo $row->stateId; ?>" <?php if($result['stateId']==$row->stateId){ ?> selected="selected" <?php } ?>>
													<?php echo $row->stateName; ?>
												</option>
												<?php	
												}
											 }
											 ?>
										</select>
										<?php echo form_error('stateId'); ?>
									</div>
								</div>
								
								<div class="form-group col-sm-12" id="areaList">
									
            					</div>
							</div>
          					
							<div class="col-sm-12 form-div padding_right_zero">
								<div class="col-sm-12 text-right padding_right_zero">
									<a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($shippingOrgId); ?>">
										Cancel
									</a>&nbsp;
									<button type="submit" class="btn btn-success btn-save">
										Next
									</button>
								</div>
							</div>
        				</div>
						</form>
					</section>
				</div>
			</div>
		</div>
	</section>
</section>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/admin/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="<?php echo base_url(); ?>css/admin/bootstrap-multiselect.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#example-post').multiselect({
    	includeSelectAllOption: true,
        enableFiltering: true
	});
});
$('.selectpicker').selectpicker('show');

function area_list(stateId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/vendor_management/area_list'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo $result['areaIdStr']; ?>&areaErr=<?php echo $result['areaErr']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
		}
	});
}

<?php
if($result['stateId'])
{
?>
area_list('<?php echo $result['stateId']; ?>');
<?php
}
?>
</script>

<style>
label{background-image:none;}
.btn-group{ width:100%;}
.multiselect{ width:100%; text-align:left; background:#fff !important; color:#777 !important;}
.multiselect .caret{float: right; margin-top: 8px;}
.btn-group .btn{ background:#fff;color:#777 !important;}
.form-group { margin-bottom: 15px !Important;}
.dropdown-menu>.active>a{ background:#94C359;}
.help_icon{ top: 5px; position: relative;}
</style>

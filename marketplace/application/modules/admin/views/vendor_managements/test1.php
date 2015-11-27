<link href="<?php echo base_url(); ?>css/color_style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />

<section id="main-content">
  <section class="wrapper">
  <div class="row">
    <div class="col-md-12">
      <ul class="breadcrumbs-alt animated fadeInLeft">
        <li> <a href="<?php echo base_url().'admin/brand_management'; ?>"> Shipping Rate List </a> </li>
        <li> <a href="javascript:void(0);" class="current">
          
          Add</a> </li>
      </ul>
    </div>
  </div>
  <?php echo form_open();?>
    <div class="row">
      <div class="col-md-12" style="padding:0;">
        <div class="col-lg-12">
          <?php $this->load->view('upload_image_in_js'); ?>
          <section class="panel" style="">
          <header class="panel-heading panel-heading1">Add Shipping Rate</header>
          <div class="panel-body" style="line-height:21px;">
            <div style="max-width:70%; margin:0 auto; padding-top:30px;">
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label for="countryName" style="float:left; line-height:33px;">Select Dropship Center </label>
                  &nbsp;<span class="error">*</span></div>
                <div class="col-sm-8 padding_left_zero">
						 <select id="example-post" name="multiselect[]" multiple="multiple"  class="form-control">								
								<option value="NEW BENIN1">NEW BENIN1</option>
								<option value="IKOTA1">IKOTA1</option>
								<option value="IKEJA1">IKEJA1</option>
								<option value="OJUELEGBA1">OJUELEGBA1</option>
								<option value="OREGUN">OREGUN</option>
								<option value="ADESUWA1">ADESUWA1</option>
				     	</select>
              </div> 
              </div>
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                	  <label for="countryName" style="float:left; line-height:33px;"> Select State </label>&nbsp;
					  
                </div>
                <div class="col-sm-8 padding_left_zero">
                      <select class="form-control selectpicker" data-live-search="true" name="stateId">
												<option value="">State</option>
												<option value="13">ABIA</option>
												<option value="25">ADAMAWA</option>
												<option value="5">AKWA IBOM</option>
												<option value="14">ANAMBRA</option>
												<option value="26">BAUCHI</option>
												<option value="6">BAYELSA</option>
						</select>
               </div>
            </div>
		      <div class="form-group col-sm-12">
                <div class="col-sm-4">
                	  <label for="countryName" style="float:left; line-height:33px;"> Select Area </label>&nbsp;
					  &nbsp;<span class="error">*</span>
                </div>
                <div class="col-sm-8 padding_left_zero">
				<div class="col-sm-4 padding_left_zero"><div class="checkbox c-checkbox" style="padding-bottom: 10px;padding-top: 5px;"><label><input type="checkbox" value=""  name="" class=""><span class="fa fa-check"></span>&nbsp;Demo1</label></div></div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 form-div padding_right_zero">
            <div class="col-sm-12 text-right padding_right_zero"><a class="btn btn-danger btn-save" href="<?php echo base_url(); ?>admin/vendor_management/test1">Cancel</a>&nbsp;<a class="btn btn-success btn-save" href="<?php echo base_url(); ?>admin/vendor_management/test2">Next</a>
            </div>
          </div>
        </div>
        </section>
      </div>
    </div>
    </div>
  </form>
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

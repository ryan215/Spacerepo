<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />

<!--main content start-->
<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
    <div class="col-lg-12">
      <section class="panel">
      <?php 
					$this->load->view('success_error_message'); 
					 $this->load->view('upload_image_in_js');
					?>
      <div class="col-sm-12 page-header">User Detail</div>
   <?php echo form_open();?>
        <section class="panel">
        <div class="panel-body" >
          <center>
          <div class="details_main">
            <h2>Edit Users</h2>
            <img src="<?php echo base_url(); ?>images/frontend/user_icon.png" class="img-responsive"> <br />
            <div class="col-sm-12">
              <div class="img_box">
                <div class="right">
                  <input type="hidden" name="imageName" id="hideImage" value="<?php echo $result['imageName']; ?>" />
                  <div id="uploadImage"> <span id="imgname">
                    <?php
											$image = '<img class="img-circle" src="'.base_url().'img/on-img.png" >';		
											echo $image;
											?>
                    <!--Upload your display image--> 
                    </span> </div>
                </div>
              </div>
              <?php echo form_error('imageName');?> </div>
            <div class="col-lg-12 pd">
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                    <div class="iconic-input right">
                      <label class="" for="FirstName">First Name</label>
                      <input type="text" id="FirstName" placeholder="First Name" name="firstName" class="form-control" value="<?php echo $result['firstName']; ?>">
                    </div>
                  </div>
                </div>
                <?php echo form_error('firstName');?> </div>
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                    <label class="" for="MiddleName">Middle Name</label>
                    <input type="text" id="MiddleName" placeholder="Middle Name" name="middle" class="form-control" value="<?php echo $result['middle']; ?>">
                  </div>
                </div>
                <?php echo form_error('middle');?> </div>
            </div>
            <div class="col-sm-12 pd">
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group">
                    <div class="iconic-input right">
                      <label class="" for="LastName">Last Name</label>
                      <input type="text" id="LastName" placeholder="Last Name" name="lastName" class="form-control" value="<?php echo $result['lastName']; ?>">
                    </div>
                  </div>
                </div>
                <?php echo form_error('lastName');?> </div>
            </div>
            <div class="clearfix"></div>
            <h2>DOB Details</h2>
            <img src="<?php echo base_url(); ?>images/dob_icon.png" class="img-responsive">
            <div class="col-sm-12 pd">
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                    <?php 
										$date = explode('-',$result['birthDay']);
										//print_r($date);
										
										?>
                    <div class="iconic-input right all-drop-custom">
                      <label class="" for="date">Date</label>
                      <select class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true" id="date" name="date">
                        <option value="" > Date</option>
                        <?php 
										for($i=1;$i<=31;$i++)
												{
												?>
                        <option value="<?php echo $i; ?>"  <?php if($date[2]==$i){ echo 'selected="selected"';} ?> > <?php echo $i; ?> </option>
                        <?php
												}													
												?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                    <div class="iconic-input right all-drop-custom">
                      <?php $calender   = cal_info(0);
                                                $month_list = $calender['months'];?>
                      <label class="" for="Month">Month</label>
                      <select class="form-control form-control1 selectpicker show-menu-arrow" name="month" id="Month" data-live-search="true">
                        <option value="" > Month</option>
                        <?php
                                                for($i=1;$i<=12;$i++)
                                                {
                                                ?>
                        <option value="<?php echo $i; ?>" <?php if($date[1]==$i){ echo 'selected="selected"';} ?>> <?php echo $month_list[$i]; ?> </option>
                        <?php
                                                }
                                                ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h2>Address Details</h2>
            <div class="col-sm-12 pd">
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                      <div class="iconic-input right all-drop-custom">
                        <label class="" for="countryId">Country</label>
                        <select class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true" id="countryId" name="countryId" onchange="state_list(this.value);">
                          <option value="">Select Country</option>
                          <?php 
											if(!empty($result['countryList']))
											{
												foreach($result['countryList'] as $row)
												{
												?>
                          <option value="<?php echo $row->countryId; ?>" <?php if($row->countryId==$result['countryId']){ echo 'selected="selected"';} ?> > <?php echo ucwords($row->name); ?> </option>
                          <?php
												}
											}													
											?>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="panel-body" style="line-height:21px;">
                  <div class="form-group text-left">
                  	<div class="iconic-input right all-drop-custom">
                    <label class="" for="stateId">State</label>
                    <div id="stateList">
                      <select class="form-control form-control1 selectpicker show-menu-arrow" name="stateId" id="stateId" data-live-search="true">
                        <option value="">Select State</option>
                      </select>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </center>
        <br />
        <br />
        <div class="col-sm-12 ">
          <center>
            <a class="btn btn-danger btn-save" href="<?php echo base_url(); ?>admin/profile">Cancel</a>&nbsp;&nbsp;
            <button class="btn btn-success btn-save">Save</button>
          </center>
        </div>
      </form>
    </div>
  </section>
</section>
<!--main content end-->
<style>
.ajax-upload-dragdrop{/* width:78% !Important;*/ padding:0px !Important; width:100px !important; text-align:center;}

.upload-statusbar{border:0; 
}

.upload-red {font-size:12px; padding:3px 15px;
}

.ajax-upload-dragdrop input{padding-left:0 !important;
	padding-right:0 !important;
	height:100px !important;
}

.ajax-upload-dragdrop  .upload-statusbar{margin-left:-120px !important;
}

.browse-star{ color: #ff6c60;
    font-size: 6px;
    line-height: 18px;
	margin-bottom: -8px;
    margin-right: -80px;
}
input[type=radio] { display:block !Important;}
</style>
<script type="text/javascript">
function state_list(countryId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().$this->session->userdata('userType').'/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo $result['stateId']; ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);	
			//area_list($('#stateId').val());			
		}
	});
}

<?php
if(!empty($result['countryId']))
{
?>
state_list('<?php echo $result['countryId']; ?>');
<?php
}
?>
</script> 

<script>
	   $( document ).ajaxComplete(function() {
 $('.selectpicker').selectpicker();
 
 $('#stateList').addClass('.selectpicker');

 
});
</script>

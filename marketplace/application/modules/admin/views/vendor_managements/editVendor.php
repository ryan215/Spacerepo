 <link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">

<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />
<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
<div class="row">
	<div class="col-md-12">
    	<ul class="breadcrumbs-alt animated fadeInLeft">
        	<li>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>">
					Shipping Vendor List
				</a>
			</li>
			<li>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($organizationId); ?>">
					View 
				</a>
			</li>
			<li>
				<a href="javascript:void(0);" class="current">
					Edit
				</a>
			</li>
      </ul>
    </div>
    <div class="col-lg-12">
      <?php 
					$this->load->view('success_error_message');
					$this->load->view('upload_image_in_js');
					?>
      <section class="panel">
      <section class="panel custom-panel">
        <div class="col-lg-12 padding_left_zero padding_right_zero">
          <section class="panel">
          <header class="panel-heading panel-heading1">Edit Details</header>
          <div class="panel-body" >
  <?php echo form_open();?>
            <center>
              <div class="details_main">
                <h2>User Details</h2>
                <img src="<?php echo base_url(); ?>images/frontend/user_icon.png" class="img-responsive">
                <div class="col-sm-12">
                  <div class="img_box">
				  	<input type="hidden" name="employeeId" value="<?php echo $result['employeeId']; ?>" />
                    <input type="text" name="imageName" id="hideImage" value="<?php echo $result['imageName']; ?>" style="visibility:hidden;">
                    <div id="uploadImage"> <span id="imgname">
                      <?php
															$image = '<img class="img-circle" src="'.base_url().'img/on-img.png" >';		
															echo $image;
															?>
                      </span> </div>
                    <p style="text-align:center;"> Upload your display image</p>
                    <?php echo form_error('imageName'); ?> </div>
                </div>
                
               
                  <div class="col-lg-6">
                    <div class="panel-body panel-body-customs" style="line-height:21px;">
                      <label class="signup-labels">First Name</label>
                      <i class="fa fa-star icon_req star-reqr"></i>
                      <div class="form-group">
                        <div class="iconic-input right">
                          <input  type="text" name="firstName" value="<?php echo $result['firstName']; ?>" class="form-control ship-input ship-input2" placeholder="First Name" >
                          <?php echo form_error('firstName'); ?> </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="panel-body panel-body-customs" style="line-height:21px;">
                      <label class="signup-labels">Middle Name</label>
                     
                      <div class="form-group">
                        <div class="iconic-input right">
                          <input  type="text" name="middleName" value="<?php echo $result['middleName']; ?>" class="form-control ship-input ship-input2" placeholder="Middle Name" >
                          <?php echo form_error('middleName'); ?> </div>
                      </div>
                    </div>
                  </div>
              
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Last Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <input type="text" name="lastName" value="<?php echo $result['lastName']; ?>" placeholder="Last Name" class="form-control ship-input ship-input2">
                            <?php echo form_error('lastName'); ?> </div>
                        </div>
                      </div>
                    </div>
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">State Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                          
                            
								<div id="stateList">
                          	<select name="stateId" id="stateId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true">
                        		<option value="">Select State</option>
                            </select>
						</div>
                     
                      <?php echo form_error('stateId'); ?></div>
                        </div>
                      </div>
                    </div>
					
					<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Area Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <div id="areaList">
                              <select name="areaId" class="form-control form-control1 selectpicker show-menu-arrow" style="width:100%;">
                                <option value="">Select Area</option>
                              </select>
                            </div>
                            <?php echo form_error('areaId'); ?> </div>
                        </div>
                      </div>
                    </div>
                
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">City Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <div id="cityList">
                              <select name="cityId" class="form-control form-control1 selectpicker show-menu-arrow" style="width:100%;">
                                <option value="">Select City</option>
                              </select>
                            </div>
                            <?php echo form_error('cityId'); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Street Address</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <input type="text" class="form-control ship-input ship-input2" placeholder="Street Address" name="street" value="<?php echo $result['street']; ?>">
                            <?php echo form_error('street'); ?></div>
                        </div>
                      </div>
                    </div>
               
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Business Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <div>
                              <input type="text"class="form-control ship-input ship-input2" placeholder="Business Name" name="businessName" value="<?php echo $result['businessName']; ?>">
                              <?php echo form_error('businessName'); ?> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Business Phone Number</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
						<div class="form-group ">
                        
								
								
									<input type="tel" name="countryCode" id="mobile-number" placeholder="Enter Phone Number" class="ship-input ship-input2 form-control" data-live-search="true" value="<?php echo $result['businessPhoneCode']; ?>" style="width:30%; float:left; border-top-right-radius:0; border-bottom-right-radius:0;">
                           <div style="float:left; width:70%;">
                           	 <input type="text" class="form-control ship-input ship-input2" placeholder="Business Phone Number" name="businessPhone" value="<?php echo $result['businessPhone']; ?>"  style="margin-left:0px; width:100%; border-top-left-radius:0; border-bottom-left-radius:0;" />
                           </div>
                         
                         <?php echo form_error('countryCode'); ?>
                <?php echo form_error('businessPhone'); ?></div>
                      </div>
                    </div>
                
              </div>
              </div>
              <div class="clearfix"></div>
            </center>
            <br />
            <br />
            <div class="col-sm-12 ">
              <center>
                <a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management'; ?>"> Cancel </a>&nbsp;&nbsp;
                <button class="btn btn-success btn-save">Save</button>
              </center>
            </div>
          </form>
        </div>
      </section>
      <!--widget end--> 
    </div>
  </section>
</section>
</div>
</div>
<!--contant end-->
</section>
</section>
<?php $this->load->view('location_in_js'); ?>
<script>
$('.selectpicker').selectpicker({  style: 'btn-default' });
</script>
<script src="<?php echo base_url(); ?>js/retailer/intlTelInput.js"></script>
<script>
      $("#mobile-number").intlTelInput();
	  
	  
	  $( document ).ajaxComplete(function() {
 $('.selectpicker').selectpicker();
 
 $('#cityId').addClass('.form-control1');

 
});
</script>

<style>
.ajax-upload-dragdrop {
	width: 150px !important;
	margin: 0 auto;
}
.ajax-upload-dragdrop input {
	width: 150px !important;
	height: 150px !important;
}
.regular-radio {
	display: none;
}
.labels-radio {
	padding-left: 3px !important;
	padding-right: 15px !important;
	text-transform: inherit !important;
	font-weight: normal;
}
input[type="radio"] {
	display: none;
}

.labels-radio{margin-right:5px;
	font-weight:normal;
	font-size:15px !important; 
}

	input[type=radio] + label:before {
	    content: "";  
	    display: inline-block;  
	    width: 15px;  
	    height: 15px;  
	    vertical-align:middle;
	    margin-right: 8px;  
		border:1px solid #666;
	    border-radius: 8px;  
		
		
	}

	input[type=radio]:checked + label:before {
		content: "\2022";
		color:#99CB5D;
		font-size:2em;
		text-align:center;
		line-height:12px;
		text-shadow:0px 0px 3px #eee;
	}
.panel-body-customs {
	text-align: left;
}
.details_main {
	padding-bottom: 20px;
}
.addon-customs {
	background-color: #fff;
}
.star-reqr{color: #ff6c60;
    font-size: 6px;
	margin-left: 2px;
    position: absolute;
}
.signup-labels{font-weight:600;
}

.intl-tel-input .flag-dropdown .selected-flag {
    margin: 1px;
    padding: 9px 16px 9px 6px;
}

#cityList .bootstrap-select{width:100% !important;
}

.btn-default{background-color: #fff !important;
    border-color: #e2e2e4 !important;1px solid 
    color: #666 !important;
}

.btn-default span{color:#666;
}

.dropdown-menu{max-height:225px !important;
}

</style>
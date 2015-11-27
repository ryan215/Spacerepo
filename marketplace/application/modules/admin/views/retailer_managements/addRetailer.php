<link href="<?php echo base_url(); ?>css/retailer/intlTelInput.css" / rel="stylesheet">

<link href="<?php echo base_url() ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />
<section id="main-content">
  <section class="wrapper"> 
    <!--contant start-->
    <div class="row">
    <div class="col-md-12">
      <ul class="breadcrumbs-alt animated fadeInLeft">
        <li> <a href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>"> Retailer List </a> </li>
        <li> <a href="javascript:void(0);" class="current">Add </a> </li>
      </ul>
    </div>
    <div class="col-lg-12">
      <?php $this->load->view('success_error_message'); ?>
      <section class="panel">
      <section class="panel custom-panel">
        <div class="col-lg-12 padding_left_zero padding_right_zero">
          <section class="panel">
          <header class="panel-heading panel-heading1">Add Details</header>
          <div class="panel-body" >
         <?php echo form_open();?>
            <center>
              <div class="details_main">
                <h2>User Details</h2>
                <img src="<?php echo base_url(); ?>images/frontend/user_icon.png" class="img-responsive">
                
				<?php /*?><div class="col-sm-12 pd">
                  <div class="col-lg-6">
                    <div class="panel-body panel-body-customs" style="line-height:21px;">
                      <label class="signup-labels">Platform</label>
                      <i class="fa fa-star icon_req star-reqr"></i>
                      <div class="form-group">
                        <div class="iconic-input right">
                          <input type="radio" name="associationType" value="1" <?php if($result['associationType']==1){ ?> checked="checked" <?php } ?> id="associationType1" />
								<label for="associationType1" class="labels-radio">Pointemart</label>
								<input type="radio" name="associationType" value="2" <?php if($result['associationType']==2){ ?> checked="checked" <?php } ?> id="associationType2"/>
								<label for="associationType2" class="labels-radio">Pointepay</label>
								<input type="radio" name="associationType" value="3" <?php if($result['associationType']==3){ ?> checked="checked" <?php } ?> id="associationType3"/>
								<label for="associationType3" class="labels-radio">Both</label>
							  	<?php echo form_error('associationType'); ?>						  
						 </div>
                      </div>
                    </div>
                  </div>
                </div><?php */?>
                <div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Dropship Center</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <select name="dropshipCentre" id="countryId" class="form-control form-control1 selectpicker show-menu-arrow" data-live-search="true">
                        <option value="">Select Dropship Center</option>
                        <?php
                        if(!empty($result['dropshipCentreList']))
                        {
                            foreach($result['dropshipCentreList'] as $row)
                            {
                        ?>
                            <option value="<?php echo $row->dropCenterId; ?>" <?php if($result['dropshipCentre']==$row->dropCenterId){ ?> selected="selected" <?php } ?>>
                                <?php echo $row->dropCenterName; ?>
                            </option>
                        <?php
                            }
                        }
                        ?>
                      </select>
                      <?php echo form_error('dropshipCentre'); ?>
                          </div>
                        </div>
                      </div>
                    </div>
				<input type="hidden" name="associationType" value="3"/>	
               
                <div class="col-sm-12 pd">
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
                </div>
                
                <div class="col-sm-12 pd">
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
                        <label class="signup-labels">Email</label>
                  
                        <div class="form-group">
                          <div class="iconic-input right">
                            <input type="text" class="form-control ship-input ship-input2" name="email" value="<?php echo $result['email']; ?>" placeholder="Email">
                            <?php echo form_error('email'); ?> </div>
                        </div>
                      </div>
                    </div>
                </div>
                
                	
                
                <div class="col-sm-12 pd">
                	<?php /*?><div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Country Name</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <select name="countryId" id="countryId" class="form-control form-control1 selectpicker show-menu-arrow" onchange="state_list(this.value);" data-live-search="true">
                        <option value="">Select Country</option>
                        <?php
                        if(!empty($result['countryList']))
                        {
                            foreach($result['countryList'] as $row)
                            {
                        ?>
                            <option value="<?php echo $row->countryId; ?>" <?php if($result['countryId']==$row->countryId){ ?> selected="selected" <?php } ?>>
                                <?php echo $row->name; ?>
                            </option>
                        <?php
                            }
                        }
                        ?>
                      </select>
                      <?php echo form_error('countryId'); ?>
                          </div>
                        </div>
                      </div>
                    </div><?php */?>
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
                    
                </div>
                
                <div class="col-sm-12 pd">
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
                    <div class="col-sm-12 pd">
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
                        
								
								<?php /*?><select name="countryCode" id="countryCode">
										<?php
										if(!empty($result['countryList']))
										{
											foreach($result['countryList'] as $row)
											{
										?>
											<option value="<?php echo $row->phoneCode; ?>" <?php if($result['countryCode']==$row->phoneCode){ ?> selected="selected" <?php } ?>>
												<?php echo $row->phoneCode; ?>
											</option>
										<?php
											}
										}
										?>
									</select><?php */?>
                                    <div class="col-sm-12 pd" style="display:inline-flex; width:100%;">
                               
                                  <div class="input-group">
                                     <span class="input-group-addon" style="background-color: #eee !important; font-size:14px;">+234</span>
                                     <input type="text" name="businessPhone" class="form-control" placeholder="Business Phone Number" value="<?php echo $result['businessPhone']; ?>">
                                  </div>
                           
                      	</div>
									<?php /*?><input type="tel" name="countryCode" id="mobile-number" placeholder="Enter Phone Number" class="ship-input ship-input2 form-control" data-live-search="true" value="<?php echo $result['countryCode']; ?>" style="width:30%; float:left; border-top-right-radius:0; border-bottom-right-radius:0;">
                           <div style="float:left; width:70%;">
                           	 <input type="text" class="form-control ship-input ship-input2" placeholder="Business Phone Number" name="businessPhone" value="<?php echo $result['businessPhone']; ?>"  style="margin-left:0px; width:100%; border-top-left-radius:0; border-bottom-left-radius:0;" /><?php */?>
                           </div>
                         
                         <?php echo form_error('countryCode'); ?>
                <?php echo form_error('businessPhone'); ?></div>
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
                <a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/retailer_management'; ?>"> Cancel </a>&nbsp;&nbsp;
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

.dropdown-menu{max-height:260px !important;
}

</style>
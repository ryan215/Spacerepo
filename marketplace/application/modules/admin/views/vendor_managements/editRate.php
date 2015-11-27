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
					Shipping Vendore List
				</a> 
			</li>
			<li>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/user_detail/'.id_encrypt($result['shippingOrgId']); ?>">
					View 
				</a>
			</li>
			<li>
				<a href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($result['shippingOrgId']); ?>">
					Shipping Rates List
				</a>
			</li>        
        	<li> <a href="javascript:void(0);" class="current">Edit </a> </li>
      </ul>
    </div>
    <div class="col-lg-12">
      <?php $this->load->view('success_error_message'); ?>
      <section class="panel">
      <section class="panel custom-panel">
        <div class="col-lg-12 padding_left_zero padding_right_zero">
          <section class="panel">
          <header class="panel-heading panel-heading1">Edit Rate</header>
          <div class="panel-body" >
        <?php echo form_open();?>
            <center>
              <div class="details_main">
                <div class="col-sm-12 pd">
                  <div class="col-lg-6">
                    <div class="panel-body panel-body-customs" style="line-height:21px;">
                      <label class="signup-labels">Warehous Area</label>
                      <div class="form-group">
                        <div class="iconic-input right">
                          <?php echo $result['fromZip']; ?> </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="panel-body panel-body-customs" style="line-height:21px;">
                      <label class="signup-labels">To Area</label>
                     
                      <div class="form-group">
                        <div class="iconic-input right">
                           <?php echo $result['toCity']; ?></div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-sm-12 pd">
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">From Weight</label>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <?php echo $result['fromWeight']; ?> KG </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
                
                	
                
                <div class="col-sm-12 pd">
                	
                    <div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">To Weight</label>
                        <div class="form-group">
                          <div class="iconic-input right">
                          
                              <?php echo $result['toWeight']; ?> KG</div>
                        </div>
                      </div>
                    </div>
                </div>
                
                <div class="col-sm-12 pd">
                	<div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">ETA</label>
                        <div class="form-group">
                          <div class="iconic-input right">
                            <?php echo $result['ETA']; ?> Days</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="panel-body panel-body-customs" style="line-height:21px;">
                        <label class="signup-labels">Rate</label>
                        <i class="fa fa-star icon_req star-reqr"></i>
                        <div class="form-group">
                          <div class="iconic-input right">
						  
                            <input type="text" class="form-control ship-input ship-input2" placeholder="Rate" name="shippRate" value="<?php echo $result['amount']; ?>">
                            <?php echo form_error('shippRate'); ?></div>
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
                <a class="btn btn-danger btn-save" href="<?php echo base_url().$this->session->userdata('userType').'/vendor_management/shipping_rate_list/'.id_encrypt($result['shippingOrgId']); ?>"> Cancel </a>&nbsp;&nbsp;
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
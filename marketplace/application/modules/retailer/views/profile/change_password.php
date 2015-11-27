<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<?php $this->load->view('success_error_message'); ?> 
        <div class="row">
            <div class="col-sm-12">
            	<section class="panel">
                <header class="panel-heading">
                      Settings 
                </header>
                <div style="padding:30px 0 10px;" class="panel-body">
                <div class="row">
                    <div class="col-lg-11 bhoechie-tab-container">
                    	<?php
						if($this->session->userdata('userType')!='shipping')						
						{
						?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <div class="list-group">
                            <a href="<?php echo base_url().$this->session->userdata('userType'); ?>/profile/change_password" class="list-group-item active text-center btn-success" style="background-color: #78CD51 !important;border-color: #78CD51 !important;">
                              <h4 class="fa fa-lock"></h4><br/> Change Password 
                            </a>
                           	
							<a href="<?php echo base_url().$this->session->userdata('userType'); ?>/profile/setting" class="list-group-item text-center">
                              <h4 class="fa fa-envelope-o"></h4><br/>Change Email
                            </a>                            
                          </div>
                        </div>
                        <?php
						}
						?>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                            <!-- flight section -->
                           <div class="bhoechie-tab-content">
                                
                            </div>
                        
                            <div class="bhoechie-tab-content active">
                                <div class="panel-body" style="line-height:21px; padding-bottom:40px;">
                                    <div class="col-sm-12">
									<?php 
$attributes = array('class' => 'form-horizontal','style' => 'margin-top:20px;');
echo form_open('',$attributes);
form_open_multipart()
?>
										<div class="form-group">
                                              <label class="col-sm-4 control-label" for="npassword">Current Password</label>
                                              <div class="col-sm-8">
                                                  <input type="password" name="opassword" placeholder="Current Password" id="opassword" class="form-control" value="<?php echo set_value('opassword');?>">
                                                  <?php echo form_error('opassword');?>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-4 control-label" for="npassword">New Password</label>
                                              <div class="col-sm-8">
                                                  <input type="password" name="npassword" placeholder="New Password" id="npassword" class="form-control" value="<?php echo set_value('npassword');?>">
                                                  <?php echo form_error('npassword');?>
                                              </div>
                                          </div>
                                          
										  <div class="form-group">
                                              <label class="col-sm-4 control-label" for="cpassword">New Confirm Password</label>
                                              <div class="col-sm-8">
                                                  <input type="password" name="cpassword" placeholder="New Confirm Password" id="cpassword" class="form-control" value="<?php echo set_value('cpassword');?>">
                                                  <?php echo form_error('cpassword');?>
                                              </div>
                                          </div>
										  
                                          <div class="form-group">
                                              <div class="col-lg-12 text-right">
                                                  <button class="btn btn-danger" type="submit">Submit</button>
                                              </div>
                                          </div>
                                      </form>
                                    </div>
                                    <div class="col-sm-2">
                                    
                                    </div>
                                </div>
                            </div>
               
                            
                        </div>
					
                    </div>
              </div>
          
            </div>
            </section>
                
            </div>
        </div>
        
        
       <!--contant end-->
    </section>
</section>
<style>
		label{background-image:none;
		}
		.chosen-container-single .chosen-single{background:none !important;
			border:1px solid #CCC !important;
			border-radius:4px !important; 
		}
		.panel-heading .nav > li > a{font-size:15px;
			font-weight:600;
		}
		
		 .table-invoice tr th{color:#FFF;
		}
		
		.btn-white{border:1px solid rgba(150, 160, 180, 0.3);
		}
		.bhoechie-tab-content  .active{
				background-color: #78CD51 !important;
		}
	</style>
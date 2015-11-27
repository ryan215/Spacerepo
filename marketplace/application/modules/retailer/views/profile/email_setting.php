<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
		<?php $this->load->view('success_error_message'); ?> 
        <div class="row">
            <div class="col-sm-12">
            	<section class="panel">
                <header class="panel-heading">
                      Setting 
                </header>
                <div style="padding:30px 0 10px;" class="panel-body">
                <div class="row">
                    <div class="col-lg-11 bhoechie-tab-container">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                          <div class="list-group">
                            <a href="<?php echo base_url().$this->session->userdata('userType'); ?>/profile/change_password" class="list-group-item text-center">
                              <h4 class="fa fa-lock"></h4><br/> Change Password 
                            </a>
                           	
							<a href="<?php echo base_url().$this->session->userdata('userType'); ?>/profile/setting" class="list-group-item active text-center" style="background-color: #78CD51 !important;border-color: #78CD51 !important;">
                              <h4 class="fa fa-envelope-o"></h4><br/>Change Email
                            </a>                            
                          </div>
                        </div>
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
?>

                                          <div class="form-group">
                                              <label class="col-sm-4 control-label" for="email">New Email</label>
                                              <div class="col-sm-8">
                                                  <input type="text" name="email" placeholder="New Email" id="email" class="form-control" value="<?php echo set_value('email');?>">
												  <?php echo form_error('email'); ?>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label class="col-sm-4 control-label" for="confirmemail">Confirm Email</label>
                                              <div class="col-sm-8">
                                                  <input type="Email" name="confirmemail" placeholder="Confirm Email" id="confirmemail" class="form-control" value="<?php echo set_value('confirmemail');?>">
                                                  <?php echo form_error('confirmemail');?>
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
	</style>
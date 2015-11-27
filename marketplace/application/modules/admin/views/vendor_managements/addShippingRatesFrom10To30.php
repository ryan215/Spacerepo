<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!--contant start-->
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
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
						<a href="javascript:void(0);" class="current">Add Rate List</a>
					</li>
				</ul>
			</div>
			
			<div class="col-lg-12">
				<section class="panel">
					<!----------------->
					<header class="panel-heading panel-heading1">10 to 50Kg Shipping Rate List</header>	


<!--start main contant-->
<div class="container" style="display:inline-bock; width:100%;">	

    <div class="log-in-box  main-shi-div" style="padding-top:20px; margin:0 auto; max-width:200px;">
	
		  <?php 
$attributes = array('id' => 'form-horizontal shipping-form');
echo form_open('',$attributes);
?>

		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="col-lg-12">
                     	 <div class="form-group">
                        <label class="signup-labels">Shipping Rate</label>
                           <div class="input-group left">
						    <span class="input-group-addon">&#x20A6;</span>
							  <input type="text" name="shippingRate" class="form-control" value="<?php echo $result['amount']; ?>"  maxlength="5"/>
							  <span class="input-group-addon">/kg</span>
							  
							
							 
						  </div>
                            <?php echo form_error('shippingRate'); ?>
                        </div>
						
                        <div class="form-group">
						 <label class="signup-labels">ETA</label>
						 <div class="input-group left">
						    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        <input type="text" name="estimateTime" class="form-control" value="<?php echo $result['eta']; ?>" />
						  </div>
                            <?php echo form_error('estimateTime'); ?>
                      
						</div>
                     
                    </div>
                	
					<div class="clearfix"></div>
                    	<div class="pull-right" style=" display:inline-block;padding-bottom:20px; margin-left:0px !important; ">
	                    	<button type="submit" class="btn btn-success  ship-sign-btn pull-right">Save</button>
	                    </div>
					
				</form>  
	</div>
</div> 
					<!---------------->							
				</section>
			</div>
		</div>		
	</section>
</section>		
<!--main content end-->
<style>
label{ background-image:none;}
</style>
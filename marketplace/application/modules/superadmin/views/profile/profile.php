<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
        	<div class="col-lg-12">
            	<?php $this->load->view('success_error_message'); ?>            
			</div>
		</div>
		
		<!--Chart-->
		<div class="row">
        	<div class="col-lg-12">
			<section class="panel">
				 <div>
			<div class="modal-body modal-body-custom">
           		<section class="panel">
                	<?php 
					$this->load->view('upload_image_in_js');
					?> 
					
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="home">
								<div class="row">
									<?php 
$attributes = array('class' => 'upload-img-input');
echo form_open('',$attributes);
?>

										<aside class="profile-nav col-lg-3">
										<input type="hidden" name="image_name" id="hideImage" value="<?php echo $dataArr['image_name']; ?>" />
										<div id="uploadImage">
											<span id="imgname">
												<?php
												$image = '<img class="img-circle" src="'.base_url().'images/default_user_image.jpg" height="100" width="100">';		
												if((!empty($dataArr['image_name']))&&(file_exists('uploads/admin/'.$dataArr['image_name'])))											
												{
													$image = '<img height="100" width="100" class="img-circle" src="'.base_url().'uploads/admin/thumb50/'.$dataArr['image_name'].'" alt="" />';													
												}
												echo $image;
												?>&nbsp;&nbsp;&nbsp;&nbsp; 
												Upload your display image
											</span>
										</div>
										</aside>
										<aside class="profile-info col-lg-9">
                  						<div class="divider"></div>
                    					
										<p>Put your First and Last name in the field</p>
										<div class="col-sm-12  form-div">
                    						<div class="col-sm-6">
												<input type="text" class="form-control model-input" placeholder="First name" name="first_name" value="<?php echo $dataArr['first_name']; ?>">
												<?php echo form_error('first_name'); ?>
                         					</div>
                         
						 					<div class="col-sm-6">
                         						<input type="text" class="form-control model-input" placeholder="Last name" name="last_name" value="<?php echo $dataArr['last_name']; ?>">
												<?php echo form_error('last_name'); ?>
                         					</div>
                    					</div>                                       
                                        <div class="divider"></div>
                                        <p>Put your Comment in the field given below</p>
                                        <div class="col-sm-12  form-div">
                                        	<div class="col-sm-12">
                                            	<textarea name="comment" class="form-control model-input" placeholder="Comment"><?php echo $dataArr['comment']; ?></textarea>
											</div>
                                        </div>
                                        <div class="col-sm-12">
                                        	<div class="col-sm-12">
                                          		<button class="btn btn-success btn-block ad_btn">Update</button>
                                            </div>
                                        </div>
										</aside>
									</form>
								</div>        
							</div>
						</div>
					</div>
				</section>
			</div>
				 	
				 </div>						
			</section>
			</div>
		</div>
		<!--Chart-->
	</div>
    <!--contant end-->
</section>
<!--main content end-->

<script type="text/javascript">
$(document).ready(function(){
	$('.selectpicker').selectpicker({
	});
});
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
        	<div class="modal-header modal-header1">
            	<button type="button" class="close close-btn" data-dismiss="modal">
					<span aria-hidden="true">
						<img src="<?php echo base_url(); ?>img/close.png"></span><span class="sr-only">Close
					</span>
				</button>
          	</div>
          	
			<div class="modal-body modal-body-custom">
           		<section class="panel">
                	<header class="panel-heading tab-bg-dark-navy-blue ">
                    	<ul class="nav nav-tabs form-tab">
                        	<li class="active">
                            	<a href="#home" data-toggle="tab">
									<?php
									if(!empty($user_id))
									{
										echo 'Edit An Superadmin';
									}
									else
									{
										echo 'Add An Superadmin';
									}
									?>
								</a>
                            </li>
						</ul>
					</header>
					
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane active" id="home">
								<div class="row">
								<?php 
$attributes = array('class' => 'upload-img-input');
echo form_open('',$attributes);
?>
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
                                       <?php
									if(empty($user_id))
									{
									?>
									    <p>Put your Email id in the field given below</p>
                                        <div class="col-sm-12 form-div">
											<div class="col-sm-12">
                                               	<input type="text" class="form-control model-input" placeholder="Email id" name="email" id="email" value="<?php echo set_value('email'); ?>">
												<?php echo form_error('email'); ?>
                                        	</div>
                                        </div>
									<?php
									}
										?>
                                        <div class="divider"></div>
                                        
                                        
										<p>Select your gender</p>
                                        <div class="col-sm-12 male-female">
                                        	<div class="col-sm-6">
                                            	<img src="<?php echo base_url(); ?>img/male.png"></br>
												<input type="radio" name="gender" id="radio1" <?php if($dataArr['gender']==1){ ?> checked="checked" <?php } ?> value="1"/>
												<label for="radio1" >Male</label>
											</div>
                                            <div class="col-sm-6">
                                            	<img src="<?php echo base_url(); ?>img/female.png"></br>
												<input type="radio" name="gender" id="radio2" <?php if($dataArr['gender']==0){ ?> checked="checked" <?php } ?> value="0" />
												<label for="radio2" >Female</label>
											</div>
											<?php echo form_error('gender'); ?>
                                        </div>
										<div class="divider"></div>
                                        
										<p>Please input your birth date below</p>
                                        <div class="col-sm-12 date-div" style="margin-bottom: 20px;">
                                        	<div class="col-sm-3">
												<select class="custom-select chosen-select selectpicker" data-live-search="true" name="date">
												<?php 
												for($i=1;$i<=31;$i++)
												{
												?>
													<option value="<?php echo $i; ?>" <?php if($dataArr['date']==$i){ ?> selected="selected" <?php } ?>>
														<?php echo $i; ?>
													</option>	
												<?php
												}													
												?>
                                            	</select>
												<?php echo form_error('date'); ?>
											</div>
                                            
											<div class="col-sm-6">
												<?php
												$calender   = cal_info(0);
												$month_list = $calender['months'];
												?>
												<select class="custom-select chosen-select selectpicker" data-live-search="true" name="month">
												<?php
												for($i=1;$i<=12;$i++)
												{
												?>
													<option value="<?php echo $i; ?>" <?php if($dataArr['month']==$i){ ?> selected="selected" <?php } ?>>
														<?php echo $month_list[$i]; ?>
													</option>
												<?php
												}
												echo form_error('month'); ?> 
												</div>
												
                                            <div class="col-sm-3">
												<input type="hidden" value="0000" name="year" />
												
											</div>
										</div>
										   
                                        <p>Put your Comment in the field given below</p>
                                        <div class="col-sm-12  form-div">
                                        	<div class="col-sm-12">
                                            	<textarea name="comment" class="form-control model-input" placeholder="Comment"><?php echo $dataArr['comment']; ?></textarea>
											</div>
                                        </div>
                                        <div class="col-sm-12">
                                        	<div class="col-sm-12">
                                          		<button class="btn btn-success btn-block ad_btn">Add A Superadmin</button>
                                            </div>
                                        </div>
									</form>
								</div>        
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>
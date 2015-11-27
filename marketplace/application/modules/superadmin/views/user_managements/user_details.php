<style>
/*view user detail*/
.page-header
{
	font-size: 20px;
    margin-top: 15px;
}
 
.bio-graph-info{
	font-size:15px;
}

.bio-row
{
	width:80%;
	padding:0;
}

/*end of user detail page*/
</style>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'superadmin/user_management'; ?>">
							User Managment
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?> 					 
                	<div class="col-sm-12 page-header">
						User Profile
					</div>
					<?php
					$imageUrl  = base_url().'images/default_user_image.jpg';
					if((!empty($result['imageName']))&&(file_exists('uploads/admin/thumb50/'.$result['imageName'])))
					{
						$imageUrl = base_url().'uploads/admin/thumb50/'.$result['imageName'];
					}
					?>
					<div class="row">
						<aside class="profile-nav col-lg-3">
                        	<section class="panel">
								<div class="user-heading round" style="margin-left:10px;">
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
										<h1><?php echo ucwords($result['firstName'].' '.$result['middleName'].' '.$result['lastName']); ?></h1>
                                        <p>
										</p>
                                      </div>
                                  </section>
                              </aside>
<aside class="profile-info col-lg-9">
	<section class="panel">
    	<div class="col-sm-12">
        	<div class="col-sm-1" style="padding-left:5px;">
				<?php
				if((!empty($result['code']))&&($result['code']=="SUPERADMIN"))
				{
				?>
				<a href="<?php echo base_url();?>superadmin/user_management/update_superadmin_user/<?php echo id_encrypt($employeeId);?>" class="btn btn-primary">
					<i class="fa fa-pencil"></i> Edit
				</a>
				<?php
				}
				elseif((!empty($result['code']))&&($result['code']=="ADMIN"))
				{
				?>
				<a href="<?php echo base_url();?>superadmin/user_management/update_admin_user/<?php echo id_encrypt($employeeId);?>" class="btn btn-primary">
					<i class="fa fa-pencil"></i> Edit
				</a>
				<?php				
				}
				?>
			</div>
			<div class="col-sm-2"  style="padding-left:20px;">
			<?php 
			$attributes = array('id' => 'frmSub');
			echo form_open('',$attributes);
			?>
			<input type="submit" name="submit" value="Reset Password" class="btn btn-warning" onclick="return reset_password();">
			</form></div>
			<?php
			if($result['blockUnblock'])
			{
			?>
				<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(0);">
					UnBlocked
				</a>
			<?php
			}
			else
			{
			?>
				<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block(1);">
					Blocked
				</a>			
			<?php
			}			
			?>
		</div>
	</section>
	
	<section class="panel">
        	<div class="panel-body bio-graph-info">
								<table class="table table-invoice table-custom">
									<thead>
										<th colspan="2" style="background-color:#A9D86E; color:#FFF;">Personal Detail</th>
									</thead>
									<tbody>
										<tr>
											<td>Name : </td>
											<td><?php echo $result['userName']; ?></td>
										</tr>
										<tr>
											<td>Email : </td>
											<td><?php echo $result['email']; ?></td>
										 </tr>
										 <tr>
											<td>Date of birth : </td>
											<td>
												<?php echo $result['date']; ?>
											</td>
										 </tr>
										 
                      					</tbody>
                    				</table>
								                   
									<table class="table table-invoice table-custom">
										<thead>
											<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
											Roles
											</th>
										</thead>
										<tbody>
											<?php
											if((!empty($result['code']))&&($result['code']=="SUPERADMIN"))
											{
											?>
												<tr>
													<td>Superuser</td>
													<td>
														<input type="checkbox" name="" id="checkbox" class="check1" checked="checked"  disabled="disabled" />
														<label for="checkbox1" class="label1">&nbsp;</label> 
													</td>
												</tr>
												<?php 
											}
											else
											{
												if(!empty($result['rolesList']))
												{
													$i = 1;
													foreach($result['rolesList'] as $row)
													{
														if(strtolower($row->code)!='am')
														{
											?>
											<tr>
												<td><?php echo $row->Description; ?> : </td>
												<td>
													<input type="checkbox" name="rules[]" id="checkbox<?php echo $i; ?>" class="check1" value="<?php echo $row->roleId; ?>" <?php if((!empty($result['employeeRoleList'][$row->roleId]))&&($result['employeeRoleList'][$row->roleId]==$row->roleId)){ ?> checked="checked" <?php } ?> disabled="disabled" />
												<label for="checkbox1" class="label1">&nbsp;</label>
												</td>
											</tr>
												<?php
															$i++;
														}
													}
												}
											}
											?>   
										</tbody>
									</table>
									
									<table class="table table-invoice table-custom">
										<thead>
											<th colspan="2" style="background-color:#A9D86E; color:#FFF;">Address</th>
										</thead>
										<tbody>
											<tr>
												<td>
												Country Name : 
												</td>
												<td>Nigeria
												</td>
											</tr>
											<tr>
												<td>
												State Name : 
												</td>
												<td>
												<?php 
													echo $result['stateName'];
													
												?>
												</td>
											</tr>
                      					</tbody>
                    				</table>
                            	</div>
                        	</section>

</aside>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->
	  
<script type="text/javascript" src="<?php echo base_url(); ?>js/confirmbox/sweet-alert.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/confirmbox/sweet-alert.css">
<script type="text/javascript">
function reset_password()
{
	if(confirm('Are you sure want to reset password for <?php echo $result['userName']; ?> ?'))
	{
		return true;
	}
	return false;
}

function unblock_block(status)
{
	msg = 'Are you sure that you want to block this user?';
	
	if(status)
	{
		msg = 'Are you sure that you want to unblock this user?';
	}
	redirect = "<?php echo base_url(); ?>superadmin/user_management/unblock_block/<?php echo id_encrypt($employeeId); ?>/"+status
	console.log(redirect);
	
	confirm_box(redirect,msg);
	
}
</script>

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
<?php $this->load->view('superadmin_managements/addEditAdminForm');  ?>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'superadmin/superadmin_management'; ?>">Superadmin Managment</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					$this->load->view('upload_image_in_js'); 
					?> 					 
                	<div class="col-sm-12 page-header">
						User Detail
					</div>
						<?php
						$imageUrl  = base_url().'images/default_user_image.jpg';
						if((!empty($dataArr['image_name']))&&(file_exists('uploads/superadmin/thumb50/'.$dataArr['image_name'])))
						{
							$imageUrl = base_url().'uploads/superadmin/thumb50/'.$dataArr['image_name'];
						}
						?>
						<div class="row">
                        	<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo $imageUrl; ?>">
                        					<img src="<?php echo $imageUrl; ?>" class="example-image" />
										</a>
										<h1><?php echo ucwords($dataArr['first_name'].' '.$dataArr['last_name']); ?></h1>
                                        <p>
										</p>
                                      </div>
                                  </section>
                              </aside>
                              <aside class="profile-info col-lg-9">
                                  <section class="panel">
                                      <div class="col-sm-12">
                                      	  <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">
										  Edit
										  </button>
										  
										  <?php
										  if($dataArr['block_status'])
										  {
										  ?>
										  <a onclick="unblock_block('<?php echo id_encrypt($user_id); ?>',0);">
    	                                      <button class="btn btn-danger" type="button">
											  	Block
											  </button>
										  </a>
										  <?php
										  }
										  else
										  {
										  ?>
										  <a onclick="unblock_block('<?php echo id_encrypt($user_id); ?>',1);">
                                          	<button class="btn btn-success" type="button">
												Unblock
											</button>
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
											<td><?php echo ucwords($dataArr['first_name'].' '.$dataArr['last_name']); ?></td>
										</tr>
										<tr>
											<td>Email : </td>
											<td><?php echo $dataArr['email']; ?></td>
										 </tr>
										 <tr>
											<td>Gender : </td>
											<td>
												<?php
												if($dataArr['gender'])
												{
													echo 'Male';
												}
												else
												{
													echo 'Female';
												}
												?>								
											 </td>
										 </tr>
										 <tr>
											<td>Date of birth : </td>
											<td><?php echo $dataArr['month'].'-'.$dataArr['date']; ?></td>
										 </tr>
										 
                      					</tbody>
                    				</table>
									
									                   
									<table class="table table-invoice table-custom">
										<thead>
											<th colspan="2" style="background-color:#A9D86E; color:#FFF;">Comment</th>
										</thead>
										<tbody>
											<tr>
												<td><?php echo nl2br($dataArr['comment']); ?></td>
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
function unblock_block(user_id,status)
{
	msg = 'Are you sure want to block this user ?';
	
	if(status)
	{
		msg = 'Are you sure want to unblock this user ?';
	}
	redirect = "<?php echo base_url(); ?>superadmin/superadmin_management/unblock_block/"+user_id+'/'+status
	confirm_box(redirect,msg);
}

<?php
if((!empty($show_modal))&&($show_modal==1))
{
?>
$( document ).ready( function() { 
	$('#myModal').modal('show');
});
<?php
}
?>
</script>

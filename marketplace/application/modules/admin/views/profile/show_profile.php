<style>
/*view user detail*/
.page-header{font-size: 20px;
    margin-top: 15px;
 }
 
.bio-graph-info{font-size:15px;
}

.bio-row{width:80%;
 padding:0;
}
/*end of user detail page*/

.ajax-upload-dragdrop
{
	padding:10px 13px 0px 26px !important; 
	border:none !important; 
}

.fileupload-exists
{
	padding:10px 13px 0px 26px !important;
}
</style>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>css/file_upload/uploadfilemulti.css" />
<?php
$user_type = $this->session->userdata('userType');
?>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
        	<div class="col-lg-12">
            	<section class="panel">
					<?php $this->load->view('success_error_message'); ?>  
                	<div class="col-sm-12 page-header">User Detail</div>
						<?php
						$imageUrl  = base_url().'images/default_user_image.jpg';
						$imageNm   = $users_details->imageName;
						if($user_type=='admin')
						{
							if((!empty($imageNm))&&(file_exists('uploads/admin/thumb50/'.$imageNm)))
							{
								$imageUrl = base_url().'uploads/admin/thumb50/'.$imageNm;
							}
						}
						elseif($user_type=='superadmin')
						{
							if((!empty($imageNm))&&(file_exists('uploads/superadmin/thumb50/'.$imageNm)))
							{
								$imageUrl = base_url().'uploads/superadmin/thumb50/'.$imageNm;
							}
						}
						?>
						<div class="row">
                        	<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
                                    	<?php /*?><a href="<?php echo $imageUrl; ?>"><?php */?>
										<a href="javascript:void(0);">
                                        	<img src="<?php echo $imageUrl; ?>" />
										</a>
                                          <h1>
										  	<?php 
												echo ucwords($users_details->firstName.' '.$users_details->middle.' '.$users_details->lastName); 
											?>
										  </h1>
                                          <p>
										  </p>
                                      </div>
                                  </section>
                              </aside>
                              <aside class="profile-info col-lg-9">
                                  <section class="panel">
                                      <div class="col-sm-12">
                                      	  <a href="<?php echo base_url().$user_type.'/profile/edit_profile'; ?>" class="btn btn-primary" type="button" >
										  Edit
										  </a>
										  
										 
										
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
                            <td><?php echo ucwords($users_details->firstName.' '.$users_details->middle.' '.$users_details->lastName); ?></td>
                        </tr>
                        <tr>
                        	<td>Email : </td>
                            <td><?php echo $users_details->email; ?></td>
                         </tr>
                         
                         <tr>
                         	<td>Date of birth : </td>
                            <td><?php 
								$date=date_create($users_details->birthDay);
								echo date_format($date,"d M");							
							?></td>
                         </tr>
						 <tr>
                         	<td>Country : </td>
                            <td><?php echo $users_details->name; ?></td>
                         </tr>
						 <tr>
                         	<td>State : </td>
                            <td><?php echo $users_details->stateName; ?></td>
                         </tr>
						
                      </tbody>
                    </table>
                                         
                   <!-- <table class="table table-invoice table-custom">
                    	<thead>
                        	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">Comment</th>
                        </thead>
                        <tbody>
                       	<tr>
							<td><?php echo nl2br($users_details->comment); ?></td>
                         </tr>
                      </tbody>
                    </table>-->
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
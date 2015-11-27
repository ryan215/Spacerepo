
<!-- Modal -->
<?php //$this->load->view('staff_managements/addEditAdminForm123');  ?>

<!--main content start-->
<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="javascript:void(0);" class="current">Employee Management</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
					<?php 
					$this->load->view('success_error_message'); 
					?>  
                    <div class="panel-body">
                    	<section class="panel custom-panel">
							<div style="padding:0;" class="col-sm-12">
                            	<div class="col-sm-5 " style="padding: 5px;">
								 <div class="col-sm-2 col-lg-2" style="padding-left:0px;"><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_employee" class="btn btn-sm btn-shadow btn-success hvr-push"  >
										<i class="fa fa-plus"></i>&nbsp;Add
									</a></div>
									<div class="col-sm-4 col-lg-3">
										<div class="form-group">    
                                            <select class="selectpicker  form-control" data-style="btn-success" name="" onchange="" id="" style="width: 75px; display: none;">
                                                <option value="10">10</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
										</div>
									</div>
									<div class="col-lg-5 col-sm-6"  style="padding:0px;">
										   <span class="records_per_page">Records Per Page</span>
									</div>
                                </div>
								<div class="col-sm-7 " style="padding: 5px;">
								<div class="input-group m-bot15 " >
                                              <div class="input-group-btn ">
											  <div style="">
											  <select class="selectpicker form-control" data-style="btn-success" name=""  id="" onchange="">
                                            <option value="">All</option>
											<option value="name">Name</option>
                                        	<option value="email">Email</option>
										</select></div>                                                 
                                              </div>
                                              <input class="form-control" type="search" style="width:100%; border-radius: 0px  5px 5px 0px !important; " onkeyup="ajax_search();" name="search" placeholder="Search" id="search">
                                          </div>
								</div>	
							</div>
                        </section>
                        <section id="unseen">
                             <table class="table table-invoice table-custom">
								<thead>
									<tr>
										<th width="5%">S.No.</th>
										<th width="5%">Image</th>
										<th>Name</th>
										<th>Email</th>
										<th width="13%">User Name</th>
										<th width="3%">Action</th>									  
									</tr>
								</thead>
							    <tbody>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>
									<tr>
									<td>1</td>
									<td>
										<span class="img-cercle"><img src="<?php echo base_url(); ?>images/default_user_image.jpg"></span>
									</td>
									<td class="numeric">Ariyo Afolabi</td>
									<td class="numeric">aafolabi@spacepointe.com</td>
									<td class="numeric">Demo</td>
									<td><center><a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_details" class="btn btn-warning btn-xs tooltips" type="button" title="View Details"><i class="fa fa-eye"></i></a></center></td>										
									</tr>   
								</tbody>
							</table>
                    	</section>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
<!--main content end-->
<script language="javascript" type="application/javascript">
$('.selectpicker').selectpicker('show');
</script>

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li class="">
						<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/employee_list" class="">Employee Management</a>
					</li>
					<li class="">
						<a href="javascript:void(0);" class="current">View</a>
					</li>
				</ul>
			</div>
        	<div class="col-lg-12">
            	<section class="panel">
                	<div class="col-sm-12 page-header panel-heading1">Employee Profile</div>
						<div class="row">
                        	<aside class="profile-nav col-lg-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<a class="example-image-link" data-lightbox="example-1" href="<?php echo base_url(); ?>images/default_user_image.jpg">
                        					<img src="<?php echo base_url(); ?>images/default_user_image.jpg" class="example-image">
										</a>
										<h1>Ariyo  Afolabi</h1>
                                        <p>
										</p>
                                      </div>
                                  </section>
                              </aside>
							  <aside class="profile-info col-lg-9">
									<section class="panel">
										<div class="col-sm-12">
											<div class="col-sm-1" style="padding-left:5px;">
													<a href="<?php echo base_url(); ?>retailer/dashboard/pointepay_html/add_employee" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a></div>
											<div class="col-sm-2" style="padding-left:20px;">
											<?php 
$attributes = array('id' => 'frmSub');
echo form_open('',$attributes);
?>
												<input name="submit" value="Reset Password" class="btn btn-warning" onclick="return reset_password();" type="submit">
											</form>
											</div>
											<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="">UnBlocked</a>							</div>
									</section>
									<section class="panel">
											<div class="panel-body bio-graph-info">
												   <table class="table table-invoice table-custom">
																	<thead><tr><th colspan="2" style="background-color:#A9D86E; color:#FFF;">Personal Detail</th></tr></thead>
																	<tbody>
																		<tr>
																			<td>First Name : </td>
																			<td>Ariyo  Afolabi</td>
																		</tr>
																		<tr>
																			<td>last Name : </td>
																			<td>Ariyo  Afolabi</td>
																		</tr>
																		<tr>
																			<td>Email : </td>
																			<td>aafolabi@spacepointe.com</td>
																		</tr>
																		<tr>
																			<td>Phone No. : </td>
																			<td>+2347896552222</td>
																		 </tr>
																		 <tr>
																			<td>Username : </td>
																			<td>demo</td>
																		</tr>
																		<tr>
																			<td>Salary : </td>
																			<td>&#x20A6;123365.00</td>
																		</tr>
																		</tbody>
																	</table>																				   
												   <table class="table table-invoice table-custom">
																		<thead>
																			<tr><th colspan="2" style="background-color:#A9D86E; color:#FFF;">Roles </th>
																		</tr></thead>
																		<tbody>
																			<tr>
																				<td> Make A Sale : </td>
																				<td><input name="rules[]" id="checkbox1" class="check1" value="8" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label>
																				</td>
																			</tr>
																			<tr>
																				<td>Manage Product : </td>
																				<td><input name="rules[]" id="checkbox2" class="check1" value="9" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label></td>
																			</tr>
																			<tr>
																				<td>Manage Inventory : </td>
																				<td><input name="rules[]" id="checkbox3" class="check1" value="10" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label></td>
																			</tr>
																			<tr>
																				<td>Manage Category : </td>
																				<td><input name="rules[]" id="checkbox4" class="check1" value="11" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label></td>
																			</tr>
																			<tr>
																				<td>Manage Customers : </td>
																				<td><input name="rules[]" id="checkbox5" class="check1" value="12" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label></td>
																			</tr>
																			<tr>
																				<td>Manage Discounts  : </td>
																				<td><input name="rules[]" id="checkbox6" class="check1" value="17" checked="checked" disabled="disabled" type="checkbox"><label for="checkbox1" class="label1">&nbsp;</label></td>
																			</tr>
																			
																		</tbody>
																	</table>
												   <table class="table table-invoice table-custom">
																		<thead><tr><th colspan="2" style="background-color:#A9D86E; color:#FFF;">Address</th></tr></thead>
																		<tbody>
																			<tr>
																				<td>State Name :</td>
																				<td>LAGOS</td>
																			</tr>
																			<tr>
																				<td>Area Name :</td>
																				<td>Demo</td>
																			</tr>
																			<tr>
																				<td>City Name :</td>
																				<td>Demo1</td>
																			</tr>
																			<tr>
																				<td>Street :</td>
																				<td>Demo2</td>
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
<link href="<?php echo base_url(); ?>css/admin/custom_admin.css" type="text/css" rel="stylesheet" />	

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
<style type="text/css">
.rating_icon{  margin-top: 2px; }
.rating_icon .active{ color:#e9ce18; }
.rating_icon .inactive{ color:#d3d3d3; }
</style>

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt">
					<li>
						<a href="<?php echo base_url().'superadmin/product_rating_review'; ?>">
							Product Rating & Review Management
						</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="current">Rating & Review Detail</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel" style="width:100%;  display: inline-block;">
					<?php $this->load->view('success_error_message'); ?>    
                	<div class="col-sm-12 panel-heading panel-heading1" style="height:48px;">
						Rating & Review Details					
					</div>
					<div class="row">							
                    	<aside class="profile-info col-lg-12" style="  display: inline-flex;  padding-top: 20px;"><br />
							<?php
							$imageUrl = base_url().'img/no_image.jpg';
							if((!empty($result['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$result['imageName'])))
							{
								$imageUrl = base_url().'uploads/product/thumb500_500/'.$result['imageName'];
							}
							elseif((!empty($result['imageName']))&&(file_exists('uploads/product/'.$result['imageName'])))
							{
								$imageUrl = base_url().'uploads/product/'.$result['imageName'];
							}
							?>
							<aside class="profile-nav col-lg-3 col-md-3">
                            	<section class="panel">
                                	<div class="user-heading round" style="margin-left:10px;">
										<img src="<?php echo $imageUrl; ?>" class="example-image img-responsive"/>
									</div>
                                </section>
                            </aside>
							<aside class="profile-info col-lg-9">
								
								
								<section class="panel">
                                	
						        	<div class="panel-body bio-graph-info">
                                    	
										<table class="table table-invoice table-custom" style="margin-top:12px;">
						                	<thead>
						                    	<th colspan="2" style="background-color:#A9D86E; color:#FFF;">
													Rating & Review Details
												</th>
						                    </thead>                    
											<tbody>
 							                   	<tr>
						                        	<td width="35%">Product Name : </td>
						                            <td><?php echo $result['productName']; ?></td>
                        						</tr>
                        						<tr>
                        							<td width="35%">Customer Name : </td>
						                            <td>
														<?php 
															echo ucwords($result['firstName'].' '.$result['lastName']); 
														?>
													</td>
                         						</tr> 
												<tr>
                        							<td width="35%">Customer Email : </td>
						                            <td><?php echo $result['email']; ?></td>
                         						</tr>
												<tr>
						                        	<td width="35%">Phone : </td>
						                            <td><?php echo $result['phone']; ?></td>
                        						</tr>
												<tr>
                        							<td width="35%">Review Title : </td>
						                            <td><?php echo $result['reviewTitle']; ?></td>
                         						</tr>
												<tr>
                        							<td width="35%">Review Description : </td>
						                            <td><?php echo nl2br($result['reviewDescription']); ?></td>
                         						</tr>
												<tr>
                        							<td width="35%">Rating : </td>
						                            <td>
														<div class="rating_icon">
															<?php
															for($i=1;$i<=5;$i++)
															{
																if($i<=$result['totalRating'])
																{
																	echo '<span class="fa fa-star active"></span>';
																}
																else
																{
																	echo '<span class="fa fa-star inactive"></span>';
																}
															}
															?>									
														</div>
													</td>
                         						</tr>   											                         						
											</tbody>
                    					</table>
						            	
										
									  
										
                            	</div>
                        	</section>
							 </aside>
                        </aside>
                	</div>
            	</section>
        	</div>
        </div>
    	<!--contant end-->
	</section>
</section>
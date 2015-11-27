<!-- Main Container -->
<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
		<div class="col-main">
			<!--breadcrumb-->
 			<div class="breadcrumbDiv">
				<ul class="breadcrumb">
					<li><a href="<?php echo base_url(); ?>">Home</a></li>
					<li><a href="<?php echo base_url().'frontend/dashboard'; ?>">Dashboard</a></li>
                	<li class="active">My Reviews and Ratings</li>
				</ul>
			</div>
			<!--breadcrumb-->
			
			<div class="col-sm-9" style="padding-left:0px;">
				<div class="my-account">
					<div class="page-title">
						<h2>My Reviews and Ratings </h2> 
					</div>

					<div class="dashboard">             
						<div class=" col-md-12  col-lg-12 col-sm-12 col-xs-12  my_account_right_section " style="padding-bottom: 54px !important;">
     						<div class="divider"></div><br>
							<ul id="tabs" class="nav nav-tabs custom-navtabs" data-tabs="tabs">
								<li>
									<a href="<?php echo base_url().'frontend/dashboard/product_review'; ?>">
										Product Reviews
									</a>
								</li>
								<li class="active">
									<a href="javascript:void(0);">
										Seller Reviews
									</a>
								</li>        
							</ul>
							
							<div id="my-tab-content" class="tab-content">
                				<div class="tab-pane active">
									<div class="col-sm-6 no-padding product_review_left">
										<h3>Reviews by <?php echo $this->session->userdata('userName'); ?></h3>
									</div>
                     				<div class="col-sm-6 no-padding product_review_right" style="text-align:right;">
										<?php /*?><span>
											<b style="line-height:33px; margin-right:20px;">Sort By :</b>
											<select class="form-control account-input pull-right" style="width:200px;">
												<option value="Most Helpful">Most Helpful</option>
												<option value="Most Recent">Most Recent</option>
											</select>
										</span><?php */?>
									</div>
									<?php //echo "<pre>"; print_r($ratingAndReview); exit;
									if(!empty($ratingAndReview))
									{
										foreach($ratingAndReview as $row)
										{
									?>
									<div class="col-sm-12 no-padding reviewman-div" style="border-bottom: 1px solid #ddd; padding-bottom:20px !important;">	
                         				<div class="col-sm-3 no-padding ">
											<div class="img">
												<?php 
													if((!empty($row->product_image))&&(file_exists('uploads/product/thumb50/'.$row->product_image)))
													{
													?>
													<a class="product-image" href="javascript:void(0);">
														<img width="75" height="75" src="<?php echo base_url().'uploads/product/thumb50/'.$row->product_image; ?>">
													</a>
													<?php
													}
													else
													{
													?>
													<a class="product-image" href="javascript:void(0);">
														<img src="<?php echo base_url().'img/no_image.jpg'; ?>" height="70" width="70"/>
													</a>
													<?php
													}
													?>	
											</div>
										</div>
										
										<div class="col-sm-6 no-padding ">
											<div class="item-div">							
												<span>
													<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($row->order_product_id); ?>">
														<?php echo $row->product_name; ?>
													</a> 
												</span><br>
												<span class="cart-price">
													Price : &#x20A6;<?php echo number_format($row->product_price,2); ?>
												</span><br>
												<span style="font-size:11px;">	
													Seller : <?php echo $row->retailer_name; ?>												
												</span><br>
											</div>   
										</div>

										<?php
										if(!empty($row->avg_rating))
										{
										?>
										<div class="col-sm-3 no-padding">
                            				<div class="item-div">		
												<span><b>Good</b></span> 
												<span style="font-size:11px;">
													on <?php echo date('Y-m-d',$row->last_modified_time); ?>
												</span><br>
												
												<span class="histo-star">
													rated: 
													<?php 													
													for($i=1;$i<=round($row->avg_rating);$i++)
													{
														echo '<span class="fa-star fa"></span>';
													}
													?>
												</span>
                            				</div>
										</div>
										<?php
										}
										?>
										<div class="col-sm-12" style="padding-top:10px;">
											<?php
											if(!empty($row->rating_review))
											{
												echo nl2br($row->rating_review);
											}
											?>
											<div class="col-sm-12 no-padding" style="padding-top: 20px !important;text-align: right;">
												<span style="text-align:right;">
													<?php
													if(!empty($row->rating_id))
													{
													?>
													<a href="<?php echo base_url().'frontend/dashboard/edit_seller_review/'.id_encrypt($row->rating_id); ?>" class="review_edit">
														Edit
													</a>&nbsp;&nbsp;&nbsp;&nbsp;
													<a href="javascript:void(0);" class="review_delete" onclick="return delete_review('<?php echo id_encrypt($row->rating_id); ?>');">
														Delete
													</a>
													<?php
													}
													else
													{
													?>
													<a href="<?php echo base_url().'frontend/seller/seller_rating/'.id_encrypt($row->order_retailer_id); ?>" class="review_delete">
														Add
													</a>
													<?php
													}
													?>
												</span>
											</div>											
										</div>
									</div>
									<?php	
										}
									}
									else
									{
									?>
									<div class="col-sm-12 no-padding reviewman-div" style="border-bottom: 1px solid #ddd; padding-bottom:20px !important;">	
										No Rating and Reivew
                         			</div>
									<?php
									}
									?>
									                         
								</div>
							</div>
						</div>
					</div>          
        		</div>
      		</div>
	  		<?php $this->load->view('right_bar'); ?>
  		</div>
	</div>
</section>
<!-- Main Container End -->

<script type="text/javascript">
function delete_review(ratingID)
{
	if(confirm('Are you sure want to delete this ?'))
	{
		window.location.href = '<?php echo base_url().'frontend/dashboard/delete_seller_review/'; ?>'+ratingID;
	}
	return false;
}
</script>
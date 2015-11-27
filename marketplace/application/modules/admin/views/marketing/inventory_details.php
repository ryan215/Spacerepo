<div class="col-lg-12">
<section class="panel">
                          <header class="panel-heading">
                         	Inventory Details
							  
                          </header>
                          <div class="panel-body">
                              <div class="col-lg-12" style="padding:0;">
                              <section class="panel">
                                  <div class="panel-body" style="padding:0;">
<?php echo form_open();?>
<input type="hidden" name="currentQty" value="<?php echo $result['currentQty']; ?>" />
<div class="summary-list">
	<div class="col-lg-8 pull-right">
		<div class="col-lg-6 pull-right">
			<div class="col-lg-3 pull-right">
            	<?php
				if(($this->session->userdata('userType')=='superadmin')||($this->session->userdata('userType')=='admin'))
				{
				?>
            	<a class="btn btn-primary pull-right" type="button" href="<?php echo base_url();?>admin/product_marketing_management/edit_product/<?php echo id_encrypt($marketingProductId);?> ">
				<i class="fa fa-pencil"></i> Edit Details
			</a>
               <?php 	
				}
											//  echo $result['active'];
											if(isset($result['active']))
											{
											  if($result['active']==1)
														{
														?>
														<a href="javascript:void(0);" class="btn btn-success pull-right" type="button" style="margin-left:20px;" onclick="unblock_block('<?php echo id_encrypt($result['marketingProductId']); ?>',0);">
															UnBlocked
														</a>
														<?php
														}
														else
														{
														?>
														<a href="javascript:void(0);" class="btn btn-danger pull-right" type="button" style="margin-left:20px;" onclick="unblock_block('<?php echo id_encrypt($result['marketingProductId']); ?>',1);">
															Blocked
														</a>			
														<?php
														}			
											}
														?>	
                                         </div>
									  </form>
                                  </div>
                              </section> 
                          </div>
						  <div class="col-lg-12 stock-div pd">
						  	<div class="col-sm-4 state-overview pd">
                                  <section class="panel">
                                      <div class="symbol symbol1 red stock-red-div">
                                          Stock Left
                                      </div>
                                      
									
							
														
													
                                                      	<?php 
										$sizearray=str_replace(',','',$result['product_size']);
										if(isset($sizearray) && !empty($sizearray)){
												$colorArr=explode(',',$result['colorId']);	
												?>

													

													<table width="100%" class="table table-striped   stock_table">
													
													
													<tr><td><strong>Sizes</strong></td><td><strong>Stock</strong></td></tr>
													<?php
													$sizeArr=explode(',',$result['product_size']);
															$stockArr=explode(',',$result['stock']);
															
															
														?>
															
														
														<?php 
														$colorcode='';	
													foreach($sizeArr as $key=>$size){
													  if(!empty($colorArr)){ 
														if($colorcode !=$colorArr[$key]){
													$colorcode=$colorArr[$key];
													if(isset($result['color_list'][$colorArr[$key]])){ ?>
													<tr><td colspan="2"><small style="background-color:<?php if(isset($result['color_list'][$colorArr[$key]])){ echo $result['color_list'][$colorArr[$key]]; } ?>"></small></td></tr>
													  <?php } } } ?>
														<tr><td><?php echo $size; ?></td><td><?php echo $stockArr[$key]; ?></td></tr>
														<?php 
													}
													
													?>
													
													</table>
													<?php }
													
													elseif(isset($result['colorId']) && !empty($result['colorId'])){
														?>	<table width="100%" class="table table-striped   stock_table">
													
													
													<tr><td><strong>color</strong></td><td><strong>Stock</strong></td></tr>
													<?php $colorArr=explode(',',$result['colorId']);
													$stockArr=explode(',',$result['stock']);
													foreach($colorArr as $key=>$colordetail){
														?>
														<tr><td><small style="background-color:<?php echo $result['color_list'][$colorArr[$key]];?>"></small></td><td><?php echo $stockArr[$key]; ?></td></tr>
														<?php 
													}
													?>
													</table><?php 
													}
													else{
														?>
                                                        <label style="margin-top: 25px;">
														<?php echo $result['currentQty']; ?>
														</label>
														<?php 
													}
													?>
											
										
										
									 
                                  </section>
                              </div>
						  </div>
						  
						  <!--start product detail page-->
						  <div class="col-sm-12 pd">
						  	<div class="col-sm-12 detail-plus pd">
								Product Detail
							</div>
							<div class="dtl-div col-sm-12 pd" >
                            	
                                	<aside class="profile-nav col-lg-3 pd" style="padding-top:12px;">
                                    <section class="panel">
                                        <div class="user-heading round" style="margin-left:10px;">
                                            <?php /*?><a class="example-image-link" data-lightbox="example-1" href="http://192.168.1.5/marketplace/images/default_user_image.jpg"><?php */?>
											<?php 
											if((!empty($result['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$result['imageName'])))
											{
											
												echo '<img src="'.base_url().'uploads/product/thumb500_500/'.$result['imageName'].'" height="150" width="150" />';
											}
											elseif((!empty($result['imageName']))&&(file_exists('uploads/product/'.$result['imageName'])))
											{
											
												echo '<img src="'.base_url().'uploads/product/'.$result['imageName'].'" height="150" width="150" />';
											}
											else
											{
												echo '<img src="'.base_url().'img/no_image.jpg" height="150" width="150"/>';
											}
											?>	
                                               
                                            <?php /*?></a><?php */?>
                                            <h1><?php echo $result['productName']; ?></h1>
                                            <p>
                                            </p>
                                          </div>
                                      </section>
                                  </aside>
                               
								<div class="col-sm-9">
                                	<table class="table table-invoice">
                                    	<thead>
                                            <tr>
                                                <th colspan="2">Details</th>
                                            </tr>
                                        </thead>
                                        <tr>
                                            <td>Product Name</td>
                                            <td>
												<a href="<?php echo base_url().$this->session->userdata('userType').'/product_management/view/'.id_encrypt($result['productId']); ?>">
												<?php echo $result['productName']; ?>
												</a>
											</td>
                                        </tr>
										<tr>
                                            <td>Stock Details</td>
                                            
										
														<td><?php echo $result['currentQty']; ?></td>
														
                                        </tr>
                                        <tr>
                                            <td>Actual Price</td>
                                            <td>&#x20A6;<?php echo number_format($result['displayPrice'],2); ?></td>
                                        </tr>                                        
                                       
										<tr>
                                            <td>Effective Sale Price</td>
                                            <td>&#x20A6;<?php echo number_format($result['currentPrice'],2); ?></td>
                                        </tr>
                                    </table>
                                </div>
							</div>
						  </div>
						  <!--enf of product detail page-->
						  
                         </div>
                      </section>
</div>

<script>
function unblock_block(product_id,status)
{
	msg = 'Are you sure want to block this product ?';
	
	if(status)
	{
		msg = 'Are you sure want to Unblock this product ?';
	}
	
	swal({   
	title: '',   
	text: msg,   
	type: "warning",   
	showCancelButton: true,   
	confirmButtonColor: "#DD6B55",   
	confirmButtonText: "Yes",   
	cancelButtonText: "No",   
	closeOnConfirm: false,   
	closeOnCancel: false 
	}, 
	function(isConfirm){   
		if (isConfirm) 
		{     
			window.location.href = "<?php echo base_url().$this->session->userdata('userType').'/product_marketing_management/unblock_block/'; ?>"+product_id+'/'+status;
		} 
		else 
		{     
			swal("Cancelled","", "error");   
		} 
	});
}
</script>  
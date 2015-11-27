	<?php if(!empty($product_detial)){
		foreach($product_detial->results as $key=>$product_info){ 
		
		?>
	
	
					<div class="panel panel-default one_box">
									<div class="panel-heading ">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>">
											<dl> 
													 	<dd width="2%"><?php if(isset($product_info->images[0])){ ?><img style="height:30px;width:30px;" src="<?php echo $product_info->images[0];?>"> <?php } ?> </dd>
														<dd width="20%"><p><?php echo $product_info->name;?></p></dd>
														
														
														
												</dl>
											
											</a>
										</h4>
									</div>
									<div id="collapse<?php echo $key;?>" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#">
																			  <?php if(isset($product_info->images[0]))
																						{ ?>
																						<img src="<?php echo $product_info->images[0];?>" alt="">
																				<?php	 } ?>
																																	  </a>
																			  <h1><?php if(isset($product_info->name)){ echo $product_info->name; }?></h1>
																			  
																		  </div>
																		   <br />
																		  <center> <a href="<?php echo base_url().$this->session->userdata('userType'); ?>/semantics/add_product/<?php echo $time.'/'.$key; ?>" class="btn btn-primary "><i class="fa fa-plus"></i> Add To Product list</a>
																		  </center>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 ">
																							  
																	 <section class="panel">
															  
															  <div class="panel-body bio-graph-info">
																  
																  <div class="row">
																    <?php
																			if(isset($product_info->features) && !empty($product_info->features))
																			{
																			  foreach($product_info->features as $key1=>$value)
																			  {
																				  echo ' <div class="bio-row">
																					  <p><span>'.$key1.' </span>: '.$value.'</p>
																						</div>';
																			  }
																			}
											 
																		?>
										 									  </div>
															  </div>
															  <p><a class="btn pull-right btn-warning btn-xs btn-circle" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key;?>"><i class="fa fa-arrow-up"></i></a></p>
														  </section>						   
																	 </aside>
																	</div>
										</div>
									</div>
								</div>
		<?php }
	}
 <style>
 .switch {
    position: relative;
    height: 26px;
    width: 120px;
    margin: 10px 0 0;
    background: #F1F2F7;
    border-radius: 3px;
    text-align:center;
  
  }
  
  .switch-label {
    position: relative;
    z-index: 2;
    float: left;
    width: 58px;
    line-height: 26px;
    font-size: 11px;
    color: #666;
    text-align: center;
    font-size:25px;
    cursor: pointer;
    padding-left:0 !important;
  }
  .switch-label:active {
    font-weight: bold;
  }
  
  .switch-label-off {
    padding-left: 2px;
  }
  
  .switch-label-on {
    padding-right: 2px;
  }
   small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 100%;
}

  
  .switch-input {
    display: none;
  }
  .switch-input:checked + .switch-label {
    font-weight: bold;
    color: #fff;
    text-shadow: 0 1px rgba(255, 255, 255, 0.25);
    -webkit-transition: 0.15s ease-out;
    -moz-transition: 0.15s ease-out;
    -ms-transition: 0.15s ease-out;
    -o-transition: 0.15s ease-out;
    transition: 0.15s ease-out;
    -webkit-transition-property: color, text-shadow;
    -moz-transition-property: color, text-shadow;
    -ms-transition-property: color, text-shadow;
    -o-transition-property: color, text-shadow;
    transition-property: color, text-shadow;
  }
  .switch-input:checked + .switch-label-on ~ .switch-selection {
    left: 60px;
    / Note: left: 50%; doesn't transition in WebKit /
  }
  
  .switch-selection {
    position: absolute;
    z-index: 1;
    height: 100%;
    left: 2px;
    display: block;
    width: 60px;
    border-radius: 3px;
    background-color: #8CB94D;
    -webkit-transition: left 0.15s ease-out;
    -moz-transition: left 0.15s ease-out;
    -ms-transition: left 0.15s ease-out;
    -o-transition: left 0.15s ease-out;
    transition: left 0.15s ease-out;
  }
		label{background-image:none;
		}
		.chosen-container-single .chosen-single{background:none !important;
			border:1px solid #CCC !important;
			border-radius:4px !important; 
		}
		.panel-heading .nav > li > a{font-size:15px;
			font-weight:600;
		}
		
		 .table-invoice tr th{color:#FFF;
		}
		.summary-list li{height:45px;
		}
		
		.summary-list li:first-child{width:15%;
		}
		.summary-list li:nth-child(2){width:20%;
			padding: 5px 9px 5px 5px;
			vertical-align:top;
		}
		.summary-list li:last-child{width:10%;
			text-align:center;
			padding:5px 15px;
		}
		.summary-list .r-activity{margin:0;
		}
		.btn-space{padding:5px 20px;
		}
		.symbol1{font-size: 21px;
			color:#fff;
		}
		.detail-plus{font-size:21px;
		}
		.detail-plus i{font-size:34px;
			padding-left:10px;
		}
		.stock-div{border-bottom:1px solid #ccc;
			margin-bottom:15px;
		}
		
		.stock-left-numbers{padding: 0px 21px ! important; text-align: center;
		}
		
		.stock-red-div{float:left;
			background-color:#fff !important;
			color:#1FB5AD;
			width:160px !important;
			font-weight:700;
			font-size:22px;
			text-align:left !important;
		}
		.stock_table tr td{ padding:5px !Important;}
		.sizes_label{
		top: -2px;
  		position: relative}
		input[type=checkbox] {
			  margin: 4px 8px 0px !important;
			  line-height: normal;
			}
		 small {
	border: 1px solid #DDDDDD;
	display: inline-block;
	height: 14px;
	margin: 0 3px 0 1px;
	width: 14px;
}
.block-element label {
  float: left;
  margin-right: 18px;
}
.color-filter .block-element {float:left;
}
	</style>
    
      <section id="main-content">
          <section class="wrapper">
		  		<?php $this->load->view('success_error_message'); ?> 
              <!--contant start-->
              <div class="row">
			  	<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
					
					<li>
						<a href="<?php echo base_url().'cse/product_management/check_stocks/'.id_encrypt($organizationId); ?>">Inventory</a>
					</li>
									
					<li>
						<a class="current" href="javascript:void(0);">
							Inventory Details
						</a>
					</li>
				</ul>
			</div>
			  	
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              Edit Inventory
							  
                          </header>
                          <div class="panel-body">
                              <div class="col-lg-12" style="padding:0;">
                              <section class="panel">
                                  <div class="panel-body" style="padding:0;">
<?php echo form_open();?>
<input type="hidden" name="currentQty" value="<?php echo $result['currentQty']; ?>" />
	<div class="summary-list">
    
									<div class="col-lg-8 pull-left">
				<div class="col-lg-6 pull-left">
		
									   <div class="col-lg-3">
                                              <?php 	
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
											if((!empty($result['imageName']))&&(file_exists('uploads/product/'.$result['imageName'])))
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
                                            <td>&#x20A6;<?php echo number_format($result['costprice'],2); ?></td>
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
              </div>
              <!--contant end-->
          </section>
      </section>
      <!--main content end-->
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
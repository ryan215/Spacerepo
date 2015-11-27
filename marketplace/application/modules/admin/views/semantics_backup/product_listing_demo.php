<link href="<?php echo base_url().'css/table_search_style.css'; ?>" rel="stylesheet" type="text/css" />
<style>
label{
	background-image:none;
}

.chosen-container-single .chosen-single{
	background:none !important;
	border:1px solid #CCC !important;
	border-radius:4px !important; 
}

.panel-heading .nav > li > a{
	font-size:15px;
	font-weight:600;
}

.nav-justified {background:#bcc1c5;
}

.table-invoice > thead > tr > th{color:#FFF;
}

.btn-reqt{border:1px solid #ccc;
}

.notifi{position:absolute !important;
	top:-8px !important;
}

#header_notification_bar {
list-style-type: none !important;
float: left;
padding-left: 20px;
}
</style>

<section id="main-content">
	<section class="wrapper">
    	<!--contant start-->
        <div class="row">
			<div class="col-md-12">
				<ul class="breadcrumbs-alt animated fadeInLeft">
				
					<li>
						<a href="javascript:void(0);" class="current">Semantics List</a>
					</li>
				</ul>
			</div>
        	
			<div class="col-lg-12">
            	<section class="panel">
						<div class="panel-body">
							<section class="panel custom-panel" style="margin-bottom:0;">
									<div style="padding:0;" class="col-lg-12">
										<div class="col-sm-5 " style="padding: 0px;">									
											<div class="col-sm-3" style="padding-left:5px;">
												<div class="form-group">
													<select class="selectpicker chosen-select form-control"  name='sel_no_entry' onchange="ajax_search();"  id='sel_no_entry' style="width:75px;display: inline-block;">
														<option value="10">10</option>
														<option value="50">50</option>
														<option value="100">100</option>
													</select>
												</div>
											</div>
											<div class="col-sm-5"  style="padding:0px;"> <span class="records_per_page">Records Per Page</span> </div>									
										</div>
										<div class="col-sm-7" style="padding-right:0px;">
											<div class="input-group m-bot15">
													<input type="text" placeholder="Enter Product Name" id="search" class="form-control">
													<span class="input-group-btn">
															<button class="btn btn-danger" type="button" onclick="ajaxPage();"><i class="fa fa-search"></i> Search</button>
														  </span>
											 </div>
										</div>
									</div>	
							</section>
							<section class="panel custom-panel" id="accordion">	
							
							<div class="bs-example">
								<div class="panel-group" id="accordion">
								<div class="panel panel-default one_box">
									<div class="panel-heading ">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
												<dl> 
													 	<dd width="2%"><img style="height:30px;width:30px;" src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg"> </dd>
														<dd width="20%"><p>Apple iPhone 6 Plus, Gold, 16 GB </p></dd>
														<dd width="5%"><p class="text-success">$730.00</p></dd>
														<dd width="50%"><p style="font-weight:normal;">Language support English (Australia, Canada, UK, U... (visit site URLs for full description) asdasdasdasd</p></dd>
														
												</dl>
											
											</a>
										</h4>
									</div>
									<div id="collapseOne" class="panel-collapse collapse">
										<div class="panel-body">
										   <div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#">
																																		  <img src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg" alt="">
																																	  </a>
																			  <h1>Apple iPhone 6 Plus, Gold, 16 GB (Unlocked)</h1>
																			  <p>$730.00</p>
																		  </div>
																		 <br />
																		 <center> <button class="btn btn-primary "><i class="fa fa-shopping-cart"></i> Add To Product</button>
																		  </center>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 ">																		  
																	 <section class="panel">															  
																	 <div class="panel-body bio-graph-info">
																		  
																		  <div class="row">
																		   <div class="bio-row">
																				  <p><span>Browser </span>: HTML -Safari-</p>
																			  </div> <div class="bio-row">
																				  <p><span>Internal Memory </span>: 16GB, 1GB RAM</p>
																			  </div> <div class="bio-row">
																				  <p><span>Standby </span>: Up to 384 Hours -3G-</p>
																			  </div> <div class="bio-row">
																				  <p><span>Phone Cellular Band </span>: GSM</p>
																			  </div> <div class="bio-row">
																				  <p><span>3G </span>: HSDPA 850 - 900 - 1700 - 1900 - 2100</p>
																			  </div> <div class="bio-row">
																				  <p><span>Operating System </span>: iOS 8</p>
																			  </div> <div class="bio-row">
																				  <p><span>Battery </span>: Built-in rechargeable lithium-ion Battery</p>
																			  </div> <div class="bio-row">
																				  <p><span>Dimensions </span>: 6.22 x 3.06 x 0.28 -inches-</p>
																			  </div> <div class="bio-row">
																				  <p><span>Carrier </span>: AT-T</p>
																			  </div> <div class="bio-row">
																				  <p><span>Display </span>: 5.5- LED-backlit IPS LCD Multi-Touchscreen Shatter proof glass, oleophobic coating</p>
																			  </div> <div class="bio-row">
																				  <p><span>Front-facing Camera </span>: 1.2 Megapixel Camera, 720p, burst, HDR</p>
																			  </div> <div class="bio-row">
																				  <p><span>Chipset </span>: Apple A8, PowerVR GX6650 -hexa-core graphics- Graphics</p>
																			  </div> <div class="bio-row">
																				  <p><span>2G </span>: GSM 850 - 900 - 1800 - 1900</p>
																			  </div> <div class="bio-row">
																				  <p><span>Camera </span>: 8 Megapixel Camera -3264 x 2448 pixels- w- Autofocus, dual-LED -dual tone- flash</p>
																			  </div> <div class="bio-row">
																				  <p><span>Bluetooth </span>: v4.0, A2DP</p>
																			  </div> <div class="bio-row">
																				  <p><span>4G </span>: LTE 700 - 800 - 850 - 900 - 1700 - 1800 - 1900 - 2100 - 2600</p>
																			  </div> <div class="bio-row">
																				  <p><span>Color Class </span>: Gold</p>
																			  </div> <div class="bio-row">
																				  <p><span>GPS </span>: with A-GPS, GLONASS</p>
																			  </div> <div class="bio-row">
																				  <p><span>USB </span>: v2.0</p>
																			  </div> <div class="bio-row">
																				  <p><span>Messaging </span>: iMessage, SMS -threaded view-, MMS, Email, Push Email</p>
																			  </div> <div class="bio-row">
																				  <p><span>Phone Style Type </span>: Candy Bar</p>
																			  </div> <div class="bio-row">
																				  <p><span>Talktime </span>: Up to 24 Hours -3G-</p>
																			  </div>										  </div>
																	  </div>
																	 <p><a class="btn pull-right btn-warning btn-xs btn-circle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-arrow-up"></i></a></p>
														  			</section>						   
																	 </aside>
																	</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default one_box">
									<div class="panel-heading ">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
											<dl> 
													 	<dd width="2%"><img style="height:30px;width:30px;" src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg"> </dd>
														<dd width="20%"><p>Apple iPhone 6 Plus, Gold, 16 GB </p></dd>
														<dd width="5%"><p class="text-success">$730.00</p></dd>
														<dd width="50%"><p style="font-weight:normal;">Language support English (Australia, Canada, UK, U... (visit site URLs for full description)</p></dd>
														
												</dl>
											
											</a>
										</h4>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse">
										<div class="panel-body">
											<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#">
																																		  <img src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg" alt="">
																																	  </a>
																			  <h1>Apple iPhone 6 Plus, Gold, 16 GB (Unlocked)</h1>
																			  <p>$730.00</p>
																		  </div>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 ">
																							  
																	 <section class="panel">
															  
															  <div class="panel-body bio-graph-info">
																  
																  <div class="row">
																   <div class="bio-row">
																		  <p><span>Browser </span>: HTML -Safari-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Internal Memory </span>: 16GB, 1GB RAM</p>
																	  </div> <div class="bio-row">
																		  <p><span>Standby </span>: Up to 384 Hours -3G-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Phone Cellular Band </span>: GSM</p>
																	  </div> <div class="bio-row">
																		  <p><span>3G </span>: HSDPA 850 - 900 - 1700 - 1900 - 2100</p>
																	  </div> <div class="bio-row">
																		  <p><span>Operating System </span>: iOS 8</p>
																	  </div> <div class="bio-row">
																		  <p><span>Battery </span>: Built-in rechargeable lithium-ion Battery</p>
																	  </div> <div class="bio-row">
																		  <p><span>Dimensions </span>: 6.22 x 3.06 x 0.28 -inches-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Carrier </span>: AT-T</p>
																	  </div> <div class="bio-row">
																		  <p><span>Display </span>: 5.5- LED-backlit IPS LCD Multi-Touchscreen Shatter proof glass, oleophobic coating</p>
																	  </div> <div class="bio-row">
																		  <p><span>Front-facing Camera </span>: 1.2 Megapixel Camera, 720p, burst, HDR</p>
																	  </div> <div class="bio-row">
																		  <p><span>Chipset </span>: Apple A8, PowerVR GX6650 -hexa-core graphics- Graphics</p>
																	  </div> <div class="bio-row">
																		  <p><span>2G </span>: GSM 850 - 900 - 1800 - 1900</p>
																	  </div> <div class="bio-row">
																		  <p><span>Camera </span>: 8 Megapixel Camera -3264 x 2448 pixels- w- Autofocus, dual-LED -dual tone- flash</p>
																	  </div> <div class="bio-row">
																		  <p><span>Bluetooth </span>: v4.0, A2DP</p>
																	  </div> <div class="bio-row">
																		  <p><span>4G </span>: LTE 700 - 800 - 850 - 900 - 1700 - 1800 - 1900 - 2100 - 2600</p>
																	  </div> <div class="bio-row">
																		  <p><span>Color Class </span>: Gold</p>
																	  </div> <div class="bio-row">
																		  <p><span>GPS </span>: with A-GPS, GLONASS</p>
																	  </div> <div class="bio-row">
																		  <p><span>USB </span>: v2.0</p>
																	  </div> <div class="bio-row">
																		  <p><span>Messaging </span>: iMessage, SMS -threaded view-, MMS, Email, Push Email</p>
																	  </div> <div class="bio-row">
																		  <p><span>Phone Style Type </span>: Candy Bar</p>
																	  </div> <div class="bio-row">
																		  <p><span>Talktime </span>: Up to 24 Hours -3G-</p>
																	  </div>										  </div>
															  </div>
															  <p><a class="btn pull-right btn-warning btn-xs btn-circle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-arrow-up"></i></a></p>
														  </section>						   
																	 </aside>
																	</div>
										</div>
									</div>
								</div>
								<div class="panel panel-default one_box">
									<div class="panel-heading ">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
											<dl> 
													 	<dd width="2%"><img style="height:30px;width:30px;" src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg"> </dd>
														<dd width="20%"><p>Apple iPhone 6 Plus, Gold, 16 GB </p></dd>
														<dd width="5%"><p class="text-success">$730.00</p></dd>
														<dd width="50%"><p style="font-weight:normal;">Language support English (Australia, Canada, UK, U... (visit site URLs for full description)</p></dd>
														
												</dl>
											</a>
										</h4>
									</div>
									<div id="collapseThree" class="panel-collapse collapse">
										<div class="panel-body">                   
												<div class="col-sm-12  semantics_box padding_left_zero padding_right_zero">
																	<aside class="profile-nav col-lg-3 padding_left_zero">
																	  <section class="panel">
																		  <div class="user-heading round">
																			  <a href="#">
																																		  <img src="http://sem3-idn.s3-website-us-east-1.amazonaws.com/3c348723db4443791f0db51e0d5f6221,0.jpg" alt="">
																																	  </a>
																			  <h1>Apple iPhone 6 Plus, Gold, 16 GB (Unlocked)</h1>
																			  <p>$730.00</p>
																		  </div>
																	  </section>
																	</aside>
																	<aside class="profile-info col-lg-9 ">
																							  
																	 <section class="panel">
															  
															  <div class="panel-body bio-graph-info">
																  
																  <div class="row">
																   <div class="bio-row">
																		  <p><span>Browser </span>: HTML -Safari-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Internal Memory </span>: 16GB, 1GB RAM</p>
																	  </div> <div class="bio-row">
																		  <p><span>Standby </span>: Up to 384 Hours -3G-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Phone Cellular Band </span>: GSM</p>
																	  </div> <div class="bio-row">
																		  <p><span>3G </span>: HSDPA 850 - 900 - 1700 - 1900 - 2100</p>
																	  </div> <div class="bio-row">
																		  <p><span>Operating System </span>: iOS 8</p>
																	  </div> <div class="bio-row">
																		  <p><span>Battery </span>: Built-in rechargeable lithium-ion Battery</p>
																	  </div> <div class="bio-row">
																		  <p><span>Dimensions </span>: 6.22 x 3.06 x 0.28 -inches-</p>
																	  </div> <div class="bio-row">
																		  <p><span>Carrier </span>: AT-T</p>
																	  </div> <div class="bio-row">
																		  <p><span>Display </span>: 5.5- LED-backlit IPS LCD Multi-Touchscreen Shatter proof glass, oleophobic coating</p>
																	  </div> <div class="bio-row">
																		  <p><span>Front-facing Camera </span>: 1.2 Megapixel Camera, 720p, burst, HDR</p>
																	  </div> <div class="bio-row">
																		  <p><span>Chipset </span>: Apple A8, PowerVR GX6650 -hexa-core graphics- Graphics</p>
																	  </div> <div class="bio-row">
																		  <p><span>2G </span>: GSM 850 - 900 - 1800 - 1900</p>
																	  </div> <div class="bio-row">
																		  <p><span>Camera </span>: 8 Megapixel Camera -3264 x 2448 pixels- w- Autofocus, dual-LED -dual tone- flash</p>
																	  </div> <div class="bio-row">
																		  <p><span>Bluetooth </span>: v4.0, A2DP</p>
																	  </div> <div class="bio-row">
																		  <p><span>4G </span>: LTE 700 - 800 - 850 - 900 - 1700 - 1800 - 1900 - 2100 - 2600</p>
																	  </div> <div class="bio-row">
																		  <p><span>Color Class </span>: Gold</p>
																	  </div> <div class="bio-row">
																		  <p><span>GPS </span>: with A-GPS, GLONASS</p>
																	  </div> <div class="bio-row">
																		  <p><span>USB </span>: v2.0</p>
																	  </div> <div class="bio-row">
																		  <p><span>Messaging </span>: iMessage, SMS -threaded view-, MMS, Email, Push Email</p>
																	  </div> <div class="bio-row">
																		  <p><span>Phone Style Type </span>: Candy Bar</p>
																	  </div> <div class="bio-row">
																		  <p><span>Talktime </span>: Up to 24 Hours -3G-</p>
																	  </div>										  </div>
															  </div>
															  <p><a class="btn pull-right btn-warning btn-xs btn-circle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-arrow-up"></i></a></p>
														  </section>						   
																	 </aside>
																	</div>										
										</div>
									</div>
								</div>
							</div>
							</div>
							</section>							                         
						</div>
                </section>
            </div>
              </div>
              <!--contant end-->
          </section>
      </section>
	  
<script type="text/javascript">
$('.selectpicker').selectpicker('show');


</script>
<style>
.padding_left_zero{
	padding-left:0px;
}
.padding_right_zero{
	padding-right:0px;
}
.semantics_box{

}
.one_box{ bottom: 0;
  box-shadow: 0 -1px 0 #e5e5e5,0 0 2px rgba(0,0,0,.12),0 2px 4px rgba(0,0,0,.24);
  padding:5px; cursor:pointer; margin-bottom:10px;
 }
.one_box tr td{ padding:5px; font-weight:bold; } 
dl{ margin:0px;}
dd { 
    display: inline-block;
    margin-left: 14px;
}
.panel-heading{ padding:0px;}
</style>
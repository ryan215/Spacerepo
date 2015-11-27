<section id="main-content">
          <section class="wrapper">
              <!--mail inbox start-->
              <div class="mail-box">
                  <aside class="sm-side">
                      <div class="user-head">
                         <!-- <a href="javascript:;" class="inbox-avatar">
                              <img src="img/mail-avatar.jpg" alt="">
                          </a>-->
                          <div class="user-name">
                              <h3 style="margin-top:15px;">NewsLetter Mails</h3>
                          </div>
                         <!-- <a href="javascript:;" class="mail-dropdown pull-right">
                              <i class="fa fa-chevron-down"></i>
                          </a>-->
                      </div>
                      <div class="inbox-body">
                          <a class="btn btn-compose" data-toggle="modal" href="<?php echo base_url(); ?>admin/news_subscription/test4">
                              Compose
                          </a>
                          <!-- Modal -->
                          <?php /*?><div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog" style="width:650px;">
                                  <div class="modal-content">
                                      <div class="modal-header" style="border-radius:0px;">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h4 class="modal-title">Compose</h4>
                                      </div>
                                      <div class="modal-body">
                                          <form class="form-horizontal" role="form">
                                             
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Subject</label>
                                                  <div class="col-lg-10">
                                                      <input type="text" class="form-control" id="inputPassword1" placeholder="">
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Message</label>
                                                  <div class="col-lg-10">
                                                      <textarea name="" id="" class="form-control" cols="30" rows="10"></textarea>
                                                  </div>
                                              </div>

                                              <div class="form-group">
                                                  <div class="col-lg-offset-2 col-lg-10">
                                                      
                                                      <button type="submit" class="btn btn-send">Send</button>
                                                  </div>
                                              </div>
                                          </form>
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><?php */?><!-- /.modal -->
                      </div>
                      <ul class="inbox-nav inbox-divider">
                          <li class="active">
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test1"><i class="fa fa-inbox"></i> Newsletter History <span class="label label-warning pull-right">04</span></a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test2"><i class="fa fa-user"></i> Subscribed <span class="label label-success pull-right">04</span></a>
                          </li>
                          <li>
                              <a href="<?php echo base_url(); ?>admin/news_subscription/test3"><i class="fa fa-user"></i> Unsubscribed <span class="label label-info pull-right">04</span></a>
                          </li>
                      </ul>
                  </aside>
                  <aside class="lg-side">
                      <div class="inbox-head">
                          <h3>Newsletter History</h3>
                          <form class="pull-right position" action="#">
                              <div class="input-append">
                                  <input type="text"  placeholder="Search" class="sr-input">
                                  <button type="button" class="btn sr-btn"><i class="fa fa-search"></i></button>
                              </div>
                          </form>
                      </div>
                      <div class="inbox-body">
                         <div class="mail-option">
                             <!--<div class="chk-all">
                                 <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                 <div class="btn-group" >
                                     <a class="btn mini all" href="#" data-toggle="dropdown">
                                         All
                                         <i class="fa fa-angle-down "></i>
                                     </a>
                                     <ul class="dropdown-menu">
                                         <li><a href="#"> None</a></li>
                                         <li><a href="#"> Read</a></li>
                                         <li><a href="#"> Unread</a></li>
                                     </ul>
                                 </div>
                             </div>-->

                             <div class="btn-group">
                                 <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="Refresh"><i class=" fa fa-refresh"></i>
                                 </a>
								  
                             </div>
							  <!--<div class="btn-group">
                                 
								  <a class="btn mini tooltips" href="#" data-toggle="dropdown" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i>
                                 </a>
                             </div>-->
                             <ul class="unstyled inbox-pagination">
                                 <li><span>1-50 of 234</span></li>
                                 <li>
                                     <a href="#" class="np-btn"><i class="fa fa-angle-left  pagination-left"></i></a>
                                 </li>
                                 <li>
                                     <a href="#" class="np-btn"><i class="fa fa-angle-right pagination-right"></i></a>
                                 </li>
                             </ul>
                         </div>
						 
                          <div id="accordion">
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
						 	<table class="table table-inbox table-hover">
                            <tbody>
							<tr class="unread">
                                 <td class="inbox-small-cells" width="5%">1</td>
                                 <td class="view-message  dont-show" width="20%">Demo1</td>
                                 <td class="view-message ">Lorem ipsum dolor imit set...</td>
                                 <td class="view-message text-right">4:30 PM</td>
                             </tr>
							 </tbody></table>
						  </a>
						  <div id="collapseOne" class="panel-collapse collapse" style="border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd; min-height:500px !important;max-height:500px !important; overflow-y:scroll;">
							<div class="panel-body"><!-- HEADER -->
							<table class="head-wrap" bgcolor="" style="margin-top: -2px;">
								<tbody><tr>
									<td></td>
									<td class="header container" align="" style="position:relative;">
										
										<!-- /content -->
										<div class="content" style="padding:0px;">
											<table bgcolor="#999999">
												<tbody><tr>
													<td width="100%"><img src="<?php echo base_url(); ?>images/new_images/news_img/header.gif" width="100%"></td>
													
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
									</td>
									<td></td>
								</tr>
							</tbody></table><!-- /HEADER -->
							
							<!-- MENU -->
							<table class="body-wrap" style="margin-top: 0px;">
								<tbody><tr>
									<td></td>
									<td class="container" bgcolor="#D3D1D1" style="max-width: 571px !important;">
										
										<!-- /content -->
										<div class="content">
											<table bgcolor="#D3D1D1">
												<tbody><tr>
													
														<td width="10%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/frontend/product/product_list_grid/220 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Fashion</a></span></td>
														<td style="padding-right:5px;">|</td>
														<td width="10%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/category/Cell-Phones-Accessories-grid-1815 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Phones</a></span></td>
														<td style="padding-right:5px;">|</td>
														<td width="10%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/category/Electronics-Computers-grid-275 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Computing</a></span></td>
														<td style="padding-right:5px;">|</td>
														<td width="10%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/category/Electronics-Computers-grid-275 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Electronics</a></span></td>
														<td style="padding-right:5px;">|</td>
														<td width="25%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/category/Large-Appliances-grid-935 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Home Appliances</a></span></td>
														<td style="padding-right:5px;">|</td>
														<td width="10%" style="vertical-align: top; padding-right:5px;    padding: 10px;">
														<span><a href="https://pointemart.com/category/Movies-Music-Games-grid-440 " style="text-decoration:none;color:#000000;font-family: Myriad Pro; font-weight: bold;" target="_blank">Games</a></span></td>
														
														
														
													
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
									</td>
									<td></td>
								</tr>
							</tbody></table><!-- /MENU -->
							
							<!-- BODY -->
							<table class="body-wrap" bgcolor="">
								<tbody><tr>
									
									<td class="container" align="" bgcolor="#FFFFFF">
										
										<!-- content -->
										<div class="content" style="padding:0px;">
											<table>
												<tbody><tr>
													<td><a href="https://pointemart.com/" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/main_banner.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
										<!-- content -->
										<div class="content" style="background-image:url('<?php echo base_url(); ?>images/new_images/news_img/bg.gif'); background-repeat:no-repeat;">
											<table bgcolor="" style="padding-top:45px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;     padding-top: 40px;"><a href="https://pointemart.com/category/Womens-Traditional-Wears-grid-55605" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/cloths.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 62px;"><a href="https://pointemart.com/category/Food-Beverages-grid-38390 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/foods.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 60px;"><a href="https://pointemart.com/category/Craft-Supplies-grid-11715 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/praying.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
										<div class="content" style="padding:0px;">
											<table>
												<tbody><tr>
													<td><img src="<?php echo base_url(); ?>images/new_images/news_img/savemore_bg.gif" width="100%"></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
										<!-- content -->
										<div class="content">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href=" https://pointemart.com/category/Cookware-grid-11605 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/cooking_pots.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Small-Appliances-grid-23925 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/ele_catl.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Kitchen-Tools-grid-17270" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/kitchen_uts.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<div class="content" style="padding: 0px;margin-top: -50px;">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/savemore_stars.gif" style=" margin-left: 84px;"></td><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/savemore_stars.gif" style=" margin-left: -84px;"></td>
												</tr>
											</tbody></table>
										</div>	
										<!-- content -->
										<div class="content">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Water-Dispensers-grid-48840 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/water_dis.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Small-Appliances-grid-23925 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/microwaves.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Large-Appliances-grid-935 " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/refig.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<!-- /content -->
										<div class="content" style="padding:0px;">
											<table>
												<tbody><tr>
													<td><img src="<?php echo base_url(); ?>images/new_images/news_img/awoof_price.gif" width="100%"></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<!-- content -->
										<div class="content">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Cell-Phones-grid-10285" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/affordable.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href=" https://pointemart.com/category/TV-Video-grid-6105" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/led_tv.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href=" https://pointemart.com/category/Accessories-grid-6985" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/power_banks.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<div class="content" style="padding: 0px;margin-top: -50px;">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/awoof_stars.gif" style=" margin-left: 84px;"></td><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/awoof_stars.gif" style=" margin-left: -84px;"></td>
												</tr>
											</tbody></table>
										</div>	
										<div class="content">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Laptops-Tablets-grid-4125" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/laptops.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href=" https://pointemart.com/category/PC-Headsets-grid-19910" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/headphons.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Generators-grid-39875" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/ganerators.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<!-- /content -->
										<div class="content" style="padding:0px;">
											<table>
												<tbody><tr>
													<td><img src="<?php echo base_url(); ?>images/new_images/news_img/go_cousal.gif" width="100%"></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<div class="content">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Dresses-grid-12650" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/classy_woman.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Unisex-grid-49720" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/tandytop.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Shirts-grid-23650" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/mens_shop.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										<div class="content" style=" padding: 0px;margin-top: -58px;">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/savemore_stars.gif" style=" margin-left: 84px;"></td><td width="50%" align="center"><img src="<?php echo base_url(); ?>images/new_images/news_img/savemore_stars.gif" style=" margin-left: -84px;"></td>
												</tr>
											</tbody></table>
										</div>		
										<div class="content" style="background-image:url('<?php echo base_url(); ?>images/new_images/news_img/bottom_bg.gif'); background-repeat:repeat-x;    padding-bottom: 30px;">
											<table bgcolor="" style="padding-top:0px;">
												<tbody><tr>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Women-shoes-grid-23760" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/ladis_heels.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Mens-Watches-grid-26620" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img//wrist_watch.gif" width="100%"></a></td>
													<td class="small" width="33%" style="vertical-align: top; padding-right:10px;    padding-top: 0px;"><a href="https://pointemart.com/category/Handbags-Accessories-grid-15675" target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/ladis_bags.gif" width="100%"></a></td>
												</tr>
											</tbody></table>
										</div><!-- /content -->
										
										<!-- content -->
										<div class="content" style="padding:0px;"><table bgcolor="#EAE0E0" style="background:#EAE0E0;">
											<tbody><tr>
												<td width="20%" style="vertical-align: top;"></td>
												<td width="60%">
													 <table style="padding:10px;"><tbody><tr>
													 <td align="center"  style="padding:10px;"><a href="https://www.facebook.com/SpacePointe " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/fb.gif"></a><p><a href="https://www.facebook.com/SpacePointe " style="text-decoration:none;color:#000000;" target="_blank">Facebook</a></p></td>
													 <td align="center"  style="padding:10px;"><a href="https://twitter.com/SpacePointe/ " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/twitter.gif"></a><p><a href="https://twitter.com/SpacePointe/" style="text-decoration:none;color:#000000;" target="_blank">Twitter</a></p></td>
													 <td align="center"  style="padding:10px;"><a href=" https://pointemart.com/ " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/website_link.gif"></a><p><a href="https://pointemart.com/ " style="text-decoration:none;color:#000000;" target="_blank">Website</a></p></td>
													 <td align="center"  style="padding:10px;"><a href="mailto:newsletter@spacepointe.com"><img src="<?php echo base_url(); ?>images/new_images/news_img/email.gif"></a><p><a href="mailto:newsletter@spacepointe.com " style="text-decoration:none;color:#000000;">Email</a></p></td>
													 <td align="center"  style="padding:10px;"><a href="https://instagram.com/spacepointe/ " target="_blank"><img src="<?php echo base_url(); ?>images/new_images/news_img/intsgram.gif"></a><p><a href="https://instagram.com/spacepointe/" style="text-decoration:none;color:#000000;" target="_blank">Instagram</a></p></td>
													 </tr></tbody></table>	
												</td>
												<td width="20%" style="vertical-align: top;"></td>
												</tr>
											
												
											
										</tbody></table></div><!-- /content -->
										<div class="content" style="padding:0px;"><table bgcolor="#EAE0E0" style="background:#EAE0E0;">
										<tbody><tr>
												<td width="100%" style="padding-left:10px;padding-right:10px; font-family: Times New Roman;font-style: italic;">Not only do you pay less for what you buy at PointeMart.com, but we personally package your order and ship to you. In other words, what you see online and buy, is indeed what you get!</td>
											</tr>	
										
										</tbody></table>
										</div>
										<!-- content -->
										<div class="content" style="padding:0px;"><table bgcolor="#EAE0E0" style="padding-top:20px;background:#EAE0E0;">
										<tbody><tr>
											<td width="15%" style="padding: 10px;"></td>
											<td width="18%" align="center" style="padding: 10px;"><a href="https://pointemart.com/contact-us " style="text-decoration:none;color:#000000;font-family: Times New Roman;font-style: italic;" target="_blank">Contact Us</a></td><td width="1%">|</td>
											<td width="20%" align="center" style="padding: 10px;"><a href="https://pointemart.com/privacy-policy " style="text-decoration:none;color:#000000;font-family: Times New Roman;font-style: italic;" target="_blank">Privacy Policy </a></td><td width="1%">|</td>
											<td width="30%" align="center" style="padding: 10px;"><a href="https://pointemart.com/terms-of-use " style="text-decoration:none;color:#000000;font-family: Times New Roman;font-style: italic;" target="_blank">Terms &amp; Conditions</a></td>
											<td width="20%"></td>
										</tr>	
										</tbody></table>
										</div>
										<!-- content -->
										<!-- content -->
										<div class="content" style="padding:0px;"><table bgcolor="#EAE0E0" style="background:#EAE0E0;">
										<tbody><tr>
											<td width="100%" align="center"><p style="font-family: Times New Roman;font-style: italic;">Copyright &copy; *2015* *PointeMart* All rights reserved.</p> </td>
										</tr>	
										</tbody></table>
										</div>
										<!-- content -->
										
										<!-- content -->
										<div class="content" style="padding:0px;"><table bgcolor="#EAE0E0" style="padding-bottom:20px; background:#EAE0E0; ">
										<tbody><tr>
											<td width="100%" align="center"><b style="font-family: Times New Roman;font-style: italic;">Our mailing address is:</b></td>
										</tr>	
										<tr>	
											<td width="100%" align="center" style="font-family: Times New Roman;font-style: italic;">242A Alhaji Ganiyu Alimi Crescent, Gbagada Phase II.Lagos</td>
										</tr>
										<tr>
											<td width="100%" align="center" style="font-family: Times New Roman;font-style: italic;">Phone No.: +234-1-216-3344</td>
										</tr>
										<tr>
											<td width="100%" align="center" style="font-family: Times New Roman;font-style: italic;    padding-bottom: 20px;">Email: <a href="mailto:care@pointemart.com" style="text-decoration:none;color:#000000;">care@pointemart.com</a>
											</td>
										</tr>	
										</tbody></table>
										</div>
										
										<!-- content -->
									</td>
									<td></td>
								</tr>
							</tbody></table><!-- /BODY -->
							</div>
						  </div>
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
							 	<table class="table table-inbox table-hover">
                             <tr class="">
                                 <td class="inbox-small-cells" width="5%">2</td>
                                 <td class="view-message  dont-show" width="20%">Demo2</td>
                                 <td class="view-message ">Lorem ipsum dolor imit set...</td>
                                 <td class="view-message text-right">Oct 20</td>
                              </tr>
                             </table>
							 </a>
						  <div  id="collapseTwo" class="panel-collapse collapse" style="border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
									<div class="panel-body">
											<p>HTML stands for HyperText Markup Language. HTML is the main markup language for describing the structure of Web pages. <a href="http://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
										</div>
									</div>
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapsethree">
						 	<table class="table table-inbox table-hover">
                            <tbody>
							<tr class="unread">
                                 <td class="inbox-small-cells" width="5%">3</td>
                                 <td class="view-message  dont-show" width="20%">Demo3</td>
                                 <td class="view-message ">Lorem ipsum dolor imit set...</td>
                                 <td class="view-message text-right">Oct 02</td>
                             </tr>
							 </tbody></table>
						  </a>
						  <div id="collapsethree" class="panel-collapse collapse" style="border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
									<div class="panel-body">
										<p>HTML stands for HyperText Markup Language. HTML is the main markup language for describing the structure of Web pages. <a href="http://www.tutorialrepublic.com/html-tutorial/" target="_blank">Learn more.</a></p>
									</div>
							</div>
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapsefour">
							 	<table class="table table-inbox table-hover">
                             <tr class="">
                                 <td class="inbox-small-cells" width="5%">4</td>
                                 <td class="view-message  dont-show" width="20%">Demo4</td>
                                 <td class="view-message ">Lorem ipsum dolor imit set...</td>
                                 <td class="view-message text-right">Sep 5</td>
                              </tr>
                             </table>
							 </a>
						  <div  id="collapsefour" class="panel-collapse collapse" style="border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;">
									<div class="panel-body">
											
										</div>
									</div>			
						  </div>
							 
                      </div>
                  </aside>
              </div>
              <!--mail inbox end-->
          </section>
      </section>
<style>
label{ background-image:none;}
/* ------------------------------------- 
		GLOBAL 
------------------------------------- */
.collapse {
	margin:0;
	padding:0;
}


/* ------------------------------------- 
		ELEMENTS 
------------------------------------- */



p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
/* 	padding:15px; */
	background-color: #ebebeb;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

/* ------------------------------------- 
		HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
		BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
		FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}


/* ------------------------------------- 
		TYPOGRAPHY 
------------------------------------- */
/*h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-weight:200; font-size: 44px;}
h2 { font-weight:200; font-size: 37px;}
h3 { font-weight:500; font-size: 27px;}
h4 { font-weight:500; font-size: 23px;}
h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}
*/
.collapse { margin:0!important;}

p, ul { 
/*	margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;
*/}
p.lead { font-size:17px; }
p.last { margin-bottom:0px;}

ul li {
/*	margin-left:5px;
	list-style-position: inside;
*/}

/* ------------------------------------- 
		SIDEBAR 
------------------------------------- */
ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}



/* --------------------------------------------------- 
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:600px!important;
	margin:0 auto!important; /* makes it centered */
	clear:both!important;
}

/* This should also be a block element, so that it will fill 100% of the .container */

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


/* Odds and ends */
.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
		PHONE
		For clients that support media queries.
		Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
	
	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}
	
	table.social div[class="column"] {
		
	}

}

</style>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#myModalpop").modal('show');
});

<?php
if(($this->session->flashdata('successNews'))||($newsId))
{
?>
jQuery(document).ready(function($){
	$("#myModalpop").modal('hide');
	$("#reffer_frnd").modal('show');	
});
<?php
}
if($this->session->flashdata('successNewsRefer'))
{
?>
jQuery(document).ready(function($){
	$("#myModalpop").modal('hide');
	$("#reffer_frnd").modal('show');	
});
<?php
}

?>		
</script>

<div id="myModalpop" class="modal fade first-popup">
	<div class="modal-dialog" style="width: 700px;">
    	<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="  position: absolute; right: 6px; color: #000; opacity:inherit;">&times;</button>
			<img src="<?php echo base_url(); ?>images/new_images/POP-UP-2.jpg" width="100%" class="img-responsive"> 
			<div class="col-sm-8 form-group"  style="position:absolute; top: 37%;">
				<?php 
				echo form_open(); 
				?>
				<input type="text" name="news_email" placeholder="Type your Email here" class="input-text" style="width: 94%; height: 40px;margin-left: 8%; margin-top: 4%; background-color: #fff;font-size: 14px;line-height: 14px;" value="<?php echo set_value('news_email'); ?>"> 
				<div style="width: 94%;margin-left: 34px;"><?php echo form_error('news_email'); ?></div>
				<center>
				
					<button type="submit" name="new_sub_btn" value="male" style="width: 150px;height: 30px; margin-top:10px; background:#FF0EBC; color:#fff;font-size: 16px;margin-left: 25px;">MALE</button>
					<button type="submit" name="new_sub_btn" value="female" style="width: 150px;height: 30px; margin-top:10px;background:#FF0EBC; color:#fff;font-size: 16px;margin-left: 5px">FEMALE</button>
				</center>
			</form>				
			</div>
		</div>
    </div>
</div>
<?php /*
<div id="reffer_frnd" class="modal fade first-popup">
	<div class="modal-dialog" style="width: 700px;">
		<div class="modal-content">
   			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="  position: absolute; right: 6px; color: #000; opacity:inherit;">&times;</button>
			<img src="<?php echo base_url(); ?>images/new_images/reffer_frnd.jpg" width="100%"> 
			<div class="col-sm-7 form-group"  style="position:absolute;top: 36%; left: 26%;">
				<?php 
				if($this->session->flashdata('successNewsRefer'))
				{
				?>
					<h2 class="success_pop">
					  <?php echo $this->session->flashdata('successNewsRefer');?>
					</h2>
				<?php
				}
				else
				{
					echo form_open(base_url().'news-letter-subscribe-refer-friends-'.id_encrypt($newsId)); 
					if(form_error('refer_email1'))
					{
						echo form_error('refer_email1');
					}
					elseif(form_error('refer_email2'))
					{
						echo form_error('refer_email2');
					}
					elseif(form_error('refer_email3'))
					{
						echo form_error('refer_email3');
					}
					elseif(form_error('refer_email4'))
					{
						echo form_error('refer_email4');
					}
					elseif(form_error('refer_email5'))
					{
						echo form_error('refer_email5');
					}
				?>
					<input type="text" name="refer_email1" placeholder="Enter Email Address 1" class="input-text reffer_text" style="width: 100%; height: 40px;" value="<?php echo set_value('refer_email1'); ?>"><br>
					<input type="text" name="refer_email2" placeholder="Enter Email Address 2" class="input-text reffer_text" style="width: 100%; height: 40px;" value="<?php echo set_value('refer_email2'); ?>"><br>
					<input type="text" name="refer_email3" placeholder="Enter Email Address 3" class="input-text reffer_text" style="width: 100%; height: 40px;" value="<?php echo set_value('refer_email3'); ?>"><br>
					<input type="text" name="refer_email4" placeholder="Enter Email Address 4" class="input-text reffer_text" style="width: 100%; height: 40px;" value="<?php echo set_value('refer_email4'); ?>"><br>
					<input type="text" name="refer_email5" placeholder="Enter Email Address 5" class="input-text reffer_text" style="width: 100%; height: 40px;" value="<?php echo set_value('refer_email5'); ?>">
					
					<center>
						<button type="submit" name="referFriendBtn" value="Submit" style="background-image:url('<?php echo base_url(); ?>images/new_images/sub_btn.jpg'); background-repeat:no-repeat;width: 180px;height: 50px; margin-top:0px;"></button>
					</center>
					</form>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php */?>

<!-- BEGIN: content -->
        <div id="yt_content" class="yt-content wrap bodyContainerWrapper">
            <!-- PAGE V2 -->

            <!-- END -->
            <div class="yt-breadcrumbs">
                <div class="container">
                    <div class="row">
                    </div>
                </div>
            </div>
            <div class="home-top-wrap">
                <div class="container">
                    <div class="row">
                        <div class="home-top-left col-lg-3 col-md-3 col-sm-0">
                        <div class="css_effect sm_megamenu_wrapper_vertical_menu sambar " id="sm_megamenu_menu559cda9bd26a4" data-sam="17752576091436342939">
                        <div class="sambar-inner"> 
                            <a class="btn-sambar" data-sapi="collapse" href="#sm_megamenu_menu559cda9bd26a4"> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                                <span class="icon-bar"></span> 
                            </a>
                            <ul class="sm-megamenu-hover sm_megamenu_menu sm_megamenu_menu_black" data-jsapi="on">
                                <?php
                                if(!empty($categoryList))
                                {
                                    foreach($categoryList as $key=>$level)
                                    {	
                                ?>
                                <li class="computer-hight-light -parent other-toggle   
                    sm_megamenu_lv1 sm_megamenu_drop parent">
                                    <a class="sm_megamenu_head sm_megamenu_drop " href="<?php echo frontend_grid_category_url($key,$level['levelName']); ?>" id="sm_megamenu_73">
                                        <span class="sm_megamenu_icon sm_megamenu_nodesc">
                                            <span class="sm_megamenu_title">
                                                <?php echo $level['levelName']; ?>
                                            </span> 
                                        </span>
                                    </a>
                                    <div class="sm-megamenu-child sm_megamenu_dropdown_5columns  ">
                                        <div class="sm_megamenu_col_5 sm_megamenu_firstcolumn  sm_megamenu_id73   computer-hight-light ">
                                            <div class="sm_megamenu_col_4 sm_megamenu_firstcolumn  sm_megamenu_id108   sub-menu2">
                                                <div class="sm_megamenu_head_item "> </div>
                                                <div class="sm_megamenu_content">
                                                    <div class="drop-menu-v0">
                                                        <?php
                                                        if(!empty($level['nextLevel']))
                                                        {
                                                            foreach($level['nextLevel'] as $key2=>$secondLevel)
                                                            {
                                                        ?>
                                                        <div class="sub-memnu menuv1">
                                                            <a href="<?php echo frontend_grid_category_url($key2,$secondLevel['levelName']); ?>">
                                                                <div class="menu-title sm_megamenu_title">
                                                                    <span><?php echo $secondLevel['levelName']; ?></span> 
                                                                </div>
                                                            </a>
                                                            <div class="menu-content">
                                                                <ul>
                                                                    <?php
                                                                    if(!empty($secondLevel['nextLevel']))
                                                                    {
                                                                        foreach($secondLevel['nextLevel'] as $key3=>$thirdLevel)
                                                                        {
                                                                    ?>
                                                                    <li>
                                                                        <a href="<?php echo frontend_grid_category_url($key3,$thirdLevel['levelName']); ?>">
                                                                            <?php echo $thirdLevel['levelName']; ?>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>	
                                                                </ul>
                                                            </div>
                                                        </div> 
                                                        <?php
                                                            }
                                                        }
                                                        ?>                                  
                                                    </div>
                                                </div>
                                            </div>                    	
                                            
                                        </div>
                                    </div>
                                </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
</div>
                        
                        </div>
                        
                        <div class="home-top-center col-lg-6 col-md-9 col-sm-8">
                            <div class="yt-slideshow">
                                <div style="overflow:hidden;">
                                    <div class="margin-sl-image">
                                        <div id="sm_imageslider_17943753441435666590" class="sm_imageslider_wrap">

                                            <div class="sm_imageslider">
                                                <div class="item">
                                                    <a href="<?php echo frontend_grid_category_url(904,'Unisex');?>" title="TOMS">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/TOMS.jpg" alt="TOMS" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo product_url(14230,'U-Power Smart Scooter Hooverboard');?>" title="hooverboard"> 
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/hooverboard.jpg" alt="hooverboard" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo base_url(); ?>pointeforce" title="pointeforce">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/POINTEFORCECENTRE.jpg" alt="pointeforce" />
                                                    </a>
                                                </div>
												<div class="item">
                                                    <a href="<?php echo base_url(); ?>marketing/product/product_list_grid" title="paydayagainoct">  
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/paydayagainoct.jpg" alt="paydayagainoct" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo frontend_grid_category_url(9,'Office & School Supplies');?>" title="office supplies">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/office_supplies.jpg" alt="office supplies" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo base_url(); ?>product/Gbemisoke-heels-Green-details-718960" title="gbemisokeshoes">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/gbemisokeshoes.jpg" alt="African Fabrics" />
                                                    </a>
                                                </div>
												<div class="item">
                                                    <a href="<?php echo base_url(); ?>product/pre-order-grid" title="PREORDER">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/PREORDER2.jpg" alt="African Fabrics" />
                                                    </a>
                                                </div>
                                            </div>


                                        </div> 
                                    </div>
                                </div>
                            </div>


                            <script type="text/javascript">
                                //<![CDATA[
                                jQuery(document).ready(function($) {
                                    $('.sm_imageslider').owlCarousel({
                                        navigation: true,

                                        slideSpeed: 800,
                                        stopOnHover: true,
                                        paginationSpeed: 800,
                                        autoPlay: true,
                                        navigationText: ["", ""],
                                        pagination: false,

                                        singleItem: true,
                                        transitionStyle: "backSlide"

                                    });
                                });
                                //]]>
                            </script>

                        </div>
                        <div class="home-top-right col-lg-3 hidden-md col-sm-4">

                            <script type="text/javascript">
                                //<![CDATA[
                                data = new Date(2013, 10, 26, 12, 00, 00);
                                var listdeal = [];

                                function CountDown(date, id) {
                                        dateNow = new Date();
                                        amount = date.getTime() - dateNow.getTime();
                                        delete dateNow;
                                        if (amount < 0) {
                                            document.getElementById(id).innerHTML = "Now!";
                                        } else {
                                            days = 0;
                                            hours = 0;
                                            mins = 0;
                                            secs = 0;
                                            out = "";
                                            amount = Math.floor(amount / 1000);
                                            days = Math.floor(amount / 86400);
                                            amount = amount % 86400;
                                            hours = Math.floor(amount / 3600);
                                            amount = amount % 3600;
                                            mins = Math.floor(amount / 60);
                                            amount = amount % 60;
                                            secs = Math.floor(amount);
                                            if (hours != 0) {
                                                out += "<div class='time-item time-hour'>" + "<div class='num-time'>" + hours + "</div>" + "</div> ";
                                            }
                                            out += ": " + "<div class='time-item time-min'>" + "<div class='num-time'>" + mins + "</div>" + "</div> ";
                                            out += ": " + "<div class='time-item time-sec'>" + "<div class='num-time'>" + secs + "</div>" + "</div> ";
                                            out = out.substr(0, out.length - 2);
                                            document.getElementById(id).innerHTML = out;
                                            setTimeout(function() {
                                                CountDown(date, id)
                                            }, 1000);
                                        }
                                    }
                                    //]]>
                            </script>

                            <div class="deal-wrapper">


                                <div id="sm_deal_14356665901971751020" class="sm-deal-wrap">


                                    <div class="w-deal-res deal-home-df">
                                        <!--<div class="customNavigation custom-nav-default">
                                            <a title="Previous" class="button-default1 prev-deal icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                            <a title="Next" class="button-default1 next-deal icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                        </div>-->
                                        <div class="overflow-owl-slider">
                                            <div class="rw-margin">
                                                <div class="slider-deal">

                                                    <div class="item item-deal item respl-item">
                                                        <div class="item-inner" style="padding:0;">
                                                            <div class="w-image-box" style="margin-top:0;">
                                                               <div class="item-image">
                                                                        <a href="<?php echo base_url();?>marketing/product/product_list_grid" title="Deal of the day">
                                                                            <img src="<?php echo base_url(); ?>images/new_images/home/dealsinsmallerdiomension.png" title="Deal of the day" alt="Deal of the day" style="padding-bottom:5px;" />
                                                                        </a>
                                                                    </div>
																	<div class="item-image">
                                                                        <a href="<?php echo base_url();?>frontend/seller/seller_product/115885" title="SPOTLIGHT">
                                                                            <img src="<?php echo base_url(); ?>images/new_images/home/SPOTLIGHT.png" title="SPOTLIGHT" alt="SPOTLIGHT">
                                                                        </a>
                                                                    </div>

                                                                
                                                            </div>
                                                           
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                jQuery(document).ready(function($) {
                                    var owl_deal = $(".slider-deal");
                                    owl_deal.owlCarousel({
                                        itemsCustom: [
                                            [0, 1],
                                            [480, 1],
                                            [768, 1],
                                            [992, 1],
                                            [1200, 1]
                                        ],
                                        navigation: false, // Show next and prev buttons
                                        slideSpeed: 300,
                                        stopOnHover: true,
                                        paginationSpeed: 400,
                                        autoPlay: false,
                                        pagination: true,
                                    });

                                    $(".next-deal").click(function() {
                                        owl_deal.trigger('owl.next');
                                    })
                                    $(".prev-deal").click(function() {
                                        owl_deal.trigger('owl.prev');
                                    })
                                });
                            </script>

                            <script type="text/javascript">
                                //<![CDATA[
                                window.onload = function() {
                                    if (listdeal.length > 0) {
                                        for (i = 0; i < listdeal.length; i++) {
                                            var arr = listdeal[i].split("&&||&&");
                                            var data = new Date(arr[1]);
                                            CountDown(data, arr[0]);
                                        }
                                    }
                                };
                                //]]>
                            </script>
                        </div>
                        
                        <div class="home-top-left col-lg-3 col-md-3"></div>
                    	<div class="home-top-center2 col-lg-9 col-md-9">
                            <div class="bannerhome1 bannerhome">
                                <div class="img-effect img-banner1">
                                    <a href="<?php echo frontend_grid_category_url(314,'Kitchen Tools');?>" class="img-class banner1">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/three_banner/utensils.jpg" alt="Utensils" />
                                    </a>
                                </div>
                                
                                <div class="img-effect img-banner2">
                                    <a href="<?php echo frontend_grid_category_url(122,'Women');?>" class="img-class banner3">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/three_banner/wardrobe.jpg" alt="LOAFERSFOPREN" />
                                    </a>
                                </div>
								<div class="img-effect img-banner3">
                                    <a href="<?php echo base_url(); ?>product/pre-order-grid" class="img-class banner2">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/three_banner/PREORDER2b.jpg" alt="PREORDER2" />
                                    </a>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="row">
                    	
                    </div>
                    
                </div>
            </div>

            <div class="yt-content-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-2-wrapper1">

                            <div id="yt_left" class="col-lg-3 col-md-3">
                                <div class="yt-left-wrap">
                                    <div class=" basic2 block-left-products1 block-left-products-left">
                                        <div class="block-title">
                                            <strong>
					<span>recommended PRODUCTS</span>
				</strong>
                                            <div class="sn-img icon-bacsic2"></div>

                                            <div class="customNavigation nav-left-product">
                                                <a style="display:none;" title="Previous" class="btn-bs prev-bs icon-angle-left"></a>
                                                <a style="display:none;" title="Next" class="btn-bs next-bs icon-angle-right"></a>
                                            </div>
                                        </div>
                                        <div class="blocks block-left-products">


                                            <div id="sm_basic_products_1435666591427843508" class="block-content">
                                                <div class="slider-left-product basic-product">
                                                    <!-- Begin bs-items     -->
                                                    <!-- Begin bs-item-cf -->
                                                    <div class="item-left-products item">
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section1">
                                                                <span class="item-count">
											1										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Playstation 3									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(5800,'Sony PlayStation 3 - 500 GB');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Playstation-3.jpg" title="Sony PlayStation 3 - 500 GB" alt="Sony PlayStation 3 - 500 GB">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
                                                        <!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section2">
                                                                <span class="item-count">
											2										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Apple iPad Mini									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(12728,'Apple iPad Mini with Retina Display 32GB,WiFi + Cellular');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Apple-iPad-Mini.jpg" title="Apple iPad Mini with Retina Display 32GB,WiFi + Cellular" alt="Apple iPad Mini with Retina Display 32GB,WiFi + Cellular">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
                                                        <!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section3">
                                                                <span class="item-count">
											3										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Beko 1.5 HP									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(7031,'Beko 1.5 HP Split Air Conditioner - BXCY 121');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Beko-1.5-HP.jpg" title="Beko 1.5 HP Split Air Conditioner - BXCY 121" alt="Beko 1.5 HP Split Air Conditioner - BXCY 121">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
                                                        <!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section4">
                                                                <span class="item-count">
											4										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Blackberry Passport								</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(12429,'Blackberry Passport - Silver');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Blackberry-Passport.jpg" title="Blackberry Passport - Silver" alt="Blackberry Passport - Silver">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
                                                        <!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section5">
                                                                <span class="item-count">
											5										</span>
                                                                <a href="grouped-product.html" title="Grouped Product" style="text-transform:capitalize;">
											LG LED TV With IPS Panel								</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(6154,'LG LED TV WITH IPS PANEL - 32LB550A-TA');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/LG-LED-TV-WITH-IPS-PANEL.jpg" title="LG LED TV WITH IPS PANEL - 32LB550A-TA" alt="LG LED TV WITH IPS PANEL - 32LB550A-TA">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section6">
                                                                <span class="item-count">
											6										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											M&L Ladies Crop Top & Trouser Set									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(10693,'M&L Ladies Crop Top & Trouser Set');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/M&L-Ladies-Crop-Top-&-Trouser-Set.jpg" title="M&L Ladies Crop Top & Trouser Set" alt="M&L Ladies Crop Top & Trouser Set">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section7">
                                                                <span class="item-count">
											7										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											22'' 3 Tier Dish Rack									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(2516,"22'' 3 Tier Dish Rack");?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/22''-3-Tier-Dish-Rack.jpg" title="22'' 3 Tier Dish Rack" alt="22'' 3 Tier Dish Rack">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section8">
                                                                <span class="item-count">
											8										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											BVL AQVA POUR HOMME										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(12412,'BVL AQVA POUR HOMME');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/BVL-AQVA-POUR-HOMME.jpg" title="BVL AQVA POUR HOMME" alt="BVL AQVA POUR HOMME">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section9">
                                                                <span class="item-count">
											9										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											NFC Bluetooth Speaker								</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(9379,'HV-SK466BT Mini Portable NFC Bluetooth Speaker');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/HV-SK466BT-Mini-Portable-NFC-Bluetooth-Speaker.jpg" title="HV-SK466BT Mini Portable NFC Bluetooth Speaker" alt="HV-SK466BT Mini Portable NFC Bluetooth Speaker">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section10">
                                                                <span class="item-count">
											10										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Polo Black Perfume										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(12497,'Polo Black Perfume');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Polo-Black-Perfume.jpg" title="Polo Black Perfume" alt="Polo Black Perfume">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section11">
                                                                <span class="item-count">
											11										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Tomy Takkies Toe							</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                     <a href="<?php echo product_url(9181,'Tomy Takkies Toe-Cap Lace Up Adult Plimsolls - Black & White');?>" title="Polo Black Perfume">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/TomyTakkiesToe-apLaceUpAdultPlimsollsBlackWhite.jpg" title="Tomy Takkies Toe-Cap Lace Up Adult Plimsolls - Black & White" alt="Tomy Takkies Toe-Cap Lace Up Adult Plimsolls - Black & White">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section12">
                                                                <span class="item-count">
											12										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											 Infinix Hot-2-X510						</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                  <a href="<?php echo product_url(10452,'Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Infinix-Hot-2-X510-(2GB-RAM,-16GB-ROM)---Black.jpg" title="Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black" alt="Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section13">
                                                                <span class="item-count">
											13										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											Polystar Mobile AC-1HP PV-09MBG										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                      <a href="<?php echo product_url(10256,'Polystar Mobile AC 1HP PV-09MBG');?>" title="Polystar Mobile AC 1HP PV-09MBG">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/Polystar-Mobile-AC-1HP-PV-09MBG.jpg" title="Polystar Mobile AC 1HP PV-09MBG" alt="Polystar Mobile AC 1HP PV-09MBGs">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
														<!-- Begin bs-item-cf -->
                                                        <div class="bs-item cf">
                                                            <div class="bs-title left-bs " id="section14">
                                                                <span class="item-count">
											14										</span>
                                                                <a href="grouped-product.html" title="Grouped Product">
											TSW By Ruggedman T-shirt							</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(12993,'TSW By Ruggedman T-shirt With Mary Design - Multicoloured');?>" title="TSW By Ruggedman T-shirt With Mary Design - Multicoloured">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recmned/TSW-By-Ruggedman-T-shirt-With-Mary-Design---Multicoloured.jpg" title="TSW By Ruggedman T-shirt With Mary Design - Multicoloured" alt="TSW By Ruggedman T-shirt With Mary Design - Multicoloured">
                                                                    </a>
                                                                </div>

                                                               
                                                                <!-- End bs-content -->
                                                            </div>
                                                            <!-- End bs-item-inner -->
                                                        </div>
                                                        <!-- End bs-item-cf -->
                                                    </div>

                                                    <!-- End bs-items -->
                                                </div>
                                            </div>
                                            <!-- End Sm-basic-products -->


                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function($) {
                                            $('.bs-title').accordion_snyderplace({
                                                defaultOpen: 'section1',
                                                speed: 'fast',
                                                animateOpen: function(elem, opts) { //replace the standard slideUp with custom function
                                                    elem.next().slideFadeToggle(opts.speed);
                                                },
                                                animateClose: function(elem, opts) { //replace the standard slideDown with custom function
                                                    elem.next().slideFadeToggle(opts.speed);
                                                }
                                            });
                                            //custom animation for open/close
                                            $.fn.slideFadeToggle = function(speed, easing, callback) {
                                                return this.animate({
                                                    opacity: 'toggle',
                                                    height: 'toggle'
                                                }, speed, easing, callback);
                                            };
                                        });
                                    </script>
                                    
                                </div>
                            </div>

                            <div id="yt_main" class="yt-main-right yt-main col-main col-lg-9 col-md-9">
                                <div class="yt_main_inner">
                                    <noscript>
                                        <div class="global-site-notice noscript">
                                            <div class="notice-inner">
                                                <p>
                                                    <strong>JavaScript seems to be disabled in your browser.</strong>
                                                    <br /> You must have JavaScript enabled in your browser to utilize the functionality of this website. </p>
                                            </div>
                                        </div>
                                    </noscript>
                                    <div class="global-site-notice demo-notice">
                                        <div class="notice-inner">
                                            <p>This is a demo store. Any orders placed through this store will not be honored or fulfilled.</p>
                                        </div>
                                    </div>

                                    <div class="std">
                                        <div class="no-display">&nbsp;</div>
                                    </div>
                                    <div id="sm_listing_tabs_259097321435666591" class="super-category-block first-load sn-category-block">

                                        <div class="block-title-defaults ">
                                            <div class="tab-category-title block-title">
                                                <strong><span>Electronics</span></strong>
                                                <div class="sn-img icon-bacsic item1"></div>

                                                <?php /*?><div class="customNavigation custom-nav-default">
                                                    <a title="Previous" class="button-default prev-cat prev-super-cat-72 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                    <a title="Next" class="button-default next-cat next-super-cat-72 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                                </div><?php */?>
                                            </div>
                                        </div>
                                        <div class="super-cat-wrapper">
                                            <div class="overflow-owl-slider">
                                                <div class="border-cat">
                                                    <div class="rw-margin">
                                                        <div class="ltabs-items-container slider-cat-72">
                                                            <!--Begin Items-->
                                                            <div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(187,'Cell Phones');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/electronics/Smartphones.jpg" alt="Smartphones" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(187,'Cell Phones');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(187,'Cell Phones');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(316,'LED & LCD TVs');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/electronics/Smart-TVs.jpg" alt="LED & LCD TVs" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(316,'LED & LCD TVs');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(316,'LED & LCD TVs');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(292,'Home Theater Systems');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/electronics/Digital-Home-Theatre-System.jpg" alt="Home Theater Systems" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(292,'Home Theater Systems');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(292,'Home Theater Systems');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(57,'Games');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/electronics/Video-Gaming-Consoles.jpg" alt="TV & Video" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(57,'Games');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(57,'Games');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        jQuery(document).ready(function($) {
                                                            var owl_cat_72 = $(".slider-cat-72");
                                                            owl_cat_72.owlCarousel({
                                                                itemsCustom: [
                                                                    [0, 1],
                                                                    [480, 2],
                                                                    [768, 3],
                                                                    [992, 3],
                                                                    [1200, 4]
                                                                ],
                                                                navigation: false, // Show next and prev buttons
                                                                slideSpeed: 300,
                                                                stopOnHover: true,
                                                                paginationSpeed: 400,
                                                                autoPlay: false,
                                                                pagination: false,
                                                            });

                                                            $(".next-super-cat-72").click(function() {
                                                                owl_cat_72.trigger('owl.next');
                                                            })
                                                            $(".prev-super-cat-72").click(function() {
                                                                owl_cat_72.trigger('owl.prev');
                                                            })
                                                        });
                                                    </script>
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="content-home-img3">
                                        <div class=" img-effect img-content-home3">
                                            <a href="<?php echo base_url();?>marketing/exclusives/product_list_grid/54340" class="img-class ">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/coupanbanner/TSW.jpg" alt="img" />
                                            </a>
                                        </div>
                                    </div>
                                    <div id="sm_listing_tabs_15562372151435666592" class="super-category-block first-load sn-category-block">

                                        <div class="block-title-defaults ">
                                            <div class="tab-category-title block-title">
                                                <strong><span>WOMEN'S FASHION</span></strong>
                                                <div class="sn-img icon-bacsic item2"></div>

                                                <?php /*?><div class="customNavigation custom-nav-default">
                                                    <a title="Previous" class="button-default prev-cat prev-super-cat-14 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                    <a title="Next" class="button-default next-cat next-super-cat-14 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                                </div><?php */?>
                                            </div>
                                           
                                        </div>


                                        <div class="super-cat-wrapper">


                                            <div class="overflow-owl-slider">
                                                <div class="border-cat">
                                                    <div class="rw-margin">
                                                        <div class="ltabs-items-container slider-cat-14">
                                                            <!--Begin Items-->
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(230,'Dresses');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/womanfashion/Attractive-Womens-Dresses.jpg" alt="Dresses" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div><div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(230,'Dresses');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(230,'Dresses');?>"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(304,'Jeans');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/womanfashion/Ripped-Skinny-Jean.jpg" alt="Jeans" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(304,'Jeans');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(304,'Jeans');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(432,'Women shoes');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/womanfashion/Gbemisoke.jpg" alt="Women shoes" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(432,'Women shoes');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(432,'Women shoes');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(285,'Handbags & Accessories');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/womanfashion/Hand-Bags.jpg" alt="Handbags & Accessories" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(285,'Handbags & Accessories');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(285,'Handbags & Accessories');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        jQuery(document).ready(function($) {
                                                            var owl_cat_14 = $(".slider-cat-14");
                                                            owl_cat_14.owlCarousel({
                                                                itemsCustom: [
                                                                    [0, 1],
                                                                    [480, 2],
                                                                    [768, 3],
                                                                    [992, 3],
                                                                    [1200, 4]
                                                                ],
                                                                navigation: false, // Show next and prev buttons
                                                                slideSpeed: 300,
                                                                stopOnHover: true,
                                                                paginationSpeed: 400,
                                                                autoPlay: false,
                                                                pagination: false,
                                                            });

                                                            $(".next-super-cat-14").click(function() {
                                                                owl_cat_14.trigger('owl.next');
                                                            })
                                                            $(".prev-super-cat-14").click(function() {
                                                                owl_cat_14.trigger('owl.prev');
                                                            })
                                                        });
                                                    </script>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                </div>
                            </div>

                            <div style="clear:both;"></div>

                            <div class="container">
                                <!-- BANNER CONTENT -->

                                <div class="row content-home-img">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class=" img-effect img-content-home1">
                                            <a href="<?php echo product_url(13072,'Gbemisoke heels - Green');?>" class="img-class">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/springsales/Gbemisoke.jpg" alt="Gbemisoke heels - Green" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="img-effect img-content-home2">
                                            <a href="<?php echo frontend_grid_category_url(904,'Unisex');?>" class="img-class ">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/springsales/Tomy-Takkies.jpg" alt="Unisex" />
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- SUPERCATEGORIES -->


                                <div id="sm_listing_tabs_19158727221435666592" class="super-category-block first-load sn-category-block">

                                    <div class="block-title-defaults ">
                                        <div class="tab-category-title block-title">
                                            <strong><span>MEN'S FASHION</span></strong>
                                            <div class="sn-img icon-bacsic item3"></div>

                                            <?php /*?><div class="customNavigation custom-nav-default">
                                                <a title="Previous" class="button-default prev-cat prev-super-cat-92 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                <a title="Next" class="button-default next-cat next-super-cat-92 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                            </div><?php */?>
                                        </div>
                                        
                                    </div>
                                    <div class="super-cat-wrapper">
                                        <div class="overflow-owl-slider">
                                            <div class="border-cat">
                                                <div class="rw-margin">
                                                    <div class="ltabs-items-container slider-cat-92">
                                                        <!--Begin Items-->
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(466,"Men's Ties & Pocket Squares");?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/manfashion/Ties-&-Tees.jpg" alt="Men's Ties & Pocket Squares" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(466,"Men's Ties & Pocket Squares");?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(466,"Men's Ties & Pocket Squares");?>"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(484,"Men's Watches");?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/manfashion/Wristwatches-for-Men.jpg" alt="Men's Watches" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(484,"Men's Watches");?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(484,"Men's Watches");?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(430,'Shirts');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/manfashion/Designer-Mens-Shirt.jpg" alt="Shirts" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(430,'Shirts');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(430,'Shirts');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(431,'Shoes');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/manfashion/Mens-Shoes.jpg" alt="Shoes" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(431,'Shoes');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(431,'Shoes');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(904,'Unisex');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/manfashion/Tomy-Takkies.jpg" alt="Unisex" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(904,'Unisex');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(904,'Unisex');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    jQuery(document).ready(function($) {
                                                        var owl_cat_92 = $(".slider-cat-92");
                                                        owl_cat_92.owlCarousel({
                                                            itemsCustom: [
                                                                [0, 1],
                                                                [480, 2],
                                                                [768, 3],
                                                                [992, 3],
                                                                [1200, 5]
                                                            ],
                                                            navigation: false, // Show next and prev buttons
                                                            slideSpeed: 300,
                                                            stopOnHover: true,
                                                            paginationSpeed: 400,
                                                            autoPlay: false,
                                                            pagination: false,
                                                        });

                                                        $(".next-super-cat-92").click(function() {
                                                            owl_cat_92.trigger('owl.next');
                                                        })
                                                        $(".prev-super-cat-92").click(function() {
                                                            owl_cat_92.trigger('owl.prev');
                                                        })
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>

								<div id="sm_listing_tabs_19158727221435666592" class="super-category-block first-load sn-category-block">

                                    <div class="block-title-defaults ">
                                        <div class="tab-category-title block-title">
                                            <strong><span>KIDS CORNER</span></strong>
                                            <div class="sn-img icon-bacsic item4"></div>

                                            <?php /*?><div class="customNavigation custom-nav-default">
                                                <a title="Previous" class="button-default prev-cat prev-super-cat-92 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                <a title="Next" class="button-default next-cat next-super-cat-92 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                            </div><?php */?>
                                        </div>
                                        
                                    </div>
                                    <div class="super-cat-wrapper">
                                        <div class="overflow-owl-slider">
                                            <div class="border-cat">
                                                <div class="rw-margin">
                                                    <div class="ltabs-items-container slider-cat-94">
                                                        <!--Begin Items-->
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(714,'Back Packs');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kidscorner/Backpacks.jpg" alt="Back Packs" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(714,'Back Packs');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(714,'Back Packs');?>"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(58,'Games');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kidscorner/Disney-Toys-for-Kids.jpg" alt="Games" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(58,'Games');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(58,'Games');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(21,'Baby Food');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kidscorner/Baby-Foods.jpg" alt="Baby Food" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(21,'Baby Food');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(21,'Baby Food');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(906,'Unisex');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kidscorner/Kids-Sneakers.jpg" alt="Unisex" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(906,'Unisex');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(906,'Unisex');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(190,'Children');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kidscorner/Childrens-Fragrance.jpg" alt="Children" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(190,'Children');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(190,'Children');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															
                                                    </div>
                                                </div>

                                                <script>
                                                    jQuery(document).ready(function($) {
                                                        var owl_cat_94 = $(".slider-cat-94");
                                                        owl_cat_94.owlCarousel({
                                                            itemsCustom: [
                                                                [0, 1],
                                                                [480, 2],
                                                                [768, 3],
                                                                [992, 3],
                                                                [1200, 5]
                                                            ],
                                                            navigation: false, // Show next and prev buttons
                                                            slideSpeed: 300,
                                                            stopOnHover: true,
                                                            paginationSpeed: 400,
                                                            autoPlay: false,
                                                            pagination: false,
                                                        });

                                                        $(".next-super-cat-94").click(function() {
                                                            owl_cat_94.trigger('owl.next');
                                                        })
                                                        $(".prev-super-cat-94").click(function() {
                                                            owl_cat_94.trigger('owl.prev');
                                                        })
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>
								
								<div id="sm_listing_tabs_19158727221435666592" class="super-category-block first-load sn-category-block">

                                    <div class="block-title-defaults ">
                                        <div class="tab-category-title block-title">
                                            <strong><span>BOOKS</span></strong>
                                            <div class="sn-img icon-bacsic item5"></div>

                                            <?php /*?><div class="customNavigation custom-nav-default">
                                                <a title="Previous" class="button-default prev-cat prev-super-cat-95 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                <a title="Next" class="button-default next-cat next-super-cat-95 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                            </div><?php */?>
                                        </div>
                                        
                                    </div>
                                    <div class="super-cat-wrapper">
                                        <div class="overflow-owl-slider">
                                            <div class="border-cat">
                                                <div class="rw-margin">
                                                    <div class="ltabs-items-container slider-cat-95">
                                                        <!--Begin Items-->
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(771,'Christian Literatures');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/books/Christian_Books.jpg" alt="Christian Literatures" />
                                                                            </a>
                                                                        </div>
																		
                                                                    </div>
																	
                                                                   
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(34,"Children's Books");?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/books/Childrens.jpg" alt="Children's Books" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	
                                                                    
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(51,'Fiction');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/books/Fiction_Books.jpg" alt="Fiction" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																
                                                                    
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(81,'Motivational & Self-Help');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/books/Motivational_Books.jpg" alt="Motivational & Self-Help" />
                                                                            </a>
                                                                        </div>
																		
                                                                    </div>
																	
													
                                                                    
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(48,'Family & Lifestyle');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/books/Lifestyle_Books.jpg" alt="Family & Lifestyle" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                       
                                                                    </div>
                                                                    </div>
																	
															
                                                                    
                                                                </div>
                                                            </div>	
                                                    </div>
                                                </div>

                                                <script>
                                                    jQuery(document).ready(function($) {
                                                        var owl_cat_95 = $(".slider-cat-95");
                                                        owl_cat_95.owlCarousel({

                                                            itemsCustom: [
                                                                [0, 1],
                                                                [480, 2],
                                                                [768, 3],
                                                                [992, 3],
                                                                [1200, 5]
                                                            ],
                                                            navigation: false, // Show next and prev buttons
                                                            slideSpeed: 300,
                                                            stopOnHover: true,
                                                            paginationSpeed: 400,
                                                            autoPlay: false,
                                                            pagination: false,
                                                        });

                                                        $(".next-super-cat-95").click(function() {
                                                            owl_cat_95.trigger('owl.next');
                                                        })
                                                        $(".prev-super-cat-95").click(function() {
                                                            owl_cat_95.trigger('owl.prev');
                                                        })
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>
								
								<div id="sm_listing_tabs_19158727221435666592" class="super-category-block first-load sn-category-block">

                                    <div class="block-title-defaults ">
                                        <div class="tab-category-title block-title">
                                            <strong><span>kitchen </span></strong>
                                            <div class="sn-img icon-bacsic item6"></div>

                                            <?php /*?><div class="customNavigation custom-nav-default">
                                                <a title="Previous" class="button-default prev-cat prev-super-cat-96 icon-angle-left"><i class="fa fa-angle-left"></i></a>
                                                <a title="Next" class="button-default next-cat next-super-cat-96 icon-angle-right"><i class="fa fa-angle-right"></i></a>
                                            </div><?php */?>
                                        </div>
                                        
                                    </div>
                                    <div class="super-cat-wrapper">
                                        <div class="overflow-owl-slider">
                                            <div class="border-cat">
                                                <div class="rw-margin">
                                                    <div class="ltabs-items-container slider-cat-96">
                                                        <!--Begin Items-->
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(1009,'Cookers & Ovens');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kitchen/Cookers-&-Ovens.jpg" alt="Cookers & Ovens" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(1009,'Cookers & Ovens');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(1009,'Cookers & Ovens');?>"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(483,'Washers & Dryers');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kitchen/Washers-&-Dryers.jpg" alt="Washers & Dryers" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(483,'Washers & Dryers');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(483,'Washers & Dryers');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(1007,'Blenders, Mixers & Juicers');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kitchen/Blenders-&-Mixers.jpg" alt="Blenders, Mixers & Juicers" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(1007,'Blenders, Mixers & Juicers');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(1007,'Blenders, Mixers & Juicers');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(1005,'Microwaves & Ovens');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kitchen/Microwaves-&-Ovens.jpg" alt="Microwaves & Ovens" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(1005,'Microwaves & Ovens');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(1005,'Microwaves & Ovens');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(1022,'Toasters & Sandwich Makers');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/kitchen/Toasters-&-Sandwich-Makers.jpg" alt="Toasters & Sandwich Makers" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(1022,'Toasters & Sandwich Makers');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo frontend_grid_category_url(1022,'Toasters & Sandwich Makers');?>"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															
                                                    </div>
                                                </div>

                                                <script>
                                                    jQuery(document).ready(function($) {
                                                        var owl_cat_96 = $(".slider-cat-96");
                                                        owl_cat_96.owlCarousel({
                                                            itemsCustom: [
                                                                [0, 1],
                                                                [480, 2],
                                                                [768, 3],
                                                                [992, 3],
                                                                [1200, 5]
                                                            ],
                                                            navigation: false, // Show next and prev buttons
                                                            slideSpeed: 300,
                                                            stopOnHover: true,
                                                            paginationSpeed: 400,
                                                            autoPlay: false,
                                                            pagination: false,
                                                        });

                                                        $(".next-super-cat-96").click(function() {
                                                            owl_cat_96.trigger('owl.next');
                                                        })
                                                        $(".prev-super-cat-96").click(function() {
                                                            owl_cat_96.trigger('owl.prev');
                                                        })
                                                    });
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!-- LISTINGTAB -->

                                <script type="text/javascript" src="sm/listingtabs/js/owl.carousel2.js"></script>
                                <div id="sm_listing_tabs_902086861436342941" class="sj-listing-tabs first-load">
                                    <!--<![endif]-->
                                    <div class="tab-listing-titles block-title">
                                        <strong><span>Top Selling</span></strong>
                                        <div class="sn-img icon-bacsic"></div>
                                    </div>
                                    <div class="ltabs-wrap ">
                                        <div class="ltabs-tabs-container" data-delay="300" data-duration="100" data-effect="zoomOut" data-ajaxurl="" data-modid="sm_listing_tabs_902086861436342941">
                                            <!--Begin Tabs-->
                                            <div class="ltabs-tabs-wrap block-title-v2">
                                                <span class='ltabs-tab-selected'></span>
                                                <span class='ltabs-tab-arrow'></span>
                                                <ul class="ltabs-tabs cf">
                                                    <li class="ltabs-tab sn0   tab-sel tab-loaded " data-category-id="125" data-active-content=".items-category-125">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/1_1.png" title="Electronic" alt="Electronic" />
                                                            <span class="ltabs-tab-label">Electronics						</span>
                                                        </div>
                                                    </li>
                                                    <li class="ltabs-tab sn1  " data-category-id="123" data-active-content=".items-category-123">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/3_1.png" title="Computer" alt="Computer" />
                                                            <span class="ltabs-tab-label">Computer								</span>
                                                        </div>
                                                    </li>
                                                    <li class="ltabs-tab sn2  " data-category-id="131" data-active-content=".items-category-131">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/10.png" title="Fashion" alt="Fashion" />
                                                            <span class="ltabs-tab-label">Woman								</span>
                                                        </div>





                                                    </li>
                                                    <li class="ltabs-tab sn3  " data-category-id="127" data-active-content=".items-category-127">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/5_1.png" title="MenSell" alt="MenSell" />
                                                            <span class="ltabs-tab-label">Men								</span>
                                                        </div>

                                                    </li>
                                                    <li class="ltabs-tab sn4  " data-category-id="124" data-active-content=".items-category-124">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/2_1.png" title="Mobiles" alt="Mobiles" />
                                                            <span class="ltabs-tab-label">Mobiles								</span>
                                                        </div>


                                                    </li>
                                                    <li class="ltabs-tab sn5  " data-category-id="133" data-active-content=".items-category-133">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/groomimg.png" title="Grooming" alt="Grooming" />
                                                            <span class="ltabs-tab-label">Grooming								</span>
                                                        </div>


                                                    </li>
                                                    <li class="ltabs-tab sn6  " data-category-id="126" data-active-content=".items-category-126">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/baby.png" title="Baby" alt="Baby" />
                                                            <span class="ltabs-tab-label">Baby								</span>
                                                        </div>

                                                    </li>
                                                    <li class="ltabs-tab sn7  " data-category-id="128" data-active-content=".items-category-128">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/office.png" title="Office" alt="Office" />
                                                            <span class="ltabs-tab-label">Office								</span>
                                                        </div>


                                                    </li>
                                                    <li class="ltabs-tab sn8  " data-category-id="132" data-active-content=".items-category-132">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/utility.png" title="Utility" alt="Utility" />
                                                            <span class="ltabs-tab-label">Utility	 							</span>
                                                        </div> 


                                                    </li>
                                                    <li class="ltabs-tab sn9  " data-category-id="129" data-active-content=".items-category-129">
                                                        <div class="ltabs-tab-img">
                                                            <img src="<?php echo base_url(); ?>images/new_images/media/catalog/category/resized/70x30/bb9245aaa65dec726fffa56a53534b65/household.png" title="Household" alt="Household" /> 
                                                            <span class="ltabs-tab-label">Household								</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- End Tabs-->
                                        <div class="ltabs-items-container super-cat-wrapper  show-slider">
                                            <!--Begin Items-->
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
                                                    <div class="ltabs-tabs-containers">
                                                        <div class="imgleft  img-effect">
                                                            <a class="img-class " href="#"><img alt="img-listing-left" src="<?php echo base_url(); ?>images/new_images/home/FREESHIPPING.png" />
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-9 col-md-9 col-sm-12" style="position: static;">
                                                    <div class="ltabs-items  ltabs-items-selected ltabs-items-loaded items-category-125">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4104,'Sollatek TV Guard Voltage Protector');?>">
																				<img title="Sollatek TV Guard Voltage Protector" alt="Sollatek TV Guard Voltage Protector" src="<?php echo base_url(); ?>images/new_images/home/topsell/electronics/Sollatek-TV-Guard-Voltage-Protector.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(4104,'Sollatek TV Guard Voltage Protector');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10450,'Beats By Dre Studio 2 Over-Ear Headphones - Red');?>">
                                                                            <img title="Beats By Dre Studio 2 Over-Ear Headphones - Red" alt="HBeats By Dre Studio 2 Over-Ear Headphones - Red" src="<?php echo base_url(); ?>images/new_images/home/topsell/electronics/Beats-By-Dre-Studio-2-Over-Ear-Headphones---Red.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10450,'Beats By Dre Studio 2 Over-Ear Headphones - Red');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10047,'Polystar PV-SDVD900 Portable Radio DVD System');?>">
                                                                            <img title="Polystar PV-SDVD900 Portable Radio DVD System" alt="Polystar PV-SDVD900 Portable Radio DVD System" src="<?php echo base_url(); ?>images/new_images/home/topsell/electronics/Polystar-PV-SDVD900-Portable-Radio-DVD-System.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10047,'Polystar PV-SDVD900 Portable Radio DVD System');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(2341,'LG 42 INCH PLASMA TV PN4500');?>">
                                                                            <img title="LG 42 INCH PLASMA TV PN4500" alt="LG 42 INCH PLASMA TV PN4500" src="<?php echo base_url(); ?>images/new_images/home/topsell/electronics/LG-42-INCH-PLASMA-TV-PN4500.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(2341,'LG 42 INCH PLASMA TV PN4500');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-123">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12038,'HP ProOne 400 G1 Intel® Pentium® G3250T 19.5" HD LED Touchscreen 4GB RAM, 500GB');?>">
                                                                            <img title='HP ProOne 400 G1 Intel® Pentium® G3250T 19.5" HD LED Touchscreen 4GB RAM, 500GB' alt='HP ProOne 400 G1 Intel® Pentium® G3250T 19.5 HD LED Touchscreen 4GB RAM, 500GB' src="<?php echo base_url(); ?>images/new_images/home/topsell/computer/HP-ProOne-400-G1-Intel®-Pentium®-G3250T-19.5-HD-LED-Touchscr.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12038,'HP ProOne 400 G1 Intel® Pentium® G3250T 19.5" HD LED Touchscreen 4GB RAM, 500GB');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7266,'Acer X113 3D 2800 Lumens DLP Projector');?>">
                                                                            <img title="Acer X113 3D 2800 Lumens DLP Projector" alt="Acer X113 3D 2800 Lumens DLP Projector" src="<?php echo base_url(); ?>images/new_images/home/topsell/computer/Acer-X113-3D-2800-Lumens-DLP-Projector.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(7266,'Acer X113 3D 2800 Lumens DLP Projector');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(11474,'ACER ASPIRE E14(E5-471-3541)INTEL CORE i3-4005U(1.7GHZ,3MB L3 CACHE) LAPTOP');?>">
                                                                            <img title="ACER ASPIRE E14(E5-471-3541)INTEL CORE i3-4005U(1.7GHZ,3MB L3 CACHE) LAPTOP" alt="ACER ASPIRE E14(E5-471-3541)INTEL CORE i3-4005U(1.7GHZ,3MB L3 CACHE) LAPTOP" src="<?php echo base_url(); ?>images/new_images/home/topsell/computer/ACER-ASPIRE-E14(E5-471-3541)INTEL-CORE-i3-4005U(1.7GHZ,3MB.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(11474,'ACER ASPIRE E14(E5-471-3541)INTEL CORE i3-4005U(1.7GHZ,3MB L3 CACHE) LAPTOP');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12044,'Veeda Laptop Bag-Black');?>">
                                                                            <img title="Veeda Laptop Bag-Black" alt="Veeda Laptop Bag-Black" src="<?php echo base_url(); ?>images/new_images/home/topsell/computer/Veeda-Laptop-Bag-Black.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12044,'Veeda Laptop Bag-Black');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-131">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10543,'Gucci Controllata Leather Hand Bag');?>">
                                                                            <img title="Gucci Controllata Leather Hand Bag" alt="Gucci Controllata Leather Hand Bag" src="<?php echo base_url(); ?>images/new_images/home/topsell/woman/Gucci-Controllata-Leather-Hand-Bag.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10543,'Gucci Controllata Leather Hand Bag');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10374,'Aphrodite High-Waisted Skinny Jeans -Navy Blue');?>">
                                                                            <img title="Aphrodite High-Waisted Skinny Jeans -Navy Blue" alt="Aphrodite High-Waisted Skinny Jeans -Navy Blue" src="<?php echo base_url(); ?>images/new_images/home/topsell/woman/Aphrodite-High-Waisted-Skinny-Jeans--Navy-Blue.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10374,'Aphrodite High-Waisted Skinny Jeans -Navy Blue');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(13072,'Gbemisoke heels - Green');?>">
                                                                            <img title="Gbemisoke heels - Green" alt="Gbemisoke heels - Green" src="<?php echo base_url(); ?>images/new_images/home/topsell/woman/Gbemisoke-heels---Green.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(13072,'Gbemisoke heels - Green');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10727,'Blue Studded Abaya Gown');?>">
                                                                            <img title="Blue Studded Abaya Gown" alt="Blue Studded Abaya Gown" src="<?php echo base_url(); ?>images/new_images/home/topsell/woman/Blue-Studded-Abaya-Gown.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10727,'Blue Studded Abaya Gown');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-127">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(1920,"Luceo blue sneakers");?>">
                                                                            <img title="Luceo blue sneakers" alt="Luceo blue sneakers" src="<?php echo base_url(); ?>images/new_images/home/topsell/men/Luceo-blue-sneakers.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(1920,"Luceo blue sneakers");?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12977,'TSW By Ruggedman GBMH 20 Short Sleeve T-Shirt - Black');?>">
                                                                            <img title="TSW By Ruggedman GBMH 20 Short Sleeve T-Shirt - Black" alt="TSW By Ruggedman GBMH 20 Short Sleeve T-Shirt - Black" src="<?php echo base_url(); ?>images/new_images/home/topsell/men/TSW-By-Ruggedman-GBMH-20-Short-Sleeve-T-Shirt---Black.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12977,'TSW By Ruggedman GBMH 20 Short Sleeve T-Shirt - Black');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(6104,"Men's Tuxedo Suit with Black Satin Shawl Lapel - Red & Black");?>">
                                                                            <img title="Men's Tuxedo Suit with Black Satin Shawl Lapel - Red & Black" alt="Men's Tuxedo Suit with Black Satin Shawl Lapel - Red & Black" src="<?php echo base_url(); ?>images/new_images/home/topsell/men/Men's-Tuxedo-Suit-with-Black-Satin-Shawl-Lapel---Red-&-Black.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(6104,"Men's Tuxedo Suit with Black Satin Shawl Lapel - Red & Black");?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(5530,'Parigi Golden Buckle Leather Belt – Salvatore Ferragamo');?>">
                                                                            <img title="Parigi Golden Buckle Leather Belt – Salvatore Ferragamo" alt="Parigi Golden Buckle Leather Belt – Salvatore Ferragamo" src="<?php echo base_url(); ?>images/new_images/home/topsell/men/Parigi-Golden-Buckle-Leather-Belt-–-Salvatore-Ferragamo.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(5530,'Parigi Golden Buckle Leather Belt – Salvatore Ferragamo');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>   
                                                    </div>
                                                    <div class="ltabs-items  items-category-124">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                        
                                                        
                                                         <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12795,'Samsung Galaxy S6 Duos SM-G920 32GB -Gold');?>">
                                                                            <img title="Samsung Galaxy S6 Duos SM-G920 32GB -Gold" alt="Samsung Galaxy S6 Duos SM-G920 32GB -Gold" src="<?php echo base_url(); ?>images/new_images/home/topsell/mobile/Samsung-Galaxy-S6-Duos-SM-G920-32GB--Gold.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12795,'Samsung Galaxy S6 Duos SM-G920 32GB -Gold');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12429,'Blackberry Passport - Silver');?>">
                                                                            <img title="Blackberry Passport - Silver" alt="Blackberry Passport - Silver" src="<?php echo base_url(); ?>images/new_images/home/topsell/mobile/Blackberry-Passport---Silver.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12429,'Blackberry Passport - Silver');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(1530,'Lumia 535 RM-1092 Dual SIM 8GB Smartphone');?>">
                                                                            <img title="Lumia 535 RM-1092 Dual SIM 8GB Smartphone" alt="Lumia 535 RM-1092 Dual SIM 8GB Smartphone" src="<?php echo base_url(); ?>images/new_images/home/topsell/mobile/Lumia-535-RM-1092-Dual-SIM-8GB-Smartphone.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(1530,'Lumia 535 RM-1092 Dual SIM 8GB Smartphone');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10452,'Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black');?>">
                                                                            <img title="Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black" alt="Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black" src="<?php echo base_url(); ?>images/new_images/home/topsell/mobile/Infinix-Hot-2-X510-(2GB-RAM,-16GB-ROM)---Black.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10452,'Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-133">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                             <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7866,'Nicky Clarke Hair Dryer');?>">
                                                                            <img title="Nicky Clarke Hair Dryer" alt="Nicky Clarke Hair Dryer" src="<?php echo base_url(); ?>images/new_images/home/topsell/grooming/Nicky-Clarke-Hair-Dryer.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(7866,'Nicky Clarke Hair Dryer');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8063,'Creme Luxe Lipstick- Forever Nude');?>">
                                                                            <img title="Creme Luxe Lipstick- Forever Nude" alt="Creme Luxe Lipstick- Forever Nude" src="<?php echo base_url(); ?>images/new_images/home/topsell/grooming/Creme-Luxe-Lipstick--Forever-Nude.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(8063,'Creme Luxe Lipstick- Forever Nude');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8949,'Remy 2-Toned U.S Human Hair');?>">
                                                                            <img title="Remy 2-Toned U.S Human Hair" alt="Remy 2-Toned U.S Human Hair" src="<?php echo base_url(); ?>images/new_images/home/topsell/grooming/Remy-2-Toned-U.S-Human-Hair.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(8949,'Remy 2-Toned U.S Human Hair');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(9794,'Romanian Curls Human Hair - 2 Layers');?>">
                                                                            <img title="Romanian Curls Human Hair - 2 Layers" alt="Romanian Curls Human Hair - 2 Layers" src="<?php echo base_url(); ?>images/new_images/home/topsell/grooming/Romanian-Curls--Human-Hair---2-Layers.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(9794,'Romanian Curls Human Hair - 2 Layers');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-126">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7125,'Stroller Kids School Bag');?>">
                                                                            <img title="Stroller Kids School Bag" alt="Stroller Kids School Bag" src="<?php echo base_url(); ?>images/new_images/home/topsell/baby/Stroller-Kids-School-Bag.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(7125,'Stroller Kids School Bag');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(11067,'Stainless Steel Food Flasks- 5 Piece Set');?>">
                                                                            <img title="Stainless Steel Food Flasks- 5 Piece Set" alt="Stainless Steel Food Flasks- 5 Piece Set" src="<?php echo base_url(); ?>images/new_images/home/topsell/baby/Stainless-Steel-Food-Flasks--5-Piece-Set.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(11067,'Stainless Steel Food Flasks- 5 Piece Set');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(9767,'Barcelona Nike Endorsed Kids Home Jersey 2015/2016 Season - Red & Blue');?>">
                                                                            <img title="Barcelona Nike Endorsed Kids Home Jersey 2015/2016 Season - Red & Blue" alt="Barcelona Nike Endorsed Kids Home Jersey 2015/2016 Season - Red & Blue" src="<?php echo base_url(); ?>images/new_images/home/topsell/baby/Barcelona-Nike-Endorsed-Kids-Home-Jersey-20152016-Season----Re.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(9767,'Barcelona Nike Endorsed Kids Home Jersey 2015/2016 Season - Red & Blue');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7144,'Best To School Brown Leather Shoe');?>">
                                                                            <img title="Best To School Brown Leather Shoe" alt="Best To School Brown Leather Shoe" src="<?php echo base_url(); ?>images/new_images/home/topsell/baby/Best-To-School-Brown-Leather-Shoe.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(7144,'Best To School Brown Leather Shoe');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-128">
                                                        <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(2644,'HP Deskjet Ink Advantage 1515 All-in-One');?>">
                                                                            <img title="HP Deskjet Ink Advantage 1515 All-in-One" alt="HP Deskjet Ink Advantage 1515 All-in-One" src="<?php echo base_url(); ?>images/new_images/home/topsell/office/HP-Deskjet-Ink-Advantage-1515-All-in-One.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(2644,'HP Deskjet Ink Advantage 1515 All-in-One');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(11548,'CASIO DR-140L 14 Digit Desktop Printing Calculator');?>">
                                                                            <img title="CASIO DR-140L 14 Digit Desktop Printing Calculator" alt="CASIO DR-140L 14 Digit Desktop Printing Calculator" src="<?php echo base_url(); ?>images/new_images/home/topsell/office/CASIO-DR-140L-14-Digit-Desktop-Printing-Calculator.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(11548,'CASIO DR-140L 14 Digit Desktop Printing Calculator');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(11425,'Flip Chart Board');?>">
                                                                            <img title="Flip Chart Board" alt="Flip Chart Board" src="<?php echo base_url(); ?>images/new_images/home/topsell/office/Flip-Chart-Board.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(11425,'Flip Chart Board');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(11761,'Conqueror Paper Laid Cream A4 100gsm Ream');?>">
                                                                            <img title="Conqueror Paper Laid Cream A4 100gsm Ream" alt="Conqueror Paper Laid Cream A4 100gsm Ream" src="<?php echo base_url(); ?>images/new_images/home/topsell/office/Conqueror-Paper-Laid-Cream-A4-100gsm-Ream.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(11761,'Conqueror Paper Laid Cream A4 100gsm Ream');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ltabs-items  items-category-129">
                                                       
 														  <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(2171,'Saisho Electric Barbecue Grill');?>">
                                                                            <img title="Saisho Electric Barbecue Grill" alt="Saisho Electric Barbecue Grill" src="<?php echo base_url(); ?>images/new_images/home/topsell/household/Saisho-Electric-Barbecue.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(2171,'Saisho Electric Barbecue Grill');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4139,'Master Chef 4-In-1 Juicer, Blender, Grinder and Mill');?>">
                                                                            <img title="Master Chef 4-In-1 Juicer, Blender, Grinder and Mill" alt="Master Chef 4-In-1 Juicer, Blender, Grinder and Mill" src="<?php echo base_url(); ?>images/new_images/home/topsell/household/Master-Chef-4-In-1-Juicer,-Blender,-Grinder-and-Mill.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(4139,'Master Chef 4-In-1 Juicer, Blender, Grinder and Mill');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(12895,'Philips FC6142 Vacuum cleaner');?>">
                                                                            <img title="Philips FC6142 Vacuum cleaner" alt="Philips FC6142 Vacuum cleaner" src="<?php echo base_url(); ?>images/new_images/home/topsell/household/Philips-FC6142-Vacuum-cleaner.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(12895,'Philips FC6142 Vacuum cleaner');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(5198,'Sabichi Shower Curtain in Green Stripes');?>">
                                                                            <img title="Sabichi Shower Curtain in Green Stripes" alt="Sabichi Shower Curtain in Green Stripes" src="<?php echo base_url(); ?>images/new_images/home/topsell/household/Sabichi-Shower-Curtain-in-Green-Stripes.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(5198,'Sabichi Shower Curtain in Green Stripes');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
													<div class="ltabs-items  items-category-132">
                                                      	 <div class="ltabs-items-inner ltabs00-4 ltabs01-4 ltabs02-3 ltabs03-2 ltabs04-1 zoomOut">
                                                           
                                                             <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4877,'Sumec Firman Generator - SPG1800');?>">
                                                                            <img title="Sumec Firman Generator - SPG1800" alt="Sumec Firman Generator - SPG1800" src="<?php echo base_url(); ?>images/new_images/home/topsell/utility/Sumec-Firman-Generator---SPG1800.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(4877,'Sumec Firman Generator - SPG1800');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(10418,'2-in-1 Potable Solar Power Generator + Phone Charger');?>">
                                                                            <img title="2-in-1 Potable Solar Power Generator + Phone Charger" alt="2-in-1 Potable Solar Power Generator + Phone Charger" src="<?php echo base_url(); ?>images/new_images/home/topsell/utility/2-in-1-Potable-Solar-Power-Generator-+-Phone-Charger.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(10418,'2-in-1 Potable Solar Power Generator + Phone Charger');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7029,'Luminous Inverters Eco 1KVA');?>">
                                                                            <img title="Luminous Inverters Eco 1KVA" alt="Luminous Inverters Eco 1KVA" src="<?php echo base_url(); ?>images/new_images/home/topsell/utility/Luminous-Inverters-Eco-1KVA.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(7029,'Luminous Inverters Eco 1KVA');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(6283,'Solar Panels 12v/130watts');?>">
                                                                            <img title="Solar Panels 12v/130watts" alt="Solar Panels 12v/130watts" src="<?php echo base_url(); ?>images/new_images/home/topsell/utility/Solar-Panels-12v130watts.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo product_url(6283,'Solar Panels 12v/130watts');?>"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                        </div>
													  
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!--End Items-->
                                    </div>
                                </div>

                                <script type="text/javascript">
                                    //<![CDATA[
                                    jQuery(document).ready(function($) {;
                                        (function(element) {
                                            var $element = $(element),
                                                $tab = $('.ltabs-tab', $element),
                                                $tab_label = $('.ltabs-tab-label', $tab),
                                                $tabs = $('.ltabs-tabs', $element),
                                                ajax_url = $tabs.parents('.ltabs-tabs-container').attr('data-ajaxurl'),
                                                effect = $tabs.parents('.ltabs-tabs-container').attr('data-effect'),
                                                delay = $tabs.parents('.ltabs-tabs-container').attr('data-delay'),
                                                duration = $tabs.parents('.ltabs-tabs-container').attr('data-duration'),
                                                rl_moduleid = $tabs.parents('.ltabs-tabs-container').attr('data-modid'),
                                                $items_content = $('.ltabs-items', $element),
                                                $items_inner = $('.ltabs-items-inner', $items_content),
                                                $items_first_active = $('.ltabs-items-selected', $element),
                                                $load_more = $('.ltabs-loadmore', $element),
                                                $btn_loadmore = $('.ltabs-loadmore-btn', $load_more),
                                                $select_box = $('.ltabs-selectbox', $element),
                                                $tab_label_select = $('.ltabs-tab-selected', $element);

                                            enableSelectBoxes();

                                            function enableSelectBoxes() {
                                                $tab_wrap = $('.ltabs-tabs-wrap', $element),
                                                    $tab_label_select.html($('.ltabs-tab', $element).filter('.tab-sel').children('.ltabs-tab-label').html());
                                                if ($(window).innerWidth() <= 479) {
                                                    $tab_wrap.addClass('ltabs-selectbox');
                                                } else {
                                                    $tab_wrap.removeClass('ltabs-selectbox');
                                                }
                                            }

                                            $('span.ltabs-tab-selected, span.ltabs-tab-arrow', $element).click(function() {
                                                if ($('.ltabs-tabs', $element).hasClass('ltabs-open')) {
                                                    $('.ltabs-tabs', $element).removeClass('ltabs-open');
                                                } else {
                                                    $('.ltabs-tabs', $element).addClass('ltabs-open');
                                                }
                                            });

                                            $(window).resize(function() {
                                                if ($(window).innerWidth() <= 479) {
                                                    $('.ltabs-tabs-wrap', $element).addClass('ltabs-selectbox');
                                                } else {
                                                    $('.ltabs-tabs-wrap', $element).removeClass('ltabs-selectbox');
                                                }
                                            });

                                            function showAnimateItems(el) {
                                                var $_items = $('.new-ltabs-item', el),
                                                    nub = 0;
                                                $('.ltabs-loadmore-btn', el).fadeOut('fast');
                                                $_items.each(function(i) {
                                                    nub++;
                                                    switch (effect) {
                                                        case 'none':
                                                            $(this).css({
                                                                'opacity': '1',
                                                                'filter': 'alpha(opacity = 100)'
                                                            });
                                                            break;
                                                        default:
                                                            animatesItems($(this), nub * delay, i, el);
                                                    }
                                                    if (i == $_items.length - 1) {
                                                        $('.ltabs-loadmore-btn', el).fadeIn(delay);
                                                    }
                                                    $(this).removeClass('new-ltabs-item');
                                                });
                                            }

                                            function animatesItems($this, fdelay, i, el) {
                                                var $_items = $('.ltabs-item', el);
                                                $this.attr("style",
                                                    "-webkit-animation:" + effect + " " + duration + "ms;" + "-moz-animation:" + effect + " " + duration + "ms;" + "-o-animation:" + effect + " " + duration + "ms;" + "-moz-animation-delay:" + fdelay + "ms;" + "-webkit-animation-delay:" + fdelay + "ms;" + "-o-animation-delay:" + fdelay + "ms;" + "animation-delay:" + fdelay + "ms;").delay(fdelay).animate({
                                                    opacity: 1,
                                                    filter: 'alpha(opacity = 100)'
                                                }, {
                                                    //delay: 100
                                                });
                                                if (i == ($_items.length - 1)) {
                                                    $(".ltabs-items-inner").addClass("play");
                                                }
                                            }

                                            showAnimateItems($items_first_active);
                                            $tab.on('click.tab', function() {
                                                var $this = $(this);
                                                if ($this.hasClass('tab-sel')) return false;
                                                if ($this.parents('.ltabs-tabs').hasClass('ltabs-open')) {
                                                    $this.parents('.ltabs-tabs').removeClass('ltabs-open');
                                                }
                                                $tab.removeClass('tab-sel');
                                                $this.addClass('tab-sel');
                                                var items_active = $this.attr('data-active-content');
                                                var _items_active = $(items_active, $element);
                                                $items_content.removeClass('ltabs-items-selected');
                                                _items_active.addClass('ltabs-items-selected');
                                                $tab_label_select.html($tab.filter('.tab-sel').children('.ltabs-tab-label').html());
                                                var $loading = $('.ltabs-loading', _items_active);
                                                var loaded = _items_active.hasClass('ltabs-items-loaded');
                                                if (!loaded && !_items_active.hasClass('ltabs-process')) {
                                                    _items_active.addClass('ltabs-process');
                                                    var category_id = $this.attr('data-category-id');
                                                    $loading.show();
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: ajax_url,
                                                        data: {
                                                            listing_tabs_moduleid: rl_moduleid,
                                                            is_ajax_listing_tabs: 1,
                                                            ajax_listingtags_start: 0,
                                                            categoryid: category_id,
															'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
                                                            config: 'eyJhY3RpdmUiOiIxIiwibGlzdGluZ3RhYnNfdGl0bGVfdGV4dCI6IlRvcCBTZWxsaW5nIiwicHJvZHVjdF9saW5rc190YXJnZXQiOiJfc2VsZiIsIm5iaV9jb2x1bW4xIjoiNCIsIm5iaV9jb2x1bW4yIjoiMyIsIm5iaV9jb2x1bW4zIjoiMiIsIm5iaV9jb2x1bW40IjoiMSIsInNob3dfbG9hZG1vcmVfc2xpZGVyIjoic2xpZGVyIiwiZmlsdGVyX3R5cGUiOiJjYXRlZ29yaWVzIiwicHJvZHVjdF9jYXRlZ29yeSI6IjEyMywxMjQsMTI1LDEyNiwxMjcsMTI4LDEyOSwxMzEsMTMyLDEzMyIsImZpbHRlcl9vcmRlcl9ieSI6Im5hbWUiLCJmaWVsZF9wcmVsb2FkIjoibmFtZSIsImNhdGVnb3J5X3ByZWxvYWQiOiIyIiwiY2hpbGRfY2F0ZWdvcnlfcHJvZHVjdHMiOiIxIiwibWF4X2RlcHRoIjoiMTAiLCJwcm9kdWN0X2ZlYXR1cmVkIjoiMCIsInByb2R1Y3Rfb3JkZXJfYnkiOiJuYW1lIiwicHJvZHVjdF9vcmRlcl9kaXIiOiJBU0MiLCJwcm9kdWN0X2xpbWl0YXRpb24iOiI0IiwidGFiX2FsbF9kaXNwbGF5IjoiMCIsImNhdF90aXRsZV9tYXhsZW5ndGgiOiI1MCIsImNhdGVnb3J5X29yZGVyX2J5IjoibmFtZSIsImNhdGVnb3J5X29yZGVyX2RpciI6IkFTQyIsImljb25fZGlzcGxheSI6IjEiLCJpbWdjZmdjYXRfZnJvbV9jYXRlZ29yeV9pbWFnZSI6IjEiLCJpbWdjZmdjYXRfZnJvbV9jYXRlZ29yeV90aHVtYm5haWwiOiIxIiwiaW1nY2ZnY2F0X2Zyb21fY2F0ZWdvcnlfZGVzY3JpcHRpb24iOiIxIiwiaW1nY2ZnY2F0X29yZGVyIjoiY2F0ZWdvcnlfaW1hZ2UsIGNhdGVnb3J5X3RodW1ibmFpbCwgY2F0ZWdvcnlfZGVzY3JpcHRpb24iLCJpbWdjZmdjYXRfZnVuY3Rpb24iOiIxIiwiaW1nY2ZnY2F0X3dpZHRoIjoiNzAiLCJpbWdjZmdjYXRfaGVpZ2h0IjoiMzAiLCJpbWdjZmdjYXRfY29uc3RyYWluT25seSI6IjEiLCJpbWdjZmdjYXRfa2VlcEFzcGVjdFJhdGlvIjoiMSIsImltZ2NmZ2NhdF9rZWVwRnJhbWUiOiIxIiwiaW1nY2ZnY2F0X2tlZXBUcmFuc3BhcmVuY3kiOiIxIiwiaW1nY2ZnY2F0X2JhY2tncm91bmQiOiJGRkZGRkYiLCJpbWdjZmdjYXRfcGxhY2Vob2xkZXIiOiJzbVwvbGlzdGluZ3RhYnNcL2ltYWdlc1wvbm9waG90by5qcGciLCJwcm9kdWN0X3RpdGxlX2Rpc3BsYXkiOiIxIiwicHJvZHVjdF90aXRsZV9tYXhsZW5ndGgiOiIyNSIsInByb2R1Y3RfaW1hZ2Vfd2lkdGgiOiIyMDAiLCJwcm9kdWN0X2ltYWdlX2hlaWdodCI6IjIwMCIsInByb2R1Y3RfZGVzY3JpcHRpb25fZGlzcGxheSI6IjAiLCJwcm9kdWN0X2Rlc2NyaXB0aW9uX21heGxlbmd0aCI6IjE1MCIsInByb2R1Y3RfcHJpY2VfZGlzcGxheSI6IjEiLCJwcm9kdWN0X2RhdGVfZGlzcGxheSI6IjAiLCJwcm9kdWN0X2hpdHNfZGlzcGxheSI6IjAiLCJwcm9kdWN0X3Jldmlld3NfY291bnQiOiIxIiwicHJvZHVjdF9hZGRjYXJ0X2Rpc3BsYXkiOiIxIiwicHJvZHVjdF9hZGR3aXNobGlzdF9kaXNwbGF5IjoiMSIsInByb2R1Y3RfYWRkY29tcGFyZV9kaXNwbGF5IjoiMSIsInByb2R1Y3RfcmVhZG1vcmVfZGlzcGxheSI6IjAiLCJwcm9kdWN0X3JlYWRtb3JlX3RleHQiOiJEZXRhaWxzIiwiaW1nY2ZnX2Zyb21fcHJvZHVjdF9pbWFnZSI6IjEiLCJpbWdjZmdfZnJvbV9wcm9kdWN0X2Rlc2NyaXB0aW9uIjoiMCIsImltZ2NmZ19vcmRlciI6InByb2R1Y3RfaW1hZ2UsIHByb2R1Y3RfZGVzY3JpcHRpb24iLCJpbWdjZmdfZnVuY3Rpb24iOiIxIiwiaW1nY2ZnX3dpZHRoIjoiMjAwIiwiaW1nY2ZnX2hlaWdodCI6IjE2NyIsImltZ2NmZ19jb25zdHJhaW5Pbmx5IjoiIiwiaW1nY2ZnX2tlZXBBc3BlY3RSYXRpbyI6IjEiLCJpbWdjZmdfa2VlcEZyYW1lIjoiMSIsImltZ2NmZ19rZWVwVHJhbnNwYXJlbmN5IjoidHJ1ZSIsImltZ2NmZ19iYWNrZ3JvdW5kIjoiRkZGRkZGIiwiaW1nY2ZnX3BsYWNlaG9sZGVyIjoic21cL2xpc3Rpbmd0YWJzXC9pbWFnZXNcL25vcGhvdG8uanBnIiwiZWZmZWN0Ijoiem9vbU91dCIsImR1cmF0aW9uIjoiMTAwIiwiZGVsYXkiOiIzMDAiLCJjZW50ZXIiOiIiLCJuYXYiOiIxIiwibG9vcCI6IjEiLCJtYXJnaW4iOiIwIiwic2xpZGVCeSI6IjEiLCJhdXRvcGxheSI6IiIsImF1dG9wbGF5SG92ZXJQYXVzZSI6IjEiLCJhdXRvcGxheVNwZWVkIjoiMTAwMCIsIm5hdlNwZWVkIjoiMTAwMCIsInNtYXJ0U3BlZWQiOiIxMDAwIiwic3RhcnRQb3NpdGlvbiI6IjEiLCJtb3VzZURyYWciOiIxIiwidG91Y2hEcmFnIjoiMSIsInB1bGxEcmFnIjoiMSIsImluY2x1ZGVfanF1ZXJ5IjoiMCIsInByZXRleHQiOiIiLCJwb3N0dGV4dCI6IiJ9'
                                                        },
                                                        success: function(data) {
                                                            if (data.items_markup != '') {
                                                                $('.ltabs-items-inner', _items_active).html(data.items_markup);
                                                                _items_active.addClass('ltabs-items-loaded').removeClass('ltabs-process');
                                                                $loading.remove();
                                                                showAnimateItems(_items_active);
                                                                updateStatus(_items_active);

                                                                CreateProSlider($('.ltabs-items-inner', _items_active));

                                                            }
                                                        },
                                                        dataType: 'json'
                                                    });

                                                } else {


                                                    var owl = $('.ltabs-items-inner', _items_active);
                                                    owl = owl.data('owlCarousel2');
                                                    if (typeof owl === 'undefined') {} else {
                                                        owl.onResize();
                                                    }
                                                }
                                            });

                                            function updateStatus($el) {
                                                $('.ltabs-loadmore-btn', $el).removeClass('loading');
                                                var countitem = $('.ltabs-item', $el).length;
                                                $('.ltabs-image-loading', $el).css({
                                                    display: 'none'
                                                });
                                                $('.ltabs-loadmore-btn', $el).parent().attr('data-rl_start', countitem);
                                                var rl_total = $('.ltabs-loadmore-btn', $el).parent().attr('data-rl_total');
                                                var rl_load = $('.ltabs-loadmore-btn', $el).parent().attr('data-rl_load');
                                                var rl_allready = $('.ltabs-loadmore-btn', $el).parent().attr('data-rl_allready');

                                                if (countitem >= rl_total) {
                                                    $('.ltabs-loadmore-btn', $el).addClass('loaded');
                                                    $('.ltabs-image-loading', $el).css({
                                                        display: 'none'
                                                    });
                                                    $('.ltabs-loadmore-btn', $el).attr('data-label', rl_allready);
                                                    $('.ltabs-loadmore-btn', $el).removeClass('loading');
                                                }
                                            }

                                            $btn_loadmore.on('click.loadmore', function() {
                                                var $this = $(this);
                                                if ($this.hasClass('loaded') || $this.hasClass('loading')) {

                                                    return false;
                                                } else {
                                                    $this.addClass('loading');
                                                    $('.ltabs-image-loading', $this).css({
                                                        display: 'inline-block'
                                                    });
                                                    var rl_start = $this.parent().attr('data-rl_start'),
                                                        rl_moduleid = $this.parent().attr('data-modid'),
                                                        rl_ajaxurl = $this.parent().attr('data-ajaxurl'),
                                                        effect = $this.parent().attr('data-effect'),
                                                        category_id = $this.parent().attr('data-categoryid'),
                                                        items_active = $this.parent().attr('data-active-content');
                                                    var _items_active = $(items_active, $element);
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: rl_ajaxurl,
                                                        data: {
                                                            listing_tabs_moduleid: rl_moduleid,
                                                            is_ajax_listing_tabs: 1,
                                                            ajax_listingtags_start: rl_start,
                                                            categoryid: category_id,
															'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>',
                                                            config: 'eyJhY3RpdmUiOiIxIiwibGlzdGluZ3RhYnNfdGl0bGVfdGV4dCI6IlRvcCBTZWxsaW5nIiwicHJvZHVjdF9saW5rc190YXJnZXQiOiJfc2VsZiIsIm5iaV9jb2x1bW4xIjoiNCIsIm5iaV9jb2x1bW4yIjoiMyIsIm5iaV9jb2x1bW4zIjoiMiIsIm5iaV9jb2x1bW40IjoiMSIsInNob3dfbG9hZG1vcmVfc2xpZGVyIjoic2xpZGVyIiwiZmlsdGVyX3R5cGUiOiJjYXRlZ29yaWVzIiwicHJvZHVjdF9jYXRlZ29yeSI6IjEyMywxMjQsMTI1LDEyNiwxMjcsMTI4LDEyOSwxMzEsMTMyLDEzMyIsImZpbHRlcl9vcmRlcl9ieSI6Im5hbWUiLCJmaWVsZF9wcmVsb2FkIjoibmFtZSIsImNhdGVnb3J5X3ByZWxvYWQiOiIyIiwiY2hpbGRfY2F0ZWdvcnlfcHJvZHVjdHMiOiIxIiwibWF4X2RlcHRoIjoiMTAiLCJwcm9kdWN0X2ZlYXR1cmVkIjoiMCIsInByb2R1Y3Rfb3JkZXJfYnkiOiJuYW1lIiwicHJvZHVjdF9vcmRlcl9kaXIiOiJBU0MiLCJwcm9kdWN0X2xpbWl0YXRpb24iOiI0IiwidGFiX2FsbF9kaXNwbGF5IjoiMCIsImNhdF90aXRsZV9tYXhsZW5ndGgiOiI1MCIsImNhdGVnb3J5X29yZGVyX2J5IjoibmFtZSIsImNhdGVnb3J5X29yZGVyX2RpciI6IkFTQyIsImljb25fZGlzcGxheSI6IjEiLCJpbWdjZmdjYXRfZnJvbV9jYXRlZ29yeV9pbWFnZSI6IjEiLCJpbWdjZmdjYXRfZnJvbV9jYXRlZ29yeV90aHVtYm5haWwiOiIxIiwiaW1nY2ZnY2F0X2Zyb21fY2F0ZWdvcnlfZGVzY3JpcHRpb24iOiIxIiwiaW1nY2ZnY2F0X29yZGVyIjoiY2F0ZWdvcnlfaW1hZ2UsIGNhdGVnb3J5X3RodW1ibmFpbCwgY2F0ZWdvcnlfZGVzY3JpcHRpb24iLCJpbWdjZmdjYXRfZnVuY3Rpb24iOiIxIiwiaW1nY2ZnY2F0X3dpZHRoIjoiNzAiLCJpbWdjZmdjYXRfaGVpZ2h0IjoiMzAiLCJpbWdjZmdjYXRfY29uc3RyYWluT25seSI6IjEiLCJpbWdjZmdjYXRfa2VlcEFzcGVjdFJhdGlvIjoiMSIsImltZ2NmZ2NhdF9rZWVwRnJhbWUiOiIxIiwiaW1nY2ZnY2F0X2tlZXBUcmFuc3BhcmVuY3kiOiIxIiwiaW1nY2ZnY2F0X2JhY2tncm91bmQiOiJGRkZGRkYiLCJpbWdjZmdjYXRfcGxhY2Vob2xkZXIiOiJzbVwvbGlzdGluZ3RhYnNcL2ltYWdlc1wvbm9waG90by5qcGciLCJwcm9kdWN0X3RpdGxlX2Rpc3BsYXkiOiIxIiwicHJvZHVjdF90aXRsZV9tYXhsZW5ndGgiOiIyNSIsInByb2R1Y3RfaW1hZ2Vfd2lkdGgiOiIyMDAiLCJwcm9kdWN0X2ltYWdlX2hlaWdodCI6IjIwMCIsInByb2R1Y3RfZGVzY3JpcHRpb25fZGlzcGxheSI6IjAiLCJwcm9kdWN0X2Rlc2NyaXB0aW9uX21heGxlbmd0aCI6IjE1MCIsInByb2R1Y3RfcHJpY2VfZGlzcGxheSI6IjEiLCJwcm9kdWN0X2RhdGVfZGlzcGxheSI6IjAiLCJwcm9kdWN0X2hpdHNfZGlzcGxheSI6IjAiLCJwcm9kdWN0X3Jldmlld3NfY291bnQiOiIxIiwicHJvZHVjdF9hZGRjYXJ0X2Rpc3BsYXkiOiIxIiwicHJvZHVjdF9hZGR3aXNobGlzdF9kaXNwbGF5IjoiMSIsInByb2R1Y3RfYWRkY29tcGFyZV9kaXNwbGF5IjoiMSIsInByb2R1Y3RfcmVhZG1vcmVfZGlzcGxheSI6IjAiLCJwcm9kdWN0X3JlYWRtb3JlX3RleHQiOiJEZXRhaWxzIiwiaW1nY2ZnX2Zyb21fcHJvZHVjdF9pbWFnZSI6IjEiLCJpbWdjZmdfZnJvbV9wcm9kdWN0X2Rlc2NyaXB0aW9uIjoiMCIsImltZ2NmZ19vcmRlciI6InByb2R1Y3RfaW1hZ2UsIHByb2R1Y3RfZGVzY3JpcHRpb24iLCJpbWdjZmdfZnVuY3Rpb24iOiIxIiwiaW1nY2ZnX3dpZHRoIjoiMjAwIiwiaW1nY2ZnX2hlaWdodCI6IjE2NyIsImltZ2NmZ19jb25zdHJhaW5Pbmx5IjoiIiwiaW1nY2ZnX2tlZXBBc3BlY3RSYXRpbyI6IjEiLCJpbWdjZmdfa2VlcEZyYW1lIjoiMSIsImltZ2NmZ19rZWVwVHJhbnNwYXJlbmN5IjoidHJ1ZSIsImltZ2NmZ19iYWNrZ3JvdW5kIjoiRkZGRkZGIiwiaW1nY2ZnX3BsYWNlaG9sZGVyIjoic21cL2xpc3Rpbmd0YWJzXC9pbWFnZXNcL25vcGhvdG8uanBnIiwiZWZmZWN0Ijoiem9vbU91dCIsImR1cmF0aW9uIjoiMTAwIiwiZGVsYXkiOiIzMDAiLCJjZW50ZXIiOiIiLCJuYXYiOiIxIiwibG9vcCI6IjEiLCJtYXJnaW4iOiIwIiwic2xpZGVCeSI6IjEiLCJhdXRvcGxheSI6IiIsImF1dG9wbGF5SG92ZXJQYXVzZSI6IjEiLCJhdXRvcGxheVNwZWVkIjoiMTAwMCIsIm5hdlNwZWVkIjoiMTAwMCIsInNtYXJ0U3BlZWQiOiIxMDAwIiwic3RhcnRQb3NpdGlvbiI6IjEiLCJtb3VzZURyYWciOiIxIiwidG91Y2hEcmFnIjoiMSIsInB1bGxEcmFnIjoiMSIsImluY2x1ZGVfanF1ZXJ5IjoiMCIsInByZXRleHQiOiIiLCJwb3N0dGV4dCI6IiJ9'
                                                        },
                                                        success: function(data) {
                                                            if (data.items_markup != '') {
                                                                $(data.items_markup).insertAfter($('.ltabs-item', _items_active).nextAll().last());
                                                                $('.ltabs-image-loading', $this).css({
                                                                    display: 'none'
                                                                });
                                                                showAnimateItems(_items_active);
                                                                updateStatus(_items_active);
                                                            }
                                                        },
                                                        dataType: 'json'
                                                    });
                                                }
                                                return false;
                                            });

                                            if ($('.ltabs-items-inner', $element).parent().hasClass('ltabs-items-selected')) {
                                                var items_active = $('.ltabs-tab.tab-sel', $element).attr('data-active-content');
                                                var _items_active = $(items_active, $element);
                                                CreateProSlider($('.ltabs-items-inner', _items_active));
                                            }

                                            function CreateProSlider($items_inner) {
                                                $items_inner.owlCarousel2({
                                                    center: false,
                                                    nav: true,
                                                    loop: true,
                                                    margin: 0,
                                                    slideBy: 1,
                                                    autoplay: false,
                                                    autoplayHoverPause: true,
                                                    autoplaySpeed: 1000,
                                                    navSpeed: 1000,
                                                    smartSpeed: 1000,
                                                    startPosition: 1,
                                                    mouseDrag: true,
                                                    touchDrag: true,
                                                    pullDrag: true,
                                                    dots: false,
                                                    autoWidth: false,
                                                    navClass: ['owl-prev', 'owl-next'],
                                                    navText: ['&#139;', '&#155;'],
                                                    responsive: {
                                                        0: {
                                                            items: 1
                                                        },
                                                        480: {
                                                            items: 2
                                                        },
                                                        768: {
                                                            items: 3
                                                        },
                                                        1200: {
                                                            items: 4
                                                        }
                                                    }
                                                });
                                            }


                                        })('#sm_listing_tabs_902086861436342941');
                                    });
                                    //]]>
                                </script>



                                <!-- BRAND -->

                                <?php /*?><div class="slider-brand-bottom-wrapper">
                                    <div class="customNavigation custom-nav-default">
                                        <a class="button-default prev-brand-bottom icon-angle-left" title="Previous"><i class="fa fa-angle-left"></i></a>
                                        <a class="button-default next-brand-bottom icon-angle-right" title="Next"><i class="fa fa-angle-right"></i></a>
                                    </div>

                                    <div class="slider-brand-bottom">
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/addidas.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/aldo.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/amani2.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/amrmnai.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/apple.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/binatone.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/blackberrry.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/bnanarep.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/bvlarri.png" alt="Image Brand" />
                                            </a>
                                        </div>
										<div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/casio.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/chanel.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/ck.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/gap.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/hp.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/hugoboss.png" alt="Image Brand" />
                                            </a>
                                        </div>

                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/lg.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/nokia.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/panasoni.png" alt="Image Brand" />
                                            </a>
                                        </div>
										<div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/samsung.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                        <div class="item">
                                            <a href="#" title="Image Brand"><img src="<?php echo base_url(); ?>images/new_images/home/brand/sony.png" alt="Image Brand" />
                                            </a>
                                        </div>
                                    </div>

                                    <script>
                                        jQuery(document).ready(function($) {
                                            var owl_slider_brand = $(".slider-brand-bottom");
                                            owl_slider_brand.owlCarousel({
                                                itemsCustom: [
                                                    [0, 2],
                                                    [480, 3],
                                                    [768, 4],
                                                    [992, 5],
                                                    [1200, 6]
                                                ],
                                                navigation: false, // Show next and prev buttons
                                                paginationSpeed: 400,
                                                autoPlay: false,
                                                pagination: false,
                                                stopOnHover: true
                                            });

                                            $(".next-brand-bottom").click(function() {
                                                owl_slider_brand.trigger('owl.next');
                                            })
                                            $(".prev-brand-bottom").click(function() {
                                                owl_slider_brand.trigger('owl.prev');
                                            })
                                        });
                                    </script>
                                </div><?php */?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- STATIC V2 -->
                <!-- END -->
            </div>
        </div>
        <!-- END: content -->
        
<script>
$(".sm_megamenu_wrapper_vertical_menu").hover(function(){
        $('.poup').toggleClass('hover-hide');
});
</script> 

        
        
<style>
.owl-item .item{ margin:0px;}
.price {  white-space: inherit !important;}
.price-box{ margin:0px;}
.block{ margin:0px;}
.block .actions{ padding:0px;}.button:hover { border:none;}
.block .block-title{   font-family: inherit;  color: inherit;  font-size: 12px;}
.ltabs-item.new-ltabs-item.respl-item{width:225px !important;}

.all-pages-leftmenu{display:none !important;
	visibility: hidden;
}

.hide-menus{display:none !important;
	visibility: hidden;
}

.only-header-menu{display:none !important;
	visibility: hidden;
}

.sambar ul li{display:block !important;
}

.sm_megamenu_wrapper_vertical_menu{border-top:1px solid #ddd;
}

.home-top-left .sm_megamenu_wrapper_vertical_menu .sm_megamenu_lv1 > a::before{color: #666;
    content: "";
    font-family: "FontAwesome";
    font-size: 6px;
    margin-right: 5px;
    position: relative;
    top: -2px;
}

.home-top-left .sm_megamenu_wrapper_vertical_menu li.sm_megamenu_drop > a::after{ color: #999;
    content: "";
    float: right;
    font-family: "FontAwesome";
    font-size: 12px;
}

.sm_megamenu_wrapper_vertical_menu{background:#fff;
}

/*.home-top-left .sm_megamenu_wrapper_vertical_menu li.sm_megamenu_drop > a::after{color:#fff;
}*/
	
.success_pop{
	background-color: #028002; color:#fff;
    top: 30px;
    position: relative;
    font-size: 18px !Important;
    text-align: center;
    padding-top: 10px !Important;
    line-height: 26px;
    padding-bottom: 10px !Important;
	}		
.reffer_text{     height: 20px !important;
    margin-bottom: 6px !important;}
</style>






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
			<img src="<?php echo base_url(); ?>images/new_images/KATE-GIVE-AWAWAY-ORIGINAL.jpg" width="100%"> 
			<div class="col-sm-7 form-group"  style="position:absolute; top: 37%;">
				<?php 
				echo form_open(); 
				?>
				<input type="text" name="news_email" placeholder="Enter Email Address" class="input-text" style="width: 100%; height: 40px;" value="<?php echo set_value('news_email'); ?>"> 
				<?php echo form_error('news_email'); ?>
				<center>
					<button type="submit" name="new_sub_btn" value="Submit" style="background-image:url('<?php echo base_url(); ?>images/new_images/sub_btn.jpg'); background-repeat:no-repeat;width: 180px;height: 50px; margin-top:10px;"></button>
				</center>
			</form>				
			</div>
		</div>
    </div>
</div>

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
                                                    <a href="<?php echo frontend_grid_category_url(904,'Unisex');?>" title="SNEAKERS">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/SNEAKERS.png" alt="SNEAKERS" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo frontend_grid_category_url(105,'Soccer');?>" title="football">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/football.jpg" alt="Get Fit" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo base_url();?>marketing/exclusives/product_list_grid/54340" title="Kids Store">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/back_toscl.jpg" alt="Kids Store" />
                                                    </a>
                                                </div>
												<div class="item">
                                                    <a href="<?php echo frontend_grid_category_url(80,'Men');?>" title="Men">  
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/mens_banner.jpg" alt="Perfume" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo product_url(10452,'Infinix Hot 2 X510 (2GB RAM, 16GB ROM) - Black');?>" title="Style En Vogue">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/infinix.jpg" alt="Style En Vogue" />
                                                    </a>
                                                </div>
                                                <div class="item">
                                                    <a href="<?php echo base_url();?>marketing/product/product_list_grid" title="acs">
                                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/summer_sale.jpg" alt="Tyres" />
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
                                                                        <a href="<?php echo base_url();?>marketing/exclusives/product_list_grid" title="SPOTLIGHT">
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
                                    <a href="<?php echo frontend_grid_category_url(187,'Cell Phones');?>" class="img-class banner1">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/PHONESDE.jpg" alt="PHONESDE" />
                                    </a>
                                </div>
                                <div class="img-effect img-banner2">
                                    <a href="<?php echo frontend_grid_category_url(431,'Small Appliances');?>" class="img-class banner2">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/JUICERSANDMIXERS.jpg" alt="JUICERSANDMIXERS" />
                                    </a>
                                </div>
                                <div class="img-effect img-banner3">
                                    <a href="<?php echo frontend_grid_category_url(435,'Shoes');?>" class="img-class banner3">
                                        <img src="<?php echo base_url(); ?>images/new_images/home/banner/LOAFERSFOPREN.jpg" alt="LOAFERSFOPREN" />
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
											Dish Drainer									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(2048,"22'' Two Layered Dish Drainer");?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend1.png" title="Grouped Product" alt="Grouped Product">
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
											All In One Printer										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(1116,'HP Deskjet 1512 Inkjet All-in-One Printer');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend2.png" title="Grouped Product" alt="HP Deskjet 1512 Inkjet All-in-One Printer">
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
											Mascara									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(6909,'Maybelline The Colossal Volume Express Smoky Eyes Mascara');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend3.png" title="Grouped Product" alt="Maybelline The Colossal Volume Express Smoky Eyes Mascara">
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
											Samsung	Led TV								</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(2758,'Samsung 32-inch UA32EH4003 LED TV');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend4.png" title="Grouped Product" alt="Samsung 32-inch UA32EH4003 LED TV">
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
                                                                <a href="grouped-product.html" title="Grouped Product">
											The Promise									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(5900,'The Promise');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend5.png" title="Grouped Product" alt="The Promise">
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
											Elepaq Generator									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(5287,'Elepaq Generator - SPG4800');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend6.png" title="Grouped Product" alt="Elepaq Generator - SPG4800">
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
											Baby Shoe										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(6481,'Poker Dot Baby Shoe - Black & White');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend7.png" title="Grouped Product" alt="Poker Dot Baby Shoe - Black & White">
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
											Playstation3 - Slim										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(5800,'PlayStation 3 - Slim');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend8.png" title="Grouped Product" alt="PlayStation 3 - Slim">
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
											Tomy Takkies								</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo frontend_grid_category_url(904,'Unisex');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend9.png" title="Grouped Product" alt="Unisex">
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
											Bobbi Brown										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(3453,'Bobbi Brown – Makeup Brushes In Faux Leather Pouch (24pcs kit)');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/recommend10.png" title="Grouped Product" alt="Bobbi Brown – Makeup Brushes In Faux Leather Pouch (24pcs kit)">
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
											16-Piece Dinner Set							</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                     <a href="<?php echo product_url(3925,'16-piece Dinner Set - Brown');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/dinner_set.jpg" title="Grouped Product" alt="16-piece Dinner Set - Brown">
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
											 Whisting Kettle							</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                  <a href="<?php echo product_url(2854,'Zoombo Stainless Steel Whistling Kettle ');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/kettle.jpg" title="Grouped Product" alt="Zoombo Stainless Steel Whistling Kettle ">
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
											Wardrobe With Wheels										</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                      <a href="<?php echo product_url(2896,'Mobile Wardrobe Closet With Wheels');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/wardrobe.jpg" title="Grouped Product" alt="Mobile Wardrobe Closet With Wheels">
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
											Office Shoe									</a>
                                                            </div>
                                                            <!-- Begin bs-item-inner -->
                                                            <div class="bs-item-inner">

                                                                <div class="bs-image">

                                                                    

                                                                    <a href="<?php echo product_url(5449,'Atmosphere Animal Skin Office Shoe');?>" title="Grouped Product">
                                                                        <img src="<?php echo base_url(); ?>images/new_images/home/recommended/leopard_shoes.jpg" title="Grouped Product" alt="Atmosphere Animal Skin Office Shoe">
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
                                                                            <a href="<?php echo frontend_grid_category_url(29,'Camera, Photo & Video');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/CAMERAS&CTV.jpg" alt="Camera, Photo & Video" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(29,'Camera, Photo & Video');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/1595"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(57,'Games');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/ganmes&console.jpg" alt="Games" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo frontend_grid_category_url(57,'Games');?>"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3135"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(66,'Home Theater & Audio');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/soundsystem.jpg" alt="Home Theater & Audio" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3630"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3630"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(111,'TV & Video');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/tvaccessories.jpg" alt="TV & Video" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/6105"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/6105"></a>
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
                                            <a href="<?php echo product_url(1230,'prname');?>" class="img-class ">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/iphone.jpg" alt="img" />
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
                                                                            <a href="<?php echo frontend_grid_category_url(304,'Jeans');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/CLASSYWAISTJEAN.jpg" alt="Jeans" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div><div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/16720"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/16720"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(230,'Dresses');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/FLORALWOMENSDES.jpg" alt="Dresses" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/12650"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/12650"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(940,'Shoes');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/LUNASSHOE.jpg" alt="Huma saren mazem kae" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/51700"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/51700"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(53,'Fragrance');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/REDDOORFRAGRANCE.jpg" alt="Huma saren mazem kae" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2915"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2915"></a>
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
                                            <a href="<?php echo frontend_grid_category_url(122,'Women');?>" class="img-class">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/PLUSSIZE.jpg" alt="img" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="img-effect img-content-home2">
                                            <a href="<?php echo frontend_grid_category_url(483,'Washers & Dryers');?>" class="img-class ">
                                                <img src="<?php echo base_url(); ?>images/new_images/home/WASHINGMACHINE.jpg" alt="img" />
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
                                                                            <a href="<?php echo frontend_grid_category_url(335,"Men's");?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/FCUKPERF.jpg" alt="" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/18425"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/18425"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(431,'Shoes');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/LACOSTEMENSSHOE.jpg" alt="Shoes" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23705"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23705"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(162,'Belts');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/MENSBELT.jpg" alt="Belts" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/8910"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/8910"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(167,'Blazers & Sports Coats');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/MENSBLAZERS.jpg" alt="Blazers & Sports Coats" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/9185"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/9185"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(81,'Dress Shirts');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/MENSSHIRT.jpg" alt="Dress Shirts" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/12595"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/12595"></a>
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
                                                                            <a href="<?php echo frontend_grid_category_url(41,'Diapering & Potty');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/BABYDIAPERS.jpg" alt="Diapering & Potty" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2255"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2255"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(2,'Baby');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/BABYESSENTIALS.jpg" alt="Baby" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/110"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/110"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(697,'School Bags');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/BACKTOSCHOOL.jpg" alt="School Bags" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/38335"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/38335"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(11,'Toys & Games');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/KIDSTOYS.jpg" alt="Toys & Games" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/605"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/605#"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(70,'Kids');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/KIDSWEAR.jpg" alt="Kids" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3850"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3850"></a>
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
                                            <strong><span>BOOKS, MOVIES AND GAMES</span></strong>
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
                                                                            <a href="<?php echo frontend_grid_category_url(81,'Motivational & Self-Help');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/BOOKS.jpg" alt="" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/4455"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/4455"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(51,'Fiction');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/BOOKTWILIGHTHOUIR.jpg" alt="Fiction" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2805"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/2805"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(83,'Movies');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/MOVIES.jpg" alt="Movies" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/4565"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/4565"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(57,'Games');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/VIDEOGAMES.jpg" alt="Games" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3135"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3135"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(83,'Movies');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/MOVIES2.jpg" alt="Movies" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="frontend/product/product_list_grid/4565"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="frontend/product/product_list_grid/4565"></a>
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
                                                                            <a href="<?php echo frontend_grid_category_url(435,'Small Appliances');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/blenders.jpg" alt="Small Appliances" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23925"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23925"></a>
																		
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(435,'Small Appliances');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/GASCOOKER.jpg" alt="Small Appliances" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23925"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/23925"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(398,'Refrigerators');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/HAIRTHERMOCOOOL.jpg" alt="Refrigerators" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/21890"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/21890"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(483,'Washers & Dryers');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/lgmachine.jpg" alt="Washers & Dryers" />
                                                                            </a>
                                                                        </div>
																		<div class="new-item">
                                                                        <span>New</span>
                                                                    </div>
                                                                    </div>
																	
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/26565"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/26565"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
														<div class="item item-supercat respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <span class="hover-background"></span>
                                                                        <div class="item-image">
                                                                            <a href="<?php echo frontend_grid_category_url(211,'Cookware');?>" class="product-image rspl-image">
                                                                                <img src="<?php echo base_url(); ?>images/new_images/home/product/pondhasstove.jpg" alt="Cookware" />
                                                                            </a>
                                                                        </div>
                                                                    </div>
																	<a class="product-image" style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/11605"> </a>
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/11605"></a>
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
                                                                        <a class="item-image" href="<?php echo frontend_grid_category_url(29,'Camera, Photo & Video');?>">
																				<img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/product/CAMERAS&CTV.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/1595"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo frontend_grid_category_url(57,'Games');?>">
                                                                            <img title="" alt="Huma saren mazem kae" src="<?php echo base_url(); ?>images/new_images/home/product/ganmes&console.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3135"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo frontend_grid_category_url(66,'Home Theater & Audio');?>">
                                                                            <img title="" alt="Jema rumi miren kito" src="<?php echo base_url(); ?>images/new_images/home/product/soundsystem.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/3630"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo frontend_grid_category_url(111,'TV & Video');?>">
                                                                            <img title="" alt="Pisan maze ikan kazen" src="<?php echo base_url(); ?>images/new_images/home/product/tvaccessories.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="<?php echo base_url(); ?>frontend/product/product_list_grid/6105"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(2970,'Lenovo A10 Mini Touch (2GB,16GB HDD) 10.1-Inch Android Netbook - Black');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/lenevo.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4002,'Dell Inspiron 15 3543 Intel Pentium Dual Core (4GB,500GB HDD) 15.6-Inch');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/dell.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7427,'Acer Mini Aspire Laptop 2GB 250GB Windows 8.1');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/acer.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7395,'HP Pavilion 15 i3 Laptop Windows 8');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/hp.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(5561,'White Mini Top Gown');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/whites_gwn.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(2340,'Vegan Padlock Handbag - Green');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/bags.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8409,'Delicious Nude Sanadal');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/shoes.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(5620,'Aisha Ancy Woman Blazer');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/aish_blazers.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(6104,"Men's Tuxedo Suit with Black Satin Shawl Lapel - Red & Black");?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/men_suit.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(394,'Michael Kors MK8086 Rose Gold-tone Chronograph Watch');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/watch.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(5055,'J.B Lace-up Shoes with Knitted Ankle Detail -Brown');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/lacd_shoes.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8730,'Light Army Green Short Sleeve Senator');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/senator_shirts.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(6322,'prname');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/infinix.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(1251,'prname');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/blacberry_z.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo base_url(); ?>frontend/single/product_detail/83875">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/apple_iphone6.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo base_url(); ?>frontend/single/product_detail/345180">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/samsung.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(5057,'Ebony Professional Hair Steamer');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/ebony_ahir.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(1931,'Funmi Curls 14 inches');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/funmi_curls.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7689,'Profectiv Mega Growth Relaxer - 7 Salon Pack Touch-ups');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/hair_relaxer.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(341,'Supper Tapper Professional Electric Hair Clipper');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/clipper.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(5035,'SMA First Infant Milk');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/sma_mlik.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(5453,'Pampers Diapers Size 5 - 22ct.');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/pampers.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7636,'Kids Dinning Set With Four Chairs');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/kids_dining.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(6666,'Happy Winners Baby Sitter - 4 - 15 Months');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/baby_sitter.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(7259,'HP Deskjet 1513 - Multifunction Color Photo Printer with Scanner and Copier');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/printa.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7469,'Kangaroo Staple Machine');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/staple_machine.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(6579,'KW-Trio Heavy Duty 2hole Punch');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/hole.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8731,'HP 80A Black Original LaserJet Toner Cartridge');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/toner.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(6283,'Solar Panels 12v/130watts');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/solar.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4877,'Sumec Firman Generator - SPG1800');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/sumec_fireman.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(4864,'Tri-Ace Carrera 225/45 R17');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/tires.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(721,'Abro Radiator Coolant Fluid');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/coolant.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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
                                                                        <a class="item-image" href="<?php echo product_url(1852,'Tower Gold Premium Cooker 3sets.');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/pots.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(7674,'Haier Thermocool Crown Damsel Gas Cooker - (TSCE 504G)');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/gas_cooker.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(6922,'LG Top - Mount Refrigerator - GR - B252VPL');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/lg_fridge.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
                                                                        <!-- QUICLVIEW -->
                                                                    </div>

                                                                    <div class="other-infor">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ltabs-item new-ltabs-item respl-item">
                                                                <div class="item-inner">
                                                                    <div class="w-image-box">
                                                                        <a class="item-image" href="<?php echo product_url(8520,'Eurosonic 4.1 Litre Electric Stainless Kettle');?>">
                                                                            <img title="" alt="Girem masen poka na" src="<?php echo base_url(); ?>images/new_images/home/topselling/electric_kettle.jpg" />
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="add-to-links">
                                                                        <a style="display:none;" href="girem-masen-poka.html"></a>
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






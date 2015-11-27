<link href="<?php echo base_url(); ?>js/frontend/lightbox/glasscase.minf195.css?v=2.1" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>css/frontend/style_drop.css" rel="stylesheet"/>
<link href="http://fonts.googleapis.com/css?family=Ubuntu|Roboto|Roboto+Slab" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/frontend/lightslider.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>css/frontend/zoom.css" rel="stylesheet"/>

<section class="main-container col1-layout">
	<div class="main container shadow-main-div">
    	<div class="col-main"> 
      		<!--breadcrumb-->
	      <div class="breadcrumbDiv">
        <ul class="breadcrumb">
          <li> <a href="<?php echo base_url(); ?>">Home</a> </li>
          <li class="active">Rating & Review List</li>
        </ul>
      </div>
      <!--breadcrumb-->
      <div class="row">
        <div class="product-view">
          

<div class="clearfix"></div>
<div class="col-sm-12">
	<div class="new_title center" style="margin:0px !important;">
		<h2>Reviews of <?php echo $result['productName']; ?></h2>
	</div>
	<div class="col-sm-2 rating_avg_sec">
		<span class="fa fa-star star_big"></span>
		<span class="count"><?php echo round($result['avgRating'],1,PHP_ROUND_HALF_UP); ?></span>
		<p class="subText">Average Rating</p>
		<p class="subText">Based on <?php echo $result['totalRating']; ?>&nbsp;ratings</p>
	</div>
	<div class="col-sm-6 rating_stars_bar">
		<ul class="ratingsDistribution">
			<li>
				<a href="<?php echo product_rating_review_url($productId,$result['productName'],5); ?>" title="Read 5 star reviews">
					<span>5 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $result['productRating5']+2.041; ?>%"><?php echo $result['productRating5']; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$result['productName'],4); ?>" title="Read 4 star reviews">
					<span>4 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $result['productRating4']+2.041; ?>%"><?php echo $result['productRating4']; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$result['productName'],3); ?>" title="Read 3 star reviews">
					<span>3 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $result['productRating3']+2.041; ?>%"><?php echo $result['productRating3']; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$result['productName'],2); ?>" title="Read 2 star reviews">
					<span>2 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo $result['productRating2']+2.041; ?>%"><?php echo $result['productRating2']; ?></div>
					</div>
				</a>
			</li>
			<li>
				<a href="<?php echo product_rating_review_url($productId,$result['productName'],1); ?>" title="Read 1 star reviews">
					<span>1 star</span>
					<div class="bar">
						<div class="progress" style="width:<?php echo ($result['productRating1']+2.041); ?>%"><?php echo $result['productRating1']; ?></div>
					</div>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-sm-3 write_review_sec">
		<p>Have you used this product?</p>
		<?php
		if($this->session->userdata('userId'))
		{
		?>
		<a href="<?php echo product_write_review_url($productId,$result['productName']); ?>">
			<button class="btn btn_write" title="write a review" type="button">
				<span>write a review</span>
			</button>
		</a>
		<?php
		}
		else
		{
		?>
		
		<a data-toggle="modal" data-target="#modal-login" title="Write A Review" style="cursor:pointer;">
			<button class="btn btn_write" title="write a review" type="button">
				<span>write a review</span>
			</button>
		</a>
		<?php
		}
		?>
	</div>	
</div>
<div class="clearfix"></div>
<div class="col-sm-12">
	<?php
	if(!empty($ratingReviewList))
	{	
		foreach($ratingReviewList as $row)
		{
	?>
			<div class="main_reviewnrating_sec">
				<div class="col-sm-2 padding_left_zero rating_description">
					<div class="rating_icon">
						<?php
						$total = 0;
						if($row->productRating1)
						{
							$total = 1;
						}
						elseif($row->productRating2)
						{				
							$total = 2;		
						}
						elseif($row->productRating3)
						{
							$total = 3;
						}
						elseif($row->productRating4)
						{
							$total = 4;
						}
						elseif($row->productRating5)
						{
							$total = 5;
						}
						
						for($i=1;$i<=5;$i++)
						{
							if($i<=$total)
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
					<span><?php echo ucwords($row->firstName.' '.$row->lastName); ?></span><br />
					<span class="rating_date">
						<?php echo $row->lastModifiedDt; ?>
					</span>
					<?php
					if($row->orderId==0)
					{
					?>
					<img src="<?php echo base_url(); ?>images/frontend/first_to_review.png" class="img-responsive certified_img" />
					<?php
					}
					if((!empty($row->ordersId))||(!empty($row->orderId)))
					{
					?>
					<img src="<?php echo base_url(); ?>images/frontend/certified_buyer.png" class="img-responsive certified_img" />
					<?php
					}					
					?>
				</div>
				<div class="col-sm-10 review_description">
					<p class="review_title">
						<strong>
							<?php echo $row->reviewTitle; ?>
						</strong>
					</p>
					<p>
						<?php echo nl2br($row->reviewDescription); ?>
					</p>	
				</div>
			</div>	
			<div class="clearfix"></div>
	<?php
		}
	}
	else
	{
		echo 'Data not found';
	}
	?>
</div>	    
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<style>
    .gc-overlay-area {
        display: none !important;
    }
.rating_icon{  margin-top: 2px; }
.rating_icon .active{ color:#e9ce18; }
.rating_icon .inactive{ color:#d3d3d3; }
.count{ font-size:12px;}
.total_review a{ text-transform:uppercase;  margin-left: 10px;  font-family: latoregular!important;font-size:12px;}
.write_review{   padding-top: 4px; }
.write_review_sec{ padding:20px 20px;}
.btn_write{   background-color: #F3863D;   width: 180px; padding-top: 15px;  border: none;  padding-bottom: 15px;  color: #fff!important;  margin-bottom: 20px;  border-radius: 5px;  font-size: 16px;    text-transform: uppercase;  font-weight: 400; }
.btn_write:hover{ background-color: #F5A168;}
.rating_avg_sec{ padding:20px 20px;}
.rating_avg_sec .star_big{   font-size: 7em; color: #e9ce18; }
.rating_avg_sec .count{     font-size: 18px;  position: absolute;      top: 53px;  left: 53px; color: #fff; }
.rating_avg_sec .subText{   margin-bottom: 0px;   color: #888;  font-size: 12px;  line-height: 18px;}
.rating_stars_bar{   margin: 20px 20px;  border-right: 1px dashed #ccc;}
.rating_stars_bar .ratingsDistribution {
  list-style-type: none;
  padding-left: 10px;
}
.rating_stars_bar .ratingsDistribution li {
  font-size: 11px;
  margin-top: 3px;
  margin-bottom: 5px;
  color: #666;
}
.rating_stars_bar .ratingsDistribution li .bar {
  background-color: #f2f2f2;
  width: 80%;
  display: inline-block;
  height: 12px;
  vertical-align: bottom;
  position: relative;
}
.rating_stars_bar .ratingsDistribution li .bar .progress {
  line-height: 11px;
  height: 11px;
  font-size: 9px;
  border-radius: 0px;
  box-shadow: none;
  background-color: #eed44b;
  border: 1px solid #eed44b;
}

.main_reviewnrating_sec{ padding-bottom:20px;}
.rating_description{ padding:20px 0 20px 0; }
.rating_description .rating_date{ font-size:12px; color:#999; }
.rating_description .certified_img{ padding-top:10px; }
.review_description{ padding:20px 0 20px 0;}
.review_description .review_title{   font-family: museo700;}
.prev{
	 position: absolute;
  left: 0;
  top: 0 !important;
  background-color: #484848 !important;
  color: #fff;
  border-radius: 1px !important;
  font-size: 21px !important;
  padding: 1px 12px !important;
  left: -16px;cursor:pointer;
}
.prev:hover{ color:#fff !important;}
.next:hover{ color:#fff !important;}
.next{
	  position: absolute;
  right: 0;
  top: 0 !important;
  background-color: #484848 !important;
  color: #fff;
  border-radius: 1px !important;
  font-size: 21px !important;
  padding: 1px 12px !important;
  right: 14px;cursor:pointer;
}
.btn.disabled{
   display:none !important;
}
.cs_head{ font-family: museo300;font-size: 16px; }
.color_box { padding:15px; margin-right:5px;  border: 2px #eee solid;}
.color_box:hover { border:2px solid #ffd926;}
.size_box {margin-right:5px;  border: 2px #eee solid; }
.size_box:hover { border:2px solid #ffd926;}
.fadde_color{ opacity: 0.3;}
.active_color {  border:2px solid #ffd926; }
.btn-pickup{background: #EB5467; border:1px solid #EB5467; color:#fff;  padding: 4px 10px 4px 10px; font-size: 12px;}
.btn-pickup:hover{background: #EB5467; border:1px solid #EB5467; color:#fff;  padding: 4px 10px 4px 10px;  font-size: 12px;}
.tab-pane table tr td { text-align:left;}
.tab-content .one>.active { display:inline-flex;}
.tab-content .two>.active { display:block;}
.pickup_box{   background: #fff; height:210px;
  border-right: 1px solid #eee;
  /*border-bottom: 1px solid #eee;*/
padding: 5px; 
  }
.pickup_box:hover { border-bottom: 2px solid #7bc470; }  
.pickup_box h5{ margin-top:2px; margin-bottom:2px;font-family: museo700; text-transform:uppercase;} 
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus { border-bottom:1px solid #eee !important;}
.wonens-slider .owl-prev > disabled{ display:none}
.wonens-slider .owl-next > disabled{ display:none}
.customNavigation {   position: absolute;
   top: 65%;
  z-index: 1000;  width: 100%; }
  .wonens-slider .item img{width:100px !important;
	margin:0 auto 6px auto;
}

.wonens-slider .owl-item{margin:0 !important;
}

.wonens-slider .item{margin:0 !important;
	text-align:center;
	padding-bottom:0px;
}

.wonens-slider .item .product_names{font-family: 'latosemibold';
	text-transform:uppercase;
	color:#444444;
	margin-bottom:0;
}

.wonens-slider .owl-item a{cursor:pointer;
	text-decoration:none;
	display:block;
	border-right:1px solid #f1f1f1;
	transition:all ease-out 0.2s;
	border-bottom:2px solid #fff;
}

.wonens-slider .owl-item:first-child a{border-left:1px solid #ececec !important;
}

.wonens-slider .owl-item a:hover{border-bottom:2px solid #7bc470;
}

.wonens-slider .owl-controls{position:absolute;
	width:100%;
	top:38px;
}

.wonens-slider .owl-next{position: absolute;
    right: 0;
    top: 0 !important;
	background-color:#484848 !important;
	color:#fff;
	border-radius:1px !important;
	font-size: 21px !important;
    padding: 1px 12px !important;
	right: -21px;
}

.wonens-slider .owl-prev{position: absolute;
    left: 0;
    top: 0 !important;background-color:#484848 !important;
	color:#fff;
	border-radius:1px !important;
	font-size: 21px !important;
    padding: 1px 12px !important;
	left: -21px;
}
.owl-wrapper-outer {  border-top: 1px solid #eee !important;}
.owl-item {/* width:240px !important;*/}
.payment_mode_sec .head{   font-family: museo300 !important;}
.price_section .price_sec_1 { border-right:none !Important;}
.price_section .price_sec_2{ 	border-left: 1px solid #ccc;}
.new_title.center{ margin-right:0px !important;}

.singletab-div li{margin-bottom:14px;
}

.singletab-div li a{background-color:#fff;
	color:#666666;
	font-size:14px;
	border-radius:6px;
	-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
}

.singletab-div li.active a, .singletab-div li:hover a, .singletab-div li:focus a{background-color:#a3ce62;
	color:#fff;	
	-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
	border-bottom:0 !important;
	font:14px;
}

.singletab-div{border-bottom:0 !important;
}

.avlble-tab{-webkit-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
-moz-box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
box-shadow: 0px 0px 5px 0px rgba(196,196,196,0.6);
	border-radius:6px;
	
}

.check_aval{background: #efefef; /* Old browsers */
background: -moz-linear-gradient(top, #efefef 0%, #fdfdfd 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#efefef), color-stop(100%,#fdfdfd)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, #efefef 0%,#fdfdfd 100%); /* IE10+ */
background: linear-gradient(to bottom, #efefef 0%,#fdfdfd 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#efefef', endColorstr='#fdfdfd',GradientType=0 ); /* IE6-9 */
border:1px solid #c8c8c8;
border-radius:6px;
padding-bottom:20px;
}

.singletab-div li:first-child{padding-right:10px;
}

.singletab-div li:last-child{padding-left:10px;
}

.singletab-div>li.active>a, .singletab-div>li.active>a:hover, .singletab-div>li.active>a:focus {background-color:#a3ce62;
	color:#fff;
	border-radius:6px;
	border-bottom:0 !important;}

.singletab-div>li.active>a::brfore, .singletab-div>li.active>a:hover::brfore, .singletab-div>li.active>a:focus::brfore{content: "";
    border-color: transparent #111; 
    border-style: solid;
    border-top:15px solid #a3ce62;
    border-left:14px solid transparent;
    border-right:14px solid transparent;
    display: block;
    height: 0;
    width: 0;
    left: 0;
	right:0;
    bottom: -16px;
    position: absolute;
	margin:0 auto;
}

.singletab-div>li.active>a:after, .singletab-div>li.active>a:hover:after, .singletab-div>li.active>a:focus:after{content: "";
    border-color: transparent #111; 
    border-style: solid;
    border-top:15px solid #a3ce62;
    border-left:14px solid transparent;
    border-right:14px solid transparent;
    display: block;
    height: 0;
    width: 0;
    left: 0;
	right:0;
    bottom: -16px;
    position: absolute;
	margin:0 auto;
}
.check_aval .dropdown-menu{box-shadow:1px 1px 6px rgba(0,0,0,.2);/*max-height:250px!important*/}
.selectpicker{   max-height: 224px !important;min-height: 20px !important;

   }
.pri-percent{display: inline-block;
  margin: 0 0 0 10px;
  border: 1px solid #c9c9c9;
  width: 45px;
  height: 43px;
  border-radius: 50%;
  text-align: center;
  padding: 8px;
  font-size: 12px;
  line-height: 12px;  color: #6fba54;}
.btn_buynow_sec{ background-color:#F3863D !important;  font-size: 16px !important;} 
.btn_buynow_sec:hover{ background-color:#F5A168 !important;}
.free-shipping-label {
  border: 1px dashed #999;
  border-radius: 3px;
  font-size: 10px;
  padding: 1px 7px;
  color: #F38C46;
  font-weight: 600;
  display: inline-block;
  position: relative;
  top: 2px;
  height: 19px;
  box-sizing: border-box;
  font-family: latomedium!important;
  margin-bottom: 15px;
}
.price_section .price_sec_1 .special-price {
  margin-bottom: 0px;
}
.btn-savchange{ color:#fff; text-transform:uppercase;}
.btn-savchange:hover{ color:#fff;}
.review_data{ border:1px solid #eaeaea; padding:5px;}
section {
    padding-top: 3px;
}
.yt-breadcrumbs {
  margin-top: 0px;
}
.header-v0 .ver-megamenu-header .sm_megamenu_wrapper_vertical_menu{ display:none !important;}


</style>
<link type="text/css" href="<?php echo  base_url(); ?>css/frontend/review.css" media="all" />


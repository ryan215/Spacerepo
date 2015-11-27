<link href="<?php echo base_url();?>css/frontend/retailer_review.css" rel="stylesheet">
<style>
.fa-star {
    color: #feb614 !important;
}
</style>
<section class="main-container col1-layout">
  <div class="main container">
  <div class="col-main">	

	<div class="breadcrumbDiv col-lg-12">
				<ul class="breadcrumb">
					<li> <a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="active"> Retailer Rating & Reviews</li>
				</ul>
			</div>	

	<!--Product page Left start-->
    <div class="col-lg-9 col-sm-9 col-md-9 main-left-div">
		<div class="col-sm-12 no-padding retailer-nametop">
			<?php
			//echo "<pre>"; print_r($retailer_detail); exit;
			if(!empty($retailer_detail->bussiness_name))
			{
				echo '<h2>'.$retailer_detail->bussiness_name.'</h2>';
			}
			if(!empty($retailer_detail->comment))
			{
				echo '<p>'.$retailer_detail->comment.'</p>';
			}
			?>
			<!--<p class="product-issues">
				<i class="fa fa-arrow-right"></i>7 Day Replacement Guarantee
			</p>-->
		</div>
		
		<!--start review and rating div-->
		<div class="col-sm-12 Reviews-div">
			<div class="new_title center" style="margin-right:0px !important;">
									<h2>REVIEWS &amp; RATINGS</h2>
								</div>
			<div class="col-lg-12 Reviews-star">
				<div class="inner">
					<div class="col-sm-3 rate-div">
						<div class="star-crcle">
							<i class="icon-large icon-star">
								<span class="rating-point">
									<?php
									if(!empty($retailer_rating_count->avg_rating))
									{
										echo sprintf("%0.2f",$retailer_rating_count->avg_rating);
									}
									else
									{
										echo '0';
									}
									?>
								</span>
							</i>
						</div>
						<h3>
							Based on 
							<?php 
							if(!empty($retailer_rating_count->total_rating))
							{
								echo $retailer_rating_count->total_rating;
							}
							else
							{
								echo '0';
							}
							
							$rating_5 = 0;
							$rating_4 = 0;
							$rating_3 = 0;
							$rating_2 = 0;
							$rating_1 = 0;
							if(!empty($retailer_rating_count))
							{
								$rating_5 = $retailer_rating_count->ratailer_rating_5;
								$rating_4 = $retailer_rating_count->ratailer_rating_4;
								$rating_3 = $retailer_rating_count->ratailer_rating_3;
								$rating_2 = $retailer_rating_count->ratailer_rating_2;
								$rating_1 = $retailer_rating_count->ratailer_rating_1;
							}
							?> 
							ratings 
						</h3>
					</div>
					
					<div class="histo col-sm-6">
						<div class="five histo-rate">
							<span class="histo-star">
								<i class=" icon-large icon-star"></i> 5           
							</span>
							<span class="bar-block">
								<span id="bar-five" style="width:<?php echo $rating_5+10; ?>px;" class="bar">
									<span><?php echo $rating_5; ?></span>&nbsp;							  
								</span>							
							</span>						  
						</div>
					  
						<div class="four histo-rate">
							<span class="histo-star">
								<i class="icon-large icon-star"></i> 4           
							</span>
							<span class="bar-block">
								<span id="bar-four" style="width:<?php echo $rating_4+10; ?>px;" class="bar">
									<span><?php echo $rating_4; ?></span>&nbsp;								  
								</span>							
							</span>						  
						</div> 
					  
						<div class="three histo-rate">
							<span class="histo-star">
								<i class="icon-large icon-star"></i> 3           
							</span>
							<span class="bar-block">
								<span id="bar-three" class="bar" style="width:<?php echo $rating_3+10; ?>px;">
									<span><?php echo $rating_3; ?></span>&nbsp;									  
								</span>							
							</span>	
						</div>
					  
						<div class="two histo-rate">
							<span class="histo-star">
								<i class="icon-large icon-star"></i> 2           
							</span>
							<span class="bar-block">
								<span id="bar-two" class="bar" style="width:<?php echo $rating_2+10; ?>px;">
									<span><?php echo $rating_2; ?></span>&nbsp;		 
								</span>							
							</span>						  
						</div>
					  
						<div class="one histo-rate">
							<span class="histo-star">
								<i class=" icon-large icon-star"></i> 1           
							</span>
							<span class="bar-block">
								<span id="bar-one" class="bar" style="width:<?php echo $rating_1+10; ?>px;">
									<span><?php echo $rating_1; ?></span>&nbsp;									  
								</span>							
							</span>						  
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12 show-reviews" id="ajaxData">
			
		</div>
		<!--end of review and rating div-->
	</div>
	<!--Product page Left end-->
<div class="col-sm-3 padding_zero">			  
              	<div class="product-img-box col-sm-12 col-xs-12">
                <div class="product-additional">
                  
				  <div class="block block-product-additional">
                    <div class="block-title"><strong><span>Reviews</span></strong></div>
                    <div class="block-content">  
        	<?php 
			if(!empty($user_id))
			{
			?>
				<a href="<?php echo base_url().'frontend/seller/seller_rating/'.id_encrypt($seller_id); ?>" class="button btn-cart" style="background:#EB5467;text-decoration:none;  font-size:12px;">
					REVIEW
				</a>
			<?php			
			}
			else
			{
			?>
			<a href="<?php echo base_url().'frontend/seller/seller_rating/'.id_encrypt($seller_id); ?>" class="button btn-cart" style="background:#EB5467;text-decoration:none;  font-size:12px;">
					REVIEW
				</a>
            <?php 
			}
			?>
		</div>

</div> 
</div></div></div></div></div>
    	
<script type="text/javascript">
function ajaxPage(urlLink)
{	
	ajax_function(urlLink,'#ajaxData');
}
ajaxPage('<?php echo base_url().'frontend/seller/seller_review_ajax/'.$seller_id.'/'.$total.'/'; ?>');

function already_add()
{
	alert_box_msg('You already added review and rating');
}
</script>


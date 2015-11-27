<link href="<?php echo base_url();?>css/frontend/retailer_review.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/rating/rating.css" rel="stylesheet">

<!--start main contant-->
<section class="main-container col1-layout">
  <div class="main container">
  <div class="col-main">	
<div class="breadcrumbDiv col-lg-12">
      <ul class="breadcrumb">
        <li> <a href="<?php echo base_url(); ?>">Home</a> </li>
        <li>Review</li>
       
      </ul>
    </div>	
	
		
    <!--Product page Left start-->
    <div class="col-lg-12 col-sm-12 col-md-12 review-main-div">
	<div class="new_title center" style="margin-right:0px !important;">
									<h2>Rate And Review For Retailer</h2>
								</div>
	
		<!--start review and rating div-->
		<div class="col-sm-12 Reviews-div">
			<div class="col-sm-12 no-padding">
            	<div class="col-lg-2 col-md-2 bou-item">
                	<h3>Item Bought</h3>
					<?php  $rating_id = 0; ?>
				</div>
<?php 
echo form_open();
?>                                                                                                           <div class="col-lg-10 col-md-10 right-rate-div">
                	<h3>Rate seller</h3>
					<input type="hidden" name="rating" id="ratingID"  value="<?php echo $rating_id; ?>" />
					<div class="tuto-cnt">
						<div class="rate-ex3-cnt">
							<div id="1" class="rate-btn-1 rate-btn"></div>
							<div id="2" class="rate-btn-2 rate-btn"></div>
							<div id="3" class="rate-btn-3 rate-btn"></div>
							<div id="4" class="rate-btn-4 rate-btn"></div>
							<div id="5" class="rate-btn-5 rate-btn"></div>
						</div>
					</div>
					
                    <P>Feedback about seller</P>
                    <div class="col-sm-12 no-padding">
                    	<div class="add-comment">
                        	Add Comments
                        </div>
                        <textarea rows="5" class="form-control comment-area" name="comment" id="comment" onkeyup="return limiter(this.value);"></textarea>
						<?php echo form_error('comment'); ?>
                        <div style="padding-top:10px; font-size:13px;">
							You have <span id="count">2000</span> Characters left
						</div>
					</div>
                    
					<div class="cmntbtn-div col-sm-12">
                    	<button class="button view-all"> Submit Feedback</button>
                    </div>
				</div>
				</form>
			</div>
		</div>
		<!--end of review and rating div-->
	</div>
	<!--Product page Left end-->
	<!--Product right open-->
	<div class="col-lg-2 col-sm-3 col-md-2 product-right-div">
	</div>	
	<!--Product right close-->
</div> 	

<script>
// rating script
$(function(){ 
	/*$('.rate-btn').hover(function(){
    	$('.rate-btn').removeClass('rate-btn-hover');
        var therate = $(this).attr('id');
		$('#ratingID').val(therate);
        for (var i = therate; i >= 0; i--) {
        	$('.rate-btn-'+i).addClass('rate-btn-hover');
        };
    });*/
                            
    $('.rate-btn').click(function(){    
    	var therate = $(this).attr('id');
		$('#ratingID').val(therate);
        $('.rate-btn').removeClass('rate-btn-active');
        	for (var i = therate; i >= 0; i--) {
            	$('.rate-btn-'+i).addClass('rate-btn-active');
			};
		});
	});

function limiter(tex)
{
	var len = $('#comment').val().length;
	if(len >= 2000){
		tex = tex.substring(0,2000);
		$('#comment').val(tex);
		return false;
	}
	$('#count').text(2000-len);
}
</script>
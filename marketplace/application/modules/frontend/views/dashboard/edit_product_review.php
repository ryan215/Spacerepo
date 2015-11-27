<link href="<?php echo base_url();?>css/retailer_review.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/rating/rating.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/new_css/category.css" rel="stylesheet">
<style>
.fa-star {
    color: #feb614 !important;
}
</style>

<div class="col-lg-10 col-sm-12 col-md-12 review-main-div">
	<div class="col-sm-12 no-padding retailer-nametop">
		<h2>Rate Product</h2>
	</div>

	<!--start review and rating div-->
	<div class="col-sm-12 Reviews-div">
		<div class="col-sm-12 no-padding">
        	<?php 
echo form_open();
?>                                                                                           
			<div class="col-lg-10 col-md-10 right-rate-div">
            	<span>Rate this product on a scale of 1-5</span><br>
                <input type="hidden" name="rating" id="ratingID"  value="<?php echo $rating; ?>" />
					<div class="tuto-cnt">
						<div class="rate-ex3-cnt">
							<div id="1" class="rate-btn-1 rate-btn"></div>
							<div id="2" class="rate-btn-2 rate-btn"></div>
							<div id="3" class="rate-btn-3 rate-btn"></div>
							<div id="4" class="rate-btn-4 rate-btn"></div>
							<div id="5" class="rate-btn-5 rate-btn"></div>
						</div>
					</div>
					
					<div class="col-sm-12 review-title">
                    	<p>Review Title</p>
                        <input type="text" name="review" class="form-control" value="<?php echo $rating_review; ?>">
						<?php echo form_error('review'); ?>
					</div>
                    
					<P>Feedback about Product</P>
                    <div class="col-sm-12 no-padding">
                    	<div class="add-comment">
                        	Add Comments
                        </div>
						<textarea rows="5" class="form-control comment-area" name="comment" id="comment" onkeyup="return limiter(this.value);"><?php echo $comment; ?></textarea>
						<?php echo form_error('comment'); ?>
                        <div style="padding-top:10px; font-size:13px;">
							You have 
							<span id="count">
								<?php
								$total  = strlen($comment);
								$totalC = 2000-$total;
								echo $totalC;
								?>
							</span> 
							Characters left
						</div>
					</div>
                    
					<div class="col-sm-12 review-title">
                    	<p>Display Name</p>
                        <input type="text" class="form-control" name="display_name" value="<?php echo $display_name; ?>">
						<?php echo form_error('display_name'); ?>
					</div>
					
					<div class="cmntbtn-div col-sm-12">
                    	<button class="btn buy-btn btn-info buy-btn-seller btn-success"> Submit</button>
                    </div>
				</div>
				</form>
			</div>
		</div>
		<!--end of review and rating div-->
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

<?php
if($rating)
{
?>
$(function(){                             
	var therate = '<?php echo $rating; ?>';
	$('#ratingID').val(therate);
    $('.rate-btn').removeClass('rate-btn-active');
    for (var i = therate; i >= 0; i--) {
    	$('.rate-btn-'+i).addClass('rate-btn-active');
	};
});
<?php
}
?>

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
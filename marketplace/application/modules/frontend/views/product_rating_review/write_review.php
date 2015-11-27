<script src="<?php echo base_url(); ?>js/frontend/jquery.nicescroll.min.js" type="text/javascript"></script>

<section class="main-container col2-left-layout">
	<div class="container main-contant-wrapper shadow-main-div">
  		<div class="row">
			<div class="yt-breadcrumbs">
        		<div class="container">
        			<div class="row">
        				<div class="breadcrumbs col-md-12">
    			<ul><li class="home" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a itemprop="url" href="<?php echo base_url(); ?>" title="Go to Home Page"><span itemprop="title">Home</span></a></li><li class="category4" itemscope="" itemtype=""><strong>Write A Review</strong></li></ul>
					</div>
        			</div>
        		</div>
        	</div>
				
			<div class="col-main col-sm-9 col-sm-push-3">
				<article class="col-main col-sm-12">
						<div class="page-title"><h2>Write A Review</h2></div>
					  	<div class="account-login personal-infodiv">
              <div class="col2-set">
                <div class="col-sm-12 new-users" style="  max-width: 100% !important;">
                  <?php 
echo form_open();
?>                                                                                           
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-3">
                        <label for="rating">Your Ranting<span class="error">*</span> :</label>
                      </div>
                      <div class="col-sm-9 padding-bottom">
							<input type="hidden" class="rating" name="rating" id="ratingID"  value="<?php echo $result['rating']; ?>" />
							<?php echo form_error('rating'); ?>  
                      </div>
                    </div>
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-3">
                        <label for="review_title">Review Title<span class="error">*</span> :</label>
                      </div>
                      <div class="col-sm-9 padding-bottom">
                        <input type="text" class="form-control account-input" value="<?php echo $result['reviewTitle']; ?>" name="reviewTitle">
						<?php echo form_error('reviewTitle'); ?>
                         </div>
                    </div>
                    <div class="form-group form-grp-custom">
                      <div class="col-sm-3">
                        <label for="review_description">Your Review<span class="error">*</span> :</label>
                      </div>
<div class="col-sm-9 padding-bottom">
	<textarea name="reviewDescription" class="form-control account-input" rows="2" cols="100" style="width:100%; min-height:70px; border-radius:0px;" id="comment" onkeyup="return limiter(this.value);"><?php echo $result['reviewDescription']; ?></textarea>
	<?php echo form_error('reviewDescription'); ?>
	<div style="padding-top:10px; font-size:13px;">
		You have 
		<span id="count">
			<?php
			$total  = strlen($result['reviewDescription']);
			$totalC = 2000-$total;
			echo $totalC;
			?>
		</span> 
		Characters left
	</div>
</div>

                    </div>
					
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                      <button type="submit" class="btn  btn-savchange"> Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
                     
					 
				</article>
			</div>
<div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
	<aside class="col-left sidebar">
		<p>You have chosen to review</p>
			<div class="col-sm-4 padding_left_zero">
				<?php
				$imageUrl = base_url().'img/no_image.jpg';
				if((!empty($result['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$result['imageName'])))
				{
					$imageUrl = base_url().'uploads/product/thumb500_500/'.$result['imageName'];
				}
				elseif((!empty($result['imageName']))&&(file_exists('uploads/product/'.$result['imageName'])))
				{
					$imageUrl = base_url().'uploads/product/'.$result['imageName'];
				}
				?>
				<img src="<?php echo $imageUrl ;?>" class="img-responsive" />
			</div>
			<div class="col-sm-8 padding_left_zero">
				<a href="<?php echo base_url().'frontend/single/product_detail/'.id_encrypt($productId); ?>">
					<?php echo $result['productName']; ?>
				</a>
			</div>
			<div class="clearfix"></div>
						<div class="col-sm-12 review_data">
							 <h5>What makes a good review</h5>
							 <strong>Have you used this product?</strong>
							 <p>It's always better to review a product you have personally experienced.</p>	
							 <strong>Educate your readers</strong>
							 <p>Provide a relevant, unbiased overview of the product. Readers are interested in the pros and the cons of the product.</p>
							 <strong>Be yourself, be informative</strong>
							 <p>Let your personality shine through, but it's equally important to provide facts to back up your opinion.</p>
							 <strong>Get your facts right!</strong>
							 <p>Nothing is worse than inaccurate information. If you're not really sure, research always helps.</p>		
						</div>
					
				</aside>
				</div>
    	</div>
	</div>
</section>
<script type="text/javascript">
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

<style>
.btn-savchange{ color:#fff; background:#666;	 text-transform:uppercase;}
.btn-savchange:hover{ color:#fff; background-color:#fe5621
}
.review_data{ border:1px solid #eaeaea; padding:5px;}
section {
    padding-top: 3px;
}
.yt-breadcrumbs {
  margin-top: 0px;
}
.header-v0 .ver-megamenu-header .sm_megamenu_wrapper_vertical_menu{ display:none !important;}
.btn-default:hover{ background-color:inherit;}
.pd {
    padding: 0;
}h4, .h4, h5, .h5, h6, .h6 {
    margin-top: 10px;
    margin-bottom: 10px;
}
h4{     font-size: 18px;}
.button{ height:inherit;    text-transform: inherit;    line-height: 23px;}
.data-table th { text-align:left; border:none;
    text-transform: uppercase;
}
.data-table tr td{ border:none; vertical-align:top !important;}
.btn_adc { padding-top:5px;}
#shopping-cart-table .product-name{     font-family: 'Open Sans',sans-serif !important;}
#shopping-cart-table{ border:none !important;}
.data-table thead{ border:none}
.data-table tbody tr{ border:none;}.seller-name {
    font-size: 15px;
}.button_carts:hover {
    border: 1px solid #A3CE62;
    background: #A3CE62;
    color: #FFF;
}.btn{ font-family: 'Open Sans',sans-serif;
    border: 1px solid #ddd;
    background: #fff;
    padding: 5px 12px;    color: #333;
    transition: color 300ms ease-in-out 0s,background-color 300ms ease-in-out 0s,background-position 300ms ease-in-out 0s;
}
.cart-collateral h3 {
    font-size: 15px;
    color: #000;
    margin-bottom: 15px;
    border-bottom: 1px #ddd solid;
    padding: 10px 0;
    font-family: 'Open Sans',sans-serif;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 20px;
}
a.button.btn-proceed-checkout {
    background: #A3CE62;
    padding: 24px 15px;
    color: #fff;
    width: 100%;
    text-decoration: none;
    border-radius: 2px;    font-size: 16px;
}
a.button.btn-proceed-checkout:hover {
    background: #333;
    color: #fff;
    border: 1px solid #000;
}.button:hover {
    border: inherit;
}
.color_static {
    padding: 8px;
    margin-left: 5px;
}.color_box {
    margin-right: 5px;
    border: 2px solid #eee;
}
.size_static {
    padding: 0 5px;
    font-size: 11px;
    margin-left: 5px;
}.size_box {
    margin-right: 5px;
    border: 2px solid #eee;
}label {
    font-weight: bold;
}
.dashboard {
    display: inline-block;
    width: 100%;
}
.personal-infodiv {
    margin-top: 0;
}
account-login {
    margin-bottom: 15px;
    background-color: #FFF;
    padding: 0;
    margin-top: 15px;
}
.new-users {
    padding: 35px 45px 45px;
}
.new-users {
	display:inline-block;
    text-align: left;
    margin: 0 auto;
    background: #fff;
    border: 1px solid #eaeaea;
    -webkit-box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    -moz-box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    box-shadow: 1px 1px 13px -1px rgba(221,221,221,1);
    max-width: 50%;
}
.form-grp-custom {
    display: inline-block;
    width: 100%;
}.account-input {
    border-radius: 0;
}
.btn-savchange {
    background-color: #666;
    border: 1px solid #666;
    border-radius: 0; color:#fff;
}
.btn-savchange:hover{     background-color: #fe5621;    border: 1px solid #fe5621;}
input[type="text"]{ height:42px;background: #f7f7f7!important;}
input[type="text"]:focus{  background: #fff!important;    border: 1px solid #fe5621;}
textarea{ height:42px;background: #f7f7f7!important;}
textarea:focus{  background: #fff!important;    border: 1px solid #fe5621!important;}
.padding_left_zero{ padding-left:0px;}
.fa-star:before {
    content: "\f005";
    color: #e9ce18;
}
.fa-star{ }
</style>
<script type="text/javascript" src="<?php echo  base_url(); ?>js/new_js/bootstrap-rating.js"></script>
 
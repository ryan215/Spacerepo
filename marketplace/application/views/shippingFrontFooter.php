
<!-- Footer -->
<footer>
	<?php /*?><div class="newsletter-wrap">
    	<div class="container">
      		<div class="row">
        		<div class="col-xs-12 newsletter-maidiv">
          			<div class="newsletter">
            			<div>
                			<div><h4><span>Newsletter</span></h4></div>
							<input type="text" name="email" id="newsletter1" title="Sign up for our newsletter" class="input-text" placeholder="Enter your email address">
							<button type="submit" title="Subscribe" class="subscribe"><span>Subscribe</span></button>
						</div>
					</div>
					<!--newsletter--> 
				</div>
			</div>
    </div>
  </div><?php */?>
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 col-lg-3">
          <div class="footer-column-1 pull-left">
            <div class="footer-logo">
				<a href="<?php echo base_url(); ?>" title="Logo">
					<img src="<?php echo base_url(); ?>images/logo.png" alt="footer logo" class="img-responsive">
				</a>
			</div>
            <center>
				<?php /*?><p>
					<a type="button" title="Sign In" class="btn btn-success btn-cart" href="<?php echo base_url().'frontend/home/sign_in'; ?>">
						<span>Sign In</span>
					</a>
					<a type="button" title="Sign Up" class="btn btn-success btn-cart" href="<?php echo base_url().'frontend/home/sign_up'; ?>">
						<span>Sign Up</span>
					</a>
				</p><?php */?>
			</center>
          </div>
        </div>
<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
	<div class="footer-column pull-left">
    	<h4 style="padding-bottom:5px;  margin-top: -2px;"><a href="http://helpdesk.pointemart.com/ " target="_blank" style="  padding:0px;  font-size: 14px;  margin: 0;  color: #444444;  font-weight: bold;  font-family: 'Open Sans', sans-serif;">Let Us Help You</a></h4>
        <ul class="links">              
        	<li>
				<?php
				if($this->session->userdata('userId'))
				{
				?>
				<a href="<?php echo base_url().'frontend/dashboard';?>" title="Your Account">
					Your Account
				</a>
				<?php
				}
				else
				{
				?>
				<a href="<?php echo base_url().'frontend/home/sign_in'; ?>" title="Your Account">
					Your Account
				</a>
				<?php
				}
				?>
			</li>
				  <?php /*?><li><a href="<?php echo base_url(); ?>shipping-rates-and-policies" title="Shipping Rates & Policies">Shipping Rates & Policies</a></li>
              <li><a href="<?php echo base_url(); ?>return-and-replacements" title="Return & Repalcements">Returns & Replacements</a></li><?php */?>
			  <li><a href="http://helpdesk.pointemart.com/Tickets/CreateWithCustomForm/2178 " target="_blank" title="Shipping Rates & Policies">Shipping Rates & Policies</a></li>
              <li><a href="http://helpdesk.pointemart.com/Tickets/CreateWithCustomForm/2107 " target="_blank" title="Return & Repalcements">Returns & Replacements</a></li>
              <li><a href="<?php echo base_url(); ?>contact-us" title="Contact Us">Contact Us</a></li>              
            </ul>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
          <div class="footer-column pull-left">
            <h4>Get to Know Us</h4>
            <ul class="links">
              <li class="first"><a title="About Spacepointe" href="<?php echo base_url(); ?>about">About PointeMart</a></li>
              <li><a title="Investor Relations" href="<?php echo base_url(); ?>investor-relatons">Investor Relations</a></li>
              <li><a title="Press Release" href="<?php echo base_url(); ?>press-release">Press Release</a></li>
              <li><a title="Carrers" href="<?php echo base_url(); ?>careers">Careers</a></li>              
            </ul>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-2  col-lg-2">
          <div class="footer-column pull-left">
            <h4>Make Money With Us</h4>
            <ul class="links">
              <li class="first">
			  	<a href="<?php echo base_url(); ?>retailer/home" title="Sell on PointeMart">
					Sell on PointeMart
				</a>
			  </li>
              <li><a href="<?php echo base_url(); ?>retailer/home" title="Advertise your products">Advertise Your Products</a></li>
              <li><a href="<?php echo base_url(); ?>terms-of-use">Terms of Use</a></li>
              <li><a href="<?php echo base_url(); ?>privacy-policy">Privacy Policy</a></li>
              
            </ul>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
          <div class="footer-column-last pull-left">
            <h4>Contact Us</h4>
            <div class="address-div">
            	<i class="fa fa-map-marker">&nbsp;</i>
				16 Akin Adesola Street, Victoria Island, Lagos, Nigeria 
            </div>
            <div class="phone-footer col-sm-12" style="padding-left:0px;">
				<i class="fa fa-phone">&nbsp;</i><?php echo $this->config->item('admin_phone_no'); ?>, 807-771-9562
			</div>           
             <div class="phone-footer col-sm-12" style="padding-left:0px;  padding-right: 0px;">
				<i class="fa fa-phone">&nbsp;</i> +234-807-771-9519, 807-418-0801
			</div>
            
            <div class="email-footer" style="  display: inline-block;"><h4 style="padding-top:5px;padding-bottom:0px;">For Customer Inquires</h4><i class="fa fa-envelope">&nbsp;</i>
            	
				<a href="mailto:care@pointemart.com" style="padding-bottom:0px;padding-top:0px;">care@pointemart.com	</a> 
			</div>
            
             <div class="email-footer"><h4 style="padding-top:5px;padding-bottom:0px;">For Corporate Inquires</h4><i class="fa fa-envelope">&nbsp;</i>
            	
				<a href="mailto:Info@spacepointe.com" style="padding-bottom:0px;padding-top:0px;">Info@spacepointe.com	</a> 
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="social-section">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="inner">
          <h4>Connect With Us</h4>
            <div class="social">
              <ul class="link">
              	<li class="pull-left" style="color:#444444; line-height:30px;">Follow Us on </li>
                <li class="fb pull-left"><a href="https://www.facebook.com/SpacePointe" target="_blank"></a></li>
                <li class="tw pull-left"><a href="https://twitter.com/SpacePointe" target="_blank"></a></li>
                <li class="ins pull-left"><a href="https://instagram.com/spacepointe" target="_blank"><i class="fa fa-instagram"></i></a></li>
                <!--<li class="googleplus pull-left"><a href="https://plus.google.com/111848463632007508512/posts/3YjZz5obmY6" target="_blank"></a></li>                <li class="pintrest pull-left"><a href="https://www.pinterest.com/spacepointe/" target="_blank"></a></li>
                <li class="linkedin pull-left"><a href="https://www.linkedin.com/company/spacepointe" target="_blank"></a></li>-->
               <!-- <li class="youtube pull-left"><a href="#"></a></li>-->
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
          <div class="payment-accept pull-right">
            <div><a href="http://www.unionbankng.com/" target="_blank"><img src="<?php echo base_url(); ?>images/frontend/logo-u.jpg" alt="Union Bank" style="width: 25% !important;"></a><img src="<?php echo base_url(); ?>images/frontend/web-pay.png" alt="payment-2" style=""><img src="<?php echo base_url(); ?>images/frontend/img_1.png" alt="payment-2"><img src="<?php echo base_url(); ?>images/frontend/payment-2.png" alt="payment-2"><img src="<?php echo base_url(); ?>images/frontend/payment-4.png" alt="payment-4"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="footer-bottom">
    <div class="container" style="padding: 12px;">
      <div class="row">
        <div class="col-sm-5 col-xs-12 coppyright"> <?php echo date('Y'); ?> &copy; PointeMart.</div>
        <div class="col-sm-7 col-xs-12 company-links">
          <ul class="links">
            <li><a title="Magento Themes" href="<?php echo base_url(); ?>conditions-of-use">Conditions of Use</a></li>
            <li><a title="Premium Themes" href="<?php echo base_url(); ?>privacy-and-security">Privacy & Security</a></li>
           <!-- <li><a title="Responsive Themes" href="<?php //echo base_url(); ?>site-map">Site Map</a></li>-->            
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- End Footer -->

<!-- JavaScript -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/common.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/slider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/owl.carousel.min.js"></script>
<style>
footer {
	margin-top: 0px;
	  border-top: 1px solid #F5F5F5;
}
/* Footer */

/* BRAND SLIDER */
.brand-logo {
	background-color: #FFFFFF;
	margin: 0px 0px 0px 0px;
	padding: 25px 0px 25px 0px;
	border-top: 1px solid #efefef;
}
.brand-logo .container {
	padding: 0px 50px;
}
.brand-logo .slider-items-products .owl-buttons .owl-next {
	position: absolute;
	right: -12px;
	top: 20px;
}
.brand-logo .slider-items-products .owl-buttons a {
	border: none;
	background: #f5f5f5;
}
.brand-logo .slider-items-products .owl-buttons .owl-next a:before {
	font-size: 24px;
}
.brand-logo .slider-items-products .owl-buttons .owl-prev a:before {
	font-size: 24px;
}
.brand-logo .slider-items-products .owl-buttons .owl-prev {
	left: -22px;
	position: absolute;
	top: 18px;
	background: none;
}
.brand-logo a.flex-next {
	background: #fff !important;
	color: #666 !important;
}
.brand-logo a.flex-next:hover {
	color: #000 !important;
	background: #fff !important;
}
.brand-logo a.flex-prev {
	background: #fff !important;
	color: #666 !important;
}
.brand-logo a.flex-prev:hover {
	color: #000 !important;
	background: #fff !important;
}
/* newsletter */
.newsletter-wrap {
	background: #191919;
	padding: 25px;
}
.newsletter {
	margin: 0 0 20px 0;
	padding: 5px 0 0;
	position: relative;
	width: 820px;
	margin: auto;
	margin: auto;
}
.newsletter-wrap h4 {
	font-size: 16px;
	text-transform: uppercase;
	display: inline-block;
	font-weight: normal;
	margin-right: 8px;
	letter-spacing: 1px
}
.newsletter-wrap input[type="text"] {
	background: #FFFFFF;
	width: 450px;
	height: 18px;
	display: inline-block;
	color: #a7a7a7;
	line-height: 22px;
	background-color: #fff;
	border: none;
	padding-left: 10px;
	font-size: 13px;
	font-family: 'Open Sans', sans-serif;
	border: none;
}
.newsletter-wrap button.subscribe {
	background: #A3CE62;
	border: 0 none;
	overflow: hidden;
	padding: 9px 13px !important;
	cursor: pointer;
	font-weight: normal;
	color: #fff;
	margin-left: 10px;
	font-family: 'Open Sans', sans-serif;
	text-transform: uppercase;
	transition: color 300ms ease-in-out 0s, background-color 300ms ease-in-out 0s, background-position 300ms ease-in-out 0s;
}
.newsletter-wrap button.subscribe:before {
	content: "\f0e0";
	font-family: FontAwesome;
	font-size: 13px;
	padding-right: 5px;
	font-weight: normal;
}
.newsletter-wrap input[type="text"] {
	background: #FFFFFF;
	width: 450px;
	height: auto;
	display: inline-block;
	color: #a7a7a7;
	line-height: 22px;
	background-color: #fff;
	border: none;
	font-size: 13px;
	font-family: 'Open Sans', sans-serif;
	border: none;
	padding: 10px
}
footer {
	padding: 0px 0 0;
	overflow: hidden;
	background: #fff;
	color: #fff;
	margin-top: 15px;
}
footer ul {
	margin: 0px;
	padding: 0px;
}
footer ul li {
	list-style-type: none;
}
.com-add {
	border-bottom: 1px solid #f7f7f7;
	margin-bottom: 10px;
	padding-bottom: 6px;
}
footer .footer-inner {
	margin: auto;
	overflow: hidden;
	padding-top: 40px
}
footer .footer-inner h3 {
	color: #3D4C4F;
	font-size: 15px;
	text-transform: uppercase;
	margin: 0 0 15px;
	padding: 0 0 10px;
	font-family: Arial, Helvetica, sans-serif;
}
.footer-column-1 {
	margin-right: 30px;
	margin-bottom: 15px;
	line-height: 18px;
	min-height: 140px;
	padding-right: 30px;
}
.footer-column {
	margin-right: 10px;
	margin-bottom: 15px;
	min-height: 140px
}
footer .footer-column a {
	transition: color 300ms ease-in-out 0s, background-color 300ms ease-in-out 0s, background-position 300ms ease-in-out 0s;
}
/*footer .footer-column a:before {
	content: "\f105";
	font-family: FontAwesome;
	font-size: 13px;
	display: inline-block!important;
	cursor: pointer;
	line-height: 20px;
	color: #666;
	margin-right: 5px;
}*/
.footer-column-last {
	margin-right: 0px;
	margin-bottom: 15px;
	padding-left: 0px;
}
.footer-column-last li {
	padding: 0px 0 5px;
}
.footer-bottom .inner {
	margin: auto;
	padding: 20px 0 15px;
	height: 60px;
}
.footer-bottom .inner a {
	color: #aaa
}
.footer-bottom .inner .bottom_links a {
	margin-left: 15px;
}
.footer-bottom .inner a:hover {
	color: #fff
}
footer a, footer p {
	font-size: 12px;
	color: #999;
	padding-top: 5px;
	padding-bottom: 5px;
}
footer .footer-column a {
	display: block;
	color: #474747;
	font-size: 13px;
}
footer a {
	line-height: normal;
}
footer a:hover {
	color: #848080;
}
footer p {
	line-height: 20px;
}
footer h4 {
	padding: 0 0 10px;
	font-size: 14px;
	margin: 0;
	color: #444444;
	font-weight: bold;
	font-family: 'Open Sans', sans-serif;
}
footer .input-text:focus {
	background: #fff;
	border-color: #464646;
}
footer .coppyright {
	color: #666;
	float: left
}
.footer-bottom .company-links ul {
	padding: 0px;
}
.footer-bottom .company-links li {
  display: inline-block;
  margin-left: 20px;
  list-style: none;
  float: right;
}
footer a {
  line-height: normal;
    font-size: 12px;
  color: #999;
  padding-top: 5px;
  padding-bottom: 5px;
}
.footer-bottom ul li{ padding-top:0px !important;}
.footer-bottom ul li a {
 color: #999 !important; margin: 0px !important; }
.add-icon:before {
	content: "\f041";
	font-family: FontAwesome;
	font-size: 15px;
	color: #848080;
	height: 35px;
	width: 35px;
	line-height: 35px;
	display: inline-block;
	float: left;
	font-style: normal;
	text-align: center;
	margin-right: 10px;
	border-radius: 30px;
	border: 2px #aaa solid;
	border-radius: 25px
}
.email-footer {
	overflow: hidden;
	font-size: 13px;
	color: #474747;
}
.email-footer a {
	font-size: 13px;
	line-height: 24px;
	color: #474747;
}
.phone-footer {
	overflow: hidden;
	font-size: 13px;
	line-height: 24px;
	color: #474747;
}
.address-div {
	color: #474747;
	font-size: 13px;
	line-height: 24px;
	overflow: hidden;
}
footer address {
	display: block;
	margin: auto;
	font-style: normal;
	line-height: 1.5em;
	color: #aaa;
	padding-top: 5px;
	margin-top: 10px;
	text-align: left;
	padding-bottom: 5px;
	margin-bottom: 7px;
	font-size: 12px;
	border: none;
}
.email-icon:before {
	content: "\f0e0";
	font-family: FontAwesome;
	font-size: 14px;
	color: #848080;
	height: 35px;
	width: 35px;
	margin-right: 5px;
	line-height: 30px;
	display: inline-block;
	float: left;
	font-style: normal;
	text-align: center;
	margin-right: 10px;
	border: 2px #aaa solid;
	border-radius: 25px
}
.phone-icon:before {
	content: "\f095";
	font-family: FontAwesome;
	font-size: 15px;
	color: #848080;
	height: 35px;
	width: 35px;
	margin-right: 5px;
	line-height: 35px;
	display: inline-block;
	float: left;
	font-style: normal;
	text-align: center;
	margin-right: 10px;
	border: 2px #aaa solid;
	border-radius: 25px
}
.footer-bottom .bottom_links li {
	margin-left: 20px
}
.custom-footer-links li {
	margin: 7px 0
}
.payment-accept {
	color: #333333;
	font-size: 12px;
}
.payment-accept img {
	margin-left: 10px;
	width: 60px;
	width: 50px;
}
.footer-col-right {
	width: 58%;
	float: left
}
.contact-info {
	text-align: center;
}
ul.contact-info span {
	font-size: 13px !important;
	font-weight: 900 !important;
	color: #666;
	float: left
}
ul.contact-info li {
	margin-bottom: 8px;
	padding-bottom: 8px;
	display: inline-block;
}
ul.contact-info li.last {
	float: left;
	margin-bottom: 0px;
	border-bottom: 0px #2D3D4C solid
}
#container_newsletter {
	width: 100%;
	padding: 7px 0 7px 0;
	background: #f7f7f7;
	margin: 36px 0 22px 0
}
#text_container_news {
	width: 205px;
	height: 34px;
	float: left;
	margin-left: 30px;
	text-transform: uppercase;
	font-family: arial;
	font-size: 10px;
	color: #647177;
	padding-top: 7px
}
#text_container_news span {
	color: #959a9c;
	font-size: 9px
}
#container_form_news {
	position: relative;
	z-index: 0
}
#container_form_news2 input[type="text"] {
	background: #FFFFFF;
	width: 165px;
	height: 12px;
	display: inline;
	color: #a7a7a7;
	line-height: 20px;
	background-color: #FFFFFF;
	border: 2px solid #ddd;
	padding-left: 10px;
	font-size: 13px;
	font-family: Arial, Helvetica, sans-serif;
}
#container_form_news2 input[type="submit"] {
	cursor: pointer;
	border: 0;
	background: #FFFFFF;
	width: 20px;
	height: 12px;
	display: block;
	position: relative;
	color: #a7a7a7;
	font-size: 10px;
	line-height: 20px;
	top: -18px;
	right: -160px
}
.footer-box {
	width: 1240px;
	margin: auto;
}
footer ul span {
	display: inline-block;
	font-size: 20px;
	font-weight: 300;
	line-height: 15px;
	padding-right: 3px;
}
address {
	display: block;
	margin: auto;
	font-style: normal;
	line-height: 21px;
	color: #999;
	padding-top: 10px;
	margin-top: 10px;
	text-align: left;
	padding-bottom: 15px;
	border-bottom: 1px #eaeaea solid;
	margin-bottom: 15px
}
.footer-logo {
	text-align: left;
	margin: 0 0 22px 0;
}
.social-section {
	padding: 0px;
	overflow: hidden;
	width: 100%;
	margin: auto;
	background: #fff;
	border-bottom: 1px solid #eee;
}
.social-section .inner {
	margin: auto;
	overflow: hidden;
	margin-bottom: 20px;
	padding-top: 20px;
}
.social .fb a:before {
	content: "\f09a";
	font-family: FontAwesome;
}
.social .fb a {
	background: #3C5B9B;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .fb a:hover {
	background: #3C5B9B !important;text-decoration:none;
}



.social .ins a {
	background: #824D3B;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .ins a:hover {
	background: #824D3B !important;
	
}

.social .tw a:before {
	content: "\f099";
	font-family: FontAwesome;
}
.social .tw a {
	background: #359BED;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .tw a:hover {
	background: #359BED !important;text-decoration:none;
}
.social .googleplus a:before {
	content: "\f0d5";
	font-family: FontAwesome;
}
.social .googleplus a {
	background: #E33729;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .googleplus a:hover {
	background: #E33729!important;
}
.social .rss a:before {
	content: "\f09e";
	font-family: FontAwesome;
}
.social .rss a {
	content: "\f09e";
	font-family: FontAwesome;
	background: #FD9F13;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .rss a:hover {
	background: #FD9F13 !important;
}
.social .pintrest a:before {
	content: "\f0d3";
	font-family: FontAwesome;
}
.social .pintrest a {
	content: "\f0d3";
	font-family: FontAwesome;
	background: #cb2027;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .pintrest a:hover {
	background: #cb2027 !important;
}
.social .linkedin a:before {
	content: "\f0e1";
	font-family: FontAwesome;
}
.social .linkedin a {
	content: "\f0e1";
	font-family: FontAwesome;
	background: #027ba5;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .linkedin a:hover {
	background: #027ba5 !important;
}
.social .youtube a:before {
	content: "\f167";
	font-family: FontAwesome;
}
.social .youtube a {
	background: #F03434;
	font-size: 18px;
	border-radius: 3px;
	line-height: 35px;
	display: inline-block!important;
	width: 35px;
	height: 35px;
	color: #fff;
	text-align: center;
	padding: 0;
}
.social .youtube a:hover {
	background: #F03434 !important;
}
.social h4 {
	font-size: 14px;
	font-weight: bold;
	color: #fff;
	text-align: left;
	border: none;
	padding: 0;
	margin: 0;
	margin-bottom: 5px;
}
.social ul {
	margin: 0;
	padding-top:0px !Important;
	list-style: none;
}
.social ul li {
	margin-right: 7px !important; padding-bottom:0px !Important; margin-left:0px !Important;
}
.social a {
	transition: background 400ms ease-in-out;
	-webkit-transition: background 400ms ease-in-out;
	-moz-transition: background 400ms ease-in-out;
	-o-transition: background 400ms ease-in-out;
}
.payment-accept {
	color: #333333;
	font-size: 12px;
	margin: auto;
	overflow: hidden;
	margin-bottom: 20px;
	padding-top: 20px;
	text-align: right;
}
.payment-accept img {
	margin-left: 10px;
	width: 60px;
	width: 50px;
}
.btn-cart {
background: #A3CE62;
color: #fff;
font-size: 16px;
text-shadow: none;
margin-top: 0px;
font-weight: normal;
transition: color 300ms ease-in-out 0s, background-color 300ms ease-in-out 0s, background-position 300ms ease-in-out 0s;
margin-left: 10px;
border: none;
padding: 5px 12px;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/level-1.css">

</body>
</html>
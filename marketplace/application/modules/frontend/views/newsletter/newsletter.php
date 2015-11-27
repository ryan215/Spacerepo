<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta Data -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1" >
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/slogo.png" type="image/x-icon" />
<title>PointeMart</title>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Stylesheets -->
<link href="<?php echo base_url(); ?>css/newsletter/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/newsletter/intlTelInput.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/newsletter/style.css" rel="stylesheet">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-63026686-1', 'auto');
  ga('send', 'pageview');

</script>
<script type="text/javascript">

                var $mcGoal = {'settings':{'uuid':'90f3abe73bb36998ec8a5a27d','dc':'us10'}};

                (function() {

                                var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;

                                sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';

                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);

                })();

</script>
</head>

<body>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="top:30%;">
    <div class="model-header">
      <button type="button" class="close-popup-icon" data-dismiss="modal" aria-label="Close" style="border:0; background:none;"><span aria-hidden="true"><img width="30px" height="30px" src="<?php echo base_url(); ?>img/close.png"></span></button>
    </div>
    <div class="modal-content newlatter-content"> <img class="conget-img" src="<?php echo base_url(); ?>img/tag-popup.png">
      <div class="modal-body newlatter-popup">
        <h2> Congratulations!</h2>
        <p class="change-message">Your signup is almost complete! To complete the signup process, please check your email and click the link to verify your email address and enter for the daily prize drawings!!
		</p>
        <p>10 winners selected every day!!</p>
        <p style="margin-bottom:2px; font-size:16px;">Draw Dates:</p>
        May 15th – May 23rd 2015 &nbsp;&nbsp;&nbsp;&nbsp;
        
      </div>
    </div>
  </div>
</div>
<section class="header">
  <div class="container">
<?php
$uriSeg3 = $this->uri->segment(3);
if(($this->session->flashdata('success'))&&(empty($uriSeg3)))
{	
?>
<script type="text/javascript">
	$(document).ready(function(){
	$('#myModal').modal('show');
});
</script>

    <div class="alert-success"> <span class="glyphicon glyphicon-ok" style="padding: 12px;line-height: 20px;"></span> <?php echo $this->session->flashdata('success'); ?> </div>
    <?php
}
elseif($this->session->flashdata('error'))
{
?>
    <div class="alert alert-danger" style="padding:0 5px"> <span class="glyphicon glyphicon-remove" style="padding: 5px 8px 8px 15px;line-height: 23px;"></span> <?php echo $this->session->flashdata('error'); ?> </div>
    <?php
}
?>
    <div class="row">
      <div class="col-xs-7 col-lg-4 logo"> <img src="<?php echo base_url(); ?>img/newsletter/logo.png" class="img-responsive" /> </div>
      <div class="col-xs-5 col-lg-8 social-top">
        <p class="pull-right"> <a href="https://www.facebook.com/SpacePointe" target="_blank"><i class="fa fa-facebook"></i></a> <a href="https://twitter.com/SpacePointe" target="_blank"><i class="fa  fa-twitter"></i></a> <a href="https://instagram.com/spacepointe" target="_blank"><i class="fa fa-instagram"></i></a> </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 slider-maindiv">
        <div id="myCarousel" class="carousel slide" data-ride="carousel"> 
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
            <li data-target="#myCarousel" data-slide-to="4"></li>
            <li data-target="#myCarousel" data-slide-to="5"></li>
            <li data-target="#myCarousel" data-slide-to="6"></li>
            <li data-target="#myCarousel" data-slide-to="7"></li>
            <li data-target="#myCarousel" data-slide-to="8"></li>
          </ol>
          
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active"> <img src="<?php echo base_url(); ?>img/newsletter/africanfab1.jpg" alt="Chania"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/LANDPAGEgrt1.jpg" alt="Chania"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/LANDPAGEKIDSSSNEW1.jpg" alt="Flower" > </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/LANDPAGExtrtranew1.jpg" alt="Flower"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/LANDPAGEstainbb1.jpg" alt="Flower"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/samsung-banner1.jpg" alt="Flower"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/ASS.jpg" alt="Flower"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/AVEND.jpg" alt="Flower"> </div>
            <div class="item"> <img src="<?php echo base_url(); ?>img/newsletter/console.jpg" alt="Flower"> </div>
           
          </div>
          
          <!-- Left and right controls --> 
          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> </div>
        <?php /*?><div id="slider1_container" style="display: none; position:relative; margin: 0 auto;top: 0px; left: 0px; width: auto; height: 500px; overflow: hidden;"> 
          <!-- Loading Screen -->
          <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;"> </div>
          </div>
          <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter2.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter3.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter4.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter5.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter6.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter7.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/newsletter8.jpg" /> </div>
            <div> <img u="image" src2="<?php echo base_url(); ?>img/newsletter/b1.jpg" /> </div>
          </div>
          
          <!--#region Bullet Navigator Skin Begin --> 
          <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html --> 
          
          <!-- bullet navigator container -->
          <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;"> 
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
          </div>
          <!--#endregion Bullet Navigator Skin End --> 
          
          <!--#region Arrow Navigator Skin Begin --> 
          <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html --> 
          
          <!-- Arrow Left --> 
          <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;"> </span> 
          <!-- Arrow Right --> 
          <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;"> </span> 
          <!--#endregion Arrow Navigator Skin End --> 
          
        </div><?php */?>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <div class="col-sm-12 sign_up">
    <div class="col-sm-7 pd">
      <div class="sign_data">
        <h1>Newsletter Signup</h1>
        <span class="sign_up_heading">BUY & SELL Your Products In PointeMart, Your Online Marketplace </span>
        <p>Join our <strong>VIP</strong> mailing list for instant access to get prizes and money</p>
      </div>
<?php 
echo form_open();
?>                                                                                                   <div class="col-sm-12 pd">
          <div class="col-sm-6 pd_bottom">
          	<span class="star-requr">*</span>
            <input class="form-control news-input" placeholder="First Name" type="text" name="firstName" value="<?php echo set_value('firstName'); ?>" />
            <?php echo form_error('firstName'); ?> </div>
          <div class="col-sm-6 pd_bottom">
          	<span class="star-requr">*</span>
            <input class="form-control news-input" placeholder="Last Name" type="text" name="lastName" value="<?php echo set_value('lastName'); ?>" />
            <?php echo form_error('lastName'); ?> </div>
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
            	<span class="star-requr">*</span>
              <input class="form-control news-input" placeholder="Email" type="text" name="email" value="<?php echo set_value('email'); ?>" />
              <?php echo form_error('email'); ?> </div>
            <div class=""></div>
            <div class="col-sm-6 pd_bottom">
            	<span class="star-requr">*</span>
              <input type="tel" class="form-control news-input" id="mobile-number" placeholder="" name="phoneCode" value="<?php echo $phoneCode; ?>" style="width:30%; float:left; border-bottom-right-radius:0 !important; border-top-right-radius:0 !important; border-right:0;">
              <!--<div class="input-group"> <span class="input-group-addon" id="basic-addon1"> +234 </span>-->
              <input class="form-control bfh-phone news-input" aria-describedby="basic-addon1" placeholder="Phone" type="text" name="phone" value="<?php echo set_value('phone'); ?>" / style="width:70%;border-bottom-left-radius:0!important; border-top-left-radius:0 !important;">
              <?php echo form_error('phone'); ?> </div>
          </div>
        </div>
        <div class="col-sm-12 pd">
          <div class="col-sm-6 pd_bottom">
          	<span class="star-requr">*</span>
          	<div id="stateList">
              <select class="form-control selectpicker" name="stateId" data-live-search="true">
                <option value="">Select State</option>
              </select>
            </div>
            <?php echo form_error('stateId'); ?>
		  </div>
          <div class="col-sm-6 pd_bottom">
          	<span class="star-requr">*</span>
            <div id="areaList">
              <select class="form-control selectpicker" name="areaId" data-live-search="true">
                <option value="">Select Area</option>
              </select>
            </div>
            <?php echo form_error('areaId'); ?> </div>
        </div>
        <div class="col-sm-12 pd">
          <div class="col-sm-6 pd_bottom">
          	<span class="star-requr">*</span>
            <div id="cityList">
              <select name="cityId" class="form-control selectpicker" data-live-search="true">
                <option value="">Select City</option>
              </select>
            </div>
            <?php echo form_error('cityId'); ?> </div>
          
          <!--<div class="form-group">
                <div class="col-sm-6 pd_bottom">
                  <label class="control-label emai"> Select your Gender</label>
                </div>
              </div>-->
          
          <div class="col-sm-6 pd_bottom">
            <select name="gender" class="form-control form-control selectpicker">
              <option>Gender</option>
              <option value="1" <?php echo set_select('gender',1); ?>>Male</option>
              <option value="2" <?php echo set_select('gender',2); ?>>Female</option>
            </select>
            <?php echo form_error('gender'); ?> </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12 pd_bottom">
            <button type="submit" class="btn btn-info btn-block col-sm-12 news-btn" >Sign up</button>
          </div>
        </div>
        <?php /*?><div class="col-sm-12"> <img src="<?php echo base_url();?>img/newsletter/bags.jpg" class="img-responsive"> </div><?php */?>
      </form>
    </div>
    <div class="col-sm-5 pic">

    
     <img src="<?php echo base_url();?>img/newsletter/Boy&girl.png" class="img-responsive"> </div>
  </div>
  
</div>
<?php
$datetime1 = new DateTime(date('Y-m-d H:i:s'));
$datetime2 = new DateTime('2015-05-28 00:00:00');
$interval  = $datetime1->diff($datetime2);
$dayDiff   = $interval->format('%a');
?>
<!-- start footer section -->
<section class="footer">
  <div class="container foot">
    <div class="col-xs-8 col-sm-6 col-lg-7">
      <?php /*?><ul>
        <li><?php echo $dayDiff; ?>
          <p> Days </p>
        </li>
        <li><?php echo $interval->format("%h"); ?>
          <p> Hours </p>
        </li>
        <li style="border:none;"><?php echo $interval->format("%i"); ?>
          <p> Minutes </p>
        </li>
      </ul><?php */?>
      <h1 style="font-family: 'museo700';  color: #fff;  line-height: 36px;  padding-top: 0px;">Pointemart<br> Launch <br>Celebration</h1>
      <div class="clearfix"></div>
  <?php /*?>    <p class="text-center text-white">We are <?php echo $dayDiff; ?> Days , <?php echo $interval->format("%h"); ?> Hours, <?php echo $interval->format("%i"); ?> Minutes away from launching POINTEMART</p><?php */?>
    </div>
  </div>
</section>
<div class=" col-lg-12 foot2"> 
  <div class="container">
    <div  class="col-xs-6 col-lg-6"> PointeMart &copy; <?php echo date('Y'); ?> </div>
    <div  class="col-xs-6 col-lg-6">
      <p class="pull-right"> <a href="https://www.facebook.com/SpacePointe" target="_blank"><i class="fa fa-facebook"></i></a> <a href="https://twitter.com/SpacePointe" target="_blank"><i class="fa  fa-twitter"></i></a> <a href="https://instagram.com/spacepointe" target="_blank"><i class="fa fa-instagram"></i></a> </p>
    </div>
  </div>
</div>

<!-- end footer section --> 

<script src="<?php echo base_url(); ?>js/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>js/frontend/bootstrap-select.js"></script> 
<script src="<?php echo base_url(); ?>js/frontend/intlTelInput.js"></script> 
<link href="<?php echo base_url(); ?>css/newsletter/bootstrap-select.css" rel="stylesheet">
<script type="text/javascript">
$("#mobile-number").intlTelInput();
$('.selectpicker').selectpicker();

function state_list(countryId)
{	
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/stateCountryList'; ?>',
		data:'countryId='+countryId+'&stateId=<?php echo htmlentities($stateId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#stateList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#stateList').html(result);
			area_list($('#stateId').val());			
			//console.log(result);
		}
	});
}

function area_list(stateId)
{	//alert(stateId);
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/areaStateList'; ?>',
		data:'stateId='+stateId+'&areaId=<?php echo htmlentities($areaId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#areaList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#areaList').html(result);
			city_list($('#areaId').val());		
		}
	});
}

function city_list(areaId)
{
	$.ajax({
		type: "POST",
		url:'<?php echo base_url().'frontend/location_management/cityAreaList'; ?>',
		data:'areaId='+areaId+'&cityId=<?php echo htmlentities($cityId); ?>&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
		beforeSend: function() {
			$('#cityList').html('<?php echo $this->loader; ?>');
		},
		success:function(result){ 
			$('#cityList').html(result);	
		}
	});
}

<?php
if($countryId)
{
?>
state_list('<?php echo htmlentities($countryId); ?>');
<?php
}
if($stateId)
{
?>
area_list('<?php echo htmlentities($stateId); ?>');
<?php
}
if($areaId)
{
?>
city_list('<?php echo htmlentities($areaId); ?>');
<?php
}

if($this->session->flashdata('success'))
{
?>
$(document).ready(function(){
	$('#myModal').modal('show');
});
<?php
}
?>
$( document ).ajaxComplete(function() {
	$('#stateId').addClass('form-control selectpicker').selectpicker();
	$('#areaId').addClass('form-control selectpicker').selectpicker();
	$('#cityId').addClass('form-control selectpicker').selectpicker();
});
</script> 
<script>
$(function(){
  $('#demo').on('hide.bs.collapse', function () {
    $('#button').html('<span class="fa fa-angle-down"></span> Show');
  })
  $('#demo').on('show.bs.collapse', function () {
    $('#button').html('<span class="fa fa-angle-up"></span> Hide');
  })
})
</script> 
<script>
  $('.carousel').carousel({
   interval: 2000
  });
 </script>  
<!-- Javascripts end --->

</body>
</html>
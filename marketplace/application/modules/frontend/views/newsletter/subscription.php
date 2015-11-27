<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta Data -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<!-- Favicon -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>img/slogo.png" type="image/x-icon" />
<title>PointeMart</title>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<!-- Stylesheets -->
<link href="<?php echo base_url(); ?>css/newsletter/font-awesome.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/newsletter/style.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/newsletter/bootstrap-select.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/newsletter/intlTelInput.css" rel="stylesheet">
<!-- Main Stylsheets -->

</head>

<body>
<!-- header section -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="top:30%;">
    <div class="model-header">
      <button type="button" class="close-popup-icon" data-dismiss="modal" aria-label="Close" style="border:0; background:none;"><span aria-hidden="true"><img width="30px" height="30px" src="<?php echo base_url(); ?>img/close.png"></span></button>
    </div>
    <div class="modal-content newlatter-content"> <img class="conget-img" src="<?php echo base_url(); ?>img/tag-popup.png" style="width:10%;">
      <div class="modal-body newlatter-popup" style="padding-bottom:50px;">
        <h2> Congratulations!</h2>
        <p class="change-message">You have been verified and are entered into the drawing to win prizes. Want to win bigger prizes?? Refer 5 friends for a chance to win bigger prizes!!
		</p>
       
      </div>
    </div>
  </div>
</div>

<section class="header">
  <div class="container">
    <?php
if($this->session->flashdata('success'))
{
?>
    <div class="alert-success"> <span class="glyphicon glyphicon-ok" style="padding: 12px;line-height: 20px;"></span> <?php echo $this->session->flashdata('success'); ?> </div>
    <?php
}
elseif($this->session->flashdata('error'))
{
?>
    <div class="alert-error"> <span class="glyphicon glyphicon-remove" style="padding: 12px;line-height: 20px;"></span> <?php echo $this->session->flashdata('error'); ?> </div>
    <?php
}
?>
    <div class="row">
      <div class="col-xs-6 col-sm-4 logo"> <img src="<?php echo base_url(); ?>img/newsletter/logo.png" class="img-responsive" /> </div>
      <div  class="col-xs-6 col-lg-8 social-top">
        <p class="pull-right"> <a href="https://www.facebook.com/SpacePointe" target="_blank"><i class="fa fa-facebook"></i></a> <a href="https://twitter.com/SpacePointe" target="_blank"><i class="fa  fa-twitter"></i></a> <a href="https://instagram.com/spacepointe" target="_blank"><i class="fa fa-instagram"></i></a> </p>
      </div>
    </div>
  </div>
</section>
<!-- end header section -->
<section>
  <div class="container">
    <div class="col-sm-6 sign_up">
      <div class="sign_data sign_data1">
        <h2>REFER FIVE FRIENDS AND <br>
          WIN MORE ENTRIES FOR<br>
          MORE PRIZES</h2>
      </div>
    </div>
    <div class="col-sm-6 girls-talk"><img src="<?php echo base_url(); ?>img/newsletter/mobs.png" class="img-responsive"></div>
  </div>
  <br>
  <br>
  <div class="container">
    <div class="col-sm-6 letf-div-subsc"> <img src="<?php echo base_url(); ?>img/newsletter/pubs2.png" class="img-responsive">
      <div class="col-sm-12 text-center left-text-subs">With every 5 verified emails, you will be entered into our<br>
        weekly draw for a FREE 500.00 NGN Pre-paid Card,<br>
        RCA Camera, I-pad Mini, Watches and much more!</div>
    </div>
    <div class="col-sm-6 refer_form">
      <p class="text-center rafer-friend-p"><i class="fa fa-angle-double-down"></i> Refer Your Friends To Win Prizes !</p>
<?php 
echo form_open();
?>                                                                                                   <div class="col-sm-12 pd">
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Name" type="text" name="name1" value="<?php echo set_value('name1'); ?>" />
              <?php echo form_error('name1'); ?> </div>
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Email" type="text" name="email1" value="<?php echo set_value('email1'); ?>" />
              <?php echo form_error('email1'); ?> </div>
          </div>
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Name" type="text" name="name2" value="<?php echo set_value('name2'); ?>" />
              <?php echo form_error('name2'); ?> </div>
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Email" type="text" name="email2" value="<?php echo set_value('email2'); ?>" />
              <?php echo form_error('email2'); ?> </div>
          </div>
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Name" type="text" name="name3" value="<?php echo set_value('name3'); ?>" />
              <?php echo form_error('name3'); ?> </div>
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Email" type="text" name="email3" value="<?php echo set_value('email3'); ?>" />
              <?php echo form_error('email3'); ?> </div>
          </div>
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Name" type="text" name="name4" value="<?php echo set_value('name4'); ?>" />
              <?php echo form_error('name4'); ?> </div>
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Email" type="text" name="email4" value="<?php echo set_value('email4'); ?>" />
              <?php echo form_error('email4'); ?> </div>
          </div>
          <div class="col-sm-12 pd">
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Name" type="text" name="name5" value="<?php echo set_value('name5'); ?>" />
              <?php echo form_error('name5'); ?> </div>
            <div class="col-sm-6 pd_bottom">
              <input class="form-control news-input" placeholder="Email" type="text" name="email5" value="<?php echo set_value('email5'); ?>" />
              <?php echo form_error('email5'); ?> </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12 pd_bottom" style="padding-top:20px;">
            <button type="submit" class="btn btn-success btn-block col-sm-12 rafer-btn" >Refer A Friend</button>
          </div>
        </div>
      </form>
      <div class="col-sm-12">
        <h4 class="text-success text-center form-bootom-text">10 Prizes to be won every Friday from May 8th to May 29th!</h4>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</section>
<?php /*?><section class="">
  <div class="container">
    <div class="col-sm-7 col-lg-7">
      <div class="col-sm-12 col-xs-offset-5  sign_up">
        <div class="sign_data text-center">
          <h2 style="line-height:32px;">REFER FIVE FRIENDS AND WIN MORE ENTRIES FOR MORE PRIZES!</h2>
          <span class="sign_up_heading">With every 5 verified emails, you will be entered into our<br> weekly draw for a FREE 500.00 NGN Pre-paid Card,<br>
            RCA Camera, I-pad Mini, Watches and much more!
		  </span>
         <!-- <p>Join our <strong>VIP</strong> mailing list for instant access to get prizes and money</p>-->
        </div>
       
        <h4 class="text-center">10 Prizes to be won every Friday from May 8th to May 29th!</h4>
      </div>
      
        </div>
      
      
      
      
    </div>
    
    
  </div>
</section><?php */?>
<!-- end content section --> 
<br>
<br>
<br>
<br>
<!-- start footer section -->
<div class=" col-lg-12 foot2">
  <div class="container">
    <div  class="col-xs-6 col-lg-6"> PointeMart &copy; <?php echo date('Y'); ?> </div>
    <div  class="col-xs-6 col-lg-6 social-bottom" style="padding-right:0px;">
      <p class="pull-right"> <a href="https://www.facebook.com/SpacePointe" target="_blank"><i class="fa fa-facebook"></i></a> <a href="https://twitter.com/SpacePointe" target="_blank"><i class="fa  fa-twitter"></i></a> <a href="https://instagram.com/spacepointe" target="_blank"><i class="fa fa-instagram"></i></a> </p>
    </div>
  </div>
</div>

<!-- end footer section --> 

<!-- Javascripts --> 
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
<script>
	function centerModal() {
    $(this).css('display', 'block');
    var $dialog = $(this).find(".modal-dialog");
    var offset = ($(window).height() - $dialog.height()) / 2;
    // Center modal vertically in window
    $dialog.css("margin-top", offset);
}

$('.modal').on('show.bs.modal', centerModal);
$(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
});
</script> 
<script>
<?php
if((!$_POST)&&(!$this->session->flashdata('error'))&&(!$this->session->flashdata('success')))
{
?>
$(document).ready(function(){
	$('#myModal').modal('show');
});
<?php
}
?>
    
	  
	  
	  $( document ).ajaxComplete(function() {
	 $('.selectpicker').selectpicker();
	 
	 $('#cityId').addClass('.form-control1');

 
});
</script> 

<!-- Javascripts end ---> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/jssor.slider.mini.js"></script> 
<script>
        jQuery(document).ready(function ($) {

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 800,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
              
                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
<style>
                /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(../img/b21.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<![endif]-->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="PointeMart Shopping Website">
<meta name="keywords" content="PointeMart Shopping Website">
<meta name="author" content="SpacePointe">
<meta http-equiv="X-Frame-Options" content="deny">

<!-- Favicons Icon -->
<link rel="icon" href="" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>images/new_images/faviconmart.png" type="image/x-icon" />
<title><?php echo $title; ?></title>
<!-- Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/require.js/2.1.11/require.min.js"></script>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- CSS Style -->
<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
$this->custom_log->write_log('custom_log','User agent server data is '.print_r($_SERVER,true));
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
$requestUri = $_SERVER['SERVER_NAME'];
$this->custom_log->write_log('custom_log','Request URl '.$requestUri);
if(!empty($requestUri))
{
 if((!empty($requestUri))&&($requestUri=='pointemart.com'))
 {
 // $urlred = str_replace('pointemart.com','m.pointemart.com',$_SERVER['REQUEST_URI']);
  // $this->custom_log->write_log('custom_log','redirect url is '.$urlred);

  header('Location:https://m.pointemart.com'.$_SERVER['REQUEST_URI']);
 }
}
}
?>
<?php /*?><script type="text/javascript">
<!--
if (screen.width <= 800) {
window.location = "https://m.pointemart.com/";
}
//-->
</script><?php */?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/style.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/bootstrap-select.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/success_error_message_style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/hover.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/responsive.css"  media='all'>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/loader_css.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/frontend/frontendNew.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/jquery.min.js"></script>
<link href="<?php echo base_url();?>css/frontend/jquery_ui.css" rel="Stylesheet">
</link>
<script src="<?php echo base_url(); ?>js/frontend/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/frontend/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/frontend/typeahead.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/new_css/bootstrap/bootstrap.css" media="all" >
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/new_css/bootstrap/bootstrap-theme.min.css" media="all" >
--><link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" media="all" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sm/cartpro/css/cartpro.css" media="all" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sm/listingtabs/css/animate.css" media="all"  >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sm/listingtabs/css/sm-listing-tabs.css" media="all"  >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>sm/listingtabs/css/owl.carousel.css" media="all"  >
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.noconflict.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.accordion_snyderplace.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.jqtransform.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/yt-script.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/yt-extend.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/cloud-zoom.1.0.2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jcarousellite_1.0.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.easing.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.cookie.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/respond.src.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/fancybox-buttons.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/easyResponsiveTabs.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/jquery.session.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/ytcpanel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/lib/modernizr.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/lib/selectivizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/lib/imagesloaded.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>js/new_js/scroll_header.js"></script>-->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/new_css/theme-orange.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>css/new_css/scroll_header.css" type="text/css" />
<link rel="author" href="https://plus.google.com/u/0/+Smartaddons" />
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Anton" media="all" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<script>
var currentRequest = null;
function not_submit(event,srchVal)
{	
	//alert(srchVal);
	//alert($('#search').val());	
	if((event.keyCode==38)||(event.keyCode==40))
	{
		return false;
	}
	if(event.keyCode==13)
	{
		urlEntr = $('#autoSearchRes li.selected').find('a').first().attr('href');
		if(urlEntr!==undefined)
		{	
			window.location.href = urlEntr;
		}
		return false;
	}
	else
	{	//console.log(srchVal.length);
		if(srchVal.length>0)
		{
			$('.main-container').css('opacity','0.1');
			$('.main-container').css('background-color','#EDEDED');
			$('div#yt_content').css('opacity','0.1');
			$('body').css('background-color','#EDEDED');
			
			currentRequest =$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>frontend/product/search_product",
				//data:'term='+srchVal
				data:'term='+$('#search').val()+'&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>',
				beforeSend:function(){           
					if(currentRequest != null) 
					{
                    	currentRequest.abort();
                	}
	            },
				success: function(data){
					$('ul#autoSearchRes').css('display','block');
					$('ul#autoSearchRes').html(data);
				}
			});
		}
		else
		{
			$('ul#autoSearchRes').html('');
			$('ul#autoSearchRes').css('display','none');
			
			$('div#yt_content').css('opacity','inherit');
			$('body').css('background-color','white');
			
			$('.main-container').css('opacity','inherit');
			$('.main-container').css('background-color','white');
		}		
	}
}

$(document).ready(function(){
	$('#search').keydown(function(e){ 
		//	For key up
		if(e.keyCode == 38)
		{
			if($('#autoSearchRes').is(':visible') )
			{
            	if(!$('.selected').is(':visible') )
				{
                	$('#autoSearchRes li').last().addClass('selected');
                }
				else
				{
					//$('#autoSearchRes li.selected').find('a').first().attr('href')
                    var i =  $('#autoSearchRes li').index($('#autoSearchRes li.selected')) ;
                    $('#autoSearchRes li.selected').removeClass('selected');
                    i--;
                    $('#autoSearchRes li:eq('+i+')').addClass('selected');
 
                }
            }
		}
		
		//	For key down
    	if(e.keyCode == 40) 
		{
			if($('#autoSearchRes').is(':visible'))
			{	
                if(!$('.selected').is(':visible') )
				{
                    $('#autoSearchRes li').first().addClass('selected');
                }
				else
				{
					//$('#autoSearchRes li.selected').find('a').first().attr('href')
                	var i =  $('#autoSearchRes li').index($('#autoSearchRes li.selected'));
					$('#autoSearchRes li.selected').removeClass('selected');
                    i++;
                    $('#autoSearchRes li:eq('+i+')').addClass('selected');
                }
            }
		}
		
		$("#autoSearchRes").scrollTop(0);
	    $("#autoSearchRes").scrollTop($('.selected').offset().top-$("#autoSearchRes").height());   
	});





	$('#sm_serachbox_pro378981551436342939').click(function(e){
		e.stopPropagation();
	});

	$(document).click(function(){
	    $('ul#autoSearchRes').html('');
		$('ul#autoSearchRes').css('display','none');
		
		$('div#yt_content').css('opacity','inherit');
		$('body').css('background-color','white');
		
		$('.main-container').css('opacity','inherit');
		$('.main-container').css('background-color','white');
	});
});

function signup_model()
{
	jQuery('#modal-login').modal('hide');
	jQuery('#modal-reg').modal('show');
}

function forgotpassword_model()
{
	jQuery('#modal-login').modal('hide');
	jQuery('#modal-fpass').modal('show');
}

function close_cart()
{
	$('div#topCartCnt').html('');
}
</script>
<style type="text/css">
body {
font-size: 12px;
}
body {
font-family: Open Sans;
}
body.sm_shoppy {
color: #444444;
}
body.sm_shoppy {
background-color: #FFFFFF;
}
a,
.store-info .list-info .item-info .info-content > h2 {
color: #444444;
}
a:hover,
.no-rating a:hover {
color: #ee4620;
}
#yt_wrapper .page-title:before {
background-color: #444444;
}
.cloud-zoom-big {
top: 0 !important;
left: 0 !important;
width: 100% !important;
height: 100% !important;
}
.forgot-pass-popup{width:100% !important;
	padding-right:0 !important;
	border-right:0 !important;
}
.auto-search-img{/*width:65px;*/
	padding:0;
}
.ui-autocomplete.ui-menu.ui-widget.ui-widget-content.ui-corner-all{border-bottom-right-radius:0 !important; 
	border-bottom-left-radius:0 !important;
	border-top-left-radius:0 !important;
	border-top-right-radius:0 !important;
	top:159px !important;
	border-color:#dcdcdc !important;
	padding-bottom:5px !important;
	font-size:12px;
	margin-left:-1px;
	margin-top:14px !important;
	z-index:10 !important;
	line-height:17px !important;
	min-height:50px; max-height:500px; overflow-y:scroll; overflow-x:hidden;
}
.search_text .search-main{padding-top:2px;
	padding-bottom:2px;
}
.search_text:hover .search-main{background-color:#fe5621 !important;
	padding-top:2px;
	padding-bottom:2px;
}
.headerContainerWrapper {
	position: static;
	top: 0;
	left: 0;
	width: 100%;
	z-index:1000;
	-webkit-transition: top 500ms ease;
	-moz-transition: top 500ms ease;
	-o-transition: top 500ms ease;
	transition: top 500ms ease;

	/* enable hardware acceleration to fix laggy transitions */
/*	-webkit-transform: translateZ(0);
	-moz-transform: translateZ(0);
	-ms-transform: translateZ(0);
	-o-transform: translateZ(0);
	transform: translateZ(0);
*/}
.scrollActive .headerContainerWrapper {
	position: fixed;
}

.popover{ z-index:0;}
</style>
<script>
jQuery(document).ready(function($) {
$('.minimal-price-link').parent('.price-box').addClass('r-price-box');
});
</script>
<script type="text/javascript">
//<![CDATA[
/* jQuery(function ($) {
$('[data-toggle="tooltip"]').tooltip()
}) */

jQuery(document).ready(function($) {
setInterval(function() {
$('[data-toggle="tooltip"]').tooltip();
}, 99)
//$('[data-toggle="tooltip"]').tooltip();
// show-hidden login form 
$(".header-login .login-quick").hide();
$('.header-login a.login').click(function() {
$this = $(this);
$this.toggleClass("actived");
$(".login-quick").slideToggle("fast");
$('.mini-cartpro .block-content').css({
'display': 'none'
});
});

//style for select option, radio...
$("#chk_remember").uniform();
$("#product-options-wrapper select").uniform();
$("#toolbar-limit select").uniform();
$(".toolbar .select-inner select").uniform();

$(".cat-wrapper #cat").uniform();

//change select,option -> ul,li	
$("select").jqTransform();
$(".block-currency").jqTransform();
$(".language-switcher").jqTransform();
$(".language-switcher .jqTransformSelectWrapper").each(function() {
arr_bg = new Array();
arr_tit = new Array();
i = 0;
$(this).find('select option').each(function() {
arr_bg[i] = $(this).css('background-image');
arr_tit[i] = $(this).attr('title');
i++;
})
j = 0;
$(this).find('ul li').each(function() {
if (arr_bg[j] != "none") {
$(this).find('a').css('background-image', arr_bg[j]);
}
$(this).find('a').attr('title', arr_tit[j]);
j++;
});
});
$('.language-switcher .jqTransformSelectWrapper ul li a.selected,.language-switcher .jqTransformSelectWrapper div span').css('background-image', $('#select-language option[selected="selected"]').css('background-image'));
$('.language-switcher .jqTransformSelectWrapper div span').attr('title', $('#select-language option[selected="selected"]').attr('title'));

//custom js (theme config) 

});
//]]>
</script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$i = 0;
$('#yt_header .sm_megamenu_wrapper_vertical_menu .sm_megamenu_menu > li.sm_megamenu_lv1').each(function() {
$this = $(this);
$i++;
if ($i > 14) {
$this.css({
'display': 'none'
});
}
if ($i == 14) {
$('#yt_header .sm_megamenu_wrapper_vertical_menu .sm_megamenu_menu').append('');
}
});
})
</script>
<script type="text/javascript">
	// get header height (without border)
	var getHeaderHeight = $('.headerContainerWrapper').outerHeight();

	// border height value (make sure to be the same as in your css)
	var borderAmount = 2;

	// shadow radius number (make sure to be the same as in your css)
	var shadowAmount = 30;

	// init variable for last scroll position
	var lastScrollPosition = 0;

	// set negative top position to create the animated header effect
	$('.headerContainerWrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');

	$(window).scroll(function() {
		var currentScrollPosition = $(window).scrollTop();

		if ($(window).scrollTop() > 2 * (getHeaderHeight + shadowAmount + borderAmount) ) {

			$('body').addClass('scrollActive').css('padding-top', getHeaderHeight);
			$('.headerContainerWrapper').css('top', 0);

			if (currentScrollPosition < lastScrollPosition) {
				$('.headerContainerWrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');
			}
			lastScrollPosition = currentScrollPosition;

		} else {
			$('body').removeClass('scrollActive').css('padding-top', 0);
		}
	});
</script>
</head>
<body id="bd" class="cmspage1 sm_shoppy    cms-index-index cms-home">
<div id="yt_wrapper">
<!-- BEGIN: Header -->
<div id="yt_header" class="yt-header wrap">
<div class="headerContainerWrapper">
  <div class="header-v0">
    <div class="yt-header-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-5 sl-header-text">
            <div class="offer-wrapper">
              <div class="offer-header">
                <ul id="offer-slider">
                  <li>
				  	<span class="sp-ic fa fa-phone-square" style="color:#DF1F26;">&nbsp;</span>
					Telephone: 
					<a style="margin-right:15px;" title="Call:234-1-631-1306" href="tel:+23416311306">
						+234-1-631-1306
					</a> 
					<span class="sp-ic fa fa-envelope" style="color:#DF1F26;">&nbsp;</span>
					E-mail: 
						<a title="<?php echo $this->config->item('admin_email'); ?>" href="mailto:<?php echo $this->config->item('admin_email'); ?>">
						<?php echo $this->config->item('admin_email'); ?>
						</a>
				  </li>
                   <li><span class="sp-ic fa fa-phone-square" style="color:#DF1F26;">&nbsp;</span>Telephone: <a style="margin-right:15px;" title="Call:(1) 631 - 1305" href="tel:+23416311305 ">+234-1-631-1305 </a> <span class="sp-ic fa fa-home" style="color:#DF1F26;">&nbsp;</span>242A Alhaji Ganiyu Alimi Crescent, Gbagada Phase II Lagos</li>
                </ul>
                
              </div>
            </div>
          </div>
          <!-- LANGUAGE_CURENCY -->
<?php
$userId = $this->session->userdata('userId');
?>

<div class="col-lg-6 col-md-7 top-links-action">
	<div class="block-action-header top-link-account my-account-link">
		<ul>
			<?php
			if(empty($userId))
			{
			?>
			<li>
				<a data-toggle="modal" data-target="#modal-reg" class="account-toplink" title="Registration">
					<i class="fa fa-user"></i> &nbsp;SIGN UP
				</a>
				
			</li>	
			<?php
			}
			?>
        </ul>
    </div>
    <!-- MYLOGIN -->
    <div class="block-action-header top-link-account login-link">
    	<ul>
        	<li>
				<a href="http://helpdesk.pointemart.com" title="Help" target="_blank"> <i class="fa fa-question-circle"></i> 
					HELP
				</a> 
			</li>
			<?php
			if(!empty($userId))
			{
			?>
				<li> <a href="<?php echo base_url().'frontend/order'; ?>" title="Track Order"><i class="fa fa-map-marker"></i> TRACK ORDER</a> </li>
				<li> <a href="<?php echo base_url().'frontend/dashboard'; ?>" title="Dashboard"><i class="fa fa-dashboard"></i> DASHBOARD</a> </li>
				<li> <a href="<?php echo base_url().'auth/logout'; ?>" title="Logout"><i class="fa fa-key"></i> LOGOUT</a> </li>
			<?php
			}
			else
			{
			?>
				<li> 
					<a class="" data-toggle="modal" data-target="#modal-login" title="Track Order">
						<i class="fa fa-map-marker"></i> TRACK ORDER
					</a>
				</li>
				<li>
					<a class="login-btn" data-toggle="modal" data-target="#modal-login" title="Login">LOGIN</a>
                    
                      
                      
                     
                      
                </li>
				<?php
					
			}
			?>
              </ul>
            </div>
            <!-- END LOGIN -->
             <div class="action-mobile">
              <div class="block-action-header top-link-account my-account-link account-mobile-btn">
               <ul>
        	<li>
				<a href="http://helpdesk.pointemart.com" title="Help" target="_blank"> <i class="fa fa-question-circle"></i> 
					
				</a> 
			</li>
			<?php
			if(!empty($userId))
			{
			?>
				<li> <a href="<?php echo base_url().'frontend/order'; ?>" title="Track Order"><i class="fa fa-map-marker"></i> </a> </li>
				<li> <a href="<?php echo base_url().'frontend/dashboard'; ?>" title="Dashboard"><i class="fa fa-dashboard"></i> </a> </li>
				<li> <a href="<?php echo base_url().'auth/logout'; ?>" title="Logout"><i class="fa fa-key"></i> </a> </li>
			<?php
			}
			else
			{
			?>
				<li> 
					<a class="" data-toggle="modal" data-target="#modal-login" title="Track Order">
						<i class="fa fa-map-marker"></i>
					</a>
				</li>
				<li>
					<a class="login-btn" data-toggle="modal" data-target="#modal-login" title="Login"><i class="fa fa-lock"></i></a>
                </li>
				<?php
					
			}
			?>
              </ul>
                
              </div>
              <div class="block-action-header top-link-account login-link login-mobile-btn">
               <ul>
			<?php
			if(empty($userId))
			{
			?>
			<li>
				<a data-toggle="modal" data-target="#modal-reg" class="account-toplink" title="Registration">
					<i class="fa fa-user"></i>
				</a>
				
			</li>	
			<?php
			}
			?>
        </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="yt-header-middle">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-2 col-sm-2 logo-wrapper">
            <h1> <a title="PointeMart" href="<?php echo base_url(); ?>"> <img src="<?php echo base_url(); ?>images/new_images/red/logo.png" alt="PointeMart" /> </a> </h1>
          </div>
          <div class="col-lg-2 col-sm-1 col-md-1  pull-left parter"><span>In Partnership with <a href="http://www.unionbankng.com/" target="_blank" title="Union Bank"><img src="<?php echo base_url(); ?>images/new_images/home/logo-u.jpg" class="img-responsive" alt="Union Bank" width="30%" style="  display:inline-block;"></a></span></div>
          <div class="col-lg-8 col-md-9 col-sm-9 yt-megamenu logo-rightdiv" style="margin-top: 15px;">           
            <div class="yt-header-under">
              <div class="yt-menu">
                <!--<link media="all" href="" type="text/css" rel="stylesheet">-->
                <!--<link media="all" href="" type="text/css" rel="stylesheet">-->
                <div class="css_effect sm_megamenu_wrapper_horizontal_menu sambar" id="sm_megamenu_menu5592877ec8827" data-sam="5036795761435666302">
                  <div class="sambar-inner"> <a class="btn-sambar" data-sapi="collapse" href="#sm_megamenu_menu5592877ec8827"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> </div>
                </div>
                <!--End Module-->
              </div>
			   <div class="col-sm-10 header-three-img">
              	<div class="col-sm-4 col-xs-4 first-imgdiv">
                	<img  src="<?php echo base_url(); ?>images/new_images/pay_on_deli.png">
                    <span class="payontxt"><a href="<?php echo base_url(); ?>pointeforce/pay_on_delivery" target="_blank">PAY ON<br /> DELIVERY</a></span>
                </div>
                <div class="col-sm-4 col-xs-4 second-imgdiv">
                	<img  src="<?php echo base_url(); ?>images/new_images/make_money.png">
                    <span class="payontxt"><a href="<?php echo base_url(); ?>pointeforce" target="_blank">Make Money<br /> with PointeForce</a></span>
                </div>
                <div class="col-sm-4 col-xs-4 third-imgdiv">
                	<img  src="<?php echo base_url(); ?>images/new_images/sell_on_pointemart.png">
                    <span class="payontxt"><a href="http://seller.spacepointe.com/" target="_blank">Sell on <br /> Pointemart</a></span>
                </div>
              </div>
              <div class="mini-cart-header">
                
                <div class="block mini-cartpro sm-cartpro">
                  <div class="block-title">
                    <div class="btn-toggle">
                      
<?php
$buyNowCart        = 0;
$checkBuyNowCartId = 0;
$totalCarts    	   = count($this->cart->contents());
$ttl			   = $totalCarts;
$url               = 'javascript:void(0);';
$cartDet = '';
if(!empty($userId))
{
	$cartDet = $this->cart_m->get_user_cart($userId);
	if(!empty($cartDet))
	{
		$ttl = 1;		
	}
}

if($ttl)
{
	$url = base_url().'frontend/product_cart/cart_page';
}
?>

<a href="<?php echo $url; ?>" id="cartAnchor" title="Cart">
	<div class="info-mini-cart">
		<span><span id="totalProduct"><?php echo $ttl; ?></span> Items </span>
	</div>
</a>
		<div id="topCartCnt">
		</div>                
	</div>
</div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="yt-header-under-2">
      <div class="container">
        <div class="row yt-header-under-wrap">
          <div class="yt-main-menu col-md-12">
            <div class="header-under-2-wrapper">
              <div id="yt-responsivemenu" class="yt-responsivemenu">
                <button type="button" class="btn btn-navbar"> </button>
                <div id="yt_resmenu_sidebar">
<ul class="nav-menu clearfix">
	<?php
	if(!empty($categoryList))
	{
		foreach($categoryList as $key=>$level)
		{	
	?>
	<li class="level0 nav-11 parent" onMouseOver="toggleMenu(this,1)" onMouseOut="toggleMenu(this,0)">
		<a href="<?php echo frontend_grid_category_url($key,$level['levelName']); ?>">
			<span><?php echo $level['levelName']; ?></span>
		</a>
    	<?php
		if(!empty($level['nextLevel']))
		{
		?>
		<ul class="level0">
		<?php
			foreach($level['nextLevel'] as $key2=>$secondLevel)
			{
		?>		
        	<li class="level1 nav-11-1 first parent" onMouseOver="toggleMenu(this,1)" onMouseOut="toggleMenu(this,0)">
				<a href="<?php echo frontend_grid_category_url($key2,$secondLevel['levelName']); ?>">
					<span><?php echo $secondLevel['levelName']; ?></span> 
				</a>
				<?php
				if(!empty($secondLevel['nextLevel']))
				{
				?>
				<ul class="level1">
				<?php
					foreach($secondLevel['nextLevel'] as $key3=>$thirdLevel)
					{
				?>
						<li class="level2 nav-11-1-1 first"> 
							<a href="<?php echo frontend_grid_category_url($key3,$thirdLevel['levelName']); ?>">
								<span>
									<?php echo $thirdLevel['levelName']; ?>
								</span> 
							</a> 
						</li>
				<?php
					}
				?>
				</ul>
				<?php
				}
				?>
           </li>
		   <?php
			}
		?>
		</ul>
		<?php
		}
		?>
    </li>
<?php
		}
	}
?>
                  </ul>                  
                </div>
              </div>
              <div class="yt-searchbox-vermenu">
                <div class="row">
                  <div class="col-lg-3 col-md-3 vertical-mega">
                    <div class="ver-megamenu-header">
                      <!--<link media="all" href="" type="text/css" rel="stylesheet">-->
                      <!--<link media="all" href="" type="text/css" rel="stylesheet">-->
<div class="mega-left-title"> 
	<strong>Categories</strong>
</div>
<div class="css_effect sm_megamenu_wrapper_vertical_menu sambar hide-menus all-pages-leftmenu only-header-menu" id="sm_megamenu_menu559cda9bd26a4" data-sam="17752576091436342939">
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

                      <!--End Module-->
                    </div>
                  </div>

										<div class="search-pro col-lg-9 col-md-9 no-padding-l">
											<div id="sm_serachbox_pro378981551436342939" class="sm-serachbox-pro">
												<div class="sm-searbox-content">
													<?php 
													$attributes = array('id' => 'search_mini_form');
													echo form_open('',$attributes);
													?>
													<div class="form-search">
														<div class="input-search"> 
															<input type="text" class="typeahead tt-query search-text" name="all_search" id="search" onKeyUp="return not_submit(event,this.value);" onFocus="return not_submit(event,this.value);" autocomplete="off">
														</div>
														<button type="button" title="Search" class="icon-search button-search-pro form-button"> <i class="fa fa-search"></i></button>
													</div>
													</form>
												</div>
												<div>
													<ul id="autoSearchRes" class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" style="display:none; background:#fff !important; "></ul>
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
  		</div>
	</div>
</div>
<style>
.all-pages-leftmenu{position:absolute;
	padding:0;
}
.hide-menus{display:none;
	visibility:hidden;
	position:absolute;
	padding:0;
}

.sambar ul li{display:block !important;
}

#ui-id-1{display:none !important;
}

#autoSearchRes{
	
    
}

#autoSearchRes li:hover .search-main{/*background-color:#fe5621 !important*/
}

.search_text:hover{ /*color:#fff;*/}
</style>
<script type="text/javascript">
			// <![CDATA[


			jQuery(document).ready(function($) {

				$("#offer-slider").owlCarousel({
					autoPlay: true,
					navigation: false,
					pagination: false,
					slideSpeed: 300,
					paginationSpeed: 400,
					singleItem: true
				});

			});
			// ]]>
		</script>
<script type="text/javascript">
			//<![CDATA[
		   /* mincart = new CartForm('minicart-form_uq559cda9bcac60', '', 'checkout/cart/updatePost/index.html');
			minicartpro_id = '';
			if (typeof isShow == 'undefined') isShow = false;
			if (typeof isEffect == 'undefined') isEffect = false;
			if (typeof overEffect == 'undefined') overEffect = false;
			if (typeof outEffect == 'undefined') outEffect = false;*/
			//]]>
		</script>
<script type="text/javascript">
						//<![CDATA[
						jQuery(document).ready(function($) {
							$(".mini-cartpro .block-title .btn-toggle").click(function() {
								$('.mini-cartpro .block-content').slideToggle(300);
							});
						});

						//]]>
					</script>
<script type="text/javascript">
			jQuery(document).ready(function($) {
				var n = $('#minicart-sidebar li').length;
				//alert(n);
				if (n > 0) {
					$('.header-cart').addClass('have_item');
				}

				$("#minicart-sidebar .btn-remove").click(function() {
					$('body').addClass('delete-overlay');
				});
			});
		</script>
<script type="text/javascript">
					jQuery(document).ready(function($) {
						$('.sm-searchbox-more').click(function() {
							$('a.sm-searchbox-more').attr('data_count') == 10;
							var sb_ajaxurl = $('a.sm-searchbox-more').attr('data_sb_ajaxurl');
							var firt_load = 5;
							var count = $('a.sm-searchbox-more').attr('data_count');
							count = parseInt(count);
							if (firt_load >= count) {
								count = count + parseInt(firt_load);
							}
							$.ajax({
								type: 'POST',
								url: sb_ajaxurl,
								data: {
									is_ajax: 1,
									count_term: count,
									'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
								},
								success: function(data) {
									$('.sm-serachbox-pro').html(data.htm);
									$('a.sm-searchbox-more').attr({
										'data_count': count + parseInt(firt_load)
									});
								},
								dataType: 'json'
							});
						});
					});
				</script>
				
 

<script type="text/javascript">
<?php /*?>jQuery(document).ready(function($) {
$("#yt-totop").hide();
$(function() {
var wh = $(window).height();
var whtml = $(document).height();
$(window).scroll(function() {
if ($(this).scrollTop() > whtml / 10) {
$('#yt-totop').fadeIn();
} else {
$('#yt-totop').fadeOut();
}
});
$('#yt-totop').click(function() {
$('body,html').animate({
scrollTop: 0
}, 800);
return false;
});
});
});
$( document ).ajaxComplete(function() {
 $('.selectpicker').selectpicker();
});<?php */?>

</script>

<script>
$(".ver-megamenu-header").hover(function(){
        $('.all-pages-leftmenu').toggleClass('hide-menus');
});
</script> 

<script type="text/javascript">
				jQuery(document).ready(function($) {
					$('body#bd').append('<div class="yt_ressidebar_screennav"><nav id="yt_screennav"><ul class="siderbar-menu"></ul></nav></div>');
					$('#yt_screennav ul.siderbar-menu').html($('#yt_resmenu_sidebar ul.nav-menu').html());

					$('#yt-responsivemenu .btn.btn-navbar').click(function() {
						if ($('body#bd').hasClass('onpen-sidebar')) {
							$('body#bd').removeClass('onpen-sidebar');
							//$('.overlay_nav').remove();
						} else {
							$('body#bd').addClass('onpen-sidebar');
							//$('body#bd').append( "<div class='overlay_nav'></div>" );
						}
					});

					/* $('.overlay_nav').click(function(){
$('body#bd').removeClass('onpen-sidebar');
$(this).remove();
}); */
				});
			</script>
<!-- END: Header -->
<?php $this->load->view('success_error_message_frontend'); ?>
<!--Menu CLose-->

<style>
.first-popup h3{
	font-size: 10px !important;
    padding-bottom: 4px !important;
    padding-top: 4px !important;
    background-color: #F90202;
    color: #fff !important;
    padding-left: 5px;
}
.payontxt a{ line-height:22px;}
.selected a{     color: #ee4620;}
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>spacepointe</title>	
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/emplate_template/order_style.css" />-->
</head>
<body bgcolor="#E6E6E6" style="font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; margin:0; padding:0; font-size:14px; color:#344444;">
<!-- HEADER -->
<table class="head-wrap " style="max-width:600px; margin:0 auto; width:100%; " bgcolor="#FFFFFF">
	<tr>
		<td></td>
		<td class="header container"  style="max-width:600px; margin:0 auto;">				
				<div class="content" style="background-color:#fff;  border-bottom:4px solid #8CB94D; font-family:Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;">
				<table bgcolor="" class="" width="100%">
					<tr>
						<td><a href="<?php echo base_url(); ?>">
						<img class="logo-img" src="<?php echo base_url(); ?>images/email_template/email_logo.png" /></a></td>
                        <td style="background-color:#fff; font-size:11px; width:85px; text-align:center;" class="logo-right-section"><a href="#" style="color:#666; text-decoration:none;"><img src="<?php echo base_url(); ?>images/email_template/trace-icon.jpg"  width="30px"/><br />TRACK <br />ORDER</a></td>
                         <td style="background-color:#fff; font-size:11px; width:85px; text-align:center;" class="logo-right-section"><a href="#" style="color:#666; text-decoration:none;"><img src="<?php echo base_url(); ?>images/email_template/Support_Services.jpg"  width="30px"/><br />CUSTOMER
SUPPORT</a></td>
					</tr>
				</table>                
				</div>				
		</td>	
	</tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table class="body-wrap" style="max-width:600px; margin:0 auto; width:100%; " bgcolor="#FFFFFF">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF" style="padding:0 10px;">
			<div class="content">
			<table>
				<tr>
					<td>
						<h4 style="font-size:16px; font-weight:500;">Hi {name},</h4>
						<p class="lead">Greeting from Spacepointe !</p>
						<p>
							Your order (<span> {orderId}</span>) has been shipped and is on the way to you.
						</p>				
						
							<p>
							
								* You will be contacted prior delivery by our logistics officer by SMS or phone. This will happen within 24hrs for Lagos and within 72hrs for places outside Lagos.
								</p>
								<p>
								* After that our delivery associate (i.e. shipping vendor) will deliver the order to you. 
								</p>
													
					</td>                    
				</tr>
			</table>            
            <table>
				<tr>
					<td>
						<div class="" style="background:#f3f3f3; padding:12px; text-align:center;">
                        	<p>
                             For any enquiry, please contact our customer service team at <span style="color:#7daa3e; font-size:14px;">service@pointemart.com </span>or call us at 01263344 between 8am and 10pm on weekdays and 9am to 6pm on weekends. 
							 </p>
                        </div>
					</td>
				</tr>
			</table>            
               {tableData}
            <table class="footer-wrap" style="width:100%;">
	<tr>
		<td></td>
		<td class="container" style="width:100%;">			
				<!-- content -->
				<div class="" style="margin-top:8px;">
				<table style="width:100%;">
				<tr>
					<td align="center">
						<p>
							<a href="javascript:void(0);" style="color:#6c992d;">PointeMart.com</a> 
							
						</p>
					</td>
				</tr>
			</table>
				</div><!-- /content -->				
		</td>
		<td></td>
	</tr>
</table>            
			</div><!-- /content -->           
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->
<!-- FOOTER -->
<!-- /FOOTER -->
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>spacepointe</title>	
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/emplate_template/order_style.css" />
</head>
<body bgcolor="#E6E6E6">
<!-- HEADER -->
<table class="head-wrap " width="100%">
	<tr>
		<td></td>
		<td class="header container" >				
				<div class="content" style="background-color:#fff;  border-bottom:4px solid #8CB94D;">
				<table bgcolor="" class="" width="100%">
					<tr>
						<td><a href="<?php echo base_url(); ?>">
						<img class="logo-img" src="<?php echo base_url(); ?>images/email_template/email_logo.png" /></a></td>
                        <td style="background-color:#fff; font-size:11px; width:85px; text-align:center;" class="logo-right-section"><?php /*?><a href="#"><img src="<?php echo base_url(); ?>images/email_template/trace-icon.jpg"  width="30px"/><br />TRACK ORDER</a><?php */?></td>
                         <?php /*?><td style="background-color:#fff; font-size:11px; width:85px; text-align:center;" class="logo-right-section"><a href="#"><img src="<?php echo base_url(); ?>images/email_template/Support_Services.jpg"  width="30px"/><br />TRACK ORDER</a></td><?php */?>
					</tr>
				</table>                
				</div>				
		</td>	
	</tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table class="body-wrap" width="100%">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">
			<div class="content" >
			<table width="100%">
				<tr>
					<td>
						<h4 style="font-size:16px; font-weight:500;">Hi {name},</h4>
						<p class="lead">Greeting from Spacepointe !</p>
						<p>
							The order no. <span> {orderId}</span> has been delivered! Kindly contact retail sales team for update to retailer/merchant and obtain Proof of Delivery from shipping vendor.
							
						</p>
					</td>                    
				</tr>
			</table>            
                        
             
            <table class="footer-wrap" width="100%" style="border-bottom:1px solid #f9e2b2; border-top:1px solid #f9e2b2; margin-top:8px;">
          <tr>
            <td></td>
            <td class="container"><!-- content -->
              
             
                <table width="100%">
                	<tr>
                    	<td height="10"></td>
                    </tr>
                  <tr>
                      <td  style="color: #939393; font-size: 11px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;  line-height: 18px;" class="prefooter-subheader" align="center"><span style="color: #7087A3">Adress :</span><?php echo $this->config->item('admin_address'); ?>&nbsp;&nbsp;&nbsp; <span style="color: #7087A3">Phone :</span> <?php echo $this->config->item('admin_phone_no'); ?> &nbsp;&nbsp;&nbsp;<span style="color: #7087A3"><br>Email :</span><a href="mailto:<?php echo $this->config->item('admin_email'); ?>"><?php echo $this->config->item('admin_email'); ?></a></td>
                    </tr>
                  <tr>
                    <td align="center">
                    <p style="padding-top:10px;"><a style="display: inline-block; width: 16px;" href="https://www.facebook.com/SpacePointe" target="_blank"><img style="display: inline-block;" src="<?php echo base_url(); ?>img/email-img/fb-ico.jpg" alt="facebook" width="16"></a>
                    <a style="display: inline-block; width: 16px;" href="https://twitter.com/spacepointe" target="_blank"><img  style="display: inline-block;" src="<?php echo base_url(); ?>img/email-img/twitter-icon.jpg" alt="twitter" width="16"></a>
                    <a style="display: inline-block; width: 16px;" href="https://instagram.com/spacepointe" target="_blank"><img  style="display: inline-block;" src="<?php echo base_url(); ?>img/email-img/inst-icon.jpg" alt="twitter" width="16"></a> </p>
                    </td>
                  </tr>                    
                </table>
             
              <!-- /content --></td>
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
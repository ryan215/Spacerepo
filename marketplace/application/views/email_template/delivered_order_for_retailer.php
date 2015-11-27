<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PointeMart</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/emplate_template/order_style.css" />
</head>
<body bgcolor="#E6E6E6">

<!-- HEADER -->
<table class="head-wrap " width="100%">
  <tr>
    <td></td>
    <td class="header container" ><div class="content" style="background-color:#fff;  border-bottom:4px solid #8CB94D;">
        <table bgcolor="" class="" width="100%">
          <tr>
            <td><a href="<?php echo base_url(); ?>"> <img class="logo-img" src="<?php echo base_url(); ?>images/email_template/email_logo.png" /></a></td>
            <td style="background-color:#fff; font-size:11px; width:85px; text-align:center;" class="logo-right-section">
				<?php /*?><a href="<?php echo base_url(); ?>frontend/order">
					<img src="<?php echo base_url(); ?>images/email_template/trace-icon.jpg"  width="27px"/><br />
            		TRACK ORDER
				</a><?php */?>
			</td>
            
          </tr>
        </table>
      </div></td>
  </tr>
</table>
<!-- /HEADER --> 

<!-- BODY -->
<table class="body-wrap" width="100%">
  <tr>
    <td></td>
    <td class="container" bgcolor="#FFFFFF"><div class="content" >
        <table width="100%">
          <tr>
            <td><h4 style="font-size:16px; font-weight:500;">Hi {sellerName},</h4>
             
              <p>
              We are pleased to inform you that the following items for {orderId} have been delivered. 
              </p>
              <!--<p> Your order (<span> {orderId}</span>) has been Placed and is on the way to you. </p>-->
              </td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td><div class="" style="background:#f3f3f3; padding:12px; text-align:center;">
            <p>Should you have complaints or issues concerning the order, please contact our<br /> customer service team within 24hrs by email at <strong>care@pointemart.com</strong> or by phone<br /> at <strong>016311305</strong> & <strong>016311306</strong> from 8am to 10pm on weekdays and 9am to 6pm on weekdays.</p>
              </div></td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td><div class="" style="">
                <p> <span style="font-size:13px;"> The following order has been delivered: </span> </p>
                
              </div></td>
          </tr>
        </table>
		<table width="100%">
			<tr>
				<td>
					<div>
						<p style="background-color:#8CB94D; color:#fff !important; padding:1px 4px;">Seller:<span>
							{sellerName}
							</span>
						</p>
					</div>
				</td>
			</tr>
		</table>
		<table width="100%" class="order-table" style="border-bottom:2px solid #6d6d6d; padding-bottom:5px;"><tbody>
		<tr>
			<th colspan="2"> Item </th>
			<th style="text-align:center;"> Item price </th>
			<th style="text-align:center;"> Qty </th>
			<th style="text-align:right;"> Subtotal </th>
		</tr>
		<tr>
			<td  style="text-align:center;">
				<img src="{imagePath}" width="45px"></td>
				<td style="text-align:center;">{productName}<br />
				{color}                      {size}
				</td>
				<td style="text-align:center;">&#x20A6;{currentPrice}</td>
				<td style="text-align:center;">{quantity}</td>
				<td style="text-align:right;">&#x20A6;{subTotal}</td>
			</tr>
		</tbody></table>
        <table width="100%">
          <tr>
            <td style="color:#666; text-align:right; padding:5px 0;">Amount Paid :<span style="font-size:18px; color:#666;">&#x20A6;{totalAmount}</span></td>
          </tr>
        </table>
        <table width="100%">
          <tr>
            <td style="font-size:13px; color:#666;"> SHIPMENT DETAILS: </td>
          </tr>
          <tr>
            <td><h4 style="font-size:16px; margin-top:8px;">{customerName}  {customerPhone} </h4>
              <p>{shippingAddress}</p></td>
          </tr>
        </table>
        <!--<table width="100%" style="border-bottom:1px solid #f9e2b2; border-top:1px solid #f9e2b2; margin-top:8px;">
          <tr>
            <td><p style="font-size:12px;"> 
 <p style="font-size:12px;"> * You will be contacted prior delivery by our logistics officer by SMS or phone. This will happen within 24hrs for Lagos and within 72hrs for places outside Lagos.</p>

<p style="font-size:12px;"> * After that our delivery associate (i.e. shipping vendor) will deliver the order to you. </p>

<p style="font-size:12px;"> For any enquiry, please contact our customer service team at care@pointemart.com or call us at 01263344 between 8am and 10pm on weekdays and 9am to 6pm on weekends.
 </p></td>
          </tr>
        </table>-->
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
      </div>
      <!-- /content --></td>
    <td></td>
  </tr>
</table>
<!-- /BODY --> 

<!-- FOOTER --> 
<!-- /FOOTER -->
<style>
p.callout {
  padding: 8px;
  background-color: rgba(117,178,82,0.2);
  margin-bottom: 15px;
  text-align: center;
  font-size: 13px;
}
</style>
</body>
</html>
<table class="table table-custom" style=" width:962px;  height: 174px;margin-bottom:0px !important; margin:0 auto;  border:1px solid #000;">
	<tbody>
		<tr>
		<td width="33%" style="padding:0px !important;border: 1px solid #000"> 
				<table width="100%">
				<tr>
				<td style="  padding-top: 5px;  padding-bottom: 5px;">
					<center><img src="<?php echo base_url(); ?>images/email_template/logo1.png"  class="img-responsive" style="  width: 69%"/></center>
				</td>
				</tr>
				<tr>
				<td style="border-top:1px solid #000;  padding-top: 2px;  padding-bottom: 5px;">
					<h4 class="text-center" style="line-height:28px; color:#000; font-family: Verdana, Geneva, sans-serif;"> Order Id - <?php echo $result['customerOrderId']; ?></h4>
					</td>
				</tr>				
				</table>
				
		</td>
			<td width="33%" style="padding:0px !important;  border-bottom: 1px solid #000;border-top: 0px solid #000;"> 
				<table width="100%">
				<tr>
				<td width="40%" style="border: 1px solid #000; text-align:center; border-left:0; border-top:0 !important;" >
                <center><div id="qrCode">
                
                </div></center>
				</td>
				<td width="60%" style="border: 1px solid #000; border-right:0; border-top:0 !important;">
					<h4 style="line-height:27px;font-family: Verdana, Geneva, sans-serif; color:#000; padding-left:6px;">Tracking No. <?php echo $result['trackingNbr']; ?></h4>
				</td>
				</tr>
				<tr>
				<td colspan="2" style="border: 0px solid #000;">
					<table width="100%">
					<tr><td width="40%" style="color:#000; font-family: Verdana, Geneva, sans-serif; padding:6px 0 4px 6px; font-size:12px;">Shipping Vendor</td><td width="2%"> :</td><td width="58%" style="padding:6px 0 4px 6px; font-size:12px;font-family: Verdana, Geneva, sans-serif;"><?php echo $result['vendorBusinessName']; ?></td></tr><tr><td style="color:#000; font-family: 'Roboto', sans-serif; padding:6px 0 4px 6px; font-size:14px;">Contact No.</td><td>:</td><td style="padding:6px 0 4px 6px; font-size:12px;"><?php echo $result['vendorBusinessPhone']; ?></td></tr><tr><td style="color:#000; font-family: Verdana, Geneva, sans-serif; padding:6px 0 4px 6px; font-size:12px;">Seller</td><td>:</td><td style="padding:6px 0 4px 6px; font-size:12px; font-family: Verdana, Geneva, sans-serif;"><?php echo $result['retailerOrganizationName']; ?></td></tr>
					</table>
				</td>
					
				</tr>				
				</table>
			</td>
			<td width="33%" style="padding:0px !important;  border-left: 1px solid #000; border-bottom: 0px solid #000;border-top: 0px solid #000;"> 
				<table width="100%" style="border-top:0; ">
				<tr><td colspan="3" style="border-bottom:1px solid #000; padding-top:15px;  padding-bottom:18px;"><center><h4 style="line-height:28px; font-family: Verdana, Geneva, sans-serif; color:#000; padding-left:6px;">Shipping Address</h4></center></td></tr>
				<tr><td width="30%" style="color:#000; font-family: Verdana, Geneva, sans-serif; padding-left:6px;font-size:12px;">Name</td><td width="2%"> :</td><td width="68%" style="font-size:12px; font-family: Verdana, Geneva, sans-serif;"><?php 
					echo $result['customerShippFirstName'].' '.$result['customerShippLastName']; 
					?></td></tr>
				<tr><td style="color:#000; font-family: 'Roboto', sans-serif; padding-left:6px; font-size:14px;"">Phone No.</td><td>:</td><td  style="font-size:12px;"><?php echo $result['customerShippPhone']; ?></td></tr>
				<?php /*?><tr><td style="color:#000; font-family: 'Roboto', sans-serif; padding-left:6px; font-size:14px;"">Email Id</td><td>:</td><td style="font-size:12px;"><?php echo $result['customerEmail']; ?></td></tr><?php */?>
				<tr><td style="color:#000; font-family: Verdana, Geneva, sans-serif; padding-left:6px; font-size:12px;">Address</td><td>:</td><td style="font-size:12px; font-family: Verdana, Geneva, sans-serif;"><?php echo $result['shippingAddressLine1']; ?>  <?php echo $result['shippingAddressLine2']; ?> , <br /><?php echo $result['shippingCity']; ?>,<?php echo $result['shippingArea']; ?>,<?php echo $result['shippingState']; ?></td></tr>
				
				</table>
			</td>
		</tr>
	</tbody>
</table>		
<script src="<?php echo base_url(); ?>js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>js/qr_code/kendo.all.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">


<style>
 @page 
    {
        size: auto;   / auto is the initial value /
        margin: 0mm;  / this affects the margin in the printer settings /
    }
body{color:#494949 !important;
	font-size:12px !important;
}
th,td{
	border: 0px solid #000; padding:3px;  font-weight: bold;}
.table-custom {
  margin-top: 0px !important; 
  padding:0px !important;
 }
 
.table-custom tbody tr td { vertical-align:top !Important; background-color:#fff; border-radius:0;font-family: Verdana, Geneva, sans-serif; }
</style>
 
<script type="text/javascript">
$(document).ready(function () {
	$("#qrCode").kendoQRCode({
		value: "<?php echo $result['trackingNbr']; ?>",
        size: 75,
        color: "#000000",
        background: "transparent"
	});
});
</script>




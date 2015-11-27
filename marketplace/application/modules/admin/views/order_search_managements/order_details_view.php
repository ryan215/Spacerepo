<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Product Details </th>
        </tr>
      </thead>
      <tbody>
		<?php
		if(!empty($result['productList']))
		{
			foreach($result['productList'] as $row)
			{
		?>
      	<tr>
        	<td width="16%" style="background:none; padding:0;">
            	<table class="table table-invoice" style="margin:0; padding:0 !important; border-spacing:3px;">
                	<tr>
                    	<td class="text-center">
							<?php
						if((!empty($row['imageName']))&&(file_exists('uploads/product/thumb500_500/'.$row['imageName'])))
						{
						?>
            <a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r"> <img src="<?php echo base_url().'uploads/product/thumb500_500/'.$row['imageName']; ?>" style="width:150px; height:150px;" height="70" width="70"/> </a>
            <?php
						}
						elseif((!empty($row['imageName']))&&(file_exists('uploads/product/'.$row['imageName'])))
						{
						?>
            <a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r"> <img src="<?php echo base_url().'uploads/product/'.$row['imageName']; ?>" style="width:150px; height:150px;" height="70" width="70"/> </a>
            <?php
						}
						else
						{
						?>
            <a class="example-image-link" data-lightbox="example-1" href="javascript:void(0);" style="border-r"> <img src="<?php echo base_url().'img/no_image.jpg'; ?>" style="width:150px; height:150px;" height="70" width="70"/> </a>
            <?php
						}
						?>
                        </td>
                    </tr>
                </table>	
            </td>
            <td style="background:none; padding:0;">
             <table class="table table-invoice" style="margin:0; padding:0 !important; border-spacing:3px;">
             	<tr>
                	<td width="30%">Name: </td>
                    <td>
						<?php echo $row['productName']; ?>
					</td>
                </tr>
                <tr>
                	<td width="30%">Quantity: </td>
                    <td><?php echo $row['quantity']; ?></td>
                </tr>
				<?php
				if(!empty($row['colorCode']))
				{
				?>
        		<tr>
		          <td width="30%">Color: </td>
		          <td>
				  	<a class="btn btn-xs color_box active_color color_static" style="margin-left: 0px; margin-right: 0px;background-color:<?php echo $row['colorCode']; ?>" href="javascript:void(0);"/></a>
				</td>
		        </tr>
		        <?php
				}
				if(!empty($row['size']))
				{
				?>
				<tr>
				  <td width="30%">Size: </td>
				  <td><?php echo $row['size']; ?></td>
				</tr>
				<?php
				}
				if($row['totalRetailAmount'])
				{
				?>
		        <tr>
		          <td width="30%">Retailer Pay Back Price: </td>
		          <td>&#x20A6;<?php echo number_format(($row['totalRetailAmount']),2); ?></td>
		        </tr>
		        <?php
				}
				if($this->session->userdata('userType')!='retailer')
				{
				?>
                <tr>
                	<td width="30%">Product Price: </td>
                    <td><?php echo '&#x20A6;'.number_format(($row['totalProductAmount']),2); ?></td>
                </tr>
				<?php
				}
				?>
             </table>
            </td>
        </tr>
		<?php
			}
		}
		?>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>

<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;">Dropship Center Details</th>
        </tr>
      </thead>
      <tbody>
						<tr>
							<td width="35%">Name: </td>
							<td><?php echo $result['dropShipCenterName']; ?></td>
						</tr>											 
						<tr>
							<td width="35%">Address: </td>
							<td><?php echo $result['dropShipCenterAddress']; ?></td>
						</tr>											 
					</tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<?php
if($this->session->userdata('userType')!='retailer')
{
?>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Payment Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">Order Type: </td>
          <td>
		  	<?php
			if($result['isEconomicDelivery']==1)
			{
				echo 'Single Shippment';
			}
			elseif($result['isEconomicDelivery']==2)
			{
				echo 'Same Day Delivery';
			}
			else
			{
				echo 'Quick Shippment';
			}
			?>
		  </td>
        </tr>
        <tr>
          <td width="35%">Order Status: </td>
          <td>
		  	<?php 
			if($result['isPickup'])
			{
				if($result['orderStatusId']==1)
				{
					echo 'New Pick up Order';
				}
				elseif($result['orderStatusId']==2)
				{
					echo 'Confirm Pick up Order';
				}
				elseif($result['orderStatusId']==3)
				{
					echo 'Ready To Pick up Order';
				}
				elseif($result['orderStatusId']==5)
				{
					echo 'Picked Up Order';
				}
			}
			else
			{
				if($result['orderStatusId']==1)
				{
					echo 'New Order';
				}
				elseif($result['orderStatusId']==2)
				{
					echo 'Confirm Order';
				}
				elseif($result['orderStatusId']==3)
				{
					echo 'Ready To Shipped Order';
				}
				elseif($result['orderStatusId']==4)
				{
					echo 'Shipped In Transit Order';
				}
				elseif($result['orderStatusId']==5)
				{
					echo 'Delivered Order';
				}
			}
		  	?>
		  </td>
        </tr>
        <tr>
          <td width="35%">Payment Mode: </td>
          <td>
		  	<?php 
		  	if($result['paymentStatus'])
			{
				echo 'Pay Online';
			}
			else
			{
				echo 'Cash On Delivery';
			}
		   ?>
		   </td>
        </tr>
        <tr>
          <td width="35%">Total Amounts: </td>
          <td><?php echo '&#x20A6;'.number_format($result['totalCustomAmount'],2); ?></td>
        </tr>
		<?php
		if($result['isPickup'])
		{
		?>
        <tr>
          <td width="35%">Pickup Process Amt: </td>
          <td><?php echo '&#x20A6;'.number_format($result['totalCustomPickupProccessAmount'],2); ?></td>
        </tr>
		<?php		
		}
		else
		{
			if($result['paymentStatus'])
			{}
			else
			{
			?>
	        <tr>
    	      <td width="35%">Cash Handling Fee: </td>
        	  <td><?php echo '&#x20A6;'.number_format($result['totalCustomCashHandlingAmount'],2); ?></td>
	        </tr>
    	    <?php
			}
			if($result['totalCustomShippingAmount'])
			{
			?>
			<tr>
			  <td width="35%">Shipping Rate: </td>
			  <td><?php echo '&#x20A6;'.number_format($result['totalCustomShippingAmount'],2); ?></td>
			</tr>
			<?php
			}
		}
		?>        
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<?php
?>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Retailer Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">Bussiness Name: </td>
          <td><?php echo $result['retailerOrganizationName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Email: </td>
          <td><?php echo $result['retailerEmail']; ?></td>
        </tr>
        <tr>
          <td width="35%">First Name: </td>
          <td><?php echo $result['retailerFirstName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Middle Name: </td>
          <td><?php echo $result['retailerMiddle']; ?></td>
        </tr>
        <tr>
          <td width="35%">Last Name: </td>
          <td><?php echo $result['retailerLastName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Bussiness Phone No: </td>
          <td><?php echo $result['retailerBusinessPhone']; ?></td>
        </tr>
        <tr>
          <td width="35%">User Name: </td>
          <td><?php echo $result['retailerUserName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Address1: </td>
          <td><?php echo $result['retailerAddressLine1']; ?></td>
        </tr>
        <tr>
          <td width="35%">Country Name: </td>
          <td><?php echo $result['retailerCountryName']; ?></td>
        </tr>
        <tr>
          <td width="35%">State Name: </td>
          <td><?php echo $result['retailerStateName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Area Name: </td>
          <td><?php echo $result['retailerAreaName']; ?></td>
        </tr>
        <tr>
          <td width="35%">City Name: </td>
          <td><?php echo $result['retailerCityName']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Customer Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">First Name: </td>
          <td><?php echo $result['customerFirstName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Last Name: </td>
          <td><?php echo $result['customerLastName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Email: </td>
          <td><?php echo $result['customerEmail']; ?></td>
        </tr>
        <tr>
          <td width="35%">Phone Number: </td>
          <td><?php echo $result['customerPhone']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Shipping vendor Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">Business Name: </td>
          <td><?php echo $result['vendorBusinessName']; ?></td>
        </tr>
        <tr>
          <td width="35%">First Name: </td>
          <td><?php echo $result['vendorFirstName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Last Name: </td>
          <td><?php echo $result['vendorLastName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Email: </td>
          <td><?php echo $result['vendorEmail']; ?></td>
        </tr>
        <tr>
          <td width="35%">Phone No: </td>
          <td><?php echo $result['vendorBusinessPhone']; ?></td>
        </tr>
        <tr>
          <td width="35%">Street: </td>
          <td><?php echo $result['vendorAddressLine1']; ?></td>
        </tr>
        <tr>
          <td width="35%">Country Name: </td>
          <td><?php echo $result['vendorCountryName']; ?></td>
        </tr>
        <tr>
          <td width="35%">State Name: </td>
          <td><?php echo $result['vendorStateName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Area Name: </td>
          <td><?php echo $result['vendorAreaName']; ?></td>
        </tr>
        <tr>
          <td width="35%">City Name: </td>
          <td><?php echo $result['vendorCityName']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Billing Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">First Name: </td>
          <td><?php echo $result['customerBillFirstName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Last Name: </td>
          <td><?php echo $result['customerBillLastName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Phone No.: </td>
          <td><?php echo $result['customerBillPhone']; ?></td>
        </tr>
        <tr>
          <td width="35%">Country Name: </td>
          <td><?php echo $result['billingCountry']; ?></td>
        </tr>
        <tr>
          <td width="35%">State Name: </td>
          <td><?php echo $result['billingState']; ?></td>
        </tr>
        <tr>
          <td width="35%">Area Name: </td>
          <td><?php echo $result['shippingArea']; ?></td>
        </tr>
        <tr>
          <td width="35%">City Name: </td>
          <td><?php echo $result['billingCity']; ?></td>
        </tr>
        <tr>
          <td width="35%">Address1: </td>
          <td><?php echo $result['billingAddressLine1']; ?></td>
        </tr>
        <tr>
          <td width="35%">Address2: </td>
          <td><?php echo $result['billingAddressLine2']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<aside class="profile-nav col-lg-12">
  <div class="col-sm-12 padding_zero" style="padding-left: 5px;">
    <table class="table table-invoice table-custom" style="">
      <thead>
        <tr>
          <th colspan="2" style="background-color:#A9D86E; color:#FFF;"> Shipping Details </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="35%">First Name: </td>
          <td><?php echo $result['customerShippFirstName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Last Name: </td>
          <td><?php echo $result['customerShippLastName']; ?></td>
        </tr>
        <tr>
          <td width="35%">Phone No.: </td>
          <td><?php echo $result['customerShippPhone']; ?></td>
        </tr>
        <tr>
          <td width="35%">Country Name: </td>
          <td><?php echo $result['shippingCountry']; ?></td>
        </tr>
        <tr>
          <td width="35%">State Name: </td>
          <td><?php echo $result['shippingState']; ?></td>
        </tr>
        <tr>
          <td width="35%">Area Name: </td>
          <td><?php echo $result['shippingArea']; ?></td>
        </tr>
        <tr>
          <td width="35%">City Name: </td>
          <td><?php echo $result['shippingCity']; ?></td>
        </tr>
        <tr>
          <td width="35%">Address1: </td>
          <td><?php echo $result['shippingAddressLine1']; ?></td>
        </tr>
        <tr>
          <td width="35%">Address2: </td>
          <td><?php echo $result['shippingAddressLine2']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</aside>
<div class="clearfix"></div>
<?php
}
?>
<style>
.color_box {margin-right:5px;  border: 2px #eee solid; padding:15px;}
.color_static {   padding: 8px;margin-left: 5px; }
</style>

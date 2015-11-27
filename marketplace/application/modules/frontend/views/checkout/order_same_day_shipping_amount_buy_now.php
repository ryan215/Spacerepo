<h5 class="grand_total opc-review-actions">Grand Total
	<span class="price" id="grandTotal">
		<?php echo '&#8358;'.number_format($totalAmount,2); ?>			
	</span>
</h5>

<div id="payCashBtn" style="display:inline-block;">
	<?php
	/*$isBlackList = 0;
	$customerDet = $this->customer_m->black_list_customer_detail($this->session->userdata('userId'));
	$this->custom_log->write_log('custom_log','customer details is '.print_r($customerDet,true));
	if(!empty($customerDet))
	{
		$isBlackList = $customerDet->isBlackList;
	}
	$this->custom_log->write_log('custom_log','customer is in black list '.$isBlackList);
	if($isBlackList==0)
	{
		if((!empty($productTypeId))&&($productTypeId==3))
		{
		}
		else
		{
	?>	
	<div class="col-xs-12 pd">		
		<a href="javascript:void(0);" class="button btn btn-placeorder-sub" onclick="same_day_cash_on_delivery();" style="line-height:51px; margin-right:0; border:0; color:#fff;">
			Cash On Delivery
		</a>
	</div>
	<div class="col-xs-12 pd">
<?php
		}
	}
	*/
$order_total  = $totalAmount*100;
$order_total  = round($order_total);
$redirect_url = payment_redirect_same_day_buy_now_delivery($order_total,$cartId);
$product_id   = static_product_id();
$txn_ref      = txt_reference($this->session->userdata('userId'));
$pay_item_id  = pay_item_id();
$mac_key      = mac_key();
$hash 		  = $txn_ref.$product_id.$pay_item_id.$order_total.$redirect_url.$mac_key;
$hash 		  = hash("sha512",$hash);

$attributes = array('id' => 'webpay_payment_form','target' => '_top');
echo form_open('https://stageserv.interswitchng.com/test_paydirect/pay',$attributes);	//	Sandbox 
//echo form_open('https://webpay.interswitchng.com/paydirect/pay',$attributes);	//	Live
?>
	<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
	<input type="hidden" name="amount" value="<?php echo $order_total; ?>">	
	<input type="hidden" name="currency" value="<?php echo currency_value(); ?>">
	<input type="hidden" name="site_redirect_url" value="<?php echo $redirect_url; ?>">
	<input type="hidden" name="txn_ref" value="<?php echo $txn_ref; ?>">			
	<input type="hidden" name="hash" value="<?php echo $hash;?>">
	<input type="hidden" name="pay_item_id" value="<?php echo $pay_item_id; ?>">
	<input type="hidden" name="cust_name" value="<?php echo $this->session->userdata('userName'); ?>">
	<input type="hidden" name="cust_name_desc" value="Customer Name">
	<input type="hidden" name="cust_id" value="<?php echo $this->session->userdata('userId'); ?>">
	<input type="hidden" name="cust_id_desc" value="Transaction Reference">
				<!-- Button Fallback -->
	<div class="payment_buttons">
    	<input type="submit" id="submit_webpay_payment_form" class="button btn btn-placeorder-sub" value="Pay Online" onclick="return authentic();" style="margin-left: 0px !important; margin-right:0; border:0; color:#fff;">
    </div>	
</form>
</div>
</div>
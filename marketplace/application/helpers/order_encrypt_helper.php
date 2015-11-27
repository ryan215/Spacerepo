<?php 
function order_encrypt($str)
{
	return $str*55;
}	
	
function order_decrypt($str)
{
	return $str/55;
}

function token_refrence()
{
	return uniqid();
}

function txt_reference($str)
{
	return time()*$str;
}

function payment_redirect_same_day_buy_now_delivery($total_amount=0,$cartId='')
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_same_day_buy_now_delivery/'.$total_amount.'/'.id_encrypt($cartId);
	return $redirect_url;
}

function payment_redirect_same_day_add_to_cart_delivery($total_amount=0)
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_same_day_add_to_cart_delivery/'.$total_amount;
	return $redirect_url;
}


function payment_redirect_buy_now_delivery($total_amount=0,$cartId='')
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_buy_now_delivery/'.$total_amount.'/'.id_encrypt($cartId);
	return $redirect_url;
}

function payment_redirect_buy_now_pickup($total_amount=0,$cartId='')
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_buy_now_pickup/'.$total_amount.'/'.id_encrypt($cartId);
	return $redirect_url;
}

function payment_redirect_add_to_cart_delivery($total_amount=0)
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_add_to_cart_delivery/'.$total_amount;
	return $redirect_url;
}

function payment_redirect_add_to_cart_pickup($total_amount=0)
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_add_to_cart_pickup/'.$total_amount;
	return $redirect_url;
}

function payment_redirect_buy_now_economical_delivery($total_amount=0,$cartId='')
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_buy_now_economical_delivery/'.$total_amount.'/'.id_encrypt($cartId);
	return $redirect_url;
}

function payment_redirect_add_to_cart_economical_delivery($total_amount=0)
{
	$redirect_url = base_url().'frontend/checkout_payment/order_complete_add_to_cart_economical_delivery/'.$total_amount;
	return $redirect_url;
}

function pay_item_id()
{
	return 101;	// Sandbox
	//return 101;	// Live
}

function mac_key()
{
	return '199F6031F20C63C18E2DC6F9CBA7689137661A05ADD4114ED10F5AFB64BE625B6A9993A634F590B64887EEB93FCFECB513EF9DE1C0B53FA33D287221D75643AB';	// Sandbox
	//return '269513DB7AA6BA0071315A9AB5539E83F8C48060B9482F58ADB5D00D25884D146237F18DA0205EA4F48A30AA755FB72CA814D1E5F614A6099D29A98B46FDCB7F';	// Live
}

function currency_value()
{
	return 566;
}

function static_product_id()
{
	return 4220; // Sandbox
	//return 4989;  // Live
}
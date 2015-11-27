<?php
function password_encrypt($str)
{
	return md5($str);
}

function id_encrypt($str)
{
	return $str*55;
}	
	
function id_decrypt($str)
{
	return $str/55;
}

function new_random_password()
{
	return mt_rand();
}

function role_list()
{
	$roles_list = array(
					'retailer_management'       => 'Retailer Management',
					'category_brand_management' => 'Category ,Brand & Location Management',
					'product_management'        => 'Product Management',
					'shipping_management'       => 'Shipping Management',
					'marketing_management'      => 'Marketing Management'
				  );	
				  
	return $roles_list;
}

function getRandomUserName()
{
	$an = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $su = strlen($an)-1;
    return substr($an,rand(0,$su),1).substr($an,rand(0,$su),1).substr($an,rand(0,$su),1).substr($an,rand(0,$su),1).substr($an,rand(0,$su),1).substr($an,rand(0,$su),1);
}

function otp5_digit()
{
	$value = rand(10000,99999);
	return $value;
}
?>
<?php
function add_shipping_rate_rules()
{
	$rules = array(	
				array(
					'field' => 'dropShipCenter[]',
					'label' => 'Dropship Center',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId[]',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
			);
	return $rules;		
}

function compose_mail_rules()
{
	$rules = array(	
				array(
					'field' => 'subject',
					'label' => 'Subject',
					'rules' => 'trim|required|min_length[5]'
				),
				array(
					'field' => 'compose_mail',
					'label' => 'Message',
					'rules' => 'trim|required|min_length[5]'
				),
			);
	return $rules;		
}

function initiate_payment_rules()
{
	$rules = array(	
				array(
					'field' => 'bankName',
					'label' => 'Bank Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'accountHolderName',
					'label' => 'Account Holder Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'accountNumber',
					'label' => 'Account Number',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;		
}

function reference_number_rules()
{
	$rules = array(	
				array(
					'field' => 'referenceNumber',
					'label' => 'Reference Number',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;
}

function customer_pointe_force_request_rules()
{
	$rules = array(	
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}


function add_pseudo_product_rules()
{
	$rules = array(	
				array(
					'field' => 'product_price',
					'label' => 'Product Price',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;		
}

function add_free_shipping_category_rules()
{
	$rules = array(	
				array(
					'field' => 'level1',
					'label' => 'category level1',
					'rules' => 'trim|required'
				),
			);
	return $rules;		
}

function add_free_shipping_product_rules()
{
	$rules = array(	
				array(
					'field' => 'level1',
					'label' => 'category level1',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'productList[]',
					'label' => 'Product List',
					'rules' => 'trim|required'
				),				
			);
	return $rules;		
}

function add_edit_price_management_rules()
{
	$rules = array(	
				array(
					'field' => 'fromPrice',
					'label' => 'From Price',
					//'rules' => 'trim|required|is_natural'
					'rules' => 'trim|required|numeric|callback_check_positive_number'
				),
				array(
					'field' => 'toPrice',
					'label' => 'To Price',
					'rules' => 'trim|required|numeric|callback_check_price_validation'
				),
				array(
					'field' => 'spacePointeCommission',
					'label' => 'Space Pointe Commission',
					'rules' => 'trim'
				),
				array(
					'field' => 'cashFee',
					'label' => 'Cash Fee',
					'rules' => 'trim|required'
				),
				/*array(
					'field' => 'adminPrice',
					'label' => 'Cash Admin Fee',
					'rules' => 'trim'
				),
				array(
					'field' => 'GenuineShippingFee',
					'label' => 'Genuine Shipping Fee',
					'rules' => 'trim'
				),	*/							
			 );
	return $rules;
}

function add_shipping_rates_from_10_to_30_rules()
{
	$rules = array(	
				array(
					'field' => 'shippingRate',
					'label' => 'Shipping Rates',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'estimateTime',
					'label' => 'Estimated Time of Delivered',
					'rules' => 'trim|required|numeric'
				),
			 );
	return $rules;
}

function check_captcha_rules()
{
	$rules = array(	
				array(
					'field' => 'captchaVal',
					'label' => 'Capthca Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'imageCaptcha',
					'label' => 'Captch Value',
					'rules' => 'trim|required|matches[captchaVal]'
				),
			 );
	return $rules;
}

function edit_category_commission_rules()
{
	$rules = array(
				array(
					'field' => 'categoryCommission',
					'label' => 'Category Commission',
					'rules' => 'trim|required|numeric'
				)
			);
	return $rules;
}

function edit_sell_price_rules()
{
	$rules = array(	
				array(
					'field' => 'sellPrice',
					'label' => 'Sell Price',
					'rules' => 'trim|required|numeric|is_natural_no_zero'
				),
				array(
					'field' => 'spacePointComisson',
					'label' => 'Space Point Comission',
					'rules' => 'trim|required|numeric'
				),				
				array(
					'field' => 'retailerPrice',
					'label' => 'Retailer Will Be Getting',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'displayPrice',
					'label' => 'Display Price',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;	
}

function marketing_sign_in_rules()
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function customer_upd_profile_rules()
{
$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'street',
					'label' => 'Street',
					'rules' => 'trim'
				),
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]'
				),
				/*array(
					'field' => 'zipcode',
					'label' => 'Zip Code',
					'rules' => 'trim|required|integer'
				),*/
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim'
				),	
			);
	return $rules;
}

function customer_update_profile_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'street',
					'label' => 'Street',
					'rules' => 'trim|required|callback_alpha_numeric_space'
				),
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]'
				),
				/*array(
					'field' => 'zipcode',
					'label' => 'Zip Code',
					'rules' => 'trim|required|integer'
				),*/
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),	
			);
	return $rules;
}

function retailer_reset_password_rules()
{
	$rules = array(	
				array(
					'field' => 'businessPhone',
					'label' => 'Phone No.',
					'rules' => 'trim|required|numeric|min_length[10]'
				),
			);
	return $rules;
}

function product_declined_rules()
{
	$rules = array(	
				array(
					'field' => 'decline',
					'label' => 'Decline Reason',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function subscription_news_rules()
{
	$rules = array(	
				array(
					'field' => 'name1',
					'label' => 'Name1',
					'rules' => 'trim|callback_check_name1'
				),
				array(
					'field' => 'email1',
					'label' => 'Email1',
					//'rules' => 'trim|required|valid_email|is_unique[newsletter_subscription.subscription_email]|is_unique[newsletter.email]'
					'rules' => 'trim|required|valid_email|callback_check_email1'
				),	
				array(
					'field' => 'name2',
					'label' => 'Name2',
					'rules' => 'trim'
				),
				array(
					'field' => 'email2',
					'label' => 'Email2',
					'rules' => 'trim|valid_email|callback_check_email2'
				),	
				array(
					'field' => 'name3',
					'label' => 'Name3',
					'rules' => 'trim'
				),
				array(
					'field' => 'email3',
					'label' => 'Email3',
					'rules' => 'trim|valid_email|callback_check_email3'
				),	
				array(
					'field' => 'name4',
					'label' => 'Name4',
					'rules' => 'trim'
				),
				array(
					'field' => 'email4',
					'label' => 'Email4',
					'rules' => 'trim|valid_email|callback_check_email4'
				),	
				array(
					'field' => 'name5',
					'label' => 'Name5',
					'rules' => 'trim'
				),
				array(
					'field' => 'email5',
					'label' => 'Email5',
					'rules' => 'trim|valid_email|callback_check_email5'
					//'rules' => 'trim|required|valid_email|is_unique[newsletter_subscription.subscription_email]|callback_check_email'
				),	
			);	
	return $rules;
}

function shippin_rate_edit_rules()
{
	$rules = array(	
				array(
					'field' => 'shippRate',
					'label' => 'Shipping Rate',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;		
}

function employee_sign_up()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'salary',
					'label' => 'Salary',
					'rules' => 'trim|required|numeric'
				),	
				array(
					'field' => 'phoneNo',
					'label' => 'Phone no',
					'rules' => 'trim|required|numeric|min_length[10]|callback_check_businessPhone'
					),	
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'role[]',
					'label' => 'Role',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'designation',
					'label' => 'Designation',
					'rules' => 'trim|required'
				),				
			);	
	return $rules;
}

function newsletter_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[newsletter.email]|is_unique[customer.email]'
				),	
				array(
					'field' => 'phone',
					'label' => 'Phone no',
					'rules' => 'trim|required|numeric|min_length[10]|callback_check_phone'
					),	
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'gender',
					'label' => 'Gender',
					'rules' => 'trim|required'
				),
			);	
	return $rules;


}

function retailer_accept_rules()
{
	$rules = array(	
				array(
					'field' => 'dropship',
					'label' => 'Dropship Center',
					'rules' => 'trim|required'
				),
			);
}

function update_shipping_vendor_rules()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone Number',
					'rules' => 'trim|numeric|min_length[10]|callback_check_businessPhone'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim'
				),
			);	
	return $rules;

}

function shipping_vendor_sign_up()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|callback_check_unique_vendor_user'
				),	
			
				array(
					'field' => 'countryCode',
					'label' => 'Country Code',
					'rules' => 'trim|required'
					),	
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone Number',
					'rules' => 'trim|numeric|min_length[10]|callback_check_businessPhone'
				),
				/*array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
					),*/
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim'
				),
			);	
	return $rules;
}

function left_slider_rules()
{
	$rules = array(	
				array(
					'field' => 'left_image',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'left_image2',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'urllink1',
					'label' => 'Link',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'urllink2',
					'label' => 'Link',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function right_slider_rules()
{
	$rules = array(	
				array(
					'field' => 'left_image',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'left_image2',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'left_image3',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'urllink1',
					'label' => 'Link',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'urllink2',
					'label' => 'Link',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'urllink3',
					'label' => 'Link',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}


function update_phone_verification_rules()
{
	$rules = array(	
				array(
					'field' => 'countryCode',
					'label' => 'Country Code',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone No',
					'rules' => 'trim|required|numeric|min_length[10]|callback_check_businessPhone'
				),
			);
	return $rules;
}

function phone_verification_rules()
{
	$rules = array(	
				array(
					'field' => 'otp[]',
					'label' => 'OTP',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function retailer_declined_rules()
{
	$rules = array(	
				array(
					'field' => 'comment',
					'label' => 'Reason',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function edit_inventory_rules()
{
	$rules = array(	
				array(
					'field' => 'editinventory',
					'label' => 'Edit Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'inventory',
					'label' => 'Inventory',
					'rules' => 'trim|required|integer|callback_check_inventory'
				),
			);
	return $rules;		
}

function add_inventory_rules()
{
	$rules = array(	
				array(
					'field' => 'stock',
					'label' => 'Add Stock',
					'rules' => 'trim|required|integer'
				),
				array(
					'field' => 'sellPrice',
					'label' => 'Sell Price',
					'rules' => 'trim|required|numeric|is_natural_no_zero'
				),
				array(
					'field' => 'spacePointComisson',
					'label' => 'Space Point Comission',
					'rules' => 'trim|required|numeric'
				),				
				array(
					'field' => 'retailerPrice',
					'label' => 'Retailer Will Be Getting',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'displayPrice',
					'label' => 'Display Price',
					'rules' => 'trim|required|numeric'
				),
			 );
	return $rules;
}

function add_product_inventory_rules()
{
	$rules = array(	
				array(
					'field' => 'stock',
					'label' => 'Add Stock',
					'rules' => 'trim|required|integer'
				),
				array(
					'field' => 'retailerQuotePrice',
					'label' => 'Retailer Quoted Price',
					'rules' => 'trim|required|numeric|is_natural_no_zero'
				),
				array(
					'field' => 'retailerPrice',
					'label' => 'Retailer Price',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'spacePointeCommission1',
					'label' => 'SpacePointe Comission1',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'spacePointeCommission2',
					'label' => 'SpacePointe Comission2',
					'rules' => 'trim|required|numeric'
				),				
				array(
					'field' => 'cashAdminPrice',
					'label' => 'Cash Admin Price',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'displayPrice',
					'label' => 'Display Price',
					'rules' => 'trim|required|numeric'
				),
			 );
	return $rules;
}

function edit_product_inventory_rules()
{
	$rules = array(	
				array(
					'field' => 'retailerQuotePrice',
					'label' => 'Retailer Quoted Price',
					'rules' => 'trim|required|numeric|is_natural_no_zero'
				),
				array(
					'field' => 'retailerPrice',
					'label' => 'Retailer Price',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'spacePointeCommission1',
					'label' => 'SpacePointe Comission1',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'spacePointeCommission2',
					'label' => 'SpacePointe Comission2',
					'rules' => 'trim|required|numeric'
				),				
				array(
					'field' => 'cashAdminPrice',
					'label' => 'Cash Admin Price',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'displayPrice',
					'label' => 'Display Price',
					'rules' => 'trim|required|numeric'
				)
			);
	return $rules;
}


function retailer_first_login_rules()
{
	$rules = array(	
				array(
					'field' => 'userName',
					'label' => 'User Name',
					'rules' => 'trim|required|callback_check_username'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[5]'
				),
				array(
					'field' => 'confPassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|min_length[5]|matches[password]'
				),
			 );
	return $rules;
}

function assign_cse_rules()
{
	$rules = array(	
				array(
					'field' => 'cseId',
					'label' => 'CSE Name',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}

function retailer_sign_up($userType)
{
	$rules = array(	
				/*array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),*/
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email|is_unique[employee.email]'
				),	
				array(
					'field' => 'businessName',
					'label' => 'Business Name',
					'rules' => 'trim|required'
				),	
				/*array(
					'field' => 'countryCode',
					'label' => 'Country Code',
					'rules' => 'trim|required'
					),	*/
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone Number',
					'rules' => 'trim|required|numeric|min_length[10]|callback_check_businessPhone'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
					),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim|required'
				),
			);	
	
	if(($userType=='superadmin')||($userType=='admin')||($userType=='cse'))
	{
		$rules[] = array(
						'field' => 'dropshipCentre',
						'label' => 'Dropship Center',
						'rules' => 'trim|required'
					);
	}
	else		
	{
		$rules[] = array(
					'field' => 'userName',
					'label' => 'User Name',
					'rules' => 'trim|required|alpha_numeric|min_length[5]|is_unique[employee.userName]'
					);
		$rules[] =	array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[5]'
				);
		$rules[] = array(
					'field' => 'confPassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				);	
		$rules[] =	array(
					'field' => 'accept',
					'label' => 'Accept Term & Condition',
					'rules' => 'trim|required'
				);
		
	}
	return $rules;
}

function update_retailer_rules()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),	
				/*array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),*/			
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'businessName',
					'label' => 'Business Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone Number',
					'rules' => 'trim|required|numeric|min_length[10]|callback_update_check_businessPhone'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email|callback_email_exits'
				),	
				array(
					'field' => 'dropshipCentre',
					'label' => 'Dropship Centre',
					'rules' => 'trim|required'
					)						
			);	
	
	return $rules;
}
function pointepay_update_retailer_rules()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),	
				/*array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),*/			
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'businessName',
					'label' => 'Business Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'businessPhone',
					'label' => 'Business Phone Number',
					'rules' => 'trim|required|numeric|min_length[10]|callback_update_check_businessPhone'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email|callback_email_exits'
				),	
								
			);	
	
	return $rules;
}

function update_cse_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),	
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim'
				),			
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'date',
					'label' => 'Birth Date',
					'rules' => 'trim'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim'
				),
				array(
					'field' => 'dropshipCentre[]',
					'label' => 'DropshipCentre',
					'rules' => 'trim|required'
				),
			);	
	return $rules;
}

function update_admin_own_profile()
{
	$rules = array(	
						array(
								'field' => 'imageName',
								'label' => 'Image Name',
								'rules' => 'trim'
							),
							array(
								'field' => 'firstName',
								'label' => 'First Name',
								'rules' => 'trim|required'
							),
							array(
								'field' => 'middle',
								'label' => 'Middle Name',
								'rules' => 'trim'
							),
							array(
								'field' => 'lastName',
								'label' => 'Last Name',
								'rules' => 'trim|required'
							),
							array(
								'field' => 'date',
								'label' => 'Date',
								'rules' => 'trim'
							),
							array(
								'field' => 'month',
								'label' => 'Month',
								'rules' => 'trim'
							),
							array(
								'field' => 'countryId',
								'label' => 'Country Name',
								'rules' => 'trim'
							),
							array(
								'field' => 'stateId',
								'label' => 'State Name',
								'rules' => 'trim'
							),		
					  );
		return $rules;
}

function forgot_password()
{
	$rules = array(
								array(
									'field' => 'confirm_code',
									'label' => 'Confirmation Code',
									'rules' => 'trim|required'
								),
								array(
									'field' => 'newPassword',
									'label' => 'New Password',
									'rules' => 'trim|required|min_length[6]|max_length[20]'
								),
								array(
									'field' => 'confirmPassword',
									'label' => 'Confirm New Password',
									'rules' => 'trim|required|matches[newPassword]'
								)
						   );
	return $rules;
}

function add_edit_product_attribute_rules()
{

	$rules = array(	
				array(
					'field' => 'product_type',
					'label' => 'Product Type',
					'rules' => 'trim|required|is_unique[product_type.description]'
				),
			 );
	return $rules;
}

function country_rules()
{
	$rules = array(	
				array(
					'field' => 'countryName',
					'label' => 'Country Name',
					'rules' => 'trim|required|is_unique[country.name]'
				)
			 );
	return $rules;
}

function zone_rules()
{
	$rules = array(	
				array(
					'field' => 'zoneName',
					'label' => 'Zone Name',
					'rules' => 'trim|required|is_unique[zone.zoneId]'
				),
			);
	return $rules;				 
}

function state_rules()
{
	$rules = array(	
				array(
					'field' => 'stateName',
					'label' => 'State Name',
					'rules' => 'trim|required|is_unique[state.stateName]'
				),
				array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),
				/*array(
					'field' => 'zoneId',
					'label' => 'zone Name',
					'rules' => 'trim|required'
				),*/
			);
	return $rules;
}

function area_rules()
{
	$rules = array(	
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaName',
					'label' => 'Area Name',
					'rules' => 'trim|required|is_unique[area.area]'
				),
			);
	return $rules;
}

function zipcode_rules()
{
	$rules = array(	
				array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityName',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				/*array(
					'field' => 'zipCode',
					'label' => 'Zip Code',
					'rules' => 'trim|required'
				),*/
			);
	return $rules;
}

function category_rules()
{
	$rules = array(
				array(
					'field' => 'catID',
					'label' => 'Category Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'parentCatId',
					'label' => 'Parent Category Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'category_name',
					'label' => 'Category Name',
					'rules' => 'trim|required|callback_check_cat_name'
				)
			);
	return $rules;
}

function add_edit_product_rules()
{
	$rules = array(	
				array(
					'field' => 'product_name',
					'label' => 'Product Name',
					'rules' => 'trim|required|callback_check_product_name'
				),
				array(
					'field' => 'item_weight',
					'label' => 'Item Weight',
					'rules' => 'trim|required|numeric'
				),
					array(
					'field' => 'selectcolor',
					'label' => 'clor selection',
					'rules' => 'trim|required|numeric'
				),
					array(
					'field' => 'selectsize',
					'label' => 'sizes',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'weight_shipping',
					'label' => 'Shipping Weight',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'total_weight',
					'label' => 'Total Weight',
					'rules' => 'trim|numeric'
				),
				array(
					'field' => 'level1ID',
					'label' => 'Level 1',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'brand_id',
					'label' => 'Brand Name',
					'rules' => 'trim|required'
				),	
			);
	return $rules;
}

function product_attribute_validation_rule($is_admin=0)
{
	$rules = array(
				'books' => array(
								array(
									'field' => 'new_brand_name',
									'label' => 'New Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'brand_name',
									'label' => 'Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'material',
									'label' => 'Material',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'language',
									'label' => 'Language',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'publisher',
									'label' => 'Publisher',
									'rules' => 'trim|required' 
								),											
								array(
									'field' => 'length',
									'label' => 'Length',
									'rules' => 'trim|required|integer' 
								),
								array(
									'field' => 'width',
									'label' => 'Width',
									'rules' => 'trim|required|integer' 
								),
								array(
									'field' => 'height',
									'label' => 'Height',
									'rules' => 'trim|required|integer' 
								),
								array(
									'field' => 'editor_review',
									'label' => 'Editor Review',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'author_name',
									'label' => 'Author Name',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'author_biography',
									'label' => 'Author Biography',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'isbn_10',
									'label' => 'ISBN 10',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'isbn_13',
									'label' => 'ISBN 13',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
							),
				
				'computers' => array(
								array(
									'field' => 'new_brand_name',
									'label' => 'New Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'brand_name',
									'label' => 'Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'pmid',
									'label' => 'PMID',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'mn',
									'label' => 'MN',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'manufacturer_desc',
									'label' => 'Manufacturer Description',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'length',
									'label' => 'Length',
									'rules' => 'trim|required|integer' 
								),
								array(
									'field' => 'width',
									'label' => 'Width',
									'rules' => 'trim|required|integer' 
								),
								array(
									'field' => 'height',
									'label' => 'Height',
									'rules' => 'trim|required|integer' 
								),						
								array(
									'field' => 'screen_size',
									'label' => 'Screen Size',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'max_screen_resolution',
									'label' => 'Max Screen Resolution',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'processor',
									'label' => 'Processor',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'ram',
									'label' => 'RAM',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'hard_drive',
									'label' => 'Hard Drive',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'graphics_coprocessor',
									'label' => 'Graphics Coprocessor',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'wireless_type',
									'label' => 'Wireless Type',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'no_of_usb',
									'label' => 'Number of USB',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'avg_battery_life',
									'label' => 'Average Battery Life',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'series',
									'label' => 'Series',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'operating_system',
									'label' => 'Operating System',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'processor_brand',
									'label' => 'Processor Brand',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'processor_count',
									'label' => 'Processor Count',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'hrd_drive_rotatnal_speed',
									'label' => 'Hard Drive Rotational Speed',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'batteries',
									'label' => 'Batteries',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'webcam_resolution',
									'label' => 'Web Cam Resolution',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'computer_memory_type',
									'label' => 'Computer Memory Type',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'flash_memory_size',
									'label' => 'Flash Memory Size',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'hrd_drive_interface',
									'label' => 'Hard Drive Interface',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'auto_ports',
									'label' => 'Auto Ports',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'power_source',
									'label' => 'Power Source',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'battery_type',
									'label' => 'Battery Type',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
							),
					
				'software' => array(
								array(
									'field' => 'new_brand_name',
									'label' => 'New Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'brand_name',
									'label' => 'Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'pmid',
									'label' => 'PMID',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'age_group',
									'label' => 'Age Group',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'manufacturer_desc',
									'label' => 'Manufacturer Description',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
							),
		
				'electronics' => array(
									array(
										'field' => 'new_brand_name',
										'label' => 'New Brand Name',
										'rules' => 'trim' 
									),
									array(
										'field' => 'brand_name',
										'label' => 'Brand Name',
										'rules' => 'trim' 
									),
									array(
										'field' => 'pmid',
										'label' => 'PMID',
										'rules' => 'trim|required' 
									),
									array(
										'field' => 'mn',
										'label' => 'MN',
										'rules' => 'trim|required' 
									),							
									array(
										'field' => 'manufacturer_desc',
										'label' => 'Manufacturer Description',
										'rules' => 'trim|required' 
									),
									array(
										'field' => 'tax',
										'label' => 'Tax',
										'rules' => 'trim|required|numeric' 
									),
								),
		
				'general_products' => array(
										array(
											'field' => 'new_brand_name',
											'label' => 'New Brand Name',
											'rules' => 'trim' 
										),
												array(
											'field' => 'brand_name',
											'label' => 'Brand Name',
											'rules' => 'trim' 
										),
										array(
											'field' => 'pmid',
											'label' => 'PMID',
											'rules' => 'trim|required' 
										),
										array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
									),
							
				'appliances' => array(
									array(
										'field' => 'new_brand_name',
										'label' => 'New Brand Name',
										'rules' => 'trim' 
									),
									array(
										'field' => 'brand_name',
										'label' => 'Brand Name',
										'rules' => 'trim' 
									),
									array(
										'field' => 'pmid',
										'label' => 'PMID',
										'rules' => 'trim|required' 
									),
									array(
										'field' => 'mn',
										'label' => 'MN',
										'rules' => 'trim|required' 
									),
									array(
										'field' => 'manufacturer_desc',
										'label' => 'Manufacturer Description',
										'rules' => 'trim|required' 
									),
									array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
								),
					
				'watches' => array(
								array(
									'field' => 'new_brand_name',
									'label' => 'New Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'brand_name',
									'label' => 'Brand Name',
									'rules' => 'trim' 
								),
								array(
									'field' => 'watch_for',
									'label' => 'Watch For',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'strap_material',
									'label' => 'Strap Material',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'type',
									'label' => 'Type',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'dial_shape',
									'label' => 'Dial Shape',
									'rules' => 'trim|required' 
								),
								array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
							),
					
				'toys' => array(
							array(
									'field' => 'new_brand_name',
									'label' => 'New Brand Name',
									'rules' => 'trim' 
								),
							array(
								'field' => 'gender',
								'label' => 'Gender',
								'rules' => 'trim|required' 
							),							
							array(
								'field' => 'age_group',
								'label' => 'Age Group',
								'rules' => 'trim|required' 
							),
							array(
								'field' => 'material',
								'label' => 'Material',
								'rules' => 'trim|required' 
							),
							array(
								'field' => 'manufacturer_desc',
								'label' => 'Manufacturer Description',
								'rules' => 'trim|required' 
							),
							array(
								'field' => 'brand_name',
								'label' => 'Brand Name',
								'rules' => 'trim' 
							),
							array(
								'field' => 'pmid',
								'label' => 'PMID',
								'rules' => 'trim|required' 
							),
							array(
								'field' => 'mn',
								'label' => 'MN',
								'rules' => 'trim|required' 
							),
							array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
						),
					
				'apparel_accessories' => array(
											array(
												'field' => 'new_brand_name',
												'label' => 'New Brand Name',
												'rules' => 'trim' 
											),
											array(
												'field' => 'brand_name',
												'label' => 'Brand Name',
												'rules' => 'trim' 
											),
											array(
												'field' => 'gender',
												'label' => 'Gender',
												'rules' => 'trim|required' 
											),							
											array(
												'field' => 'age_group',
												'label' => 'Age Group',
												'rules' => 'trim|required' 
											),
											array(
												'field' => 'size',
												'label' => 'Size',
												'rules' => 'trim|required' 
											),
											array(
												'field' => 'material',
												'label' => 'Material',
												'rules' => 'trim|required' 
											),
											array(
												'field' => 'manufacturer_desc',
												'label' => 'Description',
												'rules' => 'trim|required' 
											),
											array(
									'field' => 'tax',
									'label' => 'Tax',
									'rules' => 'trim|required|numeric' 
								),
										),		
			);
	
	/*if($is_admin)				
	{
		$taxArr = array(
					'field' => 'tax',
					'label' => 'Tax',
					'rules' => 'trim|required' 
				  );
		$rules['books'][]       	 = $taxArr;
		$rules['computers'][]   	 = $taxArr;
		$rules['software'][]   		 = $taxArr;
		$rules['electronics'][] 	 = $taxArr;
		$rules['general_products'][] = $taxArr;
		$rules['toys'][]       		 = $taxArr;
		$rules['appliances'][]  	 = $taxArr; 
	}*/
	
	return $rules;
}

function sign_in_rules()
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function admin_update_rules()
{
	$rules = array(	
				array(
					'field' => 'image_name',
					'label' => 'Image Name',
					'rules' => 'trim'
				),				
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),							
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim'
				),
				array(
					'field' => 'year',
					'label' => 'Year',
					'rules' => 'trim'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'roles[]',
					'label' => 'user needs to be assigned atleast one role, role',
					'rules' => 'trim|required'
				)
			);
	return $rules;
}

function pointe_force_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|callback_unique_customer_user'
				),	
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]'
				),
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'year',
					'label' => 'Year',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'address1',
					'label' => 'Address1',
					'rules' => 'trim|required|callback_alpha_numeric_space_val'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[8]|callback_password_check_strong'
				),
				array(
					'field' => 'confirmPassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				),					
			 );
	return $rules;
}

function customer_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[customer.email]'
				),
				array(
					'field' => 'phone',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]|is_unique[customer.phone]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[8]|callback_password_check_strong'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				),					
			 );
	return $rules;
}

function frontend_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[customer.email]'
				),
				array(
					'field' => 'phone',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]|is_unique[customer.phone]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[5]|max_length[12]'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street',
					'rules' => 'trim|required|callback_alpha_numeric_space'
				),	
				array(
					'field' => 'zipcode',
					'label' => 'Zipcode',
					'rules' => 'trim|is_natural_no_zero'
				),					
			 );
	return $rules;
}

function rating_review_feedback()
{
	$rules = array(	
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}

function product_rating_review()
{
	$rules = array(	
				array(
					'field' => 'reviewTitle',
					'label' => 'Review Title',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'reviewDescription',
					'label' => 'Review Description',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'rating',
					'label' => 'Rating',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}



function billing_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'address1',
					'label' => 'Address1',
					'rules' => 'trim|required|callback_alpha_numeric_space_val'
				),
				array(
					'field' => 'address2',
					'label' => 'address2',
					'rules' => 'trim'
				),
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]'
				),
				array(
					'field' => 'zipcode',
					'label' => 'Zip Code',
					'rules' => 'trim|integer'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),	
			);
	return $rules;
}

function shipping_rules()
{
	$rules = array(	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'address1',
					'label' => 'Address1',
					'rules' => 'trim|required|callback_alpha_numeric_space_val'
				),
				array(
					'field' => 'address2',
					'label' => 'address2',
					'rules' => 'trim'
				),
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|integer|min_length[10]'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),	
			);
	return $rules;
}

function shipping_same_billing_rules()
{
	$rules = array(	
				array(
					'field' => 'same_as_billing',
					'label' => 'Same AS Billing',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}



function segment_rules()
{
	$rules = array(
				array(
					'field' => 'segment',
					'label' => 'Segment',
					'rules' => 'trim|required|callback_segment_name_check'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Id',
					'rules' => 'trim'
				)
			);
	return $rules;
}



function sub_category_rules()
{
	$rules = array(
				array(
					'field' => 'subCatID',
					'label' => 'Sub Category Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category',
					'label' => 'Sub Category Name',
					'rules' => 'trim|required|callback_check_subcat1_name'
				)
			);
	return $rules;
}

function sub_category2_rules()
{
	$rules = array(
				array(
					'field' => 'subCatID',
					'label' => 'Sub Category Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category1_id',
					'label' => 'Sub Category1 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category2',
					'label' => 'Sub Category2 Name',
					'rules' => 'trim|required|callback_check_subcat2_name',
				)
			);
	return $rules;
}

function sub_category3_rules()
{
	$rules = array(
				array(
					'field' => 'subCat3ID',
					'label' => 'Sub Category3 Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category1_id',
					'label' => 'Sub Category1 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category2_id',
					'label' => 'Sub Category2 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category3',
					'label' => 'Sub Category3 Name',
					'rules' => 'trim|required|callback_check_subcat3_name',
				)
			);
	return $rules;
}

function sub_category4_rules()
{
	$rules = array(
				array(
					'field' => 'subCat4ID',
					'label' => 'Sub Category4 Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category1_id',
					'label' => 'Sub Category1 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category2_id',
					'label' => 'Sub Category2 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category3_id',
					'label' => 'Sub Category3 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category4',
					'label' => 'Sub Category4 Name',
					'rules' => 'trim|required|callback_check_subcat4_name',
				)
			);
	return $rules;
}

function sub_category5_rules()
{
	$rules = array(
				array(
					'field' => 'subCat5ID',
					'label' => 'Sub Category5 Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category1_id',
					'label' => 'Sub Category1 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category2_id',
					'label' => 'Sub Category2 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category3_id',
					'label' => 'Sub Category3 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category4_id',
					'label' => 'Sub Category4 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category5',
					'label' => 'Sub Category5 Name',
					'rules' => 'trim|required|callback_check_subcat5_name',
				)
			);
	return $rules;
}

function sub_category6_rules()
{
	$rules = array(
				array(
					'field' => 'subCat6ID',
					'label' => 'Sub Category6 Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category1_id',
					'label' => 'Sub Category1 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category2_id',
					'label' => 'Sub Category2 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category3_id',
					'label' => 'Sub Category3 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category4_id',
					'label' => 'Sub Category4 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category5_id',
					'label' => 'Sub Category5 Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'sub_category6',
					'label' => 'Sub Category6 Name',
					'rules' => 'trim|required|callback_check_subcat6_name',
				)
			);
	return $rules;
}

function brand_rules()
{
	$rules = array(
				array(
					'field' => 'image_name',
					'label' => 'Brand Image',
					'rules' => 'trim'
				),
				array(
					'field' => 'brand_name',
					'label' => 'Brand Name',
					'rules' => 'trim|required|callback_check_brand_name',
				),
				array(
					'field' => 'brandDescription',
					'label' => 'Brand Description',
					'rules' => 'trim'
				),
			);
	return $rules;
}





function city_rules()
{
	$rules = array(	
				array(
					'field' => 'city_id',
					'label' => 'Area Id',
					'rules' => 'trim'
				),
				array(
					'field' => 'state_id',
					'label' => 'Area',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'country_id',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'city_name',
					'label' => 'Zipcode',
					//'rules' => 'trim|required|is_unique[city.city_name]'
					'rules' => 'trim|required'
				),
			);
	return $rules;
}




function personal_info_rules()
{
	$rules = array(	
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'phone_no',
					'label' => 'Phone Number',
					'rules' => 'trim|required|min_length[10]|numeric|callback_check_phone_no'
				),
				array(
					'field' => 'gender',
					'label' => 'Gender',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}

function change_password_rules($from='')
{
	$rules = array(	
				array(
						'field' => 'opassword',
						'label' => 'Old Password',
						'rules' => 'trim|required|callback_check_old_password'
					),
				array(
					'field' => 'npassword',
					'label' => 'New Password',
					'rules' => 'trim|required|min_length[8]|callback_password_check_strong'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[npassword]'
				),
			 );
	return $rules;
}

function reset_password_rules()
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
			);
	return $rules;
}

function admin_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'image_name',
					'label' => 'Image Name',
					'rules' => 'trim'
				),				
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middle_name',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|callback_check_employee_email'
				),
				
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'admin_type',
					'label' => 'Admin Type',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}




function cse_sign_up()
{
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim'
				),	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[employee.email]'
				),
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'dropshipCentre[]',
					'label' => 'DropshipCentre',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function cse_update_rules()
{
	
	$rules = array(	
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'countryId',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function slider_rules()
{
	$rules = array(
				array(
					'field' => 'slider_image',
					'label' => 'slider Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'slider_link',
					'label' => 'slider Link',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function admin_accept_product_request_rules()
{
	$rules = array(	
				array(
					'field' => 'action',
					'label' => 'Action',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'tax',
					'label' => 'Tax',
					'rules' => 'trim|required|numeric'
				),
			);
	return $rules;
}

function admin_decline_product_request_rules()
{
	$rules = array(	
				array(
					'field' => 'action',
					'label' => 'Action',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function admin_send_back_product_request_rules()
{
	$rules = array(	
				array(
					'field' => 'action',
					'label' => 'Action',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'comment',
					'label' => 'Reason',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function open_order_update_rules()
{
	$rules = array(	
				array(
					'field' => 'track_number',
					'label' => 'Track Number',
					'rules' => 'trim|required|integer'
				),
				array(
					'field' => 'estimate_time',
					'label' => 'Estimate day',
					'rules' => 'trim|required|integer'
				),
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function add_product_for_retailer_from_cse_rules()
{
	$rules = array(	
				array(
					'field' => 'product_name',
					'label' => 'Product Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'description',
					'label' => 'Description',
					'rules' => 'trim|required|min_length[40]'
				),
				array(
					'field' => 'spid',
					'label' => 'SPID',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'srid',
					'label' => 'SRID',
					'rules' => 'trim'
				),
				/*array(
					'field' => 'product_attr',
					'label' => 'Attribute Name',
					'rules' => 'trim|required'
				),*/
				array(
					'field' => 'item_weight',
					'label' => 'Item Weight',
					'rules' => 'trim|required|greater_than[0]'
				),
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function shipping_sign_up_rules($shipp_user_type)
{
	$rules = array(	
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[users.email]'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required|min_length[6]'
				),
				array(
					'field' => 'cpassword',
					'label' => 'Confirm Password',
					'rules' => 'trim|required|matches[password]'
				),
				array(
					'field' => 'business_name',
					'label' => 'Business Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'business_address',
					'label' => 'Corporate Address',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'business_ph_no',
					'label' => 'Corporate Phone Number',
					'rules' => 'trim|required|min_length[10]|numeric'
				),
				array(
					'field' => 'phone_no',
					'label' => 'Contact Phone Number',
					'rules' => 'trim|required|min_length[10]|numeric'
				),
			);
	if($shipp_user_type=='shipping_vendor')	
	{
		$rules[] = array(
						'field' => 'state_id[]',
						'label' => 'State Name',
						'rules' => 'trim|required'
					);
		$rules[] = array(
						'field' => 'city_id[]',
						'label' => 'Zone Name',
						'rules' => 'trim|required'
					);
		$rules[] = array(
						'field' => 'zone_id[]',
						'label' => 'Area Name',
						'rules' => 'trim|required'
					);
		$rules[] = array(
						'field' => 'area_id[]',
						'label' => 'Area Name',
						'rules' => 'trim|required'
					);
		$rules[] = array(
						'field' => 'image_name',
						'label' => 'Document',
						'rules' => 'trim|required'
					);
	}
	
	return $rules;
}


function shipping_sign_up_upload_doc_rules($ruleSet)
{
	$rules = array(	
				array(
					'field' => 'termAndcond',
					'label' => 'Terms & Conditons',
					'rules' => 'trim|required'
				),
				
			);
	$rules = array_merge($rules,$ruleSet);
	return $rules;
}

function add_cse_with_retailes_rules()
{
	$rules = array(	
				array(
					'field' => 'cse_assign',
					'label' => 'CSE User',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'add_cse',
					'label' => 'Add CSE',
					'rules' => 'trim'
				),
			);
	return $rules;
}

function update_retailer_with_cse_rules($from)
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email|callback_update_email_check'
				),	
				array(
					'field' => 'business_name',
					'label' => 'Business Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'business_ph_no',
					'label' => 'Business Phone Number',
					'rules' => 'trim|required|min_length[10]|numeric'
				),				
				array(
					'field' => 'business_owner_name',
					'label' => 'Business Owner Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'phone_no',
					'label' => 'Phone Number',
					'rules' => 'trim|required|min_length[10]|numeric|callback_phone_no_check'
				),
				array(
					'field' => 'bankName',
					'label' => 'Bank Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'accountName',
					'label' => 'Account Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'accountNo',
					'label' => 'Account Number',
					'rules' => 'trim'
				),
				array(
					'field' => 'branchAdd',
					'label' => 'Branch Address',
					'rules' => 'trim'
				),
				array(
					'field' => 'country_id',
					'label' => 'Country Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'state_id',
					'label' => 'State Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'city_id',
					'label' => 'Zone Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'zone_id',
					'label' => 'Area Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'area_id',
					'label' => 'Area Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'street',
					'label' => 'Street',
					'rules' => 'trim'
				),	
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim'
				),	
				array(
					'field' => 'image_name',
					'label' => 'Image',
					'rules' => 'trim'
				),		
			);	
	if($from=='admin')
	{
		$rules[] = array(
					'field' => 'cse_assign',
					'label' => 'CSE User',
					'rules' => 'trim'
				 );
	}
	return $rules;
}

function email_setting_rules()
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'New Email',
					'rules' => 'trim|required|valid_email|is_unique[employee.email]'
				),
				array(
					'field' => 'confirmemail',
					'label' => 'Confirm New Email',
					'rules' => 'trim|required|valid_email|matches[email]'
				)
			);
	return $rules;		
}

function add_attribute_rules()
{
	$rules = array(
				array(
					'field' => 'segment_id',
					'label' => 'Segment Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'category_id',
					'label' => 'Category Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function add_tracking_number_rules()
{
	$rules = array(
				array(
					'field' => 'track_number',
					'label' => 'Track Number',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function retailer_sign_in_rules()
{
	$rules = array(
				array(
					'field' => 'email',
					'label' => 'User Name',
					//'rules' => 'trim|required|callback_check_email_or_phone'
					'rules' => 'trim|required'
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function add_vendor_document_rules()
{
	$rules = array(
				array(
					'field' => 'image_name',
					'label' => 'Document Name',
					'rules' => 'trim|required|callback_check_excel_file_valid'
				),
			);
	return $rules;
}

function update_shipping_vendor_rate_rules()
{
	$rules = array(
				array(
					'field' => 'warehouse_city',
					'label' => 'Ware House Area',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'city_covered',
					'label' => 'Area Covered',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'weight_from',
					'label' => 'Weight From',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'weight_to',
					'label' => 'Weight To',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'rates',
					'label' => 'Rate',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'estimate_delivery_timeframe',
					'label' => 'Estimate Delivery Time',
					'rules' => 'trim|required|integer'
				),
			);
	return $rules;
}

function track_order_rules()
{
	$rules = array(
				array(
					'field' => 'customer_order_id',
					'label' => 'Order Id',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function out_stock_email_rules()
{
	$rules = array(
				array(
					'field' => 'email_notification',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email'
				),
			);
	return $rules;	
}

function add_product_type_rules()
{
	$rules = array(
				array(
					'field' => 'product_type',
					'label' => 'Product Type',
					'rules' => 'trim|required||is_unique[attributes_desc.product_type]'
				),
			);
	return $rules;	
}

function add_product_type_attribute_rules()
{
	$rules = array(
				array(
					'field' => 'title',
					'label' => 'Title',
					'rules' => 'trim|required'
				),
			);
	return $rules;
}

function superadmin_sign_up_rules()
{
	$rules = array(	
				array(
					'field' => 'image_name',
					'label' => 'Image Name',
					'rules' => 'trim'
				),				
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|valid_email|is_unique[users.email]'
				),
				array(
					'field' => 'gender',
					'label' => 'Gender',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim'
				),
				/*array(
					'field' => 'country_id',
					'label' => 'Country Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'state_id',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),*/
			);
	return $rules;
}

function superadmin_update_rules()
{
	$rules = array(	
				array(
					'field' => 'image_name',
					'label' => 'Image Name',
					'rules' => 'trim'
				),				
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),							
				array(
					'field' => 'date',
					'label' => 'Date',
					'rules' => 'trim'
				),
				array(
					'field' => 'month',
					'label' => 'Month',
					'rules' => 'trim'
				),
				array(
					'field' => 'year',
					'label' => 'Year',
					'rules' => 'trim'
				),
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim'
				),
			);
	return $rules;
}

function superadmin_update_profile_rules()
{
	$rules = array(	
				array(
					'field' => 'image_name',
					'label' => 'Image Name',
					'rules' => 'trim'
				),				
				array(
					'field' => 'first_name',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'last_name',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),							
				array(
					'field' => 'comment',
					'label' => 'Comment',
					'rules' => 'trim'
				),
			);
	return $rules;
}

function add_edit_product_type_rules()
{
	$rules = array(	
				array(
					'field' => 'product_type',
					'label' => 'Product Type',
					'rules' => 'trim|required|is_unique[product_type.description]'
				),
			 );
	return $rules;
}

function add_edit_attribute_type_rules()
{
	$rules = array(	
				array(
					'field' => 'productTypeId',
					'label' => 'Prdouct Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'attribute_type',
					'label' => 'Attribute Type',
					'rules' => 'trim|required|callback_attribute_type_check'
				),
				
			 );
	return $rules;
}

function add_edit_attribute_name_rules()
{
	$rules = array(	
				array(
					'field' => 'product_type',
					'label' => 'Prdouct Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'attribute_type',
					'label' => 'Attribute Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'attribute_name',
					'label' => 'Attribute Name',
					'rules' => 'trim|required|callback_attribute_name_check'
				),
			 );
	return $rules;
}

function add_product_taxonomy_rules()
{
	$rules = array(	
				array(
					'field' => 'product_type',
					'label' => 'Product Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'attribute_type',
					'label' => 'Attribute Type',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'attribute_name[]',
					'label' => 'Attribute Name',
					'rules' => 'trim|required'
				),
			 );
	return $rules;
}

function add_retailer_product_from_master_list_rules()
{
	$rules = array(	
				array(
					'field' => 'categoryId',
					'label' => 'Category Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'upc',
					'label' => 'UPC',
					'rules' => 'trim'
				),
				array(
					'field' => 'costPrice',
					'label' => 'Cost Price',
					'rules' => 'trim|required|numeric'
				),
				array(
					'field' => 'sellPrice',
					'label' => 'Sell Price',
					'rules' => 'trim|required|numeric|callback_check_sell_price_with_cost_price'
				),
			 );
	return $rules;
}
function retailer_customer_signup()
{
	$rules	=	array(
				array(
					'field' => 'firstName',
					'label' => 'first Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'lastName',
					'label' => 'last Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'imageName',
					'label' => 'Image',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'notes',
					'label' => 'Note',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'phoneNo',
					'label' => 'Phone Number',
					'rules' => 'trim|required|is_unique[customer.phone]'
				),
				array(
					'field' => 'stateId',
					'label' => 'state',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'street',
					'rules' => 'trim|required'
				),
				
						);
return $rules;
}

function add_marketing_product_rules()
{
	$rules = array(
				array(
					'field' => 'inventory',
					'label' => 'Inventory',
					'rules' => 'trim'
				),				
				array(
					'field' => 'cost',
					'label' => 'Actual Price',
					'rules' => 'trim|required|callback_check_greater[sale]'
				),				
				
				array(
					'field' => 'sale',
					'label' => 'Effective sale price',
					'rules' => 'trim|required|greater_than[-1]'
				),
				array(
					'field' => 'datefrom',
					'label' => 'Effective Date from',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'dateto',
					'label' => 'Effective Date To',
					'rules' => 'trim|required|callback_check_greater_date[datefrom]'
				),
				array(
					'field' => 'level1',
					'label' => 'level1 Category',
					'rules' => 'trim|required'
				),
			
				array(
					'field' => 'retailerdiscount',
					'label' => 'Retailer Discount',
					'rules' => 'trim|required|greater_than[-1]'
				),
				array(
					'field' => 'spacepointediscount',
					'label' => 'Spacepointe Discount',
					'rules' => 'trim|required|greater_than[-1]'
				),
				array(
					'field' => 'discount',
					'label' => 'Discount',
					'rules' => 'trim|required|greater_than[-1]'
				),
			);
	return $rules;
	
}
 function pointepay_retailer_sign_up()
{
	$rules = array(	
				
				array(
					'field' => 'firstName',
					'label' => 'First Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'middleName',
					'label' => 'Middle Name',
					'rules' => 'trim'
				),
				array(
					'field' => 'lastName',
					'label' => 'Last Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|valid_email|is_unique[employee.email]'
				),	
				array(
					'field' => 'businessName',
					'label' => 'Business Name',
					'rules' => 'trim|required'
				),	
				array(
					'field' => 'areaId',
					'label' => 'Area Name',
					'rules' => 'trim|required'
					),
				array(
					'field' => 'stateId',
					'label' => 'State Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'cityId',
					'label' => 'City Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'street',
					'label' => 'Street Address',
					'rules' => 'trim|required'
				),
			);	
			return $rules;
}
?>
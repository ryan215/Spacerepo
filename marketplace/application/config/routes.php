<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller']    = "frontend/home"; 
$route['admin'] 			 	= "auth/login";
$route['backend'] 			 	= "auth/login";
$route['retailer'] 			 	= "retailer/home";

$route['finance'] 			 	= "auth/login";

$route['product/(:any)-details-(:num)-color-(:num)-size-(:num)-colorsize-(:num)'] = 'frontend/single/product_detail/$2/$3/$4/$5';
$route['product/(:any)-details-(:num)'] 						 = 'frontend/single/product_detail/$2';
$route['product/(:any)-write-rating-review-(:num)'] 			 = 'frontend/product_rating_review/write_review/$2';
$route['product/(:any)-rating-review-(:num)-rating-no-(:num)']   = 'frontend/product_rating_review/rating_review_list/$2/$3';
$route['product/(:any)-rating-review-(:num)'] 					 = 'frontend/product_rating_review/rating_review_list/$2';


$route['category/(:any)-grid-(:num)'] = 'frontend/product/product_list_grid/$2';
$route['category/(:any)-list-(:num)'] = 'frontend/product/product_list_list/$2';

$route['brand/(:any)-grid-(:num)']    = 'frontend/product/brand_product_list_grid/$2';
$route['brand/(:any)-list-(:num)']    = 'frontend/product/brand_product_list_list/$2';

$route['product/pre-sales-(:any)'] 	  = 'frontend/pre_sales/product_list/$1';
$route['product/pre-sales-(:any)'] 	  = 'frontend/pre_sales/product_list/$1';

$route['news-letter-subscribe-refer-friends-(:num)'] = 'frontend/home/index/$1';


$route['shipping']      				 	= 'shipping/shipping';
$route['shipping/sign_up'] 	 				= 'shipping_admin/shipping/sign_up';
$route['shipping/city_list']				= 'shipping_admin/shipping/city_list';
$route['shipping/zone_list'] 				= 'shipping_admin/shipping/zone_list';
$route['shipping/area_list'] 				= 'shipping_admin/shipping/area_list';
$route['shipping/file_download'] 			= 'shipping_admin/shipping/file_download';
$route['shipping/shipping_upload_document'] = 'shipping_admin/shipping/shipping_upload_document/';


$route['shipping-rates-and-policies'] = 'frontend/custom/get_view/shipping-rates-and-policies';
$route['return-and-replacements'] 	  = 'frontend/custom/get_view/return-and-replacements';
$route['contact-us'] 				  = 'frontend/custom/get_view/contact-us';
$route['about'] 					  = 'frontend/custom/get_view/about';
$route['investor-relatons'] 		  = 'frontend/custom/get_view/investor-relatons';
$route['press-release'] 			  = 'frontend/custom/get_view/press-release';
$route['careers'] 					  = 'frontend/custom/get_view/careers';
$route['sell-on-pointemart'] 		  = 'frontend/custom/get_view/sell-on-pointemart';
$route['advertise-your-products']	  = 'frontend/custom/get_view/advertise-your-products';
$route['site-map']		 			  = 'frontend/custom/get_view/site-map';
$route['privacy-and-security']        = 'frontend/custom/get_view/privacy-and-security';
$route['conditions-of-use'] 		  = 'frontend/custom/get_view/conditions-of-use';
$route['terms-of-use']            	  = 'frontend/custom/get_view/terms-of-use';
$route['privacy-policy']              = 'frontend/custom/get_view/privacy-policy';
$route['404_override'] 		 = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
<?php
function asc_price($x, $y)
{
	$ret_var = assoc_array_sort($x, $y, 'currentPrice','ASC');
    return $ret_var;
}

function des_price($x, $y)
{
	$ret_var = assoc_array_sort($x, $y, 'currentPrice','DESC');
    return $ret_var;
}

function product_attributes()
{
	$productAttributes = array(
							'books' 			  => 'Books',
						 	'computers'           => 'Computers',
							'software' 			  => 'Software',
							'electronics' 		  => 'Electronics',
							'general_products'    => 'General Products',
							'appliances' 		  => 'Appliances',
							'watches' 			  => 'Watches',
							'toys'				  => 'Toys',
							'apparel_accessories' => 'Apparel & Accessories',
						 );
	return $productAttributes;
}

function product_attribute_description()
{
	$array = array(
			 	'brand_name'  				=> 'Brand Name',
				'gender'      				=> 'Gender',
				'age_group'   				=> 'Age Group',
				'strap_color' 				=> 'Strap Color',
				'size'		  				=> 'Size',
				'material'    				=> 'Material',
				'manufacturer_desc'			=> 'Manufacturer Description',
				'pmid'						=> 'PMID',
				'mn'						=> 'MN',
				'tax'						=> 'Tax',
				'language'					=> 'Language',
				'publisher'					=> 'Publisher',
				'item_dimension'			=> 'Item Dimension',
				'editor_review'				=> 'Editor Review',
				'author_name'				=> 'Author Name',
				'author_biography'			=> 'Author Biography',
				'isbn_10'					=> 'ISBN 10',
				'isbn_13'					=> 'ISBN 13',
				'screen_size'				=> 'Screen Size',
				'max_screen_resolution'		=> 'Maximum Screent Resolution',
				'processor'					=> 'Processor',
				'ram'						=> 'RAM',
				'hard_drive'				=> 'Hard Drive',
				'graphics_coprocessor'		=> 'Graphics Coprocessor',
				'wireless_type'				=> 'Wireless Type',
				'no_of_usb'					=> 'Number Of USB',
				'avg_battery_life'			=> 'Average Battery Life',
				'series'					=> 'Series',
				'operating_system'			=> 'Operating System',
				'processor_brand'			=> 'Processor Brand',
				'processor_count'			=> 'Processor Count',
				'hrd_drive_rotatnal_speed'  => 'Hard Drive Rotational Speed',
				'batteries'					=> 'Batteries',
				'webcam_resolution'			=> 'Web Cam Resolution',
				'computer_memory_type'		=> 'Computer Memory Type',
				'flash_memory_size'			=> 'Flash Memory Size',
				'hrd_drive_interface'		=> 'Hard Drive Interface',
				'auto_ports'				=> 'Auto Ports',
				'power_source'				=> 'Power Source',
				'battery_type'				=> 'Battery Type',
				'watch_for'					=> 'Watch For',
				'strap_material'			=> 'Strap Material',
				'type'						=> 'Type',
				'dial_shape'				=> 'Dial Shape',
				'dial_color'				=> 'Dial Color',
				'color'						=> 'Color',
				'length'                    => 'Item Dimension Length',
				'width'                     => 'Item Dimension Width',
				'height'                    => 'Item Dimension Height',
			 );
	return $array;
}

function product_commission_count($commission,$price)
{
	$final_price = $price+($price*($commission/100));
	return $final_price;
}

function price_range_checkbox($min_price='',$max_price='')
{
	$array = array();
	if(!empty($max_price))
	{
		$difference=$max_price-$min_price;
		$add=floor($difference/6);
		$from  = floor($min_price);
		while($from<=$max_price)
		{
			$remainder = $from%100; 
			if($difference < 5000){
			if($remainder!=0)
			{
				$to = $from+(100-$remainder);
			}
			else
			{
				$to = $from+500;
			}	
			}else{
				$to=$from+$add;
			}
			$array[$from.'-'.$to] = '₦'.$from.' - ₦'.$to; 
			$from = $to;
		}
	}
	return $array;
}

function product_color_list()
{
	$color = array(
				'black'		=> array(
									'name'     => 'Black',
									'code'     => '#333333',
									'int_code' => '123',
								),
				'blue'		=> array(
									'name'     => 'Blue',
									'code'     => '#1664c4',
									'int_code' => '434',
								),
				'red'		=> array(
									'name'     => 'Red',
									'code'     => '#c00707',
									'int_code' => '338',
								),
				'green'		=> array(
									'name'     => 'Green',
									'code'     => '#6fcc14',
									'int_code' => '253',
								),
				'brown'		=> array(
									'name'     => 'Brown',
									'code'     => '#943f00',
									'int_code' => '240',
								),
				'pink'		=> array(
									'name'     => 'Pink',
									'code'     => '#ff1cae',
									'int_code' => '212',
								),
				'beige'		=> array(
									'name'     => 'Beige',
									'code'     => '#f5f5dc',
									'int_code' => '176',
								),
				'grey'		=> array(
									'name'     => 'Grey',
									'code'     => '#adadad',
									'int_code' => '154',
								),
				'purple'	=> array(
									'name' 	   => 'Purple',
									'code' 	   => '#5d00dc',
									'int_code' => '132',
								),
				'yellow'	=> array(
									'name' 	   => 'Yellow',
									'code' 	   => '#f1f40e',
									'int_code' => '104',
								),
				'orange'	=> array(
									'name' 	   => 'Orange',
									'code' 	   => '#ffc600',
									'int_code' => '77',
								),
				'maroon'	=> array(
									'name' 	   => 'Maroon',
									'code' 	   => '#9b1d00',
									'int_code' => '76',
								),
				'navy_blue'	=> array(
									'name' 	   => 'Navy Blue',
									'code' 	   => '#0a43a3',
									'int_code' => '68',
								),
				'tan'    	=> array(
									'name' 	   => 'Tan',
									'code' 	   => '#ede4b2',
									'int_code' => '67',
								),
				'silver'    => array(
									'name' 	   => 'Silver',
									'code' 	   => '#ecf1ef',
									'int_code' => '49',
								),
				'off_white' => array(
									'name' 	   => 'Off White',
									'code' 	   => '#f3f1e7',
									'int_code' => '44',
								),
			 );
	return $color;
}

function some_product_color_list($array='')
{
	$color = '';
	if(!empty($array))
	{
		$colorArr = product_color_list();
		foreach($array as $key=>$value)
		{
			$color[$key] = $colorArr[$key];
		}
	}
	return $color;
}
?>
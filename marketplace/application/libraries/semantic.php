<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	require(APPPATH.'/third_party/semantics3/lib/Semantics3.php');
	class semantic
	{
		public function get_products($product_name)
		{
			
			$key = 'SEM3965FBCF176085C94BD9184167A7C1E99';
			$secret = 'NzI0YzAxNGUzZGY5OTAxZmQ5MWU4NzhhNDkxODkzMDQ';

				$requestor = new Semantics3_Products($key,$secret);
				$requestor->products_field( "search", $product_name );

						# Run the request
				$results = $requestor->get_products();

					# View the results of the request
				//$product_detail=json_decode($results);
				return $results;
		}
		
		
	}
<?php
function api_add_product()
{
	$rules=array(
				array(
					'field' => 'organizationId',
					'label' => 'organizationId',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'code',
					'label' => 'Product Name',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'productDescription',
					'label' => 'Product description',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'upc',
					'label' => 'category Description',
					'rules' => 'trim'
				),
				array(
					'field' => 'categoryId',
					'label' => 'category',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'costPrice',
					'label' => 'cost Price',
					'rules' => 'trim|required'
				),
				array(
					'field' => 'currentPrice',
					'label' => 'sale Price',
					'rules' => 'trim|required'
				),
				);
		return $rules;
}
?>
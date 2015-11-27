<?php
class Sementic_product_m extends MY_Model{	

	public function __construct()
	{
		parent::__construct();		
	}
	public function add_product_attr_type($product_attr)
	{
		$data	=	array(
								'description'	=>	$product_attr,
								'createDt'		=>	date('Y-m-d h:i:s'),
								'active'		=>	1,
								'productTypeId'	=>1
							);
		$this->db->insert('product_attribute_type',$data);
		
		return $this->db->insert_id();
	}
	public function add_product_attr_name($attribute)
	{
		
		$rs=$this->db->insert('product_attribute_name',$attribute);
		if(!empty($rs))
		{
			$product_attribute_id= $this->db->insert_id();
				return $this->add_product_taxonomy($product_attribute_id,$attribute['productAttributeTypeId']);
		}
	}
	public function add_product_taxonomy($attribute_name_id,$productAttributeTypeId)
	{
		$data=array(
						'attributeNameId'	=> $attribute_name_id,
						'attributeTypeId' =>$productAttributeTypeId,
						'productTypeId'		=>	1,
						'createDt'			=>	date('Y-m-d h:i:s'),
						'lastModifiedDt'	=>	date('Y-m-d h:i:s')
						
						);
		$rs=$this->db->insert('product_taxonomy',$data);
		
		if(!empty($rs))
		{
				return $this->db->insert_id();
		}
	}
	public function add_attribute_value($product_id,$taxonomy_id,$attributeValue)
	{
		$data=array(
							'productId'				=>	$product_id,
							'productTaxonomyId'		=>	$taxonomy_id,
							'attributeValue'		=>	$attributeValue
							);
		$rs=$this->db->insert('product_attribute',$data);
		
		
	}
	
	public function add_product($product_data)
	{
		$data	=	array(
							'code'			=>	$product_data['name'],
							'description'	=>	$product_data['description'],
							'brandId'		=>	$product_data['brandId'],
							'productTypeId'	=> 2,
							'verificationResultId'  => 1,
							'createBy'	=> $this->session->userdata('userId'),
							'createDt'				=>	date('Y-m-d h:i:s'),
							'lastModifiedDt'		=>	date('Y-m-d h:i:s')
							);
		
		$this->db->insert('product',$data);
		return $this->db->insert_id();
	}
	
	public function update_product($product_id,$produt_data)
	{
		$data	=	array(
							'code'			=>	$produt_data['name'],
							'brandId'		=>	$produt_data['brand'],
							'createDt'				=>	date('Y-m-d h:i:s'),
							'lastModifiedDt'		=>	date('Y-m-d h:i:s')
							);
		$this->db->where('productId',$product_id);
		$rs=$this->db->update('product',$data);
		return $rs;
	}	
	public function update_product_weight($product_id,$produt_data,$sizes='')
	{
		$data	=	array(
							'weight'		=>	$produt_data['weight'],
							'sizes'			=>  $sizes,
							'shippingWeight' =>	$produt_data['pakaging_material'],
							'createDt'				=>	date('Y-m-d h:i:s'),
							'lastModifiedDt'		=>	date('Y-m-d h:i:s')
							);
		$this->db->where('productId',$product_id);
		$rs=$this->db->update('product',$data);
		return $rs;
	}
	public function add_product_image($product_id,$product_image,$imagepath,$displayorder='')
	{
		$data = array(
					'imageName'				=> $product_image,
					'imagePath' 			=> $imagepath,
					'productId' 			=> $product_id,
					'displayOrder'			=> $displayorder,
					'createDt'				=>	date('Y-m-d h:i:s'),
					'lastModifiedDt'		=>	date('Y-m-d h:i:s')
				);
		$this->db->insert('product_image',$data);
		return $this->db->insert_id();
	}
	public function get_product_detail($product_id)
	{
		$this->db->select('product.*,brand.*,product_image.*,product_mrp.*')->from('product');
		$this->db->join('product_image','product.productId=product_image.productId','left');
		$this->db->join('brand','brand.brandId=product.brandId','left');
		$this->db->join('product_mrp','product_mrp.productId=product.productId','left');
		
		$this->db->where('product.productId',$product_id);
		
		return $this->db->get()->row();
	}
	public function get_product_detail_by_name($product_name)
	{
		$this->db->select('product.*,brand.*,product_image.*,product_mrp.*')->from('product');
		$this->db->join('product_image','product.productId=product_image.productId','left');
		$this->db->join('brand','brand.brandId=product.brandId','left');
		$this->db->join('product_mrp','product_mrp.productId=product.productId','left');
		
		$this->db->where('trim(product.code)',$product_name);
		//$this->db->where('product.verificationResultId',2);
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 3 OR product.verificationResultId = 4 OR product.verificationResultId = 5)');
		
		return $this->db->get()->row();
	}
	
	public function add_mrp($product_id,$mrp)
	{
			$data=array(
						'productId'				=> $product_id,
						'countryId	' 			=> 154,
						'mrp' 					=> $mrp,
						'createDt'				=>	date('Y-m-d h:i:s'),
						'active'				=>1
						);
				$this->db->insert('product_mrp',$data);
		return $this->db->insert_id();
	}
	public function update_mrp($product_id,$mrp)
	{
			$data=array(
						
						'countryId	' 			=> 154,
						'mrp' 					=> $mrp,
						'createDt'				=>	date('Y-m-d h:i:s'),
						'active'				=>1
						);
				$this->db->where('productId',$product_id);		
				$rs=$this->db->update('product_mrp',$data);
		return $rs;
	}
	public function add_tax($product_id,$tax)
	{
			$data=array(
						'productId'				=>  $product_id,
						'organizationId	' 		=>  1,
						'tax' 					=>  $tax,
						'createDt'				=>	date('Y-m-d h:i:s'),
						'effectiveDt'			=>	date('Y-m-d h:i:s'),
						'lastModifiedDt'		=>	date('Y-m-d h:i:s'),
						'active'				=>1,
						'lastModifiedBy'		=>	$this->session->userdata('userId')
						);
				$this->db->insert('product_tax',$data);
		return $this->db->insert_id();
	}
	public function product_category($product_id,$categoryId)
	{
			$data=array(
						'productId'				=>  $product_id,
						'categoryId'			=>	$categoryId,
						'organizationId	' 		=>  1,
						'createDt'				=>	date('Y-m-d h:i:s'),
						'lastModifiedDt'		=>	date('Y-m-d h:i:s'),
						'active'				=>1,
						'lastModifiedBy'		=>	$this->session->userdata('userId')
						);
				$this->db->insert('product_category',$data);
		return $this->db->insert_id();
	}
	public function activate_product($product_id)
	{
		$data=array(
					'verificationResultId'	=>	2
					);
		if($this->session->userdata('userType')=='cse')
		{
			$data['verificationResultId'] = 4;	
		}
		if($this->session->userdata('userType')=='retailer')
		{
			$data['verificationResultId'] = 3;	
		}
		$this->db->where('productId',$product_id);
		$rs=$this->db->update('product',$data);
		return $rs;
	}
	
	public function check_product_name($productName,$productId='')
	{
		//$this->db->select("replace(code,' ','') AS productName");
		if($productId)
		{
			$this->db->where('productId !=',$productId);
		}
		$this->db->where('code',$productName);
		//$this->db->where("REPLACE(LCASE(code),' ','')",strtolower($productName));		 
		$this->db->where('(verificationResultId = 2 OR verificationResultId = 4 OR verificationResultId = 5)');
		//$this->db->having('LCASE(productName)',str_replace(' ',''strtolower($productName)));
		$result = $this->db->get('product');
		//echo $this->db->last_query(); exit;
		return $result->row();
	}
	
	public function last_semantics_product_history($productId)
	{
		$this->db->where(array('productId' => $productId,'verificationResultId' => 1,'productTypeId' => 2));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get('product_history')->row();
		return $result;
	}
	
	public function update_semantic_product_history($productHistoryId,$updateArr)
	{
		$updateOpt = array(
						'weight' 	     => $updateArr['weight'],
						'shippingWeight' => $updateArr['shippingWeight'],
						'categoryId'     => $updateArr['categoryId'],
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('productHistoryId',$productHistoryId);
		$this->db->update('product_history',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function activate_semantic_product_history($productHistoryId)
	{
		$data = array(
					'verificationResultId' => 2,
					'lastModifiedDt' 	   => date('Y-m-d H:i:s'),
					'lastModifiedBy' 	   => $this->session->userdata('userId'),
				 );
				 
		if($this->session->userdata('userType')=='cse')
		{
			$data['verificationResultId'] = 4;	
		}
		if($this->session->userdata('userType')=='retailer')
		{
			$data['verificationResultId'] = 3;	
		}
		$this->db->where('productHistoryId',$productHistoryId);
		$this->db->update('product_history',$data);
		return $this->db->affected_rows();
	}
	
	public function update_product_type($productId,$productTypeId)
	{
		$updateData	= array(
							'productTypeId'  => $productTypeId,
							'lastModifiedBy' => $this->session->userdata('userId'),		
							'lastModifiedDt' =>	date('Y-m-d h:i:s')
					   );
		$this->db->where('productId',$productId);	
		$this->db->update('product',$updateData);
		return $this->db->affected_rows();
	}
}
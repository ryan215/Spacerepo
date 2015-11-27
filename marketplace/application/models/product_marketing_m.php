<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_marketing_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function add_markeitng_product($prodArr='',$organizationId)
	{
		if(!empty($prodArr))
		{
			$data = array(
						'costPrice'				=> $prodArr['cost'],
						'currentPrice'			=> $prodArr['sale'],
						'organizationId'		=> $organizationId,
						'productId'				=> $prodArr['productId'],
						'organizationProductId' => $prodArr['organizationProductId'],
						'currentQty'	      	=> $prodArr['inventory'],
						'effectiveDtFrom'     	=> $prodArr['datefrom'],
						'effectiveDtTo'  	  	=> $prodArr['dateto'],
						'spacepointeDiscount' 	=> $prodArr['spacepointeDiscount'],
						'retailerDiscount'    	=> $prodArr['retailerDiscount'],
						'discountPrice'	      	=> $prodArr['discountPrice'],
						'active'			  	=> 1,
						'createdBy'         	=> $this->session->userdata('userId'),
						'createDt'		      	=> date('Y-m-d H:i:s'),
						'lastModifiedBy'      	=> $this->session->userdata('userId'),
						'lastModifiedDt'      	=> date('Y-m-d H:i:s'),
						);
			$this->db->insert('marketing_product',$data);
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
		
	}
	public function update_markeitng_product($prodArr='',$organizationId)
	{
		if(!empty($prodArr))
		{
			$data=array(
						'costPrice'		=>	$prodArr['cost'],
						'currentPrice'	=>	$prodArr['sale'],
						'organizationId'=>	$organizationId,
						'productId'		=>	$prodArr['productId'],
						'organizationProductId'		=>	$prodArr['organizationProductId'],
						'createDt'		=>	date('Y-m-d H:i:s'),
						'lastModifiedBy'=>	$this->session->userdata('userId'),
						'lastModifiedDt'=>	date('Y-m-d H:i:s'),
						'currentQty'	=>	$prodArr['inventory'],
						'effectiveDtFrom'=> $prodArr['datefrom'],
						'effectiveDtTo'  => $prodArr['dateto'],
						'discountPrice'  => $prodArr['discountPrice'],
						'retailerDiscount'  => $prodArr['retailerDiscount'],						
						);
		$this->db->where('marketingProductId',$prodArr['marketingProductId']);
		$rs=$this->db->update('marketing_product',$data);
		return $this->db->affected_rows();
		}else{
			
		}
		
	}
	
	public function add_product_category($prodArr='',$organizationId)
	{
		$data = array(
					'categoryId'		 =>	$prodArr['categoryId'],
					'organizationId'	 =>	$organizationId,
					'marketingProductId' =>	$prodArr['marketingProductId'],
					'createDt'			 =>	date('Y-m-d H:i:s'),
					'lastModifiedBy'	 =>	$this->session->userdata('userId'),
					'lastModifiedDt'	 =>	date('Y-m-d H:i:s')
				);
		$this->db->insert('marketing_product_category',$data);
		return $this->db->insert_id();
		
	}
	public function update_product_category($prodArr='',$organizationId)
	{
		$data=array(
						
						'categoryId'	=>	$prodArr['categoryId'],
						'organizationId'=>	$organizationId,
						'createDt'		=>	date('Y-m-d H:i:s'),
						'lastModifiedBy'=>	$this->session->userdata('userId'),
						'lastModifiedDt'=>	date('Y-m-d H:i:s')
						
						);
		$this->db->where('marketingProductId',$prodArr['marketingProductId']);
		$this->db->update('marketing_product_category',$data);
		return $this->db->affected_rows();
		
	}
	public function total_products($where='')
	{
		$this->db->select('count(*) as total');
		$this->db->from('marketing_product');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('marketing_product_category','marketing_product_category.marketingProductId=marketing_product.marketingProductId');
		$this->db->join('category','category.categoryId=marketing_product_category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('brand', 'product.brandId = brand.brandId');
		$this->db->where(array(
						'product_image.displayOrder' => 1,
						'marketing_product.active'   => 1,
						'product.active' 			 => 1,
						'DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <=' => date('Y-m-d'),
						'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >='   => date('Y-m-d'),
						'category.active' => 1,
						'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$response=$this->db->get()->row();
		return $response->total;
	}
	public function product_list($start=0,$limit='',$where='')
	{
		$this->db->select('brand.*,category.*,marketing_product_category.*,marketing_product.*,product.*,product_image.imageName');
		$this->db->from('marketing_product');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('marketing_product_category','marketing_product_category.marketingProductId=marketing_product.marketingProductId');
		$this->db->join('category','category.categoryId=marketing_product_category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('brand', 'product.brandId = brand.brandId');
		$this->db->where(array(
							'product_image.displayOrder' => 1,
							'marketing_product.active'   => 1,
							'product.active' 			 => 1,
							'DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <=' => date('Y-m-d'),
							'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >='   => date('Y-m-d'),
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('marketing_product.marketingProductId','desc');
		if(!empty($limit))
		{
			 $this->db->limit($limit,$start);
		}
		$response=$this->db->get()->result();
		return $response;
	}
	
	public function total_products_history($where='')
	{
		$this->db->select('count(*) as total');
		$this->db->from('marketing_product');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('marketing_product_category','marketing_product_category.marketingProductId=marketing_product.marketingProductId');
		$this->db->join('category','category.categoryId=marketing_product_category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->where(array('product_image.displayOrder' => 1,'product.active' => 1,'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") < ' => date('Y-m-d')));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$response=$this->db->get()->row();
		return $response->total;
	}
	
	public function product_history_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('marketing_product');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('marketing_product_category','marketing_product_category.marketingProductId=marketing_product.marketingProductId');
		$this->db->join('category','category.categoryId=marketing_product_category.categoryId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->where(array('product_image.displayOrder' => 1,'product.active' => 1,'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") <' => date('Y-m-d')));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			 $this->db->limit($limit,$start);
		}
		$response=$this->db->get()->result();
		return $response;
	}
		
	public function inventory_details($marketingProductId)
	{
		$this->db->select('product.code,product.productId,marketing_product.*,product_image.imageName,group_concat(marketing_size_stock.colorId ORDER BY   marketing_size_stock.colorId ASC ) as colorId,group_concat(marketing_size_stock.size ORDER BY   marketing_size_stock.colorId ASC) as product_size,group_concat(marketing_size_stock.currentstock ORDER BY   marketing_size_stock.colorId ASC ) as stock,product.weight,product.shippingWeight,organization_product.currentPrice AS orgCurrentPrice,organization_product.organizationProductId');
		$this->db->from('marketing_product');
		$this->db->join('organization_product','marketing_product.organizationProductId = organization_product.organizationProductId');
		$this->db->join('product','marketing_product.productId = product.productId');
		$this->db->join('product_image','marketing_product.productId = product_image.productId');
		$this->db->join('marketing_size_stock','marketing_size_stock.marketingProductId=marketing_product.marketingProductId','left');
		$this->db->where(array('marketing_product.marketingProductId' => $marketingProductId,'product_image.displayOrder' => 1,'marketing_product.active' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	public function inventory_details_with_category($marketingProductId)
	{
		$this->db->select('product.code,marketing_product.*,product_image.imageName,marketing_product_category.*,group_concat(marketing_size_stock.colorId ORDER BY   marketing_size_stock.colorId ASC ) as colorId,group_concat(marketing_size_stock.size ORDER BY   marketing_size_stock.colorId ASC) as product_size,group_concat(marketing_size_stock.currentstock ORDER BY   marketing_size_stock.colorId ASC ) as stock');
		$this->db->from('marketing_product');
		$this->db->join('product','marketing_product.productId = product.productId');
		$this->db->join('marketing_product_category','marketing_product.marketingProductId = marketing_product_category.marketingProductId');
		$this->db->join('product_image','marketing_product.productId = product_image.productId');
		$this->db->join('marketing_size_stock','marketing_size_stock.marketingProductId=marketing_product.marketingProductId','left');
		$this->db->where(array('marketing_product.marketingProductId' => $marketingProductId,'product_image.displayOrder' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	
	public function inventory_details_with_category_backup($marketingProductId)
	{
		$this->db->select('product.code,marketing_product.*,product_image.imageName,marketing_product_category.*,group_concat(marketing_size_stock.colorId ORDER BY   marketing_size_stock.colorId ASC ) as colorId,group_concat(marketing_size_stock.size ORDER BY   marketing_size_stock.colorId ASC) as product_size,group_concat(marketing_size_stock.currentstock ORDER BY   marketing_size_stock.colorId ASC ) as stock');
		$this->db->from('marketing_product');
		$this->db->join('product','marketing_product.productId = product.productId');
		$this->db->join('marketing_product_category','marketing_product.marketingProductId = marketing_product_category.marketingProductId');
		$this->db->join('product_image','marketing_product.productId = product_image.productId');
		$this->db->join('marketing_size_stock','marketing_size_stock.marketingProductId=marketing_product.marketingProductId','left');
		$this->db->where(array('marketing_product.marketingProductId' => $marketingProductId,'product_image.displayOrder' => 1));
		$result = $this->db->get();
		return $result->row();
	}
	public function block_unblock($status,$marketingProductId)
	{
		$updateOpt = array('active' => $status);
		$this->db->where('marketingProductId',$marketingProductId);
		$this->db->update('marketing_product',$updateOpt);
		return $this->db->affected_rows();		
	}
	public function update_inventory($marketingProductId,$total_qty)
	{
		$this->db->set('currentQty', $total_qty, FALSE);
		$this->db->where('marketingProductId',$marketingProductId);
		$this->db->update('marketing_product');
		return $this->db->affected_rows();
		
	}
		public function add_marketing_color_stock($organizationProductId,$stock,$color)
	{
		$insertOpt = array();
		foreach($color as $singlecolor)
		{
			$insertOpt[] =	array(
							'marketingProductId'	=>	$organizationProductId,
							'currentStock'			=>	$stock,
							'colorId'				=>	$singlecolor
						);
		
		}
		if(!empty($insertOpt))
		{
			$this->db->insert_batch('marketing_size_stock',$insertOpt);
			return $this->db->affected_rows();
		}
	}
	public function add_marketing_size_stock($organizationProductId,$stock,$size,$color)
	{
		if(is_array($color))
		{
			foreach($color as $singlecolor)
			{
				if(empty($singlecolor))
				{
					$singlecolor = 0;
				}
				$insertOpt[]=	array(
								'marketingProductId'	=>	$organizationProductId,
								'currentStock'			=>	$stock,
								'size'					=>	$size,
								'colorId'				=>	$singlecolor
							);
		
			}
		//echo "<pre>";	print_r($insertOpt); exit;
			$this->db->insert_batch('marketing_size_stock',$insertOpt);
			return $this->db->affected_rows();
		}
		else
		{
			if(empty($color))
			{
				$color = 0;
			}
			
			$insertOpt = array(
							'marketingProductId' =>	$organizationProductId,
							'currentStock'		 =>	$stock,
							'size'				 =>	$size,
							'colorId'			 =>	$color
						 );
			$this->db->insert('marketing_size_stock',$insertOpt);
			return $this->db->insert_id();
		}
	}
	
	public function update_size_stock($organizationProductId,$stock,$size='',$color='')
	{
		$insertOpt=	array(
						'currentStock'			=>	$stock,
						
						);
		 $this->db->set('currentStock', $stock, FALSE);
		$this->db->where('marketingProductId',$organizationProductId);
		if(!empty($size)){
		$this->db->where('size',$size);
		}
		if(!empty($color)){
		$this->db->where('colorId',$color);
		}
		$this->db->update('marketing_size_stock'	);
		return $this->db->affected_rows();
	}
	
	public function total_front_product_listing($where='')
	{
        $this->db->select('COUNT(*) AS total');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0');
		$this->db->join('marketing_product_category','marketing_product.marketingProductId = marketing_product_category.marketingProductId');
		$this->db->join('category','marketing_product_category.categoryId = category.categoryId');
        $this->db->where(array('employee.active' => 1, 'product_image.displayOrder' => 1, 'product.active' => 1,'organization_product.currentQty >' => 2));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where))
		{
            $this->db->where($where);
        }
        $result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
        return $total;
	}
	
	public function front_product_listing_test($start=0,$limit='',$where='',$orderBy=1)
	{
        $this->db->select('product_rating_count.*,product.code,organization_product.*,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName AS mainImage,organization.organizationName,marketing_product.currentPrice AS adminPrice,marketing_product_category.categoryId,category.categoryCode,product.weight,product.shippingWeight,min(marketing_product.currentPrice),product_category.categoryId AS mainCatId');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId', 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0');
		$this->db->join('marketing_product_category','marketing_product.marketingProductId = marketing_product_category.marketingProductId');
		$this->db->join('category','product_category.categoryId = category.categoryId');
		
		$this->db->join('organization_product_view_count','product.productId = organization_product_view_count.organizationProductId','left');
		$this->db->join('product_rating_count','product.productId = product_rating_count.productId AND product_rating_count.active = 1','left');

		
        $this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) {
            $this->db->where($where);
        }
		$this->db->group_by('organization_product.productId');
		if($orderBy==1)
		{
	        $this->db->order_by('marketing_product.currentPrice', 'ASC');
		}
		elseif($orderBy==2)
		{
	        $this->db->order_by('marketing_product.currentPrice', 'DESC');
		}
		elseif($orderBy==3)
		{
	       $this->db->order_by('organization_product_view_count.totalViewCount','DESC');	
		}
		
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
	}
	
	public function get_product_all_color_and_size($ProductId)
	{
		$this->db->select('*');
		$this->db->from('marketing_size_stock');
		$this->db->join('colors','marketing_size_stock.colorId = colors.colorId','left');
		$this->db->join('marketing_product','marketing_size_stock.marketingProductId = marketing_product.marketingProductId');
		$this->db->where('marketing_product.productId',$ProductId);
		$result = $this->db->get();
		return $result->result();
	}
	public function total_product_retailer($where='')
	{
		$this->db->select('count(*) as total');
		$this->db->from('organization_product');
		$this->db->join('organization','organization.organizationId=organization_product.organizationId');
		$this->db->join('employee','employee.organizationId=organization_product.organizationId');
		$this->db->join('employee_address','employee.employeeId=employee_address.employeeId');
		$this->db->join('address','address.addressId=employee_address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->where('employee.active',1);
		$this->db->where('(employee.requestStatus = 0 OR employee.requestStatus = 3)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$total_number=$this->db->get()->row();
		return $total_number->total;
		
	}
	public function product_retailer_list($start='',$limit='',$where='')
	{
		$this->db->select('organization_product.*,organization.*,employee.*,state.*,area.*,product.weight,product.shippingWeight');
		$this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('organization','organization.organizationId=organization_product.organizationId');
		$this->db->join('dropship_center','organization.dropshipCentre=dropship_center.dropCenterId');
		$this->db->join('employee','employee.organizationId=organization_product.organizationId');
		$this->db->join('organization_address','organization.organizationId=organization_address.organizationId');
		$this->db->join('address','address.addressId=organization_address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		
		if($this->session->userdata('userType')=='cse')
		{
			$this->db->join('emp_role','employee.employeeId = emp_role.employeeId');
			$this->db->join('role','role.roleID = emp_role.roleId');
			$this->db->join('csr_organization','organization.organizationId = csr_organization.organizationId');
			$this->db->where(array('role.code' => 'CORPADMIN','csr_organization.employeeId' => $this->session->userdata('userId')));
		}
		$this->db->where('employee.active',1);
		$this->db->where('(employee.requestStatus = 0 OR employee.requestStatus = 3)');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		return $this->db->get()->result();
	}
	
	public function product_retailer_inventorydetail($organizationProductId)
	{
		$this->db->select('organization_product.*,employee.*,organization.*,product.weight,product.shippingWeight');
		$this->db->from('organization_product');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('organization','organization.organizationId=organization_product.organizationId');
		$this->db->join('employee','employee.organizationId=organization_product.organizationId');
		$this->db->join('organization_address','organization.organizationId=organization_address.organizationId');
		$this->db->join('address','address.addressId=organization_address.addressId');
		$this->db->join('country','address.country = country.countryId','left');
		$this->db->join('state','address.state = state.stateId','left');
		$this->db->join('area','address.area = area.areaId','left');
		$this->db->where('organization_product.organizationProductId',$organizationProductId);
		if(!empty($where))
		{
			$this->db->where($where);
		}
		if(!empty($start))
		{
			$this->db->limit($limit,$start);
		}
		return $this->db->get()->row();
	
	}
	
	public function single_product_with_retailer_detail($productId)
    {
	    $this->db->select('marketing_product.*,organization.organizationName,organization.dropshipCentre,product.*,brand.brandName,dropship_center.*');
        $this->db->from('marketing_product');
		$this->db->join('organization_product','marketing_product.organizationProductId=organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId=organization.organizationId');
		$this->db->join('dropship_center','organization.organizationId = dropship_center.dropCenterId','left');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('brand','brand.brandId=product.brandId','left');
		$this->db->where('marketing_product.productId', $productId);
		$this->db->order_by('marketing_product.currentPrice','asc');
        $result = $this->db->get()->row();
        return $result;
	}
	
	public function marketing_product_details($organizationProductId)
	{
	    $this->db->select('marketing_product.*,product.code,product_image.imageName');
        $this->db->from('marketing_product');
		$this->db->join('organization_product','marketing_product.organizationProductId=organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId=organization.organizationId');
		$this->db->join('dropship_center','organization.organizationId = dropship_center.dropCenterId','left');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('product_image','product.productId = product_image.productId');
		$this->db->join('brand','brand.brandId=product.brandId','left');
		$this->db->where(array('marketing_product.organizationProductId' => $organizationProductId,'product_image.displayOrder' => 1));
		$this->db->order_by('marketing_product.currentPrice','asc');
        $result = $this->db->get()->row();
        return $result;
	}
	public function parent_category_listing($categoryId)
	{
		$this->db->select('t1.categoryId,t2.categoryId as parent,t3.categoryId as parent1,t4.categoryId as parent2 ,t5.categoryId as parent3 ,t6.categoryId as parent4,t7.categoryId as parent5, t8.categoryId as parent6 ,');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t1.parentCategoryId = t2.categoryId','left');
		$this->db->join('category AS t3','t2.parentCategoryId = t3.categoryId','left');
		$this->db->join('category AS t4','t3.parentCategoryId = t4.categoryId','left');
		$this->db->join('category AS t5','t4.parentCategoryId = t5.categoryId','left');
		$this->db->join('category AS t6','t5.parentCategoryId = t6.categoryId','left');
		$this->db->join('category AS t7','t6.parentCategoryId = t7.categoryId','left');
		$this->db->join('category AS t8','t7.parentCategoryId = t8.categoryId','left');
		$this->db->where('t1.categoryId',$categoryId);
		return $this->db->get()->row();
		
	}
	public function delete_marketing_size_stock($marketingProductId)
	{
		$this->db->where('marketingProductId',$marketingProductId);
		$this->db->delete('marketing_size_stock');
		return $this->db->affected_rows();
	}
	
	public function home_flash_sales_product_list()
	{
	    $this->db->select('marketing_product.*,organization.organizationName,organization.dropshipCentre,product.*,brand.brandName,dropship_center.*,(100-((marketing_product.currentPrice/marketing_product.costPrice)*100)) AS perc,product_image.imageName AS productImageName,product.code,organization_product.currentPrice AS organizationPrice,product.weight,product.shippingWeight,organization_product.organizationProductId');
        $this->db->from('marketing_product');
		$this->db->join('organization_product','marketing_product.organizationProductId=organization_product.organizationProductId');
		$this->db->join('organization','organization_product.organizationId=organization.organizationId');
		$this->db->join('dropship_center','organization.organizationId = dropship_center.dropCenterId','left');
		$this->db->join('product','product.productId=marketing_product.productId');
		$this->db->join('brand','brand.brandId=product.brandId','left');
		$this->db->join('product_image','product.productId=product_image.productId');
		$this->db->where(array(
							'product_image.displayOrder' => 1,
							'marketing_product.active' => 1,
							'organization_product.currentQty >' => 2,
							'DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <=' => date('Y-m-d'),
							'DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >=' => date('Y-m-d')
						));
		$this->db->where_not_in('marketing_product.currentQty',0);
		$this->db->order_by('perc','desc');
		$this->db->limit(36);
        $result = $this->db->get()->result();
        return $result;
	}
	
	public function add_marketing_inventory_history($marketingProductId,$addArr)
	{
		//echo "<pre>"; print_r($addArr); exit;
	}
	
	public function exclusives_product_listing($start=0,$limit='',$where='',$orderBy=1)
	{
		$this->db->select('product_rating_count.*,product.code,organization_product.*,brand.brandId,brand.brandName,organization_product.productId,product_image.imageName,organization.organizationName,marketing_product.currentPrice AS marketingPrice,category.categoryId,category.categoryCode,product.weight,product.shippingWeight');
        $this->db->from('organization_product');
        $this->db->join('product', 'organization_product.productId = product.productId');
        $this->db->join('product_category', 'organization_product.productId = product_category.productId');
        $this->db->join('category','product_category.categoryId = category.categoryId');
		$this->db->join('product_image', 'product.productId = product_image.productId');
        $this->db->join('organization', 'organization_product.organizationId = organization.organizationId');
        $this->db->join('employee', 'organization.organizationId = employee.organizationId');
        $this->db->join('dropship_center', 'organization.dropshipCentre = dropship_center.dropCenterId');
        $this->db->join('brand', 'product.brandId = brand.brandId'); //, 'left');
        $this->db->join('marketing_product', 'organization_product.organizationProductId = marketing_product.organizationProductId AND marketing_product.active = 1 AND (DATE_FORMAT(marketing_product.effectiveDtFrom,"%Y-%m-%d") <= "'.date('Y-m-d').'" AND DATE_FORMAT(marketing_product.effectiveDtTo,"%Y-%m-%d") >= "'.date('Y-m-d').'") AND marketing_product.currentQty > 0');
		$this->db->join('marketing_product_category','marketing_product.marketingProductId = marketing_product_category.marketingProductId');
		$this->db->join('organization_product_view_count','product.productId = organization_product_view_count.organizationProductId','left');
		$this->db->join('product_rating_count','product.productId = product_rating_count.productId AND product_rating_count.active = 1','left');

		$this->db->where(array(
							'employee.active' => 1, 
							'product_image.displayOrder' => 1, 
							'product.active' => 1,
							'organization_product.currentQty >' => 2,
							'category.active' => 1,
							'brand.active' => 1
						));
		$this->db->where('(product.verificationResultId = 2 OR product.verificationResultId = 5)');
        if (!empty($where)) 
		{
            $this->db->where($where);
        }
        
		if($orderBy==1)
		{
	        $this->db->order_by('marketing_product.currentPrice', 'ASC');
		}
		elseif($orderBy==2)
		{
	        $this->db->order_by('marketing_product.currentPrice', 'DESC');
		}
		elseif($orderBy==3)
		{
	       $this->db->order_by('organization_product_view_count.totalViewCount','DESC');	
		}
		
        if(!empty($limit)) 
		{
            $this->db->limit($limit, $start);
        }
        $result = $this->db->get();
        return $result->result();
	}
	
	public function unactive_marketing_product($marketingProductId)
	{
		$updateOpt = array(
					 	'active'         => 0,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					 );
		$this->db->where('marketingProductId',$marketingProductId);
		$this->db->update('marketing_product',$updateOpt);
		return $this->db->affected_rows();		 
	}
	
	public function marketing_inventory_details($organizationProductId)
	{
		$this->db->select('marketing_product.*');
		$this->db->from('marketing_product');
		$this->db->join('organization_product','marketing_product.organizationProductId = organization_product.organizationProductId');
		$this->db->where(array('marketing_product.organizationProductId' => $organizationProductId,'marketing_product.active' => 1));
		$this->db->order_by('marketing_product.marketingProductId','DESC');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function update_marketing_sale_inventory($marketingProductId,$currentPrice)
	{
		$updateOpt = array(
						'currentPrice'	 => $currentPrice,
						'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					 );
		$this->db->where(array('marketingProductId' => $marketingProductId,'active' => 1));
		$this->db->update('marketing_product',$updateOpt);
		return $this->db->affected_rows();	
	}
}
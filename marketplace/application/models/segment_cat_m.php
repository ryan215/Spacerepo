<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Segment_cat_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add_category($addArr)
	{
		$insertOpt = array(
						'categoryCode'        => $addArr['categoryCode'],
						'categoryDescription' => $addArr['categoryDescription'],
						'createDt'			  => date('Y-m-d H:i:s'),
						'lastModifiedDt'	  => date('Y-m-d H:i:s'),
						'lastModifiedBy'   	  => $this->session->userdata('userId'),
					  );	
		if((!empty($addArr['parentCategoryId']))&&($addArr['parentCategoryId']))
		{
			$insertOpt['parentCategoryId'] = $addArr['parentCategoryId'];
		}
		if((!empty($addArr['isMarketing']))&&($addArr['isMarketing']))
		{
			$insertOpt['isMarketing'] = $addArr['isMarketing'];
		}
		$this->db->insert('category',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function semantics_category_list_dropdown($parentCatID=0,$category_id=0,$level='')
	{
		$catList = '';
		$level=$level+1;
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}
		$return ='<label>level'.$level.'</label>';
		$return  .= '<select class="form-control" name="level'.$level.'" id="category_id" onchange="cat_list(this.value,'.$level.');">';
		$return.= '<option value="">Select Level-'.$level.'</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function marketing_category_list_dropdown($parentCatID=0,$category_id=0,$level='')
	{
		$catList = '';
		$level=$level+1;
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->marketing_category_list(0,'','',$parentCatID);		
		}
		$return ='<label>level'.$level.'</label>';
		$return  .= '<select class="form-control" name="level'.$level.'" id="category_id" onchange="cat_list(this.value,'.$level.');">';
		$return.= '<option value="">Select Level-'.$level.'</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function update_category($category_id,$updateArr)
	{
		$updateOpt = array(
					 	'categoryCode'        => $updateArr['categoryCode'],
						'categoryDescription' => $updateArr['categoryDescription'],
						'lastModifiedDt'	  => date('Y-m-d H:i:s'),
						'lastModifiedBy'   	  => $this->session->userdata('userId'),
					 );
	 if((!empty($addArr['isMarketing']))&&($addArr['isMarketing']))
		{
			$insertOpt['isMarketing'] = $addArr['isMarketing'];
		}
		$this->db->where('categoryId',$category_id);
		$this->db->update('category',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function delete_category($categoryId)
	{
		$this->db->where('categoryId',$categoryId);
		$this->db->delete('category');
		return $this->db->affected_rows();
	}
	
	public function total_segment($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('category');
		$this->db->where('parentCategoryId IS NULL');	
		$this->db->where('isMarketing',0);	
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total  = $result->total;
		}
		return $total;
	}
	
	public function segment_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('category');
		$this->db->where('parentCategoryId IS NULL');
		$this->db->where('isMarketing',0);
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$this->db->order_by('lastModifiedDt','desc');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function marketing_segment_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('category');
		$this->db->where('parentCategoryId IS NULL');
		$this->db->where('isMarketing',1);
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$this->db->order_by('lastModifiedDt','desc');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function category_details($categoryId)
	{
		$this->db->where('categoryId',$categoryId);
		$result = $this->db->get('category')->row();
		return $result;
	}
	
	public function category_name_check($checkArr)
	{
		$cond = array('categoryCode' => $checkArr['categoryCode']);
		if((!empty($checkArr['parentCategoryId']))&&($checkArr['parentCategoryId']))
		{
			$cond['parentCategoryId'] = $checkArr['parentCategoryId'];
		}
		$this->db->where($cond);
		$result = $this->db->get('category')->row();
		return $result;
	}
	
	public function marketing_category_name_check($checkArr)
	{
		$cond = array('categoryCode' => $checkArr['categoryCode'],'isMarketing' => 1);
		if((!empty($checkArr['parentCategoryId']))&&($checkArr['parentCategoryId']))
		{
			$cond['parentCategoryId'] = $checkArr['parentCategoryId'];
		}
		$this->db->where($cond);
		$result = $this->db->get('category')->row();
		return $result;
	}
	
	public function total_category($parent_id=0,$where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('category');
		if($parent_id)
		{
			$this->db->where('parentCategoryId',$parent_id);
		}
		else
		{
			$this->db->where('parentCategoryId IS NULL');
		}
		
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total  = $result->total;
		}
		return $total;
	}
	
	public function category_list($start=0,$limit='',$where='',$parent_id=0)
	{
		$this->db->select('*');
		$this->db->from('category');
		if($parent_id)
		{
			$this->db->where('parentCategoryId',$parent_id);
		}
		else
		{
			$this->db->where('parentCategoryId IS NULL');
		}
		$this->db->where(array('isMarketing' => 0,'active' => 1));
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$this->db->order_by('categoryCode','ASC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function marketing_category_list($start=0,$limit='',$where='',$parent_id=0)
	{
		$this->db->select('*');
		$this->db->from('category');
		if($parent_id)
		{
			$this->db->where('parentCategoryId',$parent_id);
		}
		else
		{
			$this->db->where('parentCategoryId IS NULL');
		}
		$this->db->where('isMarketing',1);
		if(!empty($where))
		{
			$this->db->where($where);			
		}
		$this->db->order_by('categoryCode','ASC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		
		$result = $this->db->get()->result();
		return $result;
	}
		
	public function header_category()
	{
		$this->db->select('t1.categoryId AS level1ID,t1.categoryCode AS level1Name, t2.categoryId as level2ID,t2.categoryCode AS level2Name, t3.categoryId as level3ID,t3.categoryCode AS level3Name');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t2.parentCategoryId = t1.categoryId','left');
		$this->db->join('category AS t3','t3.parentCategoryId = t2.categoryId','left');
		$this->db->where('t1.parentCategoryId IS NULL');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function product_acording_level($categoryId)
	{
		$this->db->select('organization_product.*,brand.brandId,brand.brandName');
		$this->db->from('organization_product');
		$this->db->join('product_category','organization_product.productId = product_category.productId');
		$this->db->join('organization','organization_product.organizationId = organization.organizationId');
		$this->db->join('employee','organization.organizationId = employee.organizationId');
		$this->db->join('category','product_category.categoryId = category.categoryId');
		$this->db->join('product','organization_product.productId = product.productId');
		$this->db->join('brand','product.brandId = brand.brandId');
		$this->db->where('(organization.dropshipCentre = 1 OR organization.dropshipCentre = 2)');
		$this->db->where('employee.active',1);
		$this->db->where('product_category.categoryId',$categoryId);
		$this->db->order_by('organization_product.currentPrice','asc');
		$result = $this->db->get();
		return $result->result();		
	}
	
	public function category3_level($categoryId)
	{
		$this->db->select('t1.categoryId AS level1ID,t1.categoryCode AS level1Name,t1.parentCategoryId AS levelParent1ID,
t2.categoryId as level2ID,t2.categoryCode AS level2Name,t2.parentCategoryId AS levelParent2ID,
t3.categoryId as level3ID,t3.categoryCode AS level3Name,t3.parentCategoryId AS levelParent3ID');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t2.parentCategoryId = t1.categoryId','left');
		$this->db->join('category AS t3','t3.parentCategoryId = t2.categoryId','left');
		$this->db->join('category AS t4','t4.parentCategoryId = t3.categoryId','left');
		//$this->db->where('t1.parentCategoryId IS NULL AND ( t1.categoryId ='.$categoryId.' OR t2.categoryId ='.$categoryId.' OR t3.categoryId ='.$categoryId.')');
		$this->db->where('t1.categoryId',$categoryId);
		$result = $this->db->get();
		return $result->result();
	}
	
	public function home_page_promotion()
	{
		$result = $this->db->where('active',1)->get('home_page_promotion');
		return $result->result();
	}
	
	public function category_list_dropdown($parentCatID=0,$category_id=0,$level='')
	{
		$catList = '';
		$level=$level+1;
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}
		$return ='<label>level'.$level.'</label>';
		$return  .= '<select class="form-control" name="level'.$level.'" id="category_id" onchange="sub_category1_list(this.value,'.$level.');">';
		$return.= '<option value="">Select Level-'.$level.'</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}

	public function sub_category1_list_dropdown($parentCatID=0,$category_id=0)
	{
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}
		$return  = '<select class="form-control" name="sub_category1_id" id="sub_category1_id" onchange="subcat2_list(this.value);">';
		$return.= '<option value="">Select Level-3</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function sub_category2_list_dropdown($parentCatID=0,$category_id=0)
	{
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}

		$return  = '<select class="form-control" name="sub_category2_id" id="sub_category2_id" onchange="subcat3_list(this.value);">';
		$return.= '<option value="">Select Level-4</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
		
	public function sub_category3_list_dropdown($parentCatID=0,$category_id=0)
	{
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}	
		$return  = '<select class="form-control" name="sub_category3_id" id="sub_category3_id" onchange="subcat4_list(this.value);">';
		$return.= '<option value="">Select Level-5</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function sub_category4_list_dropdown($parentCatID=0,$category_id=0)
	{
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}		
		$return  = '<select class="form-control" name="sub_category4_id" id="sub_category4_id" onchange="subcat5_list(this.value);">';
		$return.= '<option value="">Select Level-6</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function sub_category5_list_dropdown($parentCatID=0,$category_id=0)
	{
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}	
		$return  = '<select class="form-control" name="sub_category5_id" id="sub_category5_id" onchange="subcat6_list(this.value);">';
		$return.= '<option value="">Select Level-7</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function sub_category6_list_dropdown($parentCatID=0,$category_id=0)
	{	
		$catList = '';
		if($parentCatID)
		{
			$catList = $this->segment_cat_m->category_list(0,'','',$parentCatID);		
		}	
		$return  = '<select class="form-control" name="sub_category6_id" id="sub_category6_id" >';
		$return.= '<option value="">Select Level-8</option>';
		
		if(!empty($catList))
		{			
			foreach($catList as $row)
			{
				$selected = '';
				if($row->categoryId==$category_id)
				{
					$selected = 'selected="selected"';
				}
				$return.= '<option value="'.$row->categoryId.'" '.$selected.'>';
				$return.= $row->categoryCode; 
				$return.= '</option>';
			}
		}
		else
		{
			return '';
		}
		$return.= '</select>';
		return $return;
	}
	
	public function auto_search($search)
	{	
		$this->db->like('categoryCode',$search,'after'); 
		$result = $this->db->get('category');
		return $result->result();
	}
	
	public function category_level($parentCatId)
	{
		$this->db->select('t1.categoryId AS level1ID,t1.categoryCode AS level1Name,t1.parentCategoryId AS levelParent1ID,
t2.categoryId as level2ID,t2.categoryCode AS level2Name,t2.parentCategoryId AS levelParent2ID,
t3.categoryId as level3ID,t3.categoryCode AS level3Name,t3.parentCategoryId AS levelParent3ID,
t4.categoryId as level4ID,t4.categoryCode AS level4Name,t4.parentCategoryId AS levelParent4ID,
t5.categoryId as level5ID,t5.categoryCode AS level5Name,t5.parentCategoryId AS levelParent5ID,
t6.categoryId as level6ID,t6.categoryCode AS level6Name,t6.parentCategoryId AS levelParent6ID,
t7.categoryId as level7ID,t7.categoryCode AS level7Name,t7.parentCategoryId AS levelParent7ID,
t8.categoryId as level8ID,t8.categoryCode AS level8Name,t8.parentCategoryId AS levelParent8ID,
t9.categoryId as level9ID,t9.categoryCode AS level9Name,t9.parentCategoryId AS levelParent9ID,
t10.categoryId as level10ID,t10.categoryCode AS level10Name,t10.parentCategoryId AS levelParent10ID');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t2.parentCategoryId = t1.categoryId','left');
		$this->db->join('category AS t3','t3.parentCategoryId = t2.categoryId','left');
		$this->db->join('category AS t4','t4.parentCategoryId = t3.categoryId','left');
		$this->db->join('category AS t5','t5.parentCategoryId = t4.categoryId','left');
		$this->db->join('category AS t6','t6.parentCategoryId = t5.categoryId','left');
		$this->db->join('category AS t7','t7.parentCategoryId = t6.categoryId','left');
		$this->db->join('category AS t8','t8.parentCategoryId = t7.categoryId','left');
		$this->db->join('category AS t9','t9.parentCategoryId = t8.categoryId','left');
		$this->db->join('category AS t10','t10.parentCategoryId = t9.categoryId','left');
		$this->db->where('t1.parentCategoryId IS NULL AND ( t1.categoryId ='.$parentCatId.' OR t2.categoryId ='.$parentCatId.' OR t3.categoryId ='.$parentCatId.' OR t4.categoryId ='.$parentCatId.' OR t5.categoryId ='.$parentCatId.' OR t6.categoryId ='.$parentCatId.' OR t7.categoryId ='.$parentCatId.' OR t8.categoryId ='.$parentCatId.' OR t9.categoryId ='.$parentCatId.' OR t10.categoryId ='.$parentCatId.')');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function category_level10()
	{
		$this->db->select('t1.categoryId AS level1ID,t1.categoryCode AS level1Name,t1.parentCategoryId AS levelParent1ID,
t2.categoryId as level2ID,t2.categoryCode AS level2Name,t2.parentCategoryId AS levelParent2ID,
t3.categoryId as level3ID,t3.categoryCode AS level3Name,t3.parentCategoryId AS levelParent3ID,
t4.categoryId as level4ID,t4.categoryCode AS level4Name,t4.parentCategoryId AS levelParent4ID,
t5.categoryId as level5ID,t5.categoryCode AS level5Name,t5.parentCategoryId AS levelParent5ID,
t6.categoryId as level6ID,t6.categoryCode AS level6Name,t6.parentCategoryId AS levelParent6ID,
t7.categoryId as level7ID,t7.categoryCode AS level7Name,t7.parentCategoryId AS levelParent7ID,
t8.categoryId as level8ID,t8.categoryCode AS level8Name,t8.parentCategoryId AS levelParent8ID,
t9.categoryId as level9ID,t9.categoryCode AS level9Name,t9.parentCategoryId AS levelParent9ID,
t10.categoryId as level10ID,t10.categoryCode AS level10Name,t10.parentCategoryId AS levelParent10ID');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t2.parentCategoryId = t1.categoryId','left');
		$this->db->join('category AS t3','t3.parentCategoryId = t2.categoryId','left');
		$this->db->join('category AS t4','t4.parentCategoryId = t3.categoryId','left');
		$this->db->join('category AS t5','t5.parentCategoryId = t4.categoryId','left');
		$this->db->join('category AS t6','t6.parentCategoryId = t5.categoryId','left');
		$this->db->join('category AS t7','t7.parentCategoryId = t6.categoryId','left');
		$this->db->join('category AS t8','t8.parentCategoryId = t7.categoryId','left');
		$this->db->join('category AS t9','t9.parentCategoryId = t8.categoryId','left');
		$this->db->join('category AS t10','t10.parentCategoryId = t9.categoryId','left');
		$this->db->where('t1.parentCategoryId IS NULL');
		$this->db->where('t1.isMarketing',0);
		$result = $this->db->get();
		return $result->result();
	}

	public function category_level_row($parentCatId)
	{
		$this->db->select('t1.categoryId AS level1ID,t1.categoryCode AS level1Name,t1.parentCategoryId AS levelParent1ID,
t2.categoryId as level2ID,t2.categoryCode AS level2Name,t2.parentCategoryId AS levelParent2ID,
t3.categoryId as level3ID,t3.categoryCode AS level3Name,t3.parentCategoryId AS levelParent3ID,
t4.categoryId as level4ID,t4.categoryCode AS level4Name,t4.parentCategoryId AS levelParent4ID,
t5.categoryId as level5ID,t5.categoryCode AS level5Name,t5.parentCategoryId AS levelParent5ID,
t6.categoryId as level6ID,t6.categoryCode AS level6Name,t6.parentCategoryId AS levelParent6ID,
t7.categoryId as level7ID,t7.categoryCode AS level7Name,t7.parentCategoryId AS levelParent7ID,
t8.categoryId as level8ID,t8.categoryCode AS level8Name,t8.parentCategoryId AS levelParent8ID,
t9.categoryId as level9ID,t9.categoryCode AS level9Name,t9.parentCategoryId AS levelParent9ID,
t10.categoryId as level10ID,t10.categoryCode AS level10Name,t10.parentCategoryId AS levelParent10ID');
		$this->db->from('category AS t1');
		$this->db->join('category AS t2','t2.parentCategoryId = t1.categoryId','left');
		$this->db->join('category AS t3','t3.parentCategoryId = t2.categoryId','left');
		$this->db->join('category AS t4','t4.parentCategoryId = t3.categoryId','left');
		$this->db->join('category AS t5','t5.parentCategoryId = t4.categoryId','left');
		$this->db->join('category AS t6','t6.parentCategoryId = t5.categoryId','left');
		$this->db->join('category AS t7','t7.parentCategoryId = t6.categoryId','left');
		$this->db->join('category AS t8','t8.parentCategoryId = t7.categoryId','left');
		$this->db->join('category AS t9','t9.parentCategoryId = t8.categoryId','left');
		$this->db->join('category AS t10','t10.parentCategoryId = t9.categoryId','left');
		$this->db->where('t1.parentCategoryId IS NULL AND ( t1.categoryId ='.$parentCatId.' OR t2.categoryId ='.$parentCatId.' OR t3.categoryId ='.$parentCatId.' OR t4.categoryId ='.$parentCatId.' OR t5.categoryId ='.$parentCatId.' OR t6.categoryId ='.$parentCatId.' OR t7.categoryId ='.$parentCatId.' OR t8.categoryId ='.$parentCatId.' OR t9.categoryId ='.$parentCatId.' OR t10.categoryId ='.$parentCatId.')');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function organization_category_list()
	{
		$this->db->select('*');
		$this->db->from('organization_category');
		$this->db->order_by('categoryId','asc');
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function update_category_commission($categoryId,$addArr)
	{
		$updateOpt = array(
						'commission'     => $addArr['categoryCommission'],
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('categoryId',$categoryId);
		$this->db->update('category',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_category_commission_history($categoryId,$addArr)
	{
		$insertOpt = array(
						'categoryId'     => $categoryId,
						'commission'     => $addArr['categoryCommission'],
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->insert('category_commission_history',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_price_management($addArr)
	{
		$insertOpt = array(
						'fromPrice'     		=> $addArr['fromPrice'],
						'toPrice'     			=> $addArr['toPrice'],
						'spacePointeCommission' => $addArr['spacePointeCommission'],
						'adminFee'     			=> $addArr['adminPrice'],
						'genuineShippingFee'    => $addArr['genuineShippingFee'],
						'active'    			=> 1,
						'createDt'				=> date('Y-m-d H:i:s'),
						'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 		=> $this->session->userdata('userId'),
					 );
		$this->db->insert('price_management',$insertOpt);
		return $this->db->insert_id();
	}	
	
	public function update_price_management($priceMngtId,$updateArr)
	{
		$updateOpt = array(
						'fromPrice'     		=> $updateArr['fromPrice'],
						'toPrice'     			=> $updateArr['toPrice'],
						'spacePointeCommission' => $updateArr['spacePointeCommission'],
						'adminFee'     			=> $updateArr['adminPrice'],
						'genuineShippingFee'    => $updateArr['genuineShippingFee'],
						'active'    			=> 1,
						'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 		=> $this->session->userdata('userId'),
					 );
		$this->db->where('priceMngtId',$priceMngtId);
		$this->db->update('price_management',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_price_management_history($priceMngtId,$addArr)
	{
		$insertOpt = array(
						'priceMngtId'			=> $priceMngtId,
						'fromPrice'     		=> $addArr['fromPrice'],
						'toPrice'     			=> $addArr['toPrice'],
						'spacePointeCommission' => $addArr['spacePointeCommission'],
						'adminFee'     			=> $addArr['adminPrice'],
						'genuineShippingFee'    => $addArr['genuineShippingFee'],
						'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 		=> $this->session->userdata('userId'),
					 );
		$this->db->insert('price_management_history',$insertOpt);
		return $this->db->insert_id();
	}	
	
	public function total_price_management($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('price_management');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->where('active',1);
		$result = $this->db->get()->row();
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function price_management_list($start=0,$limit='',$where='')
	{
		$this->db->select('*');
		$this->db->from('price_management');
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->where('active',1);
		$this->db->order_by('createDt','DESC');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		$result = $this->db->get()->result();
		return $result;
	}
	
	public function check_from_price_exists($priceMngtId,$fromPrice)
	{
		$this->db->select('*');
		$this->db->from('price_management');
		$this->db->where(array(
							'fromPrice <=' => $fromPrice,
							'toPrice >='   => $fromPrice,
							'active'       => 1,
						));
		if($priceMngtId)
		{
			$this->db->where('priceMngtId !=',$priceMngtId);
		}
		$result = $this->db->get();
		return $result->row();
	}
	
	public function check_to_price_exists($priceMngtId,$toPrice)
	{
		$this->db->select('*');
		$this->db->from('price_management');
		$this->db->where(array(
							'fromPrice <=' => $toPrice,
							'toPrice >='   => $toPrice,
							'active'       => 1,
						));
		if($priceMngtId)
		{
			$this->db->where_not_in('priceMngtId',$priceMngtId);
		}
		$result = $this->db->get();
		return $result->row();
	}
	
	public function delete_old_price_management($priceMngtId)
	{
		$this->db->where('priceMngtId',$priceMngtId);
		$this->db->update('price_management',array('active' => 0,'lastModifiedBy' => $this->session->userdata('userId'),'lastModifiedDt' => date('Y-m-d H:i:s')));
		return $this->db->affected_rows();
	}
	
	public function get_price_details($priceMngtId)
	{
		$this->db->where('priceMngtId',$priceMngtId);
		$result = $this->db->get('price_management')->row();
		return $result;
	}
	
	public function check_from_to_price_exists($priceMngtId,$checkArr)
	{
		$this->db->select('*');
		$this->db->from('price_management');
		$this->db->where(array(
							'fromPrice >=' => $checkArr['fromPrice'],
							'toPrice <='   => $checkArr['toPrice'],
							'active'       => 1,
						));
		if($priceMngtId)
		{
			$this->db->where_not_in('priceMngtId',$priceMngtId);
		}
		$result = $this->db->get();
		return $result->row();
	}
	
	public function get_price_range($priceRange)
	{
		$this->db->select('*');
		$this->db->from('price_management');
		$this->db->where(array(
							'fromPrice <=' => $priceRange,
							'toPrice >='   => $priceRange,
							'active'       => 1,
						));
		$this->db->order_by('lastModifiedDt','DESC');
		$result = $this->db->get();
		return $result->row();
	}
	
	public function add_free_shipping_category($categoryId)
	{
		$insertOpt = array(
						'categoryId'			=> $categoryId,
						'isFreeShipping'   		=> 1,
						'active'     			=> 1,
						'lastModifiedDt' 		=> date('Y-m-d H:i:s'),
						'lastModifiedBy' 		=> $this->session->userdata('userId'),
					 );
		$this->db->insert('category_free_shipping',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function total_free_shipping_category($where='')
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('category_free_shipping');
		$this->db->join('category','category_free_shipping.categoryId = category.categoryId');
		$this->db->where(array('category_free_shipping.active' => 1));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$result = $this->db->get()->row();
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
	
	public function free_shipping_category_list($start=0,$limit='',$where='')
	{
		$this->db->select('category_free_shipping.*,category.categoryCode');
		$this->db->from('category_free_shipping');
		$this->db->join('category','category_free_shipping.categoryId = category.categoryId');
		$this->db->where(array('category_free_shipping.active' => 1));
		if(!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->order_by('category_free_shipping.lastModifiedDt','DESC');
		if($limit)
		{
			$this->db->limit($limit,$start);
		}
		
		$result = $this->db->get()->result();
		return $result;	
	}
	
	public function delete_free_shipping_category($freeShipCatId)
	{
		$updateOpt = array(
					 	'active'         => 0,
						'lastModifiedDt' => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),
					 );
		$this->db->where('freeShipCatId',$freeShipCatId);
		$this->db->update('category_free_shipping',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function free_shipping_category_detail($freeShipCatId)
	{
		$this->db->where(array('freeShipCatId' => $freeShipCatId,'active' => 1));
		$result = $this->db->get('category_free_shipping')->row();
		return $result;
	}
	
	public function category_parent_list($categoryId)
	{
		$result = $this->db->query('SELECT t2.`categoryId`, t2.`categoryCode`,t2.`parentCategoryId`, level FROM ( SELECT @r AS `_categoryId`, ( SELECT @r := `parentCategoryId` FROM category WHERE `categoryId` = `_categoryId` ) AS `parentCategoryId`, @l := @l + 1 AS level FROM ( SELECT @r := '.$categoryId.', @l := 0 ) vars, category u WHERE @r <> 0 ) t1 JOIN category t2 ON t1.`_categoryId` = t2.`categoryId` ORDER BY t1.level DESC');
		return $result->result();
	}
	
	public function category_child_list($categoryId)
	{
		$result = $this->db->query("SELECT GROUP_CONCAT(lv SEPARATOR ',') AS childList FROM ( SELECT @pv:=(SELECT GROUP_CONCAT(`categoryId` SEPARATOR ',') FROM category WHERE `parentCategoryId` IN (@pv)) AS lv FROM category JOIN (SELECT @pv:=".$categoryId.")tmp WHERE `parentCategoryId` IN (@pv)) a");
		return $result->row();
	}
	
	public function category_all_child_list($categoryId)
	{
		$result = $this->db->query("SELECT GROUP_CONCAT(lv SEPARATOR ',') AS allChild FROM (SELECT @pv:=( SELECT GROUP_CONCAT(`categoryId` SEPARATOR ',') FROM category WHERE FIND_IN_SET(`parentCategoryId`, @pv) ) AS lv FROM category JOIN (SELECT @pv:=".$categoryId.")tmp WHERE `parentCategoryId` IN (@pv) ) a");
		return $result->row();
	}
	
	public function product_category_all_child_list($categoryId)
	{
		$result = $this->db->query("SELECT 
										GROUP_CONCAT(lv SEPARATOR ',') AS allChild 
									FROM 
										(
		SELECT @pv:=( SELECT GROUP_CONCAT(category.`categoryId` SEPARATOR ',') 
		FROM 
			category 
		INNER JOIN
			 product_category
		ON
			category.categoryId = product_category.categoryId
		INNER JOIN
			product
		ON
			product_category.productId = product.productId
		INNER JOIN
			organization_product
		ON
			product.productId = organization_product.productId
		INNER JOIN
			brand
		ON
			product.brandId = brand.brandId
		INNER JOIN
			organization
		ON
			organization_product.organizationId = organization.organizationId
		INNER JOIN
			employee
		ON
			organization.organizationId = employee.organizationId
		INNER JOIN
			dropship_center
		ON
			organization.dropshipCentre = dropship_center.dropCenterId
		WHERE
			( 	
				category.`categoryId` = ".$categoryId."
			OR
				FIND_IN_SET(category.`parentCategoryId`, @pv) 			
			)
			AND
				(product.verificationResultId = 2 OR product.verificationResultId = 5)
			AND
				organization_product.currentQty > 2
			AND
				product.active = 1
			AND
				category.isMarketing = 0
			AND
				category.active = 1
			AND
				brand.active = 1
			AND
				employee.active = 1
	) AS lv 
FROM 
	category
JOIN 
	(SELECT @pv:=".$categoryId.")tmp 
WHERE 
	`parentCategoryId` IN (@pv) ) a
");
		return $result->row();
	}
	
	public function free_shippng_cat_details($categoryId)
	{
		$this->db->select('category_free_shipping.*,category.categoryCode');
		$this->db->from('category_free_shipping');
		$this->db->join('category','category_free_shipping.categoryId = category.categoryId');
		$this->db->where(array('category_free_shipping.active' => 1,'category_free_shipping.categoryId' => $categoryId));
		$result = $this->db->get()->row();
		return $result;
	}
	
	public function free_shipping_multiple_category($where)
	{
		if(!empty($where))
		{
			$this->db->select('*');
			$this->db->from('category_free_shipping');
			$this->db->where('active',1);
			$this->db->where($where);
			$this->db->order_by('categoryId','ASC');
			$result = $this->db->get();
			return $result->result();
		}
		return FALSE;
	}
	
	public function block_category_status($categoryId)
	{
		$updateOpt = array(
							'active'         => 0,
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $this->session->userdata('userId'),
						);
		$this->db->where('categoryId',$categoryId);
		$this->db->update('category',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function unblock_category_status($categoryId)
	{
		$updateOpt = array(
							'active'         => 1,
							'lastModifiedDt' => date('Y-m-d H:i:s'),
							'lastModifiedBy' => $this->session->userdata('userId'),
						);
		$this->db->where('categoryId',$categoryId);
		$this->db->update('category',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function parent_category_with_commission($categoryId)
	{
		$result = $this->db->query('SELECT t2.`categoryId`, t2.`categoryCode`,t2.`parentCategoryId`,t2.`commission`,t2.`spacepointeCommission2`, level FROM ( SELECT @r AS `_categoryId`, ( SELECT @r := `parentCategoryId` FROM category WHERE `categoryId` = `_categoryId` ) AS `parentCategoryId`, @l := @l + 1 AS level FROM ( SELECT @r := '.$categoryId.', @l := 0 ) vars, category u WHERE @r <> 0 ) t1 JOIN category t2 ON t1.`_categoryId` = t2.`categoryId` ORDER BY t1.level DESC');
		return $result->row();
	}
	
	public function update_spacepointe_commission2($categoryId,$updateArr)
	{
		$updateOpt = array(
						'spacepointeCommission2' => $updateArr['categoryCommission'],
						'lastModifiedDt' 		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' 		 => $this->session->userdata('userId'),
					 );
					 
		$this->db->where('categoryId',$categoryId);
		$this->db->update('category',$updateOpt);
		return $this->db->affected_rows();
	}
	
	public function add_spacepointe_commission2_history($categoryId,$addArr)
	{
		$insertOpt = array(
						'categoryId'     		 => $categoryId,
						'spacepointeCommission2' => $addArr['categoryCommission'],
						'lastModifiedDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' 		 => $this->session->userdata('userId'),
					 );
		$this->db->insert('category_commission_pointeforce_history',$insertOpt);
		return $this->db->insert_id();
	}
}
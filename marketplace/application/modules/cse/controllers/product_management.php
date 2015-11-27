<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Product_management extends MY_Controller {
					
	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );

		$this->data['title'] = 'Product Managements';
	}	
	
	public function index($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_management_index',
				'log_MID'    => '' 
		) );				
		
		$this->data['result'] = $this->product_lib->product_list(); 
		$this->data['organizationId'] = id_decrypt($organizationId);
		$this->cseCustomView('product_managements/product_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$organizationId               = $this->input->post('organizationId');
		$this->data['result']         = $this->product_lib->product_ajaxFun($total); 
		$this->data['organizationId'] = $organizationId;
		$this->load->view('retailer/product_managements/ajaxView',$this->data);
	}
	
	public function addEditProduct($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add|Edit Product';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->add_edit_product($product_id);
		$this->data['result'] = $result;
		$this->data['product_id'] = $product_id;
		$this->cseCustomView('product_managements/add_edit_product',$this->data);
	}
	
	public function addEditProductImage($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'add_product_image',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Add|Edit Product Image';
		if(empty($product_id))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_id_not'));
			redirect(base_url().'cse/product_management/addEditProduct');
		}
		
		$product_id  			   = id_decrypt($product_id);
		$productList 			   = $this->product_m->product_image_list($product_id);
		
		$this->data['product_id']  = $product_id;
		$this->data['productList'] = $productList;
		$this->cseCustomView('retailer/product_managements/addEditProductImage',$this->data);
	}
	
	public function uploadProductImage($productId='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'upload_product_image',
				'log_MID'    => '' 
		) );
		
		$productId = id_decrypt($productId);
		$this->custom_log->write_log('custom_log','product id is '.$productId);
		//$result = $this->product_lib->upload_product_image($productId);
		$result = $this->product_lib->multiple_upload_product_image($productId);
		echo $result;
	}
	
	public function deleteImage($productImageId='',$product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'deleteImage',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'cse/product_management/addEditProductImage/'.$product_id);
		}
		
		$productImageId = id_decrypt($productImageId);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->delete_image($productImageId);
		redirect(base_url().'cse/product_management/addEditProductImage/'.$product_id);
	}
	
	public function makeMainImage($productImageId='',$product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'make_main_image',
				'log_MID'    => '' 
		) );
		
		if(empty($productImageId))
		{
			$this->session->set_flashdata('error',$this->lang->line('error_product_image_id_not'));
			redirect(base_url().'cse/product_management');
		}
		
		$productImageId = id_decrypt($productImageId);
		$product_id     = id_decrypt($product_id);
		$this->custom_log->write_log('custom_log','product image id is '.$productImageId);
		$this->product_lib->make_main_image($productImageId,$product_id);
		redirect(base_url().'cse/product_management/addEditProductImage/'.id_encrypt($product_id));		
	}
	
	public function addEditProductAttribute($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditProductAttribute',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Add|Edit Product Attribute';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->add_edit_product_attribute($product_id);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		$this->cseCustomView('retailer/product_managements/addEditProductAttribute',$this->data);
	}
	
	public function productReview($product_id='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_review',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Product Review';
		$product_id 		  = id_decrypt($product_id);
		$result 			  = $this->product_lib->admin_product_review($product_id);
		$this->data['result'] = $result;
		//echo "<pre>"; print_r($result); exit;
		$this->data['product_id'] = $product_id;
		$this->cseCustomView('product_managements/product_review',$this->data);
	}
	
	public function add_inventory($organizationId=0,$productId=0)
	{
		$organizationId 	          = id_decrypt($organizationId);
		$productId       	          = id_decrypt($productId);
		$this->data['result']         = $this->product_lib->add_product_inventory($organizationId,$productId);
		$this->data['organizationId'] = $organizationId;
		$this->data['productId']      = $productId;
		$this->cseCustomView('product_managements/add_inventory',$this->data);
	}
	
	public function edit_inventory($organizationProductId=0)
	{
		$organizationProductId = id_decrypt($organizationProductId);
		$this->data['result']  = $this->product_lib->edit_inventory($organizationProductId);
		$this->data['organizationProductId'] = $organizationProductId;
		$this->cseCustomView('product_managements/edit_inventory',$this->data);
	}
	
	public function product_price_calculate()
	{
		$result = $this->product_lib->product_price_calculate();
		echo json_encode($result);
	}
	
	
	public function calculate_discount()
	{
		$result	   = array('discount' => 0,'tax' => 0,'spacePointComission' => 0,'displayPrice' => 0);
		$saleprice = $this->input->post('saleprice');
		$mrp	   = $this->input->post('mrp');
		$tax	   = $this->input->post('tax');
		if((!empty($saleprice))&&(!empty($mrp))&&($mrp>=$saleprice))
		{
			$result['discount'] = (($mrp-$saleprice)/$mrp)*100;
		}
		$result['tax'] = ($saleprice*$tax)/100;
		$result['spacePointComission'] = ($saleprice*$this->config->item('space_point_comission'))/100; 
		$result['displayPrice'] = $saleprice+$result['tax']+$result['spacePointComission'];
		echo json_encode($result);
	}	
	
	public function calculate_saleprice()
	{
		$result	  = array('salePrice' => 0,'tax' => 0,'spacePointComission' => 0,'displayPrice' => 0);
		$discount = $this->input->post('discount');
		$mrp	  = $this->input->post('mrp');
		$tax	  = $this->input->post('tax');
		if((!empty($discount))&&(!empty($mrp)))
		{
			$total  = ($discount/100)*$mrp;
			$result['salePrice'] = $mrp-$total; 
			$result['tax'] = ($result['salePrice']*$tax)/100;
			$result['spacePointComission'] = ($result['salePrice']*$this->config->item('space_point_comission'))/100; 
			$result['displayPrice'] = $result['salePrice']+$result['tax']+$result['spacePointComission'];
		}
		echo json_encode($result);
	}
	
	public function calculate_discount_with_offer()
	{
		$result	   = array('offerPrice' => 0,'discount' => 0,'tax' => 0,'spacePointComission' => 0,'displayPrice' => 0);
		$saleprice = $this->input->post('saleprice');
		$tax	   = $this->input->post('tax');
		if(!empty($saleprice))
		{
			$result['discount'] = 0;
		}
		$result['tax'] = ($saleprice*$tax)/100;
		$result['spacePointComission'] = ($saleprice*$this->config->item('space_point_comission'))/100; 
		$result['displayPrice'] = $saleprice+$result['tax']+$result['spacePointComission'];
		echo json_encode($result);
	}
	
	public function calculate_discount_with_saleprice()
	{
		$result	    = array('discount' => 0);
		$salePrice  = $this->input->post('salePrice');
		$offerPrice = $this->input->post('offerPrice');
		$tax	    = $this->input->post('tax');
		if((!empty($salePrice))&&(!empty($offerPrice))&&($offerPrice<=$salePrice))
		{
			$result['discount'] = (($salePrice-$offerPrice)/$salePrice)*100;
		}
		echo json_encode($result);
	}
	
	public function calculate_offerprice()
	{
		$result	   = array('offerPrice' => 0);
		$discount  = $this->input->post('discount');
		$salePrice = $this->input->post('salePrice');
		$tax	   = $this->input->post('tax');
		if((!empty($discount))&&(!empty($salePrice)))
		{
			$total  = ($discount/100)*$salePrice;
			$result['offerPrice'] = $salePrice-$total; 
		}
		echo json_encode($result);
	}
	
	public function check_inventory()
	{
		$currentQty = $this->input->post('currentQty');
		$inventory  = $this->input->post('inventory');
		$editinventory  = $this->input->post('editinventory');
		if($editinventory=='sub')
		{
			if($inventory>$currentQty)
			{
				$this->form_validation->set_message('check_inventory','not avaliable in current stock');
				return false;
			}
			else
			{	
				return true;
			}
		}
	}
	
	public function view($product_id='',$organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'product_view',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  	  = 'Product View';
		$user_id			  	  = $this->session->userdata('userId');
		$product_id 		  	  = id_decrypt($product_id);
		$result 			      = $this->product_lib->admin_product_review($product_id);
		$this->data['result']     = $result;
		$this->data['product_id'] = $product_id;
		$this->data['organizationId'] = id_decrypt($organizationId);
		$this->cseCustomView('retailer/product_managements/product_view',$this->data);
	}
	
	public function check_stocks($organizationId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocks',
				'log_MID'    => '' 
		) );	
		$organizationId 			  = id_decrypt($organizationId);
		$this->data['result']     	  = $this->product_lib->check_stocks_index($organizationId);
		$this->data['organizationId'] = $organizationId;
		$this->cseCustomView('retailer/product_managements/check_stocks',$this->data);
	}
	
	public function check_stocksAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'check_stocksAjaxFun',
				'log_MID'    => '' 
		) );

		$this->data['result'] = $this->product_lib->check_stocksAjaxFun($total);
		$this->load->view('retailer/product_managements/check_stocksAjaxFun',$this->data);
	}
	
	public function inventory_details($organizationProductId=0,$organizationId=0)
	{
		$organizationProductId = id_decrypt($organizationProductId);
		$organizationId        = id_decrypt($organizationId);
		//$organizationProductId = id_decrypt($organizationProductId);
		$product_detail=$this->data['result'] = $this->product_lib->inventory_details($organizationProductId,$organizationId);
		$resultProductDetail  = $this->product_lib->product_review($product_detail['productId']);
			if(!empty($resultProductDetail['sizes'])){
		$this->data['sizes']	=explode(',',$resultProductDetail['sizes']);	
		}else
		{
			$this->data['sizes']='';
		}
		$this->data['organizationProductId']  = $organizationProductId;
		$this->data['organizationId']  = $organizationId;		
		$this->cseCustomView('retailer/product_managements/inventory_details',$this->data);
	}
	
	public function check_product_name()
	{
		$productId   = $this->input->post('productId');
		$productName = $this->input->post('product_name');
		
		$details = $this->product_m->check_product_name($productName,$productId);     
		if(!empty($details))
		{
			$this->form_validation->set_message('check_product_name','The %s field already exits');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

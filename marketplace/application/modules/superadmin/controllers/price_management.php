<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Price_management extends MY_Controller {

	public function __construct(){
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Price Management';
	}	
	
	public function index()
	{		
		$this->session->set_userdata(array(
			'log_MODULE' => 'price_management_index',
			'log_MID'    => '' 
		));			
		$this->superAdminCustomView('price_managements/price_management_list',$this->data);	
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajaxFun',
				'log_MID'    => '' 
		) );
		
		$result 			  = $this->category_lib->price_management_ajax_list();
		$this->data['result'] = $result;
		$this->load->view('price_managements/ajaxView',$this->data);
	}
	
	public function addEditPrice($priceMngtId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'addEditPrice',
				'log_MID'    => '' 
		) );
		
		$priceMngtId = id_decrypt($priceMngtId);
		$result	= $this->category_lib->add_edit_price_management($priceMngtId);
		$this->data['result'] = $result;
		$this->data['priceMngtId'] = $priceMngtId;
		$this->superAdminCustomView('price_managements/addEditPrice',$this->data);
	}
	
	public function check_positive_number($number)
	{
		if($number<0)
		{
			$this->form_validation->set_message('check_positive_number','The %s field must contain only positive numbers.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function check_price_validation($number)
	{
		$fromPrice = $this->input->post('fromPrice');
		if($number<0)
		{
			$this->form_validation->set_message('check_price_validation','The %s field must contain only positive numbers.');
			return FALSE;
		}
		else
		{
			if($number<=$fromPrice)
			{
				$this->form_validation->set_message('check_price_validation','The %s field must be greater then Price From field.');
				return FALSE;

			}
			else
			{
				return TRUE;
			}
		}

	}
	
	public function deletePriceRange($priceMngtId=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'deletePriceRange',
				'log_MID'    => '' 
		) );
		
		$priceMngtId = id_decrypt($priceMngtId);
		$this->custom_log->write_log('custom_log','price management id is '.$priceMngtId);
		if($priceMngtId)
		{
			if($this->segment_cat_m->delete_old_price_management($priceMngtId))
			{
				$this->session->set_flashdata('success','Range Deleted Successfully');
				$this->custom_log->write_log('custom_log','Range Deleted Successfully');
			}
			else
			{
				$this->session->set_flashdata('error','Range not delete');
				$this->custom_log->write_log('custom_log','Range not delete');
			}
		}
		redirect(base_url().'superadmin/price_management');
	}
}
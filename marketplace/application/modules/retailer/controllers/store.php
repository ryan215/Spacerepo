<?php if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class Store extends MY_Controller {

	public function __construct() {
	
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'stores';
		//$this->load->model('store_m');
	}	
		
	//	This is common for all
	public function store_list()
	{
		
		$this->load->view('store/store_list',$this->data);
		
	}
	public function ajax_store_list()
	{
		$search = $this->input->post('search');
		if(!empty($search))
		{
			
		}
		$search_filter='';
		$total=$this->store_m->total_store($parentOrganizationId,$search,$search_filter);
		$pagConfig = array(
		   				'base_url'    => base_url().'admin/store/ajax_store_list',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 4,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	    $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		$this->data['store_list'] = $this->store_m->store_list($page,$pagConfig['per_page'],$parentOrganizationId,$search,$search_filter);
		
		$this->data["links"]     = $this->ajax_pagination->create_links();
		$this->load->view('store/ajax_store_list',$this->data);
		
		
		
	}
	public function edit_store()
	{
		$this->load->view('store/edit_store',$this->data);
	}
	public function add_store()
	{
		
		$organizationId=$this->store_m->add_store_name($parentOrganizationId,$_POST);
		$this->custom_log->write_log('custom_log',$this->db->last_query());
		if(!empty($organizationId))
		{
			
					$employeeId = $this->user_m->add_retailer_employee($organizationId,$_POST);
					$this->custom_log->write_log('custom_log','Employee id is '.$employeeId);
					
					if($employeeId)
					{
						$addressId = $this->user_m->add_retailer_address($_POST);
						$this->custom_log->write_log('custom_log','address id is '.$addressId);
						
						if($addressId)
						{
							$this->user_m->add_retailer_employee_address($employeeId,$addressId);
							$roleID = $this->user_m->add_retailer_employee_role($employeeId,$organizationId);
							$this->custom_log->write_log('custom_log','Role id is '.$roleID);							
							if($roleID)
							{
								
								$this->session->set_flashdata('success',$this->lang->line('success_reatiler_sign_up'));
								$this->custom_log->write_log('custom_log',$this->lang->line('success_reatiler_sign_up'));
							}
							
						}
						else
						{
							$this->session->set_flashdata('error',$this->lang->line('error_add_retailer_address'));
							$this->custom_log->write_log('custom_log',$this->lang->line('error_add_retailer_address'));
						}
					
		}
					else
					{
						$this->session->set_flashdata('error',$this->lang->line('error_add_retailer_employee'));
						$this->custom_log->write_log('custom_log',$this->lang->line('error_add_retailer_employee'));
					}
		}
		else
		{
			$this->session->set_flashdata('error',$this->lang->line('error_add_retailer_employee'));
			$this->custom_log->write_log('custom_log',$this->lang->line('error_add_retailer_employee'));
		}

		
	}
}
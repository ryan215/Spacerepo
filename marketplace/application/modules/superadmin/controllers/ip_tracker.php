<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Ip_tracker extends MY_Controller {

	public function __construct() {
		
		parent::__construct (); 	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		
		$this->data['title'] = 'Ip Tracker';	
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'admin_Ip_tracker',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Admin Ip Tracker';
		$this->data['total'] = $this->user_m->total_admin_login_data(); 
		$this->superAdminCustomView('ip_tracker/admin_ip_tracker',$this->data);
	}
	
	public function adminAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ip_tracker_adminAjaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$search = $this->input->post('search');
		if(!empty($search))
		{
			$where = "AND 
						(
							user_name LIKE '%".$search."%' 							
						OR
							user_email LIKE '%".$search."%'
						OR
							ip_address LIKE '%".$search."%'
						)";
			$total = $this->user_m->total_admin_login_data_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/ip_tracker/adminAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['user_list'] = $this->user_m->admin_login_data($page,$pagConfig['per_page'],$where);
		$this->load->view('ip_tracker/adminAjaxPage',$this->data);
	}
	
	public function retailer_ip()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'retailer_Ip_tracker',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Retailer Ip Tracker';
		$this->data['total'] = $this->user_m->total_retailer_login_data(); 
		$this->superAdminCustomView('ip_tracker/retailer_ip_tracker',$this->data);
	}
	
	public function retailerAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ip_tracker_retailerAjaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$search = $this->input->post('search');
		if(!empty($search))
		{
			$where = "AND 
						(
							user_name LIKE '%".$search."%' 							
						OR
							user_email LIKE '%".$search."%'
						OR
							ip_address LIKE '%".$search."%'
						)";
			$total = $this->user_m->total_retailer_login_data_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/ip_tracker/retailerAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['user_list'] = $this->user_m->retailer_login_data($page,$pagConfig['per_page'],$where);
		$this->load->view('ip_tracker/retailerAjaxPage',$this->data);
	}
	
	public function customer_ip()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_Ip_tracker',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'Customer Ip Tracker';
		$this->data['total'] = $this->user_m->total_customer_login_data(); 
		$this->superAdminCustomView('ip_tracker/customer_ip_tracker',$this->data);
	}
	
	public function customerAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ip_tracker_customerAjaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$search = $this->input->post('search');
		if(!empty($search))
		{
			$where = "AND 
						(
							user_name LIKE '%".$search."%' 							
						OR
							user_email LIKE '%".$search."%'
						OR
							ip_address LIKE '%".$search."%'
						)";
			$total = $this->user_m->total_customer_login_data_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/ip_tracker/customerAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				 = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->data['user_list'] = $this->user_m->customer_login_data($page,$pagConfig['per_page'],$where);
		$this->load->view('ip_tracker/customerAjaxPage',$this->data);
	}
	
	public function cse_ip()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'customer_Ip_tracker',
				'log_MID'    => '' 
		) );
		
		$this->data['title'] = 'CSE Ip Tracker';
		$this->data['total'] = $this->cse_m->total_cse_login_data(); 
		$this->superAdminCustomView('ip_tracker/cse_ip_tracker',$this->data);
	}
	
	public function cseAjaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'ip_tracker_customerAjaxFun',
				'log_MID'    => '' 
		) );
		
		$where  = '';
		$search = $this->input->post('search');
		if(!empty($search))
		{
			$where = "AND 
						(
							user_name LIKE '%".$search."%' 							
						OR
							user_email LIKE '%".$search."%'
						OR
							ip_address LIKE '%".$search."%'
						)";
			$total = $this->cse_m->total_cse_login_data_where($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'superadmin/ip_tracker/cseAjaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => 10,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  );
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  				     = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$this->data["links"]     = $this->ajax_pagination->create_links();
		$this->data['page']      = $page;
		$this->data['user_list'] = $this->cse_m->cse_login_data($page,$pagConfig['per_page'],$where);
		$this->load->view('ip_tracker/cseAjaxPage',$this->data);
	}
}
<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Settlement_report extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		 
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Settlement Report';
	}	
	
	public function index()
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'settlement_report',
				'log_MID'    => '' 
		) );
		
		$this->data['total'] = $this->shipping_m->total_settlement_report();
		$this->adminCustomView('shipping_management/settlement_report/settlement_report_list',$this->data);
	}
	
	public function ajaxFun($total=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'settlement_report_ajaxFun',
				'log_MID'    => '' 
		) );
		
		$this->custom_log->write_log('custom_log','after run ajax fun '.print_r($_POST,true));
		$per_page = $this->input->post('sel_no_entry');
		$sorting  = $this->input->post('sorting');
		$search   = $this->input->post('search');
		$where    = '';
		
		if(!empty($search))
		{
			if($sorting=='order_time')
			{
				$where = " AND From_UnixTime(orders.order_time,'%d-%m-%Y') LIKE '%".$search."%'   ";
			}
			elseif($sorting=='delivered_date')
			{
				$where = " AND ( orders.delivered_date LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='order_id')
			{
				$where = " AND ( orders.customer_order_id LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='tracking_number')
			{
				$where = " AND ( orders.tracking_number LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='user_area')
			{
				$where = " AND ( orders.user_area LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='warehouse_city')
			{
				$where = " AND ( orders.warehouse_city LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='shipping_vendor_name')
			{
				$where = " AND ( orders.shipping_vendor_name LIKE '%".$search."%' ) ";
			}
			elseif($sorting=='shipping_rate')
			{
				$where = " AND ( orders.shipping_rate LIKE '%".$search."%' ) ";
			}
			else
			{
				$where = "AND 
							(
								From_UnixTime(orders.order_time,'%d-%m-%Y') LIKE '%".$search."%' 
							OR
								orders.delivered_date LIKE '%".$search."%' 
							OR
		      					orders.customer_order_id LIKE '%".$search."%' 
							OR	
								orders.tracking_number LIKE '%".$search."%' 
							OR
								orders.user_area LIKE '%".$search."%' 
							OR	
								orders.warehouse_city LIKE '%".$search."%' 
							OR
								orders.shipping_vendor_name LIKE '%".$search."%' 
							OR
								orders.shipping_rate LIKE '%".$search."%' 
							)
							";
			}
			$total = $this->shipping_m->total_settlement_report($where);
		}
		
		$pagConfig = array(
		   				'base_url'    => base_url().'admin/settlement_report/ajaxFun/'.$total.'/',
		   				'total_rows'  => $total,
			 		    'per_page'    => $per_page,
			  		    'uri_segment' => 5,
		                'num_links'   => 4
          		  	);
 
		$this->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
				
		$this->data['list'] = $this->shipping_m->settlement_report_list($page,$pagConfig['per_page'],$where);
		$this->data["links"] = $this->ajax_pagination->create_links();
		$this->data['page']  = $page;
		$this->load->view('shipping_management/settlement_report/ajaxPagView',$this->data);
	}
	
	public function details($orderID='')
	{	
		$this->session->set_userdata(array(
				'log_MODULE' => 'details',
				'log_MID'    => '' 
		) );
		
		$this->data['title']   = 'Details';
		$orderID 			   = id_decrypt($orderID);
		$result				   = $this->order_lib->settlement_report_view($orderID);		
		$this->data['result']  = $result;
		$this->data['orderID'] = $orderID;
		$this->adminCustomView('shipping_management/settlement_report/details',$this->data);
	}
	
	public function send_to_admin($orderID='')
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'send_to_admin',
				'log_MID'    => '' 
		) );
		$orderID = id_decrypt($orderID);
		$this->order_lib->send_to_finance_admin($orderID);
	}
}
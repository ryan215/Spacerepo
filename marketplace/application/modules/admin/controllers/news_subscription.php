<?php
/**
 * Created by PhpStorm.
 * User: VIJJU
 * Date: 8/4/2015
 * Time: 11:57 AM
 */
  if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class News_subscription extends MY_Controller {
    public function __construct() {

        parent::__construct ();

        // logger
        $this->session->set_userdata ( array (
                'log_FILE' => __FILE__
        ) );
        $this->load->model('news_sub_m');
        $this->data['title'] = 'Newsletter Subscription';
    }
    public function index()
    {
        $this->adminCustomView('newsletter/newsletterlist',$this->data);
    }
	 public function vip_listing()
    {
        $this->adminCustomView('newsletter/newsletterlistvip',$this->data);
    }
	
    public function ajax_subscription_list()
    {
        $per_page = $this->input->post('sel_no_entry');
		$email    = $this->input->post('email');
		$dateTime = $this->input->post('dateTime');
		$where    = 'isPopUp = 1';
		
		if(!empty($email))
		{
			$where = ' AND subscription_email like "'.$email.'%"';
		}
		
		if(!empty($dateTime))
		{
			if(!empty($where))
			{
				$where.= ' AND createDt like "'.$dateTime.'%"';
			}
			else
			{
				$where = 'createDt like "'.$dateTime.'%"';
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total     = $this->news_sub_m->total_news_letter_subscription($where);
		$pagConfig = array(
		                'base_url'    => base_url().'admin/news_subscription/ajax_subscription_list/',
		                'total_rows'  => $total,
		                'per_page'    => $per_page,
		                'uri_segment' => 4,
		                'num_links'   => 4
			        );

        $this->ajax_pagination->initialize($pagConfig);

        $page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];

        $this->data['subscriptionList'] = $this->news_sub_m->newsletter_subscription_list($page,$pagConfig['per_page'],$where);
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
		$this->load->view('newsletter/ajax_subscription_list',$this->data);
	}
	 public function ajax_subscription_list_vip()
    {
        $per_page = $this->input->post('sel_no_entry');
		$email    = $this->input->post('email');
		$dateTime = $this->input->post('dateTime');
		$gender	  = $this->input->post('gender');	
        $where    = 'isPopUp = 2';
		
		if(!empty($email))
		{
			$where .= ' AND subscription_email like "'.$email.'%"';
		}
		if(!empty($gender))
		{
			$where .= ' AND gender = "'.$gender.'"';
		}
		
		if(!empty($dateTime))
		{
			if(!empty($where))
			{
				$where.= ' AND createDt like "'.$dateTime.'%"';
			}
			else
			{
				$where = 'createDt like "'.$dateTime.'%"';
			}
		}
		
		if(!empty($where))
		{
			$where = '('.$where.')';
		}
		
		$total     = $this->news_sub_m->total_news_letter_subscription($where);
		$pagConfig = array(
		                'base_url'    => base_url().'admin/news_subscription/ajax_subscription_list_vip/',
		                'total_rows'  => $total,
		                'per_page'    => $per_page,
		                'uri_segment' => 4,
		                'num_links'   => 4
			        );

        $this->ajax_pagination->initialize($pagConfig);

        $page  = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];

        $this->data['subscriptionList'] = $this->news_sub_m->newsletter_subscription_list($page,$pagConfig['per_page'],$where);
        $this->data["links"] = $this->ajax_pagination->create_links();
        $this->data['page']  = $page;
		$this->load->view('newsletter/ajax_subscription_list_vip',$this->data);
	}
	
	public function download_list()
	{	
		// logger
        $this->session->set_userdata ( array (
                'log_FILE' => __FILE__
        ) );
		
		$this->load->dbutil();
    	$this->load->helper('download');
					
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = array(
					 	array(
							'field' => 'downloadDt',
							'label' => 'Select One',
							'rules' => 'trim|required|is_natural_no_zero'
						),
					 );
			$downloadDt = $this->input->post('downloadDt');
			if($downloadDt==3)
			{
				$rules[] = array(
								'field' => 'from_date',
								'label' => 'From Date',
								'rules' => 'trim|required'
							);
				$rules[] = array(
								'field' => 'to_date',
								'label' => 'To Date',
								'rules' => 'trim|required|callback_compareDate'
							); 
			}
			//echo "<pre>";print_r($rules); exit;
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{
				if($downloadDt==1)
				{
					$result = $this->news_sub_m->this_month_data();
				}
				if($downloadDt==2)
				{
					$result = $this->news_sub_m->last_week_data();
				}
				if($downloadDt==3)
				{
					$fromDt = $this->input->post('from_date');
					$toDt   = $this->input->post('to_date');
					$result = $this->news_sub_m->custom_date_data($fromDt,$toDt);
				}
				
				if(!empty($result))
				{
					$filename  = 'newsletter'.date('Y-m-d').'.csv';
			        $delimiter = ",";
		    	    $newline   = "\r\n";
					$data      = $this->dbutil->csv_from_result($result,$delimiter,$newline);
			        force_download($filename,$data);
				}
			}
		}
        $this->adminCustomView('newsletter/download_list',$this->data);    
	}
		public function download_list_vip()
	{	
		// logger
        $this->session->set_userdata ( array (
                'log_FILE' => __FILE__
        ) );
		
		$this->load->dbutil();
    	$this->load->helper('download');
					
		if($_POST)
		{
			//echo "<pre>"; print_r($_POST); exit;
			$this->custom_log->write_log('custom_log','Form submit '.print_r($_POST,true));
			$rules = array(
					 	array(
							'field' => 'downloadDt',
							'label' => 'Select One',
							'rules' => 'trim|required|is_natural_no_zero'
						),
					 );
			$downloadDt = $this->input->post('downloadDt');
			if($downloadDt==3)
			{
				$rules[] = array(
								'field' => 'from_date',
								'label' => 'From Date',
								'rules' => 'trim|required'
							);
				$rules[] = array(
								'field' => 'to_date',
								'label' => 'To Date',
								'rules' => 'trim|required|callback_compareDate'
							); 
			}
			//echo "<pre>";print_r($rules); exit;
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if($this->form_validation->run())
			{
				if($downloadDt==1)
				{
					$result = $this->news_sub_m->this_month_vip_data();
					
				}
				if($downloadDt==2)
				{
					$result = $this->news_sub_m->last_week_vip_data();
				}
				if($downloadDt==3)
				{
					$fromDt = $this->input->post('from_date');
					$toDt   = $this->input->post('to_date');
					$result = $this->news_sub_m->custom_vip_date_data($fromDt,$toDt);
				}
				
				if(!empty($result))
				{
					$filename  = 'newsletter'.date('Y-m-d').'.csv';
			        $delimiter = ",";
		    	    $newline   = "\r\n";
					$data      = $this->dbutil->csv_from_result($result,$delimiter,$newline);
			        force_download($filename,$data);
				}
			}
		}
        $this->adminCustomView('newsletter/download_list_vip',$this->data);    
	}
	
	public function compareDate() 
	{
		$fromDt = $this->input->post('from_date');
		$toDt   = $this->input->post('to_date');
		
		if($toDt >= $fromDt)
		{
			return True;
		}
		else 
		{
		    $this->form_validation->set_message('compareDate', '%s should be greater than Contract From Date.');
		    return False;
		}
	}
	
	public function test1()
	{
		$this->adminCustomView('newsletter/test1',$this->data);    
	}
		public function test2()
	{
		$this->adminCustomView('newsletter/test2',$this->data);    
	}
		public function test3()
	{
		$this->adminCustomView('newsletter/test3',$this->data);    
	}
	public function test4()
	{
		$this->adminCustomView('newsletter/test4',$this->data);    
	}
}

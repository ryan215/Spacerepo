<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_subscription_email_lib {
	
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function compose_mail()
	{
		if($_POST)
		{
			$this->CI->custom_log->write_log('custom_log','form submit '.print_r($_POST,true)); 	
			$rules = compose_mail_rules();
			$this->CI->form_validation->set_rules($rules);
			$this->CI->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->CI->form_validation->run())
			{
				$result = array();
				$result['subject'] = trim($this->CI->input->post('subject'));
				$result['message'] = trim($this->CI->input->post('compose_mail'));
				
				$subscribeList 	   = $this->CI->news_sub_email_m->subscribe_list();
				$this->CI->custom_log->write_log('custom_log','subscribe list '.print_r($subscribeList,true)); 	
				
				$composeMailId = $this->CI->news_sub_email_m->add_compose_mail($result);
				$this->CI->custom_log->write_log('custom_log','Compose mail id is '.$composeMailId); 
				
				if(!empty($subscribeList))
				{
					foreach($subscribeList as $row)
					{
						$mailData = array(
										'toEmail' => $row->subscription_email,
										'cc'	  => '',
										'slug'    => 'news_letter_compose_mail',
										'subject' => $result['subject'],
										'message' => $result['message']
								);
								
						if($this->CI->email_m->news_letter_send_mail($mailData))
						{
							$this->CI->custom_log->write_log('custom_log','Send Mail : '.$this->CI->email->print_debugger());
							$this->CI->session->set_flashdata('success','Mail send successfully');
							$this->CI->custom_log->write_log('custom_log','Mail send successfully');
							
							$result['newSubId'] = $row->newSubId;
							$result['email']    = $row->subscription_email;
							
							$sendMailId = $this->CI->news_sub_email_m->add_send_mail($composeMailId,$result);
							$this->CI->custom_log->write_log('custom_log','send mail id is '.$sendMailId);
						}
						else
						{
							$this->CI->custom_log->write_log('custom_log','Not Send Mail : '.$this->CI->email->print_debugger());
							$this->CI->session->set_flashdata('error','Mail not send ,try again');
							$this->CI->custom_log->write_log('custom_log','Mail not send ,try again');
						}
					}
				}
				else
				{
					$this->CI->session->set_flashdata('error','Subscribe email list not found');
					$this->CI->custom_log->write_log('custom_log','Subscribe email list not found');
				}
				
				redirect(base_url().$this->CI->session->userdata('userType').'/news_subscription_email');
			}
		}
	}
	
	public function total_subscribe_with_unsubscribe_list()
	{
		$result = array();
		$result['totalMails']	    = $this->CI->news_sub_email_m->total_compose_mail();
		$result['totalSubscribe']   = $this->CI->news_sub_email_m->total_subscribe();
		$result['totalUnsubscribe'] = $this->CI->news_sub_email_m->total_unsubscribe();
		return $result;
	}
	
	public function ajax_mail_history_list()
	{
		$result = array();
		$search = $this->CI->input->post('search');
		$where 	= '';		
		
		if(!empty($search))
		{
			$where = '(news_letter_compose_mail.subject Like "%'.$search.'%")';
		}
		
		$total  = $this->CI->news_sub_email_m->total_compose_mail($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/news_subscription_email/ajax_mail_history_list',
		   				'total_rows'  => $total,
			 		    'per_page'    => 50,
			  		    'uri_segment' => 4,
		                'num_links'   => 4,
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$result['total'] = $total;
		$result['list']  = $this->CI->news_sub_email_m->compose_mail_list($page,$pagConfig['per_page'],$where);
		$result['links'] = $this->CI->ajax_pagination->create_links();
		$result['page']  = $page;
		return $result;
	
	}
	
	public function ajax_subscribe_list()
	{
		$result = array();
		$search = $this->CI->input->post('search');
		$where 	= '';		
		
		if(!empty($search))
		{
			$where = '(subscription_email Like "%'.$search.'%")';
		}
		$total  = $this->CI->news_sub_email_m->total_subscribe($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/news_subscription_email/ajax_subscribe_list',
		   				'total_rows'  => $total,
			 		    'per_page'    => 50,
			  		    'uri_segment' => 4,
		                'num_links'   => 4,
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$result['total'] = $total;
		$result['list']  = $this->CI->news_sub_email_m->subscribe_list($page,$pagConfig['per_page'],$where);
		$result['links'] = $this->CI->ajax_pagination->create_links();
		$result['page']  = $page;
		return $result;
	}
	
	public function ajax_unsubscribe_list()
	{
		$result = array();
		$search = $this->CI->input->post('search');
		$where 	= '';		
		
		if(!empty($search))
		{
			$where = '(subscription_email Like "%'.$search.'%")';
		}
		$total  = $this->CI->news_sub_email_m->total_unsubscribe($where);
		
		$pagConfig = array(
		   				'base_url'    => base_url().$this->CI->session->userdata('userType').'/news_subscription_email/ajax_unsubscribe_list',
		   				'total_rows'  => $total,
			 		    'per_page'    => 50,
			  		    'uri_segment' => 4,
		                'num_links'   => 4,
          		  	);
 
		$this->CI->ajax_pagination->initialize($pagConfig);	
		
		$page  = ($this->CI->uri->segment(4)) ? $this->CI->uri->segment(4) : 0;
		$limit = ($page>0) ? $page*$pagConfig['per_page'] : $pagConfig['per_page'];
		
		$result['total'] = $total;
		$result['list']  = $this->CI->news_sub_email_m->unsubscribe_list($page,$pagConfig['per_page'],$where);
		$result['links'] = $this->CI->ajax_pagination->create_links();
		$result['page']  = $page;
		return $result;
	}
}
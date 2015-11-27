<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_sub_email_m extends MY_Model {
	
	public function __construct() {
            parent::__construct();
    }
	
	public function add_compose_mail($addData)
	{
		$insertOpt = array(
					 	'subject'        => $addData['subject'],
						'message'        => $addData['message'],
						'active' 		 => 1,
						'createBy' 	     => $this->session->userdata('userId'),	
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),	
						'lastModifiedDt' => date('Y-m-d H:i:s'),				
					 );
		$this->db->insert('news_letter_compose_mail',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function add_send_mail($composeMailId,$addData)
	{
		$insertOpt = array(
					 	'composeMailId'  => $composeMailId,
						'newSubId'       => $addData['newSubId'],
						'email'        	 => $addData['email'],
						'active' 		 => 1,
						'createBy' 	     => $this->session->userdata('userId'),	
						'createDt'		 => date('Y-m-d H:i:s'),
						'lastModifiedBy' => $this->session->userdata('userId'),	
						'lastModifiedDt' => date('Y-m-d H:i:s'),				
					 );
		$this->db->insert('news_letter_send_mail',$insertOpt);
		return $this->db->insert_id();
	}
	
	public function total_compose_mail($where='')
	{
		$this->db->select('COUNT(*) AS total');
        $this->db->from('news_letter_compose_mail');
		//$this->db->join('news_letter_send_mail','news_letter_compose_mail.composeMailId = news_letter_send_mail.composeMailId');
        $this->db->where(array(
						 	'news_letter_compose_mail.active' => 1,
							//'news_letter_send_mail.active'    => 1,
						 ));
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
	
	public function total_subscribe($where='')
	{
		$this->db->select('COUNT(*) AS total');
        $this->db->from('newsletter_subscription');
        $this->db->where('emailSubscription',1);
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
	
	public function compose_mail_list($start=0,$limit='',$where='')
    {
		$this->db->select('news_letter_compose_mail.subject,news_letter_compose_mail.message,news_letter_compose_mail.createDt');
		$this->db->from('news_letter_compose_mail');
		//$this->db->join('news_letter_send_mail','news_letter_compose_mail.composeMailId = news_letter_send_mail.composeMailId');
        $this->db->where(array(
						 	'news_letter_compose_mail.active' => 1,
							//'news_letter_send_mail.active'    => 1,
						 ));
		if(!empty($where))
        {
        	$this->db->where($where);
        }
		$this->db->order_by('news_letter_compose_mail.lastModifiedDt','desc');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		return $this->db->get()->result();
	}
	
	public function subscribe_list($start=0,$limit='',$where='')
    {
    	$this->db->select('*');
        $this->db->from('newsletter_subscription');
        $this->db->where('emailSubscription',1);
        if(!empty($where))
        {
        	$this->db->where($where);
        }
        $this->db->order_by('lastModifiedDt','desc');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		return $this->db->get()->result();
	}
	
	public function total_unsubscribe($where='')
	{
		return 0;
	/*
		$this->db->select('COUNT(*) AS total');
        $this->db->from('newsletter_subscription');
        $this->db->where('emailSubscription',0);
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
	*/}

	public function unsubscribe_list($start=0,$limit='',$where='')
    {
		return '';
	/*
    	$this->db->select('*');
        $this->db->from('newsletter_subscription');
        $this->db->where('emailSubscription',0);
        if(!empty($where))
        {
        	$this->db->where($where);
        }
        $this->db->order_by('lastModifiedDt','desc');
		if(!empty($limit))
		{
			$this->db->limit($limit,$start);
		}
		return $this->db->get()->result();
	*/}
}
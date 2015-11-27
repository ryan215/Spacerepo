<?php
    /**
     * Created by PhpStorm.
     * User: VIJJU
     * Date: 8/4/2015
     * Time: 12:14 PM
     */
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class news_sub_m extends MY_Model {
        
		public function __construct() {
            parent::__construct();
        }
		
        public function total_news_letter_subscription($where='')
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
		
        public function newsletter_subscription_list($start=0,$limit='',$where='')
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
		
        public function add_new_subscription($email)
        {
            $data=array(
                    'subscription_email'  => $email,
                    'emailSubscription'   => 1,
                    'lastModifiedDt'      => date('Y-m-d H:i:s'),
                    'createDt'            => date('Y-m-d H:i:s')
			);
            $this->db->insert('newsletter_subscription',$data);
            return $this->db->insert_id();
        }
		
		public function add_new_subscription_popup($email)
        {
            $data = array(
                    	'subscription_email'  => $email,
	                    'emailSubscription'   => 1,
						'isPopUp'			  => 1,
        	            'lastModifiedDt'      => date('Y-m-d H:i:s'),
            	        'createDt'            => date('Y-m-d H:i:s')
				);
    	    $this->db->insert('newsletter_subscription',$data);
            return $this->db->insert_id();
        }
		public function add_new_subscription_popup2($email,$gender)
        {
            $data = array(
                    	'subscription_email'  => $email,
	                    'emailSubscription'   => 1,
						'isPopUp'			  => 2,
						'gender'			  => $gender,		
        	            'lastModifiedDt'      => date('Y-m-d H:i:s'),
            	        'createDt'            => date('Y-m-d H:i:s')
				);
    	    $this->db->insert('newsletter_subscription',$data);
            return $this->db->insert_id();
        }
		
        public function get_subscription_detail()
        {
            return $this->db->select('*')->from('newsletter_subscription')->get()->row();
        }
		
		public function add_newsletter_subscription_refer_friend($newSubId,$email)
		{
			$data = array(
                    	'newSubId'  	 => $newSubId,
	                    'email'     	 => $email,
						'active'		 => 1,
        	            'createDt'       => date('Y-m-d H:i:s'),
						'createBy'		 => $this->session->userdata('userId'),
					    'lastModifiedBy' => $this->session->userdata('userId'),
						'lastModifiedDt' => date('Y-m-d H:i:s'),
					);
    	    $this->db->insert('newsletter_refer_friend',$data);
            return $this->db->insert_id();
		}
		
		public function this_month_data()
		{
			$this->db->select('subscription_email,createDt');
			$this->db->from('newsletter_subscription');
			$this->db->where(array('isPopUp' => 1,"From_UnixTime(createDt,'%Y-%m') >= " => date("Y-m")));
			$this->db->order_by('lastModifiedDt','DESC');
			$result = $this->db->get();
			return $result;
		}
			public function this_month_vip_data()
		{
			$result=$this->db->query("SELECT subscription_email, createDt, CASE WHEN gender = 1 THEN 'Male' ELSE 'Female' END AS Gender FROM (`newsletter_subscription`) WHERE `isPopUp` = 2 AND DATE_FORMAT(createDt,'%Y-%m') = '". date("Y-m")."' ORDER BY `lastModifiedDt` DESC");
			return $result;
		}
		
		public function last_week_data()
		{
			$result = $this->db->query('SELECT subscription_email,createDt, FROM newsletter_subscription WHERE `isPopUp` = 1 AND WEEK (createDt) = WEEK( current_date ) - 1 AND YEAR( createDt) = YEAR( current_date ) ORDER BY `lastModifiedDt` DESC');
			return $result;
		}
		public function last_week_vip_data()
		{
			$result = $this->db->query('SELECT subscription_email,createDt ,CASE WHEN gender = 1 THEN "Male" ELSE "Female" END AS Gender FROM newsletter_subscription WHERE `isPopUp` = 2 AND WEEK (createDt) = WEEK( current_date ) - 1 AND YEAR( createDt) = YEAR( current_date ) ORDER BY `lastModifiedDt` DESC');
			return $result;
		}
		
		public function custom_date_data($fromDt,$toDt)
		{
			$result = $this->db->query('SELECT subscription_email,createDt FROM `newsletter_subscription` WHERE `isPopUp` = 1 AND DATE(`createDt`) BETWEEN "'.$fromDt.'" AND "'.$toDt.'" ORDER BY `lastModifiedDt` DESC');
			return $result;
		}
		public function custom_vip_date_data($fromDt,$toDt)
		{
			$result = $this->db->query('SELECT subscription_email,createDt,CASE WHEN gender = 1 THEN "Male" ELSE "Female" END AS Gender FROM `newsletter_subscription` WHERE `isPopUp` = 2 AND DATE(`createDt`) BETWEEN "'.$fromDt.'" AND "'.$toDt.'" ORDER BY `lastModifiedDt` DESC');
			return $result;
		}
		public function join_vip_email($email)
		{
			
            $this->db->select('*');
            $this->db->from('newsletter_subscription');
            $this->db->where('isPopUp',2);
			$this->db->where('subscription_email',$email);
			return $this->db->get()->result();
		}
    }
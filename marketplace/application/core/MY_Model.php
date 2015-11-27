<?php
class My_model extends CI_Model{
	
	public $configCustomData = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->configCustomData = $this->config->item('customData');
	}
	
	//Function for update
	public function customUpdate($options)
	{
		$table = false;
		$where = false;
		$data = false;
		
		extract($options);
		
		if(!empty($where))
		$this->db->where($where);
		
		$this->db->update($table, $data);
		
		return (bool)$this->db->affected_rows();
	}
	
	
	//Function for update
	public function customDelete($options)
	{
		$table = false;
		$where = false;
		
		extract($options);
		
		if(!empty($where))
		$this->db->where($where);
		
		$this->db->delete($table);
		
		return $this->db->affected_rows();
	}


	//Function for update
	public function customInsert($options)
	{
		$table = false;
		$data = false;		
		extract($options);		
		$this->db->insert($table, $data);		
		return $this->db->insert_id();
	}
	
	//Function for Batch insert
	public function customBatchInsert($options)
	{
		$table = false;
		$data = false;
		
		extract($options);
		
		return (bool) $this->db->insert_batch($table, $data);
	}
	
	
	public function customGet($options){		
		
		$select = false;
		$table = false;
		$join = false;
		$order = false;
		$limit = false;
		$offset = false;
		$where = false;
		$or_where = false;
		$single = false;
		$in		=false;
		
		extract($options);
		
			if($select!=false)
				$this->db->select($select);
				
			if($table!=false)
				$this->db->from($table);
				
			if($where!=false)
				$this->db->where($where);
			
				
			if($or_where!=false)
				$this->db->or_where($or_where);
			
			if($in!=false)
			foreach($in as $inkey=>$invalue){
				$this->db->where_in($inkey,$invalue);	
			}
				
			if($limit!=false){
				
				if(!is_array($limit))
				{
					$this->db->limit($limit);
				}
				else
				{
					foreach($limit as $limitval => $offset){
						$this->db->limit($limitval, $offset);
					}
				}
			}
			
			
			if($order!=false){
				foreach($order as $key => $value){
					
					if(is_array($value))
					{
						foreach($order as $orderby => $orderval)
						{
							$this->db->order_by($orderby, $orderval);
						}
					}
					else
					{
						$this->db->order_by($key, $value);
					}
				}
			}
			
	
			if($join!=false){
				
				foreach($join as $key => $value){
					
					if(is_array($value))
					{
						if(count($value)==3)
						{
							$this->db->join($value[0], $value[1],$value[2]);
						}
						else
						{
							foreach($value as $key1 => $value1)
							{
								$this->db->join($key1, $value1);
							}
						}
					}
					else
					{
					$this->db->join($key, $value);
					}
				}
			}
			
/*			if($join!=false){
				
				foreach($join as $joinArray){
					
					if(!isset($joinArray[2]))
						$joinArray[2]='';
					
					$this->db->join( $joinArray[0], $joinArray[1], $joinArray[2]);
					
				}
			}
*/			

			$query  = $this->db->get();
			
			
			if($single)
			{
				return $query->row();
			}


			return $query->result();
		}
	
	

	public function customQuery($query,$single=false,$updDelete=false)
	{
		$query = $this->db->query($query);
		
		if($single)
		{
			return $query->row();
		}
		
		if($updDelete)
		{
			return $this->db->affected_rows();
		}

		return $query->result();
	}


	public function customQueryCount($query)
	{
		return $this->db->query($query)->num_rows();
	}
		

	
		
	function customCount($table,$where=false,$limit=false,$order=false,$join=false){
				
			$this->db->from($table);
				
			if($where!=false)
				$this->db->where($where);
				
			if($limit!=false){
				
				foreach($limit as $limitval => $start){
					$this->db->limit($limitval, $start);
				}
			}
			
			if($order!=false){
				
				foreach($order as $orderby => $orderval){
					$this->db->order_by($orderby, $orderval);
				}
			}
			
	
			if($join!=false){
				
				
				//print_r($join);
				
				foreach($join as $joinArray){
					
					//print_r($joinArray);
					exit;
					
					if(!isset($joinArray[2]))
						$joinArray[2]='';
					
					$this->db->join( $joinArray[0], $joinArray[1], $joinArray[2]);
					
				}
			}
	
			return $this->db->get()->num_rows();
		}
		

	//common function for sql enjaction
	public function makeSafe($str)
	{
		if($str){
			return $this->db->escape($str);	
		}
		else{
			return false;	
		}	
	}
	
	public function id_encrypt($str)
	{
		return $str*55;
	}	
	

	public function id_decrypt($str)
	{
		return $str/55;
	}
	
	
	// Registration verification mail function
	function customMail($data=false)
	{   
		$this->load->library('email');
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset']  = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);	
			
		if(!$data)
			return FALSE;		
		$cc = '';
		
		if(isset($data['cc'])&&(!empty($data['cc'])))
		{
			$cc = $data['cc'];
		}		
		
		$this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
		
		if(isset($data['tooldEmail']) && isset($data['tonewEmail']))
		{
			$this->email->to($data['tooldEmail'].",".$data['tonewEmail']);
		}
		else
		{
			$this->email->to($data['toEmail']);
		}
			
		$this->email->cc($cc);
		$this->email->subject($data['subject']);
		$this->email->message($data['body']);
		return (bool) $this->email->send();
	}		
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_management_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function total_staff_user()
	{
		$sql = "SELECT 
					COUNT(*) AS total
				FROM
					users
				INNER JOIN
					profile
				ON
					users.user_id = profile.user_id					
				WHERE
					(
						users.user_type = 'admin'
					OR
						users.user_type = 'cse'
					)
				ORDER BY
					users.user_id
				DESC
				";
		$result = $this->common_model->customQuery($sql,'single');
		
		$total = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}	
			
	public function staff_user_list($start,$limit,$where='')
	{
		$sql = "SELECT 
					users.*,profile.*,concat(profile.first_name,' ',profile.last_name) AS username
				FROM
					users
				INNER JOIN
					profile
				ON
					users.user_id = profile.user_id					
				WHERE
					(
						users.user_type = 'admin'
					OR
						users.user_type = 'cse'
					)
				".$where." 
				ORDER BY
					users.user_id
				DESC
				LIMIT ".$start.",".$limit;
				
		$user_list = $this->common_model->customQuery($sql);
		return $user_list;
	}
	
	public function staff_user_search_count($where='')
	{
		$sql = "SELECT 
					COUNT(*) AS total
				FROM
					users
				INNER JOIN
					profile
				ON
					users.user_id = profile.user_id					
				WHERE
					(
						users.user_type = 'admin'
					OR
						users.user_type = 'cse'
					)
				".$where." 
				ORDER BY
					users.user_id
				DESC";
				
		$result = $this->common_model->customQuery($sql,'single');
		$total  = 0;
		if(!empty($result))
		{
			$total = $result->total;
		}
		return $total;
	}
}
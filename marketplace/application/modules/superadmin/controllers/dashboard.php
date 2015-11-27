<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

class Dashboard extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Dashboard';
	}	
	
	public function index()
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'Dashboard_index',
				'log_MID'    => '' 
		) );
		
		$total = 0;
		$statesList = $this->cse_m->cse_states_list();
		//echo "<pre>"; print_r($statesList); exit;
		$statesArr  = array();
		if(!empty($statesList))
		{
			foreach($statesList as $row)
			{
				$statesArr[$row->stateId] = $row->stateName;
			}
		}
		$result = $this->cse_m->total_products_request_by_according_day("DATE_FORMAT(product.createDt,'%Y-%m-%d') = '".date('Y-m-d')."'");
		if(!empty($result))
		{
			foreach($result as $row)
			{
				$total = $total+$row->total;
			}
		}
		
		$actionRes = $this->cse_m->total_products_action_by_admin_according_day("DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d')."'");
		$totalActAdmin = 0;
		if(!empty($actionRes))
		{
			foreach($actionRes as $row)
			{
				$totalActAdmin = $totalActAdmin+$row->total;
			}
		}
		//echo $this->db->last_query(); exit;
		//echo "<pre>"; print_r($statesList); exit;
		
		$this->data['statesArr']     = $statesArr;
		$this->data['totalReq']      = $total;
		$this->data['totalActAdmin'] = $totalActAdmin;
		$this->data['statesList']	 = $statesList;
		$this->data['trendingPrdList'] = $this->product_m->check_organization_product_count_list('',10);
		$this->superAdminCustomView('admin/dashboard/dashboard',$this->data);
	}
	
	public function product_add_by_cse()
	{
		$stateId   = $this->input->post('stateId');
		$cseReqDay = $this->input->post('cseReqDay');
		$jsonArray = array('total' => 0,'result' => array());
		
		if($cseReqDay==2)
		{
			$lastSunday = date('Y-m-d',strtotime('last Sunday'));
			$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') >= '".$lastSunday."' AND  DATE_FORMAT(product.createDt,'%Y-%m-%d') < '".$next7days."'";
			if($stateId)
			{
				$where.= " AND address.state = ".$stateId;
			}
		}
		elseif($cseReqDay==1)
		{
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') = '".date('Y-m-d',strtotime('-1 days'))."'";
			if($stateId)
			{
				$where.= " AND address.state = ".$stateId;
			}
		}
		else
		{
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') = '".date('Y-m-d')."'";
			if($stateId)
			{
				$where.= " AND address.state = ".$stateId;
			}			
		}
		
		$total  = 0;
		$result = $this->cse_m->total_products_request_by_according_day($where);
		if(!empty($result))
		{
			$i=0;
			foreach($result as $row)
			{
				$jsonArray['result'][$i]['year']   = $row->firstName.' '.$row->middle.' '.$row->lastName;
				$jsonArray['result'][$i]['income'] = $row->total;
				$jsonArray['result'][$i]['url']   = base_url().'superadmin/dashboard/cse_chart/'.id_encrypt($row->employeeId);
				$total = $total+$row->total;
				$i++;
			}
		}
		$jsonArray['total'] = $total;
		echo json_encode($jsonArray);
	}
	
	public function product_action_by_admin()
	{
		$adminActDay = $this->input->post('adminActDay');
		$jsonArray = array('total' => 0,'result' => array());
		
		if($adminActDay==2)
		{
			$lastSunday = date('Y-m-d',strtotime('last Sunday'));
			$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') >= '".$lastSunday."' AND  DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') < '".$next7days."'";
		}
		elseif($adminActDay==1)
		{
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d',strtotime('-1 days'))."'";
		}
		else
		{
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d')."'";					
		}
		
		$total  = 0;
		$result = $this->cse_m->total_products_action_by_admin_according_day($where);
		if(!empty($result))
		{
			$i=0;
			foreach($result as $row)
			{
				$jsonArray['result'][$i]['year']   = $row->firstName.' '.$row->middle.' '.$row->lastName;
				$jsonArray['result'][$i]['income'] = $row->total;
				$total = $total+$row->total;
				$i++;
			}
		}
		$jsonArray['total'] = $total;
		echo json_encode($jsonArray);
	
	}
	
	public function cse_graph($employeeId=0,$byDay=0)
	{
		$this->session->set_userdata(array(
				'log_MODULE' => 'cse_graph',
				'log_MID'    => '' 
		) );
		
		$employeeId  = id_decrypt($employeeId);
		$total       = 0;
		$cseDetailes = $this->cse_m->cse_details($employeeId);
		$cseName     = '';
		if(!empty($cseDetailes))
		{
			$cseName = $cseDetailes->firstName.' '.$cseDetailes->middle.' '.$cseDetailes->lastName;
		}
		
		if($byDay==2)
		{
			$lastSunday = date('Y-m-d',strtotime('last Sunday'));
			$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') >= '".$lastSunday."' AND  DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') < '".$next7days."'";
		}
		elseif($byDay==1)
		{
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') = '".date('Y-m-d',strtotime('-1 days'))."'";
		}
		else
		{
			$where = "DATE_FORMAT(product.createDt,'%Y-%m-%d') = '".date('Y-m-d')."'";					
		}
		$prdWithCat = $this->cse_m->total_products_with_category_by_according_day($employeeId,$where);
		
		//echo $this->db->last_query();
	//echo "<pre>"; print_r($prdWithCat); exit;		
		if(!empty($prdWithCat))
		{
			foreach($prdWithCat as $row)
			{
				$total = $total+$row->total;				
			}
		}
		
		$reqRes = $this->cse_m->product_by_cse($employeeId,$where);
		$totalReqRS = 0;
		if(!empty($reqRes))
		{
			foreach($reqRes as $row)
			{
				$totalReqRS = $totalReqRS+$row->total;
			}
		}
		
		if($byDay==2)
		{
			$lastSunday = date('Y-m-d',strtotime('last Sunday'));
			$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		
			$whereInv = "DATE_FORMAT(inventory_history.lastModifiedDt,'%Y-%m-%d') >= '".$lastSunday."' AND  DATE_FORMAT(inventory_history.lastModifiedDt,'%Y-%m-%d') < '".$next7days."'";
		}
		elseif($byDay==1)
		{
			$whereInv = "DATE_FORMAT(inventory_history.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d',strtotime('-1 days'))."'";
		}
		else
		{
			$whereInv = "DATE_FORMAT(inventory_history.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d')."'";					
		}
		$totalNewInvtry  = $this->cse_m->total_new_created_inventory($employeeId,$whereInv);
		$totalUpdtInvtry = $this->cse_m->total_updated_inventory($employeeId,$whereInv);
		
		
		$this->data['total']      = $total;
		$this->data['totalReqRS'] = $totalReqRS;
		$this->data['cseName']    = $cseName;
		$this->data['reqRes']     = $reqRes;
		$this->data['employeeId']     = $employeeId;
		
		$this->data['totalUpdtInvtry'] = $totalUpdtInvtry;
		$this->data['totalNewInvtry']  = $totalNewInvtry;
		$this->data['byDay']           = $byDay;	
		$this->data['prdWithCat']      = $prdWithCat;			
		$this->superAdminCustomView('admin/dashboard/cse_graph',$this->data);
	}
	
	public function product_category_by_cse()
	{
		$actDay     = $this->input->post('actDay');
		$employeeId = $this->input->post('employeeId');
		$jsonArray  = array('total' => 0,'result' => array());
		
		if($actDay==2)
		{
			$lastSunday = date('Y-m-d',strtotime('last Sunday'));
			$next7days  = date('Y-m-d',strtotime('last Sunday +7 days'));
		
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') >= '".$lastSunday."' AND  DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') < '".$next7days."'";
		}
		elseif($actDay==1)
		{
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d',strtotime('-1 days'))."'";
		}
		else
		{
			$where = "DATE_FORMAT(product.lastModifiedDt,'%Y-%m-%d') = '".date('Y-m-d')."'";					
		}
		
		$total  = 0;
		$result = $this->cse_m->total_products_with_category_by_according_day($employeeId,$where);
		if(!empty($result))
		{
			$i=0;
			foreach($result as $row)
			{
				$jsonArray['result'][$i]['year']   = $row->categoryCode;
				$jsonArray['result'][$i]['income'] = $row->total;
				$total                             = $total+$row->total;
				$i++;
			}
		}
		$jsonArray['total'] = $total;
		echo json_encode($jsonArray);
	}
}
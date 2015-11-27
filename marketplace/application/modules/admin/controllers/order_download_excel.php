<?php if(! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );
 
class Order_download_excel extends MY_Controller {

	public function __construct() {
		
		parent::__construct ();	
		
		// logger
		$this->session->set_userdata ( array (
				'log_FILE' => __FILE__
		) );
		$this->data['title'] = 'Order Download Excel';
	}	
	
	public function index()
	{/*	
		$this->session->set_userdata(array(
				'log_MODULE' => 'History_order',
				'log_MID'    => '' 
		));
		
		$ordersArr = array();
		$orderList = $this->order_m->download_excel_orders_list();
		if(!empty($orderList))
		{
			$i = 0;
			foreach($orderList as $row)
			{
				$ordersArr[$row->customOrderId][$i]['orderId'] 		 = $row->orderId;
				$ordersArr[$row->customOrderId][$i]['chargedAmount'] = $row->chargedAmount;
				$ordersArr[$row->customOrderId][$i]['shippingRate']  = 0;
				
				if($row->isPickup)
				{
					if((!empty($ordersArr[$row->customOrderId]['totalAmt']))&&($ordersArr[$row->customOrderId]['totalAmt']))
					{
						$ordersArr[$row->customOrderId]['totalAmt'] = $ordersArr[$row->customOrderId]['totalAmt']+($row->pickupProccessPrice*$row->quantity);
					}
					else
					{
						$ordersArr[$row->customOrderId]['totalAmt'] = $row->pickupProccessPrice*$row->quantity;
					}
				} 
				else
				{
					if($row['isEconomicDelivery'])
					{
						if($row['isCalculateShipp'])
						{											
							if($row['shippingRate'])
							{
								if(!empty($shppCalArr[$customID]['shippingRate']))
								{
								}
								else
								{
									if(!empty($row['productWeight']))
									{
										if($row['productWeight']>10)
										{
											$shippingAmt = $shippingAmt+($row['shippingRate']*$row['productWeight']);
											$totalAmount = $totalAmount+($row['shippingRate']*$row['productWeight']);	
										}
										else
										{
											$shippingAmt = $shippingAmt+$row['shippingRate'];
											$totalAmount = $totalAmount+$row['shippingRate'];
										}
										$shppCalArr[$customID]['shippingRate'] = $shippingAmt;	
									}
								}
							}
						}
					}
					else
					{
						if($row['freeShipPrdId'])
						{
						}
						elseif($row['freeShipCatId'])
						{
						}
						elseif($row['genuineShippFee'])
						{
							if($row['shippingRate'])
							{
								if(!empty($row['productWeight']))
								{
									if($row['productWeight']>10)
									{
										$shippingAmt = $shippingAmt+($row['shippingRate']*$row['quantity']*$row['productWeight']);
										$totalAmount = $totalAmount+($row['shippingRate']*$row['quantity']*$row['productWeight']);
									}
									else
									{
										$shippingAmt = $shippingAmt+($row['shippingRate']*$row['quantity']);
										$totalAmount = $totalAmount+($row['shippingRate']*$row['quantity']);
									}
								}
							}
						}
					}
									
					if($row['paymentStatus'])
					{						
					}
					else
					{
						if($row['isEconomicDelivery'])
						{
							if(!empty($shppCalArr[$customID]['cashHandlingPrice']))
							{
							}
							else
							{
								$totalAmount = $totalAmount+$row['cashHandlingPrice'];
								$cashHandlingPrice = $row['cashHandlingPrice'];											
								$shppCalArr[$customID]['cashHandlingPrice'] = $cashHandlingPrice;	
							}	
						}
						else
						{
							$totalAmount = $totalAmount+$row['cashHandlingPrice'];
							$cashHandlingPrice = $row['cashHandlingPrice'];
						}
					}					
				
					$ordersArr[$row->customOrderId][$i]['shippingRate'] = $row->shippingRate;
					
					if((!empty($ordersArr[$row->customOrderId]['totalAmt']))&&($ordersArr[$row->customOrderId]['totalAmt']))
					{
						$ordersArr[$row->customOrderId]['totalAmt'] = $ordersArr[$row->customOrderId]['totalAmt']+($row->pickupProccessPrice*$row->quantity);
					}
					else
					{
						$ordersArr[$row->customOrderId]['totalAmt'] = $row->pickupProccessPrice*$row->quantity;
					}
					
				}
				$i++;
			}
		}
		echo "<pre>"; print_r($ordersArr); exit;	
		$this->adminCustomView('order_managements/order_download_excel',$this->data);
	*/}	
}
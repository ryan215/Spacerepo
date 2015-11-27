<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class manageSale extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->apiresponse['time'] = time();
        // load  twilio model for sending message
        $this->load->model('twillo_m');
        $this->load->model('api_product_m');
        $this->load->model('api_product_sale_m');
        $this->load->model('employee_m');
        $this->load->helper('api_validation');
        $this->load->model('order_m');

        $language = $this->config->item('supported_languages');

        if (is_array($this->response->lang)) {
            $languageToSet = $language[$this->response->lang[0]];
            $this->custom_log->write_log('custom_log', print_r($this->response->lang, true));
            $this->lang->load('error', $languageToSet);
            $this->lang->load('success', $languageToSet);

        } else {
            $languageToSet = $language[$this->response->lang];
            $this->custom_log->write_log('custom_log', print_r($this->response->lang, true));
            $this->lang->load('error', $languageToSet);
            $this->lang->load('success', $languageToSet);

        }
    }

    public function productSale_post()
    {
        $rules = api_sale_rules();
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()) {
            $products = $this->post('products');

            $employeeId= $this->post('employeeId');
            $products=json_decode($products);

            $organizationId=$this->post('organizationId');

          //  print_r($products);
            $invoice_no  = 'INV-'.time();
            $lastCustmOrderIdDet = $this->api_product_sale_m->last_order_id();

            $orderId=sprintf("%.0f",$lastCustmOrderIdDet );
            $customerorderId= $lastCustmOrderIdDet+1;
           // $customerorderId=$orderId + 1;

            if(isset($_POST['customerId'])){
                $customerId=$this->post('customerId');
                $customerDetails=$this->customer_m->get_user_detail($customerId);
                $customerEmail=$customerDetails->email;
				if(empty($customerEmail))
				{
					$customerEmail='';
				}
            }
            else
            {
                $customerId='';
                $customerEmail='';
            }

            $totalAmount=$this->post('totalAmount');


            foreach($products as $product)
             {
                 $insertOpt[] = array(
                     'orderTypeId'           => 3,
                     'totalAmount'           => $totalAmount,
                     'quantity'              => $product->quantity,
					 'discountPerQuantity'	 =>	$product->discount,
                     'customerId'            => $customerId,
                     'chargedAmount'         => $product->price,
                     'organizationProductId' => $product->organizationProductId,
                     'orderStatusId'         => 9,
                     'customOrderId'         => $customerorderId,
                     'orderEmail'            => $customerEmail,
                     'createDt'              => date('Y-m-d H:i:s'),
                     'last_Modified_By'      => $employeeId,
                     'lastModifiedDt'        => date('Y-m-d H:i:s'),
                 );
                 $organizationProductId= $product->organizationProductId;
                 $stock= 'currentQty - '.$product->quantity;
                $response = $this->api_product_m->add_product_inventory($organizationProductId,$stock,$employeeId);
            }
           $response= $this->api_product_sale_m->add_order($insertOpt);
            $paymentOpt = array(
                'orderId'		  => $customerorderId,
                'paymentTypeId'   => 1,
                'amount'      	  => $totalAmount,
                'paymentStatus'   => 1,
                'paymentRef'      => '',
                'retrievalRef'    => '',
                'transactionRef'  => '',
                'merchantRef'	  => '',
                'transactionDate' => date('Y-m-d H:i:s'),
                'createDt'		  => date('Y-m-d H:i:s'),
                'lastModifiedBy'  => $employeeId,
                'lastModifiedDt'  => date('Y-m-d H:i:s'),
            );
            $this->api_product_sale_m->add_order_payment($paymentOpt);
            if(!empty($response))
            {
                $this->apiresponse['success'] = 1;

                $this->apiresponse['response'] = array(
                    'message' => 'successfully completed order',
                    'invoice' => $customerorderId
                );

                $this->response($this->apiresponse, 200);

            }
            else
            {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => 'error in order confirmation',

                );

                $this->response($this->apiresponse, 200);

            }


        } else {
            $this->apiresponse['success'] = 0;

            $this->apiresponse['response'] = array(
                'message' => $this->form_validation->error_array()
            );

            $this->response($this->apiresponse, 200);

        }


    }
	public function sendInvoice_post()
	{
		 $rules = required_organization_id ();
            $rules[] = array(
                'field' => 'invoice',
                'label' => 'Invoice',
                'rules' => 'trim|required'
            );
			 $rules[] = array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required'
            );
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run())
			{
				$orderId=$this->post('invoice');
				$orderdetail=$this->api_product_sale_m->get_order_detail($orderId);
				$customerEmail=$this->post('email');
				if(!empty($orderdetail)){
					$item='';
				foreach($orderdetail as $orderinfo)
				{
					if($orderinfo->quantity ==1){
						 $item .='';
					 $item .=  ' <table align="left" border="0" cellpadding="9" cellspacing="0" class="flexibleContainer" width="100%">
                            <tr>
							
                              <td align="left" valign="top" class="textContent">'.$orderinfo->productCodeOveride.'</td>
							
                              <td align="right" valign="top" class="textContent" style="font-size:13px;">&#8358; '.($orderinfo->chargedAmount +$orderinfo->discountPerQuantity)* $orderinfo->quantity .'</td>
						
                              <td align="right" valign="top" class="textContent" style="font-size:13px; color:#62bb46;">-&#8358; '.$orderinfo->discountPerQuantity * $orderinfo->quantity.'</td>
                              <td align="right" valign="top" class="textContent" style="font-size:13px;">&#8358;'. $orderinfo->chargedAmount * $orderinfo->quantity .'</td>
                            </tr>
                          </table>';
				 }else
				 {
					 $item .='';
					 $item .= '  <table align="left" border="0" cellpadding="9" cellspacing="0" class="flexibleContainer" width="100%">   
                            <tr>
                              <td align="left" valign="top" class="textContent">'.$orderinfo->productCodeOveride.'
                              <div style="font-size:14px; color:#8fe873;">(&#8358; '. $orderinfo->chargedAmount + $orderinfo->discountPerQuantity.' ea) x'.$orderinfo->quantity.'</div>
                              </td>
								<td align="right" valign="top" class="textContent" style="font-size:13px;">&#8358; '.($orderinfo->chargedAmount + $orderinfo->discountPerQuantity )* $orderinfo->quantity .'</td>
                              <td align="right" valign="top" class="textContent" style="font-size:13px; color:#62bb46;">-&#8358; '.$orderinfo->discountPerQuantity * $orderinfo->quantity . '</td>
                              <td align="right" valign="top" class="textContent" style="font-size:13px;">&#8358;'. $orderinfo->chargedAmount * $orderinfo->quantity .'</td>  </tr>
                          </table>    
						  ';
				 }
				 $totalAmount=$orderinfo->totalAmount;
				 $organizationName=$orderinfo->organizationName;
				 $paymentTypeId=$orderinfo->paymentTypeId;
				 
				}
				if($paymentTypeId==3){
				$paymentType="Credit Card";    
				
				}elseif($paymentTypeId=2){              
					$paymentType="Cash";
				}
				//$discount=20;
				$customerorderId=$orderId;
				//$totalDiscount=200;
				
			
					$mailData = array(
													'email'    => $customerEmail,
													'cc'	   => '',
													'from'		=>$organizationName,
													'slug'     => 'pointepay_invoice_email',
													'paymentType'=> $paymentType,
													'items'		=>	$item,
													//'discount'	=> $discount,
													'orderId'  =>$customerorderId,
													//'totalDiscount'=>	$totalDiscount,
													'totalAmount'=>$totalAmount,
													'subject'  => 'Reciept From '.$organizationName.'',
												);										
									
									if($this->email_m->send_header_mail($mailData)){
								//	echo $this->email->print_debugger();
										$this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
																
											$this->apiresponse['success'] = 1;

											$this->apiresponse['response'] = array(
												'message' =>'successfully get order listing',
												//'data'   =>$orderdetail
												
											);

									$this->response($this->apiresponse, 200);
									}else
									{
										$this->apiresponse['success'] = 0;

												$this->apiresponse['response'] = array(
													'message' =>'no Order Of this invoice has been found',
													'data'   =>$this->email->print_debugger()
												);

												$this->response($this->apiresponse, 200);
									}
				}else
				{
						$this->apiresponse['success'] = 0;

					$this->apiresponse['response'] = array(
						'message' =>'no Order Of this invoice has been found',
						'data'   =>$orderdetail
						
					);

					$this->response($this->apiresponse, 200);
					
				}
			}
			
			else
			{
				  $this->apiresponse['success'] = 0;

					$this->apiresponse['response'] = array(
						'message' => $this->form_validation->error_array()
					);

					$this->response($this->apiresponse, 200);
			}
	}
	public function sendRecharge_post()
	{
		 $rules = required_organization_id ();
            $rules[] = array(
                'field' => 'phoneNo',
                'label' => 'amount',
                'rules' => 'trim|required'
            );
			 $rules[] = array(
                'field' => 'amount',
                'label' => 'amount',
                'rules' => 'trim|required'
            );
			$this->form_validation->set_rules($rules);
			if($this->form_validation->run())
			{
				$this->load->library('recharge_lib');
				$mobilenumber=$this->post('phoneNo');
				$amount=$this->post('amount');
				$param['mobile_no'] 		= $mobilenumber;
				$param['amount']		= $amount;
				$this->custom_log->write_log('custom_log',print_r($param,true));

				$json_resp = $this->recharge_lib->do_recharge_request($param);

				$resp = json_decode($json_resp);
				$this->custom_log_lib->write_log('custom_log',print_r($resp,true));
			}
			else
			{
				  $this->apiresponse['success'] = 0;

					$this->apiresponse['response'] = array(
						'message' => $this->form_validation->error_array()
					);

					$this->response($this->apiresponse, 200);
			}
			
	}


}


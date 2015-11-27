<?php if (! defined ( 'BASEPATH' )) 	exit ( 'No Direct Access Allowed' );

    class New_order extends MY_Controller {

        public function __construct() {

            parent::__construct ();
            // logger
            $this->session->set_userdata ( array (
                'log_FILE' => __FILE__
            ) );
        }

        public function index()
        {
            $this->session->set_userdata(array(
                'log_MODULE' => 'new_order',
                'log_MID'    => ''
            ) );

            $this->data['title'] = 'New Order';
            $this->data['result'] = $this->order_lib->new_order_index();
            //echo "<pre>";	print_r($this->data['result']); exit;
            $this->retailerCustomView('admin/shipping_management/orders_management/new_order_before_accept',$this->data);
        }

        public function new_order_ajax($total=0)
        {
            $this->session->set_userdata(array(
                'log_MODULE' => 'new_order_ajax',
                'log_MID'    => ''
            ) );

            $this->data['result'] = $this->order_lib->new_order_ajax($total);
            $this->load->view('admin/shipping_management/orders_management/new_order_list_ajax',$this->data);
        }

        public function accept_decline($orderID=0,$accept_decline=0)
        {
            $this->load->model('customer_m');
            $orderID = id_decrypt($orderID);
            $this->custom_log->write_log('custom_log','order id is'.$orderID);

            if((!empty($orderID))&&(!empty($accept_decline)))
            {
                if($accept_decline==2)
                {
                    $this->custom_log->write_log('custom_log','accept declined is '.$accept_decline);

                    $getDetails = $this->order_m->new_order_details($orderID);
                    $this->custom_log->write_log('custom_log','order details is '.print_r($getDetails,true));

                    //echo "<pre>"; print_r($getDetails);	exit;
                    if(!empty($getDetails))
                    {
                        $customerDetails = $this->customer_m->get_customer_with_shipping_detail($getDetails->customerId);
                        $this->custom_log->write_log('custom_log','customer details is '.print_r($customerDetails,true));

                        if(!empty($customerDetails))
                        {
                            if($getDetails->shippingRateId)
                            {
                                $rateDetails = $this->shipping_m->shipping_vendor_details($getDetails->shippingRateId);
                                $this->custom_log->write_log('custom_log','shipping rate details is '.print_r($rateDetails,true));
                                if(!empty($rateDetails))
                                {
                                    $retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
                                    $estimateDay     = $rateDetails->ETA+$this->config->item('estimated_time_increase');
                                    $shippingVendor  = $rateDetails->organizationName;

                                    $shippingAddName = $customerDetails->firstName.' '.$customerDetails->lastName;
                                    $shippingAddress = ucwords($customerDetails->firstName.' '.$customerDetails->lastName).' ,'.$customerDetails->phone.', '.$customerDetails->addressLine1.' '.$customerDetails->address_Line2.' ,'.$customerDetails->cityName.' '.$customerDetails->areaName.' '.$customerDetails->stateName.' '.$customerDetails->countryName;

                                    if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
                                    {
                                        $imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
                                    }
                                    else
                                    {
                                        $imagePath = base_url().'img/no_image.jpg';
                                    }

                                    $color = '';
                                    if($getDetails->colorId)
                                    {
                                        //$this->db->where('colorId',$getDetails->colorId);
                                        //$result = $this->db->get('colors')->row();
                                        //$color  = 'Color = '.$result->colorCode;
                                    }

                                    $size = '';
                                    if($getDetails->size)
                                    {
                                        //$size = 'Size = '.$getDetails->size;
                                    }

                                    if($getDetails->isPickup)
                                    {
                                        $pickupDetails = $this->cart_m->pickup_details($getDetails->pickupId);
                                        if($pickupDetails)
                                        {
                                            /********Mail for Customer*****/
                                            $mailData = array(
                                                'email'           => $customerDetails->email,
                                                //'cc'	          => $retailerDetails->email.','.$rateDetails->email,
                                                'cc'	          => '',
                                                'slug'            => 'pickup_confirm_order_for_customer',
                                                'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                                'customerPhone'	  => $customerDetails->phone,
                                                'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                                'eta'			  => $estimateDay,
                                                'shippingVendor'  => $shippingVendor,
                                                'shippingAddName' => $shippingAddName,
                                                'shippingAddress' => $shippingAddress,
                                                'sellerName'      => $retailerDetails->organizationName,
                                                'imagePath'		  => $imagePath,
                                                'productName'	  => $retailerDetails->code,
                                                'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                                'quantity'		  => $getDetails->quantity,
                                                'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                                'color'			  => $color,
                                                'size'			  => $size,
                                                'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                                'subject'  		  => 'Your Order Has Been Confirmed',
                                                'pickupCenter'		=> $pickupDetails->pickupName,
                                                'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName
                                            );
                                            $message='Thank you for your confirmation; please drop the '.substr($retailerDetails->code,0,15).' off at the '.$retailerDetails->dropCenterName.' Dropship centre';
                                            $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone ,$message);

                                            $customer_message='order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' , has been confirmed by the seller & will be at '.$pickupDetails->pickupName.' in '.$estimateDay.' days.';
                                            $customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
                                            $this->custom_log->write_log('custom_log',$customerresponsed);
                                            $this->custom_log->write_log('custom_log',$response);
                                        }
                                    }
                                    else
                                    {
                                        /********Mail for customer********************/
                                        $mailData = array(
                                            'email'           => $customerDetails->email,
                                            'cc'			  => '',
                                            //'cc'	          => .','.$rateDetails->email,
                                            'slug'            => 'confirm_order_for_customer',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Your Order Has Been Confirmed',
                                        );
                                        if($this->email_m->send_mail($mailData))
                                        {

                                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                                        }
                                        else
                                        {
                                            $this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                                        }
                                        /********Mail for retailer********************/
                                        $mailData = array(
                                            'email'           => $retailerDetails->email,
                                            'cc'			  => '',
                                            'slug'            => 'confirm_order_for_retailer',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Your Order Has Been Confirmed',
                                            'dropshipCenter'  => $retailerDetails->dropCenterName,
                                        );
                                        if($this->email_m->send_mail($mailData))
                                        {

                                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                                        }
                                        else
                                        {
                                            $this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                                        }

                                        /********Mail for shipping vendor********************/
                                        $mailData = array(
                                            'email'           => $rateDetails->email,
                                            'cc'			  => '',
                                            'slug'            => 'confirm_order_for_shipper',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Your Order Has Been Confirmed',
                                        );
                                        if($this->email_m->send_mail($mailData))
                                        {

                                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                                        }
                                        else
                                        {
                                            $this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                                        }
                                        $message='Thank you for your confirmation; please drop the '.substr($retailerDetails->code,0,20).' off at the '.$retailerDetails->dropCenterName.' Dropship centre';
                                        $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone ,$message);
                                        $customer_message='order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' , have been confirmed by the seller & will be  delivered in  '.$estimateDay.' days.';
                                        $customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
                                        $shipper_message='An order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' ,has been processed and is Confirmed.  Check for shipping manifest.';
                                        $shipper_message = $this->twillo_m->send_mobile_message($rateDetails->businessPhoneCode.$rateDetails->businessPhone  ,$shipper_message);


                                        $this->custom_log->write_log('custom_log',$customerresponsed);
                                        $this->custom_log->write_log('custom_log',$response);
                                    }
                                }
                                else
                                {
                                    $this->session->set_flashdata('error','Shipping vendor rate details not found');
                                }
                            }
                            else
                            {
                                $retailerDetails = $this->order_m->order_retailer_details($getDetails->organizationProductId);
                                $this->custom_log->write_log('custom_log','retailer details is '.print_r($retailerDetails,true));
                                $estimateDay     = $this->config->item('estimated_time_increase');
                                $shippingVendor  = '';

                                $shippingDetails = $this->order_m->order_shipping_address_details($getDetails->customerId,$getDetails->orderId);
                                $this->custom_log->write_log('custom_log','shipping details is '.print_r($shippingDetails,true));
                                $shippingAddName = $shippingDetails->firstName.' '.$shippingDetails->lastName;
                                $shippingAddress = ucwords($shippingDetails->firstName.' '.$shippingDetails->lastName).' ,'.$shippingDetails->phone.', '.$shippingDetails->addressLine1.' '.$shippingDetails->address_Line2.' ,'.$shippingDetails->cityName.' '.$shippingDetails->areaName.' '.$shippingDetails->stateName.' '.$customerDetails->countryName;

                                $imagePath = base_url().'img/no_image.jpg';
                                $color = '';
                                $size  = '';
                                if((!empty($retailerDetails->imageName))&&(file_exists('uploads/product/'.$retailerDetails->imageName)))
                                {
                                    $imagePath = base_url().'uploads/product/'.$retailerDetails->imageName;
                                }
                                if($getDetails->isPickup)
                                {
                                    $pickupDetails = $this->cart_m->pickup_details($getDetails->pickupId);
                                    $this->custom_log->write_log('custom_log','pickup details is '.print_r($pickupDetails,true));
                                    if($pickupDetails)
                                    {
                                        /*****Mail for Customer********/
                                        $mailData = array(
                                            'email'           => $customerDetails->email,
                                            'cc'	          => '',
                                            'slug'            => 'pickup_confirm_order_for_customer',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Your Order Has Been Confirmed',
                                            'pickupCenter'		=> $pickupDetails->pickupName,
                                            'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName
                                        );
                                        if($this->email_m->send_mail($mailData))
                                        {
                                            $message='Thank you for your confirmation; please drop the '.substr($retailerDetails->code,0,20).' off at the '.$retailerDetails->dropCenterName.' Dropship centre';
                                            $response = $this->twillo_m->send_mobile_message($retailerDetails->businessPhoneCode.$retailerDetails->businessPhone ,$message);

                                            $customer_message='order # '.$this->config->item('pre_orderId').$getDetails->customOrderId.' , has been confirmed by the seller & will be at '.$pickupDetails->pickupName.' in '.$estimateDay.' days.';
                                            $customerresponsed = $this->twillo_m->send_mobile_message('+234'.$customerDetails->phone ,$customer_message);
                                            $this->custom_log->write_log('custom_log',$customerresponsed);
                                            $this->custom_log->write_log('custom_log',$response);
                                            $this->custom_log->write_log('custom_log',$this->lang->line('success_add_retailer'));
                                        }
                                        else
                                        {
                                            $this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                                        }

                                        /*****Mail for retailer********/
                                        $mailData = array(
                                            'email'           => $retailerDetails->email,
                                            'cc'	          => '',
                                            'slug'            => 'pickup_confirm_order_for_retailer',
                                            'customerName'    => $customerDetails->firstName.' '.$customerDetails->lastName,
                                            'customerPhone'	  => $customerDetails->phone,
                                            'orderId'		  => $this->config->item('pre_orderId').$getDetails->customOrderId,
                                            'eta'			  => $estimateDay,
                                            'shippingVendor'  => $shippingVendor,
                                            'shippingAddName' => $shippingAddName,
                                            'shippingAddress' => $shippingAddress,
                                            'sellerName'      => $retailerDetails->organizationName,
                                            'imagePath'		  => $imagePath,
                                            'productName'	  => $retailerDetails->code,
                                            'currentPrice'	  => number_format($getDetails->chargedAmount,2),
                                            'quantity'		  => $getDetails->quantity,
                                            'subTotal'		  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'color'			  => $color,
                                            'size'			  => $size,
                                            'totalAmount'	  => number_format(($getDetails->chargedAmount*$getDetails->quantity),2),
                                            'subject'  		  => 'Your Order Has Been Confirmed',
                                            'pickupCenter'		=> $pickupDetails->pickupName,
                                            'pickup_centre_address' => $pickupDetails->addressLine1.','.$pickupDetails->cityName.','.$pickupDetails->areaName.','.$pickupDetails->stateName,
                                            'dropshipCenter'  => $retailerDetails->dropCenterName,
                                        );
                                        if($this->email_m->send_mail($mailData))
                                        {
                                            $this->custom_log->write_log('custom_log','Mail send to retailer');
                                        }
                                        else
                                        {
                                            $this->custom_log->write_log('custom_log',$this->lang->line('error_mail_not_send'));
                                        }
                                    }
                                }

                            }
                        }
                        else
                        {
                            $this->session->set_flashdata('error','Customer details not found');

                        }
                    }
                }
                //echo "RAMESH"; exit;
                if($this->order_m->change_accept_declined($orderID,$accept_decline))
                {
                    $orderTrackId = $this->order_m->add_order_track_details($orderID,2);
                    $this->session->set_flashdata('success',$this->lang->line('success_change_accept_declined_order'));
                }
                else
                {
                    $this->session->set_flashdata('error',$this->lang->line('error_change_accept_declined_order'));
                }
            }
            redirect(base_url().'retailer/new_order');
        }
    }
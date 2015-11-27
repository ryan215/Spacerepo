<?php defined ('BASEPATH') OR exit( 'No direct script access allowed' );
    require APPPATH . '/libraries/REST_Controller.php';

    class Dashboard extends REST_Controller
    {
        function __construct()
        {
            parent::__construct ();

            $this->load->model ('api_dashboard_sales_report');
            $this->load->helper ('api_validation');
            $this->load->model('employee_m');
            $this->load->model('api_product_m');
            if(is_array ($this->response->lang)) {
                $this->custom_log->write_log ('custom_log', print_r ($this->response->lang, TRUE));
                $this->lang->load ('error', $this->response->lang[0]);
                $this->lang->load ('success', $this->response->lang[0]);

            } else {
                $this->custom_log->write_log ('custom_log', print_r ($this->response->lang, TRUE));
                $this->lang->load ('error', $this->response->lang);
                $this->lang->load ('success', $this->response->lang);
                // $this->load->language('application', $this->response->lang);
            }

            $this->apiresponse['time'] = time ();

        }

        public function getWeeklySales_post()
        {
            $rules = api_sales_report_rules ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $week = $this->post ('week');
                $year= $this->post('year');
                $week_array = $this->getStartAndEndDate ($week,$year);
                $sales_report = $this->api_dashboard_sales_report->weekly_sales_report ($organizationId, $employeeId, $week,$year);
                foreach ($sales_report as $detail) {
                    $week_array[$detail->createdate] = number_format ($detail->totalAmount, 2, '.', '');
                }
             $total_employee=   $this->employee_m->total_employee($organizationId);
             if(!empty($total_employee) && isset($total_employee->total))
             {
                 $total_employee=$total_employee->total;
             }
              $total_product=$this->api_product_m->organization_product_count($organizationId);
                if(!empty($total_product))
                {
                    $total_product=$total_product->total;
                }
                $dates = array_keys ($week_array);
                $week_array = array_values ($week_array);

                $days = array(

                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday',
                    'Sunday',
                );
                $days = array_combine ($dates, $days);
                $week_array = array_combine ($days, $week_array);
                $today_sale=$this->api_dashboard_sales_report->get_today_sale_amount();

                if(!empty($today_sale))
                {
                    $total_sale=$today_sale->totalAmount;
                }
                else
                {
                    $total_sale=0;
                }
                if(!empty( $week_array )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully get the sales report',
                        'data'    => $week_array,
                        'todaysale'=> $total_sale,
                        'total_employee'=>$total_employee,
                        'total_product' =>$total_product

                    );

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in gettting the sales report'
                    );

                    $this->response ($this->apiresponse, 200);
                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }

        }

        public function getMonthalySales_post()
        {
            $rules = api_sales_month_report_rules ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $month = $this->post ('month');
                $year   = $this->post('year');
                $sales_report = $this->api_dashboard_sales_report->monthaly_sales_report ($organizationId, $employeeId, $month,$year);

                $week_array = $this->getStartAndEndDateMonth ($month,$year);

                foreach ($sales_report as $detail) {
                    $week_array[$detail->createdate] = number_format ($detail->totalAmount, 2, '.', '');
                }
                $total_employee=   $this->employee_m->total_employee($organizationId);
                if(!empty($total_employee) && isset($total_employee->total))
             {
                    $total_employee=$total_employee->total;
                }
                $total_product=$this->api_product_m->organization_product_count($organizationId);
                if(!empty($total_product))
                {
                    $total_product=$total_product->total;
                }
                $dates = array_keys ($week_array);
                $week_array = array_values ($week_array);
                $today_sale=$this->api_dashboard_sales_report->get_today_sale_amount();
                if(!empty($today_sale))
                {
                    $total_sale=$today_sale->totalAmount;
                }
                else
                {
                    $total_sale=0;
                }
                if(!empty($today_sale))
                {
                    $total_sale=$today_sale->totalAmount;
                }
                else
                {
                    $total_sale=0;
                }
                $days = array(
                    'week1',
                    'week2',
                    'week3',
                    'week4',
                    'week5',
                );
                $days = array_combine ($dates, $days);
                $week_array = array_combine ($days, $week_array);
                if(!empty( $week_array )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully get the sales report',
                        'data'    => $week_array,
                        'todaysale'=> $total_sale,
                        'total_employee'=>$total_employee,
                        'total_product' =>$total_product



                    );

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in gettting the sales report'
                    );

                    $this->response ($this->apiresponse, 200);
                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }

        }
        public function getYearlySales_post()
        {
            $rules = api_sales_year_report_rules ();
            $this->form_validation->set_rules ($rules);
            if($this->form_validation->run ()) {
                $organizationId = $this->post ('organizationId');
                $employeeId = $this->post ('employeeId');
                $year = $this->post ('year');
                $sales_report = $this->api_dashboard_sales_report->yearly_sales_report ($organizationId, $employeeId, $year);
                $total_employee=   $this->employee_m->total_employee($organizationId);
                if(!empty($total_employee) && isset($total_employee->total))
             {
				 $total_employee=$total_employee->total;
                }
                $total_product=$this->api_product_m->organization_product_count($organizationId);
                if(!empty($total_product))
                {
                    $total_product=$total_product->total;
                }
                $week_array=$this->getStartAndEndDateYear($year);

                foreach ($sales_report as $detail) {
                    $week_array[$detail->createdate] = number_format ($detail->totalAmount, 2, '.', '');
                }

                $dates = array_keys ($week_array);
                $week_array = array_values ($week_array);

                $days = array(
                    'jan',
                    'feb',
                    'mar',
                    'apr',
                    'may',
                    'jun',
                    'jul',
                    'aug',
                    'sep',
                    'oct',
                    'nov',
                    'dec',
                );
                // $dates='';
                $days = array_combine ($dates, $days);
                $week_array = array_combine ($days, $week_array);
                $today_sale=$this->api_dashboard_sales_report->get_today_sale_amount();
                if(!empty($today_sale))
                {
                    $total_sale=$today_sale->totalAmount;
                }
                else
                {
                    $total_sale=0;
                }
                if(!empty( $week_array )) {
                    $this->apiresponse['success'] = 1;

                    $this->apiresponse['response'] = array(
                        'message' => 'successfully get the sales report',
                        'data'    => $week_array,
                        'todaysale'=> $total_sale,
                        'total_employee'=>$total_employee,
                        'total_product' =>$total_product


                    );

                    $this->response ($this->apiresponse, 200);
                } else {
                    $this->apiresponse['success'] = 0;

                    $this->apiresponse['response'] = array(
                        'message' => 'error in gettting the sales report'
                    );

                    $this->response ($this->apiresponse, 200);
                }
            } else {
                $this->apiresponse['success'] = 0;

                $this->apiresponse['response'] = array(
                    'message' => $this->form_validation->error_array ()
                );

                $this->response ($this->apiresponse, 200);
            }

        }

        function getStartAndEndDate($week, $year)
        {
            $dto = new DateTime();
            $dto->setISODate ($year, $week);
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            $dto->modify ('+1 days');
            $ret[$dto->format ('Y-m-d')] = "0";
            return $ret;
        }

        function getStartAndEndDateMonth($month, $year)
        {
            $dto = new DateTime();
            $dto->setDate ($year, $month, 1);
            $ret[$dto->format ('Y-W')] = "0";
            $dto->modify ('+1 weeks');
            $ret[$dto->format ('Y-W')] = "0";
            $dto->modify ('+1 weeks');
            $ret[$dto->format ('Y-W')] = "0";
            $dto->modify ('+1 weeks');
            $ret[$dto->format ('Y-W')] = "0";
            $dto->modify ('+1 weeks');
            $ret[$dto->format ('Y-W')] = "0";

            return $ret;
        }

        function getStartAndEndDateYear( $year)
        {
            $dto = new DateTime();
            $dto->setDate ($year,1, 1);
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";
            $dto->modify ('+1 months');
            $ret[$dto->format ('Y-n')] = "0";


            return $ret;
        }


    }
    
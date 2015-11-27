<?php

    class Api_dashboard_sales_report extends MY_Model
    {

        public function __construct()
        {
            parent::__construct ();
        }

        public function weekly_sales_report($organizationId, $employeeId, $week,$year)
        {
            $this->db->select ('sum(order.totalAmount) as totalAmount,DATE_FORMAT(order.createDt,"%Y-%m-%d") as createdate',false);
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order_payment.orderId=order.customOrderId');
            $this->db->join ('organization_product', 'order.organizationProductId=organization_product.organizationProductId');
            $this->db->where (
                array(

                    'DATE_FORMAT(order.createDt,"%Y-%u")'    =>$year.'-'.$week,
                )
            );

            $this->db->group_by ('createdate');
            $query = $this->db->get ();
            return $query->result ();


        }
        public function monthaly_sales_report($organizationId, $employeeId, $month,$year)
        {
            $this->db->select ('sum(order.totalAmount) as totalAmount,DATE_FORMAT(order.createDt,"%Y-%u") as createdate',false);
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order_payment.orderId=order.customOrderId');
            $this->db->join ('organization_product', 'order.organizationProductId=organization_product.organizationProductId');
            $this->db->where (
                array(

                    'DATE_FORMAT(order.createDt,"%Y-%c")'    => $year.'-'.$month,
                )
            );

            $this->db->group_by ('createdate');
            $query = $this->db->get ();
            return $query->result ();


        }
        public function Yearly_sales_report($organizationId, $employeeId, $year)
        {
            $this->db->select ('sum(order.totalAmount) as totalAmount,DATE_FORMAT(order.createDt,"%Y-%c") as createdate',false);
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order_payment.orderId=order.customOrderId');
            $this->db->join ('organization_product', 'order.organizationProductId=organization_product.organizationProductId');
            $this->db->where (
                array(

                    'DATE_FORMAT(order.createDt,"%Y")'    => $year,
                )
            );

            $this->db->group_by ('createdate');
            $query = $this->db->get ();
            return $query->result ();


        }
        function get_today_sale_amount()
        {
            $this->db->select ('sum(order.totalAmount) as totalAmount,DATE_FORMAT(order.createDt,"%Y-%m-%d") as createdate',false);
            $this->db->from ('order');
            $this->db->join ('order_payment', 'order_payment.orderId=order.customOrderId');
            $this->db->join ('organization_product', 'order.organizationProductId=organization_product.organizationProductId');
            $this->db->where ('DATE_FORMAT(order.createDt,"%Y-%m-%d")= CURDATE()');

            $this->db->group_by ('createdate');
            $query = $this->db->get ();
            return $query->row ();

        }


    }
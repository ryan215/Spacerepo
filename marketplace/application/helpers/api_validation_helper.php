<?php
    function api_login_rules()
    {
        $rules = array(

            array(

                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required' ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required' ),

        );
        return $rules;
    }

    function api_signup_rules()
    {
        $rules = array(
            array(
                'field' => 'firstName',

                'label' => 'First Name',

                'rules' => 'trim|required' ),

            array(
                'field' => 'isPointeMart',

                'label' => 'isPointeMart',
                'rules' => 'trim|required' ),
            array(
                'field' => 'isPointePay',
                'label' => 'isPointePay',
                'rules' => 'trim|required' ),
            array(
                'field' => 'organizationName',
                'label' => 'Organization Name',
                'rules' => 'trim|required|is_unique[organization.organizationName]' ),
            array(
                'field' => 'lastName',
                'label' => 'Last Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'middleName',
                'label' => 'middle Name',
                'rules' => 'trim' ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required' ),
            array(
                'field' => 'addressLine1',
                'label' => 'Street',
                'rules' => 'trim|required' ),
            array(
                'field' => 'businessPhoneCode',
                'label' => 'businessPhoneCode',
                'rules' => 'trim|required' ),
            array(
                'field' => 'city',
                'label' => 'City',
                'rules' => 'trim|required' ),
            array(
                'field' => 'state',
                'label' => 'State',
                'rules' => 'trim|required' ),
            array(
                'field' => 'userName',
                'label' => 'User Name',
                'rules' => 'trim|required|is_unique[employee.userName]' ),
            array(
                'field' => 'country',
                'label' => 'country',
                'rules' => 'trim|required' ),
            array(
                'field' => 'businessPhone',
                'label' => 'Phone',
                'rules' => 'trim|required|callback_check_businessPhone' ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|is_unique[employee.email]' ),
        );
        return $rules;
    }

    function check_userdetail()
    {
        $riles = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|is_unique[employee.email]' ),
            array(
                'field' => 'businessPhone',
                'label' => 'Phone',
                'rules' => 'trim|required|callback_check_businessPhone' ),
            array(
                'field' => 'businessPhoneCode',
                'label' => 'Phone',
                'rules' => 'trim|required' ),
            array(
                'field' => 'organizationName',
                'label' => 'organization Name',
                'rules' => 'trim|required|is_unique[organization.organizationName]' ),
            array(
                'field' => 'userName',
                'label' => 'User Name',
                'rules' => 'trim|required|is_unique[employee.userName]' )

        );
        return $riles;
    }

    function area_validation()
    {
        $rules = array(
            array(
                'field' => 'country_id',
                'label' => 'country id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'state_id',
                'label' => 'state id',
                'rules' => 'trim|required' ) );

        return $rules;
    }

    function city_validation()
    {
        $rules = array(
            array(
                'field' => 'country_id',
                'label' => 'country id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'state_id',
                'label' => 'state id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'area_id',
                'label' => 'area id',
                'rules' => 'trim|required' )

        );

        return $rules;
    }

    function send_verification()
    {
        $rules = array(
            array(
                'field' => 'businessPhone',
                'label' => 'Business Phone',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required' ),


        );

        return $rules;
    }

    function check_verification()
    {
        $rules = array(
            array(
                'field' => 'oraganizationId',
                'label' => 'oraganization Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'verificationPref',
                'label' => 'verification Prefrence',
                'rules' => 'trim|required' ) );
        return $rules;
    }

    function check_username()
    {
        $rules = array(
            array(
                'field' => 'userName',
                'label' => 'User Name',
                'rules' => 'trim|required|is_unique[employee.userName]' ) );
        return $rules;

    }

    function api_add_employeerules()
    {
        $rules = array(
            array(
                'field' => 'firstName',
                'label' => 'First Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'lastName',
                'label' => 'Last Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'businessPhone',
                'label' => 'Phone No',
                'rules' => 'trim|required' ),
            array(
                'field' => 'salary',
                'label' => 'salary',
                'rules' => 'trim|required' ),
            array(
                'field' => 'state',
                'label' => 'state',
                'rules' => 'trim|required' ),
            array(
                'field' => 'city',
                'label' => 'city',
                'rules' => 'trim|required' ),
            array(
                'field' => 'area',
                'label' => 'Area',
                'rules' => 'trim|required' ),
            array(
                'field' => 'addressLine1',
                'label' => 'address',
                'rules' => 'trim|required' ),
            array(
                'field' => 'organizationId',
                'label' => 'organization ID',
                'rules' => 'trim|required' ),
            array(
                'field' => 'role',
                'label' => 'employee roles',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'employee Id',
                'rules' => 'trim|required' ),
        );
        return $rules;
    }

    function add_organization_customer_rules()
    {
        $rules = array(
            array(
                'field' => 'firstName',
                'label' => 'first Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'lastName',
                'label' => 'last Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'notes',
                'label' => 'Note',
                'rules' => 'trim' ),
            array(
                'field' => 'phone',
                'label' => 'Phone Number',
                'rules' => 'trim|required|is_unique[customer.phone]' ),
            array(
                'field' => 'state',
                'label' => 'state',
                'rules' => 'trim|required' ),
            array(
                'field' => 'city',
                'label' => 'city',
                'rules' => 'trim|required' ),
            array(
                'field' => 'area',
                'label' => 'Area',
                'rules' => 'trim|required' ),
            array(
                'field' => 'addressline1',
                'label' => 'street',
                'rules' => 'trim|required' ),
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required' ),


        );
        return $rules;

    }

    function api_add_category()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'categoryCode',
                'label' => 'category name',
                'rules' => 'trim|required|callback_checkCategoryCode' ),
            array(
                'field' => 'categoryDescription',
                'label' => 'category Description',
                'rules' => 'trim' ),
        );
        return $rules;

    }

    function api_update_category()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'categoryId',
                'label' => 'category Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'categoryCode',
                'label' => 'category name',
                'rules' => 'trim|required|callback_checkCategoryCode' ),
            array(
                'field' => 'categoryDescription',
                'label' => 'category Description',
                'rules' => 'trim' ),
        );
        return $rules;

    }

    function required_organization_id()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
        );
        return $rules;
    }

    function api_forgot_password()
    {

        $rules = array(
            array(
                'field' => 'businessPhone',
                'label' => 'business Phone',
                'rules' => 'trim|required' ),
            array(
                'field' => 'businessPhoneCode',
                'label' => 'business Phone code',
                'rules' => 'trim|required' ) );
        return $rules;
    }

    function api_reset_password()
    {
        $rules = array(
            array(
                'field' => 'employeeId',
                'label' => 'employee Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'trim|required' ) );
        return $rules;
    }

    function master_list_validation()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required' ),
            array(
                'field' => 'count',
                'label' => 'count',
                'rules' => 'trim|required' ),


        );
        return $rules;

    }

    function api_master_prd_inventory()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'productCodeOveride',
                'label' => 'Product Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'currentPrice',
                'label' => 'sale Price',
                'rules' => 'trim|required' ),
            array(
                'field' => 'categoryId',
                'label' => 'Category Id',
                'rules' => 'trim|required' ),


            array(
                'field' => 'costPrice',
                'label' => 'Cost Price',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'Retailer id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'upc',
                'label' => 'UPC',
                'rules' => 'trim|required' ),


        );
        return $rules;
    }

    function api_master_prd_update()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organizationId',
                'rules' => 'trim|required' ),
            array(
                'field' => 'productCodeOveride',
                'label' => 'Product Name',
                'rules' => 'trim|required' ),
            array(
                'field' => 'currentPrice',
                'label' => 'sale Price',
                'rules' => 'trim|required' ),
            array(
                'field' => 'categoryId',
                'label' => 'Category ID',
                'rules' => 'trim|required' ),


            array(
                'field' => 'costPrice',
                'label' => 'Cost Price',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'Retailer id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'upc',
                'label' => 'UPC',
                'rules' => 'trim|required' ),


        );
        return $rules;
    }

    function api_inventory_rules()
    {


        $rules = array(
            array(
                'field' => 'organizationProductId',
                'label' => 'organization Product Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'inventory',
                'label' => 'inventory',
                'rules' => 'trim|required' ),
        );
        return $rules;
    }

    function api_sale_rules()
    {


        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'products',
                'label' => 'products',
                'rules' => 'trim|required' ),
            array(
                'field' => 'employeeId',
                'label' => 'Employee Id',
                'rules' => 'trim|required' ),
            array(
                'field' => 'totalAmount',
                'label' => 'total Amount',
                'rules' => 'trim|required' ),
        );
        return $rules;
    }


    function api_upc_product_detail()
    {


        $rules = array(

            array(
                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),

            array(

                'field' => 'upc',

                'label' => 'upc',

                'rules' => 'trim|required' ),


        );
        return $rules;
    }

    function api_block_unblock_employee()
    {
        $rules = array(

            array(

                'field' => 'organizationId',

                'label' => 'organization Id',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'employeeId',

                'label' => 'employeeId',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'staffEmployeeId',

                'label' => 'staff Employee Id',

                'rules' => 'trim|required'
            ),

            array(
                'field' => 'blockStatus',

                'label' => 'blockStatus',

                'rules' => 'trim'
            ),


        );
        return $rules;
    }

    function api_activate_deactivate_discount()
    {
        $rules = array(

            array(

                'field' => 'organizationId',

                'label' => 'organization Id',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'employeeId',

                'label' => 'employeeId',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'discountId',

                'label' => 'Discount Id',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'activeStatus',

                'label' => 'active Status',

                'rules' => 'trim'
            ),


        );
        return $rules;
    }

    function api_add_discount_post()
    {
        $rules = array(

            array(

                'field' => 'organizationId',

                'label' => 'organization Id',

                'rules' => 'trim|required' ),

            array(

                'field' => 'employeeId',

                'label' => 'employeeId',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'title',

                'label' => 'Title',

                'rules' => 'trim|required'
            ),

            array(

                'field' => 'discount',

                'label' => 'discount',

                'rules' => 'trim|required'
            ),
            array(

                'field' => 'discountOn',

                'label' => 'Discount on',

                'rules' => 'trim|required'
            ),


        );
        return $rules;
    }

    function add_product_discount()
    {
        $rules = array(

            array(

                'field' => 'organizationId',

                'label' => 'organization Id',

                'rules' => 'trim|required' ),

            array(

                'field' => 'employeeId',

                'label' => 'employeeId',

                'rules' => 'trim|required'
            ),
            array(

                'field' => 'products',

                'label' => 'products',

                'rules' => 'trim|required'
            ),
            array(

                'field' => 'discountId',

                'label' => 'Discount Id',

                'rules' => 'trim|required'
            ),


        );
        return $rules;

    }

    function api_sales_report_rules()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'week',
                'label' => 'week',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'year',
                'label' => 'year',
                'rules' => 'trim|required'
            ),
        );
        return $rules;
    }

    function api_sales_month_report_rules()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'month',
                'label' => 'month',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'year',
                'label' => 'year',
                'rules' => 'trim|required'
            ),
        );
        return $rules;
    }

    function api_sales_year_report_rules()
    {
        $rules = array(
            array(
                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'year',
                'label' => 'year',
                'rules' => 'trim|required'
            ),
        );
        return $rules;

    }

    function api_product_list_for_discount()
    {
        $rules = array(

            array(

                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            ),
          array(
                'field' => 'discountId',
                'label' => 'Discount Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'count',
                'label' => 'count',
                'rules' => 'trim|required'
            ),


        );
        return $rules;
    }
    function api_product_list_for_discount_Id()
    {
        $rules = array(

            array(

                'field' => 'organizationId',
                'label' => 'organization Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'employeeId',
                'label' => 'employeeId',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'discountId',
                'label' => 'Discount Id',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'set',
                'label' => 'set',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'count',
                'label' => 'count',
                'rules' => 'trim|required'
            ),


        );
        return $rules;
    }
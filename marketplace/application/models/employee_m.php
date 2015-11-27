<?php if (!defined('BASEPATH')) exit( 'No direct script access allowed' );

    class Employee_m extends MY_Model
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function total_employee($organizationId, $where='')
        {
            $this->db->select('count(*) as total');
            $this->db->from('employee');
            $this->db->join('emp_role', 'employee.employeeId=emp_role.employeeId');
            $this->db->join('role', 'emp_role.roleId=role.roleId');
            $this->db->where('role.code', 'employee');
            $this->db->where('employee.organizationId', $organizationId);
            if (!empty( $where )) {
                $this->db->where($where);
            }
            $query = $this->db->get();

            return $query->row();


        }

        public function ajax_employee_list($start = '', $limit = '', $organizationId, $where = '')
        {
            $this->db->select('role.*,address.*,employee.*,designation_role.code as designation,(select group_concat(roleId) from emp_role where emp_role.employeeId=employee.employeeId) as empRoleList,country.name AS countryName,state.stateName,zip.city AS cityName,area.area AS areaName');
            $this->db->from('employee');
			$this->db->join('employee_designation','employee_designation.employeeId=employee.employeeId','left');
			$this->db->join('designation_role','designation_role.designationId=employee_designation.designationId','left');
            $this->db->join('employee_address', 'employee.employeeId=employee_address.employeeId', 'left');
            $this->db->join('address', 'employee_address.addressId=address.addressId', 'left');
            $this->db->join('country', 'address.country = country.countryId', 'left');
            $this->db->join('state', 'address.state = state.stateId', 'left');
            $this->db->join('area', 'address.area = area.areaId', 'left');
            $this->db->join('zip', 'address.city = zip.zipId', 'left');

            $this->db->join('emp_role', 'employee.employeeId=emp_role.employeeId');
            $this->db->join('role', 'emp_role.roleId=role.roleId');
            $this->db->where('role.code', 'employee');
            $this->db->where('employee.organizationId', $organizationId);
            if (!empty( $where )) {
                $this->db->where($where);
            }
            if (!empty( $start ) && !empty( $limit )) {
                $this->db->limit($limit, $start);
            }

            $query = $this->db->get();

            return $query->result();
        }

        public function block_unblock_employee($staffEmployeeId, $blockStaus = 0, $employeeId)
        {
            $data = array(
                'active'         => $blockStaus,
                'lastModifiedBy' => $employeeId,
                'lastModifiedDt' => date('Y-m-d H:i:s'),

            );
            $this->db->where('employeeId', $staffEmployeeId);
            $this->db->update('employee', $data);

            return $this->db->affected_rows();
        }

        public function get_employee_detail($staffEmployeeId)
        {
            $this->db->select('*');
            $this->db->from('employee');
            $this->db->where('employeeId',$staffEmployeeId);
            return $this->db->get()->row();


        }
    }
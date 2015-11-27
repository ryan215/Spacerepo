<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class color_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_colors()
	{
		$result=$this->db->select('*')->from('colors')->get()->result();
		return $result;
	}
	
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Custom_product {

	protected $_log_path;
	protected $_threshold = 1;
	protected $_date_fmt  = 'Y-m-d H:i:s';
	protected $_enabled	  = TRUE;
	protected $_levels	  = array('ERROR' => '1', 'DEBUG' => '2',  'INFO' => '3', 'ALL' => '4');
	
	
	protected $CI;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->CI =& get_instance();
		
		$this->CI->load->library('session');
		
		$config =& get_config();

		$this->_log_path = ($config['product_path'] != '') ? $config['product_path'] : APPPATH.'product_log/';

		if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))
		{
			$this->_enabled = FALSE;
		}

		if (is_numeric($config['log_threshold']))
		{ 
			$this->_threshold = $config['log_threshold'];
		}

		if ($config['log_date_format'] != '')
		{
			$this->_date_fmt = $config['log_date_format'];
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level
	 * @param	string	the error message
	 * @param	bool	whether the error is a native PHP error
	 * @return	bool
	 */
	
	public function write_log($level = 'error', $msg,$productname_suffix, $php_error = FALSE)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}
	
		$level = strtoupper($level);
	
		if ($level!='CUSTOM_LOG' AND (! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold)))
		{
			return FALSE;
		}
	
		$filepath = $this->_log_path.'product_log'.$productname_suffix.'.json';
		$message  = '';
	
		
	
		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
	
		$message = $msg;
		
		
		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);
		@chmod($filepath, FILE_WRITE_MODE);
		return TRUE;
	}
}
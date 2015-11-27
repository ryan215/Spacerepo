<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Name:  Twilio
	*
	* Author: Ben Edmunds
	*		  ben.edmunds@gmail.com
	*         @benedmunds
	*
	* Location:
	*
	* Created:  03.29.2011
	*
	* Description:  Twilio configuration settings.
	*
	*
	*/

	/**
	 * Mode ("sandbox" or "prod")
	 **/
	$config['mode']   = 'prod';

	/**
	 * Account SID
	 **/
	$config['account_sid']   = 'ACb5461ab805ac85badc282ab1e1b72e46';

	/**
	 * Auth Token
	 **/
	$config['auth_token']    = '533f718c18fcb9f2f08a82f22fd79429';

	/**
	 * API Version
	 **/
	$config['api_version']   = '2010-04-01';

	/**
	 * Twilio Phone Number
	 **/
	$config['number']        = '+1706-383-0744';


/* End of file twilio.php */
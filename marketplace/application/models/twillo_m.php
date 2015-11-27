<?php 
class Twillo_m extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
		
    }
	public function send_mobile_message_backup($to,$message)
	{
		$this->load->library('twilio');
		//$user_detail=$this->Location_model->get_country('',$country_id);
		$to=str_replace('+','',$to);
		$from = '+1706-383-0744';
		$to = '+'.$to;
		//$message = 'This is a test...';
		$response='';
		$response = $this->twilio->sms($from, $to, $message);
		//$response = $this->twilio->call($from, $to, $message);

		$this->custom_log->write_log('custom_log','twillo api response:'.print_r($response,true));
		return $response;
	}
	
	public function send_mobile_message($to,$message)
	{/*
		$to         = str_replace('+','',$to);
		$sms_msg    = "";
		$owneremail = "oogbebor@spacepointe.com";
		$subacct    = "SPACEPOINTE";
		$subacctpwd = "sP9Ng#2015"; 
		$sendto     = "".$to.""; // destination number /
        $sender     = "Spacepointe"; // sender id /
        $msg        = "".$message.""; // message to be sent /

		// create the required URL /

        $url = "http://www.smslive247.com/http/index.aspx?"
            	."cmd=sendquickmsg"
            	."&owneremail=".UrlEncode($owneremail)
            	."&subacct=".UrlEncode($subacct)
            	."&subacctpwd=".UrlEncode($subacctpwd)
            	."&message=".UrlEncode($msg)
            	."&sender=".UrlEncode($sender)
            	."&sendto=".UrlEncode($sendto)
            	."&msgtype=".UrlEncode(0);

            // call the URL /

			if ($f = @fopen($url, "r"))
			{
				$answer = fgets($f, 255);
				if(substr($answer, 0, 1) == "+")
				{
					 $sms_msg= "SMS to $sendto was successful.";
				}
				else
				{
					$sms_msg= "an error has occurred: [$answer].";
				}
			}
			else
			{
				$sms_msg= "Error: URL could not be opened.";
			}
			return $answer;
	*/
		return 1;
	}
	
	public function mobile_call($to,$message)
	{
		$this->load->library('twilio');
		//$user_detail=$this->Location_model->get_country('',$country_id);
		$to=str_replace('+','',$to);
		$from = '+1706-383-0744';
		$to = '+'.$to;
		//$message = 'This is a test...';
		$response='';
		//$response = $this->twilio->sms($from, $to, $message);
		$response = $this->twilio->call($from, $to, $message);

		$this->custom_log->write_log('custom_log','twillo api response:'.print_r($response,true));
		return $response;
	}
}
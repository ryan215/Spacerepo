<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function customMail($data)
	{
		$config = Array(
                	'protocol'  => 'smtp',
	                'smtp_host' => 'smtp.1and1.com',
	                'smtp_port' => '587',
	                'smtp_user' => 'noreply@spacepointe.com',
	                'smtp_pass' => '12345678',
	                'mailtype'  => 'html',
					'charset'   => 'iso-8859-1',
					'wordwrap'  => TRUE,
				 );
		
		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");;			

		$cc = '';

		if(isset($data['cc'])&&(!empty($data['cc'])))
		{
			$cc = $data['cc'];
		}		
	
		$this->email->from($this->config->item('admin_email'),$this->config->item('admin_name'));
		$this->email->to('techwatts4@gmail.com');
		//$this->email->to($data['toEmail']);		
		//$this->email->cc($cc);
		if((!empty($data['bcc']))&&($data['bcc']))
		{
			//$this->email->bcc($data['bcc']);
		}		
		//$this->email->bcc('techwatts3@gmail.com');
		$this->email->subject($data['subject']);
		$this->email->message($data['body']);
		
		if(!empty($data['attechmnt']))
		{
			$this->email->attach($data['attechmntPath']);
		}
		
		return $this->email->send();	
	}
	
	public function news_letter_send_mail($data)
	{
		$config = Array(
                	'protocol'  => 'smtp',
	                'smtp_host' => 'smtp.1and1.com',
	                'smtp_port' => '587',
	                'smtp_user' => 'noreply@spacepointe.com',
	                'smtp_pass' => '12345678',
	                'mailtype'  => 'html',
					'charset'   => 'iso-8859-1',
					'wordwrap'  => TRUE,
					'crlf' 	    => "\r\n",
					'newline'   => "\r\n",
				);
		
		$body = $this->parser->parse('email_template/'.$data['slug'],$data,true); 
		
		$this->load->library('email',$config);
		$this->email->from($this->config->item('admin_email'),$this->config->item('admin_name'));
		$this->email->to('techwatts4@gmail.com');
		//$this->email->to($data['toEmail']);		
		$this->email->subject($data['subject']);
		$this->email->message($body);
		return $this->email->send();	
	}
	
	public function send_mail($data)
	{
		$subject  = $data['subject'];
		$body     = $this->parser->parse('email_template/'.$data['slug'],$data,true); 
		$sendData = array(
						'toEmail' => $data['email'],
						'subject' => $subject,
						'body'    => $body,
						'cc'      => $data['cc']
					);		
		//echo "<pre>";	print_r($sendData); exit;
		if(!empty($data['attechmnt']))
		{
			$sendData['attechmnt'] = $data['attechmnt'];
			$sendData['attechmntPath'] = $data['attechmntPath'];
		}
		
		return $this->customMail($sendData);
	}
	public function sendHeadercustomMail($data)
	{
		//$this->load->library('email');
		
		
		/*$config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.1and1.com',
                'smtp_port' => '587',
                'smtp_user' =>'devadmin@spacepointe.com',
                'smtp_pass' => '12345678',
                'mailtype'  => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE,
				//'priority'=>	1
              );*/
			  $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.1and1.com',
                'smtp_port' => '587',
                'smtp_user' =>'noreply@spacepointe.com',
                'smtp_pass' => '12345678',
                'mailtype'  => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE,
				//'priority'=>	1
              );


		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");;			

		$cc = '';

		if(isset($data['cc'])&&(!empty($data['cc'])))
		{
			$cc = $data['cc'];
		}		
	
		//$this->email->from('devadmin@spacepointe.com',$this->config->item('admin_name'));
		$this->email->from($this->config->item('admin_email'),$data['fromMail'].' via pointepay');

		$this->email->to($data['toEmail']);
		$this->email->cc($cc);
		if((!empty($data['bcc']))&&($data['bcc']))
		{
			$this->email->bcc($data['bcc']);
		}		
		$this->email->subject($data['subject']);
		$this->email->message($data['body']);
		
		if(!empty($data['attechmnt']))
		{
			$this->email->attach($data['attechmntPath']);
		}
		
		return $this->email->send();	
	}
	
	public function send_header_mail($data)
	{
		$subject  = $data['subject'];
		$body     = $this->parser->parse('email_template/'.$data['slug'],$data,true); 
		$sendData = array(
						'toEmail' => $data['email'],
						'subject' => $subject,
						'body'    => $body,
						'cc'      => $data['cc'],
						'fromMail' => $data['from']
					);		
					//print_r($sendData); exit;
		if(!empty($data['attechmnt']))
		{
			$sendData['attechmnt'] = $data['attechmnt'];
			$sendData['attechmntPath'] = $data['attechmntPath'];
		}
		
		return $this->sendHeadercustomMail($sendData);
	}
}

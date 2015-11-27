<?php  if (! defined ( 'BASEPATH' ))  exit ( 'No Direct Access Allowed' );

class News_subscription_email extends MY_Controller {
	
    public function __construct() {

        parent::__construct ();

		$this->session->set_userdata ( array (
                'log_FILE' => __FILE__
        ) );
		
        $this->load->model('news_sub_email_m');
		$this->load->library('news_subscription_email_lib');
        $this->data['title'] = 'Newsletter Subscription';
    }
    
	public function index()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'compose_mail',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Compose Mail';
		
		$this->data['result'] = $this->news_subscription_email_lib->total_subscribe_with_unsubscribe_list();
		$this->news_subscription_email_lib->compose_mail();
		$this->adminCustomView('news_subscription_emails/compose_mail',$this->data);
    }
	
	public function mail_history_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'mail_history_list',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Mail History';
		$this->data['result'] = $this->news_subscription_email_lib->total_subscribe_with_unsubscribe_list();
		$this->adminCustomView('news_subscription_emails/mail_history_list',$this->data);
    }
	
	public function ajax_mail_history_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajax_mail_history_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->news_subscription_email_lib->ajax_mail_history_list();
		$this->load->view('news_subscription_emails/mail_history_ajax_list',$this->data);
	}
	
	public function subscribe_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'subscribe_list',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Subscribe News Letter';
		$this->data['result'] = $this->news_subscription_email_lib->total_subscribe_with_unsubscribe_list();
		$this->adminCustomView('news_subscription_emails/subscribe_list',$this->data);
    }
	
	public function ajax_subscribe_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajax_subscribe_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->news_subscription_email_lib->ajax_subscribe_list();
		$this->load->view('news_subscription_emails/subscribe_ajax_list',$this->data);
	}
	
	public function unsubscribe_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'unsubscribe_list',
				'log_MID'    => '' 
		) );
		
		$this->data['title']  = 'Unsubscribe News Letter';
		$this->data['result'] = $this->news_subscription_email_lib->total_subscribe_with_unsubscribe_list();
		$this->adminCustomView('news_subscription_emails/unsubscribe_list',$this->data);
    }
	
	public function ajax_unsubscribe_list()
    {
		$this->session->set_userdata(array(
				'log_MODULE' => 'ajax_unsubscribe_list',
				'log_MID'    => '' 
		) );
		
		$this->data['result'] = $this->news_subscription_email_lib->ajax_unsubscribe_list();
		$this->load->view('news_subscription_emails/unsubscribe_ajax_list',$this->data);
	}	
}

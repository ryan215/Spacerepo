<?php
 
class Recharge_lib {

    public $CurlHeaders;
    public $ResponseCode;

    public function __construct() {
        $this->CurlHeaders = array();
        $this->ResponseCode = 0;
    }


	function do_recharge_request($param)
	{

		$random_number = rand(5,10);
		$transaction_id = "abc".$random_number;  // string. Number not allowed
		//$db->insert("recharge_test_table",array("trans_id" => $transaction_id,"time"=>time()));


		$oauth_consumer_key = $client_id = $consumer_key = "spacepoint_nigeria_demo_user1";
		$oauth_consumer_secret = $client_secret = $consumer_secret = "wltJSD3ztLKfBQmIW32iSGfcrwe3okS0";
		$username = "spacepoint_nigeria_demo_user1";
//		$msisdn = "2348059827239"; // mobile number +234-8059827239
//		$msisdn = "2340123456789";
		$msisdn = "234".$param['mobile_no'];
//		$face_value = 5000;
		$face_value = (int) $param['amount'];
		//$face_value *= 100;
		$supplier_api = "ttdemo_v1";
		$product_info = array("product" => "airtime");


	//	echo $face_value;
	//	echo " ";
	//	echo $msisdn;exit;
		
		try
		{
			$params = array("username"=>$username, "msisdn"=>$msisdn,"transaction_id"=>$transaction_id, "face_value"=>$face_value,"supplier_api"=>$supplier_api, "product_info"=>$product_info);

			$request = new OAuth($oauth_consumer_key, $oauth_consumer_secret,OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

			//print_r($request);

			$request->disableSSLChecks();

			$request->fetch("https://hsc16.miranetworks.net:16000/v1/recharge",json_encode($params), OAUTH_HTTP_METHOD_POST,array("Content-Type"=>"application/json"));

			return $response = $request->getLastResponse();

			//echo $response;
//			echo "<pre>";
//			print_r($response);

//			return $response;


		}
		 catch(Exception $e) {
		  return 'Message: ' .$e->getMessage();
		}

	}

}
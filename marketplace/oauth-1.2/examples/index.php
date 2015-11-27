<?php
require("config.inc.php");
try {


	$request = new OAuth(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET,OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_AUTHORIZATION);
	
$JSONBody = '{
        "username": "spacepoint_nigeria_demo_user1",
        "msisdn": "2340123456789",
        "transaction_id": "abc123",
        "face_value": 5000,
        "supplier_id": "ttdemo_v1",
        "product_info": {
            "product": "airtime"
            }
        }';

$request->fetch($url, $JSONBody, OAUTH_HTTP_METHOD_POST, array('Content-Type' => 'application/json'));

echo $request->getLastResponse();



// Hit the server
//$request->fetch($url);

//echo $request->getLastResponse();

/*
	exit;

	$request_token_info = unserialize(file_get_contents(OAUTH_TMP_DIR . "/request_token_resp"));
    
    $o->setToken($request_token_info["oauth_token"],$request_token_info["oauth_token_secret"]);
    
    $arrayResp = $o->getAccessToken("https://www.foo.tld/oauth/accessToken");
	file_put_contents(OAUTH_TMP_DIR . "/access_token_resp",serialize($arrayResp));
    echo "Finished getting the access token!"; */
} catch(OAuthException $E) {
	echo "Response: ". $E->lastResponse . "\n";
}

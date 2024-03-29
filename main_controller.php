<?php
// Get our helper functions
require_once("functions.php");
require_once("connect_to_mysql.php");
// Set variables for our request
$api_key = "1ad16161f1d79d041faa271898ce163f";
$shared_secret = "f27efe0cdd9245fef7c4bc408280a585";
$params = $_GET; // Retrieve all request parameters

$hmac = $_GET['hmac']; // Retrieve HMAC request parameter
$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexographically
$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);
// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {
	// Set variables for our request
	$query = array(
		"client_id" => $api_key, // Your API key
		"client_secret" => $shared_secret, // Your app credentials (secret key)
		"code" => $params['code'] // Grab the access key from the URL
	);
	
	// Generate access token URL
	$access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
	// Configure curl client and execute request
	//echo "$access_token_url";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, $access_token_url);
	curl_setopt($ch, CURLOPT_POST, count($query));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));


	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
	$result = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);
	// Store the access token
	
	$result1 = json_decode($result, true);
	
	$access_token = $result1['access_token'];
echo "$error";

	// Show the access token (don't do this in production!)
	
	$sql = "INSERT INTO table_token (store_url, access_token, install_date)
		VALUES ('".$params['shop']."', '".$access_token."', NOW())";

if (mysqli_query($conn, $sql)) {
	echo "Successfully installed the app";
	header('Location: https://'.$params['shop'].'/admin/apps');
	
	die();
} else {
	echo "Error inserting new record: " . mysqli_error($conn);
}

} else {
	// Someone is trying to be shady!
	die('This request is NOT from Shopify!');
}

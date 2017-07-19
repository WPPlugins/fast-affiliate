<?php
/**
 * Standard API Call
 * to get the list of the program of effiliation
 *
 * @since    1.0.0
 */
function fast_affiliate_API($url, $payload, $request_type){

	$token = get_option('fast_affiliate_token');
	$domain = $_SERVER['SERVER_NAME'];
	$url=$url.$domain."/";

	if ($request_type=='GET') {
		$arg = [
			'method' => $request_type,
			'timeout' => 30,
			'headers' => array ( 'Content-Type' => 'application/json', 'Authorization' => 'Token '.$token),
			'httpversion' => '1.0',
			'sslverify' => false
		];
		$response = wp_remote_get($url, $arg);
	}
	else {
		$arg = [
			'method' => $request_type,
			'body' => json_encode($payload),
			'timeout' => 30,
			'headers' => array ( 'Content-Type' => 'application/json', 'Authorization' => 'Token '.$token),
			'httpversion' => '1.0',
			'sslverify' => false
		];
		$response = wp_remote_post($url, $arg);
	}
	
	$data = wp_remote_retrieve_body($response);

	return json_decode($data,true);
}
 /**
 * To send request to the server
 * to get the list of the program of affilinet
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_cj(){
	$fast_affiliate_cj_site_id = get_option('fast_affiliate_cj_site_id');
	$fast_affiliate_cj_developer_key = get_option('fast_affiliate_cj_developer_key');

	$data=[
	'site_id' => $fast_affiliate_cj_site_id,
	'developer_key' => $fast_affiliate_cj_developer_key
	];

	$url="https://affiliate.trencube.com/get_cj_programs/";
	
	return fast_affiliate_API($url, $data, 'POST');
}
 /**
 * To send request to the server
 * to get the list of the program of affilinet
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_affilinet(){
	$affilinet_publisher_password = get_option('fast_affiliate_affilinet_publisher_password');
	$affilinet_products_password = get_option('fast_affiliate_affilinet_products_password');
	$affilinet_publisher_id = get_option('fast_affiliate_affilinet_publisher_id');

	$data=[
	'publisher_password' => $affilinet_publisher_password,
	'products_password' => $affilinet_products_password,
	'publisher_id' => $affilinet_publisher_id
	];

	$url="https://affiliate.trencube.com/get_affilinet_programs/";
	
	return fast_affiliate_API($url, $data, 'POST');
}
/**
 * To send request to the server
 * to get the list of the program of effiliation
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_tradedoubler(){
	$tradedoubler_products_token=get_option('fast_affiliate_tradedoubler_products_token');
	$data=['tradedoubler_products_token' => $tradedoubler_products_token];
	
	$url="https://affiliate.trencube.com/get_tradedoubler_programs/";

	return fast_affiliate_API($url, $data, 'POST');
}
 /**
 * To send request to the server
 * to get the list of the program of effiliation
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_effiliation(){
	$api_key_effiliation=get_option('fast_affiliate_effiliation_api_key');
	$data=['platform_api_key'=>$api_key_effiliation];
	$authorization = 'Authorization: Token '.$token;

	$url="https://affiliate.trencube.com/get_effiliation_programs/";

	return fast_affiliate_API($url, $data, 'POST');
}


 /**
 * To send request to the server
 * to get the list of the program of amazon
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_amazon(){
	$fast_affiliate_amazon_locale= get_option('fast_affiliate_amazon_locale');
    $fast_affiliate_amazon_tracking_id= get_option('fast_affiliate_amazon_tracking_id');
    $fast_affiliate_amazon_api_key= get_option('fast_affiliate_amazon_api_key');
    $fast_affiliate_amazon_secret_key= get_option('fast_affiliate_amazon_secret_key');

	$data=[
		'access_key_id'=>$fast_affiliate_amazon_api_key,
		'secret_access_key'=>$fast_affiliate_amazon_secret_key,
		'tracking_id'=>$fast_affiliate_amazon_tracking_id,
		'country'=>$fast_affiliate_amazon_locale
		];

	$url="https://affiliate.trencube.com/get_amazon_programs/";

	return fast_affiliate_API($url, $data, 'POST');
}


 /**
 * To send request to the server
 * to get the list of the program of amazon
 *
 * @since    1.0.0
 */
function fast_affiliate_get_programs_ebay(){
	$fast_affiliate_ebay_appId = get_option('fast_affiliate_ebay_appId');
    $fast_affiliate_ebay_siteId = get_option('fast_affiliate_ebay_siteId');
    $fast_affiliate_ebay_campaingId = get_option('fast_affiliate_ebay_campaingId');
    $fast_affiliate_ebay_customId = get_option('fast_affiliate_ebay_customId');

	$data=[
		'appId'=>$fast_affiliate_ebay_appId,
		'siteId'=>$fast_affiliate_ebay_siteId,
		'campaingId'=>$fast_affiliate_ebay_campaingId,
		'customId'=>$fast_affiliate_ebay_customId
		];

	$url="https://affiliate.trencube.com/get_ebay_programs/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_amazon_products_from_keyword($keyword){
	$platforms = [];

	$fast_affiliate_amazon_locale= get_option('fast_affiliate_amazon_locale');
	$fast_affiliate_amazon_tracking_id= get_option('fast_affiliate_amazon_tracking_id');
	$fast_affiliate_amazon_api_key= get_option('fast_affiliate_amazon_api_key');
	$fast_affiliate_amazon_secret_key= get_option('fast_affiliate_amazon_secret_key');

	$platforms['amazon'] = [
		'access_key_id'=>$fast_affiliate_amazon_api_key,
		'secret_access_key'=>$fast_affiliate_amazon_secret_key,
		'tracking_id'=>$fast_affiliate_amazon_tracking_id,
		'country'=>$fast_affiliate_amazon_locale
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_amazon_products/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_ebay_products_from_keyword($keyword){
	$platforms = [];

	$fast_affiliate_ebay_appId= get_option('fast_affiliate_ebay_appId');
	$fast_affiliate_ebay_siteId= get_option('fast_affiliate_ebay_siteId');
	$fast_affiliate_ebay_campaingId= get_option('fast_affiliate_ebay_campaingId');
	$fast_affiliate_ebay_customId= get_option('fast_affiliate_ebay_customId');

	$platforms['ebay'] = [
		'appId'=>$fast_affiliate_ebay_appId,
		'siteId'=>$fast_affiliate_ebay_siteId,
		'campaingId'=>$fast_affiliate_ebay_campaingId,
		'customId'=>$fast_affiliate_ebay_customId
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_ebay_products/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_affilinet_products_from_keyword($keyword){
	$platforms = [];

	$affilinet_publisher_password = get_option('fast_affiliate_affilinet_publisher_password');
	$affilinet_products_password = get_option('fast_affiliate_affilinet_products_password');
	$affilinet_publisher_id = get_option('fast_affiliate_affilinet_publisher_id');

	$platforms['affilinet'] = [
		'publisher_password' => $affilinet_publisher_password,
		'products_password' => $affilinet_products_password,
		'publisher_id' => $affilinet_publisher_id
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_affilinet_products/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_effiliation_products_from_keyword($keyword){
	$platforms = [];

	$api_key_effiliation=get_option('fast_affiliate_effiliation_api_key');
	$platforms['effiliation'] =  [
		'api_key'=>$api_key_effiliation
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_effiliation_products/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_tradedoubler_products_from_keyword($keyword){
	$platforms = [];

	$fast_affiliate_tradedoubler_products_token= get_option('fast_affiliate_tradedoubler_products_token');
	$platforms['tradedoubler'] = [
		'products_token'=>$fast_affiliate_tradedoubler_products_token
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_tradedoubler_products/";

	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_get_CJ_products_from_keyword($keyword){
	$platforms = [];

	$fast_affiliate_cj_site_id = get_option('fast_affiliate_cj_site_id');
	$fast_affiliate_cj_developer_key = get_option('fast_affiliate_cj_developer_key');

	$platforms['CJ'] = [
		'site_id' => $fast_affiliate_cj_site_id,
		'developer_key' => $fast_affiliate_cj_developer_key
		];

	$data=['keyword' => $keyword,'platforms'=> $platforms];
	$url="https://affiliate.trencube.com/get_cj_products/";

	return fast_affiliate_API($url, $data, 'POST');
}
	
/**
 * To send request to the server
 * to get the list of the products
 *
 * @since    1.0.0
 */
function fast_affiliate_signal_unselected($data){
	$url = "https://affiliate.trencube.com/delete_links/";

	return fast_affiliate_API($url, $data, 'POST');
}	

/**
 * To send request to the server
 * to get the list of the products
 *
 * @since    1.0.0
 */
function fast_affiliate_get_affiliate_link($data){
	$url = "https://affiliate.trencube.com/get_affiliate_links/";
	
	return fast_affiliate_API($url, $data, 'POST');
}

/**
 * To send request to the server
 * to get the list of the affiliate links
 *
 * @since    1.0.0
 */
function fast_affiliate_get_recorded_links(){
	$url = "https://affiliate.trencube.com/get_my_links/";
	$data = "";

	return fast_affiliate_API($url, $data, 'GET');
}

/**
 * To send request to the server
 * to get the token
 *
 * @since    1.0.0
 */
function fast_affiliate_get_token($domain) {
	$token = get_option('fast_affiliate_token',"");
	if ($token ==""){
		$arg = [
		'method' => 'GET',
		'timeout' => 30,
		'headers' => array ( 'Content-Type' => 'application/json', 'Authorization' => 'Token b7da737e91655e32c4b37414cf7488ad5480979c'),
		'httpversion' => '1.0',
		'sslverify' => false];
		$url = "https://affiliate.trencube.com/create_new_client/".$domain."/";

		$response = wp_remote_post($url,$arg);
		$data = wp_remote_retrieve_body($response);

		if ( is_wp_error( $response ) ) {
			return false;
		} else {
			$json_data=json_decode($data,true);
			update_option('fast_affiliate_token', $json_data[0]['token']);
			return true;
		}
	}
}


function fast_affiliate_get_quick_link($data) {
	$url = "https://affiliate.trencube.com/get_quick_link/";
	
	return fast_affiliate_API($url, $data, 'POST');
}

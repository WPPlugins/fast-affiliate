<?php
function fast_affiliate_send_platforms_programs(){
	//Effiliation
	$fast_affiliate_programs=get_option('fast_affiliate_programs');
	$api_key_effiliation=get_option('fast_affiliate_effiliation_api_key');
	
	//Amazon
	$api_key_amazon=get_option('fast_affiliate_amazon_api_key');
	$secret_key_amazon=get_option('fast_affiliate_amazon_secret_key');
	$tracking_id_amazon=get_option('fast_affiliate_amazon_tracking_id');
	$locale_amazon=get_option('fast_affiliate_amazon_locale');

	//TradeDoubler
	$products_token_tradedoubler=get_option('fast_affiliate_tradedoubler_products_token');

	//Affilinet
	$affilinet_publisher_password = get_option('fast_affiliate_affilinet_publisher_password');
	$affilinet_products_password = get_option('fast_affiliate_affilinet_products_password');
	$affilinet_publisher_id = get_option('fast_affiliate_affilinet_publisher_id');

	$payload=[];

	$n_programs=count($fast_affiliate_programs);

	for($i=0;$i<$n_programs;$i++){
		if ($fast_affiliate_programs[$i]['platform_id']=="effiliation"){
			array_push($payload, ['platform_id'=>'effiliation', 'program_id'=>$fast_affiliate_programs['program_id'], 'platform_data'=>['api_key'=>$api_key_effiliation]]);
		} elseif ($fast_affiliate_programs[$i]['platform_id']=="amazon"){
			array_push($payload,['platform_id'=>'amazon', 'program_id'=>$fast_affiliate_programs['program_id'], 'platform_data'=>['access_key_id'=>$api_key_amazon, 'country'=>$locale_amazon,'secret_access_key'=>$secret_key_amazon,'tracking_id'=>$tracking_id_amazon]]);
		} elseif ($fast_affiliate_programs[$i]['platform_id']=="tradedoubler"){
			array_push($payload,['platform_id'=>'tradedoubler', 'program_id'=>$fast_affiliate_programs['program_id'], 'platform_data'=>['products_token'=>$products_token_tradedoubler]]);
		} elseif ($fast_affiliate_programs[$i]['platform_id']=="affilinet"){
			array_push($payload,['platform_id'=>'affilinet', 'program_id'=>$fast_affiliate_programs['program_id'], 'platform_data'=>['publisher_password' => $affilinet_publisher_password,'products_password' => $affilinet_products_password,'publisher_id' => $affilinet_publisher_id]]);
		}
	}

	$url="https://affiliate.trencube.com/update_products/";
	$data=$payload;
	return fast_affiliate_API($url, $data, 'POST');
}

function fast_affiliate_construct_f_a_programs(){
	
	$saved_programs=get_option('fast_affiliate_programs');
	$n_saved_programs=count($saved_programs);

	$programs_effiliation = fast_affiliate_get_programs_effiliation();
	$programs_amazon = fast_affiliate_get_programs_amazon();
	$programs_tradedoubler = fast_affiliate_get_programs_tradedoubler();
	$programs_affilinet = fast_affiliate_get_programs_affilinet();
	
	$n_programs_effiliation = count($programs_effiliation);
	$n_programs_amazon=count($programs_amazon);
	$n_programs_tradedoubler=count($programs_tradedoubler);
	$n_programs_affilinet=count($programs_affilinet);


	$final_programs = [];	
	
	if (is_array($programs_effiliation)){
		for ($program=0; $program<$n_programs_effiliation; $program++){
			$final_programs[]=$programs_effiliation[$program];
		}
	} else {
		if($saved_programs){
			for($i=0; $i<$n_saved_programs; $i++){
				if ($saved_programs[$i]['platform_id']=='effiliation'){
					$final_programs[]=$saved_programs[$i];
				}
			}
		}
	}

	if (is_array($programs_amazon)){
		for ($program=0; $program<$n_programs_amazon; $program++){
			$final_programs[]=$programs_amazon[$program];
		}
	} else {
		if($saved_programs){
			for($i=0; $i<$n_saved_programs; $i++){
				if ($saved_programs[$i]['platform_id']=='amazon'){
					$final_programs[]=$saved_programs[$i];
				}
			}
		}
	}

	if (is_array($programs_tradedoubler)){
		for ($program=0; $program<$n_programs_tradedoubler; $program++){
			$final_programs[]=$programs_tradedoubler[$program];
		}
	} else {
		if($saved_programs){
			for($i=0; $i<$n_saved_programs; $i++){
				if ($saved_programs[$i]['platform_id']=='tradedoubler'){
					$final_programs[]=$saved_programs[$i];
				}
			}
		}
	}

	if (is_array($programs_affilinet)){
		for ($program=0; $program<$n_programs_affilinet; $program++){
			$final_programs[]=$programs_affilinet[$program];
		}
	} else {
		if($saved_programs){
			for($i=0; $i<$n_saved_programs; $i++){
				if ($saved_programs[$i]['platform_id']=='affilinet'){
					$final_programs[]=$saved_programs[$i];
				}
			}
		}
	}

	if (count($final_programs)>0) {
		update_option('fast_affiliate_programs',$final_programs);
	}

}

function fast_affiliate_prepare_program_url($url){
	if (substr($url,0,17)=="/includes/images/"){
		$url=dirname(plugin_dir_url( __FILE__ )).$url;
	} else if (!((substr($url,0,8)=="https://") or (substr($url,0,7)=="http://"))) {
		return "";
	} 
	return $url;
}
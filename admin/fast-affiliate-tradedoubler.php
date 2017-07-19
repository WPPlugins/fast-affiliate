<?php

function fast_affiliate_update_tradedoubler_config(){
	$tradedoubler_products_token = filter_var($_POST['tradedoubler_products_token'],FILTER_SANITIZE_STRING);
	update_option('fast_affiliate_tradedoubler_products_token',$tradedoubler_products_token);

	$programs_recorded=get_option('fast_affiliate_programs');
	
	$programs_tradedoubler = fast_affiliate_get_programs_tradedoubler();
	
	$final_programs = [];
	if ($programs_recorded) {
		$n_programs_recorded=count($programs_recorded);
		for($i=0;$i<$n_programs_recorded;$i++){
			if ($programs_recorded[$i]['platform_id']!='tradedoubler'){
				$final_programs[]=$programs_recorded[$i];
			}
		}
	}

	$nb_programs_tradedoubler = count($programs_tradedoubler);
	if (is_array($programs_tradedoubler) && count($programs_tradedoubler)>0){
		for ($program=0;$program<$nb_programs_tradedoubler;$program++){
			$final_programs[]=$programs_tradedoubler[$program];
		}
		if (count($final_programs)>0) {
			update_option('fast_affiliate_programs',$final_programs);
		}
	} else {
		echo "Error: " . $programs_tradedoubler;
	}


    wp_die();
}

/**
 * Render Config Tab.
 *
 * @since    1.0.0
 */
function fast_affiliate_tradedoubler(){
	echo "<form method='post' action=''>";
	echo "<h3>".(__('tradeDoubler parameters','fast-affiliate'))."</h3>";

	echo (__('TradeDoubler Products Token','fast-affiliate'));
	$tradedoubler_products_token=get_option('fast_affiliate_tradedoubler_products_token');
	if (!isset($tradedoubler_products_token)){
		$tradedoubler_products_token="false";
	}
	echo "<input type='text' size='50' name='fast_affiliate_tradedoubler_products_token' id='fast_affiliate_tradedoubler_products_token' value='".$tradedoubler_products_token."'/>";
	echo " ";
	echo "<a href='http://fast-affiliate.trencube.com/configuration-de-la-plate-forme-trade-doubler/' target='_blank'>".__('How to find this key ?','fast-affiliate')."</a>";
    echo "<br>";

	echo "<input name='Submit' id='button_tradedoubler' type='submit' value='".(__("Save Changes", "fast-affiliate"))."' class='button button-primary' />";
    echo "</form>";

    echo "<br>";
    echo "<h3>".(__("Programs found for this affiliate platform","fast-affiliate"))."</h3>";
    echo "<div id='tradedoubler_api_status'></div>";
    echo "<div id='tradedoubler_loading' style='display:none;'><img src='";
    echo dirname(plugin_dir_url( __FILE__ ));
    echo "/includes/images/waiting_response.gif' height='50' width='50'></div>";
    $fast_affiliate_list=get_option('fast_affiliate_programs',false);

    echo "<br>";
    echo "<table class='programs_table tradedoubler'>";
    echo "<thead><th> ".(__("Program name", "fast-affiliate"))." </th><th> ".(__("Logo","fast-affiliate"))." </th></thead><tbody>";
    if(!$fast_affiliate_list){

    } else {
	    foreach($fast_affiliate_list as $key => $value){
	    	if ($value['platform_id']=="tradedoubler"){
	    		$program_logo_url=fast_affiliate_prepare_program_url($value['program_logo_url']);
	    		echo "<tr><td> ".$value['program_name']." </td><td><img src='".$program_logo_url."' style='width:80px;height:30px;'></td></tr>";
	    	}
	    }
	}
    echo "</tbody></table>";
}
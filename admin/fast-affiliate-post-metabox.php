<?php

function fast_affiliate_update_selected(){
	// array constructed in javascript (no user input)
	$unselected = $_POST['unselected'];
	$selected = $_POST['selected'];
	// value constructed by javascript (no user input)
	$postid = intval($_POST['postid']);

	$saved_products=get_post_meta($postid,'fast_affiliate_products_choice', true);

	$n_saved_products=count($saved_products);

	fast_affiliate_signal_unselected($unselected);

	$to_save_products = $saved_products;
	for($i=0; $i<$n_saved_products; $i++) {
		if (in_array($saved_products[$i]['link_id'], $unselected)){
			unset($to_save_products[$i]);
		}
	}
	$to_save_products=array_values($to_save_products);

	delete_post_meta($postid,'fast_affiliate_products_choice');
	add_post_meta($postid,'fast_affiliate_products_choice', $to_save_products, true);

	fast_affiliate_display_selected_array($to_save_products);

	wp_die();
}
function fast_affiliate_display_selected_array($products_list){
	$post_number=get_the_ID();

	echo "<div class='post_products'>";
	echo "<table class='selected_product_table'>";
	echo "<tbody>";
	foreach($products_list as $product){
		$programs=get_option('fast_affiliate_programs');
		$program_logo_url="nologo";
		foreach($programs as $program) {
	    	if ($product['program_id']==$program['program_id']){
	    		$program_name=$program['program_name'];
		    	$program_logo_url=$program['program_logo_url'];
		    	$program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
	    	}
	    }
	    if (array_key_exists('link_type', $product ) == false) {
	    	$product['link_type'] = "Product Link";
	    }

	    if ($product['link_type']=="Product Link"){
	    	// Lien fournit par le serveur
		    echo "<tr class='shortcode_line'>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td>".(__("Shortcode of the announce", "fast-affiliate"))." <span class='fa-toCopy'>[fa_announce link_id=".$product['link_id']."]</span> <button class='fa-btnCopy' type='button' data-shortcode='[fa_announce link_id=" .$product['link_id']. "]'>".(__("Copy in clipboard", "fast-affiliate"))."</button></td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "</tr>";

		    echo "<tr class='product_line'>";
		    echo "<td> <input type='checkbox' checked name='selected_product' link_id='".$product['link_id']."' data-post_id='".$post_number."'</td>";
		    echo "<td><img src='".$product['product_url_image']."' style='text-align:center;max-height:90px;max-width:90px;'></td>";
		    echo "<td><b>".$product['product_name']."</b></td>";
			echo "<td> ".$product['product_price']." ".$product['product_currency']." </td>";
			if ($program_logo_url == "") {
	                echo "<th><span id='program_name'>" . $program_name . "</span></th>";
	        }
	        else {
	        	echo "<th><img src='".$program_logo_url."'' width='80' height='30'></th>";
	        }
			if ($product['product_availability'] == 1) {
				echo "<td>".(__("Available", "fast_affiliate"))."</td>";
			}
			else {
				echo "<td>".(__("Out of stock", "fast_affiliate"))."</td>";
			}
			echo "</tr>";
		} else {
			// Lien rapide généré à la volée
			echo "<tr class='shortcode_line'>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td>".(__("Shortcode of the announce", "fast-affiliate"))." <span class='fa-toCopy'>[fa_announce link_id=".$product['link_id']."]</span> <button class='fa-btnCopy' type='button' data-shortcode='[fa_announce link_id=" .$product['link_id']. "]'>".(__("Copy in clipboard", "fast-affiliate"))."</button></td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "<td></td>";
		    echo "</tr>";

		    echo "<tr class='product_line'>";
		    echo "<td> <input type='checkbox' checked name='selected_product' link_id='".$product['link_id']."' data-post_id='".$post_number."'</td>";
		    echo "<td><img src='".$product['product_url_image']."' style='text-align:center;max-height:90px;max-width:90px;'></td>";
		    echo "<td><b>".$product['product_name']."</b></td>";
			echo "<td> ".$product['product_price']." ".$product['product_currency']." </td>";
			if ($program_logo_url == "") {
	                echo "<th><span id='program_name'>" . $program_name . "</span></th>";
	        }
	        else {
	        	echo "<th><img src='".$program_logo_url."'' width='80' height='30'></th>";
	        }
			if ($product['product_availability'] == 1) {
				echo "<td>".(__("Available", "fast_affiliate"))."</td>";
			}
			else {
				echo "<td>".(__("Out of stock", "fast_affiliate"))."</td>";
			}
			echo "</tr>";
		}
	}
	echo "</tbody>";
	echo "</table>";
	echo "</div>";
}


function fast_affiliate_add_products(){
	// array constructed in javascript (no user input)
	$checked = $_POST['checked'];
	// value constructed by javascript (no user input)
	$postid = intval($_POST['postid']);

	// EFFILIATION
	$api_key_effiliation=get_option('fast_affiliate_effiliation_api_key');

	// AMAZON
	$api_key_amazon=get_option('fast_affiliate_amazon_api_key');
	$secret_key_amazon=get_option('fast_affiliate_amazon_secret_key');
	$tracking_id_amazon=get_option('fast_affiliate_amazon_tracking_id');
	$locale_amazon=get_option('fast_affiliate_amazon_locale');

	// eBay
	$ebay_appId=get_option('fast_affiliate_ebay_appId');
	$ebay_campaingId=get_option('fast_affiliate_ebay_campaingId');
	$ebay_customId=get_option('fast_affiliate_ebay_customId');
	$ebay_siteId=get_option('fast_affiliate_ebay_siteId');

	// TRADEDOUBLER
	$fast_affiliate_tradedoubler_products_token=get_option('fast_affiliate_tradedoubler_products_token');

	// AFFILINET
	$affilinet_publisher_password = get_option('fast_affiliate_affilinet_publisher_password');
	$affilinet_products_password = get_option('fast_affiliate_affilinet_products_password');
	$affilinet_publisher_id = get_option('fast_affiliate_affilinet_publisher_id');

	// CJ
	$fast_affiliate_cj_site_id = get_option('fast_affiliate_cj_site_id');
	$fast_affiliate_cj_developer_key = get_option('fast_affiliate_cj_developer_key');

	$selected_products=[];
	$n_selected_products= count($checked);

	for($i=0; $i<$n_selected_products ;$i++){
		$selected_products[$i]['platform_id'] = $checked[$i][0];
		$selected_products[$i]['program_id'] = $checked[$i][1];
		$selected_products[$i]['product_id'] = $checked[$i][2];
		if ($checked[$i][0]=="effiliation"){	
			$selected_products[$i]['api_key'] = $api_key_effiliation;
		} 
		elseif ($checked[$i][0]=="amazon"){
			$selected_products[$i]['access_key_id'] = $api_key_amazon;
			$selected_products[$i]['country'] = $locale_amazon;
			$selected_products[$i]['secret_access_key'] = $secret_key_amazon;
			$selected_products[$i]['tracking_id'] = $tracking_id_amazon;
		}
		elseif ($checked[$i][0]=="ebay"){
			$selected_products[$i]['appId'] = $ebay_appId;
			$selected_products[$i]['campaingId'] = $ebay_campaingId;
			$selected_products[$i]['customId'] = $ebay_customId;
			$selected_products[$i]['siteId'] = $ebay_siteId;
		}
		elseif ($checked[$i][0]=="tradedoubler"){
			$selected_products[$i]['fast_affiliate_tradedoubler_products_token'] = $fast_affiliate_tradedoubler_products_token;
		}
		elseif ($checked[$i][0]=="affilinet"){
			$selected_products[$i]['publisher_password'] = $affilinet_publisher_password;
			$selected_products[$i]['products_password'] = $affilinet_products_password;
			$selected_products[$i]['publisher_id'] = $affilinet_publisher_id;
		}
		elseif ($checked[$i][0]=="CJ"){
			$selected_products[$i]['site_id'] = $fast_affiliate_cj_site_id;
			$selected_products[$i]['developer_key'] = $fast_affiliate_cj_developer_key;
		}
	}

	$new_products=fast_affiliate_get_affiliate_link($selected_products);
	
	$saved_products=get_post_meta($postid,'fast_affiliate_products_choice',true);
	if (empty($saved_products)){
		$saved_products=[];
	}
	$n_saved_products = count($saved_products);

	for ($i=0; $i<$n_selected_products; $i++){
		for ($j=0; $j<$n_saved_products; $j++){
			if ($saved_products[$j]['platform_id']==$new_products[$i]['platform_id'] && $saved_products[$j]['program_id']==$new_products[$i]['program_id'] && $saved_products[$j]['product_id']==$new_products[$i]['product_id']){
				unset($new_products[$i]);
			}
		}
	}
	
	$final_products=array_merge($saved_products,$new_products);

	update_post_meta($postid,'fast_affiliate_products_choice', $final_products);
	update_meta_cache('post', $postid);

	fast_affiliate_display_selected_array($final_products);

	if ($post_id=="") {
		wp_die();
	}

}


function fast_affiliate_get_platforms() {
	$fast_affiliate_programs=get_option('fast_affiliate_programs');
	$platforms = [];
	for ($i=0; $i<count($fast_affiliate_programs); $i++) {
		if (!in_array($fast_affiliate_programs[$i]['platform_id'], $platforms))
		{
		    $platforms[] = $fast_affiliate_programs[$i]['platform_id']; 
		}
	}
	wp_send_json($platforms);
}

function fast_affiliate_get_amazon_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_amazon_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'amazon');

	wp_die();
}

function fast_affiliate_get_ebay_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_ebay_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'ebay');

	wp_die();
}

function fast_affiliate_get_effiliation_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_effiliation_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'effiliation');

	wp_die();
}

function fast_affiliate_get_tradedoubler_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_tradedoubler_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'tradedoubler');

	wp_die();
}

function fast_affiliate_get_CJ_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_CJ_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'CJ');

	wp_die();
}

function fast_affiliate_get_affilinet_products(){
	$keyword = filter_var($_POST['keyword'],FILTER_SANITIZE_STRING);
	$post_number= $_POST['postid'];

	$product_list = fast_affiliate_get_affilinet_products_from_keyword($keyword);

	fast_affiliate_render_products($product_list, $post_number, 'affilinet');

	wp_die();
}

function fast_affiliate_render_products($product_list, $post_number, $platform_id) {
	$programs_products=$product_list['products'];
	// value constructed by javascript (no user input)

	echo "<div id='fast_affiliate_platform_products_" . $platform_id . "'>";	
	$fast_affiliate_programs=get_option('fast_affiliate_programs');
	foreach($programs_products as $program_id=>$products){
		if (count($products)>0){
			$program_name="";
		    $program_logo_url="nologo";
		    foreach($fast_affiliate_programs as $program) {
		    	if ($program_id==$program['program_id']){
		    		$program_name=$program['program_name'];
		    		$program_logo_url=$program['program_logo_url'];
		    		$program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
		    	}
		    }
		    $program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
		    echo "<table class='programs_table'>";
	    	echo "<thead>";
	    	if ($program_logo_url == "") {
                echo "<th><span id='program_name'>" . $program_name . "</span></th>";
            }
            else {
            	echo "<th><img src='".$program_logo_url."'' width='80' height='30'></th>";
            }
	    	echo "<th>".$program_name."</th></thead>";
	    	echo "</table>";
	    	echo "<div class='post_products'>";
			echo "<table class='programs_table_".key($programs_products)."' >";
			echo "<thead>";
				echo "<th></th>";
				echo "<th> ".(__("Image","fast-affiliate"))." </th>";
				echo "<th> ".(__("Product name","fast-affiliate"))." </th>";
				echo "<th> ".(__("Price","fast-affiliate"))." </th>";
				echo "<th> ".(__("Stock","fast-affiliate"))." </th>";
			echo "</thead>";
			echo "<tbody>";

			foreach($products as $product){
				echo "<tr class='product_line'>";
				echo "<td> <input type='checkbox' name='choice' platform_id='".$product['platform_id']."' product_id='".$product['product_id']."' program_id='".$program_id."' data-post_id='".$post_number."' >";
				echo "<td><img src='".$product['product_image']."' style='max-height:90px;max-width:50px;'></td>";
				echo "<td> ".$product['product_name']." </td>";
				echo "<td> ".$product['product_price']." ".$product['product_currency']." </td>";
				if ($product['product_availability'] == 1) {
					echo "<td>".(__("Yes", "fast-affiliate"))."</td>";
				}
				else {
					echo "<td>".(__("No", "fast-affiliate"))."</td>";
				}
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
	}
	echo "</div>";
}


function fast_affiliate_init_metabox(){
	add_meta_box('fast_affiliate_meta_box','Fast Affiliate','fast_affiliate_render_meta_box','post','normal');
}


function fast_affiliate_render_meta_box(){
	$post_id=get_the_ID();
	$fast_affiliate_programs=get_option('fast_affiliate_programs');
    
    $links_post_meta = get_post_meta($post_id,'fast_affiliate_products_choice', true);
    if ($links_post_meta == "") {
    	$n_saved_products = 0;
    }
    else {
    	$n_saved_products = count($links_post_meta);
    }

    ?>
    <form name='fast_affiliate_metabox'>
	    <?php echo "<div id='fast_affiliate_tab' data-post_id='".$post_id."'>";?>
	    	<ul class="nav-tab-wrapper">
	    		<li></li>
	    		<li id="tab_selected"><a class="nav-tab"><?php _e("Selected products","fast-affiliate")?><span id="selected_products_number">(<?php echo $n_saved_products?>)</span></a></li>
	        	<li id="tab_search"><a class="nav-tab nav-tab-active"><?php _e("Search for products","fast-affiliate")?></a></li>
	        	<li id="tab_quick_link"><a class="nav-tab nav-tab-active"><?php _e("Quick link","fast-affiliate")?></a></li>
	        </ul>

	        <div class="hidden" id="fast_affiliate_selected">
	        	<?php echo "<button id='fast_affiliate_update_saved' type='button' class='fast_affiliate_metabox_record_choices' postid='".get_the_ID()."' >".(__("Update","fast-affiliate"))."</button>";?>
	        	<div id='saved_products'>
	        	<?php fast_affiliate_selected_products(get_the_ID());?>
	        	</div>
	    	</div>

	    	<div  id="fast_affiliate_search">
	    		<?php
	    		echo "<form name='fast_affiliate_metabox'>";
				echo "<label for='fast_affiliate_keyword'>".(__("Keyword","fast-affiliate"))." :</label>";
				echo "<input id='fast_affiliate_keyword' type='text' name='fast_affiliate_mot_cle' value=''/>";
				echo "<button id='fast_affiliate_find_button' type='button' class='fast_affiliate_metabox_keyword_submit' postid='".get_the_ID()."' >".(__("Find","fast-affiliate"))."</button>";
				echo "<button id='fast_affiliate_include_in_post_button' type='button' class='fast_affiliate_metabox_record_choices' postid='".get_the_ID()."' >".(__("Include in post","fast-affiliate"))."</button>";
				echo "</form>";
				echo "<div id='find_loading' style='display:none;'><img src='" . dirname(plugin_dir_url( __FILE__ )) . "/includes/images/waiting_response.gif' height='50' width='50'></div>";
	    		?>
	    		<div id="product_results"></div>
	    	</div>

	    	<div class="hidden" id="fast_affiliate_quick_link">
	    		<?php
	    		echo "<form name='fast_affiliate_metabox_quick_link'>";
	    		echo "<p>".(__("Quick links are not stock management", "fast-affiliate"))."</p>";
				echo "<label for='fast_affiliate_quick_link_text'>".(__("Quick link url", "fast-affiliate"))." :</label>";
				echo "<input id='fast_affiliate_quick_link_text' type='text' name='fast_affiliate_quick_link_text' value=''/>";
				echo "</br>";
				echo "<label for='fast_affiliate_quick_link_name'>".(__("Quick link name", "fast-affiliate"))." :</label>";
				echo "<input id='fast_affiliate_quick_link_name' type='text' name='fast_affiliate_quick_link_name' value=''/>";
				echo "</br>";
				echo "<label for='fast_affiliate_quick_link_program'>".(__("Program", "fast-affiliate"))." :</label>";
				echo "<select id='fast_affiliate_quick_link_program'>";
				echo "<option selected value='0000'></option>";
				for ($i=0; $i<count($fast_affiliate_programs); $i++) {
					if ($fast_affiliate_programs[$i]['platform_id'] != 'tradedoubler') {
						echo "<option value='" . $fast_affiliate_programs[$i]['program_id'] . "'>" . $fast_affiliate_programs[$i]['program_name'] . "</option>";
					}
				}
				echo "</select>";
				echo "<button id='fast_affiliate_add_quick_link' type='button' class='fast_affiliate_metabox_submit' postid='".get_the_ID()."' >".(__("Add to post","fast-affiliate"))."</button>";
				echo "</form>";
				echo "<div id='find_loading' style='display:none;'><img src='" . dirname(plugin_dir_url( __FILE__ )) . "/includes/images/waiting_response.gif' height='50' width='50'></div>";
	    		?>
	    		<div id="product_results"></div>
	    	</div>
		</div>
    </form>    
    <?php
}

function fast_affiliate_selected_products($post_id){
	$post_number = $post_id;
 	
 	$products=get_post_meta($post_number,'fast_affiliate_products_choice', true);
 	
 	fast_affiliate_display_selected_array($products);

	// echo "<div class='post_products'>";
	// echo "<table class='selected_product_table'>";
	// echo "<tbody>";
	// if ($products) {
	// 	foreach($products as $product){
	// 		$program_logo_url = "nologo";
	// 		$programs=get_option('fast_affiliate_programs');
	// 		foreach($programs as $program) {
	// 	    	if ($product['program_id']==$program['program_id']){
	// 	    		$program_name=$program['program_name'];
	// 		    	$program_logo_url=$program['program_logo_url'];
	// 		    	$program_logo_url=fast_affiliate_prepare_program_url($program_logo_url);
	// 	    	}
	// 	    }
		    
	// 	    echo "<tr class='product_line'>";
	// 	    echo "<td> <input type='checkbox' checked name='selected_product' link_id='".$product['link_id']."' data-post_id='".$post_number."'></td>";
	// 	    echo "<td><img src='".$product['product_url_image']."' style='text-align:center;max-height:90px;max-width:90px;'></td>";
	// 	    echo "<td><b>".$product['product_name']."</b></td>";
	// 		echo "<td> ".$product['product_price']." ".$product['product_currency']." </td>";
	// 		if ($program_logo_url == "") {
 //                echo "<th><span id='program_name'>" . $program_name . "</span></th>";
	//         }
	//         else {
	//         	echo "<th><img src='".$program_logo_url."'' width='80' height='30'></th>";
	//         }
	// 		if ($product['product_availability'] == 1) {
	// 			echo "<td>".(__("Available", "fast_affiliate"))."</td>";
	// 		}
	// 		else {
	// 			echo "<td>".(__("Out of stock", "fast_affiliate"))."</td>";
	// 		}
	// 		echo "</tr>";
	// 	}
	// }
	
	// echo "</tbody>";
	// echo "</table>";
	// echo "</div>";

}
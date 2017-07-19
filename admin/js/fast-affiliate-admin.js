jQuery(document).ready(function($) {

	jQuery(".fa-btnCopy").click(function() {
		var aux = document.createElement("input");
		aux.setAttribute("value", this.getAttribute('data-shortcode'));
		document.body.appendChild(aux);
		aux.select();
		document.execCommand("copy");

		document.body.removeChild(aux);

	});


	jQuery('#button_general_config').click(function(event){
		event.preventDefault();

		var show_price = 0;
		if($("#fast_affiliate_show_price").prop('checked') == true) {
			show_price = 1;
		}

		var data = {
			'action': 'fast_affiliate_update_general_config',
			'show_price': show_price,
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			location.reload(true);
		});
	});

	jQuery('#button_effiliation').click(function(event){
		jQuery('#effiliation_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_effiliation_config',
			'effiliation_api_key': jQuery('#fast_affiliate_effiliation_api_key').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#effiliation_api_status').text(response + " Try later");
				jQuery('#effiliation_loading').hide();
			}
			else {
				location.reload(true);
			}
		});
	});

	jQuery('#button_amazon').click(function(event){
		jQuery('#amazon_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_amazon_config',
			'amazon_api_key': jQuery('#fast_affiliate_amazon_api_key').val(),
			'amazon_locale': jQuery('#fast_affiliate_amazon_locale').val(),
			'amazon_tracking_id': jQuery('#fast_affiliate_amazon_tracking_id').val(),
			'amazon_secret_key': jQuery('#fast_affiliate_amazon_secret_key').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#amazon_api_status').text(response + " Try later");
				jQuery('#amazon_loading').hide();
			}
			else {
				location.reload(true);
			}
			
		});
	});


	jQuery('#button_ebay').click(function(event){
		jQuery('#ebay_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_ebay_config',
			'ebay_appId': jQuery('#fast_affiliate_ebay_appId').val(),
			'ebay_siteId': jQuery('#fast_affiliate_ebay_siteId').val(),
			'ebay_campaingId': jQuery('#fast_affiliate_ebay_campaingId').val(),
			'ebay_customId': jQuery('#fast_affiliate_ebay_customId').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#ebay_api_status').text(response + " Try later");
				jQuery('#ebay_loading').hide();
			}
			else {
				location.reload(true);
			}
			
		});
	});

	jQuery('#button_tradedoubler').click(function(event){
		jQuery('#tradedoubler_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_tradedoubler_config',
			'tradedoubler_products_token': jQuery('#fast_affiliate_tradedoubler_products_token').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#tradedoubler_api_status').text(response + " Try later");
				jQuery('#tradedoubler_loading').hide();
			}
			else {
				location.reload(true);
			}
		});
	});

	jQuery('#button_affilinet').click(function(event){
		jQuery('#affilinet_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_affilinet_config',
			'affilinet_publisher_password': jQuery('#fast_affiliate_affilinet_publisher_password').val(),
			'affilinet_products_password': jQuery('#fast_affiliate_affilinet_products_password').val(),
			'affilinet_publisher_id': jQuery('#fast_affiliate_affilinet_publisher_id').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#affilinet_api_status').text(response + " Try later");
				jQuery('#affilinet_loading').hide();
			}
			else {
				location.reload(true);
			}
		});
	});

	jQuery('#button_cj').click(function(event){
		jQuery('#cj_loading').show();
		event.preventDefault();

		var data = {
			'action': 'fast_affiliate_update_cj_config',
			'fast_affiliate_cj_site_id': jQuery('#fast_affiliate_cj_site_id').val(),
			'fast_affiliate_cj_developer_key': jQuery('#fast_affiliate_cj_developer_key').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			if (response.indexOf('Error:')!=-1) {
				jQuery('#cj_api_status').text(response + " Try later");
				jQuery('#cj_loading').hide();
			}
			else {
				location.reload(true);
			}
		});
	});


	jQuery('#tab_selected').click(function(){
		jQuery("#fast_affiliate_search").hide();
		$("#fast_affiliate_quick_link").hide();
		$('#tab_selected a').attr('class','nav-tab nav-tab-active');
		$('#tab_search a').attr('class','nav-tab');
		$('#tab_quick_link a').attr('class','nav-tab');
		$("#fast_affiliate_selected").show();
	});


	jQuery('#tab_search').click(function(){
		$("#fast_affiliate_selected").hide();
		$("#fast_affiliate_quick_link").hide();
		$("#fast_affiliate_search").show();
		$('#tab_search a').attr('class','nav-tab nav-tab-active');
		$('#tab_selected a').attr('class','nav-tab');
		$('#tab_quick_link a').attr('class','nav-tab');
	});

	jQuery('#tab_quick_link').click(function(){
		$("#fast_affiliate_selected").hide();
		$("#fast_affiliate_search").hide();
		$("#fast_affiliate_quick_link").show();
		$('#tab_quick_link a').attr('class','nav-tab nav-tab-active');
		$('#tab_selected a').attr('class','nav-tab');
		$('#tab_search a').attr('class','nav-tab');
	});


	jQuery('#fast_affiliate_find_button').click(function(){
		jQuery('#product_results').empty();

		var postid = $('#fast_affiliate_find_button').attr('postid');
		var keyword = jQuery('#fast_affiliate_keyword').val();


		jQuery('#find_loading').show();
		var platforms = [];
		var data = {
			'action': 'fast_affiliate_get_platforms',
			'keyword': jQuery('#fast_affiliate_keyword').val(),
		};

		jQuery.post(ajax_object.ajax_url, data, function(response) {
			platforms = response;

			for (var i=0; i<platforms.length; i++) {
				//Api call for every platform ...
				var action = 'fast_affiliate_get_' + platforms[i] + '_products';

				var p_data = {
					'action': action,
					'keyword': keyword,
					'postid': postid
				};

				jQuery.post(ajax_object.ajax_url, p_data, function(p_response) {
					jQuery('#product_results').append(p_response);
				});
			}

			jQuery('#find_loading').hide();
		});

	});


	jQuery('#fast_affiliate_update_saved').click(function(){
		var id_products_selected = [];

		jQuery('input:checkbox[name="selected_product"]').each(function() {
			if (this.checked) {
				id_products_selected.push(this.getAttribute('link_id'));
			}
		});

		var id_products_unselected = [];

		jQuery('input:checkbox[name="selected_product"]').each(function() {
			if (!this.checked) {
				id_products_unselected.push(this.getAttribute('link_id'));
			}
		});

		var postid = jQuery('#fast_affiliate_update_saved').attr('postid');

		var data = {
			'action': 'fast_affiliate_update_selected',
			'selected': id_products_selected,
			'unselected': id_products_unselected,
			'postid' : postid
		};
		
		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$('#saved_products').empty();
			$('#saved_products').append(response);
			var rowCount = ($('.selected_product_table tr').length)/2;
			$('#selected_products_number').text(" ("+rowCount+")");
		});
	});


	jQuery('#fast_affiliate_include_in_post_button').click(function(){
		var id_products_checked = [];
		jQuery('#find_loading').show();
		jQuery('input:checkbox[name="choice"]').each(function() {
			if (this.checked) {
				id_products_checked.push([this.getAttribute('platform_id'),this.getAttribute('program_id'),this.getAttribute('product_id')]);
			}
		});
		
		var postid = jQuery('#fast_affiliate_include_in_post_button').attr('postid');

		var data = {
			'action': 'fast_affiliate_add_products',
			'checked': id_products_checked,
			'postid' : postid
		};
		
		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$('#saved_products').empty();
			jQuery('#find_loading').hide();
			$('#saved_products').append(response);
			var rowCount = ($('.selected_product_table tr').length)/2;
			$('#selected_products_number').text(" ("+rowCount+")");
		});

	});

	jQuery('#fast_affiliate_add_quick_link').click(function(){
		jQuery('#find_loading').show();
		var source_link = jQuery('#fast_affiliate_quick_link_text').val();
		var link_name = jQuery('#fast_affiliate_quick_link_name').val();
		var postid = jQuery('#fast_affiliate_add_quick_link').attr('postid');
		var program_id = jQuery('#fast_affiliate_quick_link_program').val();


		console.log(source_link);
		console.log(postid);
		console.log(program_id);
		

		var data = {
			'action': 'fast_affiliate_add_quick_link',
			'source_link': source_link,
			'link_name': link_name,
			'postid' : postid,
			'program_id': program_id
		};
		
		jQuery.post(ajax_object.ajax_url, data, function(response) {
			$('#saved_products').empty();
			jQuery('#find_loading').hide();
			$('#saved_products').append(response);
			var rowCount = ($('.selected_product_table tr').length)/2;
			$('#selected_products_number').text(" ("+rowCount+")");
		});

	});

	$(".stock_table").tablesorter(); 

});
<?php

function fast_affiliate_update_clicks(){
	global $wpdb;

    $link_id = strval($_POST['link_id']);
    $source = strval($_POST['source']);

 
    $table_name = $wpdb->prefix . 'f_a_link_performance';

    $clicks = $wpdb->get_var(
    		"SELECT clicks FROM $table_name 
    		WHERE linkid = $link_id AND source = '$source'"
    	);

    if (empty($clicks)){

	    $wpdb->insert(
	    	$table_name,
	    	array(
	    		'linkid' => $link_id,
				'source' => $source,
				'clicks' => 1,
			),
			array('%s', '%s', '%d')
		);
	} else {

		$clicks=intval($clicks)+1;
		$wpdb->update($table_name,
			array(
				'clicks' => $clicks
			),
			array(
				'linkid' => $link_id,
				'source' => $source
			),
			array(
				'%d'
			),
			array(
				'%s',
				'%s'
			)
		);
	}

    wp_die();

}
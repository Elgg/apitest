<?php
	/**
	 * Elgg API Tester
	 * 
	 * @package ElggDevTools
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	admin_gatekeeper();
	
	$method = get_input('method');

	// See if we are being called to execute a method.
	if (!$method) {
		register_error(elgg_echo('apitest:execute:nomethod'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	// fetch apitest plugin settings 
	$apikey = get_plugin_setting('apikey', 'apitest');
	$secret = get_plugin_setting('secretkey', 'apitest');
	$endpoint = get_plugin_setting('endpoint', 'apitest');

	
	// get the list of api commands available
	$commands = send_api_get_call($endpoint, array ('method' => 'system.api.list'), array ('public' => $apikey, 'private' => $secret));
	
	$commands = unserialize($commands);
	
	// grab our method and check its parameters
	$command_details = $commands->result[$method];
	if (!$command_details) {
		register_error(sprintf(elgg_echo('apitest:execute:fail'), $method));
		forward();
	}
	
	$params = array();
			
	// Get the method
	$params['method'] = $method;

	// Needs auth token?
	if ($command_details['require_user_auth']) {
		$params['auth_token'] = get_input('auth_token');
	}

	// Get other expected parameters
	foreach ($command_details['parameters'] as $k => $v) {
		$params[$k] = get_input($k);
	}

	// Execute
	$result = "";
	if ($command_details['call_method'] == 'POST') {
		$result = send_api_post_call($endpoint, $params, array ('public' => $apikey, 'private' => $secret), get_input('post_data')); 
	} else {
		$result = send_api_get_call($endpoint, $params, array ('public' => $apikey, 'private' => $secret));
	}

	$result = unserialize($result);
	
	// cache result in session for results page
	$_SESSION['apitest:result'] = $result;
	$_SESSION['apitest:method'] = $method;
	
	if (($result) && ($result->status == 0)) {
		system_message(elgg_echo('apitest:execute:success'));
	} else {
		register_error(sprintf(elgg_echo('apitest:execute:failwithmessage'), $method, $result->message));
	}
	
	forward("pg/apitest/viewresult/");		
	
?>
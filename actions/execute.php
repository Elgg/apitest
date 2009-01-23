<?php
	/**
	 * Elgg API Tester
	 * 
	 * @package ElggDevTools
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@marcus-povey.co.uk>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */

	global $CONFIG, $APICLIENT_LAST_CALL_RAW;

	action_gatekeeper();
	admin_gatekeeper();
	
	$method = get_input('method');

	// See if we are being called to execute a method.
	if ($method)
	{
		// fetch api list
		$apikey = get_plugin_setting('apikey', 'apitest');
		$secret = get_plugin_setting('secretkey', 'apitest');
		$endpoint = get_plugin_setting('endpoint', 'apitest');

		$commands = send_api_get_call($endpoint, array ('method' => 'system.api.list'), array ('public' => $apikey, 'private' => $secret));
	
		$command_details = $commands->result[$method];

		if ($command_details)
		{
			$params = array();
			
			// Get the method
			$params['method'] = $method;
		
			// Needs auth token?
			if ($command_details['require_auth_token'])
			{
				$params['auth_token'] = get_input('auth_token');
				$_SESSION["apitest:auth_token"] = $params['auth_token']; // Set session for next query
			}
		
			// Get other expected parameters
			foreach ($command_details['parameters'] as $k => $v) {
				$params[$k] = get_input($k);
				$_SESSION["apitest:$k"] = $params[$k]; // Set session for next query
			}
		
			// Execute
			$result = "";
			if ($command_details['call_method'] == 'POST')
				$result = send_api_post_call($endpoint, $params, array ('public' => $apikey, 'private' => $secret), get_input('post_data')); 
			else
				$result = send_api_get_call($endpoint, $params, array ('public' => $apikey, 'private' => $secret));
		
			// Process results
			$_SESSION['apitest:rawresult'] = $APICLIENT_LAST_CALL_RAW;
			
			$_SESSION['apitest:result'] = $result;
			if (($result) && ($result->status == 0))
			{
				system_message(elgg_echo('apitest:execute:success'));
			}
			else
			{
				register_error(sprintf(elgg_echo('apitest:execute:failwithmessage'), $method, $result->message));
			}
			
			forward($CONFIG->url . "pg/apitest/viewresult/");
		}
		else
			register_error(sprintf(elgg_echo('apitest:execute:fail'), $method));
	}
	else
		register_error(elgg_echo('apitest:execute:nomethod'));
	
	forward($_SERVER['HTTP_REFERER']);
?>
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

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();
	set_context('admin');
	
	// Set admin user for user block
	set_page_owner(get_loggedin_userid());
	
	
	$title = elgg_view_title(elgg_echo('apitest'));
	
	
	// fetch api plugin settings
	$apikey = get_plugin_setting('apikey', 'apitest');
	$secret = get_plugin_setting('secretkey', 'apitest');
	$endpoint = get_plugin_setting('endpoint', 'apitest');
	
	if ( !$apikey || !$secret || !$endpoint ) {
		register_error(elgg_echo('apitest:notconfigured'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	// fetch api list
	$commands = send_api_get_call($endpoint, array ('method' => 'system.api.list'), array ('public' => $apikey, 'private' => $secret));
		
	if (!$commands) {
		register_error(sprintf(elgg_echo('apitest:execute:fail'), 'system.api.list'));
		forward($_SERVER['HTTP_REFERER']);
	}
	
	$commands = unserialize($commands);
	
	if ($commands->status != 0) {
		$body .= $commands->message;
	} else {				
		foreach ($commands->result as $command => $details) {
			$body .= elgg_view('apitest/command', array('command' => $command, 'details' => $details));	
		}
	}
		
		
	page_draw(elgg_echo('apitest'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));	

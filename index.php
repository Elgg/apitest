<?php
	/**
	 * Elgg API Tester
	 * 
	 * @package ElggDevTools
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@marcus-povey.co.uk>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	admin_gatekeeper();
	set_context('admin');
	
	// Set admin user for user block
	set_page_owner($_SESSION['guid']);
	
	
	$title = elgg_view_title(elgg_echo('apitest'));
	
	
	// fetch api list
	$apikey = get_plugin_setting('apikey', 'apitest');
	$secret = get_plugin_setting('secretkey', 'apitest');
	$endpoint = get_plugin_setting('endpoint', 'apitest');
	
	if ( ($apikey) && ($secret) && ($endpoint) )
	{
		$commands = send_api_get_call($endpoint, array ('method' => 'system.api.list'), array ('public' => $apikey, 'private' => $secret));
		
		if ($commands)
		{
			foreach ($commands->result as $command => $details)
			{
				// List commands here.
				$body .= elgg_view('apitest/command', array('command' => $command, 'details' => $details));
				
			}
		}
		else
			$body .= elgg_echo('apitest:notconfigured');
	}
	else
		$body .= elgg_echo('apitest:notconfigured');
		
	// Display main admin menu
	page_draw(elgg_echo('apitest'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
	
?>
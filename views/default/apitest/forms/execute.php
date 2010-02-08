<?php

	/**
	 * Elgg API Tester
	 * 
	 * @package ElggDevTools
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd
	 * @copyright Curverider Ltd 2008-2010
	 * @link http://elgg.com/
	 */

	$details = $vars['details'];
	$command = $vars['command'];
	
	$params = array();

	$variables = "";
	
	// If authentication is required then ensure this is prompted for
	if ($details['require_user_auth'] == true) {
		$variables .= "<p><b>auth_token</b> :";
		$variables .= elgg_view('input/text', array('internalname' => 'auth_token', 'value' => ''));			
	}
			
	foreach ($details['parameters'] as $k => $v) {
		$variables .= "<p><b>$k</b> ";
		
		if ($details['parameters'][$k]['required'] == FALSE) {
			$variables .= " (".elgg_echo('apitest:optional'). ") :";
		} else {
			$variables .= ":";
		}
		
		$variables .= elgg_view('input/text', array('internalname' => $k, 'value' => $v));			
	}
		
	// Do we need to provide post data?
	$postdata = "";
	if ($details['call_method'] == 'POST') {
		$postdata = "<span onclick=\"showhide('$command:postdata')\"><a href=\"#\">". elgg_echo('apitest:postdata') . "</a></span>";
	}
	
	$method_control = elgg_view('input/hidden', array('internalname' => 'method', 'value' => $command));
	$postdata_control = elgg_view('input/longtext', array('internalname' => 'post_data'));
	$execute_control = elgg_view('input/submit', array('value' => elgg_echo('apitest:execute')));
	$form_data = <<< END
		<div>
			$method_control
			$variables
			$postdata
			<div id="$command:postdata" style="display:none">$postdata_control</div>
			$execute_control
		</div>
END;
	
	echo elgg_view('input/form', array('action' => "{$vars['url']}action/apitest/execute", 'body' => $form_data));
?>
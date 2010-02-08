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
	
	$title = $vars['command'];
	
	$details = $vars['details'];

	$info .= "<p><b><a href=\"#\" onclick=\"showhide('{$title}');\">{$title}</a></b>"; 
	if ($details['description']) {
		$info .= " - {$details['description']}</p>";
	}
	
	$info .= "<div id=\"{$title}\" style=\"display: none\">".elgg_view('apitest/forms/execute', $vars)."</div>";

	echo elgg_view_listing(NULL, $info);
?>
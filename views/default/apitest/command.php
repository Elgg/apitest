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
	
	global $CONFIG;
	
	$entity = new ElggObject();
	$entity->subtype = 'api_command';
	$entity->title = $vars['command'];
	
	$icon = elgg_view(
			'graphics/icon', array(
			'entity' => $entity,
			'size' => 'small',
		  )
		);
		
	$details = $vars['details'];

	$info .= "<p><b><a href=\"#\" onClick=\"showhide('{$entity->title}');\">{$entity->title}</a></b>"; 
	if ($details['description']) $info .= " - {$details['description']}</p>";
	
	$info .= "<div id=\"{$entity->title}\" style=\"display: none\">".elgg_view('apitest/forms/execute', $vars)."</div>";

	echo elgg_view_listing($icon, $info);
?>
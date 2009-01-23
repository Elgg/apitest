<?php
	/**
	 * Elgg API Tester language pack
	 * 
	 * @package ElggDevTools
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@marcus-povey.co.uk>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */


	$english = array(
	
		/**
		 * Menu items and titles
		 */
	
			'apitest' => 'API Tester',
			'apitest:lastresult' => 'Last API Result', 
	
			'apitest:apikey' => 'API Key',
			'apitest:secretkey' => 'Secret Key',
			'apitest:endpoint' => 'Endpoint',
	
	
			'apitest:notconfigured' => 'The API Tester has not yet been configured, please go to the Admin -> tools settings for this plugin.',
	
			'apitest:optional' => "Optional",
			'apitest:postdata' => "Add POST data to query...",
	
			'apitest:execute' => "Execute",
	
			'apitest:execute:nomethod' => "No method was specified.",
			'apitest:execute:fail' => "There was a problem executing %s",
	
			'apitest:execute:failwithmessage' => "There was a problem executing %s, '%s'",
			'apitest:execute:success' => "Command successfully executed",
	);
					
	add_translation("en",$english);
?>
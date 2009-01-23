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

	function apitest_init($event, $object_type, $object = null) {
		
		global $CONFIG;
		
		// Register a page handler, so we can have nice URLs
		register_page_handler('apitest','apitest_page_handler');
		
		// Metatags
		extend_view('metatags','apitest/metatags');
		
		// Register some actions
		register_action("apitest/execute",false, $CONFIG->pluginspath . "apitest/actions/execute.php", true);
		
		
	}
	
	function apitest_pagesetup()
	{
		if (get_context() == 'admin' && isadminloggedin()) {
			global $CONFIG;
			add_submenu_item(elgg_echo('apitest'), $CONFIG->wwwroot . 'pg/apitest/');
		}
	}
	
	function apitest_page_handler($page) 
	{
		global $CONFIG;
		
		if ($page[0])
		{
			switch ($page[0])
			{
				case 'viewresult' : include($CONFIG->pluginspath . "apitest/result.php"); break;
				default : include($CONFIG->pluginspath . "apitest/index.php"); 
			}
		}
		else
			include($CONFIG->pluginspath . "apitest/index.php"); 
	}
	
	// Make sure test_init is called on initialisation
	register_elgg_event_handler('init','system','apitest_init');
	register_elgg_event_handler('pagesetup','system','apitest_pagesetup');
?>
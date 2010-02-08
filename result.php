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

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	admin_gatekeeper();
	set_context('admin');
	
	// Set admin user for user block
	set_page_owner(get_loggedin_userid());
	
	
	function display_var($var, $n = 0)
	{
		$body = "";
		$depthadd = "";
		for ($a =0; $a < $n; $a ++)
			$depthadd .= "+";

		foreach ($var as $k => $v)
		{
			if (is_object($v))
				$body .= display_var($v, $n+1);
			else if (is_array($v))
			{
				foreach ($v as $p => $q)
					$body .= "<div><p><b>$depthadd $p: </b> ".display_var($q, $n+1)."</p></div>";
			}				
			else {
				$var = print_r($v, true);
				$body .= "<div><p><b>$depthadd $k: $var</b> </p></div>";
			}
		}
		
		return $body;
	}
	
	$title = elgg_view_title(elgg_echo('apitest:lastresult'));
	
	$body = '<div class="contentWrapper">';
	
	$body .= '<h3>' . elgg_echo('apitest:method') . ": {$_SESSION['apitest:method']}</h3><br />";
	
	if ($_SESSION['apitest:result']) {
		$body .= display_var($_SESSION['apitest:result']);		
	}
	
	$body .= '</div>';
		
	page_draw(elgg_echo('apitest:lastresult'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
	

?>
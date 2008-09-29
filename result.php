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
	
	
	function display_var($var, $n = 0)
	{
		$body = "";
		$depthadd = "";
		for ($a =0; $a < $n; $a ++)
			$depthadd .= "+";

		foreach ($var as $k => $v)
		{
			if ((is_array($v)) || (is_object($v)))
				$body .= display_var($v, $n+1);
			else
				$body .= "<div><p>$depthadd <b>$k: </b> $v</p></div>";
		}
		
		return $body;
	}
	
	$title = elgg_view_title(elgg_echo('apitest:lastresult'));
	
	$errormessage = "";
	if (!$_SESSION['apitest:result'])
		$errormessage = "<div><p><b>{$_SESSION['apitest:rawresult']}</b></p></div>";
	else if ($_SESSION['apitest:result']->result!=0)
		$errormessage = "<div><p><b>{$_SESSION['apitest:result']->message}</b></p><hr /></div>";
	
	$body .= $errormessage;

	if ($_SESSION['apitest:result'])
	{
		$body .= display_var($_SESSION['apitest:result']);
		
		/*foreach ((array)$_SESSION['apitest:result'] as $k => $v)
		{
			
			if (!is_array($v))
				$body .= "<div><p><b>$k: </b> $v</p></div>";
			else
			{
				foreach ($v as $p => $q)
					$body .= "<div><p><b>+ $p: </b> $q</p></div>";
			}
		}*/
	}
		
	// Display main admin menu
	page_draw(elgg_echo('apitest:lastresult'),elgg_view_layout("two_column_left_sidebar", '', $title . $body));
	

?>
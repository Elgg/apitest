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

	$endpoint = $vars['entity']->endpoint;
	if (!$endpoint)
		$endpoint = "{$vars['url']}pg/api/rest/php/";
?>
<p>
	<?php echo elgg_echo('apitest:apikey'); ?> <?php echo elgg_view('input/text', array('internalname' => 'params[apikey]', 'value' => $vars['entity']->apikey)); ?>
	<?php echo elgg_echo('apitest:secretkey'); ?> <?php echo elgg_view('input/text', array('internalname' => 'params[secretkey]', 'value' => $vars['entity']->secretkey)); ?>
	<?php echo elgg_echo('apitest:endpoint'); ?> <?php echo elgg_view('input/text', array('internalname' => 'params[endpoint]', 'value' => $endpoint)); ?> 
</p>
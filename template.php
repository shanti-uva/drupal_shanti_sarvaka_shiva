<?php

/**
 * @file
 * template.php
 */
 
 /**
  *   This is the template.php file for Sarvaka Shiva, a child sub-theme of the Shanti Sarvaka theme.
  *   
  */ 
  
/**
 * Implements hook_preprocess_page:
 */
 
function sarvaka_shiva_preprocess_page(&$vars) {
	$vids = array();
	$content = $vars['page']['content'];
	// Find the all_vis and my_vis blocks and separate them out from the content into their own variables
	foreach($content as $key => $view) {
		if(strpos($key, 'views_') > -1) {
			if(isset($view['#views_contextual_links_info']['views_ui']['view_display_id'])) {
				if($view['#views_contextual_links_info']['views_ui']['view_display_id'] == 'all_vis_block') {
					$vids['allvis'] = $key;
				} else if($view['#views_contextual_links_info']['views_ui']['view_display_id'] == 'my_vis_block') {
					$vids['myvis'] = $key;
				}
			}
		}
	}
	if(count($vids) > 0) {
		foreach($vids as $name => $vid) { 
			$vars['page'][$name] = $vars['page']['content'][$vid];
			unset($vars['page']['content'][$vid]);
		}
	}
}

/**
 * Implements hook_preprocess_node: adds variable "can_edit" to determine whether to display an edit button
 */
function sarvaka_shiva_preprocess_node(&$vars) {
	global $user;
	$vars['can_edit'] = FALSE;
	if(node_access('update', $vars['node'], $user)) {
		$vars['can_edit'] = TRUE;
	}
}


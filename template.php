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
 * Implements hook_preprocess_node: adds variable "can_edit" to determine whether to display an edit button
 */
function sarvaka_shiva_preprocess_node(&$vars) {
	global $user;
	$vars['can_edit'] = FALSE;
	if(node_access('update', $vars['node'], $user)) {
		$vars['can_edit'] = TRUE;
	}
}

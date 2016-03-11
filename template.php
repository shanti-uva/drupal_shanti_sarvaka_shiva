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
    foreach ($content as $key => $view) {
        if (strpos($key, 'views_') > -1) {
            if (isset($view['#views_contextual_links_info']['views_ui']['view_display_id'])) {
                if ($view['#views_contextual_links_info']['views_ui']['view_display_id'] == 'all_vis_block') {
                    $vids['allvis'] = $key;
                } else if ($view['#views_contextual_links_info']['views_ui']['view_display_id'] == 'my_vis_block') {
                    $vids['myvis'] = $key;
                }
            }
        }
    }
    if (count($vids) > 0) {
        foreach ($vids as $name => $vid) {
            $vars['page'][$name] = $vars['page']['content'][$vid];
            unset($vars['page']['content'][$vid]);
        }
    }
}

/**
 * Implements hook_preprocess_node:
 * 		adds variable "can_edit" to determine whether to display an edit button
 * 		creates info popup and share link
 */
function sarvaka_shiva_preprocess_node(&$vars) {
    switch ($vars['type']) {
        case 'shivadata':
            sarvaka_shiva_preprocess_shivadata($vars);
            break;
            
        case 'shivanode':
            sarvaka_shiva_preprocess_shivanode($vars);
            break;
    }
}

function sarvaka_shiva_preprocess_shivadata(&$vars) {
    //dpm($vars, 'pp node vars in theme');
    $author = user_load($vars['uid']);
    $author_link = l($author -> name, 'user/' . $vars['uid']);
    // Preprocess Shiva Data nodes
    $linklist = '<ul>';
    foreach ($vars['vis_links'] as $n => $link) {
        $linklist .= "<li>$link</li>";
    }
    $linklist .= '</ul>';
    if (count($vars['vis_links']) == 0) { $linklist = "Data not yet visualized.";
    }

    $infovars = array('icon' => 'fa-info-circle', 'title' => $vars['title'], 'vauthor' => $author_link, 'vdate' => date('M j, Y', $vars['created']), 'vdata' => 'Visualizations:' . $linklist, 'vdesc' => (!empty($vars['content']['body'])) ? $vars['content']['body'][0]['#markup'] : "", 'vfooter' => '', );

    $vars['infopop'] = sarvaka_shiva_custom_info_popover($infovars);
    $vars['viewpop'] = sarvaka_shiva_custom_info_popover(array(
        'icon' => 'shanticon-link-external', 
        'title' => t("View in New Window"), 
        'vdesc' => t('<p>View this data in a separate window</p>'), 
        'vfooter' => '', 
     ));
    $vars['usepop'] = sarvaka_shiva_custom_info_popover(array(
        'icon' => 'shanticon-visuals', 
        'title' => t("Use this Data"), 
        'vdesc' => t('<p>Create a visualization with this data</p>'), 
        'vfooter' => '', 
     ));
    //$vars['source_url'] = (empty($vars['shivadata_source_url'])) ? '' : $vars['shivadata_source_url'][0]['value'];
    $vars['source_url'] = (empty($vars['shivadata_source_url']) || !isset($vars['shivadata_source_url'][0]['value'])) ? '' : $vars['shivadata_source_url'][0]['value'];
    $vars['create_url'] = url("create/shivanode/{$vars['nid']}");
    //$vars['link_external'] = "<div class=\"share-link\"><a href=\"$source_url\" target=\"_blank\">$ext_link_pop</a></div>";

} 

function sarvaka_shiva_preprocess_shivanode(&$vars) {
    //dpm($vars, 'pp node vars in theme');
    $author = user_load($vars['uid']);
    $author_link = l($author -> name, 'user/' . $vars['uid']);
    // For Shiva Visualization Nodes
    global $user;
    $vars['can_edit'] = FALSE;
    if (node_access('update', $vars['node'], $user)) {
        $vars['can_edit'] = TRUE;
    }
    // Variables/markup for info popup
    $linktxt = '';
    if (!empty($vars['data_node'])) {
        if (is_string($vars['data_node']) && strpos($vars['data_node'], 'http') > -1) {
            $ltitle = t('External Spreadsheet');
            $lurl = $vars['data_node'];
            $linktxt = l($ltitle, $lurl, array('attributes' => array('target' => '_blank')));
        } else if (is_object($vars['data_node']) && isset($vars['data_node'] -> nid)) {
            $linktxt = l($vars['data_node'] -> title, "node/{$vars['data_node']->nid}", array('attributes' => array('target' => '_blank')));
            $vars['data_link'] = $linktxt;
        } else {
            $linktxt = t('n/a');
        }

        // Add link to source spreadsheet after group content access in details field group of full display
        if (isset($vars['content']['group_details']['group_content_access'])) {
            $vars['content']['group_details']['group_content_access']['#suffix'] = '<div class="field field-name-shivanode-data-link field-type-link field-label-inline clearfix">
                        <div class="field-label">' . t('Source Data:') . '&nbsp;</div>
                        <div class="field-items">
                            <div class="field-item even">' . $linktxt . '</div>
                        </div>
                    </div>';
        }
    }
    $vtype = (empty($vars['content']['shivanode_element_type'][0]['#markup'])) ? "" : $vars['content']['shivanode_element_type'][0]['#markup'];
    $vsubtype = (empty($vars['content']['shivanode_subtype'][0]['#markup'])) ? "" : $vars['content']['shivanode_subtype'][0]['#markup'];
    // Group info
    $vgroups = '';
    if (!empty($vars['og_group_ref'])) {
        foreach ($vars['og_group_ref'] as $n => $ginfo) {
            if (!empty($ginfo['target_id'])) {
                $gid = $ginfo['target_id'];
                $gnode = node_load($gid);
                $link = l($gnode -> title, "node/$gid");
                $vgroups .= "$link,";
            }
        }
    }
    if (!empty($vgroups)) {
        $vgroups = substr($vgroups, 0, strlen($vgroups) - 1);
    }
    
    //dpm($vars, 'vars in template');
    $coll = '';
    if (!empty($vars['field_og_parent_collection_ref'][0]['entity'])) {
        $collent = $vars['field_og_parent_collection_ref'][0]['entity'];
        $coll = l($collent->title, url('node/' . $collent->nid));
    }
    $desc = field_view_field('node', $vars['node'], 'shivanode_description', array('type' => 'text_summary_or_trimmed', 'label'=>'hidden', ));
    $infovars = array(
        'icon' => 'fa-info-circle', 
        'title' => $vars['title'], 
        'vtype' => $vtype, 
        'vsubtype' => $vsubtype, 
        'vauthor' => $author_link, 
        'vdate' => date('M j, Y', $vars['created']), 
        'vdata' => $linktxt, 
        'vgroups' => $coll, 
        'vdesc' => render($desc), 
        'vfooter' => '', 
     );
    $vars['infopop'] = sarvaka_shiva_custom_info_popover($infovars);

    // Variables/markup for Share pop
    $sharepop = sarvaka_shiva_custom_info_popover(array(
        'icon' => 'shanticon-share', 
        'title' => t("Share Visualization"), 
        'vdesc' => t('<p>Click to view sharing options.</p>'), 
        'vfooter' => '',
    /* 'options' => 'data-delay=\'{"show": 200, "hide": 200}\'', // Doesn't work */
    ));
    $vars['sharepop'] = "<div class=\"share-link\"><a href=\"/node/{$vars['node']->nid}/share?format=simple&amp;class=lightbox\" 
									class=\"sharelink\"
									rel=\"lightframe[|width:800px; height:450px; scrolling: no;]\" 
									title=\"Share this visualization!\" >
									$sharepop
									</a></div>";
}

/**
 * Implements hook_preprocess_search_results
 */
function sarvaka_shiva_preprocess_search_result(&$vars) {
    $url = drupal_get_path('theme', 'sarvaka_shiva') . '/images/sngen-chart-default.png';
    $node = $vars['result']['node'];
    $vars['url'] = url("node/{$node->nid}");
    $author = user_load($node -> uid);
    $vars['result']['author'] = l($author -> name, "/user/{$node->uid}");
    $vars['snippet'] = '';
    if (module_exists('shivanode')) {
        module_load_include('inc', 'shivanode', 'includes/shivanode');
        $vars['result']['thumb_url'] = _get_thumb_image($node);
        $vars['result']['sntype'] = _get_shivanode_type($node);
    }
    if (!empty($vars['result']['date'])) {
        $vars['result']['date'] = date('M j, Y', $vars['result']['date']);
    }
}

/**
 * Implements hook_preprocess_views_view_fields
 *
 * Removes width/height settings from thumb images in shiva_visuals_solr view.
 * Not sure where these are coming from.
 *
 * TODO: Find out where height and width settings are coming from for thumbnails and remove. Is it legacy?
 */
function sarvaka_shiva_preprocess_views_view_fields(&$vars) {
    $view = $vars['view'];
    if ($view -> name == 'shiva_visuals_solr') {
        $imgurl = $vars['fields']['field_image'] -> content;
        $imgurl = preg_replace('/height="[^"]+"/', '', $imgurl);
        $imgurl = preg_replace('/width="[^"]+"/', '', $imgurl);
        $vars['fields']['field_image'] -> content = $imgurl;
    }
}

/**
 * Implements theme_field for shivadata_source_url
 * 	Gives link to open in separate window followed by Iframe with showing the data.
 * 	Currently only shows when it's a google doc.
 *
 * 	TODO: Need to account for other types of datasource than google docs
 */
function sarvaka_shiva_field__shivadata_source_url($variables) {
    $url = $variables['element'][0]['#markup'];
    $output = '';
    $output .= '<div class="outlink"><a href="' . $url . '" target="_blank">' . t("View in separate window") . '</a></div>';
    $output .= '<div class="shivaframe"><iframe id="shivaDataFrame" src="' . $variables['element'][0]['#markup'] . '" frameborder="0" ' . 'style="width: 98% !important; min-height: 1000px;"> </iframe></div>';
    // Render the top-level DIV.
    $output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

    return $output;
}

/**
 * Creates custom popovers for Shivnode information based on shanti_sarvaka_info_popover
 *
 * Provides markup for the info popups from icons etc.
 * 	Variables:
 * 		- icon 		 (string) 	: icon class to use
 * 		- title 	 (string) 	: Header of popover
 * 		- vtype    (string) 	: Type of Visualization
 * 		- vsubtype (string) 	: Subtype
 * 		- vauthor   (string)  : Author
 * 		- vdate     (string) 	: Date
 * 		- footer 	 (string) 	: Footer content (optional)
 *    - options (string)    : "data-..." attribute options
 */
function sarvaka_shiva_custom_info_popover($variables) {
    $icon = $variables['icon'];
    $icon = (strpos($icon, 'fa') > -1) ? "fa $icon" : "icon $icon";
    $subtype = (!empty($variables['vsubtype'])) ? "({$variables['vsubtype']})" : "";
    $infoitems = $vtype = $vdate = $vgroups = '';
    $vtype = '<li>';
    if (!empty($variables['vtype'])) {
        $vtype .= "<span class=\"icon shanticon-visuals\" title=\"Visualization Type\"></span> {$variables['vtype']} {$subtype} ";
    }
    if (!empty($variables['vauthor'])) {
        $vtype .= "<span class=\"icon shanticon-agents\" title=\"Author\"></span> {$variables['vauthor']}";
    }
    $vtype .= '</li>';
    if (!empty($variables['vdate'])) {
        $vdate = "<li><span class=\"icon shanticon-calendar\" title=\"Date Created\"></span> {$variables['vdate']}</li>";
    }
    if (!empty($variables['vdata'])) {
        $vdate = "<li><span class=\"icon shanticon-list\" title=\"Data Used\"></span> {$variables['vdata']}</li>";
    }
    if (!empty($variables['vgroups'])) {
        $vgroups = "<li><span class=\"icon shanticon-stack\" title=\"Collections\"></span> {$variables['vgroups']}</li>";
    }
    if (!empty($vtype) || !empty($vauthor) || !empty($vdate) || !empty($vgroups)) {
        $infoitems = '<ul class="info">' . $vtype . $vdate . $vgroups . '</ul>';
    }
    $options = (!empty($variables['options'])) ? $variables['options'] : '';
    $html = "<div class=\"visinfo\"><span class=\"popover-link\"><span class=\"{$icon}\"></span></span>
						<div class=\"popover\" data-title=\"{$variables['title']}\" {$options}>
							<div class=\"popover-body\">
								{$infoitems}
								<div class=\"desc\">{$variables['vdesc']}</div>
							</div>
							<div class=\"popover-footer\">{$variables['vfooter']}</div>
						</div></div>";
    return $html;
}

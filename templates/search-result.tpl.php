<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
?>

<li class="shanti-thumbnail visual <?php print $classes; ?>" <?php print $attributes; ?>>
	
  <div class="shanti-thumbnail-image shanti-field-visuals">
    <a href="<?php print $url; ?>" class="shanti-thumbnail-link">
    	 <span class="overlay"><span class="icon"></span></span>
       <img class="img-responsive" typeof="foaf:Image" src="<?php print $result['thumb_url']; ?>">
       <span class="icon shanticon-visuals"></span>
    </a>
  </div> <!-- End of shanti-thumbnail-image -->
  
  <div class="shanti-thumbnail-info">
		<div class="body-wrap">
			<div class="shanti-thumbnail-field shanti-field-title">
				<span class="field-content"><a href="<?php print $url; ?>" class="shanti-thumbnail-link"><?php print $title; ?></a></span>
			</div>
			
			<div class="shanti-thumbnail-field shanti-field-type">
				<span class="shanti-field-content"><?php print $result['sntype']; ?></span>
			</div>
			<div class="shanti-thumbnail-field shanti-field-agent">
				<span class="shanti-field-content"> <?php print $result['author']; ?></span>
			</div>
			<div class="shanti-thumbnail-field shanti-field-created">
				<span class="shanti-field-content"><?php print $result['date']; ?></span>
			</div>
		
		</div> <!-- end body-wrap -->
<!--
		<div class="footer-wrap">
	
		</div> <!-- end footer -->
	</div> <!-- end shanti-thumbnail-info -->
</li>
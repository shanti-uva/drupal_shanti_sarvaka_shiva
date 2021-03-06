<?php
/**
 * @file
 * Default view template to display a list of items in a grid.
 *
 * Available template variables:
 * - $view: The view object.
 * - $title: Title of the view. May be empty.
 * - $rows: Array of items.
 * - $list_class: The class for the items list.
 * - $classes: Array of classes for each item.
 * - $classes_array: Array of classes for each item.
 *
 * @ingroup views_templates
 */
?>
<div id="<?php print $views_wookmark_id ?>" class="views-wookmark-grid">
  <?php if (!empty($title)) : ?>
    <h3><?php print $title; ?></h3>
  <?php endif; ?>
  <ul class="shanti-gallery <?php print $list_class; ?>">
    <?php foreach ($rows as $id => $item): ?>
      <li class="shanti-thumbnail visual views-wookmark-grid-item <?php print $classes_array[$id]; ?>"><?php print $item; ?></li>
    <?php endforeach; ?>
  </ul>
</div>

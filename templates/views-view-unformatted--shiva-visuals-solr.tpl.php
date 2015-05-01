<?php

/**
 * @file
 * View template for shanti gallery of thumbnails
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="shanti-gallery">
	<?php foreach ($rows as $id => $row): ?>
	  <?php print $row; ?>
	<?php endforeach; ?>
</ul>
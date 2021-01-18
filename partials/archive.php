<?php
/**
 * Archive partial
 *
* @package      RushmarkChild
* @author      Chris Clarke
 * @since        1.0.0
 * @license      GPL-2.0+
**/

echo '<article class="post-summary">';

	rushmark_post_summary_image();

	echo '<div class="post-summary__content">';
		rushmark_entry_category();
		rushmark_post_summary_title();
	echo '</div>';

echo '</article>';

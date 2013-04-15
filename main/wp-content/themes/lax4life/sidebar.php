<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	
		<div id="secondary" class="widget-area" role="complementary">
			<?php MS_dynamic_sidebar(); ?>
		</div><!-- #secondary -->

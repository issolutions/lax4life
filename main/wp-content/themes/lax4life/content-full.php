<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<div class="entry-title">
			<h1><?php the_title(); ?></h1>
		</div>
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		
	</article><!-- #post -->
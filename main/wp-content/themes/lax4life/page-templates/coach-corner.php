<?php
/**
 * Template Name: Coach Corner Page Template, with Sidebar
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content" style="width: 70.104166667% !important;">
		<div id="content" role="main">
			
			<div class="entry-header right-side">
					<div class="entry-title">
					  <h1>Coach's Corner</h1>
					</div>
					</div>
					
			<?php
			$args = array( 'order'=> 'ASC', 'category' => '32' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post) :  setup_postdata($post); 
			?>
				
					<div class="entry-content">
					<h3>
					<?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  				the_post_thumbnail();
				}?>
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					  <?php the_excerpt(); ?>
					</div><!-- .entry-content -->
					
					<?php endforeach; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
	<!-- LAX VALUES -->
		<div id="content" role="main">
		<?php
			$args = array( 'numberposts' => 1, 'order'=> 'ASC', 'category' => '44' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post) :  setup_postdata($post); 
			?>
					<div class="entry-header">
					<div class="entry-title">
					  <h1><?php the_title(); ?></h1>
					</div>
					</div>
					<div class="entry-content">
					  <?php the_content();?>
					</div><!-- .entry-page-image -->
					
					<?php endforeach; ?>

		</div><!-- #content -->
		
		<!-- GAME STATS -->
		<div id="content" role="main">

			<?php query_posts( array( 'post__in' => array(91),  'orderby' => 'post__in' ) ); ?>
			
			  <?php while (have_posts()) : the_post(); ?>
				<div class="entry-header">
					<div class="entry-title">
					  <h1><?php the_title(); ?></h1>
					</div>
					</div>
					<div class="entry-content">
					  <?php the_content();?>
					</div><!-- .entry-page-image -->
					
			  <?php endwhile;?>

		</div><!-- #content -->
		
		<!-- PHOTO GALLERY -->	
		<div id="content" role="main">

			<?php query_posts( array( 'post__in' => array(95),  'orderby' => 'post__in' ) ); ?>
			
			  <?php while (have_posts()) : the_post(); ?>
				<div class="entry-header">
					<div class="entry-title">
					  <h1><?php the_title(); ?></h1>
					</div>
					</div>
					<div class="entry-content">
					  <?php the_content();?>
					</div><!-- .entry-page-image -->
					
			  <?php endwhile;?>

		</div><!-- #content -->
		
		<div style="width: 100%;">
		<div class="one_half last">
	<!-- EVENTS NEWS -->
		<div id="content" role="main">
			
			<div class="entry-header">
					<div class="entry-title">
					  <h1>Event News</h1>
					</div>
					</div>
					
			<?php
			$args = array( 'numberposts' => 1, 'order'=> 'ASC', 'category' => '27' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post) :  setup_postdata($post); 
			?>
			
					<div class="entry-content">
					<h3><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					  <?php the_excerpt(); ?>
					</div><!-- .entry-content -->
					
					<?php endforeach; ?>
					
		</div><!-- #content -->
		
		</div>
		
		<div class="one_half last" style="border-left:1px solid #CCCCCC;">
		<!-- COACHS CORNER -->
		<div id="content" role="main">
                    <div class="entry-header">
					<div class="entry-title">
					  <h1>Coach's Corner</h1>
					</div>
					</div>
			<?php
			$args = array( 'numberposts' => 5, 'order'=> 'ASC', 'category' => '32' );
			$postslist = get_posts( $args );
			foreach ($postslist as $post) :  setup_postdata($post);
			?>
					<div class="entry-content">
					
					<h3><?php
				if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
  				the_post_thumbnail();
				}?>
				<a style="display:inline-block;" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
					 <?php the_title(); ?></a></h3>
					 
					</div><!-- .entry-content -->
					<?php endforeach; ?>
					
		</div><!-- #content -->
		
		</div>
		
		<div class="spacer" style="clear: both;"></div>
		</div>
		
	</div><!-- #primary -->

<?php get_footer(); ?>
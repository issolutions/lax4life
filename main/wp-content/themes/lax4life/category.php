<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'twentytwelve' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>

			<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>
			</header><!-- .archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			endwhile;

			twentytwelve_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->
<?php if (is_category('club')) : ?>
<?php dynamic_sidebar( 'sidebar-sr' ); ?>

<?php elseif (is_category('fall')) : ?>
<?php dynamic_sidebar( 'sidebar-lfl' ); ?>

<?php elseif (is_category('aboutlfl')) : ?>
<?php dynamic_sidebar( 'sidebar-lfl' ); ?>

<?php elseif (is_category('summer')) : ?>
<?php dynamic_sidebar( 'sidebar-lsl' ); ?>

<?php elseif (is_category('aboutlsl')) : ?>
<?php dynamic_sidebar( 'sidebar-lsl' ); ?>

<?php elseif (is_category('aboutsst')) : ?>
<?php dynamic_sidebar( 'sidebar-sst' ); ?>

<?php elseif (is_category('shootout')) : ?>
<?php dynamic_sidebar( 'sidebar-sst' ); ?>

<?php elseif (is_category('coach')) : ?>
<?php dynamic_sidebar( 'sidebar-sr' ); ?>

<?php elseif (is_category('aboutsr')) : ?>
<?php dynamic_sidebar( 'sidebar-sr' ); ?>

<?php else : ?>
<?php get_sidebar(); ?>

<?php endif; ?>

<?php get_footer(); ?>
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
<?php include('searchform.php'); ?>
<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
    <?php endwhile;endif ?>
</ul>
<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

<?php get_sidebar(); ?>


<?php get_footer(); ?>


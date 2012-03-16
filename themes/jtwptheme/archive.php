<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
    <?php endwhile;endif ?>
</ul>
<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
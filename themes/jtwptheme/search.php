<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<form action="<?php bloginfo('siteurl'); ?>" id="searchform" method="get">
    <div data-role="fieldcontain">
	    <input type="search" name="s" id="search" value="" />
	</div>
</form>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

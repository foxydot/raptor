<?php
/*** GENERAL ***/
add_theme_support( 'html5' );//* Add HTML5 markup structure
add_theme_support( 'genesis-responsive-viewport' );//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer' ) );

/*** HEADER ***/
add_filter( 'genesis_search_text', 'msdlab_custom_search_text' ); //customizes the serach bar placeholder

/*** NAV ***/
/**
 * Move nav into header
 */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );
add_action('genesis_after_header','msdlab_page_banner');
//add social to nav
add_filter('genesis_nav_items','msdlab_social_nav',20, 2);
add_filter('wp_nav_menu_items','msdlab_social_nav',20, 2);

/*** SIDEBARS ***/
add_action('genesis_before', 'msdlab_ro_layout_logic'); //This ensures that the primary sidebar is always to the left.
add_action('after_setup_theme','msdlab_sidebars'); //creates widget areas for a hero and flexible widget area
add_filter('widget_text', 'do_shortcode');//shortcodes in widgets

/*** CONTENT ***/
add_action('genesis_before_sidebar_widget_area','msdlab_ambassador_facts');
add_filter('genesis_breadcrumb_args', 'msdlab_breadcrumb_args'); //customize the breadcrumb output
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs'); //move the breadcrumbs 
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs'); //to outside of the loop area

remove_action( 'genesis_entry_header', 'genesis_post_info',12); //remove the info (date, posted by,etc.)
remove_action( 'genesis_entry_footer', 'genesis_post_meta'); //remove the meta (filed under, tags, etc.)

add_action( 'genesis_before_post', 'msdlab_post_image', 8 ); //add feature image across top of content on *pages*.
 
/*** FOOTER ***/
//add_theme_support( 'genesis-footer-widgets', 1 ); //adds automatic footer widgets

remove_action('genesis_footer','genesis_do_footer'); //replace the footer
add_action('genesis_footer','msdlab_do_social_footer');//with a msdsocial support one

/*** HOMEPAGE (BACKEND SUPPORT) ***/
add_action('after_setup_theme','msdlab_add_homepage_hero_flex_sidebars'); //creates widget areas for a hero and flexible widget area
add_action('after_setup_theme','msdlab_add_homepage_callout_sidebars'); //creates a widget area for a callout bar, usually between the hero and the widget area

add_action('wp_head', 'msdlab_custom_hooks_management');
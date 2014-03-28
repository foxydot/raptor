<?php
add_filter( 'genesis_pre_get_option_site_layout', 'msdlab_do_layout' );
function msdlab_do_layout( $opt ) {
        $opt = 'content-sidebar'; // You can change this to any Genesis layout
        return $opt;
}
remove_action('genesis_after_content','genesis_get_sidebar');
function msdlab_get_sidebar_alt() {
    get_sidebar( 'alt' );
}
add_action('genesis_after_content','msdlab_get_sidebar_alt');
remove_all_actions('genesis_entry_header');
remove_all_actions('genesis_entry_content');
remove_all_actions('genesis_entry_footer');
function msdlab_do_ambassador_image(){
    global $post;
    print '<a href="'.get_permalink().'">';
    the_post_thumbnail('thumbnail');
    print '</a>';
    genesis_do_post_title();
}
add_action('genesis_entry_content','msdlab_do_ambassador_image');
genesis();

<?php
/* Subtitle Support */
if(!class_exists('WPAlchemy_MetaBox')){
	include_once WP_CONTENT_DIR.'/wpalchemy/MetaBox.php';
}
add_action('init','add_custom_metaboxes');
function add_custom_metaboxes(){
	global $banner_metabox;
    $banner_metabox = new WPAlchemy_MetaBox(array
    (
        'id' => '_banner',
        'title' => 'Banner',
        'types' => array('post','page'),
        'context' => 'normal', // same as above, defaults to "normal"
        'priority' => 'high', // same as above, defaults to "high"
        'template' => get_stylesheet_directory() . '/lib/template/banner-meta.php',
        'autosave' => TRUE,
        'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
        'prefix' => '_msdlab_' // defaults to NULL
    ));
}
add_action('admin_footer','banner_footer_hook');
function banner_footer_hook()
{
	?><script type="text/javascript">
        jQuery('#titlediv').after(jQuery('#_banner_metabox'));
        //jQuery('#_banner_metabox').after(jQuery('#postimagediv'));		
	</script><?php
}

// include css to help style our custom meta boxes
add_action( 'admin_print_scripts', 'my_metabox_styles' );
 
function my_metabox_styles()
{
    if ( is_admin() )
    {
        wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/lib/template/meta.css');
    }
}

//add_action( 'genesis_before_post_content', 'msdlab_do_post_subtitle' );

function msdlab_do_post_subtitle() {
	global $subtitle_metabox;
	$subtitle_metabox->the_meta();
	$subtitle = $subtitle_metabox->get_the_value('subtitle');

	if ( strlen( $subtitle ) == 0 )
		return;

	$subtitle = sprintf( '<h2 class="entry-subtitle">%s</h2>', apply_filters( 'genesis_post_title_text', $subtitle ) );
	echo apply_filters( 'genesis_post_title_output', $subtitle ) . "\n";

}
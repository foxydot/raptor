<?php 
if (!class_exists('MSDBirdCPT')) {
    class MSDBirdCPT {
        //Properties
        var $cpt = 'ambassador';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDBirdCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_tax_group') );
            add_action( 'init', array(&$this,'register_cpt_ambassador') );
            add_action( 'init', array(&$this,'add_custom_metaboxes') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_print_styles', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            
            //Filters
            //add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
        }
        
        public function register_tax_group() {
        
            $labels = array( 
                'name' => _x( 'Groups', 'group' ),
                'singular_name' => _x( 'Group', 'group' ),
                'search_items' => _x( 'Search groups', 'group' ),
                'popular_items' => _x( 'Popular groups', 'group' ),
                'all_items' => _x( 'All groups', 'group' ),
                'parent_item' => _x( 'Parent group', 'group' ),
                'parent_item_colon' => _x( 'Parent group:', 'group' ),
                'edit_item' => _x( 'Edit group', 'group' ),
                'update_item' => _x( 'Update group', 'group' ),
                'add_new_item' => _x( 'Add new group', 'group' ),
                'new_item_name' => _x( 'New group name', 'group' ),
                'separate_items_with_commas' => _x( 'Separate groups with commas', 'group' ),
                'add_or_remove_items' => _x( 'Add or remove groups', 'group' ),
                'choose_from_most_used' => _x( 'Choose from the most used groups', 'group' ),
                'menu_name' => _x( 'Groups', 'group' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'group','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'group', array($this->cpt), $args );
        }
        
        function register_cpt_ambassador() {
        
            $labels = array( 
                'name' => _x( 'Ambassadors', 'ambassador' ),
                'singular_name' => _x( 'Ambassador', 'ambassador' ),
                'add_new' => _x( 'Add New', 'ambassador' ),
                'add_new_item' => _x( 'Add New Ambassador', 'ambassador' ),
                'edit_item' => _x( 'Edit Ambassador', 'ambassador' ),
                'new_item' => _x( 'New Ambassador', 'ambassador' ),
                'view_item' => _x( 'View Ambassador', 'ambassador' ),
                'search_items' => _x( 'Search Ambassador', 'ambassador' ),
                'not_found' => _x( 'No ambassadors found', 'ambassador' ),
                'not_found_in_trash' => _x( 'No ambassadors found in Trash', 'ambassador' ),
                'parent_item_colon' => _x( 'Parent Ambassador:', 'ambassador' ),
                'menu_name' => _x( 'Ambassador', 'ambassador' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Ambassador',
                'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
                'taxonomies' => array( 'group' ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'has_archive' => true,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'learn/ambassadors','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){}
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var i=1;
                        $(\'.customEditor textarea\').each(function(e)
                        {
                            var id = $(this).attr(\'id\');
             
                            if (!id)
                            {
                                id = \'customEditor-\' + i++;
                                $(this).attr(\'id\',id);
                            }
             
                            tinyMCE.execCommand(\'mceAddControl\', false, id);
             
                        });
                    });
                /* ]]> */</script>';
            }
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Ambassador Name','ambassador');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').after(jQuery('#_ambassador_info_metabox'));
                    </script><?php
            }
        }
        

        function custom_query( $query ) {
            if(!is_admin()){
                $is_ambassador = ($query->query['post_type'] == $this->cpt)?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive && $is_ambassador) {
                    $query->set( 'post_type', $this->cpt );
                    $query->set( 'meta_query', array() );
                }
            }
        } 
        
        function add_custom_metaboxes(){
            global $ambassador_info_metabox;
            $ambassador_info_metabox = new WPAlchemy_MetaBox(array
            (
                'id' => '_ambassador_info',
                'title' => 'Ambassador Info',
                'types' => array($this->cpt),
                'context' => 'normal', // same as above, defaults to "normal"
                'priority' => 'high', // same as above, defaults to "high"
                'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php') . '/lib/template/ambassador-info.php',
                'autosave' => TRUE,
                'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
                'prefix' => '_msdlab_' // defaults to NULL
            ));
        }
                     
  } //End Class
} //End if class exists statement
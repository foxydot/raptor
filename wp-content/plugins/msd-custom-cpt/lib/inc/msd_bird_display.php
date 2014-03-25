<?php 
if (!class_exists('MSDBirdDisplay')) {
    class MSDBirdDisplay {
        //Properties
        var $cpt = 'ambassador';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDBirdDisplay(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-custom-cpt/msd-custom-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php');
            //Actions
                     
            //Filters
            add_filter( 'genesis_attr_headshot', array(&$this,'msdlab_headshot_context_filter' ));
        }
 
        function get_ambassador_by_group($group) {
           $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => $this->cpt,
            'group'            => $group
            );
            $posts = get_posts($args);
            return $posts;
        }  
        
        function get_all_ambassadors(){
            $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => $this->cpt,
            );
            $posts = get_posts($args);
            return $posts;
        }     
        
        function ambassador_display($ambassadors,$attr = array()){
            global $post,$msd_custom,$ambassador_info_metabox;
            extract($attr);
            $headshot = get_the_post_thumbnail($ambassadors->ID,'headshot-md');
            $terms = wp_get_post_terms($ambassadors->ID,'group');
            $ambassador_info_metabox->the_meta($ambassadors->ID);
            $groups = '';
            if(count($terms)>0){
                foreach($terms AS $term){
                    $groups[] = $term->slug;
                }
                
                $groups = implode(' ', $groups);
            }
            $mini_bio = msdlab_excerpt($ambassadors->ID);
            $ambassadors_info = '';
                $ambassador_info_metabox->the_field('_bird_species');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
        $ambassador_info_metabox->the_field('_bird_height');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
        $ambassador_info_metabox->the_field('_bird_weight');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
        $ambassador_info_metabox->the_field('_bird_wingspan');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
        $ambassador_info_metabox->the_field('_bird_birthdate');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
        $ambassador_info_metabox->the_field('_bird_arrived');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span>$ambassador_info_metabox->get_the_value()</li>';
            }
            
            $ambassadorsstr = '
            <a class="team-member '.$groups.' '.$ambassadors->post_name.'" href="'.get_post_permalink($ambassadors->ID).'">
                <div class="headshot">
                    '.$headshot.'
                </div>
                <div class="info">
                    <h4>'.$ambassadors->post_title.'</h4>
                    <h5>'.$jobtitle_metabox->get_the_value('jobtitle').'</h5>
                    ';
            $ambassadorsstr .= '
                </div>
            </a>';
            return $ambassadorsstr;
    }   
        
        function sort_by_lastname( $a, $b ) {
            return $a->lastname == $b->lastname ? 0 : ( $a->lastname < $b->lastname ) ? -1 : 1;
        } 
        
        function get_all_practice_areas(){
            return get_terms('practice_area',array('orderby'=>'slug','order'=>'ASC'));
        }
        
        function msd_add_ambassador_headshot(){
            global $post;
            //setup thumbnail image args to be used with genesis_get_image();
            $size = 'headshot-lg'; // Change this to whatever add_image_size you want
            $default_attr = array(
                    'class' => "attachment-$size $size",
                    'alt'   => $post->post_title,
                    'title' => $post->post_title,
            );
        
            // This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
            genesis_markup( array(
                'html5'   => '<section %s>',
                'xhtml'   => '<div id="headshot" class="headshot-wrapper">',
                'context' => 'headshot'
            ) );
            do_action('msdlab_before_ambassador_headshot');
            if ( has_post_thumbnail() ) {
                printf( '%s', genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
            }
            do_action('msdlab_after_ambassador_headshot');
            genesis_markup( array(
                'html5'   => '</section>',
                'xhtml'   => '</div>'
            ) );
        }
        /**
         * Callback for dynamic Genesis 'genesis_attr_$context' filter.
         * 
         * Add custom attributes for the custom filter.
         * 
         * @param array $attributes The element attributes
         * @return array $attributes The element attributes
         */
        function msdlab_headshot_context_filter( $attributes ){
                $attributes['class'] .= ' alignleft';
                // return the attributes
                return $attributes;
        }
        
        function msdlab_ambassador_info(){
            global $post,$ambassador_info_metabox;
            $ambassador_info_metabox->the_field('_bird_species');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-sitemap fa-stack-1x fa-inverse"></i></span>'.$ambassador_info_metabox->get_the_value().'</li>';
            }
            
            $ambassador_info_metabox->the_field('_bird_height');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-arrows-v fa-stack-1x fa-inverse"></i></span> Height: '.$ambassador_info_metabox->get_the_value().' in.</li>';
            }
            
            $ambassador_info_metabox->the_field('_bird_weight');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span> Weight: '.$ambassador_info_metabox->get_the_value().' lbs.</li>';
            }
            
            $ambassador_info_metabox->the_field('_bird_wingspan');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-arrows-h fa-stack-1x fa-inverse"></i></span> Wingspan: '.$ambassador_info_metabox->get_the_value().' in.</li>';
            }
            
            $ambassador_info_metabox->the_field('_bird_birthdate');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span> Age: '.date("Y") - $ambassador_info_metabox->get_the_value().' yrs.</li>';
            }
            
            $ambassador_info_metabox->the_field('_bird_arrived');
            if($ambassador_info_metabox->get_the_value() != ''){
                $ambassadors_info .= '<li class="mobile"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-xxxxx fa-stack-1x fa-inverse"></i></span> Came to RAPTOR in '.$ambassador_info_metabox->get_the_value().'</li>';
            }
            return '<ul class="ambassador-info">'.$ambassadors_info.'</ul>';
        }
        function msd_team_additional_info(){
            global $post,$additional_info;
            $fields = array(
                    'experience' => 'Experience',
                    'decisions' => 'Notable Decisions',
                    'honors' => 'Honors/Distinctions',
                    'admissions' => 'Admissions',
                    'affiliations' => 'Professional Affiliations',
                    'community' => 'Community Involvement',
                    'presentations' => 'Presentations',
                    'publications' => 'Publications',
                    'education' => 'Education',
            );
            $i = 0; ?>
            <h3 class="toggle">More Info<span class="expand">Expand <i class="fa fa-angle-down"></i></span><span class="collapse">Collapse <i class="fa fa-angle-up"></i></span></h3>
            <ul class="team-additional-info">
            <?php
            foreach($fields AS $k=>$v){
            ?>
                <?php $additional_info->the_field('_team_'.$k); ?>
                <?php if($additional_info->get_the_value() != ''){ ?>
                    <li>
                        <h3><?php print $v; ?></h3>
                        <?php print font_awesome_lists(apply_filters('the_content',$additional_info->get_the_value())); ?>
                    </li>
                <?php 
                $i++;
                }
            } ?>
            </ul>
            <?php
        }
        function font_awesome_lists($str){
            $str = strip_tags($str,'<a><li><ul><h3><b><strong><i>');
            $str = preg_replace('/<ul(.*?)>/i','<ul class="icons-ul"\1>',$str);
            $str = preg_replace('/<li>/i','<li><i class="fa fa-li fa fa-caret-right"></i>',$str);
            return $str;
        }
        function msd_team_sidebar(){
            global $post,$primary_practice_area;
            $terms = wp_get_post_terms($post->ID,'practice_area');
            $ppa = $primary_practice_area->get_the_value('primary_practice_area');
            print '<div class="sidebar-content">';
            if(count($terms)>0){
                print '<div class="widget">
                    <div class="widget-wrap">
                    <h4 class="widget-title widgettitle">Practice Areas</h4>
                    <ul>';
                foreach($terms AS $term){
                    if($term->slug == $ppa){
                        if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                         $ret = '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a></li>'.$ret;
                        } else {
                         $ret = '<li>'.$term->name.'</li>'.$ret;
                        }
                    } else {
                        if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                         $ret .= '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a></li>';
                        } else {
                         $ret .= '<li>'.$term->name.'</li>';
                        }
                    }
                }
                print $ret;
                print '</ul>
                </div>
                </div>';
            }
            dynamic_sidebar('team-sidebar');
            print '</div>';
        }
        function msd_do_ambassador_job_title() {
            global $jobtitle_metabox;
            $jobtitle_metabox->the_meta();
            $jobtitle = $jobtitle_metabox->get_the_value('jobtitle');
        
            if ( strlen( $jobtitle ) == 0 )
                return;
        
            $jobtitle = sprintf( '<h2 class="entry-subtitle">%s</h2>', apply_filters( 'genesis_post_title_text', $jobtitle ) );
            echo apply_filters( 'genesis_post_title_output', $jobtitle ) . "\n";
        }
  } //End Class
} //End if class exists statement
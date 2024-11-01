<?php
/**
 * Stars Menu Item Default class
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Item Default class
 *
 * Create & Manege Menu Item
 *
 * @Class StarsMenuItemDefault
 * @since 1.0.0
 */
class StarsMenuItemDefault extends StarsMenuItem {

    /**
     * Menu Item Type
     *
     * @var string
     * @since 1.0.0
     */
    protected $type = "default";

    /**
     * Menu Back Item Mode
     *
     * @var string
     * @since 1.0.0
     */
    public $back_item_mode = false;

    public function init(){

        $this->item->custom_type = $this->type;

    }

    function get_start_el(){

        $indent = ( $this->depth > 0 ? str_repeat( "\t", $this->depth ) : '' ); // code indent

        if( ! $this->back_item_mode ) {
            // Passed classes.
            $this->set_item_default_classes();
            $this->add_depth_classes();
            $this->add_id_class();
            $this->add_class_responsive();
            //$this->add_alignment_class();
            $this->add_class_disable_padding();

            $this->add_dropdown_class();
            $this->add_dropdown_trigger_class();
            $this->add_dropdown_position_class();

            if ($this->has_children) {
                $this->item_classes[] = 'starsmenu-submenu-item';
            }

            if ($this->has_children || $this->depth == 0) {
                $this->item_classes[] = 'starsmenu-expanded-item';
            }

            if ($this->item->current || $this->item->current_item_ancestor ) {//|| $this->item->current_item_parent
                $this->item_classes[] = 'starsmenu-active-item';
            }

            if ($this->depth == 0) {
                $this->item_attributes['data-submenu-depth'] = $this->depth + 1;
            }

            $this->set_link_default_attributes();

            $this->set_link_default_classes();

            $this->add_item_submenu_mobile_class();

            $this->disable_link();

            $this->highlight_link_class();

            $this->no_wrap_link();

            $layout = $this->get_item_layout();

        }

        $this->set_item_before();

        $this->set_item_after();

        $this->set_link_before();

        $this->set_link_after();

        $title = $this->get_text();

        $description = $this->item_description();

        $icon = $this->get_icon();

        $image = $this->get_image();

        $custom_widget_area = $this->get_widget_area();

        $custom_content = $this->get_custom_content();

        $class_names = $this->get_item_class_names();

        $item_id = $this->get_item_id();

        $item_attributes = $this->get_item_attributes();

        $link_attributes = $this->get_link_attributes();

        $link_class_names = $this->get_link_class_names();

        $before = $this->get_item_start();

        $after = $this->get_item_end();

        $link_before = $this->get_link_before();

        $link_after = $this->get_link_after();

        $layout_content = $this->walker->get_template( "item_layout.php" , array(
            'item'                  => $this->item ,
            'has_children'          => $this->has_children ,
            'back_item_mode'        => $this->back_item_mode ,
            'layout'                => $this->item_layout ,
            'icon'                  => $icon ,
            'image'                 => $image ,
            'title'                 => $title ,
            'description'           => $description 
        ));

        if( $this->has_children && !$this->back_item_mode ){

            $this->add_back_item();

        }

        $template_args = array(
            'depth'                 => $this->depth ,
            'args'                  => $this->args ,
            'item'                  => $this->item ,
            'class_names'           => $class_names ,
            'id'                    => $this->id ,
            'indent'                => $indent ,
            'walker'                => $this->walker ,
            'has_children'          => $this->has_children ,
            'item_id'               => $item_id ,
            'item_attributes'       => $item_attributes ,
            'link_attributes'       => $link_attributes ,
            'link_class_names'      => $link_class_names ,
            'before'                => $before ,
            'after'                 => $after ,
            'link_before'           => $link_before ,
            'link_after'            => $link_after ,
            'layout_content'        => $layout_content ,
            'custom_widget_area'    => $custom_widget_area,
            'custom_content'        => $custom_content,
            'link_tag'              => $this->link_tag
        );

        $template_name = "start_item_wrapper.php";

        // Build HTML output and pass through the proper filter.
        $item_output = $this->walker->get_template( $template_name , $template_args );

        $item_output = apply_filters( "stmenu_start_item_wrapper_output" , $item_output , $template_name , $template_args );

        return $item_output;
        
    }

    public function get_end_el(){

        // Build HTML for output.
        $item_output = $this->walker->get_template( "end_item_wrapper.php" , array(
            'depth'         => $this->depth ,
            'args'          => $this->args ,
            'item'          => $this->item ,
            'walker'        => $this->walker
        ) );

        return $item_output;
    }

    public function get_start_lvl(){

        // Depth-dependent classes.
        $display_depth = ( $this->depth + 1); // because it counts the first submenu as 0

        $classes = array(
            'sub-menu starsmenu-submenu',
            ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
            ( $display_depth >=2 ? 'sub-sub-menu menu' : '' ),
            'menu-depth-' . $display_depth
        );

        $index = count( $this->walker->started_submenus ) -1;

        $parent_item = $this->walker->started_submenus[ $index ];

        // Build HTML for output.
        $output = $this->walker->get_template( "start_submenu_wrapper.php" , array(
            'depth'         => $this->depth ,
            'args'          => $this->args ,
            'back_item'     => $parent_item['back'] ,
            'classes'       => $classes ,
            'walker'        => $this->walker
        ) );

        return $output;
    }

    public function get_end_lvl(){

        $index = count( $this->walker->started_submenus ) -1;

        $parent_item = $this->walker->started_submenus[ $index ];

        if( $index == 0 ){

            $this->walker->started_submenus = array();

        }else{

            $this->walker->started_submenus = array_slice( $this->walker->started_submenus , 0 , $index );

        }

        // Build HTML for output.
        $output = $this->walker->get_template( "end_submenu_wrapper.php" , array(
            'depth'         => $this->depth ,
            'args'          => $this->args ,
            'back_item'     => $parent_item['back_bottom'] ,
            'walker'        => $this->walker
        ) );

        return $output;

    }

    public function set_item_before(){

        $title = apply_filters( 'the_title', $this->item->title, $this->item->ID );

        $this->before_arg_item = $this->walker->get_template( "start_item.php" , array(
            'item'                  => $this->item ,
            'title'                 => $title
        ) );

    }

    public function set_item_after(){

        $arrow_classes = $this->get_item_arrow();

        $this->after_arg_item = $this->walker->get_template( "end_item.php" , array(
            'item'                  => $this->item ,
            'has_children'          => $this->has_children ,
            'back_item_mode'        => $this->back_item_mode ,
            'arrow'                 => $arrow_classes ,
            'is_disable_link'       => $this->is_disable_link()
        ) );

    }

    public function set_link_before(){

        $arrow_classes = $this->get_back_item_arrow();

        $this->link_before = $this->walker->get_template( "link_before.php" , array(
            'item'                  => $this->item ,
            'has_children'          => $this->has_children ,
            'back_item_mode'        => $this->back_item_mode ,
            'arrow'                 => $arrow_classes ,
            'is_disable_link'       => $this->is_disable_link()
        ) );

    }

    public function set_link_after(){

        $arrow_classes = $this->get_item_arrow();

        $this->link_after = $this->walker->get_template( "link_after.php" , array(
            'item'                  => $this->item ,
            'has_children'          => $this->has_children ,
            'back_item_mode'        => $this->back_item_mode ,
            'arrow'                 => $arrow_classes ,
            'is_disable_link'       => $this->is_disable_link()
        ) );

    }

    function add_item_submenu_mobile_class(){

        if ( $this->has_children && ( empty( $this->item->url ) || trim( $this->item->url ) == "#" || $this->is_disable_link() ) ) {

            $this->link_classes[] = "starsmenu-mobile-submenu-toggle-combined";

        }

    }

    /**
     * Add Back Item To Top & Bottom Of SubMenus
     */
    public function add_back_item( ){

        add_filter( "stmenu_start_item_wrapper_output" , array( $this , "back_item_template_filter" ) , 1000 , 3 );

        $this->back_item_mode = true;

        add_filter( "nav_menu_link_css_class" , array( $this , "back_item_link_classes_filter" ) , 1000 , 1 );

        add_filter( "nav_menu_item_attributes" , array( $this , "back_item_attributes_filter" ) , 1000 , 1 );

        add_filter( "nav_menu_css_class" , array( $this , "back_item_classes_filter" ) , 1000 , 1 );

        $item_output = $this->get_start_el();

        $submenu_back_item_output = $item_output;

        $submenu_back_item_output .= $this->get_end_el();

        remove_filter( "nav_menu_css_class" , array( $this , "back_item_classes_filter" ) , 1000 );

        add_filter( "nav_menu_css_class" , array( $this , "back_bottom_item_classes_filter" ) , 1000 , 1 );

        $item_output = $this->get_start_el();

        $submenu_back_bottom_item_output = $item_output;

        $submenu_back_bottom_item_output .= $this->get_end_el();

        remove_filter( "nav_menu_css_class" , array( $this , "back_bottom_item_classes_filter" ) , 1000 );

        remove_filter( "nav_menu_item_attributes" , array( $this , "back_item_attributes_filter" ) , 1000 );

        remove_filter( "nav_menu_link_css_class" , array( $this , "back_item_link_classes_filter" ) , 1000 );

        $this->back_item_mode = false;

        remove_filter( "stmenu_start_item_wrapper_output" , array( $this , "back_item_template_filter" ) , 1000 );

        $this->walker->started_submenus[] = array(
            "back"            => $submenu_back_item_output ,
            "back_bottom"     => $submenu_back_bottom_item_output
        );

    }

    public function back_item_template_filter( $item_output , $template_name , $template_args ){

        $item_output = $this->walker->get_template( "back_item_wrapper.php" , $template_args );

        return $item_output;

    }

    public function back_item_classes_filter( $classes ){

        $classes = array();

        $classes[] = "menu-item";

        $classes[] = "starsmenu-back-item";

        $classes[] = "starsmenu-back-top-item";

        $classes[] = "starsmenu-mobile-submenu-back";

        return $classes;

    }

    public function back_bottom_item_classes_filter( $classes ){

        $classes = array();

        $classes[] = "menu-item";

        $classes[] = "starsmenu-back-item";

        $classes[] = "starsmenu-back-bottom-item";

        $classes[] = "starsmenu-mobile-submenu-back-bottom";

        return $classes;

    }

    public function back_item_link_classes_filter( $classes ){

        /*$key = array_search( "starsmenu-mobile-submenu-toggle-combined" , $classes );

        if( $key > -1 ){
            unset( $classes[$key] );
        }*/

        $classes = array();

        $classes[] = "starsmenu-back-link";

        $classes[] = "starsmenu-link";

        return $classes;
    }

    public function back_item_attributes_filter( $attributes ){

        if( isset( $attributes['data-submenu-depth'] ) ){

            unset( $attributes['data-submenu-depth'] );

        }

        return $attributes;

    }
    
    
}

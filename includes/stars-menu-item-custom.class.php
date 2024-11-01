<?php
/**
 * Stars Menu Item Custom class
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Item Custom class
 *
 * Create & Manege Menu Item Custom
 *
 * @Class StarsMenuItemDefault
 * @since 1.0.0
 */
class StarsMenuItemCustom extends StarsMenuItemDefault {

    /**
     * Menu Item Type
     *
     * @var string
     * @since 1.0.0
     */
    protected $type = "custom";

    /**
     * Force Disable Current Item SubMenus
     *
     * @var string
     * @since 1.0.0
     */
    public $force_disable_submenu = true;


    public function init(){

        $this->item->custom_type = $this->type;

    }

    function get_start_el(){

        $this->item_classes = array( 'menu-item' , 'starsmenu-custom-item' );

        $this->add_id_class();

        $this->add_class_responsive();

        $custom_content = $this->get_custom_content();

        $class_names = $this->get_item_class_names();

        $item_id = $this->get_item_id();

        $item_attributes = $this->get_item_attributes();

        $template_args = array(
            'depth'                 => $this->depth ,
            'args'                  => $this->args ,
            'item'                  => $this->item ,
            'class_names'           => $class_names ,
            'id'                    => $this->id ,
            'walker'                => $this->walker ,
            'has_children'          => $this->has_children ,
            'item_id'               => $item_id ,
            'item_attributes'       => $item_attributes ,
            'custom_content'        => $custom_content
        );

        $template_name = "start_custom_item.php";

        // Build HTML output and pass through the proper filter.
        $item_output = $this->walker->get_template( $template_name , $template_args );

        $item_output = apply_filters( "stmenu_start_custom_item_output" , $item_output , $template_name , $template_args );

        return $item_output;
        
    }
    
}

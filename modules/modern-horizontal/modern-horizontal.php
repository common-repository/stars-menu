<?php
/**
 * Module Name: Modern Horizontal Menu Design
 * Module URI: http://www.stars-menu.com
 * Description: one Modern Horizontal Menu For WordPress
 * Author: Stars Team
 * Author URI: http://www.stars-menu.com/stars-team
 * @since 1.0.0
 * @package StarsMenu
 * @category Modules
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Modern Horizontal Menu Module class
 *
 * Manege Modern Horizontal Menu Module
 *
 * @Class StarsModernHorizontalMenu
 * @since 1.0.0
 */
class StarsMenuModernHorizontalDesign {

    /**
     * The General Settings Tab Panel Options
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $panel_options = array();

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $stmenu;

    /**
     * StarsModernHorizontalMenu constructor.
     * @param $stars_menu
     */
	public function __construct( $stars_menu ) {

        $this->stmenu = $stars_menu;

        add_filter( 'stmenu_item_object_class_modern-horizontal' , array( $this , 'get_item_object_class' ) , 100 , 3 );

	}

    public function get_item_object_class( $class , $item , $id ){

        if( $item->custom_type ){

            $custom_type = $item->custom_type;

        } else{

            $custom_type = get_post_meta( $item->db_id , '_stars_menu_custom_item_type' , true );

        } 

        switch( $custom_type ){

            case 'custom':
                $class = 'StarsMenuItemCustom';
                break;

            case 'widget_area':
                $class = 'StarsMenuItemWidgetArea';
                break;

        }

        return $class;

    }

}

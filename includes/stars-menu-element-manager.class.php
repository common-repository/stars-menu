<?php
/**
 * Stars Menu Elements Manager class
 *
 * @package StarsMenu
 * @subpackage Elements
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Elements Manager class
 *
 * Manage Elements For Stars menu
 *
 * @Class StarsMenuGeneralSettings
 * @since 1.0.0
 */
class StarsMenuElementsManager {

    /**
     * The Options instance of the TitanFramework class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    protected $elements;

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $stmenu;

    /**
     * StarsMenuGeneralSettings constructor.
     * @param $stars_menu
     */
	public function __construct( $stars_menu ) {

        $this->stmenu = $stars_menu;

        add_action( 'plugins_loaded', array(&$this, 'load_elements') );

        add_action( 'stmenu_load_dynamic_elements', array(&$this, 'load_dynamic_elements') , 10 , 1 );

	}

    public function load_elements(){

        $elements_path = dirname( __FILE__ ) . "/elements/*-element.class.php" ;

        foreach ( glob( $elements_path ) as $element_path ) {

            require_once $element_path;
        }

    }

    public function load_dynamic_elements( $theme ){

        $dynamic_elements = stmenu_theme_option( 'theme_dynamic_elements' , $theme );

        $dynamic_elements = ( !is_array( $dynamic_elements ) ) ? array() : $dynamic_elements;

        foreach ( $dynamic_elements AS $id => $element_options ){

            if( !isset( $element_options['php_class'] ) || !isset( $element_options['menu_id'] ) ||  !isset( $element_options['id'] ) ||  !isset( $element_options['type'] ) ){
                continue;
            }

            $id = $element_options['id'];

            $type = $element_options['type'];

            $php_class = $element_options['php_class'];

            $title = isset( $element_options['title'] ) && !empty( $element_options['title'] ) ? $element_options['title'] : __("No Title" , "stars-menu");

            if( !empty( $php_class ) && class_exists( $php_class ) ){

                $element = new $php_class( $this );

                $element->title = $title;

                $element->id = $id;

                $element->menu_id = $element_options['menu_id'];

                $element->type = $type;

                $this->elements[$id] = $element;

            }

        }

    }

    public function register_element( $id , $php_class ){

        if( !empty( $php_class ) && class_exists( $php_class ) ){

            $this->elements[$id] = new $php_class( $this );

        }

    }
    
    public function get_elements(){
        
        return $this->elements;
        
    }

    public function get_element( $id ){

        if( isset( $this->elements[$id] ) ){
            return $this->elements[$id];
        }

        return null;

    }

}

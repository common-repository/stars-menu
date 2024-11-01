<?php
/**
 * Stars Menu General Settings class
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu General Settings class
 *
 * Create & Manege General Settings
 *
 * @Class StarsMenuGeneralSettings
 * @since 1.0.0
 */
class StarsMenuGeneralSettings {

    /**
     * The General Settings Tab Panel Options
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $panel_options = array();

    /**
     * The Menu Item Panel Tabs
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $panel_tabs = array();
    
    /**
     * The panel instance of the TitanFramework options class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $panel;

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $manager;

    /**
     * StarsMenuGeneralSettings constructor.
     * @param $manager
     * @param $panel
     */
	public function __construct( $manager , $panel ) {

        $this->panel = $panel;

        $this->manager = $manager;
        
        $this->set_options();

        $this->set_tabs();

        $this->create_options();

	}

    protected function create_options(){

        foreach ( $this->panel_options AS $option ){

            $this->panel->createOption( $option );

        }

    }

    protected function set_tabs(){

        $tabs = array(
            '_all'                      =>  __("Show All" , "stars-menu") ,
            'integration'               =>  __("Integration" , "stars-menu") ,
            'icons'                     =>  __("Icons" , "stars-menu") ,
            'widget-area'               =>  __("Widget Area" , "stars-menu") ,
            'advanced'                  =>  __("Advanced" , "stars-menu") ,
        );

        $this->panel_tabs = apply_filters( 'stmenu-general-settings-tab-tabs' , $tabs );

    }

    protected function set_options(){
        
        $options = array(

            array(
                'name'          => __( "Manual Integration" , "stars-menu" ),
                'type'          => 'heading' ,
                'tab'           => 'integration'
            ),

            array(
                'name'          => __( "Manual Integration Code" , "stars-menu" ),
                'type'          => 'menu-integrate',
                'id'            => 'general_custom_menu_locations' ,
                'default'       => array() ,
                'tab'           => 'integration'
            ),

            array(
                'name'                  => __( "Custom Location" , "stars-menu" ),
                'type'                  => 'ajax-button',
                'action'                => 'add_custom_menu_location',
                'label'                 => __( 'Add Custom Menu Location', 'stars-menu' ),
                'wait_label'            => __( 'Please wait...', 'stars-menu' ),
                'success_label'         => __( 'Done!', 'stars-menu' ),
                'success_callback'      => '__starsMenuAddCustomLocationSuccess',
                'data_filter_callback'  => '__starsMenuAddCustomLocationData',
                'tab'                   => 'integration'
            ),

            array(
                'name'          => __( "Manage Widget Areas" , "stars-menu" ),
                'type'          => 'custom-widget-areas',
                'id'            => 'general_custom_widget_areas' ,
                'default'       => array() ,
                'tab'           => 'widget-area'
            ) ,

            array(
                'name'          => __( "Active Menu Instances" , "stars-menu" ),
                'type'          => 'menu-instances',
                'id'            => 'general_active_menu_instances' ,
                'default'       => array() ,
                'tab'           => 'advanced'
            ) ,

            array(
                'name'                  => __( "Responsive Breakpoint" , "stars-menu" ),
                'id'                    => 'general_responsive_breakpoint',
                'type'                  => 'text',
                'desc'                  => __( "The viewport width at which the menu will collapse to mobile menu. The default is 910px. If you would like to change this to something like 768px, " , "stars-menu" ),
                'default'               => 910,
                'tab'                   => 'advanced' ,
                /*'validation'            => array( 'integer' , 'require' ) ,
                'css_sanitize'          => array( 'require' ) ,
                'is_style_variable'     => true*/
            ),

            array(
                'type' => 'save'
            )

        );

        $this->panel_options = apply_filters( 'stmenu-general-settings-tab-options' , $options );

    }

}

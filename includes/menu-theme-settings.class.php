<?php
/**
 * Stars Menu Theme Settings class
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Theme Settings class
 *
 * Create & Manege Theme Settings
 *
 * @Class StarsMenuThemeSettings
 * @since 1.0.0
 */
class StarsMenuThemeSettings {

	/**
	 * The Theme Settings Tab Panel Options
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
     * The stmenu instance of the Admin Panel class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $theme_tab;

	/**
	 * StarsMenuThemeSettings constructor.
	 * @param $manager
	 * @param $panel
	 */
	public function __construct( $manager , $panel ) {

		$this->panel = $panel;

		$this->manager = $manager;

		$this->set_options();

        $this->set_tabs();

        $this->theme_tab = $manager->admin_panel->createTab( array(
            'name' => __("Default Theme Configuration" , "stars-menu"),
        ) );

		$this->create_options();

	}

	protected function create_options(){

		foreach ( $this->panel_options AS $option ){

			$this->panel->createOption( $option );

		}

        $default_menu_theme_options = $this->panel_options;

        $default_menu_theme_options[] = array(
            'type'          => 'save' ,
            'use_reset'     => false
        );

        foreach ( $default_menu_theme_options AS $option ){

            if( isset( $option['id'] ) ) {
                $option['id'] .= "_default";
            }

            $this->theme_tab->createOption( $option );

        }

	}

    public function get_theme_option( $id , $theme = "default" ){

        if( $theme == "default" ) {
            $id .= "_default";
            $post_id = null;
        }else{
            $post_id = (int) $theme;
        }

        return $this->manager->options->getOption( $id , $post_id );

    }

    protected function set_tabs(){

        $tabs = array(
            //'_all'                      =>  __("Show All" , "stars-menu") ,
            'basic'                     =>  __("Basic Configuration" , "stars-menu") ,
            'menu-bar'                  =>  __("Menu Bar" , "stars-menu") ,
            'top_level_items'           =>  __("Top Level Items" , "stars-menu") ,
            'hamburger'                 =>  __("Hamburger" , "stars-menu") ,
            'position'                  =>  __("Position &amp; Layout" , "stars-menu") ,
            'submenus'                  =>  __("Submenus" , "stars-menu") ,
            'descriptions'              =>  __("Descriptions" , "stars-menu") ,
            'images'                    =>  __("Images" , "stars-menu") ,
            'responsive'                =>  __("Responsive &amp; Mobile" , "stars-menu") ,
            //'style_customizations'      =>  __("Style Customizations" , "stars-menu") ,
            'icons'                     =>  __("Icons" , "stars-menu") ,
            'misc'                      =>  __("Miscellaneous" , "stars-menu") ,
            'logo'                      =>  __("Logo" , "stars-menu") ,
            'search'                    =>  __("Search" , "stars-menu") ,
            'sub-nav-bar'               =>  __("Sub Navigation Bar" , "stars-menu") ,
            'woo-cart'                  =>  __("WooCommerce Cart Icon" , "stars-menu") ,
            'social-bar'                =>  __("Social Bar" , "stars-menu") ,
            'advanced'                  =>  __("Advanced" , "stars-menu") ,
            'sticky'                    =>  __("Sticky" , "stars-menu") ,
            'divider'                   =>  __("Divider" , "stars-menu") ,
        );

        $this->panel_tabs = apply_filters( 'stmenu-theme-settings-tab-tabs' , $tabs );

    }

	protected function set_options(){

        $arrow_icons = array(
            'ellipsis-h' ,
            'chevron-right' ,
            'arrow-right' ,
            'hand-o-right' ,
            'arrow-circle-right' ,
            'caret-right' ,
            'angle-double-right' ,
            'angle-right' ,
            'chevron-circle-right' ,
            'long-arrow-right' ,
            'arrow-circle-o-right' ,

            'chevron-left' ,
            'arrow-left' ,
            'hand-o-left' ,
            'arrow-circle-left' ,
            'caret-left' ,
            'angle-double-left' ,
            'angle-left' ,
            'chevron-circle-left' ,
            'long-arrow-left' ,
            'arrow-circle-o-left' ,

            'chevron-up' ,
            'arrow-up' ,
            'hand-o-up' ,
            'arrow-circle-up' ,
            'caret-up' ,
            'angle-double-up' ,
            'angle-up' ,
            'chevron-circle-up' ,
            'long-arrow-up' ,
            'arrow-circle-o-up' ,

            'chevron-down' ,
            'arrow-down' ,
            'hand-o-down' ,
            'arrow-circle-down' ,
            'caret-down' ,
            'angle-double-down' ,
            'angle-down' ,
            'chevron-circle-down' ,
            'long-arrow-down' ,
            'arrow-circle-o-down' ,

        );

        $arrow_icons_options = array();

        $arrow_icons_options[''] = __( 'Custom' , "stars-menu" );

        foreach ( $arrow_icons AS $icon ){

            $icon = 'Font Awesome_####_' . $icon;

            $icon_classes = LA_IconManager::getIconClass($icon);

            $arrow_icons_options[$icon] = '<i class="'. esc_attr( $icon_classes ) .'"></i>';

        }

        $sizes = stmenu_get_image_sizes();

        $sizes_choices = array(  );

        foreach( $sizes AS $size => $options ){

            $label = $options['label'];

            if( isset( $options['width'] ) )
                $label .= ' - ' . $options['width'] . ' X ';

            if( isset( $options['height'] ) )
                $label .= $options['height'];

            $sizes_choices[$size] = $label;
        }

		$options = array(

            array(
                'name'          => __( 'Menu Design & Order' , "stars-menu" ),
                'id'            => 'theme_menu_design_order_layouts',
                'type'          => 'menu-design',
                'default'       => serialize(array(

                    array(
                        'id'                =>  'main-navigation' ,
                        'order'             =>  0 ,
                        'area'              =>  'sortable-center', //right,left
                        'show_in_sticky'    => true
                    ),

                    array(
                        'id'                =>  'hamburger-mode' ,
                        'order'             =>  0 ,
                        'area'              =>  'sortable-right', //right,left
                        'show_in_sticky'    => true
                    )

                )),
                //'desc'          => 'Enable or disable our X feature',
                //'tab'           => 'sticky'
            ) ,

        );

        require_once dirname( __FILE__ ) . "/theme-settings/base.php";

        require_once dirname( __FILE__ ) . "/theme-settings/menu-bar.php";

        require_once dirname( __FILE__ ) . "/theme-settings/top-level-items.php";

        require_once dirname( __FILE__ ) . "/theme-settings/hamburger-options.php";

        require_once dirname( __FILE__ ) . "/theme-settings/submenus.php";

        require_once dirname( __FILE__ ) . "/theme-settings/layout.php";

        require_once dirname( __FILE__ ) . "/theme-settings/descriptions.php";

        require_once dirname( __FILE__ ) . "/theme-settings/images.php";

        require_once dirname( __FILE__ ) . "/theme-settings/icons.php";

        require_once dirname( __FILE__ ) . "/theme-settings/mobile.php";

        require_once dirname( __FILE__ ) . "/theme-settings/miscellaneous.php";

        require_once dirname( __FILE__ ) . "/theme-settings/divider.php";

        require_once dirname( __FILE__ ) . "/theme-settings/advanced.php";

		$this->panel_options = apply_filters( 'stmenu-theme-settings-tab-options' , $options );

	}

}

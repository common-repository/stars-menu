<?php
/**
 * Stars Menu Logo Element class
 *
 * @package StarsMenu
 * @subpackage Elements
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Logo Element class
 *
 * Create Logo Element
 *
 * @Class StarsMenuGeneralSettings
 * @since 1.0.0
 */
class StarsMenuLogoElement {

    /**
     * Element Title
     *
     * @var object Instance Of StarsMenuElementsManager
     * @since 1.0
     */
    public $manager;

    /**
     * Element Title
     *
     * @var string
     * @since 1.0
     */
    public $title;

    /**
     * Element Id
     *
     * @var string
     * @since 1.0
     */
    public $id = 'stars-logo';

    /**
     * Element Wrapper Classes
     *
     * @var string
     * @since 1.0
     */
    public $classes = array();

    /**
     * StarsMenuGeneralSettings constructor.
     * @param $manager object instance of StarsMenuElementsManager
     */
	public function __construct( $manager ) {

        $this->manager = $manager;

        $this->title = __('Logo','stars-menu');

        add_filter( 'stmenu-theme-settings-tab-options' , array( $this , 'get_settings' ) , 10 , 1 );

	}

    public function get_template(){

        $show_in_sticky = stmenu_show_in_sticky( $this->id );

        $theme = StMenu()->current_theme;

        $this->classes = array_merge( $this->classes , array( 'starsmenu-logo-wrapper' , 'starsmenu-elitem-wrapper' , "starsmenu-elitem-{$this->id}" ) );

        if( $show_in_sticky === false ) {
            $this->classes[] = 'starsmenu-hide-in-sticky';
        }

        $logo_link_type = stmenu_theme_option( 'theme_logo_link_type' , $theme );

        $logo_link_target = stmenu_theme_option( 'theme_logo_link_target' , $theme );

        $logo_link_target = 'target="' . esc_attr($logo_link_target) . '"';

        $logo_link = "javascript:void(0)";

        switch ( $logo_link_type ){

            case "home":

                $logo_link = home_url();

                break;

            case "custom":

                $custom_link = stmenu_theme_option( 'theme_logo_custom_link' , $theme );

                $logo_link = empty( $custom_link ) ? "javascript:void(0)" : $custom_link;

                break;

            case "no-link":

                $logo_link_target = "";

                break;

        }

        $logo = $this->get_logo( $theme );

        $class_names = join( ' ', apply_filters( 'starsmenu_element_classes', array_filter( $this->classes ), $this->id ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $args = apply_filters( "stmenu_logo_element_template_args" , array(
            'class_names'       => $class_names ,
            'link'              => $logo_link ,
            'link_target'       => $logo_link_target ,
            'logo'              => $logo
        ) , $this );

        return stmenu_get_template_html( "modern-horizontal/element_logo.php" , $args );
        
    }

    public function get_logo( $theme ){

        $main_logo_id = (int)stmenu_theme_option( 'theme_main_logo' , $theme );

        $hamburger_mode_logo_id = (int)stmenu_theme_option( 'theme_hamburger_mode_logo' , $theme );

        $mobile_logo_id = (int)stmenu_theme_option( 'theme_mobile_logo' , $theme );

        $sticky_logo_id = (int)stmenu_theme_option( 'theme_sticky_logo' , $theme );

        $alt = stmenu_theme_option( 'theme_logo_alt' , $theme );

        $size = "full";

        $atts = array( "class" => "starsmenu-logo-image" );

        if( !empty( $alt ) ){
            $atts["alt"] = $alt;
        }

        $main_logo_atts = $atts;

        $main_logo_atts["class"] .= " starsmenu-main-logo";

        $main_logo = wp_get_attachment_image( $main_logo_id , $size , "" , $main_logo_atts );

        if( !empty( $main_logo ) ) {
            $this->classes[] = 'starsmenu-has-main-logo';
        }

        $hamburger_mode_atts = $atts;

        $hamburger_mode_atts["class"] .= " starsmenu-hamburger-mode-logo";

        $hamburger_mode_logo = wp_get_attachment_image( $hamburger_mode_logo_id , $size , "" , $hamburger_mode_atts );

        if( !empty( $hamburger_mode_logo ) ) {
            $this->classes[] = 'starsmenu-has-hamburger-mode-logo';
        }
        
        $mobile_logo_atts = $atts;

        $mobile_logo_atts["class"] .= " starsmenu-mobile-logo";

        $mobile_logo = wp_get_attachment_image( $mobile_logo_id , $size , "" , $mobile_logo_atts );

        if( !empty( $mobile_logo ) ) {
            $this->classes[] = 'starsmenu-has-mobile-logo';
        }

        $sticky_logo_atts = $atts;

        $sticky_logo_atts["class"] .= " starsmenu-sticky-logo-image";

        $sticky_logo = wp_get_attachment_image( $sticky_logo_id , $size , "" , $sticky_logo_atts );

        if( !empty( $sticky_logo ) ) {
            $this->classes[] = 'starsmenu-has-sticky-logo';
        }

        $logo = $main_logo . $hamburger_mode_logo . $mobile_logo . $sticky_logo;

        $logo = apply_filters( 'stmenu_logo_item_html' , $logo , $main_logo , $hamburger_mode_logo , $mobile_logo , $sticky_logo );

        return $logo;

    }

    public function get_settings( $theme_options ){

        $pro_version_msg = stmenu_pro_version_msg();

        $options = array(

            array(
                'name'                  => __( "Logo" , "stars-menu" ),
                'type'                  => 'heading' ,
                'tab'                   => 'logo'
            ),

            array(
                'name'          => __( 'Main Logo' , "stars-menu" ),
                'id'            => 'theme_main_logo',
                'type'          => 'upload',
                'default'       => '',
                'desc'          => __("This is the logo that will be displayed on your navigation bar. For best results, use a png." , "stars-menu" ),//'Enable or disable our X feature',
                'label'         => __( 'Choose Logo' , "stars-menu" ),
                'placeholder'   => __( 'Choose Image' , "stars-menu" ),
                'tab'           => 'logo'
            ) ,

            array(
                'name'          => __( "Logo Link" , "stars-menu" ),
                'id'            => 'theme_logo_link_type',
                'options'       => array(
                    'home'              => __( "Link To Home" , "stars-menu" )  ,
                    'custom'            => __( "Custom Link" , "stars-menu" )  ,
                    'no-link'           => __( "without Link" , "stars-menu" )  ,
                ),
                'type'          => 'radio',
                'desc'          => __( "It specifies the type of Logo Link. If you want your logo does not have any link, select the “Without Link” option, if you want to link an arbitrary address, select the “Custom Link” and then specify your desired link by using Logo “Custom Link” setting. Otherwise, your logo will be linked to main page of site by selecting the “Link To Home” option." , "stars-menu" ),
                'default'       => 'home',
                'tab'           => 'logo'
            ),

            array(
                'name'          => __( "Logo Custom Link" , "stars-menu" ),
                'id'            => 'theme_logo_custom_link',
                'type'          => 'text',
                'desc'          => __( "Set the custom hyperlink/url for your logo." , "stars-menu" ),
                'default'       => '',
                'tab'           => 'logo'
            ),

            array(
                'name'          => __( "Logo Link Target" , "stars-menu" ),
                'id'            => 'theme_logo_link_target',
                'options'       => array(
                    '_blank'           => __( "Open in new window" , "stars-menu" )  ,
                    '_self'            => __( "Open in same window" , "stars-menu" )  ,
                ),
                'type'          => 'radio',
                'desc'          => __( "Set the target for your logo url." , "stars-menu" ),
                'default'       => '_self',
                'tab'           => 'logo'
            ),

            array(
                'name'          => __( "Logo alt" , "stars-menu" ),
                'id'            => 'theme_logo_alt',
                'type'          => 'text',
                'desc'          => __( "Set alt attribute for the logo." , "stars-menu" ),
                'default'       => '',
                'tab'           => 'logo'
            ),

            array(
                'name'                  => __( 'Hamburger Mode Logo' , "stars-menu" ),
                'type'                  => 'note',
                'desc'                  => $pro_version_msg,
                'tab'                   => 'logo'
            ),

            array(
                'name'                  => __( 'Mobile Logo' , "stars-menu" ),
                'type'                  => 'note',
                'desc'                  => $pro_version_msg,
                'tab'                   => 'logo'
            ),

            array(
                'name'                  => __( "Logo Style Customizations" , "stars-menu" ),
                'type'                  => 'heading' ,
                'tab'                   => 'logo' ,
                'panel'                 => 'styling'
            ),

            array(
                'name'                  => __( "Logo Max Width" , "stars-menu" ),
                'id'                    => 'theme_style_stmenu_logo_max_width',
                'type'                  => 'text',
                'desc'                  => __( "This setting allows you to specify the maximum width of your Logo. also, its height will be changed with respect to this variation. So, it can be said that using this setting, you can specify the size of your Logo." , "stars-menu" ),
                'default'               => '200px',
                'validation'            => array( 'dimension' , 'require' ) ,
                'css_sanitize'          => array( 'require' ) ,
                'tab'                   => 'logo' ,//'style_customizations' ,
                'is_style_variable'     => true ,
                'panel'                 => 'styling'
            ),

            array(
                'name'                  => __( "Hamburger Bar Logo Max Width" , "stars-menu" ),
                'id'                    => 'theme_style_stmenu_hamburger_mode_logo_max_width',   
                'type'                  => 'text',
                'desc'                  => __( "This setting allows you to specify the maximum width of your Hamburger Bar Logo. also, its height will be changed with respect to this variation. So, it can be said that using this setting, you can specify the size of your Logo." , "stars-menu" ),
                'default'               => '200px',
                'validation'            => array( 'dimension' , 'require' ) ,
                'css_sanitize'          => array( 'require' ) ,
                'tab'                   => 'logo' ,//'style_customizations' ,
                'is_style_variable'     => true ,
                'panel'                 => 'styling'
            ),

            array(
                'name'                  => __( "Mobile Logo Max Width" , "stars-menu" ),
                'id'                    => 'theme_style_stmenu_mobile_logo_max_width',
                'type'                  => 'text',
                'desc'                  => __( "This setting allows you to specify the maximum width of your Mobile Logo. also, its height will be changed with respect to this variation. So, it can be said that using this setting, you can specify the size of your Logo." , "stars-menu" ),
                'default'               => '200px',
                'validation'            => array( 'dimension' , 'require' ) ,
                'css_sanitize'          => array( 'require' ) ,
                'tab'                   => 'logo' ,//'style_customizations' ,
                'is_style_variable'     => true ,
                'panel'                 => 'styling'
            ),

            array(
                'name'                  => __( "Logo Spacing" , "stars-menu" ),
                'id'                    => 'theme_style_stmenu_logo_padding',
                'type'                  => 'multi-text',
                'desc'                  => __( "It specifies the left, right, top and bottom spaces of your logo with respect to menu bar." , "stars-menu" ),
                'options'               => array(
                    'top'                   => __( "Top" , "stars-menu" )  ,
                    'right'                 => __( "Right" , "stars-menu" )  ,
                    'bottom'                => __( "Bottom" , "stars-menu" ) ,
                    'left'                  => __( "Left" , "stars-menu" )
                ),
                'default'               => array(
                    'top'                   => 0  ,
                    'right'                 => 0  ,
                    'bottom'                => 0 ,
                    'left'                  => 0
                ),
                'css_sanitize'          => array( 'spacing' ) ,
                'tab'                   => 'logo' ,
                'is_style_variable'     => true ,
                'panel'                 => 'styling'
            ),

        );

        return array_merge( $theme_options , $options );

    }


}

$this->register_element( 'stars-logo' , 'StarsMenuLogoElement' );

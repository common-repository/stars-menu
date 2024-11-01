<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$pro_version_msg = stmenu_pro_version_msg();

$hamburger_options = array(

    array(
        'name'          => __( "Hamburger Options" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'hamburger'
    ),

    array(
        'name'          => __( 'Hamburger Icon Animation' , "stars-menu" ),
        'type'          => 'note',
        'desc'          => $pro_version_msg,
        'tab'           => 'hamburger'
    ),

    array(
        'name'          => __( "Trigger" , "stars-menu" ),
        'id'            => 'theme_hamburger_opened_trigger',
        'options'       => array(
            'click'           => __( "Click" , "stars-menu" ),
            'hover'           => __( "Hover" , "stars-menu" ),
        ),
        'type'          => 'radio',
        'desc'          => __( "Open the Hamburger Bar via this trigger" , "stars-menu" ),
        'default'       => 'click',
        'tab'           => 'hamburger'
    ),

    array(
        'name'          => __( 'Hamburger Mode Animation' , "stars-menu" ),
        'type'          => 'note',
        'desc'          => $pro_version_msg,
        'tab'           => 'hamburger'
    ),

    array(
        'name'          => __( 'Enable Background For Hamburger Bar?' , "stars-menu" ),
        'id'            => 'theme_hamburger_background_enable',
        'type'          => 'enable',
        'default'       => true,
        'desc'          => __( 'Enable or Disable background for Hamburger Bar' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'hamburger'
    ) ,

    array(
        'name'          => __( 'Background Animation' , "stars-menu" ),
        'type'          => 'note',
        'desc'          => $pro_version_msg,
        'tab'           => 'hamburger'
    ),

    array(
        'name'                  => __( "Hamburger Bar Close Hover Delay" , "stars-menu" ),
        'id'                    => 'theme_hamburger_menu_close_hover_delay',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the delay amount of Hamburger Bar when the mouse is completely away from the menu (this setting is applied when the opening Trigger of Hamburger Bar is Hover)." , "stars-menu" ),
        'default'               => 200,
        'tab'                   => 'hamburger'
    ),

    array(
        'name'                  => __( "Hamburger Bar Style" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'hamburger' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_bar_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the hamburger bar." , "stars-menu" ),
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_bar_color',
        'type'                  => 'color',
        'desc'                  => __( "The text color for the top level main items on hamburger bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Hamburger Icon Style" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'hamburger' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Hamburger Icon Width' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'hamburger' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Hamburger Icon Height' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'hamburger' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Hamburger Icon Bar Height' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'hamburger' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Hamburger Icon Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_icon_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for hamburger icon." , "stars-menu" ),
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Hamburger Icon Color In Sticky Menu" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_sticky_hamburger_icon_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for hamburger icon in the sticky menu." , "stars-menu" ),
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Hamburger Icon Color In Open Hamburger Bar" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_bar_hamburger_icon_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for hamburger icon in the Hamburger Bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Hamburger Icon Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_icon_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "It specifies the left, right, top and bottom spaces of Hamburger Icon with respect to menu bar." , "stars-menu" ),
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
        'tab'                   => 'hamburger' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'//'style_customizations' ,
        //'is_style_variable'     => true
    ),

);

$options = array_merge( $options , $hamburger_options );



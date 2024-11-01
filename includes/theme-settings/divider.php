<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$divider_options = array(

    array(
        'name'          => __( "Divider" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'divider'
    ),

    array(
        'name'          => __( 'Enable Divider For Elements?' , "stars-menu" ),
        'id'            => 'theme_elements_divider_enable',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Enable or disable divider for elements' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'divider'
    ) ,

    array(
        'name'          => __( 'Enable Divider For Mobile Menu Items?' , "stars-menu" ),
        'id'            => 'theme_mobile_menu_divider_enable',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Enable or disable divider for mobile menu items' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'divider'
    ) ,

    array(
        'name'          => __( 'Enable Divider For Top Level Items?' , "stars-menu" ),
        'id'            => 'theme_top_level_items_divider_enable',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Enable or disable divider for top level menu items' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'divider'
    ) ,

    array(
        'name'          => __( 'Enable Divider For Submenus Items?' , "stars-menu" ),
        'id'            => 'theme_submenus_items_divider_enable',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Enable or disable divider for submenus items' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'divider'
    ) ,

    array(
        'name'                  => __( "Elements Divider" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'divider' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_element_divider_width',
        'type'                  => 'text',
        'desc'                  => __( "This will set width for your Elements Divider" , "stars-menu" ),
        'default'               => '1px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_element_divider_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set height for your Elements Divider" , "stars-menu" ),
        'default'               => '25px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_element_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of Elements Divider" , "stars-menu" ),
        'default'               => '#dddddd',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Corners Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_element_divider_radius',
        'type'                  => 'text',
        'desc'                  => __( "This will allow you to add rounded corners to your Elements Divider" , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Between Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_element_spacing',
        'type'                  => 'text',
        'desc'                  => __( "You can specify the space between elements on the menu bar by using this setting." , "stars-menu" ),
        'default'               => '0px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Color on Sticky" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_sticky_element_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of Elements Divider on sticky menu" , "stars-menu" ),
        'default'               => '#dddddd',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Elements Divider Color on Hamburger Bar" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_bar_element_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of Elements Divider on Hamburger Bar" , "stars-menu" ),
        'default'               => 'rgba(255, 255, 255, 0.3)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Items Divider" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'divider' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Items Divider Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_divider_width',
        'type'                  => 'text',
        'desc'                  => __( "This will set width for your Items Divider on mobile menu" , "stars-menu" ),
        'default'               => '100%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Items Divider Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_divider_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set height for your Items Divider on mobile menu" , "stars-menu" ),
        'default'               => '1px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Items Divider Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of Items Divider on mobile menu" , "stars-menu" ),
        'default'               => 'rgba(255,255,255,0.1)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Top Level Menu Items Divider" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'divider' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_divider_width',
        'type'                  => 'text',
        'desc'                  => __( "This will set width for your top level menu items Divider" , "stars-menu" ),
        'default'               => '1px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_divider_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set height for your top level menu items Divider" , "stars-menu" ),
        'default'               => '25px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of top level menu items Divider" , "stars-menu" ),
        'default'               => '#dddddd',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Corners Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_divider_radius',
        'type'                  => 'text',
        'desc'                  => __( "This will allow you to add rounded corners to your top level menu items divider" , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Color on Sticky" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_sticky_item_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of top level menu items divider on sticky menu" , "stars-menu" ),
        'default'               => '#dddddd',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Color on Hamburger Bar" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_hamburger_bar_item_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of top level menu items divider on Hamburger Bar" , "stars-menu" ),
        'default'               => 'rgba(255, 255, 255, 0.3)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Items Divider" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'divider' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_divider_width',
        'type'                  => 'text',
        'desc'                  => __( "This will set width for your submenus items Divider" , "stars-menu" ),
        'default'               => '100%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_divider_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set height for your submenus items Divider" , "stars-menu" ),
        'default'               => '1px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Divider Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_divider_color',
        'type'                  => 'color',
        'desc'                  => __( "The color of submenus items Divider" , "stars-menu" ),
        'default'               => '#dddddd',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'divider' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

);

$options = array_merge( $options , $divider_options );

<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$descriptions_options = array(

    array(
        'name'          => __( "Description" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'descriptions'
    ),

    array(
        'name'          => __( 'Top Level Descriptions' , "stars-menu" ),
        'id'            => 'theme_top_level_descriptions',
        'type'          => 'enable',
        'default'       => true,
        'desc'          => __( 'Allow descriptions on top level menu items.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'descriptions'
    ) ,

    array(
        'name'          => __( 'Normal Items Descriptions' , "stars-menu" ),
        'id'            => 'theme_normal_items_descriptions',
        'type'          => 'enable',
        'default'       => true,
        'desc'          => __( 'Allow descriptions on normal menu items.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'descriptions'
    ) ,

    array(
        'name'          => __( 'Show Items Descriptions On Mobile' , "stars-menu" ),
        'id'            => 'theme_items_descriptions_mobile',
        'type'          => 'enable',
        'default'       => true,
        'desc'          => __( 'Allow descriptions on mobile menu items.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'descriptions'
    ) ,

    array(
        'name'                  => __( "Descriptions Styles" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'descriptions' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Top Level Descriptions Font Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_desc_font_size',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => '85%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'descriptions' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Top Level Descriptions Opacity" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_desc_opacity',
        'type'                  => 'number',
        'desc'                  => __( "This will set transparency for top level menu items Descriptions" , "stars-menu" ),
        'default'               => '0.7',
        'validation'            => array( 'float' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'descriptions' ,
        'min'                   => 0 ,
        'max'                   => 1 ,
        'step'                  => 0.01 ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Top Level Descriptions Text Transform" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_desc_text_tform',
        'type'                  => 'select',
        'desc'                  => __( "This will control the capitalization of top level menu items Descriptions." , "stars-menu" ),
        'default'               => "none",
        'options'               => array(
            'none'                  => __('None', 'stars-menu'),
            'capitalize'            => __('Capitalize', 'stars-menu') ,
            'uppercase'             => __('Uppercase', 'stars-menu'),
            'lowercase'             => __('Lowercase', 'stars-menu') ,
        ),
        'tab'                   => 'descriptions' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),


    array(
        'name'                  => __( "Normal Items Descriptions Font Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_desc_font_size',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => '85%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'descriptions' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Normal Items Descriptions Opacity" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_desc_opacity',
        'type'                  => 'number',
        'desc'                  => __( "This will set transparency for normal menu items Descriptions" , "stars-menu" ),
        'default'               => '0.7',
        'validation'            => array( 'float' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'descriptions' ,
        'min'                   => 0 ,
        'max'                   => 1 ,
        'step'                  => 0.01 ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Normal Items Descriptions Text Transform" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_desc_text_tform',
        'type'                  => 'select',
        'desc'                  => __( "This will control the capitalization of normal menu items Descriptions." , "stars-menu" ),
        'default'               => "none",
        'options'               => array(
            'none'                  => __('None', 'stars-menu'),
            'capitalize'            => __('Capitalize', 'stars-menu') ,
            'uppercase'             => __('Uppercase', 'stars-menu'),
            'lowercase'             => __('Lowercase', 'stars-menu') ,
        ),
        'tab'                   => 'descriptions' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

);

$options = array_merge( $options , $descriptions_options );



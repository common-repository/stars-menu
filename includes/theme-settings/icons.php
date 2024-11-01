<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$icons_options = array(

    array(
        'name'                  => __( "Icons" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'icons'
    ),

    array(
        'name'                  => __( "Top Level Icons Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_icon_font_size',
        'type'                  => 'text',
        'desc'                  => __( "The Size of icons for Top Level Menu Items" , "stars-menu" ),
        'default'               => '20px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'icons' ,
        'is_style_variable'     => true
    ),

    array(
        'name'                  => __( "Submenus Icons Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_icon_font_size',
        'type'                  => 'text',
        'desc'                  => __( "The Size of icons for submenus Items." , "stars-menu" ),
        'default'               => '20px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'icons' ,
        'is_style_variable'     => true
    ),

    /*array(
        'name'          => __( "Top Level Icons Color" , "stars-menu" ),
        'id'            => 'theme_top_level_icons_color',
        'type'          => 'color',
        'desc'          => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'       => '',
        'tab'           => 'icons' ,
        'css'           => '#newtest{ color : value; }'
    ),

    array(
        'name'          => __( "Submenus Icons Color" , "stars-menu" ),
        'id'            => 'theme_submenus_icons_color',
        'type'          => 'color',
        'desc'          => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'       => '',
        'tab'           => 'icons'
    ),*/

    array(
        'name'          => __( "Icons Tag" , "stars-menu" ),
        'id'            => 'theme_icons_tag',
        'options'       => array(
            'i'                 => "&lt;i&gt;" ,
            'span'              => "&lt;span&gt;" ,
        ),
        'type'          => 'radio',
        'desc'          => __( "The HTML tag to use for the icons." , "stars-menu" ),
        'default'       => 'i',
        'tab'           => 'icons'
    ),

    array(
        'name'                  => __( "Icons Style" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'icons' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Icon Spacing From Text" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_spacing_text_icon',
        'type'                  => 'text',
        'desc'                  => __( "If the type of your item layout were 'Text & Icon', using this setting you can control the space between text and image (this setting is only used for Top Level Menu Items)." , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'icons' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Icon Spacing From Text In Submenus" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_spacing_text_icon',
        'type'                  => 'text',
        'desc'                  => __( "If the type of your item layout were 'Text & Icon', using this setting you can control the space between text and image (this setting is only used for submenus Items)." , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'icons' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

);

$options = array_merge( $options , $icons_options );



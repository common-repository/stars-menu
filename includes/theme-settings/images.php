<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$images_options = array(

    array(
        'name'          => __( "Images" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'images'
    ),

    array(
        'name'          => __( "Images Size" , "stars-menu" ),
        'id'            => 'theme_images_size',
        'options'       => $sizes_choices,
        'type'          => 'select',
        'desc'          => __( "Image sizes can be overridden on individual menu items" , "stars-menu" ),
        'default'       => 'full',
        'tab'           => 'images'
    ),

    array(
        'name'          => __( 'Set Image Dimensions' , "stars-menu" ),
        'id'            => 'theme_image_dimensions',
        'type'          => 'enable',
        'default'       => true,
        'desc'          => __( 'Set the actual width and height attributes on an image if none are set manually.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'images'
    ) ,

    array(
        'name'          => __( "Image Width" , "stars-menu" ),
        'id'            => 'theme_image_width',
        'type'          => 'text',
        'desc'          => __( "The width attribute value for menu item images in pixels. Do not include units. Leave blank to use actual dimensions." , "stars-menu" ),
        'default'       => '',
        'tab'           => 'images'
    ),

    array(
        'name'          => __( "Image Height" , "stars-menu" ),
        'id'            => 'theme_image_height',
        'type'          => 'text',
        'desc'          => __( "The height attribute value for menu item images in pixels. Do not include units. Leave blank to use actual dimensions." , "stars-menu" ),
        'default'       => '',
        'tab'           => 'images'
    ),

    array(
        'name'          => __( 'Use Image Title Attribute' , "stars-menu" ),
        'id'            => 'theme_image_title_attr',
        'type'          => 'enable',
        'default'       => false,
        //'desc'          => __( 'Set the actual width and height attributes on an image if none are set manually.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'images'
    ) ,

    array(
        'name'          => __( 'Disable Images on Mobile' , "stars-menu" ),
        'id'            => 'theme_disable_mobile_images',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Detected via wp_is_mobile() - be aware if you set up caching, it would need to handle mobile device detection for this to work.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'images'
    ) ,

    array(
        'name'                  => __( "Images Style" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'images' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Image Spacing From Text" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_spacing_text_image',
        'type'                  => 'text',
        'desc'                  => __( "If the type of your item layout were 'Text & Image', using this setting you can control the space between text and image (this setting is only used for Top Level Menu Items)." , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'images' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Image Spacing From Text In Submenus" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_spacing_text_image',
        'type'                  => 'text',
        'desc'                  => __( "If the type of your item layout were 'Text & Image', using this setting you can control the space between text and image (this setting is only used for submenus Items)" , "stars-menu" ),
        'default'               => '10px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'images' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

);

$options = array_merge( $options , $images_options );



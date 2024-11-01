<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$layout_options = array(

    array(
        'name'          => __( "Position & Layout" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Top Level Items Layout" , "stars-menu" ),
        'id'            => 'theme_items_layout_top_level',
        'options'       => array(
            'text'              => __( "Text Only" , "stars-menu" ) ,
            'text-image'        => __( "Text & Image" , "stars-menu" )  ,
            'text-icon'         => __( "Text & Icon" , "stars-menu" )  ,
            'icon'              => __( "Icon Only" , "stars-menu" )  ,
            'image'             => __( "Image Only" , "stars-menu" )  ,
        ),
        'type'          => 'radio',
        'desc'          => __( "It specifies the content type of the Top Level Menu Items and also the Layout Text includes the title and description of menu items (it they are existent or not hidden)." , "stars-menu" ),
        'default'       => 'text',
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Icons & Images Position For Top Level" , "stars-menu" ),
        'id'            => 'theme_icons_images_layout_top_level',
        'options'       => array(
            'above'             => __( "Above" , "stars-menu" ) ,
            'below'             => __( "Below" , "stars-menu" )  ,
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "It is used to specify the icons and images positions in the Top Level Menu Items." , "stars-menu" ),
        'default'       => 'left',
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Top Level Items Content Alignment" , "stars-menu" ),
        'id'            => 'theme_items_alignment_top_level',
        'options'       => array(
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )  ,
            'center'            => __( "Center" , "stars-menu" )  ,
        ),
        'type'          => 'radio',
        'desc'          => __( "It is used to specify the content Alignment of the Top Level Menu Items." , "stars-menu" ),
        'default'       => 'left',
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Normal Items Layout" , "stars-menu" ),
        'id'            => 'theme_items_layout_submenus',
        'options'       => array(
            'text'              => __( "Text Only" , "stars-menu" ) ,
            'text-image'        => __( "Text & Image" , "stars-menu" )  ,
            'text-icon'         => __( "Text & Icon" , "stars-menu" )  ,
            'icon'              => __( "Icon Only" , "stars-menu" )  ,
            'image'             => __( "Image Only" , "stars-menu" )  ,
        ),
        'type'          => 'radio',
        'desc'          => __( "It specifies the content type of the Normal Items and also the Layout Text includes the title and description of menu items (it they are existent or not hidden)." , "stars-menu" ),
        'default'       => 'text',
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Icons & Images Position For Normal Items" , "stars-menu" ),
        'id'            => 'theme_icons_images_layout_submenus',
        'options'       => array(
            'above'             => __( "Above" , "stars-menu" ) ,
            'below'             => __( "Below" , "stars-menu" )  ,
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "It is used to specify the icons and images positions in the Normal Menu Items." , "stars-menu" ),
        'default'       => 'left',
        'tab'           => 'position'
    ),

    array(
        'name'          => __( "Normal Items Content Alignment" , "stars-menu" ),
        'id'            => 'theme_items_alignment_submenus',
        'options'       => array(
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )  ,
            'center'            => __( "Center" , "stars-menu" )  ,
        ),
        'type'          => 'radio',
        'desc'          => __( "It is used to specify the content Alignment of the Top Level Menu Items." , "stars-menu" ),
        'default'       => 'left',
        'tab'           => 'position'
    )

);


$options = array_merge( $options , $layout_options );



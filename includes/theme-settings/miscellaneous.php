<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$misc_options = array(

    array(
        'name'                  => __( "Miscellaneous" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'misc'
    ),

    array(
        'name'          => __( "Container Tag" , "stars-menu" ),
        'id'            => 'theme_container_tag',
        'options'       => array(
            'nav'           => "&lt;nav&gt;" ,
            'div'           => "&lt;div&gt;" ,
        ),
        'type'          => 'radio',
        'desc'          => __( "The tag that wraps the entire menu. Switch to div for non-HTML5 sites." , "stars-menu" ),
        'default'       => 'nav',
        'tab'           => 'misc'
    ),

    array(
        'name'          => __( 'Allow Shortcodes in Navigation Label & Description' , "stars-menu" ),
        'id'            => 'theme_item_allow_shortcodes_label_desc',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'Enable to process shortcodes in the menu item Navigation Label and Description settings.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'misc'
    ) ,

    array(
        'name'          => __( 'Content Before Menu' , "stars-menu" ),
        'id'            => 'theme_content_before_menu',
        'type'          => 'editor',
        'default'       => '',
        'desc'          => __( 'Add HTML or shortcodes here to insert content before the start of the menu.' , "stars-menu" ),
        'tab'           => 'misc'
    ) ,

    array(
        'name'          => __( 'Content After Menu' , "stars-menu" ),
        'id'            => 'theme_content_after_menu',
        'type'          => 'editor',
        'default'       => '',
        'desc'          => __( 'Add HTML or shortcodes here to insert content after the end of the menu.' , "stars-menu" ),
        'tab'           => 'misc'
    ) ,

);

$options = array_merge( $options , $misc_options );


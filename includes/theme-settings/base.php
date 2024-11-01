<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$pro_version_msg = stmenu_pro_version_msg();

$basic_options = array(

    array(
        'name'          => __( "Basic Configuration" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( "Menu Design" , "stars-menu" ),
        'id'            => 'theme_design',
        'options'       => array(
            'modern-horizontal'     => __( "Modern Horizontal" , "stars-menu" ),
            'side_panel'            => __( "Side Panel" , "stars-menu" ),
            'megamenu'              => __( "Mega Menu" , "stars-menu" ),
            'fullscreen'            => __( "Full Screen" , "stars-menu" ),
        ),
        'type'          => 'radio',
        'desc'          => __( "type of menu design" , "stars-menu" ),
        'default'       => 'modern-horizontal',
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( "Horizontal Menu Type" , "stars-menu" ),
        'id'            => 'theme_horizontal_type',
        'options'       => array(
            'normal'            => __( "Normal" , "stars-menu" ),
            'hamburger'         => __( "Hamburger Menu" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "This setting specify the type of horizontal menu which could be normal or  hamburger menu" , "stars-menu" ),
        'default'       => 'hamburger',
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( 'Hover Animation Type For Top Level' , "stars-menu" ),
        'type'          => 'note',
        'desc'          => $pro_version_msg,
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( 'Top Level Full Height' , "stars-menu" ),
        'id'            => 'theme_top_level_full_height',
        'type'          => 'enable',
        'default'       => false,
        'desc'          => __( 'This setting allows you to set the height of top level menu items equal to menu bar height. In other words, the height of top level menu items will be full.' , "stars-menu" ),
        'enabled'       => __( 'ON' , "stars-menu" ),
        'disabled'      => __( 'OFF' , "stars-menu" ),
        'tab'           => 'basic'
    ) ,

    array(
        'name'          => __('Scroll Animate For Anchor : ', 'stars-menu'),
        'id'            => 'theme_scroll_animate_anchor',
        'type'          => 'select',
        'desc'          => __('This feature allows you to specify the type of animation for scrolls. (The type of scroll animation when Anchor is clicked.) ', 'stars-menu'),
        'default'       => 'easeInOutQuint' ,
        'options'       => array(
            ''                      => __('without using animate', 'stars-menu'),
            'easeInOutQuint'        => __('easeInOutQuint ', 'stars-menu'),
            'easeOutQuad'           => __('easeOutQuad', 'stars-menu'),
            'swing'                 => __('swing ', 'stars-menu'),
            'easeInQuad'            => __('easeInQuad', 'stars-menu'),
            'easeInOutQuad'         => __('easeInOutQuad', 'stars-menu'),
            'easeInCubic'           => __('easeInCubic', 'stars-menu'),
            'easeOutCubic'          => __('easeOutCubic', 'stars-menu'),
            'easeInOutCubic'        => __('easeInOutCubic', 'stars-menu'),
            'easeInQuart'           => __('easeInQuart', 'stars-menu'),
            'easeOutQuart'          => __('easeOutQuart ', 'stars-menu'),
            'easeInOutQuart'        => __('easeInOutQuart', 'stars-menu'),
            'easeInQuint'           => __('easeInQuint ', 'stars-menu'),
            'easeOutQuint'          => __('easeOutQuint', 'stars-menu'),
            'easeInSine'            => __('easeInSine', 'stars-menu'),
            'easeOutSine'           => __('easeOutSine', 'stars-menu'),
            'easeInOutSine'         => __('easeInOutSine', 'stars-menu'),
            'easeInExpo'            => __('easeInExpo', 'stars-menu'),
            'easeOutExpo'           => __('easeOutExpo', 'stars-menu'),
            'easeInOutExpo'         => __('easeInOutExpo', 'stars-menu'),
            'easeInCirc'            => __('easeInCirc', 'stars-menu'),
            'easeOutCirc'           => __('easeOutCirc ', 'stars-menu'),
            'easeInOutCirc'         => __('easeInOutCirc', 'stars-menu'),
            'easeInElastic'         => __('easeInElastic', 'stars-menu'),
            'easeOutElastic'        => __('easeOutElastic', 'stars-menu'),
            'easeInOutElastic'      => __('easeInOutElastic', 'stars-menu'),
            'easeInBack'            => __('easeInBack', 'stars-menu'),
            'easeOutBack'           => __('easeOutBack', 'stars-menu'),
            'easeInOutBack'         => __('easeInOutBack', 'stars-menu'),
            'easeInBounce'          => __('easeInBounce', 'stars-menu'),
            'easeOutBounce'         => __('easeOutBounce', 'stars-menu'),
            'easeInOutBounce'       => __('easeInOutBounce ', 'stars-menu'),
        ),
        'tab'           => 'basic'

    ),

    array(
        'name'          => __( "scroll Animate Duration" , "stars-menu" ),
        'id'            => 'theme_scroll_animate_duration',
        'type'          => 'text',
        'desc'          => __( "This feature allows you to specify the time it takes to, after clicking the Anchors, scroll move as animated to reach the target." , "stars-menu" ),
        'default'       => 2000,
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( "Arrows" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'basic'
    ),

    array(
        'name'          => __( 'Select Items Arrow' , "stars-menu" ),
        'id'            => 'theme_items_arrow',
        'type'          => 'icon',
        'desc'          => __( "It selects Arrow for items which have submenus (for Parent Items). Top Level Menu Items does not support Arrow on the desktop in version 1.0.0" , "stars-menu" ),
        'default'       => 'starsmenu-icon_####_right-chevron',
        'tab'           => 'basic'
    ) ,

    array(
        'name'          => __( 'Select Back Items Arrow' , "stars-menu" ),
        'id'            => 'theme_back_items_arrow',
        'type'          => 'icon',
        'desc'          => __( "Select Arrow for Back Items (all submenus except Top Level Menu submenus on the desktop, at the top of submenus have an item to return to previous submenu)." , "stars-menu" ),
        'default'       => 'starsmenu-icon_####_backward-arrow',
        'tab'           => 'basic'
    ) ,
);

$options = array_merge( $options , $basic_options );

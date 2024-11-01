<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$menu_bar_options = array(

    array(
        'name'                  => __( "Menu Bar" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling' // Equal array( 'settings' , 'styling' ) Equal array( 'styling' )
    ),

    array(
        'name'                  => __( "Menu bar Length" , "stars-menu" ),
        'id'                    => 'theme_style_menubar_dimensions',
        'options'               => array(
            'full'                  => __( "Full Width" , "stars-menu" )  ,
            'fixed'                 => __( "Fixed Width" , "stars-menu" )
        ),
        'type'                  => 'radio',
        'desc'                  => __( "Choose between a menu bar that runs the full width of the screen, or at a fixed width. (Bound by theme container)" , "stars-menu" ),
        'default'               => 'full',
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling' // Equal array( 'settings' , 'styling' ) Equal array( 'styling' )
    ),

    array(
        'name'                  => __( "Menu bar Width" , "stars-menu" ),
        'id'                    => 'theme_style_menubar_width',
        'type'                  => 'text',
        'desc'                  => __( "This setting will be applied when the “Fixed Width” option is selected in the “Menu Bar Length” setting. So, you can specify a constant Width for your menu bar." , "stars-menu" ),
        'default'               => '1200px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Content Length" , "stars-menu" ),
        'id'                    => 'theme_style_navigation_length',
        'options'               => array(
            'full'                  => __( "Full Width" , "stars-menu" )  ,
            'fixed'                 => __( "Fixed Width" , "stars-menu" )
        ),
        'type'                  => 'radio',
        'desc'                  => 'Choose between menu bar elements (Content) that runs the full width of the menu bar, or a fixed width in the centre of the menu bar.' ,
        'default'               => 'full',
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Content width" , "stars-menu" ),
        'id'                    => 'theme_style_navigation_width',
        'type'                  => 'text',
        'desc'                  => __( "This setting will be applied when the “Fixed Width” option is selected in the “Menu Bar Content Length” setting. So, you can specify a constant Width for your menu bar elements (Content)." , "stars-menu" ),
        'default'               => '1100px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Line Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_line_height',
        'type'                  => 'text',
        'desc'                  => __( "By using this setting, you can control the height of menu bar." , "stars-menu" ),
        'default'               => '60px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Z Index" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_zindex',
        'type'                  => 'text',
        'desc'                  => __( "Set the z-index to ensure the menu panels appear on top of other content." , "stars-menu" ),
        'default'               => 100,
        'validation'            => array( 'int' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the main menu bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar'  ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Image" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_image',
        'type'                  => 'upload',
        'desc'                  => __( "This will add a background image to your main menu bar." , "stars-menu" ),
        'default'               => '',
        'css_sanitize'          => array( 'attachment' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Repeat Background Image" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_repeat',
        'options'               => array(
            'no-repeat'             => __( "No Repeat" , "stars-menu" )  ,
            'repeat'                => __( "Repeat" , "stars-menu" ) ,
            'repeat-x'              => __( "Repeat X (Horizontal)" , "stars-menu" ) ,
            'repeat-y'              => __( "Repeat Y (Vertical)" , "stars-menu" ) ,
            'space'                 => __( "Space" , "stars-menu" ) ,
            'round'                 => __( "Round" , "stars-menu" ) ,
        ),
        'type'                  => 'select',
        'desc'                  => __( "Set the repeat for your main menu bar background image." , "stars-menu" ),
        'default'               => 'no-repeat',
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Attachment" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_attachment',
        'options'               => array(
            'scroll'                => __( "Scroll" , "stars-menu" )  ,
            'fixed'                 => __( "Fixed" , "stars-menu" ) ,
        ),
        'type'                  => 'select',
        'desc'                  => __( "This will set whether menu bar background image is fixed or scrolls with the rest of the page." , "stars-menu" ),
        'default'               => 'scroll',
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Position" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_position',
        'type'                  => 'text',
        'desc'                  => __( "Set the position for your main menu bar background image." , "stars-menu" ),
        'default'               => 'center center',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_bg_size',
        'type'                  => 'text',
        'desc'                  => __( 'Try "cover" to cover the entire your main menu bar.' , "stars-menu" ),
        'default'               => 'cover',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_border_color',
        'type'                  => 'color',
        'desc'                  => __( "The Border Color for the main menu bar." , "stars-menu" ),
        'default'               => 'transparent',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Border Style" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_border_style',
        'options'               => array(
            'none'                  => __( "None" , "stars-menu" )  ,
            'dotted'                => __( "dotted" , "stars-menu" )  ,
            'dashed'                => __( "dashed" , "stars-menu" ) ,
            'solid'                 => __( "solid" , "stars-menu" ) ,
            'double'                => __( "double" , "stars-menu" ) ,
            'groove'                => __( "groove" , "stars-menu" ) ,
            'ridge'                 => __( "ridge" , "stars-menu" ) ,
            'inset'                 => __( "inset" , "stars-menu" ) ,
            'outset'                => __( "outset" , "stars-menu" ) ,
        ),
        'type'                  => 'select',
        'desc'                  => __( "The Border Style for the main menu bar." , "stars-menu" ),
        'default'               => 'none',
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_border_width',
        'type'                  => 'multi-text',
        'desc'                  => __( "Using this setting you can specify the border size for four sides of menu bar (right, left, top and bottom). if you want some sides don’t include borders, you should set their sizes to 0 value." , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => 0 ,
            'right'                 => 0 ,
            'bottom'                => 0 ,
            'left'                  => 0
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Border Radius" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_radius',
        'type'                  => 'multi-text',
        'desc'                  => __( " If you are using backgrounds on your main menu bar, you can round the corners with this setting." , "stars-menu" ),
        'options'               => array(
            'tl'                    => __( "Top Left" , "stars-menu" )  ,
            'tr'                    => __( "Top Right" , "stars-menu" )  ,
            'br'                    => __( "Bottom Right" , "stars-menu" ) ,
            'bl'                    => __( "Bottom Left" , "stars-menu" )
        ),
        'default'               => array(
            'tl'                    => 0  ,
            'tr'                    => 0  ,
            'br'                    => 0 ,
            'bl'                    => 0
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will allow you to add padding to your main menu bar" , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => 0  ,
            'right'                 => '10px'  ,
            'bottom'                => 0 ,
            'left'                  => '10px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Bar Margin" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_wrap_margin',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will allow you to add margin to your main menu bar" , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => 0  ,
            'right'                 => 'auto'  ,
            'bottom'                => 0 ,
            'left'                  => 'auto'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Font" , "stars-menu" ),
        'id'                    => 'theme_style_menubar_font',
        'type'                  => 'font',
        'desc'                  => __( "It allows you to change font settings for total menu by default." , "stars-menu" ),
        'default'               => array('font-size' => '14px'),
        'show_line_height'      => false ,
        'show_color'            => false ,
        //'validation'            => array( 'require' ) ,
        //'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'menu-bar' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Menu Bar Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_wrap_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your main menu bar. (Not supported in older browsers)" , "stars-menu" ),
        'default'       => array(
            'enable'            => 'off',
            'horizontal'        => 0,
            'vertical'          => 0,
            'blur'              => 0,
            'spread'            => 0,
            'color'             => 'rgba(0, 0, 0, 0.1)',
        ),
        'validation'            => array( 'dimension' ) ,
        'css_sanitize'          => array( 'shadow' ) ,
        'tab'                   => 'menu-bar' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

);

$options = array_merge( $options , $menu_bar_options );



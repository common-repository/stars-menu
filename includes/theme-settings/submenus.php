<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$pro_version_msg = stmenu_pro_version_msg();

$submenus_options = array(


    array(
        'name'          => __( "Submenus" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'submenus'
    ),

    /*array(
    'name'          => __( "Submenus Width" , "stars-menu" ),
    'id'            => 'theme_submenus_width',
    'type'          => 'text',
    'desc'          => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
    'default'       => '',
    'tab'           => 'submenus'
    ),*/

    array(
        'name'          => __( "Submenus Open Direction" , "stars-menu" ),
        'id'            => 'theme_sub_items_submenus_open_direction',
        'options'       => array(
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "It is used to specify Direction Opening of Submenus via “shift nav” feature(all submenus except Top Level Menu submenus on the desktop using shifted to parent and child submenu)." , "stars-menu" ),
        'default'       => is_rtl() ? 'left' : 'right',
        'tab'           => 'submenus'
    ),

    array(
        'name'                  => __( "submenu shift Transition Duration" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_shift_duration',
        'type'                  => 'text',
        'desc'                  => __( "It is used to specify time period when a submenu is shifted to another submenu (Integer usage is only permitted and time is in the milliseconds , for all submenus except Top Level Menu submenus on the desktop )." , "stars-menu" ),
        'default'               => 500,
        'tab'                   => 'submenus' ,
        'validation'            => array( 'require' , 'integer' )  ,
        'css_sanitize'          => array( 'require' ) ,
        'is_style_variable'     => true
    ),

    array(
        'name'          => __( "Dropdowns" , "stars-menu" ),
        'type'          => 'heading' ,
        'tab'           => 'submenus'
    ),

    array(
        'name'          => __( "Dropdowns Position" , "stars-menu" ),
        'id'            => 'theme_dropdowns_position',
        'options'       => array(
            'left'              => __( "Left" , "stars-menu" )  ,
            'right'             => __( "Right" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "It allows you to specify the submenus positions with respect to their parent items(it is only utilized for Top Level Menu Items and elements which have Dropdown like WooCommerce Cart Icon)." , "stars-menu" ),
        'default'       => is_rtl() ? 'left' : 'right',
        'tab'           => 'submenus'
    ),

    array(
        'name'          => __( "Dropdowns Trigger" , "stars-menu" ),
        'id'            => 'theme_dropdowns_trigger',
        'options'       => array(
            'click'           => __( "Click" , "stars-menu" ),
            'hover'           => __( "Hover" , "stars-menu" ),
        ),
        'type'          => 'radio',
        'desc'          => __( "Open the Dropdowns via this trigger(it is only utilized for Top Level Menu Items and elements which have Dropdown like WooCommerce Cart Icon)." , "stars-menu" ),
        'default'       => 'hover',
        'tab'           => 'submenus'
    ),

    /*array(
        'name'          => __( "Other Level Submenus Trigger" , "stars-menu" ),
        'id'            => 'theme_other_level_submenus_trigger',
        'options'       => array(
            'click'           => __( "Click" , "stars-menu" ),
            'hover'           => __( "Hover" , "stars-menu" ),
        ),
        'type'          => 'radio',
        'desc'          => __( "Open the Other Level Submenus via this trigger" , "stars-menu" ),
        'default'       => 'click',
        'tab'           => 'submenus'
    ),*/

    array(
        'name'          => __( 'Dropdowns Transition' , "stars-menu" ),
        'type'          => 'note',
        'desc'          => $pro_version_msg,
        'tab'           => 'submenus'
    ),

    array(
        'name'                  => __( "Dropdowns Transition Duration" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_transition_duration',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the time is spent for Opening of Dropdowns (it is only utilized for Top Level Menu Items).You can use <code>.5s</code> or <code>500ms</code>. Defaults to .3s" , "stars-menu" ),
        'default'               => '.3s',
        'tab'                   => 'submenus' ,
        'validation'            => array( 'require' ) ,//'integer' ,
        'css_sanitize'          => array( 'require' ) ,
        'is_style_variable'     => true
    ),

    array(
        'name'                  => __( "Dropdowns Open Delay" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_transition_delay',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the time delay Opening of Dropdowns (it is only utilized for Top Level Menu Items).You can use <code>.5s</code> or <code>500ms</code>. Defaults to .2s" , "stars-menu" ),
        'default'               => '.2s',
        'tab'                   => 'submenus' ,
        'validation'            => array( 'require' ) ,//'integer' ,
        'css_sanitize'          => array( 'require' ) ,
        'is_style_variable'     => true
    ),

    array(
        'name'                  => __( "Dropdowns Close Hover Delay" , "stars-menu" ),
        'id'                    => 'theme_dropdowns_close_hover_delay',
        'type'                  => 'text',
        'desc'                  => __( "Determines the amount of Dropdowns‘s closing delay. 500 by default(it is only utilized for Top Level Menu Items. Integer usage is only permitted and time is in the milliseconds)." , "stars-menu" ),
        'default'               => 500,
        'tab'                   => 'submenus'
    ),

    array(
        'name'                  => __( "Submenus Background Images" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'submenus'
    ),

    array(
        'name'                  => __( 'Hide Background Images on Mobile' , "stars-menu" ),
        'id'                    => 'theme_submenus_background_image_mobile_hide',
        'type'                  => 'enable',
        'default'               => false,
        //'desc'                  => __( 'Set the actual width and height attributes on an image if none are set manually.' , "stars-menu" ),
        'enabled'               => __( 'ON' , "stars-menu" ),
        'disabled'              => __( 'OFF' , "stars-menu" ),
        'tab'                   => 'submenus'
    ) ,

    array(
        'name'                  => __( 'Hide Background Images on Desktop' , "stars-menu" ),
        'id'                    => 'theme_submenus_background_image_desktop_hide',
        'type'                  => 'enable',
        'default'               => false,
        //'desc'                  => __( 'Set the actual width and height attributes on an image if none are set manually.' , "stars-menu" ),
        'enabled'               => __( 'ON' , "stars-menu" ),
        'disabled'              => __( 'OFF' , "stars-menu" ),
        'tab'                   => 'submenus'
    ) ,

    array(
        'name'                  => __( "Submenus Style Customization" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_width',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the default width of all submenus on desktop. this size can be override in the settings of items which have submenus." , "stars-menu" ),
        'default'               => '280px',  
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the All Submenus on desktop." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Image" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_bg_image',
        'type'                  => 'upload',
        'desc'                  => __( "This will add a background image to your Submenus on desktop" , "stars-menu" ),
        'default'               => '',
        'css_sanitize'          => array( 'attachment' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Repeat Background Image" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_bg_repeat',
        'options'               => array(
            'no-repeat'             => __( "No Repeat" , "stars-menu" )  ,
            'repeat'                => __( "Repeat" , "stars-menu" ) ,
            'repeat-x'              => __( "Repeat X (Horizontal)" , "stars-menu" ) ,
            'repeat-y'              => __( "Repeat Y (Vertical)" , "stars-menu" ) ,
            'space'                 => __( "Space" , "stars-menu" ) ,
            'round'                 => __( "Round" , "stars-menu" ) ,
        ),
        'type'                  => 'select',
        'desc'                  => sprintf( __( "Learn more from %s" , "stars-menu" ) , '<a target="_blank" href="http://www.w3schools.com/cssref/pr_background-repeat.asp">' . __( "this guide" , "stars-menu" ) . '</a>' ),
        'default'               => 'no-repeat',
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Position" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_bg_position',
        'type'                  => 'text',
        'desc'                  => sprintf( __( "Learn more from %s" , "stars-menu" ) , '<a target="_blank" href="http://www.w3schools.com/cssref/pr_background-position.asp">' . __( "this guide" , "stars-menu" ) . '</a>' ),
        'default'               => 'center center',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_bg_size',
        'type'                  => 'text',
        'desc'                  => sprintf( __( "Learn more from %s" , "stars-menu" ) , '<a target="_blank" href="http://www.w3schools.com/cssref/css3_pr_background-size.asp">' . __( "this guide" , "stars-menu" ) . '</a>' ),
        'default'               => 'cover',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_border_color',
        'type'                  => 'color',
        'desc'                  => __( "The Border Color for the submenus." , "stars-menu" ),
        'default'               => 'transparent',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Border Style" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_border_style',
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
        'desc'                  => __( "The Border Style for the submenus" , "stars-menu" ),
        'default'               => 'none',  
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_border_width',
        'type'                  => 'multi-text',
        'desc'                  => __( "Using this setting you can specify the border size for four sides of submenus (right, left, top and bottom). if you want some sides don’t include borders, you should set their sizes to 0 value" , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => '0px' ,
            'right'                 => '0px' ,
            'bottom'                => '0px' ,
            'left'                  => '0px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Border Radius (rounded corners)" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_radius',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will allow you to add rounded corners to your submenus" , "stars-menu" ), //If you are using backgrounds on submenus, you can round the corners with this setting.
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
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Submenus Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_submenu_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your submenus. (Not supported in older browsers)" , "stars-menu" ),
        'default'       => array(
            'enable'            => 'on',
            'horizontal'        => 0,
            'vertical'          => 0,
            'blur'              => '20px',
            'spread'            => 0,
            'color'             => 'rgba(0,0,0,.15)',
        ),
        'validation'            => array( 'dimension' ) ,
        'css_sanitize'          => array( 'shadow' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_submenu_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add padding to the Submenus." , "stars-menu" ), 
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => '0px' ,
            'right'                 => '0px' ,
            'bottom'                => '0px' ,
            'left'                  => '0px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Items" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus items text padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_text_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "The spaces which are considered for text of submenus items (including title and description)" , "stars-menu" ),
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
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_font_size',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => "13px",
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Weight" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_font_weight',
        'type'                  => 'select',
        'desc'                  => __( "This will set how thick or thin characters in Submenus items texts should be displayed." , "stars-menu" ),
        'default'               => "normal",
        'options'               => array(
            'normal'        => __('normal', 'stars-menu'),
            'bold'          => __('bold', 'stars-menu') ,
            'bolder'        => __('bolder', 'stars-menu'),
            'lighter'       => __('lighter', 'stars-menu') ,
            100             => 100,
            200             => 200 ,
            300             => 300,
            400             => 400 ,
            500             => 500,
            600             => 600 ,
            700             => 700,
            800             => 800 ,
            900             => 900 ,
        ),
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Transform" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_text_tform',
        'type'                  => 'select',
        'desc'                  => __( "This will control the capitalization of Submenus items texts." , "stars-menu" ),
        'default'               => "capitalize",
        'options'               => array(
            'none'                  => __('None', 'stars-menu'),
            'capitalize'            => __('Capitalize', 'stars-menu') ,
            'uppercase'             => __('Uppercase', 'stars-menu'),
            'lowercase'             => __('Lowercase', 'stars-menu') ,
        ),
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for the Submenus Items Texts & Icons." , "stars-menu" ),
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the Submenus Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_border_color',
        'type'                  => 'color',
        'desc'                  => __( "The Border Color for the Submenus Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Style" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_border_style',
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
        'desc'                  => __( "The Border Style for the Submenus Items." , "stars-menu" ),
        'default'               => 'none',
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_border_width',
        'type'                  => 'multi-text',
        'desc'                  => __( "Using this setting you can specify the border size for four sides of submenus items (right, left, top and bottom). if you want some sides don’t include borders, you should set their sizes to 0 value" , "stars-menu" ),
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
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Radius" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_radius',
        'type'                  => 'multi-text',
        'desc'                  => __( "If you are using background color on submenus items, you can round the corners with this setting" , "stars-menu" ),
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
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add padding to the Submenus items." , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => '10px'  ,
            'right'                 => '15px'  ,
            'bottom'                => '10px' ,
            'left'                  => '15px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Margin" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_margin',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add margin to the Submenus items." , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => '0px' , 
            'right'                 => '0px' ,
            'bottom'                => '0px' ,
            'left'                  => '0px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Line Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_line_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set line height for your submenus Items" , "stars-menu" ),
        'default'               => '130%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Items Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_subitem_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your submenus Items. (Not supported in older browsers)" , "stars-menu" ),
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
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Arrows Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_arrow_font_size',
        'type'                  => 'text',
        'desc'                  => __( "Determine the Arrow size for the Parent Items." , "stars-menu" ),
        'default'               => "13px",
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Arrows Horizontal Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_arrow_padding',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the Arrow space from left or right side of the item with respect to its position (left or right side of the item)." , "stars-menu" ),
        /*'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),*/
        'default'               => '30px',/*array(
            'top'                   => '7px'  ,
            'right'                 => '30px'  ,
            'bottom'                => '7px' ,
            'left'                  => '10px'
        ),*/
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Items(hover)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Submenus Items Hover Styles" , "stars-menu" ),
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_hover_color',
        'type'                  => 'color',
        'default'               => '#ff9900',  
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_hover_bg_color',
        'type'                  => 'color',
        'default'               => 'transparent',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_hover_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Items(Current)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Submenus Current Items Styles" , "stars-menu" ),
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_current_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_current_bg_color',
        'type'                  => 'color',
        'default'               => 'transparent',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_current_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Items(Highlight)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Styles of submenus items with the 'Highlight Link' setting checked" , "stars-menu" ),
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_highlight_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_highlight_bg_color',
        'type'                  => 'color',
        'default'               => 'transparent',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_highlight_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus back Items" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Styles of submenus back items" , "stars-menu" ),
        'tab'                   => 'submenus' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Back Items Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_back_color',
        'type'                  => 'color',
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Back Items Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_subitem_back_bg_color',
        'type'                  => 'color',
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'  
    ),

    array(
        'name'                  => __( "Back Arrows Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_back_arrow_font_size',
        'type'                  => 'text',
        'desc'                  => __( "Determine the Arrow size for the Back Items." , "stars-menu" ),
        'default'               => "13px",
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'submenus' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),
    
);

$options = array_merge( $options , $submenus_options );



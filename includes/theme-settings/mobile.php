<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$pro_version_msg = stmenu_pro_version_msg();

$mobile_options = array(

    array(
        'name'                  => __( "Mobile & Responsive" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'responsive'
    ),

    array(
        'name'                  => __( 'Responsive Menu' , "stars-menu" ),
        'id'                    => 'theme_responsive_enable',
        'type'                  => 'enable',
        'default'               => true,
        'desc'                  => __( 'you can disable or enable responsive menu' , "stars-menu" ),
        'enabled'               => __( 'ON' , "stars-menu" ),
        'disabled'              => __( 'OFF' , "stars-menu" ),
        'tab'                   => 'responsive'
    ) ,

    array(
        'name'                  => __( 'Responsive Menu Box Direction' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive'
    ),

    array(
        'name'                  => __( "Responsive Mobile Design" , "stars-menu" ),
        'id'                    => 'theme_responsive_menu_mobile_design',
        'type'                  => 'menu-mobile-design',
        'desc'                  => __( "By using this setting you can arrange the elements of vertical parts of the Mobile Menu. The Logo and Search elements are located at the horizontal part of Mobile Menu and only the elements which are selected at the Menu Designer -> Select elements for desktop (except Log and Search elements) can be appeared on the vertical part of Mobile Menu. Note that only these elements can be arranged." , "stars-menu" ),
        'default'               => array( 'menu-bar' ), //,'stars-cart-icon' , 'stars-social-bar'
        'tab'                   => 'responsive'
    ),

    array(
        'name'          => __( 'Responsive Close Icon' , "stars-menu" ),
        'id'            => 'theme_responsive_close_icon', 
        'type'          => 'icon',
        'default'       => 'starsmenu-icon_####_access-denied',
        'tab'           => 'responsive'
    ) ,

    /*array(
        'name'          => __( "Responsive Toggle Content" , "stars-menu" ),
        'id'            => 'theme_responsive_toggle_content',
        'type'          => 'text',
        'desc'          => __( "The text to display on the responsive toggle." , "stars-menu" ),
        'default'       => __( "Menu" , "stars-menu" ),
        'tab'           => 'responsive'
    ),

    array(
        'name'          => __( "Responsive Toggle Alignment" , "stars-menu" ),
        'id'            => 'theme_responsive_toggle_alignment',
        'options'       => array(
            'full_width'     => __( "Full Width" , "stars-menu" ),
            'left'           => __( "Left" , "stars-menu" ),
            'right'          => __( "Right" , "stars-menu" )
        ),
        'type'          => 'radio',
        'desc'          => __( "Alignment of the toggle button" , "stars-menu" ),
        'default'       => 'full_width',
        'tab'           => 'responsive'
    ),*/

    array(
        'name'                  => __( "Mobile & Responsive Styles" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Line Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_wrap_line_height',
        'type'                  => 'text',
        'desc'                  => __( "You can control the height of horizontal part of the responsive menu using this setting." , "stars-menu" ),
        'default'               => '45px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_wrap_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "It allows you to specify the background color of the vertical responsive menu" , "stars-menu" ),
        'default'               => '#1b1b1b',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Overlay Background Color' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),
    
    array(
        'name'                  => __( 'Background Image' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Repeat Background Image' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Background Position' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( 'Background Size' , "stars-menu" ),
        'type'                  => 'note',
        'desc'                  => $pro_version_msg,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Mobile Menu Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_mobi_wrap_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your responsive menu vertical part. (Not supported in older browsers)" , "stars-menu" ),
        'default'       => array(
            'enable'            => 'on',
            'horizontal'        => 0,
            'vertical'          => 0,
            'blur'              => '30px',
            'spread'            => 0,
            'color'             => 'rgba(0, 0, 0, 0.52)',
        ),
        'validation'            => array( 'dimension' ) ,
        'css_sanitize'          => array( 'shadow' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Submenus Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_submenu_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add padding to the responsive Submenus." , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Menu Items" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_font_size',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => "13px",
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Weight" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_font_weight',
        'type'                  => 'select',
        'desc'                  => __( "This will set how thick or thin characters in responsive menu items texts should be displayed." , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Transform" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_text_tform',
        'type'                  => 'select',
        'desc'                  => __( "This will control the capitalization of responsive menu items texts." , "stars-menu" ),
        'default'               => "capitalize",
        'options'               => array(
            'none'                  => __('None', 'stars-menu'),
            'capitalize'            => __('Capitalize', 'stars-menu') ,
            'uppercase'             => __('Uppercase', 'stars-menu'),
            'lowercase'             => __('Lowercase', 'stars-menu') ,
        ),
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for the responsive menu Items Texts & Icons." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'  
    ),

    array(
        'name'                  => __( "Items Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the responsive menu Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_border_color',
        'type'                  => 'color',
        'desc'                  => __( "The Border Color for the responsive menu Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Style" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_border_style',
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
        'desc'                  => __( "The Border Style for the responsive menu Items." , "stars-menu" ),
        'default'               => 'none',
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_border_width',
        'type'                  => 'multi-text',
        'desc'                  => __( "Using this setting you can specify the border size for four sides of mobile menu items (right, left, top and bottom). if you want some sides don’t include borders, you should set their sizes to 0 value." , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Radius (rounded corners)" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_radius',
        'type'                  => 'multi-text',
        'desc'                  => __( "If you are using background color on responsive menu items, you can round the corners with this setting" , "stars-menu" ),
        'options'               => array(
            'tl'                    => __( "Top Left" , "stars-menu" )  ,
            'tr'                    => __( "Top Right" , "stars-menu" )  ,
            'br'                    => __( "Bottom Right" , "stars-menu" ) ,
            'bl'                    => __( "Bottom Left" , "stars-menu" )
        ),
        'default'               => array(  
            'tl'                    => 0 ,
            'tr'                    => 0 ,
            'br'                    => 0 ,
            'bl'                    => 0
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add padding to the responsive menu items." , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Margin" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_margin',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add margin to the responsive menu items." , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Line Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_line_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set line height for your responsive menu Items" , "stars-menu" ),
        'default'               => '130%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Items Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_mobi_item_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your responsive menu Items. (Not supported in older browsers)" , "stars-menu" ),
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
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Arrows Horizontal Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_arrow_padding',
        'type'                  => 'text',
        'desc'                  => __( "It specifies the Arrow space from left or right side of the item with respect to its position (left or right side of the item)." , "stars-menu" ),
        /*'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),*/
        'default'               => '30px' ,/*array(
            'top'                   => '7px'  ,
            'right'                 => '30px'  ,
            'bottom'                => '7px' ,
            'left'                  => '10px'
        ),*/
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Menu Items(hover)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Mobile Menu Items Hover Styles" , "stars-menu" ),
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_hover_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_hover_bg_color',
        'type'                  => 'color',
        'default'               => 'rgba(0, 0, 0, 0.7)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_hover_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Menu Items(Current)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Mobile Menu Current Items Styles" , "stars-menu" ),
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_current_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_current_bg_color',
        'type'                  => 'color',
        'default'               => 'rgba(0, 0, 0, 0.7)', 
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_current_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Mobile Menu Items(Highlight)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Styles of mobile menu items with the 'Highlight Link' setting checked" , "stars-menu" ),
        'tab'                   => 'responsive' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_highlight_color',
        'type'                  => 'color',
        'default'               => '#ff9900',  
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_highlight_bg_color',
        'type'                  => 'color',
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_mobi_item_highlight_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0 , 0 , 0 , 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true ,  
        'panel'                 => 'styling'
    ),

    /*array(
        'name'                  => __( "Logo Element" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'responsive'
    ),

    array(
        'name'                  => __( "Logo Max Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_logo_max_width',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => '200px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'responsive' ,
        'is_style_variable'     => true
    ),*/

);

$options = array_merge( $options , $mobile_options );


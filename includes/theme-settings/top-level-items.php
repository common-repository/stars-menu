<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

$top_level_items_options = array(


    array(
        'name'                  => __( "Menu Top Level Items" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'top_level_items' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Between Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_spacing',
        'type'                  => 'text',
        'desc'                  => __( "You can specify the space between top level menu items by using this setting." , "stars-menu" ),
        'default'               => '3px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Size" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_font_size',
        'type'                  => 'text',
        //'desc'                  => __( "The width to allot for the icon. Icon will be centered within this width. 1.3em by default." , "stars-menu" ),
        'default'               => "13px",  
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Font Weight" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_font_weight',
        'type'                  => 'select',
        'desc'                  => __( "This will set how thick or thin characters in top level menu items texts should be displayed." , "stars-menu" ),
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
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Transform" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_text_tform',
        'type'                  => 'select',
        'desc'                  => __( "This will control the capitalization of top level menu items texts." , "stars-menu" ),
        'default'               => "uppercase",
        'options'               => array(
            'none'                  => __('None', 'stars-menu'),
            'capitalize'            => __('Capitalize', 'stars-menu') ,
            'uppercase'             => __('Uppercase', 'stars-menu'),
            'lowercase'             => __('Lowercase', 'stars-menu') ,
        ),
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Letter Spacing" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_letter_spacing',
        'type'                  => 'select',
        'desc'                  => __( "This will increases or decreases the space between characters in top level menu items texts" , "stars-menu" ),
        'default'               => "1px",
        'options'               => array(
            'normal'        => __('normal', 'stars-menu'),
            '-20px'         => '-20px' ,   
            '-19px'         => '-19px' , 
            '-18px'         => '-18px' , 
            '-17px'         => '-17px' ,   
            '-16px'         => '-16px' , 
            '-15px'         => '-15px' , 
            '-14px'         => '-14px' , 
            '-13px'         => '-13px' , 
            '-12px'         => '-12px' , 
            '-11px'         => '-11px' , 
            '-10px'         => '-10px' , 
            '-9px'          => '-9px' , 
            '-8px'          => '-8px' , 
            '-7px'          => '-7px' , 
            '-6px'          => '-6px' , 
            '-5px'          => '-5px' , 
            '-4px'          => '-4px' , 
            '-3px'          => '-3px' , 
            '-2px'          => '-2px' , 
            '-1px'          => '-1px' , 
            '0px'           => '0px'  , 
            '1px'           => '1px'  , 
            '2px'           => '2px'  , 
            '3px'           => '3px'  , 
            '4px'           => '4px'  , 
            '5px'           => '5px'  , 
            '6px'           => '6px'  , 
            '7px'           => '7px'  , 
            '8px'           => '8px'  , 
            '9px'           => '9px'  , 
            '10px'          => '10px' , 
            '11px'          => '11px' , 
            '12px'          => '12px' , 
            '13px'          => '13px' , 
            '14px'          => '14px' , 
            '15px'          => '15px' ,   
            '16px'          => '16px' , 
            '17px'          => '17px' , 
            '18px'          => '18px' , 
            '19px'          => '19px' , 
            '20px'          => '20px' ,             
        ),
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_color',
        'type'                  => 'color',
        'desc'                  => __( "The color for the top level menu Items Texts & Icons." , "stars-menu" ),
        'default'               => '#000000',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_bg_color',
        'type'                  => 'color',
        'desc'                  => __( "The background color for the top level menu Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_border_color',
        'type'                  => 'color',
        'desc'                  => __( "The Border Color for the top level menu Items." , "stars-menu" ),
        'default'               => 'rgba(0, 0, 0, 0)',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Style" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_border_style',
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
        'desc'                  => __( "The Border Style for the top level menu Items." , "stars-menu" ),
        'default'               => 'none',
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_border_width',
        'type'                  => 'multi-text',
        'desc'                  => __( "Using this setting you can specify the border size for four sides of top level menu items (right, left, top and bottom). if you want some sides don’t include borders, you should set their sizes to 0 value." , "stars-menu" ),
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
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Border Radius (rounded corners)" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_radius',
        'type'                  => 'multi-text',
        'desc'                  => __( "If you are using background color on top level menu items, you can round the corners with this setting" , "stars-menu" ),
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
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "This will add padding to the top level menu items." , "stars-menu" ),
        'options'               => array(
            'top'                   => __( "Top" , "stars-menu" )  ,
            'right'                 => __( "Right" , "stars-menu" )  ,
            'bottom'                => __( "Bottom" , "stars-menu" ) ,
            'left'                  => __( "Left" , "stars-menu" )
        ),
        'default'               => array(
            'top'                   => '10px'  ,
            'right'                 => '10px'  ,
            'bottom'                => '10px' ,
            'left'                  => '10px'
        ),
        'css_sanitize'          => array( 'spacing' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Line Height" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_line_height',
        'type'                  => 'text',
        'desc'                  => __( "This will set line height for your top level menu Items" , "stars-menu" ),
        'default'               => '120%',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'          => __( "Items Shadow" , "stars-menu" ),
        'id'            => 'theme_style_stmenu_item_shadow',
        'type'          => 'box-shadow',
        'desc'          => __( "This will add a shadow to your top level menu Items. (Not supported in older browsers)" , "stars-menu" ),
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
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "items text padding" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_text_padding',
        'type'                  => 'multi-text',
        'desc'                  => __( "The spaces which are considered for text of top level menu items (including title and comments)" , "stars-menu" ),
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
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items hover/current Border Width" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_hover_border_width',
        'type'                  => 'text',
        'default'               => '2px',
        'validation'            => array( 'dimension' , 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Top Level Items(hover)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Top Level Menu Items Hover Styles" , "stars-menu" ),
        'tab'                   => 'top_level_items' ,
        'panel'                 => 'styling'
    ),

    /*array(
        'name'                  => __( "Items Hover Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_hover_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),*/

    //Items Hover Fill Color
    array(
        'name'                  => __( "Items Hover Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_hover_fill_color',
        'type'                  => 'color',
        //'desc'                  => __( "The background color for the main menu bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_hover_bg_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Hover Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_hover_border_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Top Level Items(Current)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Top Level Menu Current Items Styles" , "stars-menu" ),
        'tab'                   => 'top_level_items' ,
        'panel'                 => 'styling'
    ),

    /*array(
        'name'                  => __( "Items Current Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_current_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),*/

    //Items Current Fill Color
    array(
        'name'                  => __( "Items Current Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_current_fill_color',
        'type'                  => 'color',
        //'desc'                  => __( "The background color for the main menu bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_current_bg_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Current Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_current_border_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Menu Top Level Items(Highlight)" , "stars-menu" ),
        'type'                  => 'heading' ,
        'desc'                  => __( "Styles of Top level menu items with the 'Highlight Link' setting checked" , "stars-menu" ),
        'tab'                   => 'top_level_items' ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Text Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_highlight_color',
        'type'                  => 'color',
        'default'               => '#ff9900',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ), 

    /*array(
        'name'                  => __( "Items Highlight Fill Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_highlight_fill_color',
        'type'                  => 'color',
        //'desc'                  => __( "The background color for the main menu bar." , "stars-menu" ),
        'default'               => '#ffffff',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),*/

    array(
        'name'                  => __( "Items Highlight Background Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_highlight_bg_color',
        'type'                  => 'color',
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'validation'            => array( 'require' ) ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),

    array(
        'name'                  => __( "Items Highlight Border Color" , "stars-menu" ),
        'id'                    => 'theme_style_stmenu_item_highlight_border_color',
        'type'                  => 'color',
        'default'               => 'rgba(0, 0, 0, 0)',
        'alpha'                 => true ,
        'css_sanitize'          => array( 'require' ) ,
        'tab'                   => 'top_level_items' ,
        'is_style_variable'     => true ,
        'panel'                 => 'styling'
    ),


    /*array(
        'name'          => __( "Color Schema" , "stars-menu" ),
        'id'            => 'theme_style_color_schema',
        'type'          => 'radio-palette',
        'desc'          => __( "Use preset colors if you dont want to use your own. This will filter down to the subnavigation as well. This will affect all background styling and text coloring." , "stars-menu" ),
        'options'       => array(
            array(
                "#69D2E7",
                "#A7DBD8",
                "#E0E4CC",
                "#F38630",
                "#FA6900",
            ),
            array(
                "#D9CEB2",
                "#948C75",
                "#D5DED9",
                "#7A6A53",
                "#99B2B7",
            ),
            array(
                "#3FB8AF",
                "#7FC7AF",
                "#DAD8A7",
                "#FF9E9D",
                "#FF3D7F",
            ),
            array(
                "#D1E751",
                "#FFFFFF",
                "#000000",
                "#4DBCE9",
                "#26ADE4",
            )
        ),
        'default'       => 1,
        'tab'           => 'top_level_items'
    ),*/

);

$options = array_merge( $options , $top_level_items_options );



<?php
/**
 * Stars Menu Main Functions
 *
 * @package StarsMenu
 * @subpackage Functions
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

/**
 * Get Menu Theme Setting
 * For Default Theme : Always use the code above inside WordPress hooks that run on or after after_setup_theme
 * For Custom Themes : Using post id ( theme id )
 *
 * @param $id
 * @param string $theme === post ID
 * @return mixed
 */
function stmenu_theme_option( $id , $theme = "default" ){

    return StMenu()->options_manager->menu_theme_settings->get_theme_option( $id , $theme );

}

function stmenu_item_option( $id , $menu_item_id ){

    return StMenu()->options_manager->options->getOption( $id , $menu_item_id );

}

function stmenu_get_option( $id , $post_id = null ){

    return StMenu()->options_manager->options->getOption( $id , $post_id );

}

/**
 * Get template part
 *
 * STARS_MENU_TEMPLATE_DEBUG_MODE will prevent overrides in themes from taking priority.
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 */
function stmenu_get_template_part( $slug, $name = '' ) {
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/stars-menu/slug-name.php
    if ( $name && ! STARS_MENU_TEMPLATE_DEBUG_MODE ) {
        $template = locate_template( array( "{$slug}-{$name}.php", StMenu()->template_path() . "{$slug}-{$name}.php" ) );
    }

    // Get default slug-name.php
    if ( ! $template && $name && file_exists( StMenu()->plugin_path() . "/templates/{$slug}-{$name}.php" ) ) {
        $template = StMenu()->plugin_path() . "/templates/{$slug}-{$name}.php";
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/stars-menu/slug.php
    if ( ! $template && ! STARS_MENU_TEMPLATE_DEBUG_MODE ) {
        $template = locate_template( array( "{$slug}.php", StMenu()->template_path() . "{$slug}.php" ) );
    }

    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters( 'stmenu_get_template_part', $template, $slug, $name );

    if ( $template ) {
        load_template( $template, false );
    }
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 */
function stmenu_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( ! empty( $args ) && is_array( $args ) ) {
        extract( $args );
    }

    $located = stmenu_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $located = apply_filters( 'stmenu_get_template', $located, $template_name, $args, $template_path, $default_path );

    do_action( 'stmenu_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );

    do_action( 'stmenu_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Like stmenu_get_template, but returns the HTML instead of outputting.
 *
 * @see stmenu_get_template
 *
 * @since 1.0.0
 * @param $template_name string
 * @param $args array
 * @param $template_path string
 * @param $default_path string
 * @return string html
 */
function stmenu_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    ob_start();
    stmenu_get_template( $template_name, $args, $template_path, $default_path );
    return ob_get_clean();
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function stmenu_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    if ( ! $template_path ) {
        $template_path = StMenu()->template_path();
    }

    if ( ! $default_path ) {
        $default_path = StMenu()->plugin_path() . '/templates/front-end/';
    }

    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit( $template_path ) . $template_name,
            $template_name
        )
    );

    // Get default template/
    if ( ! $template || STARS_MENU_TEMPLATE_DEBUG_MODE ) {
        $template = $default_path . $template_name;
    }

    // Return what we found.
    return apply_filters( 'starsmenu_locate_template', $template, $template_name, $template_path );
}

/**
 * Enables template debug mode.
 */
function stmenu_template_debug_mode() {
    if ( ! defined( 'STARS_MENU_TEMPLATE_DEBUG_MODE' ) ) {
        //$status_options = get_option( 'starse_menu_status_options', array() );
        //if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
            //define( 'STARS_MENU_TEMPLATE_DEBUG_MODE', true );
        //} else {
            define( 'STARS_MENU_TEMPLATE_DEBUG_MODE', false );
        //}
    }
}

add_action( 'after_setup_theme', 'stmenu_template_debug_mode', 20 );

function stmenu_is_mobile( $scenario = false ){
    return apply_filters( 'stmenu_is_mobile' , wp_is_mobile() , $scenario );
}

/**
 * Get All WP Image Sizes
 *
 */
function stmenu_get_image_sizes(){
    global $_wp_additional_image_sizes;

    $sizes = array();

    $possible_sizes = apply_filters( 'image_size_names_choose', array(
        'thumbnail' => __('Thumbnail'),
        'medium'    => __('Medium'),
        'large'     => __('Large')
    ) );


    foreach( $possible_sizes as $_size => $label ) {

        if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
            $sizes[ $_size ]['label'] =  $label;

        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'] ,
                'label'  => $label
            );

        }

    }

    $sizes['full'] = array( 'label'  => __('Full Size') );

    foreach( $_wp_additional_image_sizes AS $img_size => $options ){
        $sizes[ $img_size ] = array(
            'width'  => $options['width'],
            'height' => $options['height'],
            'crop'   => $options['crop'] ,
            'label'  => $img_size
        );
    }

    return $sizes;
}

function stmenu_elements_order( $a, $b ) {
    if ( $a['order'] === $b['order'] ) {
        return 0;
    } else {
        return $a['order'] - $b['order'];
    }
}

function stmenu_menus_assigned_to_theme( $theme = "default" ){

    $integration_settings = get_option( 'stars_menu_integration_settings' , array() );

    $menus_assigned = array();

    foreach ( $integration_settings AS $location => $location_options ){ 

        if( isset( $location_options['theme'] ) && $location_options['theme'] == $theme && isset( $location_options['enabled'] ) && $location_options['enabled'] && has_nav_menu( $location ) ){

            $menu_id = stmenu_id_for_location( $location );

            if( $menu_id ){

                $menus_assigned[$location] = $menu_id;

            }

        }

    }

    return $menus_assigned;

}

function stmenu_id_for_location( $location ) {

    $locations = get_nav_menu_locations();

    $menu_id = isset( $locations[ $location ] ) ? $locations[ $location ] : 0;

    return $menu_id;

}

/**
 * Returns the menu name for a specified menu location
 *
 * @since 1.0
 * @param $location string
 * @return bool
 */
function stmenu_name_for_location( $location ) {

    $id = stmenu_id_for_location( $location );

    if( $id == 0 )
        return false;

    $menus = wp_get_nav_menus();

    foreach ( $menus as $menu ) {
        if ( $menu->term_id == $id ) {
            return $menu->name;
        }
    }

    return false;
}

function stmenu_get_themes(){
    
    $args = array(
        'post_type'             => 'stars_menu_themes' ,
        'posts_per_page'        => -1 ,
        'post_status'           => 'publish'
    );

    $themes = get_posts( $args );

    $all_themes = array( 'default' => __("default" , "stars-menu") );

    if( !empty( $themes ) && is_array( $themes ) ) {

        foreach ($themes as $theme) {

            $key = $theme->ID;

            $title = get_the_title($theme->ID);

            $all_themes[$key] = $title;

        }

    }

    return $all_themes;
}

if ( ! function_exists( 'stmenu_is_enabled' ) ) {

    /**
     * Determines if Stars Menu has been enabled for a given menu location.
     *
     * Usage:
     *
     * Stars Menu is enabled:
     * function_exists( 'stmenu_is_enabled' )
     *
     * Stars Menu has been enabled for a theme location:
     * function_exists( 'stmenu_is_enabled' ) && stmenu_is_enabled( $location )
     *
     * @since 1.0.0
     * @param bool|string $location - theme location identifier
     * @return bool
     */
    function stmenu_is_enabled( $location = false ) {

        if ( ! $location ) {
            return true; // the plugin is enabled
        }

        if ( ! has_nav_menu( $location ) ) {
            return false;
        }

        // if a location has been passed, check to see if MMM has been enabled for the location
        $settings = get_option( 'stars_menu_integration_settings' );

        return is_array( $settings ) && isset( $settings[ $location ]['enabled'] ) && $settings[ $location ]['enabled'] == true;
    }
}

function stmenu_get_support_url(){

    if ( $cache_support_url = wp_cache_get( 'stars_menu_support_url' ) ){
        return $cache_support_url;
    }

    $url = STARS_MENU_SUPPORT_URL;

    $data = array();


    $data['src']			= 'starsmenu_plugin';
    $data['product_id']		= 1;

    //Site Data
    $data['site_url'] 		= get_site_url();
    $data['version']		= STARS_MENU_VERSION;
    $data['timezone']		= get_option('timezone_string');

    //Theme Data
    $theme = wp_get_theme();

    $data['theme']			= $theme->get( 'Name' );
    $data['theme_link']		= '<a target="_blank" href="'.$theme->get( 'ThemeURI' ).'">'. $theme->get( 'Name' ). ' v'.$theme->get( 'Version' ).' by ' . $theme->get( 'Author' ).'</a>';
    $data['theme_slug']		= isset( $theme->stylesheet ) ? $theme->stylesheet : '';
    $data['theme_parent']	= $theme->get( 'Template' );

    //User Data
    $current_user = wp_get_current_user();
    if( $current_user ){
        if( $current_user->user_firstname ){
            $data['first_name']		= $current_user->user_firstname;
        }
        if( $current_user->user_firstname ){
            $data['last_name']		= $current_user->user_lastname;
        }
        if( $current_user ){
            $data['email']			= $current_user->user_email;
        }
    }

    if( STARS_MENU_VERSION_TYPE == "pro" ) {
        //License Data
        $license_status = stmenu_check_activate_license();
        $data['license_status'] = $license_status;
    }

    $query = http_build_query( $data );

    $support_url = "$url?$query";

    wp_cache_set('stars_menu_support_url', $support_url );

    return $support_url;
}

/**
 * Is Show Element In Sticky Mode?
 *
 * @param string $element
 * @param string $theme
 * @return bool
 */
function stmenu_show_in_sticky( $element , $theme = '' ){

    $show_in_sticky = false;

    $theme = empty( $theme ) ? StMenu()->current_theme : $theme;

    $theme = empty( $theme ) ? 'default' : $theme;

    $design_layouts = stmenu_theme_option('theme_menu_design_order_layouts' , $theme );

    if( is_array( $design_layouts ) && !empty( $design_layouts ) ) {

        foreach ( $design_layouts AS $layout ) {

            if( $layout['id'] == $element ) {
                $show_in_sticky = (bool)$layout['show_in_sticky'];
                break;
            }

        }

    }

    return $show_in_sticky;

}

function stmenu_get_item_arrow(){

    $theme = StMenu()->current_theme;

    $icon = stmenu_theme_option( 'theme_items_arrow' , $theme );

    $arrow_classes = '';

    if( !empty( $icon ) ) {

        $arrow_classes = LA_IconManager::getIconClass($icon);

    }

    return $arrow_classes;
}

function stmenu_get_back_item_arrow( ){

    $theme = StMenu()->current_theme;

    $icon = stmenu_theme_option( 'theme_back_items_arrow' , $theme );

    $arrow_classes = '';

    if( !empty( $icon ) ) {

        $arrow_classes = LA_IconManager::getIconClass($icon);

    }

    return $arrow_classes;
}


function stmenu_get_wrapper_id( $theme_location , $type = "current" ){

    $sanitized_location = str_replace( apply_filters("stmenu_location_replacements", array("-", " ") ), "-", $theme_location );

    if( $type == "current" ) {

        $counter = stmenu_loaded_counter($theme_location);

        $counter -= 1;

        $counter = $counter > 0 ? "-{$counter}" : "";

    }else{

        $counter = "";

    }

    $wrapper_id = "stars-menu-wrap-{$sanitized_location}" . $counter;

    return $wrapper_id;

}

function stmenu_base_wrapper_id( $theme_location ){

    return stmenu_get_wrapper_id( $theme_location , "base" );

}

function stmenu_menu_main_class( $menu_id ){

    $menu = wp_get_nav_menu_object( $menu_id );

    $menu_base_id = 'menu-' . $menu->slug;

    $base_id = "starsmenu-{$menu_base_id}";

    return $base_id;

}

function stmenu_get_background_image( $attachment_id , $size = 'full' ){

    $value = (int) $attachment_id;

    if( $value && get_post( $value ) ) {
        $image = wp_get_attachment_image_src( $value , $size );
        $image_src = 'url('.$image[0].')';
    }else{
        $image_src = 'none';
    }

    return $image_src;

}

function stmenu_loaded_counter( $theme_location ){
    
    return did_action('starsmenu_loaded_counter_' . $theme_location);
    
}

function is_starsmenu_admin(){

    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == "stars-menu" ) {

        return true;

    }

    $screen = get_current_screen(); 

    $screens = array( "stars_menu_themes" , "edit-stars_menu_themes" , "nav-menus" );

    if ( !is_null( $screen ) && is_object( $screen ) && in_array( $screen->id , $screens ) ) {
        return true;
    }

    return false;

}

function stmenu_pro_version_msg(){

    $pro_version_msg = '<a href="https://www.stars-menu.com/#sed-bp-module-row-container-4-1" target="_blank" class="button button-primary button-upgrade-to-pro">'. __( 'Upgrade To Pro' , "stars-menu" ) .'</a>';

    return $pro_version_msg;

}


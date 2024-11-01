<?php
/**
 * Stars Menu Style & Css Manager class
 *
 * Thanks from Tom Hemsley https://wordpress.org/plugins/megamenu/
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Style & Css Manager class
 *
 * Manege Styles & Css For Stars Menu
 *
 * @Class StarsMenuCssManager
 * @since 1.0.0
 */
final class StarsMenuCssManager {

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var object
     * @since 1.0.0
     */
    public $stmenu;

    /**
     * Inline Css
     *
     * @var string
     * @since 1.0.0
     */
    public $inline_css = "";

    /**
     * StarsMenuCssManager constructor.
     * @param $stars_menu
     */
    public function __construct( $stars_menu ) {

        $this->stmenu = $stars_menu;

        if( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == "stars-menu" && isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == "default-theme-configuration" ) {

            add_action("tf_admin_options_saved_stars_menu", array($this, "generate_css") );

            add_action("tf_save_admin_stars_menu", array($this, "save_default_theme_fonts") , 10 , 3 );

        }

        add_action( "tf_meta_options_saved_stars_menu" , array( $this , "generate_css" ) , 10 , 1 );

        add_action( "tf_meta_options_saved_stars_menu" , array( $this , "save_theme_fonts" ) , 10 , 2 );

        add_action( "stmenu_integration_settings_output_css" , array( $this , "generate_css" )  );

        add_action( "stmenu_integration_old_theme_output_css" , array( $this , "generate_css" )  );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) , 100 );

        //before titan-css
        add_action( "wp_head" , array( $this , "print_css" ) , 98 );

        add_action( 'admin_notices', array( $this, 'admin_notice_error' ) );

        add_filter( 'stmenu_scss_variables' , array( $this , 'dynamic_scss_variables' ) , 10 , 4 );

        add_action( 'admin_notices', array( $this, 'print_compile_error' ) );

    }

    public function print_compile_error(){

        $default_theme_page = false;

        if( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == "stars-menu" && isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == "default-theme-configuration" ) {
            $default_theme_page = true;
            $theme = "default";
        }

        $screen = get_current_screen();

        $themes_edit_page = false;

        if( !is_null( $screen ) && is_object( $screen ) && $screen->id == "stars_menu_themes" ){
            $themes_edit_page = true;

            global $post;

            $theme = $post->ID;
        }

        if( $themes_edit_page === false && $default_theme_page === false ){
            return ;
        }

        $compile_errors = get_option( '_starsmenu_compile_errors' , array() );

        $curr_theme_compile_errors = isset( $compile_errors[$theme] ) ? $compile_errors[$theme] : array();

        foreach ( $curr_theme_compile_errors AS $message ) {

            $class = 'notice notice-error is-dismissible';

            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);

        }

    }

    /**
     * Print notice in Wp Admin if we can not save css files in upload directory
     */
    public function admin_notice_error() {

        $settings = get_option( 'stars_menu_general_settings' );

        if( is_array( $settings ) && isset( $settings['css_file_save_permission'] ) && $settings['css_file_save_permission'] == "no" ) {

            $class = 'notice notice-error';

            $help_link = '<a href="https://codex.wordpress.org/Changing_File_Permissions">'. __('Changing File Permissions', 'stars-menu') .'</a>';

            $message = sprintf( __('You have do not permission to write files in "Upload" directory. please modify file permissions , using %s page for help', 'stars-menu') , $help_link );

            printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message );

        }

    }


    /**
     * Enqueue public CSS and JS files required by Stars Menu
     *
     * @since 1.0
     */
    public function enqueue_styles() {

        $settings = get_option( 'stars_menu_integration_settings' );

        $locations = get_nav_menu_locations();

        $enqueue_themes = array();

        if( is_array( $settings ) ) {

            foreach ( $settings AS $theme_location => $setting ) {

                $menu_id = $locations[ $theme_location ];

                if ( ! $menu_id ) {
                    continue;
                }

                if( isset ( $setting['enabled'] ) && $setting['enabled'] && isset( $setting['theme'] ) ) {

                    if( !in_array( $setting['theme'] , $enqueue_themes ) ) {

                        $this->enqueue_theme_style($setting['theme']);

                        $enqueue_themes[] = $setting['theme'];

                    }

                }

            }

        }

        $titan_css_handle = 'tf-compiled-options-stars_menu';

        if( !empty( $enqueue_themes ) && wp_style_is($titan_css_handle, 'enqueued') ){

            $deps = array();

            foreach ( $enqueue_themes AS $theme ) {

                $handle = "stars-menu-{$theme}-theme";

                if( wp_style_is($handle, 'enqueued') ) {

                    $deps[] = $handle;

                }

            }

            wp_dequeue_style( $titan_css_handle );

            wp_enqueue_style( $titan_css_handle , StMenu()->options_manager->options->cssInstance->getCSSFileURL() , $deps );

            $urls = $this->get_google_font_urls( $enqueue_themes );

            foreach ( $urls as $font_name => $url ) {
                wp_enqueue_style( 'stars-menu-google-webfont-' . strtolower( str_replace( ' ', '-', $font_name ) ), $url );
            }

        }

        do_action( 'stmenu_enqueue_public_scripts' );

    }

    public function save_default_theme_fonts( $admin_page, $activeTab, $options ){

        $this->save_theme_fonts( 'default' , $activeTab->options );

    }

    public function save_theme_fonts( $post_id , $options ){

        if( $post_id && $post_id != "default" && $post = get_post( $post_id ) ){

            if( $post->post_type != "stars_menu_themes" ){

                return false;

            }else{
                $theme = $post_id;
            }

        }else{
            $theme = "default";
        }

        $settings = get_option( 'stars_menu_general_settings' , array() );

        $font_options = array();

        foreach ( $options as $option ) {

            if ( empty( $option->settings['id'] ) || empty( $option->settings['type'] ) ) {
                continue;
            }

            if( $option->settings['type'] != "font" ){
                continue;
            }

            $font_options[] = $option->settings['id'];

        }

        if( !isset( $settings['stars_menu_fonts'] ) ){

            $settings['stars_menu_fonts'] = array();

        }

        $settings['stars_menu_fonts'][$theme] = $font_options;

        update_option( 'stars_menu_general_settings' , $settings );

    }

    public function get_theme_fonts( $theme ){

        $settings = get_option( 'stars_menu_general_settings' , array() );

        $fonts = array();

        if( isset( $settings['stars_menu_fonts'] ) && isset( $settings['stars_menu_fonts'][$theme] ) ){

            $fonts = $settings['stars_menu_fonts'][$theme];

        }

        return $fonts;

    }

    public function get_google_font_urls( $enqueue_themes ){

        $urls = array();

        // Gather all the fonts that we need to load, some may be repeated so we need to
        // load them once after gathering them
        $fontsToLoad = array();
        foreach ( $enqueue_themes as $theme ) {

            $theme_fonts = $this->get_theme_fonts( $theme );

            foreach ( $theme_fonts AS $font_option_id ) {

                if( $theme == "default" ){

                    $font_option_id = substr($font_option_id, 0 , -8);

                }

                $fontValue = stmenu_theme_option( $font_option_id , $theme );

                if (empty($fontValue['font-family'])) {
                    continue;
                }
                if ($fontValue['font-family'] == 'inherit') {
                    continue;
                }

                if ($fontValue['font-type'] != 'google') {
                    continue;
                }

                // Stop load Custom Fonts
                /*if (in_array($fontValue['font-family'], $this->settings['fonts'])) {
                    continue;
                }*/

                // Get all the fonts that we need to load
                if (empty($fontsToLoad[$fontValue['font-family']])) {
                    $fontsToLoad[$fontValue['font-family']] = array();
                }

                // Get the weight
                $variant = $fontValue['font-weight'];
                if ($variant == 'normal') {
                    $variant = '400';
                } else if ($variant == 'bold') {
                    $variant = '500';
                } else if ($variant == 'bolder') {
                    $variant = '800';
                } else if ($variant == 'lighter') {
                    $variant = '100';
                }

                if ($fontValue['font-style'] == 'italic') {
                    $variant .= 'italic';
                }

                $fontsToLoad[$fontValue['font-family']][] = $variant;

            }
        }

        // Font subsets, allow others to change this
        $subsets = apply_filters( 'stars_menu_google_font_subsets' , array( 'latin', 'latin-ext' ) );

        // Enqueue the Google Font
        foreach ( $fontsToLoad as $fontName => $variants ) {

            // Always include the normal weight so that we don't error out
            $variants[] = '400';
            $variants = array_unique( $variants );

            $fontUrl = sprintf( '//fonts.googleapis.com/css?family=%s:%s&subset=%s',
                str_replace( ' ', '+', $fontName ),
                implode( ',', $variants ),
                implode( ',', $subsets )
            );

            $fontUrl = apply_filters( 'stars_menu_enqueue_google_webfont' , $fontUrl, $fontName );

            if ( $fontUrl != false ) {
                $urls[ $fontName ] = $fontUrl;
            }
        }

        return $urls;

    }

    /**
     * Enqueue Theme Style If Menu Or Menus With This Theme Exist In Current Page
     *
     * @param $theme
     */
    public function enqueue_theme_style( $theme ){

        $upload_dir = wp_upload_dir();

        $filename = $this->get_css_filename( $theme );

        $filepath = trailingslashit($upload_dir['basedir']) . 'stars-menu/' . $filename;

        $settings = get_option( 'stars_menu_general_settings' , array() );

        // file should now exist
        if ( is_file($filepath) && !isset( $settings["stars_menu_{$theme}_theme"] ) ) {

            $css_url = trailingslashit($upload_dir['baseurl']) . 'stars-menu/' . $filename;

            $protocol = is_ssl() ? 'https://' : 'http://';

            // ensure we're using the correct protocol
            $css_url = str_replace(array("http://", "https://"), $protocol, $css_url);

            $manual_enqueue = apply_filters( 'starsmenu_enqueue_css_manually' , false , $theme , $css_url );

            if( ! $manual_enqueue ) {
                wp_enqueue_style("stars-menu-{$theme}-theme", $css_url, false, substr(md5(filemtime($filepath)), 0, 6));
            }

        }else if( isset( $settings["stars_menu_{$theme}_theme"] ) ){

            $this->inline_css .= $settings["stars_menu_{$theme}_theme"];

        }

    }

    /**
     * Print css if can not write in a File
     */
    public function print_css(){

        if( !empty( $this->inline_css ) ){

            echo "<style id='stars-menu-themes-styles'>{$this->inline_css}</style>";

        }

    }

    /**
     * Generate and cache the CSS for our menus.
     * The CSS is compiled by scssphp using the file located in /css/megamenu.scss
     *
     * @since 1.0.0
     * @return string
     * @param integer $post_id
     */
    public function generate_css( $post_id = 0 ) {

        if( $post_id && $post_id != "default" && $post = get_post( $post_id ) ){

            if( $post->post_type != "stars_menu_themes" ){

                return false;

            }else{
                $theme = $post_id;
            }

        }else{
            $theme = "default";
        }

        // the settings may have changed since the class was instantiated,
        // reset them here
        $menus = stmenu_menus_assigned_to_theme( $theme );

        if ( empty( $menus ) ) {
            return "/** No menu found for this theme  **/";
        }

        $css = "";

        $compile_errors = get_option( '_starsmenu_compile_errors' , array() );

        $curr_theme_compile_errors = array();

        $compiled_css = $this->generate_location_css( $menus, $theme );

        if ( ! is_wp_error( $compiled_css ) ) {
            $css .= $compiled_css;
        }else{
            $curr_theme_compile_errors[] = $compiled_css->get_error_message();
        }

        if( ( isset( $compile_errors[$theme] ) && $compile_errors[$theme] !== $curr_theme_compile_errors ) ||
            ( !isset( $compile_errors[$theme] ) && !empty( $curr_theme_compile_errors ) )
        ) {

            $compile_errors[$theme] = $curr_theme_compile_errors;

            update_option('_starsmenu_compile_errors', $compile_errors);
        }

        if ( strlen( $css ) ) {

            $scss_location = 'core';

            foreach ( $this->get_possible_scss_file_locations() as $path ) {
                if ( file_exists($path) && $path !== $this->get_default_scss_file_location() ) {
                    $scss_location = 'custom';
                }
            }

            $css = "/** " . date('l jS \of F Y h:i:s A') . " ({$scss_location}) **/\n\n" . $css;

            //$this->set_cached_css( $css );

            $this->save_to_filesystem( $css , $theme );

        }

        return $css;
    }

    /**
     * Compiles raw SCSS into CSS for a particular menu location.
     *
     * @since 1.0.0
     * @return mixed
     * @param string $location
     * @param string $theme
     * @param string $menu_id
     */
    public function generate_location_css( $menus , $theme ) {

        if( !class_exists( 'scssc' ) ){
            require_once STARS_MENU_INC_DIR . "/vendor/scssphp/scssc.inc.php";
        }

        $scssc = new scssc();
        $scssc->setFormatter( 'scss_formatter' );

        $import_paths = apply_filters('stmenu_scss_import_paths', array(
            get_stylesheet_directory() . "/stars-menu/scss",
            get_stylesheet_directory() ,
            get_template_directory() . "/stars-menu/scss",
            get_template_directory() ,
            trailingslashit( WP_PLUGIN_DIR )
        ));

        foreach ( $import_paths as $path ) {
            $scssc->addImportPath( $path );
        }

        try {
            return $scssc->compile( $this->get_location_complete_scss( $menus , $theme ) );
        }
        catch ( Exception $e ) {
            $message = __("Warning: CSS compilation failed. Please check your changes and fields validation errors", "megamenu");

            return new WP_Error( 'scss_compile_fail', $message . "<br /><br />" . $e->getMessage() );
        }

    }

    /**
     * Generates a SCSS string which includes the variables for a menu theme,
     * for a particular menu location.
     *
     * @since 1.0.0
     * @return string
     * @param string $theme
     * @param string $location
     * @param int $menu_id
     */
    private function get_location_complete_scss( $menus , $theme ) {

        $wrap_selector = array();

        $i = 0;

        foreach ( $menus As $location => $menu_id ) {

            if( $i > 0 ) {
                $wrap_selector[] = "'" . stmenu_base_wrapper_id($location) . "'";
                //$menu_selector = apply_filters( "stmenu_scss_menu_selector", "#stars-menu-{$sanitized_location}", $menu_id, $location );
            }else{
                $vars['wrap'] = "'" . stmenu_base_wrapper_id($location) . "'";
            }

            $i++;
        }

        $wrap_selector = join("," , $wrap_selector );

        $wrap_selector = apply_filters("stmenu_scss_wrap_selector", $wrap_selector , $menus, $theme);

        $vars['wrap_selector'] = "($wrap_selector)";

        //$vars['menu'] = "'$menu_selector'";
        $vars['menu_id'] = "'$menu_id'";

        $vars['stmenu_responsive_breakpoint'] = stmenu_get_option( 'general_responsive_breakpoint' );

        $options = $this->stmenu->options_manager->menu_theme_settings->panel_options;

        foreach ( $options AS $option ){

            if( isset( $option['is_style_variable'] ) && isset( $option['id'] ) && $option['is_style_variable'] === true ){

                $key = str_replace( "theme_style_" , "" , $option['id'] );

                $value = stmenu_theme_option( $option['id'] , $theme );

                if( isset( $option['css_sanitize'] ) ){

                    $value = $this->css_sanitize( $option['css_sanitize'] , $value , $option );

                }

                $vars[$key] = $value;

            }

        }

        $vars = apply_filters( "stmenu_scss_variables", $vars, $options , $menus, $theme );

        $scss = "";

        foreach ($vars as $name => $value) {
            $scss .= "$" . $name . ": " . $value . ";\n";
        }

        $scss .= $this->load_scss_file();

        //Custom Scss Or Css
        $custom_scss = stmenu_theme_option( 'theme_custom_css' , $theme );

        $scss .= stripslashes( html_entity_decode( $custom_scss , ENT_QUOTES ) );

        return apply_filters( "stmenu_scss_output", $scss, $menus, $theme );

    }

    public function dynamic_scss_variables( $vars, $options , $menus , $theme ){

        $style_options = array();

        foreach ( $options AS $option ){

            if( !isset( $option['id'] ) ){
                continue;
            }

            $key = str_replace( "theme_style_" , "" , $option['id'] );

            $value = stmenu_theme_option( $option['id'] , $theme );

            if( isset( $option['css_sanitize'] ) ){

                $value = $this->css_sanitize( $option['css_sanitize'] , $value , $option );

            }

            $style_options[ $key ] = $value;

        }

        extract( $style_options );

        $vars['stmenu_wrap_width'] = ( $menubar_dimensions == "full" ) ? '100%' : $menubar_width;

        //$vars['stmenu_wrap_bg_color'] = ( $menubar_transparent == "on" ) ? "transparent" : $menubar_bg_color;

        $vars['stmenu_wrap_inner_width'] = ( $navigation_length == "full" ) ? '100%' : $navigation_width;

        $vars['stmenu_responsive_enable'] = ( $theme_responsive_enable === true ) ? "on" : "off";

        $vars = array_merge( $vars , $this->get_font_vars( $menubar_font , 'stmenu_wrap' , array( 'color' , 'line-height' ) ) );

        return $vars;

    }

    public function get_font_vars( $value , $id ,  $skip = array() ){


        $skip = array_merge( $skip , array( 'dark' , 'text', 'font-type', 'text-shadow-distance', 'text-shadow-blur', 'text-shadow-color', 'text-shadow-opacity' ) );

        $vars = array();

        foreach ( $value AS $key => $val ) {

            if ( in_array( $key, $skip ) ) {
                continue;
            }

            $variable = $id . "_" . str_replace( "-" , "_" , $key );

            if ( $key == 'font-family' ) {

                if ( ! empty( $value['font-type'] ) && $val != "inherit" ) {
                    if ( $value['font-type'] == 'google' ) {

                        $vars[$variable] = '"' . $val . '"';

                        continue;
                    }
                }

                $vars[$variable] = $val;

                continue;
            }

            if ( $key == 'text-shadow-location' ) {
                $textShadow = '';
                if ( $value[ $key ] != 'none' ) {
                    if ( stripos( $value[ $key ], 'left' ) !== false ) {
                        $textShadow .= '-' . $value['text-shadow-distance'];
                    } else if ( stripos( $value[ $key ], 'right' ) !== false ) {
                        $textShadow .= $value['text-shadow-distance'];
                    } else {
                        $textShadow .= '0';
                    }
                    $textShadow .= ' ';
                    if ( stripos( $value[ $key ], 'top' ) !== false ) {
                        $textShadow .= '-' . $value['text-shadow-distance'];
                    } else if ( stripos( $value[ $key ], 'bottom' ) !== false ) {
                        $textShadow .= $value['text-shadow-distance'];
                    } else {
                        $textShadow .= '0';
                    }
                    $textShadow .= ' ';
                    $textShadow .= $value['text-shadow-blur'];
                    $textShadow .= ' ';

                    $rgb = tf_hex2rgb( $value['text-shadow-color'] );
                    $rgb[] = $value['text-shadow-opacity'];

                    $textShadow .= 'rgba(' . implode( ',', $rgb ) . ')';
                } else {
                    $textShadow .= $value[ $key ];
                }

                $variable = $id . "_text_shadow";

                $vars[$variable] = $textShadow;

                continue;
            }

            $vars[$variable] = $val;

        }

        return $vars;

    }

    public function css_sanitize( $sanitize , $value , $option ){

        if( is_string( $sanitize ) ){

            $sanitize = array( $sanitize );

        }else if( ! is_array( $sanitize ) ){

            return $value;

        }

        $default = isset( $option['default'] ) ? $option['default'] : '';

        foreach ( $sanitize AS $method ){

            $method .= "_sanitize";

            if( method_exists( __CLASS__ , $method ) ){

                $value = call_user_func_array( array( $this , $method ) , array( $value , $default , $option ) );

            }

        }

        return $value;

    }

    public function require_sanitize( $value , $default , $option ){

        if( empty( $value ) ){

            $value = empty( $default ) ? "''" : $default;

        }

        return $value;

    }

    public function attachment_sanitize( $value , $default , $option ){

        return stmenu_get_background_image( $value );

    }

    public function spacing_sanitize( $value , $default , $option ){

        $new_value = array();

        foreach ( $value AS $key => $val ) {

            if ( empty($val) && $val !== 0 && $val !== '0' ) {

                $sub_val = isset( $default[$key] ) ? $default[$key] : 0;

                $sub_val = ( empty($sub_val) && $sub_val !== 0 && $sub_val !== '0' ) ? 0 : $sub_val;

                $new_value[] = $sub_val;

            }else{

                $new_value[] = $val;

            }

        }

        return implode( " " , $new_value );

    }

    public function shadow_sanitize( $value , $default , $option ){

        if( $value['enable'] == "off" ){

            $new_value = "none";

        }else{

            unset( $value['enable'] );

            foreach ( $value AS $prop => $val ){

                if( $prop != "color" ) {
                    $value[$prop] = (empty($val) && $val !== 0 && $val !== '0') ? 0 : $val;
                }else{
                    $value[$prop] = empty($val) ? "transparent" : $val;
                }

            }

            $values = array_values( $value );

            $new_value = implode( " " , $values );

        }

        return $new_value;

    }

    /**
     * Return the path to the megamenu.scss file, look for custom files before
     * loading the core version.
     *
     * @since 1.0.0
     * @return string
     */
    private function load_scss_file() {

        $scss  = '';

        $locations = $this->get_possible_scss_file_locations();

        foreach ( $locations as $path ) {

            if ( file_exists( $path ) ) {

                $scss .= file_get_contents( $path );
                //break;
                //
                // @todo: add a break here. This is a known bug but some users may be relying on it.
                // Add warning message to plugin to alert users about not using custom megamenu.scss files
                // then fix the bug in a later release.
            }

        }

        return apply_filters( "stmenu_load_scss_file_contents", $scss);

    }

    /**
     * Return an array of all the possible file path locations for the SCSS file
     * @since 1.0.0
     * @return array
     */
    private function get_possible_scss_file_locations() {
        return apply_filters( "stmenu_scss_locations", array(
            get_stylesheet_directory() . "/stars-menu/scss/stars-menu.scss" , // child theme
            get_template_directory() . "/stars-menu/scss/stars-menu.scss", // parent theme
            $this->get_default_scss_file_location()
        ));
    }

    /**
     * Return the default SCSS file path
     *
     * @since 1.0.0
     * @return string
     */
    private function get_default_scss_file_location() {
        return STARS_MENU_ASSETS_DIR . '/css/stars-menu.scss';
    }

    /**
     *
     * @since 1.0.0
     */
    private function save_to_filesystem( $css , $theme ) {
        global $wp_filesystem;

        if ( ! $wp_filesystem ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload_dir = wp_upload_dir();
        $filename = $this->get_css_filename( $theme );
        $dir = trailingslashit( $upload_dir['basedir'] ) . 'stars-menu/';

        WP_Filesystem( false, $upload_dir['basedir'], true );

        if( ! $wp_filesystem->is_dir( $dir ) ) {
            $wp_filesystem->mkdir( $dir );
        }

        $settings = get_option( 'stars_menu_general_settings' , array() );

        if ( ! $wp_filesystem->put_contents( $dir . $filename, $css ) ) {

            // File write failed.
            $settings['css_file_save_permission'] = 'no';

            $settings["stars_menu_{$theme}_theme"] = $css;

        }else{

            if( isset( $settings["stars_menu_{$theme}_theme"] ) ){
                unset( $settings["stars_menu_{$theme}_theme"] );
            }

            $settings['css_file_save_permission'] = 'yes';

        }

        update_option( 'stars_menu_general_settings', $settings );

    }

    /**
     * Return the filename to use for the stylesheet, ensuring the filename is unique
     * for multi site setups
     *
     * @since 1.0.0
     */
    private function get_css_filename( $theme ) {

        return apply_filters( "stmenu_css_filename", "{$theme}-theme-style" ) . '.css';

    }


}

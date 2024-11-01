<?php
/*
Plugin Name: Stars Menu
Plugin URI: http://www.stars-menu.com/
Description: Stars Menu is a powerful menu plugin for WordPress
Author: Stars Team
Author URI: http://www.stars-menu.com/stars-team
Version: 1.0.1
*/

if(!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

if ( ! defined( 'STARS_MENU_PLUGIN_BASENAME' ) )
    define( 'STARS_MENU_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'STARS_MENU_PLUGIN_NAME' ) )
    define( 'STARS_MENU_PLUGIN_NAME', trim( dirname( STARS_MENU_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'STARS_MENU_PLUGIN_DIR' ) )
    define( 'STARS_MENU_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . STARS_MENU_PLUGIN_NAME );

if ( ! defined( 'STARS_MENU_PLUGIN_URL' ) )
    define( 'STARS_MENU_PLUGIN_URL', WP_PLUGIN_URL . '/' . STARS_MENU_PLUGIN_NAME );

if ( ! defined( 'STARS_MENU_ASSETS_DIR' ) )
    define( 'STARS_MENU_ASSETS_DIR', STARS_MENU_PLUGIN_DIR . '/assets' );

if ( ! defined( 'STARS_MENU_ASSETS_URL' ) )
    define( 'STARS_MENU_ASSETS_URL', STARS_MENU_PLUGIN_URL . '/assets' );

if ( ! defined( 'STARS_MENU_INC_DIR' ) )
    define( 'STARS_MENU_INC_DIR', STARS_MENU_PLUGIN_DIR . '/includes' );

if ( ! defined( 'STARS_MENU_VIEW_DIR' ) )
    define( 'STARS_MENU_VIEW_DIR', STARS_MENU_PLUGIN_DIR . DS . 'view' );

if ( ! defined( 'STARS_MENU_MODULE_DIR' ) )
    define( 'STARS_MENU_MODULE_DIR', STARS_MENU_PLUGIN_DIR . DS . 'modules' );

if ( ! defined( 'STARS_MENU_VERSION' ) )
    define( 'STARS_MENU_VERSION', '1.0.1' );

if ( ! defined( 'STARS_MENU_VERSION_TYPE' ) )
    define( 'STARS_MENU_VERSION_TYPE', 'free' );

if ( ! defined( 'STARS_MENU_PLUGIN_FILE' ) )
    define( 'STARS_MENU_PLUGIN_FILE', __FILE__ );

if ( ! defined( 'STARS_MENU_SUPPORT_URL' ) )
    define( 'STARS_MENU_SUPPORT_URL' , 'https://www.stars-menu.com/support' );

/**
 * Class StarsMenu
 */
final class StarsMenu{

    /**
     * The Options Manager instance of the StarsMenuOptionsManager class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $options_manager;

    /**
     * The Elements Manager instance of the StarsMenuElementsManager class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $elements_manager;

    /**
     * The Css Manager instance of the StarsMenuCssManager class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $css_manager;

    /**
     * The Options Manager instance of the LA_IconManager class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $icon_manager;

    /**
     * The Updater Manager instance of the StarsMenuUpdater class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    private $updater;

    /**
     * The Custom Menu Item Types instance of the StarsMenuCustomItemTypes class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    private $custom_item_types;

    /**
     * The Custom Menu Item Types instance of the StarsMenuCustomLocation class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $custom_menu_location;

    /**
     * The Custom Menu Item Types instance of the StarsMenuCustomLocation class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    public $custom_widget_area;

    /**
     * The Current Theme
     *
     * @var string
     * @since 0.1
     */
    public $current_theme = 'default';

    /**
     * The Current Theme
     *
     * @var string
     * @since 0.1
     */
    public $js_configs = array();

    /**
     * The single instance of the class.
     *
     * @var StarsMenu
     * @since 0.1
     */
    protected static $_instance = null;

    /**
     * Main StarsMenu Instance.
     *
     * Ensures only one instance of StarsMenu is loaded or can be loaded.
     *
     * @since 0.9
     * @static
     * @see StMenu()
     * @return StarsMenu - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * StarsMenu constructor.
     */
    public function __construct(){

        //localize
        add_action( 'plugins_loaded', array(&$this, 'localization') );

        $this->includes();

    }

    public function localization() {

        load_plugin_textdomain( "stars-menu" , false, dirname( plugin_basename( STARS_MENU_PLUGIN_FILE ) ) . "/languages" );

    }

    public function includes(){

        require_once STARS_MENU_INC_DIR . '/functions.php';

        $this->load_icons_manager();

        require_once STARS_MENU_INC_DIR . '/vendor/titan-framework/titan-framework-embedder.php' ;

        require_once STARS_MENU_INC_DIR . '/stars-menu-options-manager.class.php' ;

        $this->options_manager = new StarsMenuOptionsManager( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-element-manager.class.php' ;

        $this->elements_manager = new StarsMenuElementsManager( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-css-manager.class.php' ;

        $this->css_manager = new StarsMenuCssManager( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-widget.class.php' ;

        require_once STARS_MENU_INC_DIR . '/stars-menu-custom-item-types.class.php' ;

        $this->custom_item_types = new StarsMenuCustomItemTypes( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-custom-location.php' ;

        $this->custom_menu_location = new StarsMenuCustomLocation( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-custom-widget-area.php' ;

        $this->custom_widget_area = new StarsMenuCustomWidgetArea( $this );

        require_once STARS_MENU_INC_DIR . '/stars-menu-pro-version.php' ;

        $pro_version = new StarsMenuProVersion( $this );

        //Load Modules
        require_once STARS_MENU_MODULE_DIR . '/modern-horizontal/modern-horizontal.php';
        
        new StarsMenuModernHorizontalDesign( $this );

        add_action( 'init'                                  , array( $this, 'theme_post_type' ), 0 );

        add_action( 'admin_menu'                            , array( $this, 'app_create_menu') );

        add_action( 'admin_init'                            , array( $this, 'register_nav_meta_box' ), 9 );

        add_action( 'wp_ajax_stars_menu_save_settings'      , array( $this, 'save_settings') );

        add_action( 'admin_enqueue_scripts'                 , array( $this, 'admin_scripts' ) );

        add_filter( 'wp_nav_menu_args'                      , array( $this, 'automatic_integration_filter' ) , 1000 );

        add_action( 'widgets_init'                          , array( $this, 'register_widget' ) );

        add_shortcode( 'starsmenu'                          , array( $this, 'register_shortcode' ) );

        add_filter( 'wp_nav_menu'                           , array( $this, 'responsive_toggle_filter' ) , 10, 2 );

        add_action( 'wp_enqueue_scripts'                    , array( $this, 'scripts' ) );

        add_action( 'wp_footer'                             , array( $this, 'print_js_configs' ) , 10000 );

        add_filter( 'template_include'                      , array(&$this, 'theme_preview') , 1 );
    }

    public function scripts(){

        wp_enqueue_script( "stars-transition-events" , STARS_MENU_ASSETS_URL . "/js/transition-events.js" , array("jquery" ) ,'1.0.0', true );

        wp_enqueue_script( "hammer-js" , STARS_MENU_ASSETS_URL . "/js/hammer.min.js" , array("jquery" ) ,'1.0.0', true );

        wp_enqueue_script( "jquery.easing" , STARS_MENU_ASSETS_URL . "/js/jquery.easing.min.js" , array("jquery" ) ,'1.0.0', true );

        wp_enqueue_script( "stars-menu-script" , STARS_MENU_ASSETS_URL . "/js/scripts.js" , array("jquery" , "underscore" , "stars-transition-events" ,  "hammer-js" , "jquery.easing" ) ,'1.0.0', true );

        $breakpoint = stmenu_get_option( 'general_responsive_breakpoint' );

        $media = "all and (min-width: {$breakpoint}px)";

        wp_enqueue_style( "stars-menu-open-animation" , STARS_MENU_ASSETS_URL . "/css/animations-hover-effects.css" , array() , '1.0.0' , $media );

        wp_enqueue_style( "stars-menu-hamburger-icons" , STARS_MENU_ASSETS_URL . "/css/hamburger-icons.css" , array() , '1.0.0'  );

    }


    public function admin_scripts(){

        wp_enqueue_style( "stars-menu-admin-icons" , STARS_MENU_ASSETS_URL . "/fonts/starsmenu-admin/css/style.css" , array() , '1.0.0'  );

        if( !is_starsmenu_admin() ){
            return false;
        }

        wp_enqueue_script( "custom-scrollbar" , STARS_MENU_ASSETS_URL . "/js/jquery.mCustomScrollbar.concat.min.js", array("jquery"), '2.3' );

        wp_enqueue_script( "stars-menu-jquery-livequery" , STARS_MENU_ASSETS_URL . "/js/jquery.livequery.min.js" , array( "jquery"  ) ,'1.0.0', true );

        wp_enqueue_script('wp-ajax-response');

        wp_enqueue_script( "stars-menu-admin-script" , STARS_MENU_ASSETS_URL . "/js/admin-scripts.js" , array("jquery" , "underscore" , "jquery-ui-tooltip" , "custom-scrollbar" , "stars-menu-jquery-livequery" ) ,'1.0.0', true );

        wp_localize_script(
            "stars-menu-admin-script",
            'laim_localize',
            array(
                'ajax_nonce' => wp_create_nonce('stmenu_icon'),
                'ajaxurl' => admin_url('admin-ajax.php'),
            )
        );

        wp_enqueue_style( "stars-menu-admin-style" , STARS_MENU_ASSETS_URL . "/css/admin-style.css" , array() , '1.0.0'  );

        wp_enqueue_style( "stars-menu-mCustomScrollbar-style" , STARS_MENU_ASSETS_URL . "/css/jquery.mCustomScrollbar.css" , array() , '1.0.0'  );
  
    }

    public function load_icons_manager(){  

        if ( !class_exists('LA_IconManager') ) {
            require_once STARS_MENU_INC_DIR . '/vendor/icon_manager/IconManager.php';
        }

        $fonts = trailingslashit(plugin_dir_path(STARS_MENU_PLUGIN_FILE) . 'fonts');

        $this->icon_manager = LA_IconManager::getInstance($fonts);

        add_action('wp_enqueue_scripts', array( $this->icon_manager , 'enqueuePublicScripts'), 9);

        register_activation_hook(STARS_MENU_PLUGIN_FILE , array( $this->icon_manager , 'addDefaultFonts' ) );

        register_deactivation_hook(STARS_MENU_PLUGIN_FILE , 'LA_IconManager::deleteOption' );

    }

    public function responsive_toggle_filter( $nav_menu , $args ){

        // make sure we're working with a Mega Menu
        if ( ! is_a( $args->walker, 'StMenu_Walker_Nav_Menu' ) || ( isset( $args->related_menu ) && $args->related_menu === true ) )
            return $nav_menu;

        $wrapper_class = array();

        $theme_horizontal_type = stmenu_theme_option( 'theme_horizontal_type' , $this->current_theme );

        if( $theme_horizontal_type == "normal" ){

            $wrapper_class[] = "stars-menu-hz-normal";

        }else if( $theme_horizontal_type == "hamburger" ){

            $wrapper_class[] = "stars-menu-hz-hamburger";

            $theme_hamburger_background_enable = stmenu_theme_option( 'theme_hamburger_background_enable' , $this->current_theme );

            if( $theme_hamburger_background_enable ) {

                //theme_hamburger_background_opened_type
                $theme_hamburger_background_opened_type = 'fade';
                $wrapper_class[] = "starsmenu-bg-{$theme_hamburger_background_opened_type}";

                $wrapper_class[] = "starsmenu-bg-opened";

            }

            //theme_hamburger_main_nav_opened_type
            $theme_hamburger_main_nav_opened_type = 'fadeIn';
            $wrapper_class[] = "starsmenu-open-{$theme_hamburger_main_nav_opened_type}";

        }

        $elements_divider_enable = stmenu_theme_option( 'theme_elements_divider_enable' , $this->current_theme );

        if( $elements_divider_enable ){
            $wrapper_class[] = 'starsmenuElementsDivider';
        }

        $mobile_menu_divider_enable = stmenu_theme_option( 'theme_mobile_menu_divider_enable' , $this->current_theme );

        if( $mobile_menu_divider_enable ){
            $wrapper_class[] = 'starsmenuMobileDivider';
        }

        $top_level_items_divider_enable = stmenu_theme_option( 'theme_top_level_items_divider_enable' , $this->current_theme );

        if( $top_level_items_divider_enable ){
            $wrapper_class[] = 'starsmenuTopLevelDivider';
        }

        $submenus_items_divider_enable = stmenu_theme_option( 'theme_submenus_items_divider_enable' , $this->current_theme );

        if( $submenus_items_divider_enable ){
            $wrapper_class[] = 'starsmenuSubmenuDivider';
        }

        //theme_hamburger_effect
        $wrapper_class[] = 'starsmenutrigger-1';

        $wrapper_class[] = "starsmenuTopLevelHoverFill-Simple";

        $wrapper_class[] = "starsmenuTopLevelHover";

        $theme_top_level_full_height = stmenu_theme_option( 'theme_top_level_full_height' , $this->current_theme );

        if( $theme_top_level_full_height ){
            $wrapper_class[] = 'starsmenu-top-level-full-height';  
        }

        $theme_submenus_transition = 'fadeIn';

        $wrapper_class[] = "starsmenu-submenu-{$theme_submenus_transition}";


        //theme_responsive_menu_box_direction
        $wrapper_class[] = 'starsmenu-responsive-box-left-direction';

        $submenus_open_direction = stmenu_theme_option('theme_sub_items_submenus_open_direction' , $this->current_theme );

        $wrapper_class[] = ( $submenus_open_direction == 'left' ) ? 'starsmenu-toggle-submenus-open-left-direction' : 'starsmenu-toggle-submenus-open-right-direction';

        $hide_background_image_mobile = stmenu_theme_option('theme_submenus_background_image_mobile_hide' , $this->current_theme );

        if( $hide_background_image_mobile ){
            $wrapper_class[] = 'starsmenu-background-image-mobile-hide';
        }

        $hide_background_image_desktop = stmenu_theme_option('theme_submenus_background_image_desktop_hide' , $this->current_theme );

        if( $hide_background_image_desktop ){
            $wrapper_class[] = 'starsmenu-background-image-desktop-hide';
        }

        $wrapper_class[] = stmenu_base_wrapper_id( $args->theme_location );

        $wrapper_id = stmenu_get_wrapper_id( $args->theme_location );

        $wrapper_class_names = implode( " " , $wrapper_class );

        $design_layouts = stmenu_theme_option('theme_menu_design_order_layouts' , $this->current_theme );

        $areas = array();

        $_main_nav_area = "";

        $_hamburger_area = "";

        if( is_array( $design_layouts ) && !empty( $design_layouts ) ) { 

            uasort( $design_layouts , 'stmenu_elements_order' );

            foreach ( $design_layouts AS $layout ) {

                switch ( $layout['id'] ){

                    case "hamburger-mode" :

                        $el_string = "{{{hamburger-mode}}}";

                        $_hamburger_area = $layout['area'];

                        break;

                    case "main-navigation" :

                        $el_string = "{{{main-navigation}}}";

                        $_main_nav_area = $layout['area'];

                        break;
                    default :

                        $element_obj = $this->elements_manager->get_element( $layout['id'] );


                        $el_string = ( !is_null( $element_obj ) ) ? $element_obj->get_template() : "";

                }

                if( !isset( $areas[$layout['area']] ) ){
                    $areas[$layout['area']] = $el_string;
                }else{
                    $areas[$layout['area']] .= $el_string;
                }

            }

        }

        $center_area    = ( isset( $areas['sortable-center'] ) ) ? $areas['sortable-center'] : "";

        $left_area      = ( isset( $areas['sortable-left'] ) ) ? $areas['sortable-left'] : "";

        $right_area     = ( isset( $areas['sortable-right'] ) ) ? $areas['sortable-right'] : "";

        $left_nav       = ( isset( $areas['sortable-left-nav'] ) ) ? $areas['sortable-left-nav'] : "";

        $right_nav      = ( isset( $areas['sortable-right-nav'] ) ) ? $areas['sortable-right-nav'] : "";

        $area_strings = array(
            'right_area'        =>  'sortable-right' ,
            'center_area'       =>  'sortable-center' ,
            'left_area'         =>  'sortable-left'
        );

        $_hamburger_template = stmenu_get_template_html( "modern-horizontal/hamburger-mode.php" , array() );

        $_main_nav_template = stmenu_get_template_html( "modern-horizontal/main-navigation.php" , array(
            'left_nav'              => $left_nav ,
            'right_nav'             => $right_nav ,
            'nav_menu'              => $nav_menu
        ));

        foreach ( $area_strings AS $key => $area ) {

            if( $_hamburger_area == $area ) {
                $$key = str_replace("{{{hamburger-mode}}}", $_hamburger_template , $$key);
            }

            if( $_main_nav_area == $area ) {
                $$key = str_replace("{{{main-navigation}}}", $_main_nav_template , $$key);
            }

        }

        $before_menu = stmenu_theme_option('theme_content_before_menu' , $this->current_theme );

        $after_menu = stmenu_theme_option('theme_content_after_menu' , $this->current_theme );

        $responsive_close_icon = stmenu_theme_option( 'theme_responsive_close_icon' , $this->current_theme );

        if( !empty( $responsive_close_icon ) ) {

            $responsive_close_icon = LA_IconManager::getIconClass($responsive_close_icon);

        }

        $nav_menu = stmenu_get_template_html( "modern-horizontal/nav_menu.php" , array(
            'wrapper_class_names'   => $wrapper_class_names ,
            'center_area'           => $center_area ,
            'left_area'             => $left_area ,
            'right_area'            => $right_area ,
            'wrapper_id'            => $wrapper_id ,
            'before_menu'           => $before_menu ,
            'after_menu'            => $after_menu ,
            'responsive_close_icon' => $responsive_close_icon
        ));
        
        return $nav_menu;

    }

    /**
     * Adds the meta box container
     *
     * @since 1.0
     */
    public function register_nav_meta_box() {
        global $pagenow;

        if ( 'nav-menus.php' == $pagenow ) {

            if ( isset( $_GET['stars_menu_get_started'] ) &&  ( ! isset( $_POST ) || ! count( $_POST ) ) ) {
                $class = 'stars_menu_meta_box stars_menu_get_started';
            } else {
                $class = 'stars_menu_meta_box';
            }

            add_meta_box(
                $class,
                __("Stars Menu Settings", "stars-menu"),
                array( $this, 'metabox_contents' ),
                'nav-menus',
                'side',
                'high'
            );

        }

    }

    /**
     * Show the Meta Menu settings
     *
     * @since 1.0
     */
    public function metabox_contents() {

        $menu_id = $this->get_selected_menu_id();

        $this->print_enable_megamenu_options( $menu_id );

    }

    /**
     * Get the current menu ID.
     *
     * Most of this taken from wp-admin/nav-menus.php (no built in functions to do this)
     *
     * @since 1.0
     * @return int
     */
    public function get_selected_menu_id() {

        $nav_menus = wp_get_nav_menus( array('orderby' => 'name') );

        $menu_count = count( $nav_menus );

        $nav_menu_selected_id = isset( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0;

        $add_new_screen = ( isset( $_GET['menu'] ) && 0 == $_GET['menu'] ) ? true : false;

        // If we have one theme location, and zero menus, we take them right into editing their first menu
        $page_count = wp_count_posts( 'page' );
        $one_theme_location_no_menus = ( 1 == count( get_registered_nav_menus() ) && ! $add_new_screen && empty( $nav_menus ) && ! empty( $page_count->publish ) ) ? true : false;

        // Get recently edited nav menu
        $recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
        if ( empty( $recently_edited ) && is_nav_menu( $nav_menu_selected_id ) )
            $recently_edited = $nav_menu_selected_id;

        // Use $recently_edited if none are selected
        if ( empty( $nav_menu_selected_id ) && ! isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) )
            $nav_menu_selected_id = $recently_edited;

        // On deletion of menu, if another menu exists, show it
        if ( ! $add_new_screen && 0 < $menu_count && isset( $_GET['action'] ) && 'delete' == $_GET['action'] )
            $nav_menu_selected_id = $nav_menus[0]->term_id;

        // Set $nav_menu_selected_id to 0 if no menus
        if ( $one_theme_location_no_menus ) {
            $nav_menu_selected_id = 0;
        } elseif ( empty( $nav_menu_selected_id ) && ! empty( $nav_menus ) && ! $add_new_screen ) {
            // if we have no selection yet, and we have menus, set to the first one in the list
            $nav_menu_selected_id = $nav_menus[0]->term_id;
        }

        return $nav_menu_selected_id;

    }

    /**
     * Return the locations that a specific menu ID has been tagged to.
     *
     * @param $menu_id int
     * @return array
     */
    public function get_tagged_theme_locations_for_menu_id( $menu_id ) {

        $locations = array();

        $nav_menu_locations = get_nav_menu_locations();

        foreach ( get_registered_nav_menus() as $id => $name ) {

            if ( isset( $nav_menu_locations[ $id ] ) && $nav_menu_locations[$id] == $menu_id )
                $locations[$id] = $name;

        }

        return $locations;
    }

    /**
     * Print the custom Meta Box settings
     *
     * @param int $menu_id
     * @since 1.0
     */
    public function print_enable_megamenu_options( $menu_id ) {

        $tagged_menu_locations = $this->get_tagged_theme_locations_for_menu_id( $menu_id );
        $theme_locations = get_registered_nav_menus();

        $saved_settings = get_option( 'stars_menu_integration_settings' , array() );

        if ( ! count( $theme_locations ) ) {

            $link = '<a href="https://www.stars-menu.com/documentation/integration-with-widget/" target="_blank">' . __("here", "stars-menu") . '</a>';

            echo "<p>" . __("This theme does not register any menu locations.", "stars-menu") . "</p>";
            echo "<p>" . __("You will need to create a new menu location and use the Stars Menu widget or shortcode to display the menu on your site.", "stars-menu") . "</p>";
            echo "<p>" . str_replace( "{link}", $link, __("Click {link} for instructions.", "stars-menu") ) . "</p>";

        } else if ( ! count ( $tagged_menu_locations ) ) {

            echo "<p>" . __("Please assign this menu to a theme location to enable the Mega Menu settings.", "stars-menu") . "</p>";

        } else { ?>

            <?php if ( count( $tagged_menu_locations ) == 1 ) : ?>

                <?php

                $locations = array_keys( $tagged_menu_locations );
                $location = $locations[0];

                if (isset( $tagged_menu_locations[ $location ] ) ) {
                    $this->settings_table( $location, $saved_settings );
                }

                ?>

            <?php else: ?>

                <div id='megamenu_accordion'>

                    <?php foreach ( $theme_locations as $location => $name ) : ?>

                        <?php if ( isset( $tagged_menu_locations[ $location ] ) ): ?>

                            <h3 class='theme_settings'><?php echo esc_html( $name ); ?></h3>

                            <div class='accordion_content'>
                                <?php $this->settings_table( $location, $saved_settings ); ?>
                            </div>

                        <?php endif; ?>

                    <?php endforeach;?>
                </div>

            <?php endif; ?>


        <div>
            <?php

            submit_button( __( 'Save' ), 'stars-menu-save-settings-btn button-primary alignright','submit', false); 


            ?>

            <span class='spinner'></span>

        </div>
            <?php

        }

    }


    /**
     * Print the list of Mega Menu settings
     *
     * @since 1.0
     */
    public function settings_table( $location, $settings ) {
        ?>
        <table id="stars-menu-nav-settings-table">  

            <tr>
                <td><?php _e("Enable", "stars-menu") ?></td>
                <td>
                    <input type='checkbox' class='megamenu_enabled' name='stars_menu_meta[<?php echo $location ?>][enabled]' value='1' <?php checked( isset( $settings[$location]['enabled'] ) ); ?> />
                </td>
            </tr>

            <tr>

                <td><?php _e("Theme", "stars-menu"); ?></td>

                <td>

                    <select name='stars_menu_meta[<?php echo $location ?>][theme]'>

                        <?php

                        $args = array(
                            'post_type'             => 'stars_menu_themes' ,
                            'posts_per_page'        => -1 ,
                            'post_status'           => 'publish'
                        );

                        $themes = get_posts( $args );

                        $selected_theme = isset( $settings[$location]['theme'] ) ? $settings[$location]['theme'] : 'default';

                        echo "<option value='default' " . selected( $selected_theme, 'default' ) . ">" . __("default" , "stars-menu") . "</option>";

                        $locations = get_nav_menu_locations();

                        $current_menu_id = $locations[$location];

                        foreach ( $themes as $theme ) {

                            $key = $theme->ID;

                            $dynamic_elements = stmenu_theme_option( 'theme_dynamic_elements' , $key );

                            $menu_ids = array();

                            if( is_array( $dynamic_elements ) && !empty( $dynamic_elements ) ) {
                                $menu_ids = wp_list_pluck( $dynamic_elements , 'menu_id' );
                            }

                            if( in_array( $current_menu_id , $menu_ids ) ){
                                continue;
                            }

                            $title = get_the_title( $theme->ID );

                            echo "<option value='{$key}' " . selected( $selected_theme, $key ) . ">{$title}</option>";

                        }

                        ?>

                    </select>

                </td>

            </tr>

            <?php do_action( 'stars_menu_integration_settings_table', $location, $settings ); ?>
        </table>
        <?php
    }

    /**
     * Save the mega menu settings (submitted from Menus Page Meta Box)
     *
     * @since 1.0
     */
    public function save_settings() {

        check_ajax_referer( 'add-menu_item', 'nonce' );

        if ( isset( $_POST['menu'] ) && $_POST['menu'] > 0 && is_nav_menu( $_POST['menu'] ) && isset( $_POST['stars_menu_meta'] ) ) {

            $raw_submitted_settings = $_POST['stars_menu_meta'];

            $parsed_submitted_settings = json_decode( stripslashes( $raw_submitted_settings ), true );

            $location = '';

            $submitted_settings = array();

            foreach ( $parsed_submitted_settings as $index => $value ) {
                $name = $value['name'];

                // find values between square brackets
                preg_match_all( "/\[(.*?)\]/", $name, $matches );

                if ( isset( $matches[1][0] ) && isset( $matches[1][1] ) ) {
                    $location = $matches[1][0];
                    $setting = $matches[1][1];

                    $submitted_settings[$location][$setting] = $value['value'];
                }
            }

            $old_theme = '';

            if ( ! get_option( 'stars_menu_integration_settings' ) ) {

                update_option( 'stars_menu_integration_settings', $submitted_settings );

            } else {

                $existing_settings = get_option( 'stars_menu_integration_settings' , array() );

                $old_theme = !empty( $location ) && isset( $existing_settings[$location] ) && isset( $existing_settings[$location]['theme'] ) ? $existing_settings[$location]['theme'] : '';

                $new_settings = array_merge( $existing_settings, $submitted_settings );

                update_option( 'stars_menu_integration_settings', $new_settings );

            }

            do_action( "stmenu_after_save_integration_settings" , $submitted_settings[$location] );

            if( !empty( $old_theme ) ){

                do_action( "stmenu_integration_old_theme_output_css" , $old_theme );

            }

            do_action( "stmenu_integration_settings_output_css" , $submitted_settings[$location]['theme'] );

            wp_send_json_success( array(
                "message"   => __("Saved Settings Success" , "stars-menu")
            ));

        }else{

            wp_send_json_error( array(
                "message"   => __("Send data is invalid" , "stars-menu")
            ));

        }
    }

    public function automatic_integration_filter( $args ){

        $args = $this->get_nav_menu_args( $args );

        return $args;
    }

    protected function get_nav_menu_args( $args ){

        if ( ! isset( $args['theme_location'] ) ) {
            return $args;
        }

        // internal filter
        do_action('starsmenu_instance_counter_' . $args['theme_location']);

        $num_times_called = did_action('starsmenu_instance_counter_' . $args['theme_location']);

        $settings = get_option( 'stars_menu_integration_settings' , array() );
        $current_theme_location = $args['theme_location'];
        $active_menu_instances = stmenu_get_option( 'general_active_menu_instances' );
        $active_instance = isset( $active_menu_instances[$current_theme_location] ) ? $active_menu_instances[$current_theme_location] : 0;

        if ( $active_instance != 0 && $active_instance != $num_times_called ) {
            return $args;
        }

        $locations = get_nav_menu_locations();

        if ( isset ( $settings[ $current_theme_location ]['enabled'] ) && $settings[ $current_theme_location ]['enabled'] == true ) {

            if ( ! isset( $locations[ $current_theme_location ] ) ) {
                return $args;
            }

            $menu_id = $locations[ $current_theme_location ];

            if ( ! $menu_id ) {
                return $args;
            }

            $this->current_theme = $settings[ $current_theme_location ]['theme'];

            do_action('starsmenu_loaded_counter_' . $args['theme_location']);

            do_action( 'stmenu_load_dynamic_elements' , $this->current_theme );

            do_action( 'stmenu_before_load_synced_menu' , $this , $menu_id , $this->current_theme , $current_theme_location );

            //$this->css_manager->enqueue_theme_style( $settings[ $current_theme_location ]['theme'] );

            $this->add_menu_js_config( $menu_id , $current_theme_location );

            require_once STARS_MENU_INC_DIR . '/walker-nav-menu.class.php';

            require_once STARS_MENU_INC_DIR . '/stars-menu-item.class.php';

            require_once STARS_MENU_INC_DIR . '/stars-menu-item-default.class.php';

            require_once STARS_MENU_INC_DIR . '/stars-menu-item-custom.class.php';

            require_once STARS_MENU_INC_DIR . '/stars-menu-item-widget-area.class.php';

            $container_tag = stmenu_theme_option( 'theme_container_tag' , $this->current_theme );

            $html_menu_class = stmenu_menu_main_class( $menu_id );

            $args['menu_class'] = 'starsmenu-submenu stars-menu-bar-nav ' . $html_menu_class;

            $args['container'] = $container_tag;

            $menu = wp_get_nav_menu_object( $menu_id );

            $html_menu_id = 'menu-' . $menu->slug;

            $args['menu_id'] = $html_menu_id;

            //$args['item_spacing'] = 'discard';

            $args['container_class'] = 'stars-menu-bar starsmenu-elitem-wrapper starsmenu-elitem-menu-bar';

            $args['walker'] = new StMenu_Walker_Nav_Menu( $menu_id , $settings[ $current_theme_location ]['theme'] );

        }

        return $args;

    }

    public function add_menu_js_config( $menu_id , $theme_location ){

        $wrapper_id = stmenu_get_wrapper_id( $theme_location );

        $theme = $this->current_theme;

        $this->js_configs[] = array(
            'menuId'       =>  $menu_id ,
            'wrapperId'    =>  $wrapper_id,
            'theme'         =>  $theme ,
            'params'        =>  array(
                'isSticky'                      =>  false ,
                'mobileElementsDesign'          =>  stmenu_theme_option( 'theme_responsive_menu_mobile_design' , $theme ) ,
                'breakpoint'                    =>  (int)stmenu_get_option( 'general_responsive_breakpoint' ) ,
                'hamburgerMenuOpenTrigger'      =>  stmenu_theme_option( 'theme_hamburger_opened_trigger' , $theme ) ,
                'scrollAnimate'                 =>  stmenu_theme_option( 'theme_scroll_animate_anchor' , $theme ) ,
                'scrollAnimateDuration'         =>  (int)stmenu_theme_option( 'theme_scroll_animate_duration' , $theme ) ,
                'dropdownCloseHoverDelay'       =>  (int)stmenu_theme_option( 'theme_dropdowns_close_hover_delay' , $theme ) ,
                'hamburgerMenuCloseHoverDelay'   =>  (int)stmenu_theme_option( 'theme_hamburger_menu_close_hover_delay' , $theme ) ,
                'submenuShiftDuration'          =>  (int)stmenu_theme_option( 'theme_style_stmenu_submenu_shift_duration' , $theme ) ,
            )
        );

    }

    public function print_js_configs(){ 

        ?>
        <script type="text/javascript">
            var _starsMenuJsConfigs = <?php if( !empty( $this->js_configs ) ) echo wp_json_encode( $this->js_configs ); else echo "{}"; ?>;
        </script>
        <?php

    }

    public function theme_preview( $template ){

        if( is_singular( 'stars_menu_themes' ) ) {

            stmenu_get_template("theme-preview.php", array());

            return '';

        }

        return $template;

    }

    /**
     * Register widget
     *
     * @since 1.7.4
     */
    public function register_widget() {

        register_widget( 'StarsMenuWidget' );

    }

    /**
     * Shortcode used to display a menu
     *
     * @since 1.3
     * @return string
     */
    public function register_shortcode( $atts ) {

        if ( ! isset( $atts['theme_location'] ) ) {
            return false;
        }

        if ( has_nav_menu( $atts['theme_location'] ) ) {
            return wp_nav_menu( array( 'theme_location' => $atts['theme_location'], 'echo' => false ) );
        }

        return "<!-- menu not found [starsmenu theme_location={$atts['theme_location']}] -->";

    }


    // Register Custom Post Type
    public function theme_post_type() {

        $labels = array(
            'name'                  => _x( 'Stars Menu Themes', 'Post Type General Name', 'stars-menu' ),
            'singular_name'         => _x( 'Stars Menu Theme', 'Post Type Singular Name', 'stars-menu' ),
            'menu_name'             => __( 'Stars Menu Themes', 'stars-menu' ),
            'name_admin_bar'        => __( 'Stars Menu Theme', 'stars-menu' ),
            'archives'              => __( 'Item Archives', 'stars-menu' ),
            'parent_item_colon'     => __( 'Parent Item:', 'stars-menu' ),
            'all_items'             => __( 'All Items', 'stars-menu' ),
            'add_new_item'          => __( 'Add New Item', 'stars-menu' ),
            'add_new'               => __( 'Add New', 'stars-menu' ),
            'new_item'              => __( 'New Item', 'stars-menu' ),
            'edit_item'             => __( 'Edit Item', 'stars-menu' ),
            'update_item'           => __( 'Update Item', 'stars-menu' ),
            'view_item'             => __( 'View Item', 'stars-menu' ),
            'search_items'          => __( 'Search Item', 'stars-menu' ),
            'not_found'             => __( 'Not found', 'stars-menu' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'stars-menu' ),
            'featured_image'        => __( 'Featured Image', 'stars-menu' ),
            'set_featured_image'    => __( 'Set featured image', 'stars-menu' ),
            'remove_featured_image' => __( 'Remove featured image', 'stars-menu' ),
            'use_featured_image'    => __( 'Use as featured image', 'stars-menu' ),
            'insert_into_item'      => __( 'Insert into item', 'stars-menu' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'stars-menu' ),
            'items_list'            => __( 'Items list', 'stars-menu' ),
            'items_list_navigation' => __( 'Items list navigation', 'stars-menu' ),
            'filter_items_list'     => __( 'Filter items list', 'stars-menu' ),
        );

        $args = array(
            'label'                 => __( 'Stars Menu Theme', 'stars-menu' ),
            'description'           => __( 'Create Theme For Stars Menu', 'stars-menu' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'revisions' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
        );

        register_post_type( 'stars_menu_themes', $args );

    }

    public function app_create_menu(){

        add_submenu_page( 'stars-menu' , __("Stars Menu Themes" , "stars-menu") , __("Themes" , "stars-menu") , 'manage_options', "edit.php?post_type=stars_menu_themes" );

        add_submenu_page( 'stars-menu' , __("Add New Themes" , "stars-menu") , __("New Theme" , "stars-menu") , 'manage_options', "post-new.php?post_type=stars_menu_themes" );

    }

    /**
     * Get the template path.
     * @return string
     */
    public function template_path() {
        return apply_filters( 'stmenu_template_path', 'stars-menu/' );
    }

    /**
     * Get the plugin path.
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( STARS_MENU_PLUGIN_FILE ) );
    }

}

/**
 * Main instance of StarsMenu.
 *
 * Returns the main instance of SED to prevent the need to use globals.
 *
 * @since  0.9
 * @return StarsMenu
 */
function StMenu() {
    return StarsMenu::instance();
}

StMenu(); 
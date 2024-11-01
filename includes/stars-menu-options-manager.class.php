<?php
/**
 * Stars Menu General Settings class
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu General Settings class
 *
 * Create & Manege General Settings
 *
 * @Class StarsMenuGeneralSettings
 * @since 1.0.0
 */
class StarsMenuOptionsManager {

    /**
     * The Options instance of the TitanFramework class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $options;

    /**
     * The Options instance of the TitanFramework Admin Panel class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $admin_panel;

    /**
     * The general_settings instance of the StarsMenuGeneralSettings class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $general_settings;

    /**
     * The general_settings instance of the StarsMenuHelpSettings class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $help_settings;

    /**
     * The general_settings instance of the StarsMenuUpdateSettings class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $update_settings;

    /**
     * The general_settings instance of the StarsMenuThemeSettings class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $menu_theme_settings;

    /**
     * The general_settings instance of the StarsMenuItemSettings class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $menu_item_settings;

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $stmenu;

    /**
     * StarsMenuGeneralSettings constructor.
     * @param $stars_menu
     */
	public function __construct( $stars_menu ) {

        $this->stmenu = $stars_menu;

        add_action( 'tf_create_options', array( $this, 'create_options' ) );

        add_action( 'tf_admin_page_before_table_stars_menu', array( $this, 'create_tabs_menu' ) , 10 , 2 );
        add_action( 'tf_post_meta_options_before_table', array( $this, 'create_tabs_menu' ) , 10 , 2 );

        add_action( 'tf_admin_page_after_table_stars_menu', array( $this, 'end_tabs_wrapper' ) , 10 , 2 );
        add_action( 'tf_post_meta_options_after_table', array( $this, 'end_tabs_wrapper' ) , 10 , 2 );

        add_filter( 'tf_use_custom_option_header_stars_menu', array( $this, 'useCustom_option_header' ) , 10 , 1 );

        add_action( 'tf_custom_option_header_stars_menu', array( $this, 'echoOptionHeader' ) , 10 , 3 );

        add_action( 'admin_notices' , array( $this , 'menu_themes_load_dynamic_elements' ) , 0 );

        add_action( 'admin_footer' , array( $this , 'detach_theme_settings' ) , 10000 );

        add_filter( "admin_body_class" , array( $this , 'admin_body_class' ) );

	}

    public function detach_theme_settings(){

        $theme = $this->get_theme_page();

        if( !$theme ){
            return ;
        }

        ?>
        <script>

            //var _formTableSettings;

            (function ($) {

                //_formTableSettings = $(".titan-framework-panel-wrap .form-table").detach();

            })(jQuery);

        </script>
        <?php
    }

    public function menu_themes_load_dynamic_elements(){

        $theme = $this->get_theme_page();

        if( !$theme ){
            return ;
        }

        StMenu()->current_theme = $theme;

        do_action( 'stmenu_load_dynamic_elements' , $theme );

    }

    public function get_theme_page(){

        $default_theme_page = false;

        if (isset($_REQUEST['page']) && $_REQUEST['page'] == "stars-menu" && isset($_REQUEST['tab']) && $_REQUEST['tab'] == "default-theme-configuration") {
            $default_theme_page = true;
        }

        $screen = get_current_screen();

        $themes_edit_page = false;

        if ( !is_null( $screen ) && is_object( $screen ) && $screen->id == "stars_menu_themes" ) {
            $themes_edit_page = true;
        }

        if ($themes_edit_page === false && $default_theme_page === false) {
            return false;
        }

        if ($default_theme_page === true) {
            $theme = 'default';
        } else {
            global $post;

            $theme = $post->ID;
        }

        return $theme;

    }

    public function admin_body_class( $classes ){

        $theme = $this->get_theme_page();

        if( !$theme ){
            return $classes;
        }

        $classes .= ' starsmenu-admin-theme-page ';

        return $classes;

    }

    public function create_tabs_menu( $option_obj , $display_type ){

        $tabs = array();

        $active_tab = 1;

        if( isset( $_REQUEST['stars_active_tab'] ) ){

            $active_tab = $_REQUEST['stars_active_tab'];

        }

        switch ( $display_type ){

            case "nav_menu_item" :

                $tabs = $this->menu_item_settings->panel_tabs;

                break;

            case "post_meta" :

                $tabs = $this->menu_theme_settings->panel_tabs;

                $active_tab = -1;

                break;

            case "admin_page" :

                $tab = isset( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : "";

                switch ( $tab ) {

                    case "help" :

                        $tabs = $this->help_settings->panel_tabs;

                        break;

                    case "update" :

                        $tabs = $this->update_settings->panel_tabs;

                        break;

                    case "default-theme-configuration" :

                        $tabs = $this->menu_theme_settings->panel_tabs;

                        $active_tab = -1;

                        break;

                    case "general-settings" :
                    default :

                        if( isset( $_REQUEST['widget-tab'] ) && $_REQUEST['widget-tab'] == 1 ){
                            $active_tab = 4;
                        }

                        $tabs = $this->general_settings->panel_tabs;

                }

                break;
        }

        if( $display_type == "post_meta" ){
            ?>
            <div class="titan-framework-panel-wrap">
            <div class="options-container">
            <?php
        }

        if( $display_type == "post_meta" || ( $display_type == "admin_page" && isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == "default-theme-configuration" ) ){
            ?>
            <div class="starsmenu-theme-panel-heading starsmenu-theme-panel-tabs" >

                <ul class="starsmenu-theme-tabs-container">

                    <li class="starsmenu-theme-panel-tab stmenu-active-panel-tab" data-filter="designer">
                        <div>
                            <span><i class="smd smd-layout"></i></span>
                            <span><?php echo __("Menu Designer" , "stars-menu");?></span>
                        </div>
                    </li>

                    <li class="starsmenu-theme-panel-tab" data-filter="settings">
                        <div>
                            <span><i class="smd smd-cogs"></i></span> 
                            <span><?php echo __("Settings" , "stars-menu");?></span>
                        </div>
                    </li>

                    <li class="starsmenu-theme-panel-tab" data-filter="styling">
                        <div>
                            <span><i class="smd smd-brush"></i></span>
                            <span><?php echo __("Styling" , "stars-menu");?></span>
                        </div>
                    </li>

                </ul>

                <div class="stmenu-search-settings-container">
                    <input type="search" class="stmenu-search-settings" placeholder="<?php echo __("Search Settings","stars-menu");?>">
                    <button type="button" class="stmenu-search-button button button-secondary" title="<?php echo __("Full Screen","stars-menu");?>">
                        <i class="smd smd-search"></i>  
                    </button>
                </div>

            </div>
            <?php
        }

        do_action( "stmenu_before_options_display" );

        ?>

        <div class="stmenu-sub-sections">

            <?php
            $num = 1;

            foreach ( $tabs AS $key => $title ) {

                $class = "";

                if( $num == $active_tab ){
                    $class = "stmenu-active";
                }

                ?>
                <a class="stmenu-sub-section-tab <?php echo esc_attr( $class );?>" data-section-group="<?php echo $key;?>"><?php echo $title;?></a>
                <?php
                $num++;
            }
            ?>

        </div>
        <div class="stmenu-fields-wrapper">
        <div class="stmenu-fields-wrapper-inner">

        <?php

    }

    public function end_tabs_wrapper( $option_obj , $display_type ){

        ?>

        </div>
        </div>
        <?php
        do_action( "stmenu_after_options_display" );

        if( $display_type == "post_meta" ){
            ?>
            </div>
            </div>
            <?php
        }


    }

    public function useCustom_option_header( $useCustom ){

        return true;

    }

    public function echoOptionHeader( $option , $showDesc , $rowIndex ){

        $id = $option->getID();
        $name = $option->getName();

        $classes = array();
        $classes[] = "row-{$rowIndex}";
        $classes[] = "row-field-container";
        $classes[] = $rowIndex % 2 == 0 ? 'odd' : 'even';

        if( isset( $option->settings['tab'] ) ){

            $tabs = $option->settings['tab'];

            if( !is_array( $tabs ) ){
                $tabs = array( $tabs );
            }

            foreach ( $tabs AS $tab ) {

                $classes[] = "tab-filter-{$tab}";

            }

        }

        if( isset( $option->settings['panel'] ) ){

            $panels = $option->settings['panel'];

            if( !is_array( $panels ) ){
                $panels = array( $panels );
            }

            foreach ( $panels AS $panel ) {

                if( $panel == "settings" ){
                    continue;
                }

                $classes[] = "panel-filter-{$panel}";

            }

        }


        if( !empty($id) ) {
            $container_id = 'id="' . esc_attr( $id . '-container' ) . '"';
        }else{
            $container_id = '';
        }

        $classes_names = implode( " " , $classes );

        $style = $option->getHidden() == true ? 'style="display: none"' : '';

        if( isset( $option->settings['validation'] ) ) {

            $validation = is_array( $option->settings['validation'] ) ? implode( "," , $option->settings['validation'] ) : $option->settings['validation'] ;

            $validation = !empty($validation) ? 'data-validation="' . esc_attr( $validation ) . '"' : '';

        }else{

            $validation = "";

        }

        $search_key = !empty($name) ? $name : '';

        if( !in_array( $option->settings['type'] , array( "custom" , "menu-design" ) ) ) {
            ?>
            <tr <?php echo $container_id;?> data-key="<?php echo $search_key ?>" valign="top" class="<?php echo esc_attr( $classes_names );?>" <?php echo $style ?> <?php echo $validation ?>>
            <th scope="row" class="first">
                <label for="<?php echo !empty($id) ? $id : '' ?>"><?php echo !empty($name) ? $name : '' ?></label>
            </th>
            <td class="second tf-<?php echo $option->settings['type'] ?>">
            <?php

            $desc = $option->getDesc();
            if ( !empty($desc) && $showDesc ) :
                ?>
                <p class='description'><?php echo $desc ?></p>
                <?php
            endif;

        }else{

            ?>
            <tr <?php echo $container_id;?> data-key="<?php echo $search_key ?>" valign="top" class="<?php echo esc_attr( $classes_names ); ?>" <?php echo $style ?> <?php echo $validation ?>>
            <td class="second tf-<?php echo $option->settings['type'] ?>" colspan="2">
            <?php

        }

    }

    public function create_options(){

        $this->options = TitanFramework::getInstance( 'stars_menu' );

        $this->admin_panel = $this->options->createAdminPanel( array(
            'name'          => __("Stars Menu" , "stars-menu"),
            'title'         => __("Stars Menu" , "stars-menu"),// Control Panel
        ) );

        $this->general_tab();

        $this->update_tab();

        $this->menu_theme_panel();

        $this->menu_item_panel();

        $this->support_tab();

    }

    private function general_tab(){

        $general_tab = $this->admin_panel->createTab( array(
            'name' => __("General Settings" , "stars-menu"),
        ) );

        require_once STARS_MENU_INC_DIR . '/general-settings.class.php' ;

        $this->general_settings = new StarsMenuGeneralSettings( $this , $general_tab );

    }

    private function support_tab(){

        $support_tab = $this->admin_panel->createTab( array(
            'name' => __("Help" , "stars-menu"),
        ) );

        require_once STARS_MENU_INC_DIR . '/help-settings.class.php' ;

        $this->help_settings = new StarsMenuHelpSettings( $this , $support_tab );

    }

    private function update_tab(){

    }

    private function menu_theme_panel(){

        $menu_theme_settings = $this->options->createMetaBox( array(
            'name'          => 'Menu Theme Options',
            'post_type'     => array( 'stars_menu_themes' ) ,
            //'desc'                    => 'stars_menu_themes',
            //'context'                 => 'normal', //advanced , normal , side
            //'priority'                => 10, //advanced , normal , side
            //'hide_custom_fields'      => true, //advanced , normal , side
        ) );

        require_once STARS_MENU_INC_DIR . '/menu-theme-settings.class.php' ;

        $this->menu_theme_settings = new StarsMenuThemeSettings( $this , $menu_theme_settings );

    }

    private function menu_item_panel(){

        $menu_item_settings = $this->options->createMetaBox( array(
            'name'          => 'Menu Item Options',
            'post_type'     => array( 'nav_menu_item' ) ,
            //'desc'                    => 'stars_menu_themes',
            //'context'                 => 'normal', //advanced , normal , side
            //'priority'                => 10, //advanced , normal , side
            //'hide_custom_fields'      => true, //advanced , normal , side
        ) );

        require_once STARS_MENU_INC_DIR . '/menu-item-settings.class.php' ;

        $this->menu_item_settings = new StarsMenuItemSettings( $this , $menu_item_settings );

    }

}

<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionMenuDesign extends TitanFrameworkOption {

	/**
	 * Default settings
	 * @var array
	 */
	//public $defaultSecondarySettings = array(

		/**
		 * (Optional) If true, an additional control will become available in the color picker for adjusting the alpha/opacity value of the color. You can get rgba colors with the option.
		 *
		 * @since 1.9
		 * @var boolean
		 */
		//'alpha' => false,
	//);

	function __construct( $settings, $owner ) {
		parent::__construct( $settings, $owner );

		tf_add_action_once( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        tf_add_action_once( 'stmenu_before_options_display', array( $this, 'design_display' ) );

        tf_add_action_once( 'admin_footer', array( $this, 'print_template' ) );

		//tf_add_action_once( 'admin_footer', array( $this, 'startColorPicker' ) );
	}

    public function print_template(){
        ?>
        <script type="text/html" id="tmpl-menu-design-element-demo">
            <li class="starsmenu-elements" data-element="{{data.elementId}}">{{{data.elementTitle}}}</li>
        </script>
        <?php
    }

    public function design_display(){

        if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX )
        {
            return ;
        }

        $default_theme_page = false;

        if( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == "stars-menu" && isset( $_REQUEST['tab'] ) && $_REQUEST['tab'] == "default-theme-configuration" ) {
            $default_theme_page = true;
        }

        $screen = get_current_screen();

        $themes_edit_page = false;

        if( !is_null( $screen ) && is_object( $screen ) && $screen->id == "stars_menu_themes" ){
            $themes_edit_page = true;
        }

        if( $themes_edit_page === false && $default_theme_page === false ){
            return ;
        }

        if( $default_theme_page === true ){
            $theme = 'default';
        }else{
            global $post;

            $theme = $post->ID; 
        }

        $value = stmenu_theme_option( 'theme_menu_design_order_layouts' , $theme  );

        $registered_elements = StMenu()->elements_manager->get_elements();

        $starsmenu_elements = array();

        foreach ( $registered_elements AS $id => $element_obj  ){

            $starsmenu_elements[$id] = $element_obj->title;

        }

        $areas = array();

        if( is_array( $value ) && !empty( $value ) ){

            uasort( $value , 'stmenu_elements_order' );

            foreach ( $value AS $element ){

                /*if( $element['id'] == 'stars-cart-icon' && !class_exists( 'WooCommerce' ) ){
                    continue;
                }*/

                switch ( $element['id'] ){

                    case "hamburger-mode" :

                        $el_string  = '<li class="starsmenu-element-hamburger" data-order="'.$element['order'].'" data-element="'.$element['id'].'">';
                        $el_string .= '<i class="smd smd-hamburger"></i>'; 
                        $el_string .= '</li>';

                        break;

                    case "main-navigation" :

                        ob_start();
                        ?>
                        <li class="starsmenu-elements starsmenu-element-main-nav" data-element="main-navigation" data-order="<?php echo $element['order'];?>">
                            <div class="starsmenu-main-nav-wrapper">
                                <div class="starsmenu-main-nav-drop-area">
                                    <ul data-name="sortable-left-nav" class="starsmenu-design-sortable left-nav-dropable connectedSortableNav">

                                        {{{left_nav}}}

                                    </ul>
                                </div>
                                <div class="starsmenu-main-nav"><div class="starsmenu-main-nav-title">Main Navigation</div></div>
                                <div class="starsmenu-main-nav-drop-area">
                                    <ul data-name="sortable-right-nav"  class="starsmenu-design-sortable right-nav-dropable connectedSortableNav">

                                        {{{right_nav}}}

                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php
                        $el_string = ob_get_clean();

                        break;
                    default :

                        $el_string = '<li class="starsmenu-elements" data-order="'.$element['order'].'" data-element="'.$element['id'].'">'.$starsmenu_elements[ $element['id'] ].'</li>';

                }

                if( !isset( $areas[$element['area']] ) ){
                    $areas[$element['area']] = $el_string;
                }else{
                    $areas[$element['area']] .= $el_string;
                }

            }
        }

        $center_area = "";
        $left_area = "";
        $right_area = "";

        $left_nav = ( isset( $areas['sortable-left-nav'] ) ) ? $areas['sortable-left-nav'] : "";

        $right_nav = ( isset( $areas['sortable-right-nav'] ) ) ? $areas['sortable-right-nav'] : "";

        if( isset( $areas['sortable-center'] ) ) {

            $center_area = $areas['sortable-center'];

            $center_area = str_replace( "{{{left_nav}}}" , $left_nav , $center_area );

            $center_area = str_replace( "{{{right_nav}}}" , $right_nav , $center_area );
        }

        if( isset( $areas['sortable-left'] ) ) {

            $left_area = $areas['sortable-left'];

            $left_area = str_replace( "{{{left_nav}}}" , $left_nav , $left_area );

            $left_area = str_replace( "{{{right_nav}}}" , $right_nav , $left_area );
        }

        if( isset( $areas['sortable-right'] ) ) {

            $right_area = $areas['sortable-right'];

            $right_area = str_replace( "{{{left_nav}}}" , $left_nav , $right_area );

            $right_area = str_replace( "{{{right_nav}}}" , $right_nav , $right_area );
        }

        ?>
        <div class="starsmenu-design-field-content">

            <h3 class="starsmenu-layout-heading"><?php echo __("Layout & Order","stars-menu");?></h3>

            <p>
                <?php echo __("Choose your menu structure by simply enable or disable what you need and drag and drop elements to create the <br>layout you want.Items will snap left, right or center.","stars-menu");?>
            </p>

            <h3><?php echo __("Drag And Drop Elements","stars-menu");?></h3>

            <div class="stars-menu-normal-design starsmenu-design-wrapper">

                <ul data-name="sortable-left" class="starsmenu-design-sortable starsmenu-sortable-left connectedSortable">

                    <?php echo $left_area; ?>

                </ul>

                <ul data-name="sortable-center" class="starsmenu-design-sortable starsmenu-sortable-center connectedSortable">

                    <?php echo $center_area; ?>

                </ul>

                <ul data-name="sortable-right" class="starsmenu-design-sortable starsmenu-sortable-right connectedSortable">

                    <?php echo $right_area; ?>

                </ul>

            </div> <br> <br>


            <h3><?php echo __("Drag And Drop Hamburger Icon","stars-menu");?></h3>

            <div class="stars-menu-hamburger-design starsmenu-design-wrapper">

                <ul data-name="sortable-left" class="starsmenu-design-sortable starsmenu-sortable-left connectedSortableHamburger">

                    <?php echo $left_area; ?>

                </ul>

                <ul data-name="sortable-center" class="starsmenu-design-sortable starsmenu-sortable-center connectedSortableHamburger">

                    <?php echo $center_area; ?>

                </ul>

                <ul data-name="sortable-right" class="starsmenu-design-sortable starsmenu-sortable-right connectedSortableHamburger">

                    <?php echo $right_area; ?>

                </ul>

            </div>  <br> <br>

            <div class="stars-menu-elements-desktop">

                <h3> <?php echo __("Select elements for desktop","stars-menu");?> </h3>

                <div class="stars-menu-elements-checkboxes">
                    <?php

                    $element_ids = wp_list_pluck( $value , 'id' );

                    foreach ( $starsmenu_elements AS $el_id => $label ) {
                        $checked = in_array( $el_id , $element_ids ) ? 'checked="checked"' : '';
                        ?>

                        <label for="stars-menu-elements-<?php echo $el_id;?>-desktop">
                            <input type="checkbox" title="<?php echo esc_attr( $label );?>" class="stars-menu-element <?php echo $el_id;?>" name="stars-menu-elements[]" id="stars-menu-elements-<?php echo $el_id;?>-desktop" value="<?php echo $el_id;?>" <?php echo $checked; ?>>
                            <span><?php echo $label;?></span>
                        </label>

                        <?php

                    }
                    ?>
                </div>

            </div><br><br>

            <div class="stars-menu-elements-sticky">

                <h3> <?php echo __("Activate elements on sticky menu","stars-menu");?> </h3>

                <div class="stars-menu-elements-checkboxes">
                    <?php

                    $sticky_elements = wp_list_pluck( $value , 'show_in_sticky' , 'id' );

                    foreach ( $starsmenu_elements AS $el_id => $label ) {

                        $checked = isset( $sticky_elements[$el_id] ) && $sticky_elements[$el_id] ? 'checked="checked"' : '';

                        $disabled = !in_array( $el_id , $element_ids ) ? 'disabled="disabled"' : '';

                        ?>

                        <label for="stars-menu-elements-<?php echo $el_id;?>-sticky">
                            <input type="checkbox" title="<?php echo esc_attr( $label );?>" class="stars-menu-element <?php echo $el_id;?>" name="stars-menu-elements[]" id="stars-menu-elements-<?php echo $el_id;?>-sticky" value="<?php echo $el_id;?>" <?php echo $checked; ?> <?php echo $disabled; ?>>
                            <span><?php echo $label;?></span>
                        </label>

                        <?php

                    }
                    ?>
                </div>
            </div>

            <br><br><br><br>

        </div>

        <?php

    }

	/**
	 * Display for options and meta
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function display() {

		$this->echoOptionHeader();

        $value = $this->getValue();

        //if ( ! is_serialized( $value ) ) {
            $value = wp_json_encode( $value );
        //}

        ?>
        <input class="starsmenu-design-drag-drop" type="hidden" name="<?php echo $this->getID();?>" id="<?php echo $this->getID();?>" value="<?php echo esc_attr( $value );?>"/>
        <?php

        //$this->design_display();

		$this->echoOptionFooter( false );
	}


	/**
	 * Enqueue the Icons Manager scripts
	 *
	 * @since 1.9
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

        //wp_enqueue_scripts( 'jquery-ui-sortable' );

	}


	/**
	 * Load the javascript to init the colorpicker
	 *
	 * @since 1.9
	 *
	 * @return void
	 */
	public function startColorPicker() {
		//edit by parsaatef
		?>
		<script>
		/*jQuery(document).ready(function() {
			'use strict';
			if ( typeof jQuery.fn.wpColorPicker !== 'undefined' ) {
				jQuery('.tf-colorpicker').wpColorPicker();
			}
		});*/
		</script>
		<?php
	}

    /**
     * Cleans up the serialized value before saving
     *
     * @param	string $value The serialized value
     * @return	string The cleaned value
     * @since	1.4
     */
    public function cleanValueForSaving( $value ) {
        //if ( is_array( $value ) ) {
            $value = json_decode( wp_unslash( $value ), true );
        //}
        return $value;
    }


    /**
     * Cleans the raw value for getting
     *
     * @param	string $value The raw value
     * @return	string The cleaned value
     * @since	1.4
     */
    public function cleanValueForGetting( $value ) {
        if ( is_string( $value ) ) {
            $value = maybe_unserialize( stripslashes( $value ) );
        }
        /*if ( is_array( $value ) ) {
            $value = array_merge( self::$defaultStyling, $value );
        }*/

        return $value;
    }

}

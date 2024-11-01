<?php
/**
 * Stars Menu Item Settings class
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Item Settings class
 *
 * Create & Manege Item Settings
 *
 * @Class StarsMenuItemSettings
 * @since 1.0.0
 */
class StarsMenuItemSettings {

	/**
	 * The Menu Item Panel Options
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $panel_options = array();

    /**
     * The Menu Item Panel Tabs
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $panel_tabs = array();

	/**
	 * The panel instance of the TitanFramework options class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $panel;

	/**
	 * The stmenu instance of the StarsMenu class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $manager;

	/**
	 * StarsMenuItemSettings constructor.
	 * @param $manager
	 * @param $panel
	 */
	public function __construct( $manager , $panel ) {

		$this->panel = $panel;

		$this->manager = $manager;

        add_filter( "stmenu-item-settings-meta-options" , array( $this , "item_settings_type_filter" ) , 10000 );

        add_filter( "stmenu-item-settings-meta-tabs" , array( $this , "item_tabs_filter" ) );

        add_action( 'wp_ajax_menu_item_settings', array( $this, 'menu_item_settings' ), 12, 4 );

        add_action( 'wp_ajax_menu_item_settings_save', array( $this, 'menu_item_settings_save' ), 12, 4 );

        add_action( 'admin_footer' , array( $this, 'menu_items_options_template' ) );

        add_filter( "tf_stars_menu_generate_css" , array( $this , "generate_css" ) );

		add_filter( 'screen_layout_columns', array( $this , 'menu_theme_layout_columns' ) );

		add_filter( 'get_user_option_screen_layout_stars_menu_themes', array( $this , 'menu_theme_screen_layout' ) );

		add_filter( 'stars_menu_all_options_with_css' , array( $this , "filter_titan_framework_css_options" ) );

		add_filter( 'tf_pre_get_value_stars_menu' , array( $this , "reset_settings" ) , 100 , 3 );

        $this->set_options();

        $this->set_tabs();

        $this->create_options();

	}

	public function reset_settings( $value, $postID, $option ){

		$reset = isset( $_POST['reset'] ) &&  $_POST['reset'] == "yes"; 

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] == 'menu_item_settings' && $reset === true ) {

			return $option->settings['default'];

		}

		return $value;

	}

	public function filter_titan_framework_css_options( $options ){

		$menu_item_ids = array();

		foreach ( $this->panel_options AS $item_option ) {

			if ( isset( $item_option['id'] ) ) {
				$menu_item_ids[] = $item_option['id'];
			}

		}

		foreach ( $options AS $key => $option ) {

			if ( empty( $option->settings['id'] ) ) {
				continue;
			}

			if ( empty($option->settings['css']) || in_array( $option->settings['id'] , $menu_item_ids ) ) {

				unset( $options[$key] );

			}

		}

		return $options;

	}

	public function menu_theme_layout_columns( $columns ) {
		$columns['stars_menu_themes'] = 1;
		return $columns;
	}


	public function menu_theme_screen_layout() {
		return 1;
	}

	protected function create_options(){

		foreach ( $this->panel_options AS $option ){

			$this->panel->createOption( $option );

		}

	}

    protected function set_tabs(){

        $tabs = array(
            '_all'                  =>  __("Show All" , "stars-menu") ,
            'general'               =>  __("General" , "stars-menu") ,
            'icon'                  =>  __("Icon" , "stars-menu") ,
            'image'                 =>  __("Image" , "stars-menu") ,
            'layout'                =>  __("Layout" , "stars-menu") ,
            'submenu'               =>  __("Submenu" , "stars-menu") ,
            'style_customizations'  =>  __("Customize Style" , "stars-menu") ,
            'responsive'            =>  __("Responsive" , "stars-menu") ,
            'advanced'              =>  __("Advanced" , "stars-menu")
        );

        $this->panel_tabs = apply_filters( 'stmenu-item-settings-meta-tabs' , $tabs );

    }

	public function get_option( $id , $menu_item_id ){

		return $this->manager->options->getOption( $id , $menu_item_id );

	}

	protected function set_options(){

		$sidebars_widgets = stmenu_get_option( 'general_custom_widget_areas' );

		$sidebars = array( '' => __( 'Select' , "stars-menu" ) );

		if( !empty( $sidebars_widgets ) && is_array( $sidebars_widgets ) ){
			foreach( $sidebars_widgets AS $sidebar_id => $sidebar_title ){
				$sidebars[ $sidebar_id ] = ucwords( $sidebar_title );
			}
		}

		$sizes = stmenu_get_image_sizes();

		$sizes_choices = array( 'inherit'  =>  __( 'Inherit' , 'stars-menu' ) );

		foreach( $sizes AS $size => $options ){

			$label = $options['label'];

			if( isset( $options['width'] ) )
				$label .= ' - ' . $options['width'] . ' X ';

			if( isset( $options['height'] ) )
				$label .= $options['height'];

			$sizes_choices[$size] = $label;
		}

		$pro_version_msg = stmenu_pro_version_msg();

		$options = array(

			array(
				'name'          => __( 'Hide Text' , "stars-menu" ),
				'id'            => 'item_hide_text',
				'type'          => 'enable',
				'default'       => false,
				'desc'          => __( 'Select “on” to remove the link from this item; clicking a disabled link will not result in any URL being followed.' , 'stars-menu') ,
				'enabled'       => __( 'ON' , "stars-menu" ),
				'disabled'      => __( 'OFF' , "stars-menu" ),
				'tab'           => 'general' ,
                'item_type'     => array( 'default' )
			) ,

			array(
				'name'          => __( 'Disable Link' , "stars-menu" ),
				'id'            => 'item_disable_link',
				'type'          => 'enable',
				'default'       => false,
				'desc'          => __( 'Do not display the text for this item' , 'stars-menu'),
				'enabled'       => __( 'ON' , "stars-menu" ),
				'disabled'      => __( 'OFF' , "stars-menu" ),
				'tab'           => 'general' ,
                'item_type'     => array( 'default' )
			) ,

			array(
				'name'          => __( 'Highlight Link' , "stars-menu" ),
				'id'            => 'item_highlight_link',
				'type'          => 'enable',
				'default'       => false,
				'desc'          => __( 'Highlight this menu item' , "stars-menu" ),
				'enabled'       => __( 'ON' , "stars-menu" ),
				'disabled'      => __( 'OFF' , "stars-menu" ),
				'tab'           => 'general' ,
                'item_type'     => array( 'default' )
			) ,


			array(
				'name'          => __( "Don't wrap title/label text" , "stars-menu" ),
				'id'            => 'item_no_wrap_title',
				'type'          => 'enable',
				'default'       => false,
				'desc'          => __( 'Prevent the text from wrapping to a new line' , "stars-menu" ),
				'enabled'       => __( 'ON' , "stars-menu" ),
				'disabled'      => __( 'OFF' , "stars-menu" ),
				'tab'           => 'general' ,
                'item_type'     => array( 'default' )
			) ,

            array(
                'name'          => __( 'Show Item Description' , "stars-menu" ),
                'id'            => 'item_desc_display',
                'type'          => 'enable',
                'default'       => true,
                'desc'          => __( "Whether the description of this item shown or not" , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'general' ,
                'item_type'     => array( 'default' )
            ) ,

            array(
                'name'          => __( 'Social Item type' , "stars-menu" ),
                'id'            => 'item_social_item_type',
                'type'          => 'radio',
                'default'       => 'default',
                'desc'          => __( 'It is used to specify the type of social item' , "stars-menu" ),
                'options'       => array(
                    'default'           => __( "Default" , "stars-menu" ),
                    'image'             => __( "Image" , "stars-menu" ),
                    'icon'              => __( "Icon" , "stars-menu" ),
                ),
                'tab'           => 'general' ,
                'item_type'     => array( 'social' )
            ) ,

			array(
				'name'          => __( 'Select Icon' , "stars-menu" ),
				'id'            => 'item_icon',
				'type'          => 'icon',
				'default'       => '',
				//'desc'          => 'Enable or disable our X feature',
				'tab'           => 'icon' ,
                'item_type'     => array( 'default' , 'social' )
			) ,

			array(
				'name'          => __( 'Icon Color' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'icon' ,
				'item_type'     => array( 'default' , 'social' )
			),

			array(
				'name'          => __( 'Icon Hover Color' , "stars-menu" ),
				'id'            => 'item_icon_hover_color',
				'type'          => 'color',
				'alpha'         => true ,
				'default'       => '',
				//'desc'          => 'Enable or disable our X feature',
				'tab'           => 'icon' ,
				'css'			=> '
					{{wrapper_selector}} {{item_id}}.starsmenu-social-item:hover > .starsmenu-item-inner .starsmenu-icon ,
					{{wrapper_selector}} {{item_id}}.starsmenu-social-item:active > .starsmenu-item-inner .starsmenu-icon ,
					{{wrapper_selector}} {{item_id}}.starsmenu-social-item:focus > .starsmenu-item-inner .starsmenu-icon ,
					{{wrapper_multi_selector}} {{item_id}}.starsmenu-social-item:hover > .starsmenu-item-inner .starsmenu-icon ,
					{{wrapper_multi_selector}} {{item_id}}.starsmenu-social-item:active > .starsmenu-item-inner .starsmenu-icon ,
					{{wrapper_multi_selector}} {{item_id}}.starsmenu-social-item:focus > .starsmenu-item-inner .starsmenu-icon {
						color : {{value}}; 
					}
				' ,
                'item_type'     => array( 'social' )
			) ,

			array(
				'name'          => __( 'Icon Size' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'icon' ,
				'item_type'     => array( 'default' , 'social' )
			),

			array(
				'name'          => __( 'Select Image' , "stars-menu" ),
				'id'            => 'item_image',
				'type'          => 'upload',
				'default'       => '',
				//'desc'          => 'Enable or disable our X feature',
				'label'         => __( 'Choose Image' , "stars-menu" ),
				'placeholder'   => __( 'Choose Image' , "stars-menu" ),
				'tab'           => 'image' ,
                'item_type'     => array( 'default' , 'social' )
			) ,

			array(
				'name'          => __( 'Inherit Featured Image' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'image' ,
				'item_type'     => array( 'default' )
			),

            array(
                'name'          => __( "Images Size" , "stars-menu" ),
                'id'            => 'item_image_size',
                'options'       => $sizes_choices,
                'type'          => 'select',
                'desc'          => __( 'This is the size of the actual file that will be served. You can choose from any registered image size in your setup. You can set a default to be inherited globally from theme settings.' , "stars-menu" ),
                'default'       => 'inherit',
                'tab'           => 'image' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( 'Image Dimensions' , "stars-menu" ),
                'id'            => 'item_image_dimensions',
                'type'          => 'radio',
                'default'       => 'inherit',
                'desc'          => __( 'You can select inherit for Inherit settings from the menu instance settings , natural for display image at natural dimensions and custom for use a custom size, defined below' , "stars-menu" ),
                'options'       => array(
                    'inherit'           => __( "Inherit" , "stars-menu" ),
                    'natural'           => __( "Natural" , "stars-menu" ),
                    'custom'            => __( "Custom" , "stars-menu" )
                ),
                'tab'           => 'image' ,
                'item_type'     => array( 'default' )
            ) ,

            array(
                'name'          => __( "Custom Image Width" , "stars-menu" ),
                'id'            => 'item_image_width',
                'type'          => 'text',
                'desc'          => __( 'Image width attribute (px). Do not include units. Only valid if "Image Dimensions" is set to "Custom" above.' , "stars-menu" ),
                'default'       => '',
                'tab'           => 'image' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Custom Image Height" , "stars-menu" ),
                'id'            => 'item_image_height',
                'type'          => 'text',
                'desc'          => __( 'Image height attribute (px). Do not include units. Only valid if "Image Dimensions" is set to "Custom" above. Leave blank to maintain aspect ratio.' , "stars-menu" ),
                'default'       => '',
                'tab'           => 'image' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Item Layout" , "stars-menu" ),
                'id'            => 'item_layout',
                'options'       => array(
                    'default'           => __( "Default" , "stars-menu" ) ,
                    'text'              => __( "Text Only" , "stars-menu" ) ,
                    'text-image'        => __( "Text & Image" , "stars-menu" )  ,
                    'text-icon'         => __( "Text & Icon" , "stars-menu" )  ,
                    'icon'              => __( "Icon Only" , "stars-menu" )  ,
                    'image'             => __( "Image Only" , "stars-menu" )  ,
                ),
                'type'          => 'radio',
                'desc'          => __( "It specifies the layout of item content. If choose the default option, it follows the default settings." , "stars-menu" ),
                'default'       => 'default',
                'tab'           => 'layout' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( 'Item Content Alignment' , "stars-menu" ),
                'id'            => 'item_alignment',
                'type'          => 'select',
                'options'       => array(
                    'default'       => __( 'Default' , "stars-menu" ) ,
                    'left'          => __( 'Left' , "stars-menu" ) ,
                    'center'        => __( 'Center' , "stars-menu" ) ,
                    'right'         => __( 'Right' , "stars-menu" )
                ),
                'desc'          => 'It specifies the align of item content. If choose the default option, it follows the default settings.',
                'default'       => 'default' ,
                'tab'           => 'layout' ,
                'item_type'     => array( 'default' )
            ) ,

            array(
                'name'          => __( "Icon Position" , "stars-menu" ),
                'id'            => 'item_icon_layout',
                'options'       => array(
                    'default'           => __( "Default" , "stars-menu" ) ,
                    'above'             => __( "Above" , "stars-menu" ) ,
                    'below'             => __( "Below" , "stars-menu" )  ,
                    'left'              => __( "Left" , "stars-menu" )  ,
                    'right'             => __( "Right" , "stars-menu" )
                ),
                'type'          => 'radio',
                'desc'          => __( "It is used to specify the position of item Icon" , "stars-menu" ),
                'default'       => 'default',
                'tab'           => 'layout' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Image Position" , "stars-menu" ),
                'id'            => 'item_image_layout',
                'options'       => array(
                    'default'           => __( "Default" , "stars-menu" ) ,
                    'above'             => __( "Above" , "stars-menu" ) ,
                    'below'             => __( "Below" , "stars-menu" )  ,
                    'left'              => __( "Left" , "stars-menu" )  ,
                    'right'             => __( "Right" , "stars-menu" )
                ),
                'type'          => 'radio',
                'desc'          => __( "It is used to specify the position of item Image" , "stars-menu" ),
                'default'       => 'default',
                'tab'           => 'layout' ,
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Dropdown Position" , "stars-menu" ),
                'id'            => 'item_dropdown_position',
                'options'       => array(
					'default'           => __( "Default" , "stars-menu" )  ,
                    'left'              => __( "Left" , "stars-menu" )  ,
                    'right'             => __( "Right" , "stars-menu" )
                ),
                'type'          => 'radio',
                'desc'          => __( "It allows you to specify the submenu position with respect to this item(it is only utilized for Top Level Menu Items)." , "stars-menu" ),
                'default'       => 'default',
                'tab'           => 'submenu' ,
                'item_type'     => array( 'default' )
            ),

			array(
				'name'          => __( "Dropdown Trigger" , "stars-menu" ),
				'id'            => 'item_dropdown_trigger',
				'options'       => array(
					'default'           => __( "Default" , "stars-menu" )  ,
					'click'             => __( "Click" , "stars-menu" )  ,
					'hover'             => __( "Hover" , "stars-menu" )
				),
				'type'          => 'radio',
				'desc'          => __( "Open the Submenu via this trigger(it is only utilized for Top Level Menu Items)." , "stars-menu" ),
				'default'       => 'default',
				'tab'           => 'submenu' ,
                'item_type'     => array( 'default' )
			),

            array(
                'name'          => __( "Submenu Width" , "stars-menu" ),
                'id'            => 'item_submenu_width',
                'type'          => 'text',
                'desc'          => __( "It specifies the default width of submenu for this item on desktop(it is only utilized for Top Level Menu Items)." , "stars-menu" ),
                'default'       => '',
                'tab'           => 'submenu' ,
                'css'           => '                
                    @media ( min-width: {{breakpoint}} ) {
                        {{wrapper_selector}} > {{item_id}} > .starsmenu-submenu-wrapper ,
                        {{wrapper_selector}} > {{item_id}} > .starsmenu-submenu-wrapper .starsmenu-submenu ,
					    {{wrapper_multi_selector}} > {{item_id}} > .starsmenu-submenu-wrapper ,
					    {{wrapper_multi_selector}} > {{item_id}} > .starsmenu-submenu-wrapper .starsmenu-submenu {  
                            width: {{value}};             
                        }    
                    }                                        
                ',  
                'item_type'     => array( 'default' )
            ),

			array(
				'name'          => __( 'Submenu Background Image' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'submenu' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Submenu Repeat Background Image' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'submenu' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Submenu Background Position' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'submenu' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Submenu Background Size' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'submenu' ,
				'item_type'     => array( 'default' )
			),

            array(
                'name'          => __( 'Disable Item On Mobile' , "stars-menu" ),
                'id'            => 'item_hide_on_mobile',
                'type'          => 'enable',
                'default'       => false,
                'desc'          => __( 'Removes this item when mobile device is detected via wp_is_mobile().' , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'responsive' ,
                'item_type'     => array( 'default' , 'social' , 'custom' , 'widget_area' )
            ) ,

            array(
                'name'          => __( 'Disable Item On Desktop' , "stars-menu" ),
                'id'            => 'item_hide_on_desktop',
                'type'          => 'enable',
                'default'       => false,
                'desc'          => __( 'Removes this item when mobile device is NOT detected via wp_is_mobile().' , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'responsive' ,
                'item_type'     => array( 'default' , 'social' , 'custom' , 'widget_area' )
            ) ,

            array(
                'name'          => __( 'Hide below breakpoint' , "stars-menu" ),
                'id'            => 'item_hide_below_breakpoint',
                'type'          => 'enable',
                'default'       => false,
                'desc'          => __( 'Hides this item below the responsive breakpoint via CSS.' , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'responsive' ,
                'item_type'     => array( 'default' , 'social' , 'custom' , 'widget_area' )
            ) ,

            array(
                'name'          => __( 'Hide above breakpoint' , "stars-menu" ),
                'id'            => 'item_hide_above_breakpoint',
                'type'          => 'enable',
                'default'       => false,
                'desc'          => __( 'Hides this item above the responsive breakpoint via CSS.' , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'responsive' ,
                'item_type'     => array( 'default' , 'social' , 'custom' , 'widget_area' )
            ) ,

            array(
                'name'          => __( 'Disable submenu on mobile' , "stars-menu" ),
                'id'            => 'item_submenu_disable_on_mobile',
                'type'          => 'enable',
                'default'       => false,
                'desc'          => __( "Removes this item's submenu when mobile device is detected via wp_is_mobile()." , "stars-menu" ),
                'enabled'       => __( 'ON' , "stars-menu" ),
                'disabled'      => __( 'OFF' , "stars-menu" ),
                'tab'           => 'responsive' ,
                'item_type'     => array( 'default' )
            ) ,

            array(
                'name'          => __( 'Custom Content' , "stars-menu" ),
                'id'            => 'item_custom_content',
                'type'          => 'code',
                'default'       => '',
                'desc'          => __( 'Can contain HTML and shortcodes' , "stars-menu" ),
                'tab'           => 'advanced' ,
                'lang'          => 'html',
                'item_type'     => array( 'default' , 'custom' )
            ) ,

            array(
                'name'          => __( 'Select Widget Area' , "stars-menu" ),
                'id'            => 'item_widget_area',
                'type'          => 'select',
                'options'       => $sidebars,
                'desc'          => sprintf( __( 'You need create new custom widget area %1$s And then you can choose the widget area via this setting. you can manage and assign the widgets %2$s' , "stars-menu" ) ,
					'<a href="' . esc_url( admin_url( 'admin.php?page=stars-menu&tab=general-settings&widget-tab=1' ) ) . '" target="_blank">'. __('here','stars-menu') . '</a>' ,
					'<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" target="_blank">'. __('here','stars-menu') . '</a>'
				),
                'default'       => 'initial' ,
                'tab'           => 'advanced' ,
                'item_type'     => array( 'default' , 'widget_area' )
            ) ,

			array(
				'name'                  => __( "Custom Widget Areas" , "stars-menu" ),
				'type'                  => 'custom',
				'custom'				=> '<button class="manage-widget-area-button button button-secondary" >
					<a href="' . esc_url( admin_url( 'admin.php?page=stars-menu&tab=general-settings&widget-tab=1' ) ) . '" target="_blank">'. __('Manage Custom Widget Areas','stars-menu') . '</a>
				</button>',
				'tab'           		=> 'advanced' ,
				'item_type'     		=> array( 'default' , 'widget_area' )
			),
			
			array(
				'name'          => __( 'Background Color' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

            array(
                'name'          => __( "Custom Content Padding" , "stars-menu" ),
                'id'            => 'item_custom_content_padding',
                'type'          => 'text',
                'desc'          => __( "Set the padding for this specific Item Custom Content or Item Widget Area" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'advanced' , 
                'css'           => '  
                	{{wrapper_selector}} {{item_id}} > .starsmenu-item-inner > .starsmenu-widget-area ,
					{{wrapper_selector}} {{item_id}}.starsmenu-widget_area-item > .starsmenu-widget-area ,
					{{wrapper_selector}} {{item_id}} > .starsmenu-item-inner > .starsmenu-custom-content ,
					{{wrapper_selector}} {{item_id}}.starsmenu-custom-item > .starsmenu-custom-content {  
                        padding: {{value}};    
                    }  
                ',
                'item_type'     => array( 'default' , 'widget_area' , 'custom' )
            ),

			array(
				'name'          => __( 'Border Color' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Font Color' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Background Color (hover)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Border Color (hover)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Font Color (hover)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Background Color (Current)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Border Color (Current)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

			array(
				'name'          => __( 'Font Color (Current)' , "stars-menu" ),
				'type'          => 'note',
				'desc'          => $pro_version_msg,
				'tab'           => 'style_customizations' ,
				'item_type'     => array( 'default' )
			),

            array(
                'name'          => __( "Padding" , "stars-menu" ),
                'id'            => 'item_padding',
                'type'          => 'text',
                'desc'          => __( "Set the padding for this specific item" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'style_customizations' ,
                'css'           => '  
                    {{wrapper_selector}}.stars-menu-bar-nav li{{item_id}}.menu-item > .starsmenu-item-inner .starsmenu-link ,
					{{wrapper_multi_selector}}.stars-menu-bar-nav li{{item_id}}.menu-item > .starsmenu-item-inner .starsmenu-link {  
                        padding: {{value}};    
                    } 
                ',
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Margin" , "stars-menu" ),
                'id'            => 'item_margin',
                'type'          => 'text',
                'desc'          => __( "Set the margin for this specific item" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'style_customizations' ,
                'css'           => '  
                    {{wrapper_selector}}.stars-menu-bar-nav .starsmenu-submenu li{{item_id}}.menu-item > .starsmenu-item-inner ,
					{{wrapper_multi_selector}}.stars-menu-bar-nav .starsmenu-submenu li{{item_id}}.menu-item > .starsmenu-item-inner {  
                        padding: {{value}};    
                    }                   

                    @media ( min-width: {{breakpoint}} ) {
                        {{wrapper_selector}}.stars-menu-bar-nav > li{{item_id}}.menu-item > .starsmenu-item-inner ,
						{{wrapper_multi_selector}}.stars-menu-bar-nav > li{{item_id}}.menu-item > .starsmenu-item-inner {  
                            margin: {{value}};    
                        }
                    }    

                    @media ( max-width: {{breakpoint_below}} ) { 
                        {{wrapper_selector}}.stars-menu-bar-nav li{{item_id}}.menu-item > .starsmenu-item-inner ,
						{{wrapper_multi_selector}}.stars-menu-bar-nav li{{item_id}}.menu-item > .starsmenu-item-inner {  
                            padding: {{value}};    
                        }                        
                    }  
                ',
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Submenu Background Color" , "stars-menu" ),
                'id'            => 'item_submenu_bg_color',
                'type'          => 'color',
        		'alpha'         => true ,
                'desc'          => __( "The background color for the submenu of this item" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'style_customizations' ,  
                'css'           => '  

                    {{wrapper_selector}} > {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu,
                    {{wrapper_selector}} .starsmenu-submenu {{item_id}} > .starsmenu-submenu-wrapper ,
					{{wrapper_multi_selector}} > {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu ,
					{{wrapper_multi_selector}} .starsmenu-submenu {{item_id}} > .starsmenu-submenu-wrapper {    
                        background-color: {{value}};       
                    }                    
                ',  
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Submenu Font Color" , "stars-menu" ),
                'id'            => 'item_submenu_font_color',
                'type'          => 'color',
        		'alpha'         => true ,
                'desc'          => __( "The Text color for the submenu of this item" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'style_customizations' ,
                'css'           => '   
                    .stars-menu-bar-wrapper {{starsmenu_id}} {{item_id}} > .starsmenu-submenu-wrapper > ul > li > .starsmenu-item-inner .starsmenu-item-arrow ,
                    .stars-menu-bar-wrapper {{starsmenu_id}} {{item_id}} > .starsmenu-submenu-wrapper > ul > li > .starsmenu-item-inner .starsmenu-link ,
                    .stars-menu-bar-wrapper {{starsmenu_multi_id}} {{item_id}} > .starsmenu-submenu-wrapper > ul > li > .starsmenu-item-inner .starsmenu-item-arrow ,
                    .stars-menu-bar-wrapper {{starsmenu_multi_id}} {{item_id}} > .starsmenu-submenu-wrapper > ul > li > .starsmenu-item-inner .starsmenu-link  {    
                        color: {{value}};          
                    }                      
                ', 
                'item_type'     => array( 'default' )
            ),

            array(
                'name'          => __( "Submenu Padding" , "stars-menu" ),
                'id'            => 'item_submenu_padding',
                'type'          => 'text',
                'desc'          => __( "Set the padding for this specific Submenu" , "stars-menu" ),
                'default'       => '',
                'tab'           => 'style_customizations' , 
                'css'           => '  
                    {{wrapper_selector}} > {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu,
                    {{wrapper_selector}} .starsmenu-submenu {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu ,
					{{wrapper_multi_selector}} > {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu ,
					{{wrapper_multi_selector}} .starsmenu-submenu {{item_id}} > .starsmenu-submenu-wrapper > .starsmenu-submenu {  
                        padding: {{value}};    
                    }  
                ',
                'item_type'     => array( 'default' )
            ),

		);

		$this->panel_options = apply_filters( 'stmenu-item-settings-meta-options' , $options );

	}

	public function menu_items_options_template( ){

		$screen = get_current_screen();

		if( !is_null( $screen ) && is_object( $screen ) && $screen->id != "nav-menus" ){
			return ;
		}

		?>
		<div class="stars-menu-item-options-wrapper titan-framework-panel-wrap ">
			<div class="stars-menu-item-panel">

				<a class="stmenu-menu-item-settings-close" href="#"><i class="smd smd-cross"></i> <span class="stmenu-key">ESC</span></a>

				<div class="stmenu-menu-item-settings-loading hide">
					<div class="loader">
						<div class="loader-inner ball-triangle-path">
							<div class="smd smd-star"></div>
							<div class="smd smd-star"></div>  
							<div class="smd smd-star"></div>
						</div>
					</div>
				</div>

				<div class="stmenu-error-massage notice notice-error inline">

					<i class="stmenu-status-warning smd smd-exclamation-triangle"></i>
					<span class="stmenu-status-message"></span>

				</div>

				<input type="hidden" name="stmenu-item-settings-loaded-nonce" id="stmenu-item-settings-loaded-nonce" value="<?php echo esc_attr( wp_create_nonce( "stmenu-item-settings-loaded" ) );?>">

				<div class="stmenu-menu-item-stats">

					<div class="stmenu-menu-item-title"></div>
					<div class="stmenu-menu-item-id"></div>
					<div class="stmenu-menu-item-type"></div>

					<div class="stmenu-menu-item-save-button-wrapper">

						<div class="stmenu-search-settings-container">
							<input type="search" class="stmenu-search-settings" placeholder="<?php echo __("Search Settings","stars-menu");?>">
							<button type="button" class="stmenu-search-button button button-secondary" title="<?php echo __("Full Screen","stars-menu");?>">
								<i class="smd smd-search"></i>
							</button>
						</div>

						<button type="button" class="stmenu-fullscreen-settings button button-secondary" title="<?php echo __("Full Screen","stars-menu");?>">
							<i class="smd smd-expand"></i>  
						</button>

						<button type="button" class="stmenu-clear-settings button button-secondary">
							<i class="smd smd-eraser"></i> <?php echo __("Clear item settings","stars-menu");?>  
						</button>

						<button class="stmenu-menu-item-save-button button button-primary" type="button" value="Save Menu Item">
							<i class="stmenu-save-status stmenu-save-loading smd smd-spinner smd-spin hide"></i>
							<i class="stmenu-save-status stmenu-save-success smd smd-check hide"></i>  
							<i class="stmenu-save-status stmenu-save smd smd-floppy-o"></i>    
							<?php _e("Save Menu Item" , "stars-menu" );?>
						</button>

					</div>

				</div>

				<form method="post" class="stmenu-menu-item-settings-form" action="">

					<div class="stars-menu-item-panel-content">



					</div>

				</form>

			</div>
		</div>

		<?php

	}

	public function menu_item_settings() {

		check_ajax_referer( 'stmenu-item-settings-loaded', 'nonce' );

		// Handle request then generate response using WP_Ajax_Response

		if( !isset( $_POST['item_id'] ) || empty( $_POST['item_id'] ) ){

			wp_send_json_error( array(
				"message"   => __("Send data is invalid" , "stars-menu")
			));

		}

		$menu_item_id = $_POST['item_id'];

		ob_start();

		do_action( "ajax_stars_menu_item_settings" , $menu_item_id );

		$settings_content = ob_get_clean();

		wp_send_json_success( array(
			"content"   =>   $settings_content ,
			"item_id"   =>   $menu_item_id
		) );

	}

	public function menu_item_settings_save() {

		if( !isset( $_POST['item_id'] ) || empty( $_POST['item_id'] ) || !isset( $_POST['form'] ) || empty( $_POST['form'] ) ||  !isset( $_POST['form']['titan-framework_menu-item-options_nonce'] ) ){

			wp_send_json_error( array(
				"message"   => __("Send data is invalid" , "stars-menu")
			));

		}

		$nonce_action = 'menu-item-options';

		$result = wp_verify_nonce( $_POST['form']['titan-framework_menu-item-options_nonce'] , $nonce_action );

		/**
		 * Fires once the Ajax request has been validated or not.
		 *
		 * @since 2.1.0
		 *
		 * @param string    $action The Ajax nonce action.
		 * @param false|int $result False if the nonce is invalid, 1 if the nonce is valid and generated between
		 *                          0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
		 */
		do_action( 'check_ajax_referer', $nonce_action, $result );

		if ( false === $result ) {

			wp_send_json_error( array(
				"message"   => __("Cheatin oh?" , "stars-menu")
			));

		}

		$menu_item_id = $_POST['item_id'];

		$post_id = str_replace( "menu-item-" , "" , $menu_item_id );

		$post_id = (int)$post_id;

		if ( ! get_post( $post_id ) ) {

			wp_send_json_error( array(
				"message"   => __("This menu item is not valid" , "stars-menu")
			));

		}

		$form_data = $_POST['form'];

		$not_meta = array( 'titan-framework_menu-item-options_nonce' , '_wp_http_referer' );

        $css_meta_options = array();

		foreach ( $form_data AS $key => $value ){

			if( ! in_array( $key , $not_meta ) && strpos( $key , "stars_menu_" ) === 0 ){

				update_post_meta( $post_id , $key , $value );

                $option_id = str_replace( "stars_menu_" , "" , $key );

                $meta_option = $this->get_meta_option( $option_id );

                if( !is_null( $meta_option ) && isset( $meta_option['css'] ) ){

                    if( isset( $meta_option['default'] ) && $meta_option['default'] === $value ){
                        continue;
                    }

                    $meta_option['new_value'] = $value;

                    $css_meta_options[] = $meta_option;

                }

			}

		}

		$menu_id = $_POST['menu_id'];

        $this->save_menu_item_style( $css_meta_options , $menu_item_id , $post_id , $menu_id );

		wp_send_json_success( array(
			"message"   =>   __( "Success settings saved" , "stars-menu" ) ,
			"item_id"   =>   $menu_item_id
		) );

	}

	public function save_menu_item_style( $css_meta_options , $item_id , $post_id , $menu_id ){

        $css_string = "";

        if( !empty( $css_meta_options ) ){

			$html_menu_class = stmenu_menu_main_class( $menu_id );

			$menu = wp_get_nav_menu_object( $menu_id );

			$html_menu_id = 'menu-' . $menu->slug;

			//$html_menu_id = '#' . $html_menu_id;//$html_menu_id .

			$wrapper_selector = ".stars-menu-bar-wrapper .stars-menu-bar #{$html_menu_id}"; //.{$html_menu_class}.stars-menu-bar-nav. ',[ id*="'.$html_menu_id.'"].stars-menu-bar-nav'

			$wrapper_multi_selector = ".stars-menu-bar-wrapper .stars-menu-bar [id*='{$html_menu_id}']"; //..{$html_menu_class}{$html_menu_class}.stars-menu-bar-nav. ',[id*="'.$html_menu_id.'"].stars-menu-bar-nav'

			$starsmenu_id = "#{$html_menu_id}";

			$starsmenu_multi_id = "[id*='{$html_menu_id}']";

			$item_id_class = '.nav-menu-item-'. $post_id;

			$breakpoint = stmenu_get_option( 'general_responsive_breakpoint' );

            foreach ( $css_meta_options AS $option ){
                $css = $option['css'];
                $css = str_replace( "{{item_id}}" , $item_id_class , $css );
				$css = str_replace( "{{bg_value}}" , stmenu_get_background_image( $option['new_value'] ) , $css );
                $css = str_replace( "{{wrapper_selector}}" , $wrapper_selector , $css );
                $css = str_replace( "{{wrapper_multi_selector}}" , $wrapper_multi_selector , $css );
                $css = str_replace( "{{starsmenu_id}}" , $starsmenu_id , $css );
                $css = str_replace( "{{starsmenu_multi_id}}" , $starsmenu_multi_id , $css );
                $css = str_replace( "{{breakpoint_below}}" , ( $breakpoint - 1 ) . "px" , $css );
                $css = str_replace( "{{breakpoint}}" , "{$breakpoint}px" , $css );
                $css = str_replace( "{{value}}" , $option['new_value'] , $css );
                $css_string .= $css;
            }

        }

        $settings = get_option( 'stars_menu_general_settings' , array() );

        if( !isset( $settings['menu_item_styles'] ) ){
            $settings['menu_item_styles'] = array();
        }

        if( !empty( $css_string ) || ( empty( $css_string ) && isset( $settings['menu_item_styles'][$post_id] ) ) ){

            $settings['menu_item_styles'][$post_id] = $css_string;

            update_option( 'stars_menu_general_settings', $settings );

        }

        $this->manager->options->cssInstance->generateSaveCSS();

	}

    public function generate_css( $css_string ){

        $settings = get_option( 'stars_menu_general_settings' , array() );

        if( isset( $settings['menu_item_styles'] ) ){
            foreach ( $settings['menu_item_styles'] AS $item_post_id => $item_css ){

                $css_string .= $item_css;

            }
        }

        return $css_string;

    }

    /**
     * Get Meta Option By ID
     */
    public function get_meta_option( $id ){

        $meta_option = null;

        foreach ( $this->panel_options AS $option ){

            if( isset( $option['id'] ) && $option['id'] == $id ){

                $meta_option = $option;
                break;
            }

        }

        return $meta_option;

    }

    public function item_settings_type_filter( $options ){

        if( isset( $_POST['action'] ) && $_POST['action'] == 'menu_item_settings' && isset( $_POST['item_type'] ) ){

            $type = $_POST['item_type'];

            $custom_types = array( 'custom' , 'social' , 'widget_area' );

            $type = ( !in_array( $type , $custom_types ) ) ? "default" : $type;

            foreach ( $options As $key => $option ){

                if( isset( $option['item_type'] ) && ! in_array( $type , $option['item_type'] ) ){

                    unset( $options[$key] );

                }

            }

        }

        return $options;

    }


    public function item_tabs_filter( $tabs ){

        if( isset( $_POST['action'] ) && $_POST['action'] == 'menu_item_settings' && isset( $_POST['item_type'] ) ){

            $type = $_POST['item_type'];

            switch ( $type ){

                case "social" :
                    unset($tabs['layout']);
                    unset($tabs['submenu']);
                    unset($tabs['advanced']);
                    unset($tabs['style_customizations']);

                    break;

                case "custom" :
                case "widget_area" :

                    unset($tabs['layout']);
                    unset($tabs['submenu']);
                    unset($tabs['icon']);
                    unset($tabs['image']);
                    unset($tabs['layout']);
                    unset($tabs['submenu']);
                    unset($tabs['style_customizations']);
                    unset($tabs['general']);

                    break;

            }

        }

        return $tabs;

    }



}

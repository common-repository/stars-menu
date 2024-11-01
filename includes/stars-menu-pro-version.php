<?php
/**
 * StarsMenu Pro Version
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * StarsMenu Pro Version class
 *
 * Manege Pro Version For upgrade & prevent bug from free version
 *
 * Pro Features:
 * 1. 	WooCommerce Cart Icon Element
 * 2. 	Search Element
 * 3. 	Social Bar Element & social items
 * 4. 	Sub Navigation Element
 * 5. 	Sticky Menu
 * 6. 	Manage Icons Sets ( Upload Custom icons set , delete sets , ... )
 * 7. 	hamburger bar & background Animation
 * 8. 	Top Level Hover Effects
 * 9. 	hamburger Icon Size Settings
 * 10.  Custom Item Styling
 * 11.  Submenus Animations
 * 12.  Automatically inherit featured images
 * 13.  Mobile features ( breakpoint , background image , ... )
 * 14.  Automatic updates
 * 15.  Priority Support
 *
 * @Class StarsMenuProVersion
 * @since 1.0.0
 */
class StarsMenuProVersion {

	/**
	 * The stmenu instance of the StarsMenu class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $stmenu;

	/**
	 * StarsMenuProVersion constructor.
	 * @param stmenu
	 */
	public function __construct( $stmenu ) {

		$this->stmenu = $stmenu;

		add_filter( 'stmenu_scss_variables' , array( $this , 'pro_scss_variables' ) , 10 , 4 );

		add_filter( 'stmenu-theme-settings-tab-options' , array( $this , 'upgrade_pro_theme_options' ) , 100 , 1 );

		add_filter( 'stmenu-general-settings-tab-options' , array( $this , 'upgrade_pro_general_options' ) , 100 , 1 );

		add_action( 'admin_bar_menu', array( &$this, 'admin_bar_upgrade_link' ), 100 );

	}


	/**
	 *
	 * @since 1.0
	 * @param $vars
	 * @param $options
	 * @param $menus
	 * @param $theme
	 * @return array
	 */
	public function pro_scss_variables( $vars, $options , $menus , $theme ) {

		//WooCommerce Cart Icon Element
		$vars['stmenu_cart_icon_font_size'] 					= '20px';
		$vars['stmenu_cart_icon_color'] 						= '#000000';
		$vars['stmenu_cart_icon_active_color'] 					= '#ff9900';
		$vars['stmenu_sticky_cart_icon_color'] 					= '#000000';
		$vars['stmenu_hamburger_bar_cart_icon_color'] 			= '#ffffff';
		$vars['stmenu_woo_cart_padding'] 						= '0';


		//WooCommerce Search Element
		$vars['stmenu_search_padding']                  		= '0';
		$vars['stmenu_search_bg_color']                 		= 'rgba( 0 , 0 , 0 , 0)';
		$vars['stmenu_search_color']                    		= '#000';
		$vars['stmenu_search_Placeholder_color']        		= '#000';
		$vars['stmenu_search_icon_color']               		= '#000';
		$vars['stmenu_search_icon_active_color']        		= '#ff9900';
		$vars['stmenu_search_font_size']                		= '0.9em';
		$vars['stmenu_search_Placeholder_font_size']    		= '0.87em';
		$vars['stmenu_search_icon_font_size']           		= '20px';

		$vars['stmenu_sticky_search_bg_color']          		= 'rgba( 0 , 0 , 0 , 0)';
		$vars['stmenu_sticky_search_color']             		= '#000';
		$vars['stmenu_sticky_search_Placeholder_color'] 		= '#000';
		$vars['stmenu_sticky_search_icon_color']        		= '#000';

		$vars['stmenu_hamburger_bar_search_bg_color']          	= 'rgba( 0 , 0 , 0 , 0)';
		$vars['stmenu_hamburger_bar_search_color']             	= '#fff';
		$vars['stmenu_hamburger_bar_search_Placeholder_color'] 	= '#ddd';
		$vars['stmenu_hamburger_bar_search_icon_color']        	= '#fff';

		//Social Bar Element
		$vars['stmenu_social_bar_wrap_padding']                 = '0';
		$vars['stmenu_social_bar_color']                        = '#000000';
		$vars['stmenu_social_bar_active_color']                 = '#ff9900';
		$vars['stmenu_social_bar_spacing']                      = '5px';
		$vars['stmenu_social_bar_font_size']                    = '20px';
		$vars['stmenu_mobi_social_bar_color']                   = '#ffffff';
		$vars['stmenu_sticky_social_bar_color']                 = '#000000';
		$vars['stmenu_hamburger_bar_social_bar_color']          = '#ffffff';

		//Sticky menu
		$vars['stmenu_sticky_shadow']                  			= '0 2px 43px rgba(0, 0, 0, 0.1)';
		$vars['stmenu_sticky_bg_color']                			= 'rgba(255, 255, 255, 0.97)';
		$vars['stmenu_sticky_font_size']               			= '85%';
		$vars['stmenu_sticky_color']                   			= '#000';
		$vars['stmenu_sticky_line_height']             			= '55px';
		$vars['stmenu_sticky_logo_max_width']             		= '200px';
		$vars['stmenu_sticky_hamburger_icon_color']             = '#000000';
		$vars['stmenu_sticky_item_divider_color']             	= '#dddddd';
		$vars['stmenu_sticky_element_divider_color']            = '#dddddd';

		//Hamburger Icon
		$vars['stmenu_hamburger_icon_width']            		= '1.4em';
		$vars['stmenu_hamburger_icon_height']            		= '1em';
		$vars['stmenu_hamburger_icon_bar_height']            	= '2px';

		//Mobile
		$vars['stmenu_mobi_overlay_bg_color']          			= 'rgba(0,0,0,0.5)';
		$vars['stmenu_mobi_wrap_bg_image']          			= 'none';
		$vars['stmenu_mobi_wrap_bg_repeat']          			= 'no-repeat';
		$vars['stmenu_mobi_wrap_bg_position']          			= 'center center';
		$vars['stmenu_mobi_wrap_bg_size']          				= 'cover';

		return $vars;

	}

	public function upgrade_pro_theme_options( $options ){

		$other_sticky_items = array(
			'theme_style_stmenu_sticky_hamburger_icon_color' ,
			'theme_style_stmenu_sticky_item_divider_color' ,
			'theme_style_stmenu_sticky_element_divider_color'
		);

		foreach( $options AS $key => $option ){

			if( isset( $option['id'] ) && in_array( $option['id'] , $other_sticky_items ) ){

				unset( $options[$key] );

			}

		}

		$pro_version_msg = stmenu_pro_version_msg();

		$pro_options = array(

			array(
				'name'          => __( 'Search' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'search'
			),

			array(
				'name'          => __( 'WooCommerce Cart' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'woo-cart'
			),

			array(
				'name'          => __( 'Sub Navigation' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'sub-nav-bar'
			),

			array(
				'name'          => __( 'Social Bar' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'social-bar'
			),

			array(
				'name'          => __( 'Sticky Menu' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'sticky'
			),

		);

		return array_merge( $options , $pro_options );

	}

	public function upgrade_pro_general_options( $options ){

		$pro_version_msg = stmenu_pro_version_msg();

		$pro_options = array(

			array(
				'name'          => __( 'Manage Icons sets' , "stars-menu" ),
				'type'          => 'custom',
				'custom'        => $pro_version_msg,
				'tab'           => 'icons'
			),

		);

		return array_merge( $options , $pro_options );

	}

	public function admin_bar_upgrade_link() {
		global $wp_admin_bar;

		$upgrade_url = "https://www.stars-menu.com/#sed-bp-module-row-container-4-1";

		/* Add the main siteadmin menu item */
		$wp_admin_bar->add_menu( array(
			'id'     	=> 'stars_menu_upgrade_btn',
			'parent' 	=> 'top-secondary',
			'title'  	=> __( 'Upgrade To Stars Menu Pro' , "stars-menu" ),
			'href' 		=> $upgrade_url ,
			'meta'		=> array(
				'class'     => 'stars-admin-bar-upgrade-to-pro' ,
				'target'	=> '_blank'
			)
		) );
	}

}

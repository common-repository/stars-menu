<?php
/**
 * StarsMenu Custom Menu Locations
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * StarsMenu Custom Menu Locations class
 *
 * Create & Manege Custom Menu Location
 *
 * @Class StarsMenuCustomLocation
 * @since 1.0.0
 */
class StarsMenuCustomLocation {

	/**
	 * The stmenu instance of the StarsMenu class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $stmenu;

	/**
	 * StarsMenuCustomLocation constructor.
	 * @param stmenu
	 */
	public function __construct( $stmenu ) {

		// Don't do anything when we're activating a plugin to prevent errors
		// on redeclaring Titan classes.
		if ( is_admin() ) {
			if ( ! empty( $_GET['action'] ) && ! empty( $_GET['plugin'] ) ) { // Input var: okay.
				if ( 'activate' === $_GET['action'] ) { // Input var: okay.
					return;
				}
			}
		}

		$this->stmenu = $stmenu;

		add_action( 'init', array( $this, 'register_nav_menus' ) , 2 ); //after_setup_theme

		add_action( 'wp_ajax_add_custom_menu_location', array( $this, 'add_menu_location' ) );

	}

	/**
	 * Register menu locations created within Stars Menu.
	 *
	 * @since 1.0
	 */
	public function register_nav_menus() {

		$locations = stmenu_get_option( 'general_custom_menu_locations' );

		if ( is_array( $locations ) && count( $locations ) ) {

			foreach ( $locations as $key => $val ) {

				register_nav_menu( $key, $val );

			}

		}

	}

	/**
	 * Add a new menu location.
	 *
	 * @since 1.0
	 */
	public function add_menu_location() {

		//check_ajax_referer( 'starsmenu_add_menu_location', 'nonce' );

		$next_id = $_POST['next_id'];

		$new_menu_location_id = "starsmenu_custom_location_" . $next_id;

		$new_menu_location_title = "Stars Menu Custom Location " . $next_id;

		$setting_id = 'stars_menu_general_custom_menu_locations';

		$integration_code = $this->menu_integration_code( $new_menu_location_id , true , $new_menu_location_title , $setting_id );

		$option = '<option selected="selected" value="'.$new_menu_location_id.'">'.$new_menu_location_title.'</option>';

		wp_send_json_success( array(
			"content"   => $integration_code ,
			"option"	=> $option,
			"message"   => __( 'Done!', 'stars-menu' )
		) );

		//wp_send_json_error( __( 'Failed!', 'default' ) );

	}


	/**
	 * Returns the next available menu location ID
	 *
	 * @since 1.0
	 * @param $locations
	 * @return int|mixed
	 */
	public function get_next_menu_location_id( $locations ) {

		$last_id = 0;

		foreach ( $locations as $key => $value ) {

			if ( strpos( $key, 'starsmenu_custom_location_' ) !== FALSE ) {

				$parts = explode( "_", $key );
				$menu_id = end( $parts );

				if ($menu_id > $last_id) {
					$last_id = $menu_id;
				}

			}

		}

		$next_id = $last_id + 1;

		return $next_id;
	}


	/**
	 * Add the Pro settings for all Instances
	 *
	 * @param $theme_location
	 * @param $is_custom
	 * @param $location_title
	 * @param $setting_id
	 * @return string
	 */
	public function menu_integration_code( $theme_location , $is_custom , $location_title , $setting_id ){

		$shortcode  = '<code class="starsmenu-highlight-code">[starsmenu ';
		$shortcode .= ' theme_location="'.$theme_location.'"';
		$shortcode .= ']</code>';

		$api = '<code class="starsmenu-highlight-code">&lt;?php wp_nav_menu( ';
		$api.= "array( 'theme_location' => '{$theme_location}' ) ";
		$api.= '); ?&gt;</code>';

		ob_start();
		?>
		<div class="starsmenu-integration-code starsmenu-integration-code-<?php echo $theme_location;?>">

			<?php if( $is_custom === true ) : ?>
				<div class="starsmenu-desc-row stars_custom_menu_location_settings">
					<span class="">
						<input type="text" class="stars_menu_title_custom_location regular-text" data-location="<?php echo $theme_location;?>"  id="<?php echo esc_attr( $setting_id ) . "_" . $theme_location; ?>" name='<?php echo esc_attr( $setting_id );?>[<?php echo $theme_location; ?>]' value="<?php echo $location_title; ?>">
					</span>
					<span class="">
						<button name="action" class="stars_menu_remove_custom_location button button-secondary" data-location="<?php echo $theme_location;?>">
							<?php echo __('Delete Location','stars-menu');?>
						</button>
					</span>
				</div>
			<?php endif; ?>

			<div class="starsmenu-desc-row">
				<span class="starsmenu-code-snippet-type"><?php echo __('PHP','stars-menu');?></span> <?php echo $api;?>
			</div>
			<div class="starsmenu-desc-row">
				<span class="starsmenu-code-snippet-type"><?php echo __('Shortcode','stars-menu');?></span> <?php echo $shortcode;?>
			</div>
			<div class="starsmenu-desc-row">
				<span class="starsmenu-code-snippet-type"><?php echo __('Widget','stars-menu');?></span>
				<span class='starsmenu-widget-area-highlight'><?php echo __("Add the 'Stars Menu' widget to a widget area.",'stars-menu');?></span>
			</div>
			<p class="starsmenu-sub-desc starsmenu-desc-mini description" >
				<?php
				printf( __( 'Click to select, then %1$s or %2$s to copy to clipboard' , 'stars-menu' ) ,
					'<strong><em>&#8984;+c</em></strong>' ,
					'<strong><em>ctrl+c</em></strong>'
				);
				?>
			</p>
			<p class="starsmenu-sub-desc starsmenu-desc-understated description"><?php echo __('Pick the appropriate code and add to your theme template or content where you want the menu to appear.','stars-menu');?></p>
		</div>
		<?php
		$code = ob_get_clean();

		return $code;
	}

}

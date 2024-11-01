<?php
/**
 * StarsMenu Custom Widget Area
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * StarsMenu Custom Widget Area class
 *
 * Create & Manege Custom Widget Area
 *
 * @Class StarsMenuCustomWidgetArea
 * @since 1.0.0
 */
class StarsMenuCustomWidgetArea {

	/**
	 * The stmenu instance of the StarsMenu class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $stmenu;

	/**
	 * The Stars menu Custom Widget Areas
	 *
	 * @var array
	 * @since 0.9
	 */
	public $sidebars = array();

	/**
	 * StarsMenuCustomWidgetArea constructor.
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

		//widgets_init
		add_action( 'init', array( $this, 'register_custom_sidebars' ), 2 );

		add_action( 'admin_footer', array( $this, 'print_js_template' ) );

	}

	/**
	 * Register sidebars.
	 *
	 * @access public
	 * @return void
	 */
	public function register_custom_sidebars() {

		$sidebars = stmenu_get_option( 'general_custom_widget_areas' ); //var_dump( $sidebars );

		$args = apply_filters( 'starsmenu_custom_sidebars_widget_args', array(
				'before_title' 		=> '<h3 class="starsmenu-widgettitle">',
				'after_title'  		=> '</h3>',
				'before_widget'  	=> '<li id="%1$s" class="widget %2$s starsmenu-widget starsmenu-column starsmenu-item-header">',
				'after_widget'   	=> '</li>'
			)
		);

		if ( is_array( $sidebars ) ) {
			foreach ( $sidebars as $sidebar_id => $sidebar_title ) {

				$args['name']  = $sidebar_title;
				$args['id']    = $sidebar_id;
				$args['class'] = 'starsmenu-custom-widget-area';

				register_sidebar( apply_filters( 'starsmenu_widget_args_' . $sidebar_id, $args ) );
			}
		}
	}

	public function get_sidebars( $new_sidebars ){

		if( empty( $new_sidebars ) ) {

			$this->sidebars = array();

			return $this->sidebars;
		}

		$this->sidebars = stmenu_get_option( 'general_custom_widget_areas' );

		$removed_sidebars = array();

		$added_sidebars = array();

		$edited_sidebars = array();

		foreach ( $new_sidebars As $sidebar_id => $sidebar_title ){

			if( strpos( $sidebar_id , "stars_sidebar_id_" ) === 0 ){

				$added_sidebars[$sidebar_id] = $sidebar_title;

			}else{

				$edited_sidebars[$sidebar_id] = $sidebar_title;

			}

		}

		foreach ( $this->sidebars As $sidebar_id => $sidebar_title ){

			if( !in_array( $sidebar_id , array_keys( $new_sidebars ) ) ){

				$removed_sidebars[$sidebar_id] = $sidebar_title;

			}

		}

		if( !empty( $removed_sidebars ) ){

			foreach ( $removed_sidebars As $sidebar_id => $sidebar_title ){

				unset( $this->sidebars[ $sidebar_id ] );

				unregister_sidebar( $sidebar_id );

			}

		}

		if( !empty( $added_sidebars ) ){

			foreach ( $added_sidebars As $sidebar_id => $sidebar_title ){

				$sidebar_id = $this->get_sidebar_id( sanitize_title_with_dashes( $sidebar_title ) );

				$this->sidebars[ $sidebar_id ] = $sidebar_title;

			}

		}

		if( !empty( $edited_sidebars ) ){

			foreach ( $edited_sidebars As $sidebar_id => $sidebar_title ){

				$this->sidebars[ $sidebar_id ] = $sidebar_title;

			}

		}

		return $this->sidebars;

	}

	public function print_js_template( ){

		$id = 'stars_menu_general_custom_widget_areas';

		?>
		<script type="text/html" id="tmpl-add-new-custom-widget-area">

			<li>

				<label><?php echo __("Name:" , "stars-menu"); ?></label>

				<input type='text' id="<?php echo esc_attr( $id ) . "_{{data.sidebar_id}}" ?>" name='<?php echo esc_attr( $id );?>[{{data.sidebar_id}}]' value='<?php echo __("Stars Menu Widget Area" , "stars-menu"); ?>' />

				<span class="remove-action">
					<i class="dashicons dashicons-no-alt remove"></i>
				</span>

			</li>

		</script>
		<?php
	}

	/**
	 * Check user entered widget area name and manage conflicts.
	 *
	 * @param string $name User entered name
	 * @return string Processed name
	 */
	public function get_sidebar_id( $sidebar_id ) {
		if ( empty( $GLOBALS['wp_registered_sidebars'] ) ) {
			return $sidebar_id;
		}

		$taken = array();

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$taken[] = $sidebar['id'];
		}

		if ( empty($this->sidebars) ) $this->sidebars = array();

		$taken = array_merge( $taken, array_keys( $this->sidebars ) );

		if ( in_array( $sidebar_id, $taken ) ) {
			$counter  = substr( $sidebar_id, -1 );

			if ( ! is_numeric( $counter ) ) {
				$new_sidebar_id = $sidebar_id . '-1';
			} else {
				$new_sidebar_id = substr( $sidebar_id, 0, -1 ) . ( (int) $counter + 1 );
			}

			$sidebar_id = $this->get_sidebar_id( $new_sidebar_id );
		}

		return $sidebar_id;
	}

}

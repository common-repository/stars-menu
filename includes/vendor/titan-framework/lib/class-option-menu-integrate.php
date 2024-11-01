<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionMenuIntegrate extends TitanFrameworkOption {


	function __construct( $settings, $owner ) {
		parent::__construct( $settings, $owner );

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

		$locations = get_registered_nav_menus();

		$custom_menu_locations = $this->getValue();

		$custom_menu_locations = ( empty( $custom_menu_locations) || !is_array( $custom_menu_locations ) ) ? array() : $custom_menu_locations;

		$next_id = StMenu()->custom_menu_location->get_next_menu_location_id( $custom_menu_locations );

		?>

        <p class="description">
            <?php echo __("This is an overview of the menu locations supported by your theme. You can enable Stars Menu and adjust the settings for a specific menu location by going to Appearance > Menus." , "stars-menu") ;?>
        </p>

		<h4><?php echo __("Integrate Specific Theme Location" , "stars-menu") ;?></h4>

		<input type="hidden" id="stars_menu_next_menu_location_id" value="<?php echo $next_id;?>">

		<select id="stars_menu_integrate_theme_location">
			<option value="_default"><?php echo __("None" , "stars-menu") ;?></option>
			<?php
			if( is_array( $locations ) ){
				foreach( $locations as $location_id => $location_title ){
					echo '<option value="'.$location_id.'">'.$location_title.'</option>';
				}
			}
			?>
		</select>

		<p class="description">
			<?php echo __("To display a specific theme locaton, select the theme location above to generate that code" , "stars-menu") ;?>
		</p>

        <div class="stars_menu_integration_code">

            <?php
            if( is_array( $locations ) ){

                foreach( $locations as $location_id => $location_title ){

					$is_custom = isset( $custom_menu_locations[$location_id] );

                    echo StMenu()->custom_menu_location->menu_integration_code( $location_id , $is_custom , $location_title , $this->getID() );
                }

            }
            ?>

        </div>

		<?php

		$this->echoOptionFooter();
	}


}

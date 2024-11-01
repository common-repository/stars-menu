<?php
/**
 * Font Option Class
 *
 * @since	1.4
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
/**
 * Font Option Class
 *
 * @since	1.4
 */
class TitanFrameworkOptionGradient extends TitanFrameworkOption {

    // Default style options
    public static $defaultStyling = array(
        'color'     => '',
        'end'       => '',
    );

	/**
	 * Constructor
	 *
	 * @return	void
	 * @since	1.4
	 */
	function __construct( $settings, $owner ) {
		parent::__construct( $settings, $owner );

		tf_add_action_once( 'admin_enqueue_scripts', array( $this, 'loadAdminScripts' ) );

	}


	/**
	 * Enqueues the needed scripts for the admin
	 *
	 * @return	void
	 * @since	1.4
	 */
	public function loadAdminScripts() {
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Displays the option in admin panels and meta boxes
	 *
	 * @return	void
	 * @since	1.4
	 */
	public function display() {
		$this->echoOptionHeader( false );

		// Get the current value and merge with defaults
		$value = $this->getValue();
		if ( ! empty(  $value ) ) {
			$value = array_merge( self::$defaultStyling, $value );
		} else {
			$value = self::$defaultStyling;
		}

		/*
		 * Create all the fields
		 */
		?>
		<div>

            <label>
                <?php echo __("Start Color" , "stars-menu");?>
                <input class='tf-back-start-color stmenu-color' type="text" value="<?php echo esc_attr( $value['color'] ) ?>"  data-default-color="<?php echo esc_attr( $value['color'] ) ?>"/>
            </label>

            <label>
                <?php echo __("End Color" , "stars-menu");?>
                <input class='tf-back-end-color stmenu-color' type="text" value="<?php echo esc_attr( $value['end'] ) ?>"  data-default-color="<?php echo esc_attr( $value['end'] ) ?>"/>
            </label>

        </div>
		<?php

		if ( ! is_serialized( $value ) ) {
			$value = serialize( $value );
		}

		printf("<input type='hidden' class='tf-for-saving' name='%s' id='%s' value='%s' />",
			$this->getID(),
			$this->getID(),
			esc_attr( $value )
		);

		$this->echoOptionFooter( true );
	}


	/**
	 * Cleans up the serialized value before saving
	 *
	 * @param	string $value The serialized value
	 * @return	string The cleaned value
	 * @since	1.4
	 */
	public function cleanValueForSaving( $value ) {
		if ( is_array( $value ) ) {
			$value = serialize( $value );
		}
		return stripslashes( $value );
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
		if ( is_array( $value ) ) {
			$value = array_merge( self::$defaultStyling, $value );
		}

		return $value;
	}

}


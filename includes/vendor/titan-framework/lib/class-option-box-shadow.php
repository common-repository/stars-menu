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
class TitanFrameworkOptionBoxShadow extends TitanFrameworkOption {

    public $defaultSecondarySettings = array(
        'options' => array()
    );

	// Default style options
	public static $defaultStyling = array(
        'enable'            => 'off',
		'horizontal'        => 0,
		'vertical'          => 0,
		'blur'              => 0,
		'spread'            => 0,
		'color'             => 'rgba(0, 0, 0, 0.1)',
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

        $savedValue = $this->getValue();

        $options = array(
            'enable'            => __( "Enabled" , "stars-menu" ),
            'horizontal'        => __( "Horizontal" , "stars-menu" ),
            'vertical'          => __( "Vertical" , "stars-menu" ),
            'blur'              => __( "Blur" , "stars-menu" ),
            'spread'            => __( "Spread" , "stars-menu" ),
            'color'             => __( "Color" , "stars-menu" )  
        );

        foreach ( $options as $key => $label ) {

            switch ( $key ) {

                case "enable" : 

                    printf('<label for="%s"> %s <br> <input id="%s" type="checkbox" name="%s[%s]" value="on" %s /> </label>',
                        $this->getID() . "_" . $key,
                        $label,
                        $this->getID() . "_" . $key,
                        $this->getID(),
                        $key,
                        checked( $savedValue[$key] , "on", false )
                    );

                    break;

                case "color" :

                    printf('<label for="%s"> %s <br> <input class="tf-colorpicker" id="%s" type="text" name="%s[%s]" value="%s" data-default-color="%s" data-custom-width="0" data-alpha="true" /> </label>',
                        $this->getID() . "_" . $key,
                        $label,
                        $this->getID() . "_" . $key,
                        $this->getID(),
                        $key,
                        (isset($savedValue[$key])) ? esc_attr($savedValue[$key]) : '' ,
                        (isset($savedValue[$key])) ? esc_attr($savedValue[$key]) : ''
                    );

                    break;

                default :

                    printf('<label for="%s"> %s <br> <input id="%s" type="text" name="%s[%s]" value="%s" /> </label>',
                        $this->getID() . "_" . $key,
                        $label,
                        $this->getID() . "_" . $key,
                        $this->getID(),
                        $key,
                        (isset($savedValue[$key])) ? esc_attr($savedValue[$key]) : ''
                    );

            }

        }

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
		if ( !is_array( $value ) ) {
			$value = array();
		}

         $value = array_merge( self::$defaultStyling, $value );

		return $value;
	}

}


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
class TitanFrameworkOptionMultiText extends TitanFrameworkOption {

    public $defaultSecondarySettings = array(
        'options' => array()
    );

	/**
	 * Displays the option in admin panels and meta boxes
	 *
	 * @return	void
	 * @since	1.4
	 */
	public function display() {
		$this->echoOptionHeader( false );

        $savedValue = $this->getValue();

        foreach ( $this->settings['options'] as $key => $label ) {

            printf('<label for="%s"> %s <br> <input id="%s" type="text" name="%s[%s]" value="%s" /> </label>',
                $this->getID() . "_" . $key,
                $label ,
                $this->getID() . "_" . $key,
                $this->getID(),
                $key ,
                ( isset( $savedValue[$key] ) ) ? esc_attr( $savedValue[$key] ) : ''
            );

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

		return $value;
	}

}


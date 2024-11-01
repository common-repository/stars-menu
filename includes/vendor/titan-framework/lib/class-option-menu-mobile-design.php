<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionMenuMobileDesign extends TitanFrameworkOption {

	public $defaultSecondarySettings = array(
		'options' => array(),
		'select_all' => false,
	);


	/*
	 * Display for options and meta
	 */
	public function display() {

        $this->echoOptionHeader();

        $value = $this->getValue();

        $registered_elements = StMenu()->elements_manager->get_elements();

        ?>

        <ul class="starsmenu-mobile-elements" >

            <?php
            foreach ( $value AS $element_id ){

                /*if( $element_id == 'stars-cart-icon' && !class_exists( 'WooCommerce' ) ){
                    continue;
                }*/

                $title = ( $element_id == "menu-bar" ) ? __("Main Navigation" , "stars-menu") : $registered_elements[$element_id]->title;
            ?>

            <li data-value="<?php echo $element_id;?>"> <span><?php echo $title;?></span><i class="smd smd-arrows"></i></li>  

            <?php
            }
            ?>

        </ul>

        <?php
        $value = implode( ',' , $value );
        ?>

        <input class="starsmenu-mobile-design-drag-drop" type="hidden" name="<?php echo $this->getID();?>" id="<?php echo $this->getID();?>" value="<?php echo esc_attr( $value );?>"/>
        <?php

        $this->echoOptionFooter();

	}

	public function cleanValueForGetting( $value ) {

		if ( is_array( $value ) ) {
			return $value;
		}

		if ( is_string( $value ) ) {
			return explode( ',', $value );
		}

        if ( empty( $value ) || ! is_array( $value ) ) {
            return array();
        }

	}

}


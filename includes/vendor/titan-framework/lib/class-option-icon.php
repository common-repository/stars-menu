<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionIcon extends TitanFrameworkOption {

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

		//tf_add_action_once( 'admin_footer', array( $this, 'startColorPicker' ) );
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

		?>

		<input class="tf-icon-library" type="hidden" name="<?php echo esc_attr( $this->getID() );?>" id="<?php echo esc_attr( $this->getID() );?>" value="<?php echo esc_attr( $this->getValue() );?>"/>

		<div id="<?php echo esc_attr( $this->getID() );?>_icon_manager_library"></div>

		<script type="text/javascript">
			/*jQuery(document).ready(function($) {
				$(document).on("iconManagerCollectionLoaded", function(){
					window["la_icon_manager_library"] = new LAIconManager("library", "#la_icon_manager_library", window["la_icon_manager_collection"]);
					window["la_icon_manager_library"].showLibrary();
				});
			});

            jQuery(document).ready(function($) {
                $(document).on("iconManagerCollectionLoaded", function(){
                    window["la_icon_manager_select_0"] = new LAIconManager(
                        "0",
                        "#<?php //echo esc_attr( $this->getID() );?>_icon_manager_library",
                        window["la_icon_manager_collection"],
                        "#<?php //echo esc_attr( $this->getID() );?>"
                    );
                    window["la_icon_manager_select_0"].showIconSelect();
                });
            });*/

        </script>

		<?php

		$this->echoOptionFooter();
	}


	/**
	 * Enqueue the Icons Manager scripts
	 *
	 * @since 1.9
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

        StMenu()->icon_manager->enqueueAdminScripts();

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

}

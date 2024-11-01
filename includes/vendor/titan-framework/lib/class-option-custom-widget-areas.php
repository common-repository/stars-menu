<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionCustomWidgetAreas extends TitanFrameworkOption {


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

		$custom_widget_areas = $this->getValue();

		$custom_widget_areas = ( empty( $custom_widget_areas) || !is_array( $custom_widget_areas ) ) ? array() : $custom_widget_areas;

		?>
		<p class='description'>
			<?php _e("Manage all custom widget areas for using on menu items", "stars-menu"); ?>
		</p> <br> 

		<div class="starsmenu-custom-widget-areas">

			<ul>

			<?php foreach( $custom_widget_areas as $sidebar_id => $sidebar_title ): ?>
				<li>

					<label><?php echo __("Name:" , "stars-menu"); ?></label>

					<input type='text' id="<?php echo esc_attr( $this->getID() ) . "_" . $sidebar_id ?>" name='<?php echo esc_attr( $this->getID() );?>[<?php echo $sidebar_id ?>]' value='<?php echo $sidebar_title; ?>' />

					<span class="remove-action">
						<i class="dashicons dashicons-no-alt remove"></i>
					</span>

				</li>
			<?php endforeach; ?>

			</ul>

			<button type="button" class="add-widget-area-btn button button-primary">
				<?php _e("Add Widget Area" , "stars-menu");?>
			</button>

		</div>

		<p class='description'>
			<?php _e("Add or remove custom widget areas", "stars-menu"); ?>
		</p>
		<?php

		$this->echoOptionFooter();
	}

	/* overridden */
	public function cleanValueForSaving( $value ) {

		$value = !is_array( $value ) ? array() : $value;

		return StMenu()->custom_widget_area->get_sidebars( $value );
	}

}

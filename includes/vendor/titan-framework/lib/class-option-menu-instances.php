<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionMenuInstances extends TitanFrameworkOption {


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

		if (count($locations)):
			$active_menu_instances = $this->getValue();
			?>
			<p class='description'>
				<?php _e("Some themes will output a menu location multiple times on the same page. For example, your theme may output a menu location once for the main menu, then again for the mobile menu. This setting can be used to make sure Stars Menu is only applied to one of those instances.", "stars-menu"); ?>
			</p> <br> <br>
			<table>
				<tr>
					<th><?php _e("Menu Location", "stars-menu"); ?></th><th><?php _e("Active Instance", "stars-menu"); ?></th>
				</tr>
				<?php foreach( $locations as $location => $description ): ?>
					<?php if ( stmenu_is_enabled($location) ): ?>
						<?php $active_instance = isset($active_menu_instances[$location]) ? $active_menu_instances[$location] : 0; ?>
						<tr>
							<td><?php echo $description; ?></td><td><input type='text' id="<?php echo esc_attr( $this->getID() ) . "_" . $location ?>" name='<?php echo esc_attr( $this->getID() );?>[<?php echo $location ?>]' value='<?php echo $active_instance; ?>' /></td>
						</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</table>
			<p class='description'>
				<?php _e("0: Apply to all instances. 1: Apply to first instance 2: Apply to second instance , ...", "stars-menu"); ?>
			</p>
			<?php
		endif;

		$this->echoOptionFooter();
	}

}

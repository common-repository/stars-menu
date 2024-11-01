<?php
/**
 * Stars Menu Help Settings class
 *
 * @package StarsMenu
 * @subpackage Settings
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Help Settings class
 *
 * Create & Manege Help Settings
 *
 * @Class StarsMenuHelpSettings
 * @since 1.0.0
 */
class StarsMenuHelpSettings {

	/**
	 * The Help Settings Tab Panel Options
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $panel_options = array();

	/**
	 * The Menu Item Panel Tabs
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $panel_tabs = array();

	/**
	 * The panel instance of the TitanFramework options class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $panel;

	/**
	 * The stmenu instance of the StarsMenu class.
	 *
	 * @var StarsMenu
	 * @since 0.9
	 */
	public $manager;

	/**
	 * StarsMenuHelpSettings constructor.
	 * @param $manager
	 * @param $panel
	 */
	public function __construct( $manager , $panel ) {

		$this->panel = $panel;

		$this->manager = $manager;

		$this->set_options();

		$this->set_tabs();

		$this->create_options();

	}

	protected function create_options(){

		foreach ( $this->panel_options AS $option ){

			$this->panel->createOption( $option );

		}

	}

	protected function set_tabs(){

		$tabs = array(
			'_all'                   	=>  __("Show All" , "stars-menu") ,
			'knowledgebase'             =>  __("Knowledgebase" , "stars-menu") ,
			'support'             		=>  __("Support" , "stars-menu") ,
		);

		$this->panel_tabs = apply_filters( 'stmenu-help-settings-tab-tabs' , $tabs );

	}

	protected function set_options(){

		ob_start();
		?>
		<div class="starsmenu-support-wrap">
			<h3><i class="smd smd-support"></i> <?php echo __("Support Center" , "stars-menu");?> </h3>
			<p><?php echo __("Didn't find the answer you needed in the Knowledgebase or Video Tutorials?  Visit the" , "stars-menu");?>
				<a target="_blank" class="button" href="<?php echo stmenu_get_support_url();?>">
					<i class="smd smd-support"></i>
					<?php echo __("Support Center" , "stars-menu");?>
				</a>
			</p>
		</div>  
		<?php
		$support = ob_get_clean();

		ob_start();
		?>
		<div class="starsmenu-knowledgebase-wrap">
			<h3><i class="smd smd-book"></i> <?php echo __("Knowledgebase" , "stars-menu");?> </h3>
			<p><?php echo __("Search in the Knowledgebase for find your problem." , "stars-menu");?>
				<a target="_blank" class="button" href="<?php echo esc_url('https://www.stars-menu.com/documentation/');?>">
					<i class="smd smd-book"></i>
					<?php echo __("Knowledgebase" , "stars-menu");?>
				</a>
			</p>
		</div>
		<?php
		$knowledgebase = ob_get_clean();

		ob_start();
		?>
		<div class="starsmenu-upgrade-wrap">
			<h3><i class="smd smd-upgrade"></i> <?php echo __("Upgrade To Pro" , "stars-menu");?> </h3>
			<p>

				<?php echo __("for using full features of the Stars Menu plugin" , "stars-menu");?>

				<?php echo stmenu_pro_version_msg();?>

			</p>
		</div>
		<?php
		$upgrade = ob_get_clean();

		$options = array(

			array(
				'type'          => 'custom',
				'custom'        => $knowledgebase,
				'tab'           => 'knowledgebase'
			),

			array(
				'type'          => 'custom',
				'custom'        => $support,
				'tab'           => 'support'
			) ,

			array(
				'type'          => 'custom',
				'custom'        => $upgrade,
				'tab'           => 'support'
			)

		);

		$this->panel_options = apply_filters( 'stmenu-help-settings-tab-options' , $options );

	}

}

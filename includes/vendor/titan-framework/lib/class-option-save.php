<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkOptionSave extends TitanFrameworkOption {

	public $defaultSecondarySettings = array(
		'save' 				=> '',
		'save2' 			=> '',//edit by parsaatef
		'reset' 			=> '',
		'use_reset' 		=> true,
		'save2_action' 		=> '',//edit by parsaatef
		'reset_question' 	=> '',
		'action' 			=> 'save',
		'save_action' 		=> '',//edit by parsaatef
		'action_id' 		=> 'starsmenu-save',//edit by parsaatef
	);

	public function display() {
		if ( ! empty( $this->owner->postID ) ) {
			return;
		}

		if ( empty( $this->settings['save'] ) ) {
			$this->settings['save'] = __( 'Save Changes', TF_I18NDOMAIN );
		}

		//edit by parsaatef
		if ( empty( $this->settings['save2'] ) ) {
			$this->settings['save2'] = __( 'Save 2 Changes', TF_I18NDOMAIN );
		}

		if ( empty( $this->settings['reset'] ) ) {
			$this->settings['reset'] = __( 'Reset to Defaults', TF_I18NDOMAIN );
		}
		if ( empty( $this->settings['reset_question'] ) ) {
			$this->settings['reset_question'] = __( 'Are you sure you want to reset ALL options to their default values?', TF_I18NDOMAIN );
		}

		?>
		</tbody>
		</table>

		<p class='submit'>

			<?php
			$action_type = ( !empty( $this->settings['save_action'] ) ) ? 'data-action-type="'.$this->settings['save_action'].'"' : '';
			?>

			<button <?php echo $action_type; ?> name="action" value="<?php echo $this->settings['action']; ?>" class="<?php echo esc_attr( $this->settings['action_id'] ); ?> button button-primary">
				<?php echo $this->settings['save']; ?>
			</button>

			<?php
			if ( !empty( $this->settings['save2_action'] ) ) :
				?>
				<button data-action-type="<?php echo $this->settings['save2_action']; ?>" name="action" value="<?php echo $this->settings['action']; ?>" class="<?php echo esc_attr( $this->settings['action_id'] ); ?> button button-secondary">
					<?php echo $this->settings['save2']; ?>
				</button>
				<?php
			endif;
			?>

			<?php
			if ( $this->settings['use_reset'] ) :
			?>
			<button name="action" class="button button-secondary"
				onclick="javascript: if ( confirm( '<?php echo htmlentities( esc_attr( $this->settings['reset_question'] ) ) ?>' ) ) { jQuery( '#tf-reset-form' ).submit(); } jQuery(this).blur(); return false;">
				<?php echo $this->settings['reset'] ?>
			</button>
			<?php
			endif;
			?>
		</p>

		<table class='form-table'>
			<tbody>
		<?php
	}
}

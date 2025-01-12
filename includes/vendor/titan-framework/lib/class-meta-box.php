<?php

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
class TitanFrameworkMetaBox {

	private $defaultSettings = array(
		'name' => '', // Name of the menu item
		// 'parent' => null, // slug of parent, if blank, then this is a top level menu
		'id' => '', // Unique ID of the menu item
		// 'capability' => 'manage_options', // User role
		// 'icon' => 'dashicons-admin-generic', // Menu icon for top level menus only
		// 'position' => 100.01 // Menu position for top level menus only
		'post_type' => 'page', // Post type, can be an array of post types
		'context' => 'normal', // normal, advanced, or side
		'hide_custom_fields' => true, // If true, the custom fields box will not be shown
		'priority' => 'high', // high, core, default, low
		'desc' => '', // Description displayed below the title
	);

	public $settings;
	public $options = array();
	public $owner;
	public $postID; // Temporary holder for the current post ID being edited in the admin

	function __construct( $settings, $owner ) {
		$this->owner = $owner;

		if ( ! is_admin() ) {
			return;
		}

		$this->settings = array_merge( $this->defaultSettings, $settings );
		// $this->options = $options;
		if ( empty( $this->settings['name'] ) ) {
			$this->settings['name'] = __( 'More Options', TF_I18NDOMAIN );
		}

		if ( empty( $this->settings['id'] ) ) {
			$this->settings['id'] = str_replace( ' ', '-', trim( strtolower( $this->settings['name'] ) ) );
		}

        $postTypes = is_array( $this->settings['post_type'] ) ? $this->settings['post_type'] : array( $this->settings['post_type'] );



        if( in_array( "nav_menu_item" , $postTypes ) ){
            //edit by parsaatef
            add_action( 'ajax_stars_menu_item_settings', array( $this, 'register_nav_menu_items' ) , 10 , 1 );
        }

		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'save_post', array( $this, 'saveOptions' ), 10, 2 );

		// The action save_post isn't performed for attachments. edit_attachments
		// is a specific action only for attachments.
		add_action( 'edit_attachment', array( $this, 'saveOptions' ) );
	}

    //edit by parsaatef
    public function register_nav_menu_items( $menu_item_id ){

        do_action( "stmenu_before_nav_menu_item_post_meta" , $this );

        $post_id = str_replace( "menu-item-" , "" , $menu_item_id );

        $post_id = (int)$post_id;

        $post = get_post( $post_id );

        $this->display( $post );

        do_action( "stmenu_after_nav_menu_item_post_meta" , $this );

    }

	public function register() {
		$postTypes = array();

		// accomodate multiple post types
		if ( is_array( $this->settings['post_type'] ) ) {
			$postTypes = $this->settings['post_type'];
		} else {
			$postTypes[] = $this->settings['post_type'];
		}

		foreach ( $postTypes as $postType ) {

            //edit by parsaatef
			if( $postType == "nav_menu_item" ){
				continue;
			}

			// Hide the custom fields
			if ( $this->settings['hide_custom_fields'] ) {
				remove_meta_box( 'postcustom' , $postType , 'normal' );
			}

			add_meta_box(
				$this->settings['id'],
				$this->settings['name'],
				array( $this, 'display' ),
				$postType,
				$this->settings['context'],
				$this->settings['priority']
			);
		}
	}

	public function display( $post ) {
		$this->postID = $post->ID;

        //edit by parsaatef
		$display_type = "post_meta";

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] == 'menu_item_settings' ) {
			$display_type = "nav_menu_item";
		}

        do_action( "tf_post_meta_options_before_table" , $this , $display_type );
		//End edit by parsaatef

		wp_nonce_field( $this->settings['id'], TF . '_' . $this->settings['id'] . '_nonce' );

		if ( ! empty( $this->settings['desc'] ) ) {
			?><p class='description'><?php echo $this->settings['desc'] ?></p><?php
		}

		?>
		<table class="form-table tf-form-table">
		<tbody>
		<?php
		foreach ( $this->options as $option ) {
			$option->display();
		}
		?>
		</tbody>
		</table>
		<?php

        //edit by parsaatef
        do_action( "tf_post_meta_options_after_table" , $this , $display_type );

	}

	public function saveOptions( $postID, $post = null ) {

		// Verify nonces and other stuff
		if ( ! $this->verifySecurity( $postID, $post ) ) {
			return;
		}

		/** This action is documented in class-admin-page.php */
		$namespace = $this->owner->optionNamespace;
		do_action( "tf_pre_save_options_{$namespace}", $this );

		// Save the options one by one
		foreach ( $this->options as $option ) {
			if ( empty( $option->settings['id'] ) ) {
				continue;
			}

			if ( ! empty( $_POST[ $this->owner->optionNamespace . '_' . $option->settings['id'] ] ) ) {
				$value = $_POST[ $this->owner->optionNamespace . '_' . $option->settings['id'] ];
			} else {
				$value = '';
			}

			$option->setValue( $value, $postID );
		}

		//edit by parsaatef
		do_action( "tf_meta_options_saved_{$namespace}" , $postID , $this->options );   
	
	}

	private function verifySecurity( $postID, $post = null ) {
		// Verify edit submission
		if ( empty( $_POST ) ) {
			return false;
		}
		if ( empty( $_POST['post_type'] ) ) {
			return false;
		}

		// Don't save on revisions
		if ( wp_is_post_revision( $postID ) ) {
			return false;
		}

		// Don't save on autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		// Verify that we are editing the correct post type
		if ( is_array( $this->settings['post_type'] ) ) {
			if ( ! in_array( $_POST['post_type'], $this->settings['post_type'] ) ) {
				return false;
			}
			if ( null !== $post && ! in_array( $post->post_type, $this->settings['post_type'] ) ) {
				return false;
			}
		} else {
			if ( $_POST['post_type'] != $this->settings['post_type'] ) {
				return false;
			}
			if ( null !== $post && $post->post_type != $this->settings['post_type'] ) {
				return false;
			}
		}

		// Verify our nonce
		if ( ! check_admin_referer( $this->settings['id'], TF . '_' . $this->settings['id'] . '_nonce' ) ) {
			return false;
		}

		// Check permissions
		if ( is_array( $this->settings['post_type'] ) ) {
			if ( in_array( 'page', $this->settings['post_type'] ) ) {
				if ( ! current_user_can( 'edit_page', $postID ) ) {
					return false;
				}
			} else if ( ! current_user_can( 'edit_post', $postID ) ) {
				return false;
			}
		} else {
			if ( $this->settings['post_type'] == 'page' ) {
				if ( ! current_user_can( 'edit_page', $postID ) ) {
					return false;
				}
			} else if ( ! current_user_can( 'edit_post', $postID ) ) {
				return false;
			}
		}

		return true;
	}

	public function createOption( $settings ) {
		if ( ! apply_filters( 'tf_create_option_continue_' . $this->owner->optionNamespace, true, $settings ) ) {
			return null;
		}

		$obj = TitanFrameworkOption::factory( $settings, $this );
		$this->options[] = $obj;

		do_action( 'tf_create_option_' . $this->owner->optionNamespace, $obj );

		return $obj;
	}
	
}

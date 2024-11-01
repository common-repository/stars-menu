<?php
/**
 * Stars Menu Custom Item Types class
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Custom Item Types class
 *
 * Create & Manege Custom Menu Item Types
 *
 * @Class StarsMenuItem
 * @since 1.0.0
 */
class StarsMenuCustomItemTypes {

    /**
     * The stmenu instance of the StarsMenu class.
     *
     * @var StarsMenu
     * @since 0.9
     */
    public $stmenu;

    /**
     * StarsMenuCustomItemTypes constructor.
     * @param $stars_menu
     */
	public function __construct( $stars_menu ) {

        $this->stmenu = $stars_menu;

        if( is_admin() ) {

            add_filter( 'wp_setup_nav_menu_item' , array( $this, 'setup_nav_menu_item' ) );

            add_action( 'admin_init' , array( $this, 'add_meta_box' ) );

        }

	}

    public function setup_nav_menu_item( $menu_item ){

        if( $menu_item->type == 'custom' ){

            //Check flag FIRST, only deal with URL if flag hasn't been set
            $custom_item_type = '';

            $items = $this->get_advanced_items();

            $url = $menu_item->url;

            $stars_menu_prefix = '#starsmenu-';

            //When item is added to menu, set flag
            if( isset( $menu_item->post_status ) && $menu_item->post_status == 'draft' ){

                if( strpos( $url , $stars_menu_prefix ) === 0 ){

                    $custom_item_type = substr( $url , strlen( $stars_menu_prefix ) );

                    update_post_meta( $menu_item->ID , '_stars_menu_custom_item_type' , $custom_item_type );

                }

            }else{

                $custom_item_type = get_post_meta( $menu_item->ID , '_stars_menu_custom_item_type' , true );

            }


            if( $custom_item_type ){

                $menu_item->object = 'starsmenu-custom';	//perhaps if is_admin() only

                $label = $custom_item_type.' Undefined';

                if( isset( $items[$custom_item_type] ) ){

                    $label = $items[$custom_item_type]['label'];

                }

                $menu_item->type_label = '[StarsMenu ' . $label . ']';

            }

        }

        return $menu_item;

    }

    public function get_advanced_items(){

        //items key not support "-" , using "_" instead it
        $items = array(

            'custom'	=> array(
                'label'	    =>	__( 'Custom' , 'stars-menu' ),
                'title'     =>	'['.__( 'Custom' , 'stars-menu' ) . ']',
                'panels'	=>  array( 'row' , 'responsive' ),
                'desc'	    =>	__( 'Using For Create Any Custom Item' , 'stars-menu' ),
            ) ,

            'widget_area' => array(
                'label'	    =>	__( 'Widget Area' , 'stars-menu' ),
                'title'     =>	'['.__( 'Widget Area' , 'stars-menu' ) . ']',
                'panels'	=>  array( 'row' , 'responsive' ),
                'desc'	    =>	__( 'Using For Create Any Widget Area Item' , 'stars-menu' ),
            )

        );

        return apply_filters( 'stmenu_custom_menu_item_types' , $items );

    }


    public function add_meta_box(){

        add_meta_box( 'starsmenu_custom_nav_items', __( 'StarsMenu Advanced Items' , 'stars-menu' ) , array( $this , 'menu_items_meta_box' ) , 'nav-menus', 'side', 'low' );

    }

    public function menu_items_meta_box(){

        global $_nav_menu_placeholder, $nav_menu_selected_id;

        $items = $this->get_advanced_items();

        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        );

        ?>
        <div id="starsmenu-custom-menu-metabox" class="posttypediv">

            <div id="tabs-panel-starsmenu-custom" class="tabs-panel tabs-panel-active">

                <ul id ="starsmenu-custom-checklist" class="categorychecklist form-no-clear">

                    <?php
                    foreach( $items as $id => $item ){

                        $_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;

                        $url = '#starsmenu-'.$id;

                        if( isset( $item['url'] ) ){
                            $url = $item['url'];
                        }

                        ?>

                        <li>
                            <label class="menu-item-title starsmenu-tooltip-wrap" title="<?php echo esc_attr( $item['desc'] ); ?>">
                                <input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-label]" value="0"> <?php echo $item['label']; ?>
                            </label>
                            <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-type]" value="custom">
                            <input type="hidden" class="menu-item-starsmenu-custom" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-starsmenu-custom]" value="on">
                            <input type="hidden" class="menu-item-title" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-title]" value="<?php echo $item['title']; ?>">
                            <input type="hidden" class="menu-item-url" name="menu-item[<?php echo $_nav_menu_placeholder ?>][menu-item-url]" value="<?php echo $url; ?>">
                        </li>

                    <?php } ?>

                </ul>

            </div>

            <p class="button-controls">

                <span class="list-controls">
                    <a href="<?php
                    echo esc_url(add_query_arg(
                        array(
                            'starsmenu-custom-all'  => 'all',
                            'selectall'             => 1,
                        ),
                        remove_query_arg( $removed_args )
                    ));
                    ?>#starsmenu_custom_nav_items" class="select-all"><?php _e( 'Select All' ); ?></a>
                </span>

                <span class="add-to-menu">
                    <input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' , 'stars-menu' ); ?>" name="add-starsmenu-custom-menu-item" id="submit-starsmenu-custom-menu-metabox">
                    <span class="spinner"></span>
                </span>

            </p>

        </div>
        <?php

    }

}

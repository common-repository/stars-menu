<?php
/**
 * Stars Menu Walker Nav Menu Class
 *
 * Manage Walker Nav Menu
 *
 * @author      StarsMenu Team
 * @package     StarsMenu/Elements
 * @version     1.0.0
 */

/**
 * Custom walker class.
 */
class StMenu_Walker_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Started SubMenus
     *
     * @var array
     * @since 1.0.0
     */
    public $started_submenus = array();

    /**
     * Don't print these items
     *
     * @var array
     * @since 1.0.0
     */
    protected $ignore_items = array();

    /**
     * Array Of Stars Menu Items Objects
     *
     * @var array
     * @since 1.0.0
     */
    public $item_stack = array();

    /**
     * Current Stars Menu Item Object
     *
     * @var object
     * @since 1.0.0
     */
    protected $current_stmenu_item;

    /**
     * Menu Id
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $menu_id;

    /**
     * Menu Theme
     *
     * @var string
     * @since 1.0.0
     */
    protected $theme;


    /**
     * StMenu_Walker_Nav_Menu constructor.
     * @param $menu_id
     * @param $theme
     */
    public function __construct( $menu_id , $theme ){

        $this->menu_id = $menu_id;

        $this->theme = $theme;

    }

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){

        if (!$element)
            return;

        $id_field = $this->db_fields['id'];

        if( $this->get_ignore( $element->$id_field ) ){

            unset( $children_elements[$element->$id_field] );

            return;

        }

        //display this element - wp-includes/class-wp-walker.php
        $has_children = ! empty( $children_elements[$element->$id_field] );

        if ( isset( $args[0] ) && is_array( $args[0] ) ){
            $args[0]['has_children'] = $has_children;
        }

        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        $id = $element->$id_field;  // Moved up

        $design = $this->get_menu_design();

        $stmenu_item_object_class = apply_filters( "stmenu_item_object_class_{$design}" , 'StarsMenuItemDefault' , $element , $id );

        $stmenu_item = new $stmenu_item_object_class( $output , $element , $depth, $cb_args[3], $id , $this , $has_children );	//The $args that get passed to start_el are $cb[3] -- i.e. the 4the element in the array merged above

        //Ignoring? Check again after initialization so that item can disable itself
        if( $this->get_ignore( $element->$id_field ) ){
            unset( $children_elements[$element->$id_field] );
            return;
        }

        //Disabled?
        $display_on = $stmenu_item->item_display();

        //If this item is not yet disabled, allow its status to be filtered
        if( $display_on ){
            $display_on = apply_filters( 'stmenu_display_item' , true , $this , $element , $max_depth, $depth, $args , $stmenu_item );
        }

        //If the item is disabled, kill its children, Lannister-style
        if( !$display_on ){
            $this->clear_children( $children_elements , $id );
            return;
        }

        $disabled_children = false;

        //If submenu disabled, clear children but don't return
        if( $stmenu_item->get_option( 'item_submenu_disable_on_mobile' ) ){

            if( stmenu_is_mobile( 'item_submenu_disable_on_mobile' ) ){

                $this->clear_children( $children_elements , $id );

                $stmenu_item->disable_children();

                $disabled_children = true;

            }

        }

        if( $stmenu_item->force_disable_submenu === true && $disabled_children === false ){ 

            $this->clear_children( $children_elements , $id );

            $stmenu_item->disable_children();

        }

        $this->push_item( $stmenu_item );


        call_user_func_array(array($this, 'start_el'), $cb_args);

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

            foreach ( $children_elements[ $id ] as $child ){

                if ( !isset($newlevel) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array($this, 'start_lvl'), $cb_args);
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
            //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array($this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array($this, 'end_el'), $cb_args);
        
    }

    /**
     * Starts the list before the elements are added.
     *
     * Adds classes to the unordered list sub-menus.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        
        $this->current_stmenu_item->start_lvl();
        
    }

    /**
     * Start the element output.
     *
     * Adds main/sub-classes to the list items and links.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @param int    $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $this->current_stmenu_item->start_el();

    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {

        $this->current_stmenu_item->end_lvl();

    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {

        $this->current_stmenu_item->end_el();
        
    }

    /**
     * Recursive function to remove all children
     *
     * @param $children_elements
     * @param $id
     */
    public function clear_children( &$children_elements , $id ){

        if( empty( $children_elements[ $id ] ) ) return;

        foreach( $children_elements[ $id ] as $child ){
            $this->clear_children( $children_elements , $child->ID );
        }
        unset( $children_elements[ $id ] );
    }

    private function get_menu_design(){
     
        return stmenu_theme_option( 'theme_design' , $this->theme );
        
    }

    public function get_template( $template_name, $args = array(), $template_path = '', $default_path = ''){

        $template_name = $this->get_menu_design() . "/" . $template_name;

        $html = stmenu_get_template_html( $template_name, $args , $template_path , $default_path );

        return $html;

    }

    public function get_option( $setting_id , $item ){

        $menu_item_id = $item->ID;

        return stmenu_item_option( $setting_id , $menu_item_id );

    }

    public function set_ignore( $id , $ignore = true ){

        $this->ignore_items[$id] = $ignore;

    }


    public function get_ignore( $id ){

        if( isset( $this->ignore_items[$id] ) && $this->ignore_items[$id] ){
            return true;
        }

        return false;

    }

    public function push_item( $stmenu_item ){
        $this->item_stack[] = $stmenu_item;
        $this->current_stmenu_item = $stmenu_item;
    }

    public function pop_item(){

        array_pop( $this->item_stack );

        $this->current_stmenu_item = $this->current_item();

    }

    public function current_item(){
        return end( $this->item_stack );
    }

    public function parent_item(){
        return isset( $this->item_stack[count($this->item_stack)-2] ) ?
            $this->item_stack[count($this->item_stack)-2] :
            false;
    }

    public function grandparent_item(){
        return isset( $this->item_stack[count($this->item_stack)-3] ) ?
            $this->item_stack[count($this->item_stack)-3] :
            false;
    }

    public function closest_item_type( $type ){
        for( $k = count( $this->item_stack ) - 1 ; $k >= 0 ; $k-- ){
            if( $this->item_stack[$k]->get_type() == $type ){
                return $this->item_stack[$k];
            }
        }
    }

}

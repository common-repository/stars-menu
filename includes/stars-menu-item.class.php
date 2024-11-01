<?php
/**
 * Stars Menu Item class
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Stars Menu Item class
 *
 * Create & Manege Menu Item
 *
 * @Class StarsMenuItem
 * @since 1.0.0
 */
abstract class StarsMenuItem {

    /**
     * Menu Item Object
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $item;

    /**
     * Menu Item Type
     *
     * @var string
     * @since 1.0.0
     */
    protected $type = "default";

    /**
     * Menu Item Level
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $depth;

    /**
     * Menu Item Args
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $args;

    /**
     * Menu Item Id
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $id;

    /**
     * Walker
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $walker;

    /**
     * Menu Item Output
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $output;

    /**
     * Array Of Menu Item Classes
     *
     * @var array
     * @since 1.0.0
     */
    protected $item_classes = array();

    /**
     * Array Of Menu Item Attributes
     *
     * @var array
     * @since 1.0.0
     */
    protected $item_attributes = array();

    /**
     * Array Of Menu Item Link Classes
     *
     * @var array
     * @since 1.0.0
     */
    protected $link_classes = array();

    /**
     * Array Of Menu Item Link Classes
     *
     * @var array
     * @since 1.0.0
     */
    protected $link_attributes = array();

    /**
     * The Tag Of Link
     *
     * @var array
     * @since 1.0.0
     */
    protected $link_tag = 'a';

    /**
     * Array Of SubMenu Classes
     *
     * @var array
     * @since 1.0.0
     */
    protected $submenu_classes = array();

    /**
     * The Tag Of SubMenu
     *
     * @var array
     * @since 1.0.0
     */
    protected $submenu_tag = 'ul';

    /**
     * Menu Item Has Children ?
     *
     * @var StarsMenu
     * @since 1.0.0
     */
    protected $has_children = false;

    /**
     * Item End Html
     *
     * @var string
     * @since 1.0.0
     */
    public $before_arg_item = '';

    /**
     * Item Start Html
     *
     * @var string
     * @since 1.0.0
     */
    public $after_arg_item = '';

    /**
     * Before Link Item Html
     *
     * @var string
     * @since 1.0.0
     */
    public $link_before = '';

    /**
     * After Link Item Html
     *
     * @var string
     * @since 1.0.0
     */
    public $link_after = '';

    /**
     * After Link Item Html
     *
     * @var string
     * @since 1.0.0
     */
    public $item_layout = 'text';

    /**
     * Force Disable Current Item SubMenus
     *
     * @var string
     * @since 1.0.0
     */
    public $force_disable_submenu = false;

    /**
     * StarsMenuItem constructor.
     * @param string $output
     * @param object $item
     * @param int $depth
     * @param array $args
     * @param int $id
     * @param object $walker
     * @param bool $has_children
     */
	public function __construct( &$output , &$item , $depth = 0, &$args = array() , $id = 0 , &$walker , $has_children = false ) {

        $this->output 	        = &$output;

        $this->item 	        = &$item;

        $this->depth 	        = $depth;

        $this->args 	        = &$args;

        $this->id 		        = $id;

        $this->walker 	        = &$walker;

        $this->has_children     = $has_children;

        $this->ID               = $this->item->ID;

        $this->init();

	}

    /**
     * Allows subclasses to hook in
     */
    public function init(){}

    public function start_el(){

        $this->output .= apply_filters( 'walker_nav_menu_start_el' , $this->get_start_el() , $this->item , $this->depth , $this->args );
    }

    abstract function get_start_el();

    public function end_el(){

        $this->output.= $this->get_end_el();
        
    }

    abstract function get_end_el();
    
    public function start_lvl(){

        $this->output.= $this->get_start_lvl();
        
    }

    abstract function get_start_lvl();

    public function end_lvl(){

        $this->output.= $this->get_end_lvl();
    }

    abstract function get_end_lvl();

    function get_type(){
        return $this->type;
    }

    public function item_display(){

        if( $this->get_option( 'item_hide_on_mobile' ) ){
            if( stmenu_is_mobile( 'item_hide_on_mobile' ) ){
                return false;
            }
        }

        if( $this->get_option( 'item_hide_on_desktop' ) ){
            if( !stmenu_is_mobile( 'item_hide_on_desktop' ) ){
                return false;
            }
        }

        return true;
    }

    public function add_class_responsive(){

        if( $this->get_option( 'item_hide_below_breakpoint' ) ){
            $this->item_classes[] = 'starsmenu-item-hide-mobile';
        }

        if( $this->get_option( 'item_hide_above_breakpoint' ) ){
            $this->item_classes[] = 'starsmenu-item-hide-desktop';
        }

    }

    public function disable_children(){
        $this->has_children = false;

        $_item = $this->item;
        if( ( $key = array_search( 'menu-item-has-children', $_item->classes ) ) !== false) {
            unset( $_item->classes[$key] );
        }
        //Possibly remove menu item parent/menu item ancestor classes as well
    }

    public function set_item_default_classes(){

        //$classes = empty( $this->item->classes ) ? array() : (array) $this->item->classes;

        if( is_array( $this->item->classes ) ){
            
            $this->item_classes = array_merge( $this->item_classes , $this->item->classes );

            //Disable Current Menu Item Classes (do this first for efficiency)
            if( $this->get_option( 'item_disable_current' ) ){

                $remove_current = array( 'current-menu-item' , 'current-menu-parent' , 'current-menu-ancestor' );

                foreach( $this->item_classes as $k => $c ){
                    if( in_array( $c ,  $remove_current ) ){
                        unset( $this->item_classes[$k] );
                    }
                }

                $this->item_classes[] = 'starsmenu_nocurrent';
            }

        }

    }

    /**
     * Depth-dependent classes.
     */
    public function add_depth_classes(){

        $depth_classes = array(
            ( $this->depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
            ( $this->depth >=2 ? 'sub-sub-menu-item' : '' ),
            ( $this->depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
            'menu-item-depth-' . $this->depth
        );

        $this->item_classes = array_merge( $this->item_classes , $depth_classes );

    }

    public function add_id_class(){
        $this->item_classes[] = 'nav-menu-item-'. $this->item->ID;
    }

    /*public function add_alignment_class(){

        $align = $this->get_option( 'item_align' );

        if( $align && $align != 'auto' ){
            $this->item_classes[] = 'starsmenu-align-'.$align;
        }

    }*/

    public function add_class_disable_padding(){

        $disable_padding = $this->get_option( 'item_disable_padding' );

        if( $disable_padding ){
            $this->item_classes[] = 'starsmenu-disable-padding';
        }

    }

    public function add_dropdown_class(){

        if( $this->has_children && $this->depth == 0 ) {

            $this->item_classes[] = "starsmenu-dropdown-toggle";

        }

    }

    public function add_dropdown_position_class(){

        if( $this->has_children && $this->depth == 0 ) {

            $item_submenu_position = $this->get_option('item_dropdown_position');

            $theme_submenu_position = $this->get_theme_option('theme_dropdowns_position');

            $item_submenu_position = ($item_submenu_position == "default") ? $theme_submenu_position : $item_submenu_position;

            $this->item_classes[] = "starsmenu-dropdown-position-{$item_submenu_position}";
        }

    }

    public function add_dropdown_trigger_class(){

        if( $this->has_children && $this->depth == 0 ) {

            $item_submenu_trigger = $this->get_option('item_dropdown_trigger');

            $theme_submenu_trigger = $this->get_theme_option('theme_dropdowns_trigger');

            $item_submenu_trigger = ($item_submenu_trigger == "default") ? $theme_submenu_trigger : $item_submenu_trigger;

            $this->item_classes[] = "starsmenu-dropdown-trigger-{$item_submenu_trigger}";
        }

    }

    public function get_item_class_names(){
        /**
         * Filter the CSS class(es) applied to a menu item's <li>.
         *
         * @since 3.0.0
         *
         * @param array  $classes The CSS classes that are applied to the menu item's <li>.
         * @param object $item    The current menu item.
         * @param array  $args    An array of arguments. @see wp_nav_menu()
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $this->item_classes ), $this->item, $this->args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        return $class_names;
    }

    public function get_item_id(){
        /**
         * Filter the ID applied to a menu item's <li>.
         *
         * @since 3.0.1
         *
         * @param string The ID that is applied to the menu item's <li>.
         * @param object $item The current menu item.
         * @param array $args An array of arguments. @see wp_nav_menu()
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $this->item->ID, $this->item, $this->args );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        return $id;
    }

    public function get_item_attributes(){

        $item_attributes = apply_filters( 'nav_menu_item_attributes', $this->item_attributes , $this->item, $this->args );

        $attributes = '';

        foreach ( $item_attributes as $attr => $value ) {
            if ( ! empty( $value ) || $value === 0 ) {

                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }

        return $attributes;

    }

        /**
     * Get the attributes for the Link, including class, title, target, rel, href
     * Filterable with 'nav_menu_link_attributes'
     * @return array 	An array of attributes with attribute names as keys and attribute values as values i.e. $key="$val"
     */
    public function set_link_default_attributes(){

        $this->link_attributes['title']  = ! empty( $this->item->attr_title ) ? $this->item->attr_title : '';

        $this->link_attributes['target'] = ! empty( $this->item->target )     ? $this->item->target     : '';

        $this->link_attributes['rel']    = ! empty( $this->item->xfn )        ? $this->item->xfn        : '';

        $this->link_attributes['href']   = ! empty( $this->item->url )        ? $this->item->url        : '';

        if( $this->depth == 0 ){
            $this->link_attributes['tabindex'] = 0;
        }

    }

    public function get_link_attributes(){

        /**
         * Filter the HTML attributes applied to a menu item's <a>.
         *
         * @since 1.0.0
         *
         * @param array $attributes {
         *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
         *
         *     @type string $title  The title attribute.
         *     @type string $target The target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item The current menu item.
         * @param array  $args An array of arguments. @see wp_nav_menu()
         */
        $attributes = apply_filters( 'nav_menu_link_attributes', $this->link_attributes , $this->item, $this->args );

        $attributes_string = "";
        
        foreach ( $attributes as $attr => $value ) {
            if ( ! empty( $value ) || $value === 0 ) {

                $value = ( $attr == "href" ) ? esc_url( $value ) : esc_attr( $value );

                $attributes_string .= ' ' . $attr . '="' . $value . '"';
            }
        }

        return $attributes_string;

    }

    public function get_link_class_names(){

        $class_names = join( ' ', apply_filters( 'nav_menu_link_css_class', array_filter( $this->link_classes ), $this->item, $this->args ) );

        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        return $class_names;

    }

    public function set_link_default_classes(){

        $this->link_classes[] = "starsmenu-link";

        $this->link_classes[] = $this->depth > 0 ? 'sub-menu-link' : 'main-menu-link';

    }

    public function get_item_start(){

        $before = $this->args->before;

        $before .= $this->before_arg_item;

        return $before;

    }

    public function get_item_end(){

        $after = $this->args->after;

        $after = $this->after_arg_item . $after;

        return $after;

    }

    public function get_link_before(){

        $before = $this->args->link_before;

        $before .= $this->link_before;

        return $before;

    }

    public function get_link_after(){

        $after = $this->args->link_after;

        $after = $this->link_after . $after;

        return $after;

    }

    public function get_text( ){

        $title = ''; 

        if( ! $this->get_option( 'item_hide_text' ) ){

            $_title = $this->item->title;

            if( $this->get_theme_option( 'theme_item_allow_shortcodes_label_desc' ) ){
                $_title = do_shortcode( $_title );
            }

            $title = $this->walker->get_template( "item_title.php" , array(
                'item'                  => $this->item ,
                'has_children'          => $this->has_children ,
                'title'                 => $_title
            ));

        } else{
            //Flag items with disabled text
            $this->link_classes[] = 'starsmenu-item-notext';
        }

        return $title;

    }

    public function disable_link( ){

        if( $this->is_disable_link() ){

            $this->link_tag = 'span';

            unset( $this->link_attributes['href'] );

        }

    }

    public function is_disable_link(){

        return $this->get_option( 'item_disable_link' );

    }

    public function highlight_link_class(){

        if( $this->get_option( 'item_highlight_link' ) ){
            $this->item_classes[] = 'starsmenu-highlight-item';  
        }

    }

    public function no_wrap_link(){

        if( $this->get_option( 'item_no_wrap_title' ) ){
            $this->link_classes[] = 'starsmenu-nowrap-link';
        }

    }

    public function item_description(){

        //Description
        $description = '';

        if( $this->item->description ){

            if( ( ! $this->get_theme_option( 'theme_items_descriptions_mobile' ) ) && stmenu_is_mobile( 'theme_items_descriptions_mobile' ) ){
                return '';
            }

            if( ( ( $this->get_theme_option( 'theme_top_level_descriptions' ) && $this->depth == 0 ) ||
                ( $this->get_theme_option( 'theme_normal_items_descriptions' ) && $this->depth > 0 ) ) &&
                $this->get_option( 'item_desc_display' ) )
            {

                $_desc = $this->item->description;

                if( $this->get_theme_option( 'theme_item_allow_shortcodes_label_desc' ) ){

                    $_desc = do_shortcode( $_desc );

                }

                $description = $this->walker->get_template( "item_description.php" , array(
                    'item'                  => $this->item ,
                    'has_children'          => $this->has_children ,
                    'description'           => $_desc
                ));

            }

        }

        return $description;

    }

    public function get_item_arrow( ){

        return stmenu_get_item_arrow();
    }

    public function get_back_item_arrow( ){

        $icon = $this->get_theme_option( 'theme_back_items_arrow' );

        $arrow_classes = '';

        if( !empty( $icon ) ) {

            $arrow_classes = LA_IconManager::getIconClass($icon);

        }

        return $arrow_classes;
    }

    public function get_icon( ){

        $icon = $this->get_option( 'item_icon' );

        if( !empty( $icon ) ) {

            $icon_classes = LA_IconManager::getIconClass($icon);

            $icon_classes = apply_filters( 'stmenu_icon_custom_class', $icon_classes , $this->id );

            if ($icon_classes) {

                $this->link_classes[] = 'starsmenu-target-with-icon';

                $icon_tag = $this->get_theme_option('theme_icons_tag');

                $icon_tag = !$icon_tag ? 'i' : $icon_tag;

                $icon = $this->walker->get_template( "item_icon.php" , array(
                    'item'                  => $this->item ,
                    'has_children'          => $this->has_children ,
                    'icon_tag'              => $icon_tag ,
                    'icon_classes'          => $icon_classes ,
                ));

            }

        }

        return $icon;

    }

    /**
     * Get the HTML for the image attached to this menu item
     *
     * Any set img ID will override image src filtering
     *
     * @return string img HTML
     */
    public function get_image(){

        //Ignore On mobile?
        if( ( $this->get_theme_option( 'theme_disable_mobile_images' ) ) && stmenu_is_mobile( 'disable_mobile_images' ) ){
            return '';
        }

        $html = apply_filters( 'starsmenu_item_image' , '' , $this );

        if( $html ) {
            return $html;
        }

        $attachment_id = $this->get_option( 'item_image' );

        //Determine size of image to get
        $size = $this->get_option( 'item_image_size' );

        if( $size == 'inherit' ){
            $size = $this->get_theme_option( 'theme_images_size' );
        }

        $image = wp_get_attachment_image_src( $attachment_id , $size );

        if( $image ){

            list( $src , $width , $height ) = $image;

            $size_class = $size;

            if ( is_array( $size_class ) ) {
                $size_class = join( 'x', $size_class );
            }

            $attachment = get_post( $attachment_id );

            $attributes = array(
                'src'   => $src,
                'class' => "attachment-$size_class size-$size_class",
                'alt'   => trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) )), // Use Alt field first
            );

            if ( empty($attributes['alt']) )
                $attributes['alt'] = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption

            if ( empty($attributes['alt']) )
                $attributes['alt'] = trim(strip_tags( $attachment->post_title )); // Finally, use the title

            if ( empty($attributes['alt']) )
                $attributes['alt'] = get_the_title( $attachment_id ); // Finally, use the title

            // Generate 'srcset' and 'sizes' if not already present.
            $image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );

            if ( is_array( $image_meta ) ) {
                $size_array = array( absint( $width ), absint( $height ) );
                $srcset = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
                $sizes = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

                if ( $srcset && ( $sizes || ! empty( $attributes['sizes'] ) ) ) {
                    $attributes['srcset'] = $srcset;

                    if ( empty( $attributes['sizes'] ) ) {
                        $attributes['sizes'] = $sizes;
                    }
                }
            }

            //Determine dimensions
            $img_w = '';
            $img_h = '';
            $dimensions = $this->get_option( 'item_image_dimensions' );

            switch( $dimensions ){

                //Custom Dimensions use Menu Item Settings
                case 'custom':
                    $img_w = $this->get_option( 'item_image_width' );
                    $img_h = $this->get_option( 'item_image_height' );
                    break;

                //Inherit settings from main Menu Settings
                case 'inherit':
                    $img_w = $this->get_theme_option( 'theme_image_width' );
                    $img_h = $this->get_theme_option( 'theme_image_height' );
                    break;

                //Add width and height atts for natural width
                case 'natural':
                    //Done below
                    break;

                default:
                    break;
            }

            //Apply natural dimensions if not already set
            if( $this->get_theme_option( 'theme_image_dimensions' ) ){

                if( $img_w == '' && $img_h == '' ){
                    $img_w = $width;
                    $img_h = $height;
                }

            }

            //Add dimensions as attributes, with pixel units if missing
            if( $img_w ){
                $attributes['width']	= $img_w;
            }

            if( $img_h ){
                $attributes['height']   = $img_h;
            }

            if( $this->get_theme_option( 'theme_image_title_attr' ) ){

                $attributes['title'] = get_the_title( $attachment_id );

            }

            /**
             * Filters the list of attachment image attributes.
             *
             * @since 2.8.0
             *
             * @param array        $attr       Attributes for the image markup.
             * @param WP_Post      $attachment Image attachment post.
             * @param string|array $size       Requested size. Image size or array of width and height values
             *                                 (in that order). Default 'thumbnail'.
             */
            $attributes = apply_filters( 'stmenu_get_attachment_image_attributes' , $attributes, $attachment, $size , $this );

            if( !in_array( 'starsmenu-has-image' , $this->link_classes ) ) {
                $this->link_classes[] = 'starsmenu-has-image';
            }

            $html = $this->walker->get_template( "item_image.php" , array(
                'item'                  => $this->item ,
                'has_children'          => $this->has_children ,
                'attributes'            => $attributes
            ));

        }

        return $html;

    }

    public function get_custom_content(){

        $html = '';
        $custom_content = $this->get_option( 'item_custom_content' );

        if( $custom_content ){

            //$pad_custom_content = $this->get_option( 'pad_custom_content' ) == 'on' ? 'starsmenu-custom-content-padded' : '' ;
            $html.= '<div class="starsmenu-custom-content ">';
            $html.= do_shortcode( $custom_content );
            $html.= '</div>';

        }

        return $html;

    }

    public function get_widget_area(){

        $html = '';

        $widget_area_id = $this->get_option('item_widget_area'); 

        if( !empty( $widget_area_id ) && is_active_sidebar( $widget_area_id ) ){

            ob_start();
            ?>

            <ul class="starsmenu-widget-area starsmenu-<?php echo esc_attr( $widget_area_id );?>">
                <?php dynamic_sidebar( $widget_area_id ); ?>
            </ul><!-- .sidebar .widget-area -->

            <?php
            $html = ob_get_clean();
        }

        return $html;

    }

    public function get_item_layout(){

        $layout_classes = array();

        /**
         * Set Item Layout
         */
        if( $this->depth == 0 ) {

            $theme_items_layout = $this->get_theme_option('theme_items_layout_top_level');

        }else {

            $theme_items_layout = $this->get_theme_option('theme_items_layout_submenus');
        }

        $item_layout = $this->get_option( 'item_layout' );

        if( $item_layout == "default" ){

            $item_layout = $theme_items_layout;

        }

        /**
         * Set Item Alignment
         */
        if( $this->depth == 0 ) {

            $theme_items_alignment = $this->get_theme_option('theme_items_alignment_top_level');

        }else {

            $theme_items_alignment = $this->get_theme_option('theme_items_alignment_submenus');
        }

        $item_alignment = $this->get_option( 'item_alignment' );

        if( $item_alignment == "default" ){

            $item_alignment = $theme_items_alignment;

        }

        $layout_classes[] = "starsmenu-item-align-{$item_alignment}";


        /**
         * Icons/Images Layout
         */
        if( $this->depth == 0 ) {

            $theme_icons_images_layout = $this->get_theme_option('theme_icons_images_layout_top_level');

        }else {

            $theme_icons_images_layout = $this->get_theme_option('theme_icons_images_layout_submenus');
        }

        switch ( $item_layout ){

            case "text" :

                $layout = "text";

                $layout_classes[] = "starsmenu-text-layout";

                break;

            case "text-image" :

                $layout_classes[] = "starsmenu-text-image-layout";

                $image_layout = $this->get_option( 'item_image_layout' );

                if( $image_layout == "default" ){
                    $image_layout = $theme_icons_images_layout;
                }

                $layout = "text-image-{$image_layout}";

                $layout_classes[] = "starsmenu-text-image-{$image_layout}-layout";

                break;

            case "text-icon" :

                $layout_classes[] = "starsmenu-text-icon-layout";

                $icon_layout = $this->get_option( 'item_icon_layout' );

                if( $icon_layout == "default" ){
                    $icon_layout = $theme_icons_images_layout;
                }

                $layout = "text-icon-{$icon_layout}";

                $layout_classes[] = "starsmenu-text-icon-{$icon_layout}-layout";

                break;

            case "icon" :

                $layout = "icon";

                $layout_classes[] = "starsmenu-icon-layout";

                break;

            case "image" :

                $layout = "image";

                $layout_classes[] = "starsmenu-image-layout";

                break;

        }

        $this->link_classes = array_merge( $this->link_classes , $layout_classes );

        $this->item_layout = $layout;

        return $layout;

    }

    public function get_option( $setting_id ){

        return stmenu_item_option( $setting_id , $this->id );

    }

    public function get_theme_option( $setting_id ){

        return stmenu_theme_option( $setting_id , StMenu()->current_theme );

    }

}

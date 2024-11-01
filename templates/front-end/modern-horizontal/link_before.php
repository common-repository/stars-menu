<?php
/**
 * Stars Menu Link Before Template
 *
 * This template can be overridden by copying it to yourtheme/stmenu/modern-horizontal/link_before.php.
 *
 * HOWEVER, on occasion StarsMenu will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://www.stars-menu.com/documentation/template-structure/
 * @author 		StarsMenu Team
 * @package 	StarsMenu/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $has_children && ( empty( $item->url ) || trim( $item->url ) == "#" || $is_disable_link ) && !$back_item_mode ) {
	?>
    <!-- <span> -->
	<?php
}else if( $back_item_mode ){
	
	?>
	<div class="starsmenu-item-arrow-back"><i class="<?php echo esc_attr( $arrow );?>"></i></div>
	<?php
	
}


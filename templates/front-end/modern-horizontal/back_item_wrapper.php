<?php
/**
 * Start Menu Start Element Template
 *
 * This template can be overridden by copying it to yourtheme/stmenu/modern-horizontal/start_el.php.
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

?>

<li <?php echo $class_names . " " . $item_attributes;?>>
	<?php echo $before;?>
		<<?php echo $link_tag;?> <?php echo $link_class_names;?> <?php echo $link_attributes;?> >
			<?php echo $link_before;?>
			<?php echo $layout_content;?>
			<?php echo $link_after;?>
		</<?php echo $link_tag;?>>
	<?php echo $after;?>
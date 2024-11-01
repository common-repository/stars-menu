<?php
/**
 * Start Menu Start Level Template
 *
 * This template can be overridden by copying it to yourtheme/stmenu/modern-horizontal/start_lvl.php.
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

<div class="starsmenu-main-area starsmenu-elitem-wrapper starsmenu-elitem-main-area">

    <?php echo $left_nav;?>  

    <?php echo $nav_menu;?> 

    <?php echo $right_nav;?>

</div>

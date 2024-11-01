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

<?php echo apply_filters('the_content', $before_menu );?>

<div id="<?php echo $wrapper_id;?>" class="stars-menu-bar-wrapper <?php echo esc_attr( $wrapper_class_names );?>">

    <div class="stars-menu-bar-wrapper-inner starsmenu-clearfix"> 

        <div class="starsmenu-main-area-close starsmenu-hide"><i class="<?php echo esc_attr( $responsive_close_icon );?>"></i></div>   

        <div class="stars-menu-left-wrapper">

            <?php echo $left_area;?>

        </div>


        <div class="stars-menu-center-wrapper">  
            
            <?php echo $center_area;?>

        </div>


        <div class="stars-menu-right-wrapper">

            <?php echo $right_area;?>

        </div>


    </div>

</div>

<?php echo apply_filters('the_content', $after_menu );?>


<?php
/**
 * Base Configuration
 *
 * @package StarsMenu
 * @subpackage settings/menu-theme
 */

ob_start();
?>
<p> <?php echo __( 'Define any custom CSS you wish to add to menus using this theme. You can use standard CSS or SCSS.' , "stars-menu" );?> </p>
<div class="stars_menu-custom_css_tips">

    <?php /* ?>
    <p><b><?php echo __( 'Custom Styling Tips' , "stars-menu" );?></b></p>
    <ul class="custom_styling_tips">
        <li><code>#{$wrap}</code><?php echo __( 'converts to the ID selector of the menu wrapper, e.g. div#mega-menu-wrap-primary' , "stars-menu" );?></li>
        <li><code>#{$menu}</code><?php echo __( 'converts to the ID selector of the menu, e.g. ul#mega-menu-primary' , "stars-menu" );?></li>
        <li><?php printf( __( 'Using the %1$s and %2$s variables makes your theme portable (allowing you to apply the same theme to multiple menu locations).' , "stars-menu" ) ,'<code>#{$wrap}</code>' , '<code>#{$menu}</code>' );?></li>
        <li><?php echo __( 'Example CSS:' , "stars-menu" );?></li>
        <code>/** Add text shadow to top level menu items **//*<br>#{$wrap} #{$menu} &gt; li.mega-menu-item &gt; a.mega-menu-link {<br>&nbsp;&nbsp;&nbsp;&nbsp;text-shadow: 1px 1px #000000;<br>}</code>
    </ul> */ ?>

</div>
<?php
$desc = ob_get_clean();

$advanced_options = array(

    array(
        'name'                  => __( "Advanced" , "stars-menu" ),
        'type'                  => 'heading' ,
        'tab'                   => 'advanced'
    ),

    array(
        'name'                  => __( 'CSS Editor' , "stars-menu" ) ,
        'id'                    => 'theme_custom_css' ,
        'type'                  => 'code' ,
        'lang'                  => 'css' ,
        'default'               => '' ,
        'enqueue'               => false ,
        'height'                => 400 ,
        'desc'                  => $desc,
        'tab'                   => 'advanced'
    ) ,

);

$options = array_merge( $options , $advanced_options );


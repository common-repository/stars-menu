<?php
/**
 * The template for displaying all Stars Menu Themes
 *
 * @package StarsMenu
 * @subpackage Template
 * @since 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php

    // Start the loop.
    while ( have_posts() ) : the_post();

        $menus = stmenu_menus_assigned_to_theme( get_the_ID() );

        if( empty( $menus ) ){

            echo '<p style="margin-top: 100px; text-align: center;">' . __( "this theme not assigned to any menus." , "stars-menu" ) . '</p>';

        } else {


            foreach ( $menus As $location => $menu_id ) {

                if ( has_nav_menu( $location ) ) {

                    wp_nav_menu( array( 'theme_location' => $location ) );

                    break;

                }

            }

        }

    endwhile;
?>

<?php wp_footer(); ?>

</body>
</html>

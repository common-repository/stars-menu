<?php
/**
 * Stars Menu Widget class
 *
 * @package StarsMenu
 * @subpackage Core
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

if ( ! class_exists('StarsMenuWidget') ) :

    /**
     * Stars Menu Widget class
     *
     * Outputs a registered menu location using wp_nav_menu
     *
     * @Class StarsMenuWidget
     * @since 1.0.0
     */
    class StarsMenuWidget extends WP_Widget  {

        /**
         * StarsMenuWidget constructor.
         *
         * Register widget with WordPress.
         *
         */
        public function __construct() {
            parent::__construct(
                'starsmenu', // Base ID
                'Stars Menu', // Name
                array( 'description' => __( 'Outputs a menu for a selected theme location.', 'stars-menu' ) ) // Args
            );
        }


        /**
         * Front-end display of widget.
         *
         * @since 1.7.4
         * @see WP_Widget::widget()
         * @param array   $args     Widget arguments.
         * @param array   $instance Saved values from database.
         */
        public function widget( $args, $instance ) {
            extract( $args );

            if ( isset( $instance['location'] ) ) {
                $location = $instance['location'];

                $title = apply_filters( 'widget_title', $instance['title'] );

                echo $before_widget;

                if ( ! empty( $title ) ) {
                    echo $before_title . $title . $after_title;
                }

                if ( has_nav_menu( $location ) ) {
                    wp_nav_menu( array( 'theme_location' => $location ) );
                }

                echo $after_widget;
            }
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @since 1.0.0
         * @see WP_Widget::update()
         * @param array   $new_instance Values just sent to be saved.
         * @param array   $old_instance Previously saved values from database.
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['location'] = strip_tags( $new_instance['location'] );
            $instance['title'] = strip_tags( $new_instance['title'] );

            return $instance;
        }

        /**
         * Back-end widget form.
         *
         * @since 1.0.0
         * @see WP_Widget::form()
         * @param $instance array Previously saved values from database.
         * @return string|void
         */
        public function form( $instance ) {

            $selected_location = 0;
            $title = "";
            $locations = get_registered_nav_menus();

            if ( isset( $instance['location'] ) ) {
                $selected_location = $instance['location'];
            }

            if ( isset( $instance['title'] ) ) {
                $title = $instance['title'];
            }

            ?>
            <p>
            <?php if ( $locations ) { ?>
                <p>
                    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'stars-menu' ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </p>
                <label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php _e( 'Menu Location:', 'stars-menu' ); ?></label>
                <select id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>">
                    <?php
                    foreach ( $locations as $location => $description ) {
                        echo "<option value='{$location}'" . selected($location, $selected_location) . ">{$description}</option>";
                    }
                    ?>
                </select>
            <?php } else {
                _e( 'No menu locations found', 'stars-menu' );
            } ?>
            </p>
            <?php
        }

    }

endif;

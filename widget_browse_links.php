<?php
/**
 * Created by PhpStorm.
 * User: gautier
 * Date: 26/06/2014
 * Time: 06:38
 */
require_once(plugin_dir_path( __FILE__ ) ."lib/cawrappercache/ItemServiceCache.php");

add_action( 'widgets_init', 'collectiveaccess_register_browse_links_widget' );

//register our widget
function collectiveaccess_register_browse_links_widget() {
    register_widget( 'browse_links_widget' );
}

class browse_links_widget extends WP_Widget {

    //process the new widget
    function browse_links_widget() {

        $widget_ops = array(
            'classname' => 'browse_links_widget_class',
            'description' => __('Display browse collections links','collectiveaccess')
        );

        $this->WP_Widget( 'browse_links_widget', 'CollectiveAccess browse collections links', $widget_ops );
    }

    //build the widget settings form
    function form($instance) {
        $defaults = array(
            'title' => __('Browse collections','CollectiveAccess'),
        );
        // TODO : add checkboxes to select which collections parts are browsable
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title = $instance['title'];
        ?>
        <p>Title: <input class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>"  type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
    <?php
    }

    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    //display the widget
    function widget($args, $instance) {
        extract($args);

        $title = (!empty($instance['title']) ? $instance['title'] : '');

        echo $before_widget;
        $widget_body = "<ul>";
        $widget_body .= "<li><a href='".get_site_url()."/collections/objects/browse'>".__("Objects","collectiveaccess")."</a></li>";
        $widget_body .= "<li><a href='".get_site_url()."/collections/entities/browse'>".__("Entities","collectiveaccess")."</a></li>";
        $widget_body .= "<li><a href='".get_site_url()."/collections/collections/browse'>".__("Collections","collectiveaccess")."</a></li>";
        $widget_body .= "<li><a href='".get_site_url()."/collections/places/browse'>".__("Places","collectiveaccess")."</a></li>";
        $widget_body .= "<li><a href='".get_site_url()."/collections/occurrences/browse'>".__("Occurrences","collectiveaccess")."</a></li>";
        $widget_body .= "</ul>";

        if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
        print $widget_body;
        echo $after_widget;
    }
}
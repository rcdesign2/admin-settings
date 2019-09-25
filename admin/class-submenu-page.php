<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-27
 * Time: 10:41
 */

/**
 * Creates the submenu page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the submenu with which this page is associated.
 *
 * @package Custom_Admin_Settings
 */
class Submenu_Page {


    public function __construct( $deserializer ) {
        $this->deserializer = $deserializer;
    }


    /**
     * This function renders the contents of the page associated with the Submenu
     * that invokes the render method. In the context of this plugin, this is the
     * Submenu class.
     */
    public function render() {
        include_once( 'views/settings.php' );
    }
}

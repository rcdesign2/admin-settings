<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-27
 * Time: 11:12
 */

class Deserializer {

    public function get_value( $option_key ) {
        return get_option( $option_key, '' );
    }
}
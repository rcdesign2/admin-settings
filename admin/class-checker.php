<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-28
 * Time: 15:17
 */


class Checker
{


    private $type;
    private $count;


    public function __construct($type)
    {
        $this->type = $type;
        $this->count = get_option('rc-' . $type . '-count');
    }


    public function begin()
    {
        $posts = $this->get_posts();
        /*
         * This means that we have more posts than we do in the count.
         */
        if($this->count < sizeof($posts)){
            $ids = $this->get_ids_to_remove($posts);
            $this->remove_posts($ids);

        }

    }


    private function get_posts()
    {

        $args = [
            'posts_per_page' => -1,
            'post_type' => 'rc_social_post',
            'post_status' => 'publish',
        ];

        $posts = [];
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {


            while ($the_query->have_posts()) {
                $the_query->the_post();
                $posts[] = get_post();
            }

            /* Restore original Post Data */
            wp_reset_postdata();
        }
        sort($posts);
        return $posts;
    }

    private function get_ids_to_remove($posts){

        $posts_to_remove = array();
        foreach($posts as $index=>$post){
            if($index+1 <= $this->count){
                continue;
            }
            $posts_to_remove[] = $post->ID;

        }

        return $posts_to_remove;
    }


    private function remove_posts($ids){

        if(!empty($ids)){
            foreach($ids as $id){
                 wp_delete_post($id,1);
            }
        }

    }


}
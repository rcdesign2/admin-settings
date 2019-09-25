<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-26
 * Time: 11:27
 */


/*
 * Instead of using the complex instagram api, this allows us to just use a simple get_content request in a nice json format
 * which instagram provides - how nice
 */
function Instagram_Feed($account_name,$count)
{
    if ($account_name == null || $count == null ) {
        return;
    }

    $option = array(
        '__a' => '1',
    );
    $url = "https://www.instagram.com/" . $account_name . "?" . http_build_query($option, 'a', '&');

    $response = json_decode(file_get_contents($url));

    $posts = $response->graphql->user->edge_owner_to_timeline_media->edges;
    $data = array();
    foreach ($posts as $index => $post) {

        $timestamp = $post->node->taken_at_timestamp;
        $date = date('M d', $timestamp);

        $insta = [
            'id' => $post->node->id,
            'type' => 'Instagram',
            'text' => $post->node->edge_media_to_caption->edges[0]->node->text,
            'image' => $post->node->display_url,
            'data' => $post->node->shortcode,
            'date' => $date,
        ];

        $data[$index] = $insta;

        if ($index >= $count-1) {
            break;
        }

    }

   return $data;





}




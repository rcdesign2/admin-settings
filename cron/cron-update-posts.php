<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-27
 * Time: 11:50
 */

if ( ! wp_next_scheduled( 'rc_social_cron' ) ) {
    wp_schedule_event( time(), 'hourly', 'rc_social_cron' );
}

add_action( 'rc_social_cron', 'Update_rc_social_posts' );


//Update_rc_social_posts();
/*
 * This function will be used to update posts based on their types, we will not delete posts, just update them.
 */
function Update_rc_social_posts()
{

    $instagram_url = get_option('rc-custom-data');
    $insta_post_count = get_option('rc-insta-count');

    $data = Instagram_Feed($instagram_url,$insta_post_count);


    $id = "";

    for ($i = 1; $i <= sizeof($data); $i++) {
        $post = $data[$i - 1];
        if (post_exists($post['type'] . $i) == 0) {

            $id = wp_insert_post(array(
                'post_title' => $post['type'] . $i,
                'post_type' => 'rc_social_post',
                'post_content' => $post['text'],
                'post_status' => 'publish'
            ));
        } else {
            $id = get_page_by_title($post['type'] . $i, OBJECT, 'rc_social_post')->ID;
            //wp_mail('123@this.that','should not be making a post','1');
        }

       // update_field('social_platform', $post['type'], $id);
        update_field('rc_social_data', $post['data'], $id);
        update_field('rc_social_content', $post['text'], $id);
//        update_field('social_post_date', $post['date'], $id);


        if (isset($post['image'])) {
            $attach_id = get_image_attach_id($post['type'], $post['image'], $post['id'], $post['text']);
            update_field('rc_social_image', $attach_id, $id);
        }


    }


}



/*
 * When given a url, this will upload an image to the media gallery and return the attachment ID
 */
function get_image_attach_id($platform, $filename, $id, $text = "")
{


    $url = $filename;
    $title = $platform . "Image" . $id;
    $alt_text = $text;

    /*
     * We are checking for attachments by title, and returning the ID if found
     */
    global $wpdb;
    $title_exists = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT ID FROM $wpdb->posts 
        WHERE post_title = '$title' 
        AND post_type = 'attachment'",
            $title
        )
    );

    if (isset($title_exists[0])) {
        return $title_exists[0];
    }


    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

// sideload the image --- requires the files above to work correctly
    $src = media_sideload_image($url, null, null, 'src');
// convert the url to image id
    $image_id = attachment_url_to_postid($src);

    if ($image_id) {

        // make sure the post exists
        $image = get_post($image_id);

        if ($image) {

//             Add title to image
            wp_update_post(array(
                'ID' => $image->ID,
                'post_title' => $title,
            ));

//             Add Alt text to image
            update_post_meta($image->ID, '_wp_attachment_image_alt', $alt_text);
        }
    }
    return $image_id;
}
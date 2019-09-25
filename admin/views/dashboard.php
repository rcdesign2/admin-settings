<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-28
 * Time: 10:43
 */

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets()
{
    global $wp_meta_boxes;

    wp_add_dashboard_widget('rc_social_dashboard_info', 'RC Social Posts', 'rc_social_dashboard_info');
}

function rc_social_dashboard_info()
{
    $instagram_url = get_option('rc-custom-data');
    $insta_post_count = get_option('rc-insta-count');

    if ($instagram_url == null) {
        ?>
        <p>You currently do not have an instagram account setup! Click
            <a href="<?php echo get_admin_url() . "options-general.php?page=rc-social-posts"; ?>">here</a> to add one.
        </p>
        <?php
    } else {
        ?>

        <p>Currently pulling <?php echo $insta_post_count; ?> instagram posts from @<?php echo $instagram_url; ?></p>
        <div>
            <p><a href="<?php echo get_admin_url() . "options-general.php?page=rc-social-posts"; ?>">View Settings</a>
            </p>
        </div>
        <form action="<?php echo admin_url( 'admin-post.php' ); ?>">
            <input type="hidden" name="action" value="update_posts">
            <?php submit_button( 'Refresh Feed', 'primary', 'refresh_rc_feed' ); ?>
        </form>
        <?php
    }

    ?>

    <?php
}
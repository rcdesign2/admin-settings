<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 2019-08-27
 * Time: 10:46
 */


?>

<div class="wrap">

    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">

        <div id="universal-message-container">
            <h3>Instagram Settings</h3>

            <div class="options">
                <p>
                    <label>What is the Instagram profile slug?</label>
                    <br />
                    <input type="text" name="rc-message"
                           value="<?php  echo esc_attr( $this->deserializer->get_value( 'rc-custom-data' ) ); ?>"/>
                </p>
                <p>
                    <label>How many posts do you want from instagram?</label>
                    <br />
                    <input type="number" name="rc-insta-count" required="required" max="10" min="0"
                           value="<?php  echo esc_attr( $this->deserializer->get_value( 'rc-insta-count' ) ); ?>"/>
                </p>

            </div><!-- #universal-message-container -->
            <?php
            wp_nonce_field( 'rc-settings-save', 'rc-custom-message' );
            submit_button();
            ?>
    </form>

</div><!-- .wrap -->
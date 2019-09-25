(function ($) {
    $(document).ready(function () {
        jQuery("#refresh_rc_feed").click(function (e) {
            e.preventDefault();
            var data = {
                'action': 'refresh_feed'
            };
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                alert('Instagram posts updated to latest');
            });
        });
    });
})(jQuery);
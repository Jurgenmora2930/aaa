jQuery(document).ready(function($) {
    $('#fbw-settings-form input').on('change', function() {
        var data = {
            action: 'fbw_save_links',
            whatsapp_link: $('input[name="whatsapp_link"]').val(),
            facebook_link: $('input[name="facebook_link"]').val(),
            instagram_link: $('input[name="instagram_link"]').val(),
            call_link: $('input[name="call_link"]').val(),
            email_link: $('input[name="email_link"]').val(),
            location_link: $('input[name="location_link"]').val(),
            tiktok_link: $('input[name="tiktok_link"]').val(),
            messenger_link: $('input[name="messenger_link"]').val(),
            telegram_link: $('input[name="telegram_link"]').val(),
            button_position: $('select[name="button_position"]').val(),
            mobile_bottom_margin: $('input[name="mobile_bottom_margin"]').val(),
            mobile_side_margin: $('input[name="mobile_side_margin"]').val(),
            desktop_bottom_margin: $('input[name="desktop_bottom_margin"]').val(),
            desktop_side_margin: $('input[name="desktop_side_margin"]').val(),
            button_color: $('input[name="button_color"]').val(),
            icon_color: $('input[name="icon_color"]').val(),
            button_hover_color: $('input[name="button_hover_color"]').val(),
            icon_hover_color: $('input[name="icon_hover_color"]').val(),
        };

        $.post(ajaxurl, data, function(response) {
            if(response.success) {
                $('#success-message').show();
            }
        });
    });
});

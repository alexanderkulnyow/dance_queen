jQuery(document).ready(function ($) {
    function update_date() {
        var data = {
            action: 'update_date',
        };
        jQuery.post(myPlugin.ajaxurl, data, function (response) {
            alert('Получено с сервера: ' + response);
        });
    }

    jQuery('#queen_update_date_button').on('cilck', function () {

        console.log('hw')

    });
});


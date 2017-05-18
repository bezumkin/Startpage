define(['app', 'autocomplete'], function (App, Autocomplete) {
    'use strict';
    jQuery = $;

    App.Weather = {

        init: function (city) {
            $(document).on('click', '#city-trigger', function () {
                App.Weather.open();
            });

            $(document).on('reset', '#city-form', function () {
                App.Weather.close();
            });

            $(document).on('click', '#weather-update', function () {
                App.Weather.update();
            });

            setInterval(function () {
                App.Weather.update();
            }, 600000);

            this.update(city)
        },

        open: function () {
            $('.weather-wrapper').addClass('hidden');
            $('#city-form').removeClass('hidden').find('input').focus();
            Autocomplete({Url: App.action_url + '?action=weather/search'}, "#city-form-input");
        },

        close: function () {
            $('#city-form').addClass('hidden');
            $('.weather-wrapper').removeClass('hidden');
        },

        update: function (city) {
            var $update = $('#weather-update');
            if (_.isEmpty(city)) {
                city = $update.data('id');
            }
            if (!$update.hasClass('fa-spin')) {
                $update.addClass('fa-spin');
                $.post(App.action_url, {action: 'weather/update', city: city}, function (res) {
                    $update.removeClass('fa-spin');
                    if (!_.isEmpty(res.object.content)) {
                        $('#weather').html(res.object.content);
                    }
                }, 'json');
            }
        },

        formCallback: function (object) {
            if (!_.isEmpty(object.content)) {
                $('#weather').html(object.content);
            }
        }
    };
});
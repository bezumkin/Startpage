define(['app'], function (App) {
    'use strict';
    jQuery = $;

    App.Search = {
        init: function (crawler) {
            this.$wrapper = $('#search');
            this.$crawlers = this.$wrapper.find('.dropdown-menu');
            this.$trigger = $('#dropdown-trigger');

            this.$form = $('#search-form');
            this.$input = this.$form.find('.search');
            this.$submit = this.$form.find('[type="submit"]');
            this.$reset = this.$form.find('[type="reset"]');

            $(document).on('click', '#search .dropdown-item', function () {
                App.Search.select($(this).attr('id').replace('search-', ''), true);
            });

            var $this = this;
            this.$input.on('keyup', function () {
                var length = $(this).val().length;
                if (length) {
                    $this.$reset.removeClass('hidden');
                    $this.$submit.removeClass('alone');
                } else {
                    $this.$reset.addClass('hidden');
                    $this.$submit.addClass('alone');
                }
            }).focus();

            this.$form.on('submit', function () {
                if (!navigator.userAgent.match(/(iPod|iPhone|iPad)/i)) {
                    setTimeout(function () {
                        $this.$form.trigger('reset');
                    }, 10);
                }
            }).on('reset', function () {
                $this.$reset.addClass('hidden');
                $this.$submit.addClass('alone');
            });

            if (crawler != undefined) {
                this.select(crawler);
            }
        },

        select: function (crawler, save) {
            var $crawler = $('#search-' + crawler);
            this.$form.attr('action', $crawler.data('url'));
            this.$form.find('input').attr('name', $crawler.data('q')).focus();
            this.$trigger.html($crawler.html().trim());

            this.$crawlers.find('.hidden').removeClass('hidden');
            $crawler.addClass('hidden');

            if (save != undefined) {
                $.post(App.action_url, {action: 'search/select', crawler: crawler}, null, 'json');
            }
        },
    };
});
define(['app', 'sortable', 'autocomplete'], function (App, Sortable, Autocomplete) {
    'use strict';
    jQuery = $;

    App.Links = {
        init: function () {
            $(document).on('click', '.link-header span', function () {
                var $this = $(this);
                var $link = $this.parents('.link');
                var id = $link.data('id');
                if ($this.hasClass('remove')) {
                    App.Links.remove(id);
                } else {
                    App.Links.update(id);
                }
            });

            App.Router.route('add', 'add', function () {
                App.Links.add();
            });

            $('#links').on('sortupdate', function (e) {
                var from = e.detail.oldindex;
                var to = e.detail.index;
                var id = $(e.detail.item).data('id');

                $.post(App.action_url, {action: 'link/sort', from: from, to: to, id: id}, 'json');
            });

            this.sortable();
        },

        add: function () {
            App.Modal.load('link/get', {}, function () {
                Autocomplete({
                    Url: App.action_url + '?action=link/search',
                    _Cache: function () {
                        return undefined;
                    }
                }, "#new-link-form-input");
            });
        },

        update: function (id) {
            var $link = $('#link-' + id);
            $link.addClass('loading');
            $.ajax(App.action_url, {
                method: 'post',
                data: {action: 'link/update', id: id},
                dataType: 'json',
                success: function (res) {
                    if (!_.isEmpty(res.object['content'])) {
                        $link.replaceWith(res.object['content']);
                    }
                },
                error: function (res) {
                    res = res.responseJSON;
                    if (!_.isEmpty(res.message)) {
                        App.Message.failure(res.message);
                    }
                    $link.removeClass('loading');
                },
            });
        },

        remove: function (id) {
            var $link = $('#link-' + id);
            $.post(App.action_url, {action: 'link/remove', id: id}, function (res) {
                $link.remove();
            }, 'json');
        },

        sortable: function() {
            Sortable('#links', {
                items: ':not(#new-link)',
                placeholderClass: 'link placeholder'
            });
        },

        formCallback: function (data) {
            App.Modal.hide();
            if (!_.isEmpty(data.content)) {
                var $link = $(data['content']);
                $link.insertBefore($('#new-link'));
                if (!$link.find('.link-image img').length) {
                    App.Links.update(data['id']);
                }
                App.Links.sortable();
            }
        }
    };

    App.Links.init();
});
var ENTER_KEY = 13;

define('app', ['jquery', 'backbone', 'alertify', 'autocomplete', 'bootstrap', 'backbone_syphon'], function ($, Backbone, alertify, Autocomplete) {
    'use strict';
    jQuery = $;

    var App = {
        action_url: '/assets/components/startpage/action.php',

        init: function () {
            $.ajaxSetup({
                error: function (res) {
                    var data = res.responseJSON;
                    if (data.message !== '') {
                        App.Message.failure(data.message);
                    }
                }

            });
            alertify.defaults.maintainFocus = false;

            // Autocomplete
            Autocomplete.defaults.EmptyMessage = '';
            Autocomplete.defaults.HttpMethod = 'POST';
            Autocomplete.defaults.QueryArg = 'search';
            Autocomplete.defaults.MinChars = 2;
            Autocomplete.defaults._Post = function (response) {
                try {
                    var returnResponse = [];
                    var json = JSON.parse(response);
                    if (Object.keys(json).length === 0) {
                        return '';
                    }
                    for (var i = 0; i < Object.keys(json.object).length; i++) {
                        returnResponse[returnResponse.length] = {
                            "Value": json.object[i],
                            "Label": this._Highlight(json.object[i])
                        };
                    }
                    return returnResponse;
                }
                catch (event) {
                    return response;
                }
            };
            Autocomplete.defaults._Select = function (item) {
                if (item.hasAttribute("data-autocomplete-value")) {
                    this.Input.value = item.getAttribute("data-autocomplete-value");
                }
                else {
                    this.Input.value = item.innerHTML;
                }
                this.Input.setAttribute("data-autocomplete-old-value", this.Input.value);
                $(this.Input).parents('form').submit();
            };
            Autocomplete.defaults.KeyboardMappings.Enter.Callback = function (e) {
                if (this.DOMResults.getAttribute("class").indexOf("open") != -1) {
                    var liActive = this.DOMResults.querySelector("li.active");
                    if (liActive !== null) {
                        e.preventDefault();
                        this._Select(liActive);
                        this.DOMResults.setAttribute("class", "autocomplete");
                    }
                }
            };
            Autocomplete.defaults.KeyboardMappings.Enter.Event = 0;

            // Router
            var Router = Backbone.Router.extend({
                routes: {
                    'profile': 'profile',
                },

                profile: function () {
                    App.Modal.load('profile/get', {}, function() {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                },

                clear: function () {
                    if (!this.old_browser) {
                        history.replaceState({}, '', window.location.href.replace(/#.*$/, ''));
                    }
                    App.Router.navigate('');
                },
            });
            App.Router = new Router();
            $(document).on('ready', function () {
                Backbone.history.start({root: document.location.pathname});
            });

            // Modal
            App.$modal = $('#modal');
            $(document).on('hide.bs.modal', function () {
                App.Router.clear();
            });
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('input:visible:first').focus();
            });

            // Forms
            $(document).on('submit', 'form', function (e) {
                var $form = $(this);
                if ($form.hasClass('external')) {
                    return;
                }
                e.preventDefault();
                var data = Backbone.Syphon.serialize($form);
                data.action = $form.attr('action');
                $form.find('input, button').attr('disabled', true);
                $.ajax(App.action_url, {
                    method: 'post',
                    data: data,
                    dataType: 'json',
                    success: function (res) {
                        if (res.success && !_.isEmpty(res.message)) {
                            App.Message.success(res.message);
                        }
                        if (!_.isEmpty(res.object['callback'])) {
                            var path = res.object['callback'].split('.');
                            var callback = App;
                            for (var i = 0; i < path.length; i++) {
                                if (callback[path[i]] == undefined) {
                                    return false;
                                }
                                callback = callback[path[i]];
                            }
                            callback(res.object);
                        }
                        $form.find('input, button').attr('disabled', false);
                    },
                    error: function (res) {
                        res = res.responseJSON;
                        if (!_.isEmpty(res.message)) {
                            App.Message.failure(res.message);
                        }
                        $form.find('input, button').attr('disabled', false);
                        $form.find('input:visible:first').focus();
                    },
                });
            });

            $('[data-toggle="tooltip"]').tooltip();
        },

        Modal: {
            load: function (action, data, callback) {
                if (_.isEmpty(data)) {
                    data = {};
                }
                data.action = action;
                $.ajax(App.action_url, {
                    method: 'post',
                    data: data,
                    dataType: 'json',
                    success: function (res) {
                        App.$modal.find('#modal-title')
                            .text(!_.isEmpty(res.object['title']) ? res.object['title'] : '');
                        App.$modal.find('#modal-body')
                            .html(!_.isEmpty(res.object['content']) ? res.object['content'] : '');
                        if (_.isFunction(callback)) {
                            //callback(res);
                            App.$modal.one('shown.bs.modal', function () {
                                callback(res)
                            });
                        }
                        App.Modal.show();
                    },
                    error: function (res) {
                        res = res.responseJSON;
                        if (!_.isEmpty(res.message)) {
                            App.Message.failure(res.message);
                        }
                        App.Router.clear();
                    },
                });
            },
            show: function () {
                if (!App.$modal.hasClass('show')) {
                    App.$modal.modal('show');
                }
            },
            hide: function () {
                if (App.$modal.hasClass('show')) {
                    App.$modal.modal('hide');
                }
            }
        },

        Message: {
            success: function (message, delay) {
                if (message !== '') {
                    alertify.notify(message, 'success', delay || 5);
                }
            },

            failure: function (message, delay) {
                if (message !== '') {
                    alertify.notify(message, 'failure', delay || 5);
                }
            },

            info: function (message, delay) {
                if (message !== '') {
                    alertify.notify(message, 'info', delay || 5);
                }
            },

            close: function () {
                alertify.dismissAll();
            },

            alert: function (message, ok) {
                alertify.alert(message).set({
                    transition: 'fade',
                    closable: false,
                    movable: false,
                    pinnable: false,
                    modal: true,
                    onok: ok,
                    labels: {
                        ok: 'OK',
                    }
                }).setHeader('');

                $('.ajs-ok').addClass('btn btn-primary');
            },

            confirm: function (message, ok, cancel) {
                alertify.confirm(message).set({
                    transition: 'fade',
                    closable: false,
                    movable: false,
                    pinnable: false,
                    modal: true,
                    onok: ok,
                    oncancel: cancel,
                    onclose: function () {
                        App.Router.clear();
                    },
                    labels: {
                        ok: 'OK',
                        cancel: $('meta[name="page-context"]').attr('content') === 'web'
                            ? 'Отмена'
                            : 'Cancel',
                    },
                }).setHeader('');
                $('.ajs-ok').addClass('btn btn-primary');
                $('.ajs-cancel').addClass('btn btn-secondary');
            },
        },

        Profile: {
            callback: function (object) {
                if (!_.isEmpty(object.content)) {
                    $('header').find('.hybridauth').html(object.content);
                }
            }
        }
    };
    App.init();

    requirejs(['app/links', 'app/counters'], function () {
        $(document).trigger('ready');
    });

    return App;
});
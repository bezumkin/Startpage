requirejs.config({
    baseUrl: '/assets/components/startpage/js/web/',
    //urlArgs: 'time=' + (new Date()).getTime(),
    urlArgs: 'v=' + document.head.querySelector('meta[name="assets-version"]').content,
    waitSeconds: 30,
    paths: {
        jquery: 'lib/jquery.min',
        bootstrap: 'lib/bootstrap.min',
        tether: 'lib/tether.req',
        backbone: 'lib/backbone.min',
        backbone_syphon: 'lib/backbone.syphon.min',
        underscore: 'lib/underscore.min',
        alertify: 'lib/alertify.min',
        cookies: 'lib/js.cookie.min',
        sortable: 'lib/html.sortable.min',
        autocomplete: 'lib/autocomplete.min',
        select2: 'lib/select2.min',
    },
    shim: {
        bootstrap: {
            deps: ['jquery', 'tether']
        },
        backbone: {
            deps: ['underscore', 'jquery'],
            exports: 'Backbone'
        },
        app: {
            deps: ['jquery', 'backbone', 'alertify', 'bootstrap', 'backbone_syphon'],
            exports: 'App'
        },
    }
});

requirejs.onError = function (err) {
    if (err.requireType === 'timeout') {
        if (typeof App === 'object') {
            App.utils.Message.alert('Could not load javascript. Try to reload page.', function () {
                document.location.reload();
            })
        } else {
            alert('Could not load javascript. Try to reload page.');
            console.log(err);
        }
    } else {
        throw err;
    }
};
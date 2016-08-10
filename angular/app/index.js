var config = process.env.CONFIG;

if (config.config.env === 'dev') {
    var req = require.context('../config/', false, /\.json$/);

    var localConfig = {};

    if (req.keys().indexOf('./config.' + config.config.env + '.json') > -1) {
        localConfig = req('./config.' + config.config.env + '.json');
    }

    angular.merge(
            config,
            req('./config.json'),
            localConfig
            );
}

var app = angular.module('app', config.app.module)
        .provider('App', require('./app'))
        .config(['AppProvider', function (AppProvider) {
                AppProvider.config = config.config
            }])
        .run(['$rootScope', 'App', function ($rootScope, App) {
                $rootScope.App = App
            }]);

var type, name;

for (type in config.app) {
    if (!config.app.hasOwnProperty(type))
        continue;

    var items = config.app[type];

    switch (type) {
        case 'controller':
            for (name in items) {
                items.hasOwnProperty(name) && app.controller(name, require('./controllers/' + items[name]));
            }
            break;

        case 'directive':
            for (name in items) {
                items.hasOwnProperty(name) && app.directive(name, require('./directives/' + items[name]));
            }
            break;

        case 'component':
            for (name in items) {
                items.hasOwnProperty(name) && app.component(name, require('./components/' + items[name]));
            }
            break;

        case 'provider':
            for (name in items) {
                items.hasOwnProperty(name) && app.provider(name, require('./services/' + items[name]));
            }
            break;

        case 'service':
            for (name in items) {
                items.hasOwnProperty(name) && app.service(name, require('./services/' + items[name]));
            }
            break;

        case 'factory':
            for (name in items) {
                items.hasOwnProperty(name) && app.factory(name, require('./factories/' + items[name]));
            }
            break;

        case 'model':
            for (name in items) {
                items.hasOwnProperty(name) && app.factory(name, require('./models/' + items[name]));
            }
            break;

        case 'filter':
            for (name in items) {
                items.hasOwnProperty(name) && app.filter(name, require('./filters/' + items[name]));
            }
            break;

        case 'validator':
            for (name in items) {
                items.hasOwnProperty(name) && app.directive(name, require('./validators/' + items[name]));
            }
            break;

        case 'config':
            for (name = 0; name < items.length; name++) {
                app.config(require('./config/' + items[name]));
            }
            break;

        case 'run':
            for (name = 0; name < items.length; name++) {
                app.run(require('./config/' + items[name]));
            }
            break;

        case 'custom':
            for (name = 0; name < items.length; name++) {
                require('./custom/' + items[name]);
            }
            break;
    }
}

angular.bootstrap(document, ['app']);

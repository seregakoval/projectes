module.exports = Country;

Country.$inject = ['$resource', 'App', 'Request'];

function Country($resource, App, Request) {
    var model = $resource(App.config.apiUrl + 'countries/:id/:action/:action_id/:subaction', {
        id: '@id', action: '@action', action_id: '@action_id', subaction: '@subaction',
    }, {});

    return model;

}
module.exports = CourseLevel;

CourseLevel.$inject = ['$resource', 'App', 'Request'];

function CourseLevel($resource, App, Request) {
    var model = $resource(App.config.apiUrl + 'course-levels/:id/:action/:action_id/:subaction', {
        id: '@id', action: '@action', action_id: '@action_id', subaction: '@subaction',
    }, { });

    return model;

}
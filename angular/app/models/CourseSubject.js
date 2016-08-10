module.exports = CourseSubject;

CourseSubject.$inject = ['$resource', 'App', 'Request'];

function CourseSubject($resource, App, Request) {
    var model = $resource(App.config.apiUrl + 'course-subjects/:id/:action/:action_id/:subaction', {
        id: '@id', action: '@action', action_id: '@action_id', subaction: '@subaction',
    }, {});

    return model;

}
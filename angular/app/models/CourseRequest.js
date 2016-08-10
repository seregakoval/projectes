module.exports = CourseRequest;

CourseRequest.$inject = ['$resource', 'App', 'Request'];

function CourseRequest($resource, App, Request) {
    var model = $resource(App.config.apiUrl + 'course-request/:id/:action/:action_id/:subaction', {
        id: '@id', action: '@action', action_id: '@action_id', subaction: '@subaction',
    }, {
        //create/update
        save: {
            method: 'POST',
            isArray: false,
            responseType: 'json',
            transformRequest: Request.transformRequestToFormData, //file upload
            headers: {'Content-Type': undefined}, //file upload            
        },
    });

    return model;

}
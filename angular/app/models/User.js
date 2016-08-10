module.exports = User;

User.$inject = ['$resource', 'App', 'Request'];

function User($resource, App, Request) {
    var model = $resource(App.config.apiUrl + 'users/:id/:action/:action_id/:subaction', {
        id: '@id', action: '@action', action_id: '@action_id', subaction: '@subaction',
    }, {
        register: {
            method: 'POST',
        },
        login: {
            method: 'POST',
            params: {action: "login"},
        },
        forgot: {
            method: 'POST',
            params: {action: "forgot"},
        },
        current: {
            method: 'GET',
            params: {action: "current"},
        },
        //users/verify-email
        verifyEmail: {
            method: 'POST',
            params: {action: "verify-email"},
        },
        getProfile: {
            params: {action: "profile"},
        },
        updateProfile: {
            method: 'POST',
            params: {action: "profile"},
            isArray: false,
            responseType: 'json',
            transformRequest: Request.transformRequestToFormData, //file upload
            headers: {'Content-Type': undefined}, //file upload            
        },
        //POST /rest/v1/disconnect-social - remove binded social, {"type":}
        removeSocial: {
            method: 'POST',
            params: {action: "disconnect-social"},
            isArray: false,
            responseType: 'json',
        },
    });

    return model;

}
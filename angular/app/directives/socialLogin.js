module.exports = socialLogin;

socialLogin.$inject = ['$auth', 'UserLogin', 'ToasterError'];

function socialLogin($auth, UserLogin, ToasterError) {
    return {
        restrict: 'A',
        scope: {
            group: '=',
            callback: '&',
            type: '@', //facebook/twitter/linkedin
        },
        link: function (scope, element, attrs) {
            element.bind('click', function () {
                $auth.authenticate(scope.type, {'group': scope.group})
                        .then(function (data) {
                            UserLogin.setUser().then(function (data) {
                                scope.callback({data: data});
                            });
                        })
                        .catch(function (data) {
                            // Something went wrong. what to do?
                            //console.log(data, 'WRONG FB login');
                            ToasterError.showError(data);
                        });

            });
        },
    }
}

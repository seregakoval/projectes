module.exports = logout;

logout.$inject = ['Acl', '$state','$auth'];

function logout(Acl, $state, $auth) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            element.bind('click', function () {
                Acl.logout();//remove usr info
                $auth.logout();//remove token
                $state.transitionTo('root.home', {}, {
                    reload: true,
                    inherit: false,
                    notify: true
                });
            });
        },
    }
}

module.exports = Login;

Login.$inject = ['$auth', '$state', 'Validator', '$auth', 'UserLogin', 'ToasterError', 'toaster'];

function Login($auth, $state, Validator, $auth, UserLogin, ToasterError, toaster) {
    var vm = this;

    vm.errors = {};
    vm.model = {};
    vm.login = function (myForm) {
        Validator.clearFormServerErrors(myForm, vm.errors);
        vm.errors = {};
        if (!myForm.$invalid) {
            vm.loading = true;
            $auth.login(vm.model).then(function (data) {
                UserLogin.setUser().then(function (data) {
                    vm.loading = false;
                    $state.go('root.course.list');
                }, function (data) {
                    vm.loading = false;
                    ToasterError.showError(data);
                });
            }, function (data) {
                vm.loading = false;
                ToasterError.showError(data);
                vm.errors = Validator.setFormServerErrors(myForm, data);
            });
        }
    }


    vm.socialCallback = function (data) {
        $state.go('root.course.list');
    }

}

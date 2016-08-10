module.exports = RegisterConfirm;

RegisterConfirm.$inject = ['User', '$stateParams', '$state', '$timeout', '$auth', 'UserLogin'];

function RegisterConfirm(User, $stateParams, $state, $timeout, $auth, UserLogin) {
    var vm = this;

    vm.message = "";
    //to do:cg-busy?
    vm.userPromise = User.verifyEmail({'token': $stateParams.token}, function (data) {
        $auth.setToken(data.accessToken.token);
        UserLogin.setUser().then(function (data) {
            //console.log(data, 'UserLogin');
            vm.message = "Registration complete. Thank you for taking time to register.We hope you will enjoy our Community."
            $timeout(function () {
                $state.go('root.profile');
            }, 4000);
        });

    }, function (data) {
        //console.log(data);
        vm.message = data.data[0];//!!! Bad error handle!
    });

}

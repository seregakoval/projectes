module.exports = Register;

Register.$inject = ['User', 'Validator', '$state', 'toaster'];

function Register(User, Validator, $state, toaster) {
    var vm = this;


    vm.groups = [
        {
            'key': "student",
            'value': "I am a student",
        },
        {
            'key': "instructor",
            'value': "I am an instructor",
        }
    ];


    vm.errors = {};
    vm.model = {};
    vm.register = function (myForm) {
        Validator.clearFormServerErrors(myForm, vm.errors);
        vm.errors = {};
        if (!myForm.$invalid) {
            vm.loading = true;
            User.register(vm.model, function (data) {
                vm.loading = false;
                toaster.pop('success', 'Registration Successful!', 'Please, check your mailbox for confirmation.');
                $state.go('root.auth.register_complete');
            }, function (data) {
                vm.loading = false;
                vm.errors = Validator.setFormServerErrors(myForm, data);
            });
        }
    }

    vm.socialCallback = function (data) {
        $state.go('root.profile');
    }
}

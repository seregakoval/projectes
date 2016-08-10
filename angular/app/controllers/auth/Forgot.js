module.exports = Forgot;

Forgot.$inject = ['User', 'Validator'];

function Forgot(User, Validator) {
    var vm = this;

    vm.errors = {};
    vm.model = {};
    vm.forgot = function (myForm) {
        Validator.clearFormServerErrors(myForm, vm.errors);
        vm.errors = {};
        if (!myForm.$invalid) {
            vm.loading = true;
            User.forgot(vm.model, function (data) {
                vm.loading = false;
                //toaster.pop('success', 'Registration Successful!', 'Please, check your mailbox for confirmation.');              
            }, function (data) {
                vm.loading = false;
                vm.errors = Validator.setFormServerErrors(myForm, data);
            });
        }
    }

    vm.socialCallback = function (data) {
        console.log(data);
    }
}

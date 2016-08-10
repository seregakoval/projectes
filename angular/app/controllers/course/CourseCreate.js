module.exports = CourseCreate;

CourseCreate.$inject = ['CourseRequest', 'promiseLevels', 'Validator', 'ToasterError', '$state'];

function CourseCreate(CourseRequest, promiseLevels, Validator, ToasterError, $state) {
    var vm = this;
    vm.model = {}
    vm.errors = {};
    vm.tags = [];

    vm.levels = promiseLevels;

    vm.save = function (myForm) {
        Validator.clearFormServerErrors(myForm, vm.errors);
        vm.errors = {};
        if (!myForm.$invalid) {
            vm.loading = true;
            vm.model.tags = vm.tags.map(function (tag) {
                return tag.text;
            });
            CourseRequest.save(vm.model, function (data) {
                vm.loading = false;
                $state.go('root.course.created');
            }, function (data) {
                vm.loading = false;
                ToasterError.showError(data);
                vm.errors = Validator.setFormServerErrors(myForm, data);
            });
        } else {
            Validator.showFirstError();
        }
    }
}

module.exports = Profile;

Profile.$inject = ['User', 'Validator', 'promiseProfile', 'ToasterError', 'toaster', 'promiseCourseSubjects', 'promiseCountries', 'Acl', '$auth'];

function Profile(User, Validator, promiseProfile, ToasterError, toaster, promiseCourseSubjects, promiseCountries, Acl, $auth) {
    var vm = this;
    vm.model = promiseProfile.toJSON();
    vm.countries = promiseCountries;
    vm.courseSubjects = promiseCourseSubjects;


    vm.social = {
        'twitter': false,
        'facebook': false,
        'linkedin': false,
    }
    //social profiles
    angular.forEach(vm.model.profiles, function (profile) {
        vm.social[profile.network] = true;//if exist - set true
    })

    vm.toggleConnect = function (type) {
        if (vm.social[type]) {
            //if connected->disconnect
            User.removeSocial({type: type}, function (data) {
                vm.social[type] = false;
            }, function (data) {
                ToasterError.showError(data);// Something went wrong
            })
        } else {
            //connect
            $auth.authenticate(type)
                    .then(function (data) {
                        vm.social[type] = true;
                    })
                    .catch(function (data) {
                        ToasterError.showError(data);// Something went wrong
                    });


        }
    }

    vm.errors = {};

    vm.save = function (myForm) {
        Validator.clearFormServerErrors(myForm, vm.errors);
        vm.errors = {};
        if (!myForm.$invalid) {
            vm.loading = true;
            angular.extend(vm.model, vm.model.location);//location in push and get are different:(
            delete vm.model.id;
            User.updateProfile(vm.model, function (data) {
                vm.loading = false;
                toaster.pop('success', 'Success!', 'Thank you, changes to your profile have been saved.');
                //update acl!
                Acl.user.avatar_url = data.avatar_url;
                Acl.user.firstname = data.firstname;
                Acl.user.lastname = data.lastname;
                Acl.update();


            }, function (data) {
                vm.loading = false;
                ToasterError.showError(data);
                vm.errors = Validator.setFormServerErrors(myForm, data);
            });
        } else {
            Validator.showFirstError();
        }
    }

    vm.socialCallback = function (data) {
        console.log(data);
    }

}

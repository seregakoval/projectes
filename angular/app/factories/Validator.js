module.exports = Validator;

Validator.$inject = [];

function Validator() {
    return {
        setFormServerErrors: function (myForm, data) {
            var errors = {};
            angular.forEach(data.data, function (error) {
                if (myForm[error.field]) {
                    //if ng-formm error
                    if (typeof (myForm[error.field][error.field]) != 'undefined') {
                        //console.log('set ng-form error');
                        myForm[error.field][error.field].$setValidity("server", false);
                    } else {
                        myForm[error.field].$setValidity("server", false); //simple form error
                    }
                }
                errors[error.field] = error.message;
            })
            return errors;
        },
        clearFormServerErrors: function (validationForm) {
            angular.forEach(validationForm, function (key) {
                if (typeof (key) == "object") {
                    if (key.$name) {
                        validationForm[key.$name].$setValidity("server", true);
                        if (validationForm[key.$name][key.$name]) {//for ng-form
                            validationForm[key.$name][key.$name].$setValidity("server", true);
                        }
                    }
                }
            })
        },
        showFirstError: function () {            
            var header = angular.element("nav");
            var offset = header[0].offsetHeight+10;
            //nav height 60
            $('html,body').animate({
                scrollTop: angular.element(".ng-invalid").not("form.ng-invalid").first().parent().offset().top -offset
            }, 650);
        }
    };
}

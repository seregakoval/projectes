module.exports = avatarInput;

avatarInput.$inject = [];

function avatarInput() {
    return {
        scope: {
            model: '=', //avatar
            view: '=', //avatar_url
            submitted: '<', //one way binding
            error: '=',
            name: '@',
            placeholder: '@',
        },
        link: function (scope, element, attributes) {
            scope.info = 'Please press "Save" button in order to apply changes.';
            element.bind("change", function (changeEvent) {
                var file = changeEvent.target.files[0];
                if (file.type != 'image/jpeg' && file.type != 'image/png' && file.type != 'image/gif') {
                    scope.$apply(function (scope) {
                        scope.error = "Please select image";
                        scope[scope.name][scope.name].$setValidity("server", false);
                    });
                } else {
                    scope.$apply(function (scope) {
                        scope.loading = true;
                        scope.error = '';
                        scope[scope.name][scope.name].$setValidity("server", true);
                        scope.model = file;
                    });
                    var reader = new FileReader();
                    reader.onload = function (evt) {
                        scope.$apply(function (scope) {
                            scope.view = evt.target.result;
                            scope.edited = true;
                            scope.loading = false;

                        });
                    };
                    reader.readAsDataURL(file);
                }
            });



            scope.removeFile = function (name) {
                scope.model.forEach(function (file) {
                    if (file.name == name) {
                        scope.model.splice(scope.model.indexOf(file), 1);
                    }
                });
            }
        },
        template: [
            '<ng-form name="{{name}}">',
            '<div class="photo"  ng-class="{\'has-error\':  {{name}}[name].$invalid}">',
            '    <label>',
            '        <input type="file" name="{{name}}"  ng-model="temp">',
            '        <div class="photo_img">',
            '            <img ng-src="{{view||\'../web/img/avatar.jpg\'}}" alt="">',
            '        </div>',
            '    </label>',
            '</div>',
            '<span class="help-block" ng-show="error">{{error}}</span>',
            '<span class="help-block" ng-show="edited && !submitted && !loading">{{info}}</span>',
            '<span ng-show="loading"><i class="fa fa-spinner fa-spin"></i> loading...</span>',
            '</ng-form>',
        ].join('')
    }
}



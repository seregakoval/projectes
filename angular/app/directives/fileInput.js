module.exports = fileInput;

fileInput.$inject = [];

function fileInput() {
    return {
        scope: {
            model: '=', //image
            view: '=', //image_url
            submitted: '<', //one way binding
            error: '=',
            name: '@',
            placeholder: '@',
            preview: '<', //true/false
            class: '@',
            wrapperClass: '@',
            label: '@',
            type: '@', //image/txt/zip
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var file = changeEvent.target.files[0];

                if (scope.type == 'image' && (file.type != 'image/jpeg' && file.type != 'image/png' && file.type != 'image/gif')) {
                    scope.$apply(function (scope) {
                        scope.error = "Please select image";
                        scope[scope.name][scope.name].$setValidity("server", false);
                    });
                } else if (scope.type == 'txt' && (file.type != 'text/plain')) {

                    scope.$apply(function (scope) {
                        scope.error = "Please select text file";
                        scope[scope.name][scope.name].$setValidity("server", false);
                    });

                } else if (scope.type == 'zip' && (file.type != 'application/zip')) {
                    scope.$apply(function (scope) {
                        scope.error = "Please select zip file";
                        scope[scope.name][scope.name].$setValidity("server", false);
                    });

                } else {
                    scope.$apply(function (scope) {
                        if (scope.preview) {
                            scope.loading = true;
                        }
                        scope.error = '';
                        scope[scope.name][scope.name].$setValidity("server", true);
                        scope.model = file;                      
                    });
                    if (scope.preview) {
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
                }
            });

            scope.removeFile = function () {
                delete scope.model;
                delete scope.view;
            }
        },
        template: [
            '<ng-form name="{{name}}">',
            '<div class="form-group"  ng-class="{\'has-error\':  {{name}}[name].$invalid}">',
            '    <div class="{{wrapperClass}}">',
            '        <label class="{{class}}">{{label}}',
            '           <input type="file" name="{{name}}"  ng-model="temp">',
            '           <div class="photo_img" ng-show="preview && view">',
            '               <img ng-src="{{view}}" alt="">',
            '            </div>',
            '       </label>',
            '    </div>',
            '</div>',           
            '    <div class="upload-file" ng-if="model.name">',
            '        <i class="fa fa-check" aria-hidden="true"></i>',
            '        <span class="name">{{model.name}}</span>',
            '        <button type="button" name="button" class="close" ng-click="removeFile()">',
            '            <i class="ion-close-round" aria-hidden="true"></i>',
            '        </button>',
            '    </div>',
            
            '<span class="help-block" ng-show="error">{{error}}</span>',
            '<span ng-show="loading"><i class="fa fa-spinner fa-spin"></i> loading...</span>',
            '</ng-form>',
        ].join('')
    }
}



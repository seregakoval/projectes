module.exports = dragDropInput;

dragDropInput.$inject = [];

function dragDropInput() {
    return {
        scope: {
            model: '=', //file
            submitted: '<', //one way binding
            error: '=',
            name: '@',
            placeholder: '@',
            class: '@',
            wrapperClass: '@',
            label: '@',
            topLabel: '@',
        },
        link: function (scope, element, attributes) {

            element.on('dragover', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
            element.on('dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
            element.on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (e.originalEvent.dataTransfer) {
                    if (e.originalEvent.dataTransfer.files.length > 0) {
                        var file = e.originalEvent.dataTransfer.files[0];
                        scope.uploadFile(file);
                    }
                }
                return false;
            });

            scope.uploadFile = function (file) {
                if (file.type != 'application/zip') {
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
            }
            element.bind("change", function (changeEvent) {
                var file = changeEvent.target.files[0];
                scope.uploadFile(file);
            });

            scope.removeFile = function () {
                delete scope.model;
            }
        },
        template: [
            '<ng-form name="{{name}}">',
            '<div class="form-group"  ng-class="{\'has-error\':  {{name}}[name].$invalid}">',
            '   <div class="{{wrapperClass}}">',
            '       <div class="upload-form">',
            '           <img src="../img/upload.png" alt="" class="img">',
            '           <h5 class="title">{{topLabel}}</h5>',
            '           <label class="{{class}}">{{label}}',
            '               <input type="file" name="{{name}}" ng-model="temp">',
            '           </label>',
            '       </div>',
            '   </div>',
            '</div>',
            '<div class="upload-file" ng-if="model.name">',
            '   <i class="fa fa-check" aria-hidden="true"></i>',
            '   <span class="name">{{model.name}}</span>',
            '   <button type="button" name="button" class="close" ng-click="removeFile()">',
            '        <i class="ion-close-round" aria-hidden="true"></i>',
            '   </button>',
            '</div>',
            '<span class="help-block" ng-show="error">{{error}}</span>',
            '<span ng-show="loading"><i class="fa fa-spinner fa-spin"></i> loading...</span>',
            '</ng-form>',
        ].join('')
    }
}



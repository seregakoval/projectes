module.exports = {
    bindings: {
        model: '=',
        submitted: '<', //one way binding
        error: '=', //one way binding
        required: '<', //one way binding
        name: '@',
        placeholder: '@',
        label: '@',
        icon: '@',
        class: '@',
    },
    controller: function () {
    },
    //rows="3" cols="30"
    template: [
        '<ng-form name="{{$ctrl.name}}">',
        '<div class="form-group {{$ctrl.class}}" ng-class="{\'has-error\': ($ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$invalid)}">',
        '<i ng-if="$ctrl.icon" class="fa fa-{{$ctrl.icon}}" aria-hidden="true"></i>',
        '<textarea class="form-control" ng-model="$ctrl.model" name="{{$ctrl.name}}" placeholder="{{$ctrl.placeholder}}" ng-required="$ctrl.required"></textarea>',
        '<label ng-if="$ctrl.label">{{$ctrl.label}}</label>',
        '<span class="help-block" ng-show="$ctrl.error">{{$ctrl.error}}</span>',
        '<span class="help-block" ng-show="$ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$error.required">This field required</span>',
        '</div>',
        '</ng-form>',
    ].join('')
};

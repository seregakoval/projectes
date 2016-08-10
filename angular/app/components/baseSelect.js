module.exports = {
    bindings: {
        model: '=',
        submitted: '<', //one way binding
        options: '<', //one way binding
        error: '=', //one way binding
        required: '<', //one way binding
        disabled: '<',
        name: '@',
        placeholder: '@',
        label: '@',
        icon: '@',
        class: '@',
        labelField: '@'//data-label-field="label"
    },
    controller: function () {
        if (typeof (this.labelField == 'undefined')) {
            this.labelField = 'name'
        }
    },
    template: [
        '<ng-form name="{{$ctrl.name}}">',
        '<div class="form-group {{$ctrl.class}}" ng-class="{\'has-error\': ($ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$invalid)}">',
        '<label ng-if="$ctrl.label">{{$ctrl.label}}</label>',
        '<i ng-if="$ctrl.icon" class="fa fa-{{$ctrl.icon}}" aria-hidden="true"></i>',
        '<div class="select">',
        '   <select ng-model="$ctrl.model" name="{{$ctrl.name}}" ng-disabled="$ctrl.disabled" class="form-control" ng-required="$ctrl.required" ng-options="item.id as item[$ctrl.labelField] for item in $ctrl.options">',
        '       <option value="" disabled selected>{{$ctrl.placeholder}}</option>',
        '   </select>',
        '   <span class="help-block" ng-show="$ctrl.error">{{$ctrl.error}}</span>',
        '   <span class="help-block" ng-show="$ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$error.required">This field required</span>',
        '</div>',
        '</ng-form>',
    ].join('')
};


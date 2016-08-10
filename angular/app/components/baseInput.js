module.exports =  {
    bindings: {
        model: '=',
        submitted: '<', //one way binding
        error: '=',
        required: '<', //one way binding
        name: '@',
        placeholder: '@',
        label: '@',
        icon: '@',
        class: '@',
        changeCallback: '&',
        type: '@'
    },
    controller: function () {
        if (typeof (this.type == 'undefined')) {
            this.type = 'text'
        }
    },
    template: [
        '<ng-form name="{{$ctrl.name}}">',
        '   <div class="form-group {{$ctrl.class}}" ng-class="{\'has-error\': ($ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$invalid)}">', // with-icon
        '       <label ng-if="$ctrl.label">{{$ctrl.label}}</label>',
        '       <i ng-if="$ctrl.icon"  class="fa fa-{{$ctrl.icon}}" aria-hidden="true"></i>',
        '       <input ng-model="$ctrl.model" ng-change="$ctrl.changeCallback()"  name="{{$ctrl.name}}" type="{{$ctrl.type}}" class="form-control" placeholder="{{$ctrl.placeholder}}" ng-required="$ctrl.required">',
        '       <span class="help-block" ng-show="$ctrl.error">{{$ctrl.error}}</span>',
        '       <span class="help-block" ng-show="$ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$error.required">This field required</span>',
        '   </div>',
        '</ng-form>',
    ].join('')
};


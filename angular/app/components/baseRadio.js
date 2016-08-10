module.exports = {
    bindings: {
        model: '=',
        submitted: '<', //one way binding
        options: '<', //one way binding
        error: '=', //one way binding       
        disabled: '<',
        name: '@',
        label: '@',
        icon: '@',
        class: '@',
    },
    controller: function () {

        //visual limit 4 in row max
        this.countItems = this.options.length <= 4 ? Math.round(12 / this.options.length) : 3;

        if (!this.model) {
            this.model = this.options[0].key;//default value first
        }
    },
    template: [
        '<ng-form name="{{$ctrl.name}}">',
        '<div class="form-group {{$ctrl.class}}" ng-class="{\'has-error\': ($ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$invalid)}">',
        '   <label ng-if="$ctrl.label">{{$ctrl.label}}</label>',
        '   <i ng-if="$ctrl.icon" class="fa fa-{{$ctrl.icon}}" aria-hidden="true"></i>',
        '   <div class="row">',
        '        <div class="col-md-{{$ctrl.countItems}}" ng-repeat="option in $ctrl.options">',
        '            <label class="role-btn">',
        '               <input',
        '                   type="radio"',
        '                   ng-model="$ctrl.model"',
        '                   name="{{$ctrl.name}}"',
        '                   value="{{option.key}}"',
        '               >',
        '               <div class="role-btn_btn">',
        '                    <span>{{option.value}}</span>',
        '                    <i class="fa fa-check" aria-hidden="true"></i>',
        '                </div>',
        '           </label>',
        '     </div>',
        '   </div>',
        '   <span class="help-block" ng-show="$ctrl.error">{{$ctrl.error}}</span>',
        '   <span class="help-block" ng-show="$ctrl.submitted && {{$ctrl.name}}[$ctrl.name].$error.required">This field required</span>',
        '</div>',
        '</ng-form>',
    ].join('')
};



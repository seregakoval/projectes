module.exports = {
    bindings: {
        form: '<',
        submitted: '=',
        loading: '=',
        sendFunction: '&',
        label: '@',
        class: '@',
        icon: '@',
        disabled: '<',
    },
    controller: function () {
        if (typeof (this.disabled) == 'undefined') {
            this.disabled = false;
        }
    },
    template: [
        '<div class="btn-submit-block text-right">',
        '   <button ',
        '       ng-disabled="$ctrl.loading || $ctrl.disabled"',
        '       ng-click="$ctrl.sendFunction({form: $ctrl.form});', //{msg : \"Hello World!\"}
        '           $ctrl.submitted = true" ',
        '       class="{{$ctrl.class}}">',
        '     <span ng-show="$ctrl.loading"><i class="fa fa-spinner fa-spin"></i></span><i ng-show="$ctrl.icon.length>0" class="{{$ctrl.icon}}"></i> {{$ctrl.label}} ',
        '     <span class="ripples buttonRipples"><span class="ripplesCircle white"></span></span></button>',
        '</div>'
    ].join('')
};

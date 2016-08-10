module.exports = run;

run.$inject = [
    '$rootScope',
    '$state',
    '$stateParams',
    'Acl',
    '$location',
    'Scroll'
];

function run($rootScope, $state, $stateParams, Acl, $location, Scroll) {
    // It's very handy to add references to $state and $stateParams to the $rootScope so that you can access them from any scope within your applications.For example,
    // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li> to active whenever 'contacts.list' or one of its decendents is active.
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;

    $rootScope.$on('$stateChangeStart', function (event, toState, toParams, fromState, fromParams) {
        var defaultState = 'root.home';
        if (Acl.hasRole('user')) {
            defaultState = 'root.home';//possible other dashboard?
        }
        //check fromState - empty -> go default state
        //if fromState - DENY -> go default state
        if (!fromState.name || !Acl.can(fromState.name)) {
            fromState = defaultState;
        }

        //console.log('toState', toState.name);
        //console.log('Acl.can', Acl.can(toState.name));
        if (!Acl.can(toState.name)) {
            event.preventDefault();
            //possible to add logic there, which proposal user to login
            //console.log('default', fromState);
            $state.go(fromState, fromParams); //default go BACK

        }
    });

    $rootScope.$on('$locationChangeSuccess', function () {       
        if ($location.hash()) {
            Scroll.scrollTo($location.hash());
        }
    });




    //UI.Router intentionally does not log console debug errors out of the box.
    $rootScope.$on("$stateChangeError", console.log.bind(console));
}

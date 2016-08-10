module.exports = config;

config.$inject = [
    'AppProvider',
    '$locationProvider',
    '$authProvider',
    '$httpProvider',
    'AclProvider'
];

function config(AppProvider, $locationProvider, $authProvider, $httpProvider, AclProvider) {
    //--------- $locationProvider ----------------------------------------------
    $locationProvider.html5Mode({enabled: true}).hashPrefix('!');

    //--------- $authProvider --------------------------------------------------
    $authProvider.baseUrl = AppProvider.config.apiUrl;
    $authProvider.tokenRoot = 'result';
    $authProvider.loginUrl = 'access-tokens';

    // Facebook
    $authProvider.facebook({
        clientId: AppProvider.config.facebookClientId,
        url: '/users/auth?authclient=facebook',
    });
    // LinkedIn
    $authProvider.linkedin({
        url: '/users/auth?authclient=linkedin',
        clientId: AppProvider.config.linkedinClientId,
    });

    // Twitter
    $authProvider.twitter({
        redirectUri: window.location.origin,
        url: '/users/auth?authclient=twitter',
    });

    //--------- $httpProvider --------------------------------------------------
    $httpProvider.defaults.transformResponse = function (data, headersGetter) {
        //fix for IE (sometimes not understand json)
        if (typeof (headersGetter()['content-type']) != 'undefined' && headersGetter()['content-type'].indexOf("application/json") === 0) {
            if (data) {
                var result = angular.fromJson(data);
                if (typeof (result.result) != 'undefined') {
                    return result.result
                } else {
                    return result;
                }
            }
        }
        return data;

    };
    //--------------------------------------------------------------------------

    AclProvider.config({
        storage: 'localStorage',
        storageKey: 'courserooms',
        defaultRole: 'guest',
        emptyActionDefault: true,
        defaultUser: {
            firstname: 'Guest'
        },
        permissions: {
            guest: {
                actions: {
                    'root.courses.*': false,
                    'root.profile': false,
                }
            },
            user: {//any auth user
                actions: {
                    'root.auth.*': false,
                },
            },
            student: {
                actions: {
                    'root.course.create': false
                },
                roles: ['user']
            },
            instructor: {
                roles: ['user']
            }
        },
    });
}

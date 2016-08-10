module.exports = routes;

routes.$inject = [
    'AppProvider',
    '$stateProvider',
    '$urlRouterProvider'
];

function routes(AppProvider, $stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise(function ($injector) {
        var $state = $injector.get('$state');

        $state.go('error', null, {location: false});
    });

    $stateProvider
            .state('root', {
                abstract: true,
                url: '',
                views: {
                    'header': {
                        templateUrl: AppProvider.viewPath('site/header'),
                        controller: 'Header',
                        controllerAs: 'vm'
                    },
                    'footer': {
                        templateUrl: AppProvider.viewPath('site/footer'),
                        //controller: 'Footer',
                        //controllerAs: 'vm'
                    },
                },
            })
            .state('root.home', {
                url: '/',
                views: {
                    '@': {
                        templateUrl: AppProvider.viewPath('site/home'),
                        controller: 'Home',
                        controllerAs: 'vm'
                    },
                },
            })

            .state('root.auth', {
                url: '',
                views: {
                    '@': {
                        template: '<div ui-view></div>'
                    },
                },
            })
            .state('root.auth.login', {
                url: '/login',
                templateUrl: AppProvider.viewPath('auth/login'),
                controller: 'Login',
                controllerAs: 'vm'
            })
            .state('root.auth.register', {
                url: '/register',
                templateUrl: AppProvider.viewPath('auth/register'),
                controller: 'Register',
                controllerAs: 'vm'
            })
            .state('root.auth.register_complete', {
                url: '/register', //same url: possible to view only programmly
                templateUrl: AppProvider.viewPath('auth/register.complete'),
            })
            .state('root.auth.register_confirm', {
                url: '/verify/:token',
                templateUrl: AppProvider.viewPath('auth/register.confirm'),
                controller: 'RegisterConfirm',
                controllerAs: 'vm',
            })
            .state('root.auth.forgot', {
                url: '/forgot',
                templateUrl: AppProvider.viewPath('auth/forgot'),
                controller: 'Forgot',
                controllerAs: 'vm'
            })

            //static pages and so on
            .state('root.page', {
                url: '',
                views: {
                    '@': {
                        template: '<div ui-view data-autoscroll="true"></div>'
                    },
                },
            })
            .state('root.page.contact', {
                url: '/contact',
                templateUrl: AppProvider.viewPath('page/contact-us'),
            })
            .state('root.page.policy', {
                url: '/policy',
                templateUrl: AppProvider.viewPath('page/policy'),
            })
            .state('root.page.support', {
                url: '/support',
                templateUrl: AppProvider.viewPath('page/support'),
            })
            .state('root.page.terms', {
                url: '/terms',
                templateUrl: AppProvider.viewPath('page/terms-of-use'),
            })



            .state('error', {
                url: '/error',
                templateUrl: AppProvider.viewPath('error')
            })

            //temp and blank
            .state('root.profile', {
                url: '/profile',
                views: {
                    '@': {
                        templateUrl: AppProvider.viewPath('profile/profile'),
                        controller: 'Profile',
                        controllerAs: 'vm',
                    },
                },
                resolve: {
                    promiseProfile: ['User', function (User) {
                            return  User.getProfile().$promise;
                        }
                    ],
                    promiseCourseSubjects: ['CourseSubject', function (CourseSubject) {
                            return null;// CourseSubject.query().$promise;
                        }
                    ],
                    promiseCountries: ['Country', function (Country) {
                            return Country.query().$promise;
                        }
                    ],
                },
            })
            .state('root.course', {
                url: '/course',
                abstract: true,
                views: {
                    '@': {
                        template: '<div ui-view></div>'
                    },
                },
            })
            .state('root.course.list', {
                url: '/list',
                templateUrl: AppProvider.viewPath('course/list')
            })
            .state('root.course.create', {
                url: '/create',
                controller: 'CourseCreate',
                controllerAs: 'vm',
                templateUrl: AppProvider.viewPath('course/create'),
                resolve: {
                    promiseLevels: ['CourseLevel', function (CourseLevel) {
                            return  CourseLevel.query().$promise;
                        }
                    ],
                }, 
            })
            .state('root.course.created', {
                url: '/created',               
                templateUrl: AppProvider.viewPath('course/created'),               
            })



}

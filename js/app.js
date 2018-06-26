/**
 * Created by khanh on 10/05/17.
 */
var app = angular.module("MyModule", [
    'CommonAngularJS',
    'ui.router',
    'MetronicApp',
    'ng-backstretch'
]);
/*use ngView*/
/*app.config(['$routeProvider', function ($routeProvider) {
 $routeProvider
 .when('/', {
 templateUrl: 'pages/company.html'
 })
 .when('/staff_1', {
 templateUrl: 'pages/staff.html'
 })
 .otherwise({
 redirectTo: '/'
 });
 }
 ]);*/
/*Declare Ui-View for url*/
app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    $stateProvider
    // HOME STATES AND NESTED VIEWS ========================================
        .state('home', {
            url: '/home',
            abstract: true,
            templateUrl: 'pages/index.html',
        })
        /*STR child of home*/
        // nested list with custom controller
        .state('home.company', {
            url: '/company',
            templateUrl: 'pages/company.html'
        })
        //demo modal company
        .state('home.companyPopup', {
            url: '/company_popup',
            templateUrl: 'pages/company_popup.html'
        })
        //demo change page company
        .state('home.companyEdit', {
            url: '/company_edit',
            templateUrl: 'pages/company_edit.html'
        })
        .state('home.companyEditPage', {
            url: '/company_edit/:id',
            templateUrl: 'pages/company_edit_page.html',
            param: {
                hiddenParam: 'YES'
            }
        })

        // nested list with just some random string data
        .state('home.staff', {
            url: '/staff',
            templateUrl: 'pages/staff.html'
        })

        .state('home.staff_popup', {
            url: '/staff_popup',
            templateUrl: 'pages/staff_popup.html',
        })

        .state('home.staff_search', {
            url: '/staff_search',
            templateUrl: 'pages/staff_search.html',
        })

        .state('home.user', {
            url: '/user',
            templateUrl: 'pages/user.html'
        })
        /*END child of home*/

        // ABOUT PAGE AND MULTIPLE NAMED VIEWS =================================
        .state('login', {
            url: '/',
            templateUrl: 'pages/login.html',
            /*resolve: {
             deps: ['$ocLazyLoad', function($ocLazyLoad) {
             return $ocLazyLoad.load({
             name: 'app',
             files: [
             'js/BL/login.BL.js',
             'js/Controllers/login.Controller.js'
             ]
             });
             }]
             }*/
        });
});
/*remove character '!' on url*/
app.config(['$locationProvider', function ($locationProvider) {
    $locationProvider.hashPrefix('');
}]);

/*Add authenticate token add header*/
app.factory('authInterceptor', function ($rootScope, $q, $window) {
    return {
        request: function (config) {
            $rootScope.loading = true;
            config.headers = config.headers || {};
            if ($window.sessionStorage.token) {
                config.headers.Authorization = 'Bearer ' + $window.sessionStorage.token;
                /*console.log(config.headers.Authorization);*/
            }
            return config;
        },
        response: function (response) {
            $rootScope.loading = false;
            return response || $q.when(response);
        },
        responseError: function (response) {
            $rootScope.loading = false;
            switch (response.status) {
                case 401:
                    $window.location.href = '#/';
                    toastr.error('Can not authentication');
                    return false;
                case 403:
                    $window.location.href = '#/';
                    toastr.error('You do not have permission to access this site');
                    return false;
                case 500:
                    $window.location.href = '#/';
                    toastr.warning('Time out');
                    return false;
            }
        }
    };
});

/*Push factory to $httpProvider*/
app.config(function ($httpProvider) {
    $httpProvider.interceptors.push('authInterceptor');
});

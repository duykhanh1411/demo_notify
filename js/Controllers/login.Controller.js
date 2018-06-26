/**
 * Created by khanh on 11/05/17.
 */
app.controller("LoginController", function ($rootScope,$scope, $http, $filter, $window) {
    $scope.user = {
        'name': '',
        'password': ''
    };
    $rootScope.userInfo={
        'name':'',
        'image':''
    };
    $scope.imagesBacground = [
        'css/media/bg/1.jpg',
        'css/media/bg/2.jpg',
        'css/media/bg/3.jpg',
        'css/media/bg/4.jpg'
    ];

    /*login page*/
    /*onClick login*/
    $scope.login = function () {
        login($scope, $http, $window);
    };
});

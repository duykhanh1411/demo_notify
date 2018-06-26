/**
 * Created by khanh on 10/05/17.
 */
var appLogin = angular.module('LoginBL', []);

function login($scope, $http, $window) {
    var user = $scope.user;
    $http({
        method: "POST",
        url: 'api/public/api/auth/create',
        responseType: 'json',
        data: user,
        transformResponse: function (result) {
            /*alert(result.error+","+result.token);*/
            $window.sessionStorage.token="";
            if (result.error == "0") {
                $window.sessionStorage.userName =result.userName;
                $window.sessionStorage.imageUrl= result.imageUrl;
                $window.sessionStorage.token = result.token;
                $window.location.href = '#/home/company';
            } else {
               /* alert(result.error);*/
            }
        }
    });
};
function logout($scope, $window) {
    $window.sessionStorage.token = "";
    $window.sessionStorage.userName ="";
    $window.sessionStorage.imageUrl= "";
    /*$window.location.href = '/learning_Angular_api/firstView.php#/';*/
    $window.location.href = '#/';
};


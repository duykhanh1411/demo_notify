/**
 * Created by khanh on 23/05/2017.
 */
/*Edit controller demo for grid view*/
app.controller("CompanyEditController", function ($rootScope, $scope, $http, $filter, $window) {
    $scope.data = {
        'id': '',
        'name': '',
        'Invoke': ''
    };
    /* console.log("dsadsad");*/
    $scope.init = function () {
        if ($window.sessionStorage.token == "" || $window.sessionStorage.token == undefined) {
            $window.location.href = '#/';
        } else {
            loadListCompany(1, $scope, $http, $window);
        }
    };

    /*onClick row on grid view*/
    $scope.selectedRow = function (data) {
        selectedRow($scope, $filter, data);
        window.location.href = '#/home/company_edit/'+data.id;
    };

    /*Onclick paging*/
    $scope.getPaging = function (page) {
        loadListCompany(page, $scope, $http, $window);
    };
});
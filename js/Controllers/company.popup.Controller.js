/**
 * Created by khanh on 15/05/17.
 */
/*CompanyPopup Controller for popup demo*/
app.controller("CompanyPopupController", function ($rootScope, $scope, $http, $filter, $window, $timeout) {
    $scope.data = {
        'id': '',
        'name': '',
        'Invoke':''
    };
    $scope.init = function () {
        if($window.sessionStorage.token == "" ||$window.sessionStorage.token == undefined){
            $window.location.href = '#/';
        }else {
            loadListCompany(1, $scope, $http, $window);
        }
    };
    /*reset form when call this function
     * ng-model must declare ng-model='data."Name of field"'
     * data will be reset*/
    $scope.resetForm = function () {
        $scope.data = null;
    };

    /*onClick row on grid view*/
    $scope.selectedRow = function (data) {
        selectedRowPopup($scope, $filter, data);
        showUpdateBtnDeleteBtn();
        showModal();

    };

    /*onClick create*/
    $scope.create = function () {
        createCompany($scope, $http, $window);
        closeModal($timeout);
    };

    /*onClick update*/
    $scope.update = function () {
        updateCompany($scope, $http, $window);
        closeModal($timeout);

    };

    /*onClick delete*/
    $scope.delete = function () {
        deleteCompany($scope, $http, $window);
        closeModal($timeout);
    };
    /*onClick close modal*/
    $scope.close=function () {
        closeModal($timeout);
    };

    /*onClick paging*/
    $scope.getPaging = function (page) {
        loadListCompany(page, $scope, $http, $window);
    };

    $scope.doNothing= function ($event) {
      return $event.preventDefault();
    };

    /*onclick createbtn*/
    $scope.showPopupCreate = function () {
        $scope.data = null;
        showModal();
        showCreateBtn();
    };
});
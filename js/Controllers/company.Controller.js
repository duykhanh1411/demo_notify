/**
 * Created by khanh on 15/05/17.
 */

app.controller("CompanyController", function ($rootScope, $scope, $http, $filter, $window, $timeout) {
    enterAsTab("#mainCompany");

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
    /*reset form when call this function
     * ng-model must declare ng-model='data."Name of field"'
     * data will be reset*/
    $scope.resetForm = function () {
        $scope.data = null;
        /*  $scope.formCompany.$setPristine();*/
    };

    /*onClick row on grid view*/
    $scope.selectedRow = function (data) {
        selectedRow($scope, $filter, data);
    };

    /*onClick create*/
    $scope.create = function () {
        createCompany($scope, $http, $window);
        closeModal($timeout);
    };

    /*onClick update*/
    $scope.update = function () {
        updateCompany($scope, $http, $window);
    };

    /*onClick delete*/
    $scope.delete = function () {
        deleteCompany($scope, $http, $window);
    };

    $scope.export = function () {
        //Submit form download excel
        angular.element(document.querySelector('#exportExcel')).submit();
    }

    /*onClick paging*/
    $scope.getPaging = function (page) {
        loadListCompany(page, $scope, $http, $window);
    };

    $scope.showPopupCreate = function () {
        if ($scope.data != null) {
            var rowId = "row_id_" + $scope.data.id;
            var $target = angular.element(document.querySelector('#' + rowId));
            $target.removeClass('selected');
        }
        $scope.data = null;
        showModal();
    };

    /*Add event enterAsTab affter show modal*/
    angular.element('#myModal').on('shown.bs.modal', function () {
        enterAsTab("#myModal");
    });

    $scope.close = function () {
        enterAsTab("#mainCompany");
        closeModal($timeout);
    };
});
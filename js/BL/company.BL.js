/**
 * Created by khanh on 15/05/17.
 */
var appCompanyBL = angular.module('CompanyBL', []);

function createCompany($scope, $http, $window) {
    $scope.data.Invoke = "0";
    var staff = $scope.data;
    $http({
        method: "POST",
        url: 'api/public/api/companyGenerateAction',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                return;
            } else {
                loadListCompany(1, $scope, $http);
                toastr.success("Create success");
                $scope.resetForm();
            }
        }
    });
};

function updateCompany($scope, $http, $window) {
    $scope.data.Invoke = "1";
    var staff = $scope.data;
    $http({
        method: "POST",
        url: 'api/public/api/companyGenerateAction',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                return;
            } else {
                loadListCompany(1, $scope, $http);
                toastr.success("Update success");
                $scope.resetForm();
            }
        }
    });
};

function deleteCompany($scope, $http, $window) {
    $scope.data.Invoke = "2";
    var staff = $scope.data;
    $http({
        method: "POST",
        url: 'api/public/api/companyGenerateAction',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                return;
            } else {
                loadListCompany(1, $scope, $http);
                toastr.success("Delete success");
                $scope.resetForm();
            }
        }
    });
};

//load data to grid view
function loadListCompany(page, $scope, $http, $window) {
    var param = {
        page: page,
        Invoke: "5",
    };
    $http({
        method: "POST",
        url: 'api/public/api/companyGenerateAction',
        responseType: 'json',
        data: param,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                return;
            } else {
                creatPaging(result.currentPage, result.totalPages, result.totalItems, result.pageSize, $scope);
                $scope.listCompany = result.data;
                $scope.resetForm();
            }
        }
    });
};
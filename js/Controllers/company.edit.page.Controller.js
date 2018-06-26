/**
 * Created by khanh on 23/05/2017.
 */
/*CompanyEditPage Controller demo for edit page */
app.controller("CompanyEditPageController", function ($rootScope, $scope, $http, $filter, $window, $stateParams) {

    /* console.log("dsadsad");*/
    $scope.init = function () {
        $scope.data = {
            'id': '',
            'Invoke': ''
        };
        if ($window.sessionStorage.token == "" || $window.sessionStorage.token == undefined) {
            $window.location.href = '#/';
        } else {
            var staff = {
                'id': $stateParams.id
            }
            $http({
                method: "POST",
                url: 'api/public/api/company/getCompany',
                responseType: 'json',
                data: staff,
                transformResponse: function (result) {
                    if (result == "500" || result == "401" || result == null || result.length==0) {
                        toastr.error("Company is not exits");
                        backCompany();
                    } else
                        dataBindingToControl(angular.copy(result[0]), $scope, $filter);
                }
            });

        }
    };

    /*onClick create*/
    $scope.create = function () {
        $scope.data.Invoke = "0";
        var company = $scope.data;
        $http({
            method: "POST",
            url: 'api/public/api/companyGenerateAction',
            responseType: 'json',
            data: company,
            transformResponse: function (result) {
                if (result == "500" || result == "401" || result == null) {
                    return;
                } else {
                    alert("Create success");
                    backCompany();
                }
            }
        });
    };

    /*onClick update*/
    $scope.update = function () {
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
                    alert("Update success");
                    backCompany();
                }
            }
        });
    };

    /*onClick delete*/
    $scope.delete = function () {
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
                    alert("Delete success");
                    backCompany();
                }
            }
        });
    };

    /*Onclick back button*/
    $scope.back = function () {
       backCompany();
    }
});
function backCompany() {
    window.location.href = '#/home/company_edit';
}
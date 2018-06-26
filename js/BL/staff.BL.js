/**
 * Created by khanh on 10/05/17.
 */
var appStaffBL = angular.module('StaffBL', []);

function createStaff($scope, $http, $window) {
    $scope.data.Invoke = "0";
    $scope.data.dateOfbirth = "";
    $scope.data.companyId = $scope.companyIdCBB.id;
    $scope.data.image = $scope.image;
    if ($scope.data.companyId == "0") {
        $scope.data.companyId = "";
    }

    if ($scope.data.dateOfBirthValue != null) {
        $scope.data.dateOfbirth = moment($scope.data.dateOfBirthValue).format('YYYY-MM-DD');
    }
    var staff = $scope.data;

    $http({
        method: "POST",
        url: 'api/public/api/test',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                /* $window.location.href = '/learning_Angular_api/firstView.php#/';*/
                return;
            } else {
                loadListStaff(1, $scope, $http);
                toastr.success("Create success");
                /*alert(result);*/
                $scope.resetForm();
            }
        }
    });
};

function updateStaff($scope, $http, $window) {
    $scope.data.Invoke = "1";
    $scope.data.dateOfbirth = "";
    $scope.data.companyId = $scope.companyIdCBB.id;
    $scope.data.image = $scope.image;
    if ($scope.data.companyId == "0") {
        $scope.data.companyId = "";
    }
    if ($scope.data.dateOfBirthValue != null) {
        $scope.data.dateOfbirth = moment($scope.data.dateOfBirthValue).format('YYYY-MM-DD');
    }
    var staff = $scope.data;
    $http({
        method: "POST",
        url: 'api/public/api/test',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                /*$window.location.href = '/learning_Angular_api/firstView.php#/';*/
                return;
            } else {
                loadListStaff(1, $scope, $http);
                toastr.success("Update success");
                $scope.resetForm();
            }
        }
    });
};

function deleteStaff($scope, $http, $window) {
    $scope.data.Invoke = "2";
    var staff = $scope.data;
    $http({
        method: "POST",
        url: 'api/public/api/test',
        responseType: 'json',
        data: staff,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                /* $window.location.href = '/learning_Angular_api/firstView.php#/';*/
                return;
            } else {
                loadListStaff(1, $scope, $http);
                toastr.success("Delete success");
                $scope.resetForm();
            }
        }
    });
};

//load data to grid view
function loadListStaff(page, $scope, $http, $window) {
    var param = {
        page: page,
        Invoke: "5",
    };
    $http({
        method: "POST",
        url: 'api/public/api/test',
        responseType: 'json',
        data: param,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                /*$window.location.href = '/learning_Angular_api/firstView.php#/';*/
                return;
            } else {
                creatPaging(result.currentPage, result.totalPages, result.totalItems, result.pageSize, $scope);
                $scope.listStaff = result.data;
                $scope.resetForm();
            }
        }
    });
};
//load data to combobox company name
function loadListCBBCompany($scope, $http) {
    $http({
        method: "GET",
        url: 'api/public/api/test/getAllCompany',
        responseType: 'json',
        transformResponse: function (result) {
            $scope.listCompanyForCB = result;
            $scope.companyIdCBB = {id: 0, name: ""};
        }
    });
}

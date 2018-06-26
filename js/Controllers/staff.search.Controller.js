/**
 * Created by khanh on 27/05/2017.
 */
/*Search staff by fulltext search controller */
app.controller("StaffSearchController", function ($rootScope, $scope, $http, $filter, $window) {
    $scope.keyword = "";
    $scope.str = "";

    //onClick search
    $scope.search = function () {
        loadListStaffSearch(1, $scope, $http, $window);
    };

    //onClick export excel
    $scope.export = function () {
        angular.element(document.querySelector('#str')).val($scope.keyword).triggerHandler('input');
        console.log($scope.str);
        angular.element(document.querySelector('#exportExcel')).submit();
    };

    //onClick paging
    $scope.getPaging = function (page) {
        loadListStaffSearch(page, $scope, $http, $window);
    };
});
function loadListStaffSearch(page, $scope, $http, $window) {
    var param = {
        page: page,
        keyword: $scope.keyword
    };
    $http({
        method: "POST",
        url: 'api/public/api/test/searchStaff',
        responseType: 'json',
        data: param,
        transformResponse: function (result) {
            if (result == "500" || result == "401" || result == null) {
                return;
            } else {
                creatPaging(result.currentPage, result.totalPages, result.totalItems, result.pageSize, $scope);
                $scope.listStaff = result.data;
            }
        }
    });
};
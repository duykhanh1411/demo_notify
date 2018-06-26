/**
 * Created by khanh on 17/05/2017.
 */
app.controller("UserController", function ($rootScope, $scope, $http, $timeout, $window) {
    $scope.thumbnail = {
        dataUrl: ''
    };

    //onClick upload file
    $scope.uploadFile = function () {
        var file = $scope.myFile;
        var uploadUrl = "api/public/api/test/uploadFile";
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},
            transformResponse: function (result) {
                result= JSON.parse(result);
                if(result.error == '0'){
                    alert('Upload success');
                    resetUploadFile($scope);
                    $window.sessionStorage.userName =result.userName;
                    $window.sessionStorage.imageUrl =result.imageUrl;
                    $rootScope.userInfo={
                        'name':$window.sessionStorage.userName,
                        'image':$window.sessionStorage.imageUrl
                    };
                }
            }
        })
    };

    $scope.resetUploadFile = function () {
        resetUploadFile($scope);
    };

    //onClick select file
    $scope.selectUploadFile = function () {
        $timeout(function() {
            document.getElementById('myFile').click();
        }, 0);
    };
});

//reset after upload file
function resetUploadFile($scope) {
    //reset file select
    angular.element(document.querySelector('#myFile')).val("");
    $scope.myFile = "";

    //reset name of image
    angular.element(document.querySelector('#val')).text("");

    //reset image preview
    angular.element(document.querySelector('#imagePreView')).prop('src','');
    $scope.thumbnail = {
        dataUrl: ''
    };
    $scope.dataBtnRemoveImagePreView= '';
};
/**
 * Created by khanh on 26/05/2017.
 */
/*StaffPopup Controller for popup demo*/
app.controller("StaffPopupController", function ($scope, $http, $filter, $window, $timeout) {
    $scope.init = function () {
        if ($window.sessionStorage.token == "" || $window.sessionStorage.token == undefined) {
            $window.location.href = '#/';
        } else {
            loadListStaff(1, $scope, $http, $window);
            loadListCBBCompany($scope, $http);
        }
    };
    /*reset form when call this function
     * ng-model must declare ng-model='data."Name of field"'
     * data will be reset*/
    $scope.resetForm = function () {
        $scope.data = null;

        //reset selected cbb
        $scope.companyIdCBB = {id: 0, name: ""};

        //reset image staff
        resetUploadFileStaf($scope);

        /*  $scope.formCompany.$setPristine();*/
    };

    /*onClick row on grid view*/
    $scope.selectedRow = function (data) {
        //load data to cbb
        $scope.companyIdCBB = {id: data.companyId, name: data.companyName};

        //remove file select before
        resetUploadFileStaf($scope);

        if(data.image!= null && data.image!= ""){
            //load data to image modle
            $scope.image = data.image;
            //load image url
            $scope.thumbnail.dataUrl = data.imageUrl;
            angular.element(document.querySelector('#imagePreView')).prop("src",data.imageUrl)
            //load image name
            angular.element(document.querySelector('#val')).text(data.image);
            //Create button upload and remove
            creatBtnRemoveImagePreView($scope);
        }
        //load data for other control
        selectedRowPopup($scope, $filter, data);

        showUpdateBtnDeleteBtn();

        showModal();
    };

    /*onClick create*/
    $scope.create = function () {
        if ($scope.image != angular.element(document.querySelector('#val')).text()) {
            toastr.error("Please upload file");
            return;
        }
        createStaff($scope, $http, $window);
        resetUploadFileStaf($scope);
        closeModal($timeout);
    };

    /*onClick update*/
    $scope.update = function () {
        if ($scope.image != angular.element(document.querySelector('#val')).text()) {
            toastr.error("Please upload file");
            return;
        }
        updateStaff($scope, $http, $window);
        resetUploadFileStaf($scope);
        closeModal($timeout);
    };

    /*onClick delete*/
    $scope.delete = function () {
        deleteStaff($scope, $http, $window);
        resetUploadFileStaf($scope);
        closeModal();
    };

    $scope.close=function () {
        closeModal($timeout);
    };


    /*onClick paging*/
    $scope.getPaging = function (page) {
        loadListStaff(page, $scope, $http, $window);
    };

    $scope.thumbnail = {
        dataUrl: ''
    };

    //onClick upload file
    $scope.uploadFile = function () {
        var file = $scope.myFile;
        if (file == null || file == "") {
            toastr.error("You must select new file");
            return;
        }
        var uploadUrl = "api/public/api/test/uploadFileStaff";
        var fd = new FormData();
        fd.append('file', file);
        $http.post(uploadUrl, fd, {
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},
            transformResponse: function (result) {
                result = JSON.parse(result);
                if (result.error == '0') {
                    toastr.success('Upload success');
                    $scope.image = result.imageStaff;
                    $scope.thumbnail = result.imageUrl;
                }
            }
        })
    };

    //onClick remove file
    $scope.resetUploadFile = function () {
        resetUploadFileStaf($scope);
    };

    //onClick select file
    $scope.selectUploadFile = function () {
        $timeout(function () {
            document.getElementById('myFile').click();
        }, 0);
    };
    
    $scope.showPopupCreate = function () {
        $scope.data = null;

        //reset selected cbb
        $scope.companyIdCBB = {id: 0, name: ""};

        //reset image staff
        resetUploadFileStaf($scope);
        showModal();
        showCreateBtn();
    };
});

//reset after upload file
function resetUploadFileStaf($scope) {
    //reset ng-modle image
    $scope.image = "";

    //reset file select
    angular.element(document.querySelector('#myFile')).val("");
    $scope.myFile = "";

    //reset name of image
    angular.element(document.querySelector('#val')).text("");

    //reset image preview
    angular.element(document.querySelector('#imagePreView')).prop('src', '');
    $scope.thumbnail = {
        dataUrl: ''
    };
    $scope.dataBtnRemoveImagePreView = '';
};

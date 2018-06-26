var appCommon = angular.module('CommonAngularJS', []);
var selectorForNextControl = "input:visible:not([readonly]):not([type=file]):not([disabled]):not([type=hidden]), textarea:visible:not([readonly]):not([disabled]), select:not([disabled]), button:visible:not([disabled])";
var selectorToAttachEvent = "input:not([popup]):not([type=file]):not([disabled]):not([type=hidden]), textarea:not([readonly]):not([disabled]), select:not([disabled]), button:not([disabled])";
// build text html to html code
appCommon.directive('ngAddHtml', function ($compile, $parse) {
    return {
        restrict: 'A',
        link: function (scope, $element, attr) {
            scope.$watch(attr.contentHtml, function () {
                $element.html($parse(attr.contentHtml)(scope));
                $compile($element.contents())(scope);
            }, true);
        }
    }
});

// Directive for upload file
appCommon.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function (e) {
                // load data to $scope.myFile to upload file
                scope.$apply(function () {
                    modelSetter(scope, element[0].files[0]);
                });
                // read data from $scope.myFile
                var fileReader = new FileReader();
                fileReader.readAsDataURL(scope.myFile);
                fileReader.onload = function (e) {
                    //load src to <img src="{{thumbnail.dataUrl}}"/> (image pre view)
                    scope.$apply(function () {
                        scope.thumbnail.dataUrl = e.target.result;
                        angular.element(document.querySelector('#val')).text(scope.myFile.name);
                    });
                };
                creatBtnRemoveImagePreView(scope);
            });
        }
    };
}]);

// Directive validate number
appCommon.directive('ngOnlyNumber', function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, element, attributes, ngModel) {
            ngModel.$validators.required = function (modelValue) {
                if (modelValue) {
                    var number = modelValue.replace(/[^0-9]/g, '');
                    if (number !== modelValue) {
                        ngModel.$setViewValue(number);
                        ngModel.$render();
                    }
                    var result = parseInt(number, 10);
                    if (!isNaN(result)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                return false;
            }
            ngModel.$validators.number = function (modelValue) {
                if (modelValue) {
                    var number = modelValue.toString().replace(/[^0-9]/g, '');
                    var result = parseInt(number, 10);
                    if (!isNaN(result)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
                return false;
            };
        }
    };
});

// Directive validate code
appCommon.directive('ngOnlyCode', function () {
    return {
        restrict: "A",
        require: "ngModel",
        link: function (scope, element, attributes, ngModel) {
            function inputValue(val) {
                if (val) {
                    var digits = val.replace(/\D/g, '');

                    if (digits !== val) {
                        ngModel.$setViewValue(digits);
                        ngModel.$render();
                    }
                    return parseInt(digits, 10);
                }
                return undefined;
            }

            ngModel.$parsers.push(inputValue);
            element.bind('blur', function (e) {
                var maxLength = attributes.ngMaxlength;
                var value = ngModel.$viewValue;
                var str = "";
                value = value == null ? "" : value.toString();
                if (value != "") {
                    for (var i = 0; i < (maxLength - String(value).length); i++) {
                        str += "0";
                    }
                    if (String(value).length < maxLength) {
                        ngModel.$setViewValue(str + value);
                        ngModel.$render();
                    }
                    //else{
                    //    ngModel.$setViewValue(value);
                    //    ngModel.$render();
                    //}
                    if (String(value).length >= maxLength) {
                        ngModel.$setViewValue(value.substr(0, maxLength));
                        ngModel.$render();
                    }
                }
            });
        }
    };
});
//draw htm btnRemoveImagePreView for attribute content-html of directive ng-add-html
function creatBtnRemoveImagePreView($scope) {
    var node ='<button class="btn btn-danger" ng-click="resetUploadFile()">Remove</button><button class="btn" ng-click="uploadFile()">Upload me</button>';
    $scope.dataBtnRemoveImagePreView = node;

}

//draw html for paging for attribute content-html of directive ng-add-html
function creatPaging(pageNumber, totalPages, totalItems, maxPageShow, $scope) {
    var node = '<ul>';
    var halfPage = maxPageShow / 2;
    var startPage = pageNumber - halfPage;
    var endPage = pageNumber + halfPage;
    if (pageNumber <= halfPage) {
        startPage = 1;
        endPage = maxPageShow;
    }
    else if (pageNumber > halfPage) {
        startPage = pageNumber - halfPage;
        endPage = pageNumber + halfPage - 1;
    }
    if (endPage > totalPages) {
        endPage = totalPages;
        startPage = endPage - maxPageShow + 1;
        if (startPage < 1) {
            startPage = 1;
        }
    }
    if (totalPages > 1) {
        if (pageNumber > 1) {
            node += '<li ng-click="getPaging(1)"> << </li>';
        }
        else {
            node += '<li><<</li>';
        }
        for (var page = startPage; page < endPage + 1; page++) {
            if (page == pageNumber) {
                node += '<li class="selected-page">' + page + '</li>';
            }
            else {
                node += '<li ng-click="getPaging(' + page + ')">' + page + '</li>';
            }
        }
        if (pageNumber < totalPages) {
            node += '<li ng-click="getPaging(' + totalPages + ')"> >> </li>';
        }
        else {
            node += '<li>>></li>';
        }
    }
    if (totalItems > 0) {
        node += '<li>Page:' + pageNumber + ' / ' + totalPages + '</li>';
    }
    node += '<li>Total:' + totalItems + '</li></ul>';
    $scope.dataPagingHtml = node;
};

// Directive phone input
appCommon.directive('phoneInput', function ($filter, $browser) {
    return {
        require: 'ngModel',
        link: function (scope, $element, attrs, ngModelCtrl) {
            var listener = function () {
                var value = $element.val().replace(/[^0-9]/g, '');
                $element.val($filter('tel')(value, false));
            };
            // This runs when we update the text field
            ngModelCtrl.$parsers.push(function (viewValue) {
                return viewValue.replace(/[^0-9]/g, '').slice(0, 10);
            });
            // This runs when the model gets updated on the scope directly and keeps our view in sync
            ngModelCtrl.$render = function () {
                $element.val($filter('tel')(ngModelCtrl.$viewValue, false));
            };
            $element.bind('change', listener);
            $element.bind('keydown', function (event) {
                var key = event.keyCode;
                // If the keys include the CTRL, SHIFT, ALT, or META keys, or the arrow keys, do nothing.
                // This lets us support copy and paste too
                if (key == 91 || (15 < key && key < 19) || (37 <= key && key <= 40)) {
                    return;
                }
                $browser.defer(listener); // Have to do this or changes don't get picked up properly
            });
            $element.bind('paste cut', function () {
                $browser.defer(listener);
            });
        }
    };
});

// filter tel number
appCommon.filter('tel', function () {
    return function (tel) {
        console.log(tel);
        if (!tel) {
            return '';
        }
        //var value = tel.toString().trim().replace(/^\+/, '');
        var value = tel.toString().trim();
        if (value.match(/[^0-9]/)) {
            return tel;
        }
        var country, city, number;
        switch (value.length) {
            case 1:
            case 2:
            case 3:
                city = value;
                break;
            default:
                city = value.slice(0, 3);
                number = value.slice(3);
        }
        if (number) {
            if (number.length > 3) {
                number = number.slice(0, 3) + '-' + number.slice(3, 7);
            }
            else {
                number = number;
            }
            return ("(" + city + ") " + number).trim();
        }
        else {
            return "(" + city;
        }
    };
});

// Directive yyyy/MM/dd for input
appCommon.directive('ngYearMonthDayInput', function ($filter, $browser) {
    return {
        require: 'ngModel',
        link: function (scope, $element, attr, ngModelCtrl) {
            var listener = function () {
                var value = $element.val().slice(0, 10);
                $element.val($filter('yearMonthDay')(value, false));
            };
            // This runs when we update the text field
            ngModelCtrl.$parsers.push(function (viewValue) {
                return viewValue.slice(0, 10);
            });
            // This runs when the model gets updated on the scope directly and keeps our view in sync
            ngModelCtrl.$render = function () {
                $element.val($filter('yearMonthDay')(ngModelCtrl.$viewValue, false));
            };
            $element.bind('change', listener);
            $element.bind('keydown', function (event) {
                var key = event.keyCode;
                // If the keys include the CTRL, SHIFT, ALT, or META keys, or the arrow keys, do nothing.
                // This lets us support copy and paste too
                if (key == 91 || (15 < key && key < 19) || (37 <= key && key <= 40)) {
                    return;
                }
                $browser.defer(listener); // Have to do this or changes don't get picked up properly
            });
            $element.bind('paste cut', function () {
                $browser.defer(listener);
            });
        }
    };
});

// Filter yyyy/MM/dd for input
appCommon.filter('yearMonthDay', function () {
    return function (yearMonthDay) {
        console.log(yearMonthDay);
        if (!yearMonthDay) {
            return '';
        }
        //var value = tel.toString().trim().replace(/^\+/, '');
        var value = yearMonthDay.toString().trim().replace(/[^0-9]/g, '');
        if (value.match(/[^0-9]/)) {
            return yearMonthDay;
        }
        var year, monthDay;
        switch (value.length) {
            case 4:
                year = value;
                break;
            default:
                year = value.slice(0, 4);
                monthDay = value.slice(4);
        }
        if (monthDay) {
            if (monthDay.length > 2) {
                monthDay = monthDay.slice(0, 2) + '/' + monthDay.slice(2, 4);
            }
            else {
                monthDay = monthDay;
            }
            return (year + "/" + monthDay).trim();
        }
        else {
            return year;
        }
    };
});

//Load data ta to control by id
function dataBindingToControl(obj, $scope, $filter) {
    if (obj != null) {
        /* @*===========Load data by id name ===========*@*/
        var propObj = Object.keys(obj);
        for (var i = 0; i < propObj.length; i++) {
            var $target = angular.element(document.querySelector('#' + propObj[i]));
            if ($target.hasClass('date')) {
                //$target.val($filter('yearMonthDay')(obj[propObj[i]], false)).triggerHandler('input');
                if (obj[propObj[i]] == null) {
                    $target.val("").triggerHandler('input');
                } else
                    $target.val(obj[propObj[i]]).triggerHandler('input');
            } else
                $target.val(obj[propObj[i]]).triggerHandler('input');
            $target.val(obj[propObj[i]]).triggerHandler('textarea');
        }
    }
    else {
        $scope.resetForm();
    }
};

//Select row on grid view
function selectedRow($scope, $filter, data) {
    var rowId = "row_id_" + data.id;
    var $target = angular.element(document.querySelector('#' + rowId));

    if ($target.hasClass('selected')) {
        $target.removeClass('selected');
        dataBindingToControl(null, $scope, $filter);
    } else {
        $target.parent().children().removeClass('selected');
        $target.addClass('selected');

        /* @*===========$broadcast is load data from parent controler to children controler, $emit is load data from children controler to parent controler===========*@*/
        /* @*===========Get data by $on ===========*@*/
        //$scope.$broadcast('loadDataToControl', data);

        /*@*===========Load data by id name ===========*@*/
        dataBindingToControl(angular.copy(data), $scope, $filter);
    }
};

function selectedRowPopup($scope, $filter, data) {
    var rowId = "row_id_" + data.id;
    var $target = angular.element(document.querySelector('#' + rowId));
    $target.parent().children().removeClass('selected');
    $target.addClass('selected');

    /* @*===========$broadcast is load data from parent controler to children controler, $emit is load data from children controler to parent controler===========*@*/
    /* @*===========Get data by $on ===========*@*/
    //$scope.$broadcast('loadDataToControl', data);

    /*@*===========Load data by id name ===========*@*/
    dataBindingToControl(angular.copy(data), $scope, $filter);
};

/*Close popup*/
function closeModal($timeout){
    angular.element('#myModal').modal('hide');
    angular.element('html').removeClass('hide-overflow');
    $timeout(function() {
        removeHideBtn();
    }, 20);
};

/*show popup*/
function showModal(){
    angular.element('#myModal').modal('show');
    angular.element('html').addClass('hide-overflow');
};
/*Hide updateBtn, deleteBtn of popup*/
function showCreateBtn() {
    angular.element(document.querySelector('#updateBtn')).css('display','none');
    angular.element(document.querySelector('#deleteBtn')).css('display','none');
};

/*Hide createBtn off popup*/
function showUpdateBtnDeleteBtn() {
    angular.element(document.querySelector('#createBtn')).css('display','none');
};

/*Remove hide off button on popup*/
function removeHideBtn() {
    angular.element(document.querySelector('#createBtn')).removeAttr("style");
    angular.element(document.querySelector('#updateBtn')).removeAttr("style");
    angular.element(document.querySelector('#deleteBtn')).removeAttr("style");
};

//Function for auto change keypress: enter as tab
function enterAsTab(parentSelector, doNotFocusFirstControl) {
    var controlsToAttachEvent;
    var parentControls;

    if (parentSelector) {
        parentControls = $(parentSelector);
        controlsToAttachEvent = parentControls.find(selectorToAttachEvent);
    } else {
        parentControls = $('form');
        controlsToAttachEvent = parentControls.find(selectorToAttachEvent);
    }

    //// set focus to 1st control in parent
    if (!doNotFocusFirstControl) {
        var firstCtr = controlsToAttachEvent.filter('input:visible:not([readonly]):first');
        firstCtr.focus();
    }
    //// attach keydown event
    controlsToAttachEvent.keydown(parentSelector, onkeydownForFocusableElement);

    //// attach focus event to select all text
    $("input[type=text],textarea").focus(function () {
        this.selectionStart = this.selectionEnd = this.value.length;
    });
}

function onkeydownForFocusableElement(event) {
    // get data of event
    var parentSelector = event.data;
    //console.log("controlsToAttachEvent.keydown: " + event.keyCode + event.shiftKey );
    // inogre ESC key code
    if (event.keyCode == 27) {
        event.preventDefault();
        event.stopPropagation();
        return false;
    }

    var jSender = $(event.target);

    //// handles ENTER=13 / SPACE BAR=32 / TAB=9 keyCodes
    if (event.keyCode == 13 || event.keyCode == 32 || (event.keyCode == 9 && !event.shiftKey)) {
        var inputType = event.target.type;
        var lowerCaseNodeName = event.target.nodeName.toLowerCase();

        //// keep default behavior of below elements
        if (event.keyCode == 13) {
            if (lowerCaseNodeName == 'textarea' || inputType == 'submit' || inputType == 'button' || lowerCaseNodeName == 'button') {
                return;
            }
        }

        if (event.keyCode == 32) {
            if (inputType == 'password' || lowerCaseNodeName == 'textarea' || lowerCaseNodeName == 'select' || lowerCaseNodeName == 'button' || inputType == 'submit' || inputType == 'button'
                || inputType.indexOf("date") > -1 || inputType == "text" || inputType == "checkbox" || inputType == "radio") {
                return;
            }
        }

        if (navigateToNextControlOnAnotherAreaIfAny($(this)) == true) {
            event.preventDefault();
            event.stopPropagation();
            return;
        }

        var inputs = null;
        if (parentSelector) {
            inputs = $(this).parents(parentSelector).eq(0).find(selectorForNextControl);
        } else {
            inputs = $(this).parents("form").eq(0).find(selectorForNextControl);
        }
        //debugger;
        var idx = inputs.index(this);
        if (idx == inputs.length - 1) {
            idx = -1;
        }

        try {
            // focus to span:has(.select2) elements
            if (lowerCaseNodeName === "span") {
                $(this).closest("span.select2").removeClass("select2-container--focus");
            }

            // check to mark .select2 span as focus
            if (inputs[idx + 1].nodeName.toLowerCase() == "span") {
                $(inputs[idx + 1]).closest("span.select2").addClass("select2-container--focus");
                $(this).blur();
            } else {
                $(inputs[idx + 1]).focus();
            }
        }
        catch (err) {
            // handle objects not offering select
            console.log(err);
        }

        event.preventDefault();
        event.stopPropagation();
    }

    //// handles SHIFT + TAB
    if (event.shiftKey && event.keyCode == 9) {

        if (navigateToPrevControlOnAnotherAreaIfAny($(this)) == true) {
            event.preventDefault();
            event.stopPropagation();
            return;
        }

        var inputs = null;
        if (parentSelector) {
            inputs = $(this).parents(parentSelector).eq(0).find(selectorForNextControl);
        } else {
            inputs = $(this).parents("form").eq(0).find(selectorForNextControl);
        }

        var idx = inputs.index(this);
        if (idx == 0) {
            idx = inputs.length;
        }

        try {
            inputs[idx - 1].focus();
        }
        catch (err) {
            // handle objects not offering select
            console.log(err);
        }

        event.preventDefault();
        event.stopPropagation();
    }
}

//Focus first control
function focusFirstControl(parentSelector) {

    //// not need to include ":visible" filter because some controls are hidden when forms have loaded.
    var selectorToGetControl = "input:not([popup]):not([type=file]):not([disabled]):not([type=hidden]), textarea:not([readonly]):not([disabled]), select:not([disabled]), button:not([disabled])";

    var controlsToDetermine;
    var parentControls;

    if (parentSelector) {
        parentControls = $(parentSelector);
        controlsToDetermine = parentControls.find(selectorToGetControl);
    } else {
        parentControls = $('form');
        controlsToDetermine = parentControls.find(selectorToGetControl);
    }

    //// set focus to 1st control in parent
    var firstCtr = controlsToDetermine.filter(':first');
    firstCtr.focus();
}

/// <summary>
/// Navigates to next control on another area if any.
/// </summary>
/// <param name="jQueryObj">The jQuery object.</param>
function navigateToNextControlOnAnotherAreaIfAny(jQueryObj) {
    // get next control parent
    var nextControlParent = $("#" + jQueryObj.attr("next-element-parent"));
    if (nextControlParent.length > 0 && nextControlParent.is(':visible') === true) {
        // get prev control
        var nextControl = $("#" + jQueryObj.attr("next-element"));
        nextControl.focus();
        nextControl.trigger("mousedown");
        return true;
    }

    return false;
}

/// <summary>
/// Navigates to previous control on another area if any.
/// </summary>
/// <param name="jQueryObj">The jQuery object.</param>
function navigateToPrevControlOnAnotherAreaIfAny(jQueryObj) {
    //// check whether need to go previous control
    // get prev control parent
    var prevControlParent = $("#" + jQueryObj.attr("prev-element-parent"));
    if (prevControlParent.length > 0 && prevControlParent.is(':visible') === true) {
        // get prev control
        var prevControl = $("#" + jQueryObj.attr("prev-element"));
        prevControl.focus();
        prevControl.trigger("mousedown");
        return true;
    }

    return false;
}
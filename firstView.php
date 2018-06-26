<!DOCTYPE html>
<html>
<head>
    <link rel="ICON" href="css/Image/favicon.ico" type="image/ico" />
    <title>Demo Laravel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="libs/jquery.min.js" type="text/javascript"></script>
    <script language="javascript" src="libs/angular.min.js"></script>
    <script language="javascript" src="libs/angular-ui-router.js"></script>
    <script src="Metronic/assets/global/plugins/angularjs/plugins/ocLazyLoad.min.js" type="text/javascript"></script>
    <script language="javascript" src="libs/moment.min.js"></script>
    <script language="javascript" src="libs/ng-backstretch.js"></script>
    <script language="javascript" src="Metronic/assets/global/plugins/bootstrap-toastr/toastr.js"></script>

    <script language="javascript" src="js/app.js"></script>
    <script language="javascript" src="Metronic/js/appMetronic.js"></script>

    <script language="javascript" src="js/Common/valor.angularJS.js"></script>
    <script language="javascript" src="js/BL/login.BL.js"></script>
    <script language="javascript" src="js/BL/staff.BL.js"></script>
    <script language="javascript" src="js/BL/company.BL.js"></script>
    <script language="javascript" src="js/Controllers/login.Controller.js"></script>
    <script language="javascript" src="js/Controllers/home.Controllers.js"></script>
    <script language="javascript" src="js/Controllers/staff.Controller.js"></script>
    <script language="javascript" src="js/Controllers/company.Controller.js"></script>
    <script language="javascript" src="js/Controllers/user.Controller.js"></script>
    <script language="javascript" src="js/Controllers/company.popup.Controller.js"></script>
    <script language="javascript" src="js/Controllers/company.edit.Controller.js"></script>
    <script language="javascript" src="js/Controllers/company.edit.page.Controller.js"></script>
    <script language="javascript" src="js/Controllers/staff.popup.Controller.js"></script>
    <script language="javascript" src="js/Controllers/staff.search.Controller.js"></script>


    <script src="Metronic/assets/global/plugins/respond.min.js"></script>
    <!--<script src="Metronic/assets/global/plugins/excanvas.min.js"></script>-->
    <!--<script src="Metronic/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>-->
    <script src="Metronic/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!--<script src="Metronic/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>-->
    <!--<script src="Metronic/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->
    <!--<script src="Metronic/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>-->
    <!--<script src="Metronic/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>-->
    <!--<script src="Metronic/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>-->
    <script src="Metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
            type="text/javascript"></script>
    <!-- END CORE JQUERY PLUGINS -->

    <!-- BEGIN CORE ANGULARJS PLUGINS -->
    <script src="Metronic/assets/global/plugins/angularjs/angular-sanitize.min.js" type="text/javascript"></script>
    <script src="Metronic/assets/global/plugins/angularjs/angular-touch.min.js" type="text/javascript"></script>

    <script src="Metronic/assets/global/plugins/angularjs/plugins/ui-bootstrap-tpls.min.js"
            type="text/javascript"></script>
    <!-- END CORE ANGULARJS PLUGINS -->

    <!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
    <script src="Metronic/js/appMetronic.js" type="text/javascript"></script>
    <script src="Metronic/js/directives.js" type="text/javascript"></script>
    <!-- END APP LEVEL ANGULARJS SCRIPTS -->

    <!-- BEGIN APP LEVEL JQUERY SCRIPTS -->
    <script src="Metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="Metronic/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
    <script src="Metronic/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
    <script src="Metronic/assets/admin/layout/scripts/demo.js" type="text/javascript"></script>
    <!-- END APP LEVEL JQUERY SCRIPTS -->

    <script type="text/javascript">
        /* Init Metronic's core jquery plugins and layout scripts */
        $(document).ready(function () {
            Metronic.init(); // Run metronic theme
            Metronic.setAssetsPath('assets/'); // Set the assets folder path
        });
    </script>

    <link href="css/login.css" rel="stylesheet" type="text/css">
    <link href="css/valor.css" rel="stylesheet"/>
    <link href="Metronic/assets/global/plugins/bootstrap-toastr/toastr.css" rel="stylesheet"/>

    <link href="Metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="Metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="Metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="Metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="Metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="Metronic/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="Metronic/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="Metronic/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="Metronic/assets/admin/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="Metronic/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
</head>
<body ng-app="MyModule">
<div class="spinner" ng-show="loading">
    <div class="loader"></div>
    <img src="css/Image/Loading_icon.png" class="loader"></img>
</div>
<div ui-view>

</div>
</body>
</html>
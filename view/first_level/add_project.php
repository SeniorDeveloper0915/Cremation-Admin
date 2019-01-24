<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    $msg = "";

    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>

    <title>整形项目管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <?php include '../../include/css/mandatory.php' ?>

    <link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/plugins/froiden-helper/helper.css" rel="stylesheet" type="text/css" />
    <?php include '../../include/css/global.php' ?>
</head>

</style>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../../include/header.php'; ?>
<div class="page-container">
    <?php include '../../include/sidebar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet light bordered" class="col-md-10">
                <div class="portlet-title">
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-user-follow font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">添加一级项目</span>
                    </div>
                </div>

                <form id="projectCreate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectname">一级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="projectname" name="projectname" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请输入一级项目名称">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="sort">排序 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="sort" name="sort" class="form-control input-sm"
                                                data-required="true" value="" placeholder="请输入排序码 (注：数字越高，展示越靠前（最大值99))" min="0" max="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline" onclick="back();">返回</button>
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="createProject();return false">保存</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../../include/footer.php' ?>
<?php include '../../include/footerjs.php' ?>
<script src="../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../assets/plugins/froiden-helper/helper.js" type="text/javascript"></script>
<script>
    function back() {
        window.location.href = "project.php";
    }
    
    function createProject() {

        if (document.getElementById('projectname').value == "") {
            window.alert("Input First Level Project");
            return false;
        }

        if (document.getElementById('sort').value == "") {
            window.alert("Input Sort");
            return false;
        }

        if (document.getElementById('sort').value > 100) {
            window.alert("Input Range is 1 to 100");
            return false;
        }
        url: "../../ajax/first_level/add_project.php",
        type: "POST",
        container: "#projectCreate",
        file:true,
        success: function(response) {
            if (response.status == "success") {
                window.location.href = "project.php";
            }
        }
    }
</script>
</body>
</html>

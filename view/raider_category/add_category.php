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

    <title>攻略管理</title>
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
            <form id="categoryCreate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="name">请输入攻略类别名称 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入动态标题">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="sort">排序 : </label>        
                            </div>
                            <div class="col-sm-9">
				<input type="number" id="sort" name="sort" class="form-control input-sm"
                                    data-required="true" value="" placeholder="请输入排序码 (注：数字越高，展示越靠前（最大值99))" min="1" max="100">
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
                    <button type="submit" class="btn green btn-outline" name="submit" onclick="createCategory();return false">保存</button>
                </div>
            </form>
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
    function createCategory() {

        if (document.getElementById('name').value == "") {
            window.alert("Input Raider Category Title");
            return false;
        }

        if (document.getElementById('sort').value == "") {
            window.alert("Input Sort");
            return false;
        }

        if (document.getElementById('sort').value > 100) {
            window.alert("Sort Range is 1 to 100");
            return false;
        }
        
        $.easyAjax({
            url: "../../ajax/raider_category/add_category.php",
            type: "POST",
            container: "#categoryCreate",
            file:true,
            success: function(response) {
                if (response.status == "success") {
                    window.location.href = "category.php";
                }
            }
        });
    }

    function back() {
        window.location.href = "category.php";
    }
</script>
</body>
</html>

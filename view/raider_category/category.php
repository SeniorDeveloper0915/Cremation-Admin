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
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <i class="icon-user font-green"></i>
                        <span class="caption-subject bold uppercase">攻略管理</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided">
                            <a href="javascript:;" class="btn green btn-outline" onclick="addCategory()"> 添加类别 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover dt-responsive" id="categoryTable" style="text-align: center;">
                        <thead>
                        <tr>
                            <th class="min-tablet" style="text-align: center;">序号</th>
                            <th class="min-tablet" style="text-align: center;">类别名称</th>
                            <th class="min-tablet" style="text-align: center;">文章数量</th>
                            <th class="min-tablet" style="text-align: center;">排序</th>
                            <th class="min-tablet" style="text-align: center;">发布时间</th>
                            <th class="min-tablet" style="text-align: center;">状态</th>
                            <th class="min-tablet" style="text-align: center;">操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal modal-styled fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-user-unfollow font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">Delete Confirmation</span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Are you sure ! You want to delete this User?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
                    <button type="submit" id="delete" class="btn red btn-outline">Delete</button>
                </div>
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
<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
<script>

    var table = $('#categoryTable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sServerMethod": "GET",
        "aaSorting": [[0, "asc"]],
        "sAjaxSource": "../../ajax/raider_category/category_view.php",
        "aoColumns": [
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": true, "bSortable": true},
            {"bVisible": true, "bSearchable": false, "bSortable": false},
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
   

            // var userImage = aData['2'];

            // if(userImage == null) {
            //     userImage = '../images/avatar/no-image.png'
            // } else {
            //     userImage = '../images/avatar/' + userImage;
            // }

            // $(row.find("td")['2']).html(
            //     '<img style="width:9em ;height:8em;" src="' + userImage + '"/>'
            // );
        }

    });

    function addCategory() {
        window.location.href = "add_category.php";
    }

    function deleteCookie() {
        var d = new Date(); //Create an date object
        d.setTime(d.getTime() - (1000*60*60*24)); //Set the time to the past. 1000 milliseonds = 1 second
        var expires = "expires=" + d.toGMTString(); //Compose the expirartion date
        window.document.cookie = "category_id=" + "; " + expires;//Set the cookie with name and the expiration date
    }

    function editCategory(id) {
        deleteCookie();
        document.cookie = "category_id = " + id;
        window.location.href = "edit_category.php";
    }

    function viewCategory(id) {
        deleteCookie();
        document.cookie = "category_id=" + id;
        window.location.href            = "view_category.php"
    }

    function changeStatus(id) {
        $.easyAjax({
                type: "POST",
                url: "../../ajax/raider_category/change_status.php?id=" + id,
                success: function (response) {
                    if (response.status == "success")
                        table._fnDraw();
                }
            });
    }

    function deleteCategory(id) {

        $('#deleteModal').find(".modal-body").html('Are you sure ! You want to delete this raider category');
        $('#deleteModal').appendTo("body").modal('show');
        $("#delete").click(function () {

            $.easyAjax({
                type: "POST",
                url: "../../ajax/raider_category/delete_category.php?id=" + id,
                container: "#deleteModal",
                success: function (response) {
                    if (response.status == "success") {
                        $('#deleteModal').modal('hide');
                        table._fnDraw();
                    }
                }
            });
        })
    }
</script>
</body>
</html>

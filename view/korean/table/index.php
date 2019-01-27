<?php
    session_start();
    include '../../../config/index.php';
    error_reporting(0);
    $msg = "";

    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }

    $getKorean = $db->prepare("SELECT * FROM korean_medicine");
    $getKorean->execute();
    $rowKorean = $getKorean->fetchAll();

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

    <title>网站信息维护管理</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <?php include '../../../include/css/mandatory/index.php' ?>

    <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="../../../assets/plugins/froiden-helper/helper.css" rel="stylesheet" type="text/css" />
    <?php include '../../../include/css/global/index.php' ?>
</head>

</style>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../../../include/header/index.php'; ?>
<div class="page-container">
    <?php include '../../../include/sidebar/index.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <i class="icon-user font-green"></i>
                        <span class="caption-subject bold uppercase">网站信息维护管理</span>
                    </div>
                </div>
                <form id="koreanCreate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo $rowKorean[0]['id'] ?>">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="title">简介标题 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="title" name="title" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请输入简介标题">        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="content">简介内容 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea name="content" id="content" rows="100" cols="800" value="">
                                        
                                            </textarea>        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="createKorean();return false">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../../../include/footer/index.php' ?>
<?php include '../../../include/footerjs/index.php' ?>
<script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../assets/plugins/froiden-helper/helper.js" type="text/javascript"></script>
<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.editorConfig = function (config) {
       config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('content');

    function createKorean() {

        if (document.getElementById('title').value == "") {
            window.alert("Input Title");
            return false;
        }

        if (CKEDITOR.instances.content.getData() == "") {
            window.alert("Input Content!");
            return false;
        }

        $.easyAjax({
            url: "../../../ajax/korean/index.php",
            type: "POST",
            container: "#koreanCreate",
            data : {
                content : CKEDITOR.instances.content.getData()
            },
            file:true,
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    document.getElementById('title').value = "";
                    window.location.href = 'index.php';
                }
            }
        });
    }

</script>
</body>
</html>
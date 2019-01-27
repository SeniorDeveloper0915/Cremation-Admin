<?php
    session_start();
    include '../../../config/index.php';
    error_reporting(0);
    $msg = "";

    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }

    $getContact = $db->prepare("SELECT * FROM contact");
    $getContact->execute();
    $rowContact = $getContact->fetchAll();

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

    <title>管理</title>
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
                        <span class="caption-subject bold uppercase">管理</span>
                    </div>
                </div>
                <form id="contactCreate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" value="<?php echo $rowContact[0]['id'] ?>">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="information">地址信息 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="information" name="information" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请编辑地址信息" cols="40" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label>地址图片 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="" alt="" /> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> 
                                                </div>
                                                <div>
                                                    <span class="btn btn-outline green btn-file">
                                                    <span class="fileinput-new"> 上传图片 </span>
                                                    <span class="fileinput-exists"> 更改 </span>
                                                    <input type="file" name="contactimg" id="contactimg"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> 去掉 </a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                注：最多1张，请注意您上传的图片尺寸，4:3
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="createContact();return false">保存</button>
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
<script>
    function createContact() {

        if (document.getElementById('information').value == "") {
            window.alert("Input Contact Us Information");
            return false;
        }

        if (document.getElementById('contactimg').value == "") {
            window.alert("Select Contact Us Image");
            return false;
        }
        
        $.easyAjax({
            url: "../../../ajax/contact/index.php",
            type: "POST",
            container: "#contactCreate",
            file:true,
            success: function(response) {
                console.log(response);
                if (response.status == "success") {
                    document.getElementById('information').value = "";
                    window.location.href = 'index.php';
                }
            }
        });
    }
</script>
</body>
</html>
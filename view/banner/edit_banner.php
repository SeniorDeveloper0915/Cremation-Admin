<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $bannerId = $_COOKIE['banner_id'];

    $bannerData = $db->prepare('SELECT * FROM banner WHERE id=?');
    $bannerData->execute(array($bannerId));
    $rowBanner = $bannerData->fetch(PDO::FETCH_ASSOC);
    $bannerimg = file_exists("../../images/banner/".$rowBanner['Banner_Img']);
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

    <title>banner管理</title>
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
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-pencil font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">修改Banner</span>
                    </div>
                </div>
                <form id="bannerUpdate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="bannertitle">banner标题 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="id" value="<?php echo $rowBanner['id'] ?>">
                                            <input type="text" id="bannertitle" name="bannertitle" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowBanner['Banner_Title'] ?>">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="url">URL : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="url" name="url" class="form-control input-sm"
                                                data-required="true" value="<?php echo $rowBanner['URL'] ?>">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="sort">排序 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="sort" name="sort" class="form-control input-sm"
                                                data-required="true" value="<?php echo $rowBanner['Sort'] ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label>广告图 : </label>    
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img  src='<?php echo ($bannerimg == 1) ? ("../../images/banner/".$rowBanner['Banner_Img']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' style="width: 200px; height: 150px;" /> 
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> 
                                                </div>
                                                <div>
                                                    <span class="btn btn-outline green btn-file">
                                                    <span class="fileinput-new"> 上传图片 </span>
                                                    <span class="fileinput-exists"> 更改 </span>
                                                    <input type="file" name="bannerimg" id="bannerimg"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> 去掉 </a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                注：最多1张，请注意您上传的图片尺寸，11*11
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline" onclick="back();">返回</button>
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="updateBanner();return false">保存</button>
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
        window.location.href = "banner.php";
    }

    function updateBanner() {
        $.easyAjax({
            type: "POST",
            url: "../../ajax/banner/edit_banner.php",
            container: "#bannerUpdate",
            file:true,
            success: function(response) {
                if (response.status == "success") {
                    window.location.href = "banner.php";
                }
            }
        });
    }
</script>
</body>
</html>



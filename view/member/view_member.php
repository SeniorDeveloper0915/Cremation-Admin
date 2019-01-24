<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $memberId = $_COOKIE['member_id'];

    $memberData = $db->prepare('SELECT * FROM core_team WHERE id=?');
    $memberData->execute(array($memberId));
    $rowMember = $memberData->fetch(PDO::FETCH_ASSOC);
    $memberimg = file_exists("../../images/member/".$rowMember['Member_Img']);

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

    <title>网站信息维护管理 </title>
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
            <form id="industryCreate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="name">成员名称 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control input-sm" data-required="true"
                                    value="<?php echo $rowMember['Member_Name'] ?>" disabled="true">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="position">成员职务 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="position" name="position" class="form-control input-sm"
                                    data-required="true" value="<?php echo $rowMember['Position'] ?>" disabled="true">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="profile">成员简介 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <textarea id="profile" name="profile" class="form-control input-sm" data-required="true"
                                    cols="40" rows="5" disabled="true"> <?php echo $rowMember['Profile'] ?> </textarea>        
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label>封面图片 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <div class="fileinput fileinput-new">
                                    <div class="fileinput-new thumbnail" >
                                        <img  src='<?php echo ($memberimg == 1) ? ("../../images/member/".$rowMember['Member_Img']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' style="width: 200px; height: 150px;" />
                                    </div>
                                </div>
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
                                    data-required="true" value="<?php echo $rowMember['Sort'] ?>" disabled="true">        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
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
<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
<script>
    function back() {
        window.location.href = "member.php";
    }
</script>
</body>
</html>
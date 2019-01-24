<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $caseId = $_COOKIE['case_id'];

    $caseData = $db->prepare('SELECT * FROM hospital_case WHERE id = ?');
    $caseData->execute(array($caseId));
    $rowCase = $caseData->fetch(PDO::FETCH_ASSOC);
    $caseimg = file_exists("../../images/case/".$rowCase['Case_Img']);

    $getHospital = $db->prepare("SELECT * FROM hospital ORDER BY id ASC");
    $getHospital->execute();
    $rowHospital = $getHospital->fetchAll();

    $getDoctor = $db->prepare("SELECT * FROM doctor ORDER BY id ASC");
    $getDoctor->execute();
    $rowDoctor = $getDoctor->fetchAll();
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

    <title>医院管理</title>
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
            <form id="caseCreate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">医院名称 : </label>        
                            </div>
                            
                            <div class="col-sm-2">
                                <select class="form-control" id="hospitalid" name="hospitalid" disabled="true">
                                    <?php
                                        foreach ($rowHospital as $value) {
                                            if ($value['id'] == $rowCase['Hospital_Id'])
                                            {
                                    ?>
                                                <option value="<?php echo $value['id'];?>"><?php echo $value['Hospital_Name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label>案例封面照 : </label>
                            </div>
                            <div class="col-sm-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img  src='<?php echo ($caseimg == 1) ? ("../../images/case/".$rowCase['Case_Img']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' alt="上传图片"/>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="title">案例标题 </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="title" name="title" class="form-control input-sm" data-required="true"
                                    value="<?php echo $rowCase['Title']; ?>" disabled="true">  
                            </div>
                        </div>
                        
                        
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="casetime">案例时间</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="casetime" name="casetime" class="form-control input-sm"
                                    data-required="true" value="<?php echo $rowCase['Time']; ?>" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">主刀医生 : </label>        
                            </div>
                            
                            <div class="col-sm-2">
                                <select class="form-control" id="doctorid" name="doctorid" disabled="true">
                                    <?php
                                        foreach ($rowDoctor as $value) {
                                            if ($value['id'] == $rowCase['Doctor_Id'])
                                            {
                                    ?>
                                                <option value="<?php echo $value['id'];?>"><?php echo $value['Doctor_Name'];?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="content">案例介绍 : </label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="introduction" id="introduction" rows="10" cols="80" value="">
                                    <?php echo str_replace("\n", "", $rowCase['Introduction']); ?>
                                </textarea>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    <div class="form-group form-md-line-input form-md-floating-label"><div class="row">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="content">排序 : </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="sort" name="sort" class="form-control input-sm"
                                    data-required="true" value="<?php echo $rowCase['Sort']; ?>" disabled="true">
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
    CKEDITOR.editorConfig = function (config) {
       config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('introduction');

    function back() {
        window.location.href = "case.php";
    }
</script>
</body>
</html>
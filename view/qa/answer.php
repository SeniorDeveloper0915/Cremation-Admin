<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);

    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $qaId = $_COOKIE['qa_id'];

    $qaData = $db->prepare('SELECT * FROM qa WHERE id=?');
    $qaData->execute(array($qaId));
    $rowQa = $qaData->fetch(PDO::FETCH_ASSOC);

    $firstData = $db->prepare('SELECT Project_Name FROM first_project WHERE id = ?');
    $firstData->execute(array($rowQa['First_Project_Id']));
    $firstProject = $firstData->fetch(PDO::FETCH_ASSOC);

    $secondData = $db->prepare('SELECT Project_Name FROM second_project WHERE id = ?');
    $secondData->execute(array($rowQa['Second_Project_Id']));
    $secondProject = $secondData->fetch(PDO::FETCH_ASSOC);

    $thirdData = $db->prepare('SELECT Project_Name FROM project WHERE id = ?');
    $thirdData->execute(array($rowQa['Third_Project_Id']));
    $thirdProject = $thirdData->fetch(PDO::FETCH_ASSOC);

    $doctorData = $db->prepare('SELECT * FROM doctor');
    $doctorData->execute();
    $rowDoctor = $doctorData->fetchAll();
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

    <title>回答管理</title>
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
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="row">
                        <div class="col-sm-1">
                            <label for="phonenumber">提问用户 : </label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="phonenumber" name="phonenumber" class="form-control input-sm" data-required="true"
                                value="<?php echo $rowQa['PhoneNumber'] ?>" disabled="true">        
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input ">
                    <div class="row">
                        <div class="col-sm-1">
                            <label for="project">提问项目 : </label>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="first" name="first" class="form-control input-sm"
                                data-required="true" value="<?php echo $firstProject['Project_Name'] ?>" disabled="true" style="text-align: center;">
                        </div>
                        
                        <div class="col-sm-3">
                            <input type="text" id="second" name="second" class="form-control input-sm"
                                data-required="true" value="<?php echo $secondProject['Project_Name'] ?>" disabled="true" style="text-align: center;">
                        </div>

                        <div class="col-sm-3">
                            <input type="text" id="third" name="third" class="form-control input-sm"
                                data-required="true" value="<?php echo $thirdProject['Project_Name'] ?>" disabled="true" style="text-align: center;">
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="row">
                        <div class="col-sm-1">
                            <label for="qtitle">提问标题 : </label>        
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="qtitle" name="qtitle" class="form-control input-sm" data-required="true"
                                value="<?php echo $rowQa['Question_Title'] ?>" disabled="true">        
                        </div>
                    </div>
                </div>
                
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="row">
                        <div class="col-sm-1">
                            <label for="qcontent">问题内容 : </label>        
                        </div>
                        <div class="col-sm-9">
                            <textarea id="qcontent" name="qcontent" class="form-control input-sm" data-required="true"
                                value="" placeholder="请输入项目简介" cols="40" rows="5" disabled="true"> <?php echo $rowQa['Question_Content'] ?> </textarea>        
                        </div>
                    </div>
                </div>

                <hr style="border-top: 2px dashed red;"></hr>
                <form id="answer" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $rowQa['id'] ?>">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">答复医生 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="doctorid" name="doctorid">
                                    <?php
                                        foreach ($rowDoctor as $value) {
                                    ?>
                                            <option value="<?php echo $value['id'];?>"><?php echo $value['Doctor_Name'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="content">资讯内容 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <textarea name="content" id="content" rows="10" cols="80" value="">

                                </textarea>        
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
                    <button type="submit" class="btn green btn-outline" name="submit" onclick="answer();return false">保存</button>
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
<script src="//cdn.gaic.com/cdn/ui-bootstrap/0.58.0/js/lib/ckeditor/ckeditor.js"></script>
<script>
    
    CKEDITOR.editorConfig = function (config) {
       config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('content');

    function back() {
        window.location.href = "qa.php";
    }

    function answer() {

        if (document.getElementById('doctorid').value == "") {
            window.alert("Select Doctor");
            return false;
        }

        if (CKEDITOR.instances.content.getData() == "") {
            window.alert("Input Answer Content");
            return false;
        }
        
        $.easyAjax({
            type: "POST",
            url: "../../ajax/qa/answer.php",
            container: "#answer",
            data : {
                content : CKEDITOR.instances.content.getData()
            },

            file:true,
            success: function(response) {
                if (response.status == "success") {
                    console.log("Success");
                    window.location.href = "qa.php";
                }
            }
        });
    }
</script>
</body>
</html>
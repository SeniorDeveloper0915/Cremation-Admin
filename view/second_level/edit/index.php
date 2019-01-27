<?php
    session_start();
    include '../../../config/index.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }
    
    $projectId = $_COOKIE['project_id'];

    $projectData = $db->prepare('SELECT * FROM second_project WHERE id=?');
    $projectData->execute(array($projectId));
    $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

    $getFirsts = $db->prepare("SELECT * FROM first_project ORDER BY id ASC");
    $getFirsts->execute();
    $firstProjects = $getFirsts->fetchAll();

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
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-pencil font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">整形项目管理</span>
                    </div>
                </div>
                <form id="projectUpdate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="hidden" name="id" value="<?php echo $rowProject['id'] ?>">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectname">一级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="firstid" name="firstid">
                                                <?php
                                                    foreach ($firstProjects as $value) {
                                                        if ($value['id'] == $rowProject['First_Project_Id'])
                                                        {
                                                ?>
                                                            <option value="<?php echo $value['id'];?>" selected><?php echo $value['Project_Name'];?></option>
                                                <?php
                                                        } else if ($value['id'] != $rowProject['First_Project_Id'])
                                                        {
                                                ?>
                                                            <option value="<?php echo $value['id'];?>"><?php echo $value['Project_Name'];?></option>
                                                <?php
                                                        }
                                                    }
                                                ?>
                                            </select>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectname">一级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="projectname" name="projectname" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowProject['Project_Name'] ?>">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="sort">排序</label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="number" id="sort" name="sort" class="form-control input-sm"
                                                data-required="true" value="<?php echo $rowProject['Sort'] ?>" min="1" max="100">        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline" onclick="back();">返回</button>
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="updateProject();return false">保存</button>
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
    function updateProject() {
        $.easyAjax({
            type: "POST",
            url: "../../../ajax/second_level/edit/index.php",
            container: "#projectUpdate",
            file:true,
            success: function(response) {
                if (response.status == "success") {
                    window.location.href = "../table/index.php";
                }
            }
        });
    }

    function back() {
        window.location.href = "../table/index.php";
    }
</script>
</body>
</html>
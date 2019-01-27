<?php
    session_start();
    include '../../../config/index.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }
    
    $projectId = $_COOKIE['project_id'];

    $getFirsts = $db->prepare("SELECT * FROM first_project ORDER BY id ASC");
    $getFirsts->execute();
    $firstProjects = $getFirsts->fetchAll();

    $getSeconds = $db->prepare('SELECT * FROM second_project ORDER BY id ASC');
    $getSeconds->execute();
    $secondProjects = $getSeconds->fetchAll();

    $projectData = $db->prepare('SELECT * FROM project WHERE id=?');
    $projectData->execute(array($projectId));
    $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

    $beforeimg = file_exists("../../../images/project/".$rowProject['Before_Img']);
    $effectimg = file_exists("../../../images/project/".$rowProject['Effect_Img']);

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
                <form id="bannerUpdate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectname">一级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="firstid" name="firstid" disabled="" disabled="true">
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
                                            <label for="projectname">二级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="secondid" name="secondid" disabled="true">
                                                <?php
                                                    foreach ($secondProjects as $value) {
                                                        if ($value['id'] == $rowProject['Second_Project_Id'])
                                                        {
                                                ?>
                                                            <option value="<?php echo $value['id'];?>" selected><?php echo $value['Project_Name'];?></option>
                                                <?php
                                                        } else if ($value['id'] != $rowProject['Second_Project_Id'])
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
                                            <label for="projectname">三级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="projectname" name="projectname" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowProject['Project_Name'] ?>" disabled="true">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectalias">三级项目别名 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" id="projectalias" name="projectalias" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowProject['Project_Alias'] ?>" disabled="true">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label>项目封面图 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="fileinput fileinput-new">
                                                <div class="fileinput-new thumbnail" >
                                                    <img  src='<?php echo ($beforeimg == 1) ? ("../../../images/project/".$rowProject['Before_Img']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' style="width: 200px; height: 150px;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label>效果展示图 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="fileinput fileinput-new">
                                                <div class="fileinput-new thumbnail" >
                                                    <img  src='<?php echo ($effectimg == 1) ? ("../../../images/project/".$rowProject['Effect_Img']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' style="width: 200px; height: 150px;" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="description">项目简介 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="description" name="description" class="form-control input-sm"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Description'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="features">项目特色 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="features" name="features" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Features'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="efficiency">项目功效 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="efficiency" name="efficiency" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Efficiency'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="proposedprice">参考价格 : </label>        
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" id="proposedfrom" name="proposedfrom" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowProject['Proposed_From'] ?>" step="any" disabled="true">        
                                        </div>
					                    <div class="col-sm-1" style="text-align : center;">
						                    <span> ~ </span>
					                    </div>
					                    <div class="col-sm-4">
                                            <input type="text" id="proposeto" name="proposedto" class="form-control input-sm" data-required="true"
                                                value="<?php echo $rowProject['Proposed_To'] ?>" step="any" disabled="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="timeperiod">时间周期 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="timeperiod" name="timeperiod" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Time_Period'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="aesthetic">美学标准 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="aesthetic" name="aesthetic" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Aesthetic_standard'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="advantages">项目优点 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="advantages" name="advantages" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Advantages'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="shortcoming">项目缺点 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="shortcoming" name="shortcoming" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Shortcoming'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="suitable">适合人群 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="suitable" name="suitable" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Suitable'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="warning">风险提示 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="warning" name="warning" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Risk_Warning'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="precautions">术前准备注意事项 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="precautions" name="precautions" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Pre_Precautions'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="considerations">术后护理注意事项 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="considerations" name="considerations" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Care_considerations'] ?> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="treatment">副作用及处理 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="treatment" name="treatment" class="form-control input-sm" data-required="true"
                                                cols="40" rows="5" disabled="true"> <?php echo $rowProject['Effects_Treatment'] ?> </textarea>        
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
                                                data-required="true" value="<?php echo $rowProject['Sort'] ?>" disabled>        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline" onclick="back();">返回</button>
                    </div>
                </form>
            </div>
        </div>
    </form>
</div>
<?php include '../../../include/footer/index.php' ?>
<?php include '../../../include/footerjs/index.php' ?>
<script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
<script src="../../../assets/plugins/froiden-helper/helper.js" type="text/javascript"></script>
<script>
    function back() {
        window.location.href = "../table/index.php";
    }
</script>
</body>
</html>

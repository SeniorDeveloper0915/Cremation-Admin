<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $getFirsts = $db->prepare("SELECT * FROM first_project ORDER BY id ASC");
    $getFirsts->execute();
    $firstProjects = $getFirsts->fetchAll();

    $getSeconds = $db->prepare("SELECT * FROM second_project ORDER BY id ASC");
    $getSeconds->execute();
    $secondProjects = $getSeconds->fetchAll();
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
            <div class="portlet light bordered" class="col-md-10">
                <div class="portlet-title">
                    <div class="caption font-green" style="width: 100%;">
                        <i class="icon-user-follow font-green"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <span class="caption-subject bold uppercase">添加三级项目</span>
                    </div>
                </div>

                <form id="projectCreate" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="projectname">一级项目名称 : </label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="firstid" name="firstid">
                                                <?php
                                                    foreach ($firstProjects as $value) {
                                                ?>
                                                        <option value="<?php echo $value['id'];?>"><?php echo $value['Project_Name'];?></option>
                                                <?php
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
                                            <select class="form-control" id="secondid" name="secondid">
                                                <?php
                                                    foreach ($secondProjects as $value) {
                                                ?>
                                                        <option value="<?php echo $value['id'];?>"><?php echo $value['Project_Name'];?></option>
                                                <?php
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
                                                value="" placeholder="请输入三级项目名称">        
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
                                                value="" placeholder="请输入三级项目别名">        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label>项目封面图 : </label>        
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
                                                    <input type="file" name="beforeimg" id="beforeimg"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> 去掉 </a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                注：最多1张，请注意您上传的图片尺寸，4:3
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
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    <img src="" alt="" /> </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> 
                                                </div>
                                                <div>
                                                    <span class="btn btn-outline green btn-file">
                                                    <span class="fileinput-new"> 上传图片 </span>
                                                    <span class="fileinput-exists"> 更改 </span>
                                                    <input type="file" name="effectimg" id="effectimg"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> 去掉 </a>
                                                </div>
                                            </div>
                                            <div class="clearfix margin-top-10">
                                                注：最多1张，请注意您上传的图片尺寸，5:2
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
                                            <textarea id="description" name="description" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请输入项目简介" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目特色" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目功效" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目参考价格" step="any">        
                                        </div>
					<div class="col-sm-1" style="text-align : center;">
						<span>~</span>
					</div>
					<div class="col-sm-4">
                                            <input type="text" id="proposedto" name="proposedto" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请?~S?~E?项?~[??~O~B?~@~C价?| ?" step="any">
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
                                                value="" placeholder="请输入项目时间周期" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目美学标准" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目优点" cols="40" rows="5"> </textarea>        
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <label for="shortcoming">项目缺点</label>        
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea id="shortcoming" name="shortcoming" class="form-control input-sm" data-required="true"
                                                value="" placeholder="请输入项目缺点" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目适合人群" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入项目风险" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入术前准备注意事项" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入术后护理注意事项" cols="40" rows="5"> </textarea>        
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
                                                value="" placeholder="请输入副作用及处理" cols="40" rows="5"> </textarea>        
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
                                                data-required="true" value="" placeholder="请输入排序码 (注：数字越高，展示越靠前（最大值99))" min="1" max="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline" onclick="back();">返回</button>
                        <button type="submit" class="btn green btn-outline" name="submit" onclick="createProject();return false">保存</button>
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
        window.location.href = "project.php";
    }

    function createProject() {

        if (document.getElementById('firstid').value == "") {
            window.alert("Select First Level Project");
            return false;
        }

        if (document.getElementById('secondid').value == "") {
            window.alert("Select Second Level Project");
            return false;
        }

        if (document.getElementById('projectname').value == "") {
            window.alert("Input Project Name");
            return false;
        }

        if (document.getElementById('projectalias').value == "") {
            window.alert("Input Project Alias");
            return false;
        }

        if (document.getElementById('beforeimg').value == "") {
            window.alert("Select Before Image");
            return false;
        }

        if (document.getElementById('effectimg').value == "") {
            window.alert("Select Effect Image");
            return false;
        }

        if (document.getElementById('description').value == "") {
            window.alert("Input Project Description");
            return false;
        }

        if (document.getElementById('features').value == "") {
            window.alert("Input Project Features");
            return false;
        }

        if (document.getElementById('efficiency').value == "") {
            window.alert("Input Project Efficiency");
            return false;
        }

        if (document.getElementById('proposedprice').value == "") {
            window.alert("Input Proposed Price");
            return false;
        }

        if (document.getElementById('timeperiod').value == "" ) {
            window.alert("Input Time Period");
            return false;
        }

        if (document.getElementById('aesthetic').value == "") {
            window.alert("Input Aesthetic Standard");
            return false;
        }

        if (document.getElementById('advantages').value == "") {
            window.alert("Input Project Advantages");
            return false;
        }

        if (document.getElementById('shortcoming').value == "") {
            window.alert("Input Short Coming");
            return false;
        }

        if (document.getElementById('suitable').value == "") {
            window.alert("Input Project Suitable");
            return false;
        }

        if (document.getElementById('warning').value == "") {
            window.alert("Input Risk Warning");
            return false;
        }

        if (document.getElementById('precautions').value == "") {
            window.alert("Input Project Precautions");
            return false;
        }

        if (document.getElementById('considerations').value == "") {
            window.aert("Input Project Care Considerations");
            return false;
        }

        if (document.getElementById('treatment').value == "") {
            window.alert("Input Effect Treatment");
            return false;
        }

        if (document.getElementById('sort').value == "") {
            window.alert("Input Sort");
            return false;
        }

        if (document.getElementById('sort').value > 100) {
            window.alert('Sort Range is 1 to 100');
            return false;
        }
        
        $.easyAjax({
            url: "../../ajax/third_level/add_project.php",
            type: "POST",
            container: "#projectCreate",
            file:true,
            success: function(response) {
                if (response.status == "success") {
                    window.location.hef = "project.php";
                }
            }
        });
    }
</script>
</body>
</html>

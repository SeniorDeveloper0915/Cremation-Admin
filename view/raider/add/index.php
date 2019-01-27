<?php
    session_start();
    include '../../../config/index.php';
    error_reporting(0);
    $msg = "";

    if (!isset($_SESSION['admin'])) {
        header('location:../../../index.php');
    }

    $getCategory = $db->prepare("SELECT * FROM raider_category ORDER BY id ASC");
    $getCategory->execute();
    $rowCategory = $getCategory->fetchAll();

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
            <form id="raiderCreate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">攻略类别 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" id="categoryid" name="categoryid">
                                    <?php
                                        foreach ($rowCategory as $value) {
                                    ?>
                                            <option value="<?php echo $value['id'];?>"><?php echo $value['Category_Name'];?></option>
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
                                <label for="title">攻略标题 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="title" name="title" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入攻略标题">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="sectitle">攻略二级标题 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="sectitle" name="sectitle" class="form-control input-sm"
                                    data-required="true" value="" placeholder="请输入攻略二级标题">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label>攻略封面图 : </label>        
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
                                        <input type="file" name="raiderimg" id="raiderimg"> </span>
                                        <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> 去掉 </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    注：最多1张，请注意您上传的图片尺寸，11*11
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="content">攻略内容 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <textarea name="content" id="content" rows="10" cols="80" value="">
                            
                                </textarea>        
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
                                    data-required="true" value="" placeholder="请输入排序码 (注：数字越高，展示越靠前（最大值99))" min="1" max="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
                    <button type="submit" class="btn green btn-outline" name="submit" onclick="createRaider();return false">保存</button>
                </div>
            </form>
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

    function createRaider() {

        if (document.getElementById('categoryid').value == "") {
            window.alert("Select Raider Category");
            return false;
        }

        if (document.getElementById('title').value == "") {
            window.alert("Input Raider Title");
            return false;
        }

        if (document.getElementById('sectitle').value == "") {
            window.alert("Input Raider Second Title");
            return false;
        }

        if (document.getElementById('raiderimg').value == "") {
            window.alert("Select Raider Image");
            return false;
        }

        if (CKEDITOR.instances.content.getData() == "") {
            window.alert("Input Raider Content");
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
            url: "../../../ajax/raider/add/index.php",
            type: "POST",
            container: "#raiderCreate",
            data : {
                content : CKEDITOR.instances.content.getData()
            },
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
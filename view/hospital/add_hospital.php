<?php
    session_start();
    include '../../config/config.php';
    error_reporting(0);
    $msg = "";

    if (!isset($_SESSION['admin'])) {
        header('location:../../index.php');
    }

    $getFirsts = $db->prepare("SELECT * FROM first_project ORDER BY id ASC");
    $getFirsts->execute();
    $firstProjects = $getFirsts->fetchAll();

    $getSeconds = $db->prepare("SELECT * FROM second_project ORDER BY id ASC");
    $getSeconds->execute();
    $secondProjects = $getSeconds->fetchAll();

    $getThird = $db->prepare("SELECT * FROM project ORDER BY id ASC");
    $getThird->execute();
    $thirdProjects = $getThird->fetchAll();

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
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
        }
        th {
            text-align: center;
        }
    </style>
    <?php include '../../include/css/global.php' ?>
</head>

</style>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
<?php include '../../include/header.php'; ?>
<div class="page-container">
    <?php include '../../include/sidebar.php'; ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <form id="hospitalCreate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="name">医院名称 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院名称">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label>医院LOGO : </label>
                            </div>
                            <div class="col-sm-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="" alt="" /> </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> 
                                    </div>
                                    <div>
                                        <span class="btn btn-outline green btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="logoimg" id="logoimg"> </span>
                                        <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    注：最多1张，请注意您上传的图片尺寸，1：1
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label>医院宣传照 : </label>
                            </div>
                            <div class="col-sm-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img src="" alt="" /> </div>
                                    <div id="fileinput-preview"> 
                                    </div>
                                    <div>
                                        <span class="btn btn-outline green btn-file">
                                            <span class="fileinput-new"> Select image </span>
                                            <span class="fileinput-exists" onclick="change();return false"> Change </span>
                                            <input type="file" name="publicityimgs[]" id="publicityimgs" multiple="" onchange="preview_images()"> 
                                        </span>
                                        <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput" onclick="remove();"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    注：最多4张，请注意您上传的图片尺寸，1：1
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="slogan">医院标语 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="slogan" name="slogan" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院标语">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="qualification">医院资质 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="qualification" name="qualification" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院资质">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="level">医院等级 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="level" name="level" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院等级">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="license">医疗许可证号 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="license" name="license" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院医疗许可证号">        
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="address">医院地址 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="address" name="address" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院地址">        
                            </div>
                        </div>
                    </div>
                     
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">服务项目 : </label>        
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="firstid" name="firstid" onchange="selFirst(this.value);">
                                    <?php
                                        foreach ($firstProjects as $value) {
                                    ?>
                                            <option value="<?php echo $value['id'];?>" data-option="<?php echo $value['id'];?>"><?php echo $value['Project_Name'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="secondid" name="secondid" onchange="selSecond(this.value);">
                                    <?php
                                        foreach ($secondProjects as $value) {
                                    ?>
                                            <option value="<?php echo $value['id'];?>" data-option="<?php echo $value['First_Project_Id'];?>" data-id="<?php echo $value['id'];?>"><?php echo $value['Project_Name'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" id="thirdid" name="thirdid" onchange="selThird(this.value);">
                                    <?php
                                        foreach ($thirdProjects as $value) {
                                    ?>
                                            <option value="<?php echo $value['id'];?>" data-option="<?php echo $value['First_Project_Id'];?>" data-id="<?php echo $value['Second_Project_Id'];?>"><?php echo $value['Project_Name'];?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a href="javascript:;" onclick="addService();" class="btn btn-outline green btn-sm" id="addservice">+</a>&nbsp
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-1">
                                
                            </div>
                            <div class="col-sm-9" style="overflow-x: auto; height: 250px;">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>指数</th>
                                            <th>一级项目</th>
                                            <th>二级项目</th>
                                            <th>三级项目</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listservice" style="text-align: center; overflow: auto; overflow-x: hidden; height: 150px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">医院团队 : </label>        
                            </div>
                            
                            <div class="col-sm-2">
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
                            <div class="col-sm-2">
                                <a href="javascript:;" onclick="addDoctor();" class="btn btn-outline green btn-sm">+</a>&nbsp
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-sm-1">
                                
                            </div>
                            <div class="col-sm-9" style="overflow-x: auto; height: 150px;">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th>指数</th>
                                            <th>医生名称</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody id="listdoctor" style="text-align: center; overflow: auto; overflow-x: hidden; height: 150px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="introduction">医院简介 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <textarea id="introduction" name="introduction" class="form-control input-sm" data-required="true"
                                    value="" placeholder="请输入医院简介" cols="40" rows="5"> </textarea>
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
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
                    <button type="submit" class="btn green btn-outline" name="submit" onclick="createHospital();return false">保存</button>
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
    var services;
    var doctors;
    var first   = document.querySelector('#firstid');
    var second  = document.querySelector('#secondid');
    var third   = document.querySelector('#thirdid');
    var firstoptions = first.querySelectorAll('option');
    var secondoptions = second.querySelectorAll('option');
    var thirdoptions = third.querySelectorAll('option');
    $(document).ready(function () {
        services = new Array();
        doctors = new Array();
    });

    CKEDITOR.editorConfig = function (config) {
       config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('content');
    
    function createHospital() {

        if (document.getElementById('name').value == "") {
            window.alert("Input Hospital Name");
            return false;
        }

        if (document.getElementById('logoimg').value == "") {
            window.alert("Select Hospital Logo Image");
            return false;
        }

        if (document.getElementById('publicityimgs').value == "") {
            window.alert("Select Hospital Publicity Images");
            return false;
        }

        if (document.getElementById('slogan').value == "") {
            window.alert("Input Hospital Slogan");
            return false;
        }

        if (document.getElementById('qualification').value == "") {
            window.alert("Input Hospital Qualification");
            return false;
        }

        if (document.getElementById('level').value == "") {
            window.alert("Input Hospital Level");
            return false;
        }

        if (document.getElementById('license').value == "") {
            window.alert("Input Hospital License");
            return false;
        }

        if (document.getElementById('address').value == "") {
            window.alert("Input Hospital Address");
            return false;
        }

        if (document.getElementById('introduction').value == "") {
            window.alert("Input Hospital Introduction");
            return false;
        }

        if (document.getElementById('sort').value == "") {
            window.alert("Input Hospital Sort");
            return false;
        }

        if (document.getElementById('sort').value > 100) {
            window.alert("Sort Range is 1 to 100");
            return false;
        }

        if (services.length == 0) {
            window.alert("Select Hospital Services");
            return false;
        }

        if (doctors.length == 0) {
            window.alert("Select Hospital Doctor!");
            return false;
        }
        
        $.easyAjax({
            url: "../../ajax/hospital/add_hospital.php",
            type: "POST",
            container: "#hospitalCreate",
            data : {
                services : JSON.stringify(services),
                doctors  : JSON.stringify(doctors)
            },
            file:true,
            success: function(response) {
                if (response.status == "success") {
                    window.location.href = "hospital.php";
                }
            }
        });
    }

    function back() {
        window.location.href = "hospital.php";
    }

    function preview_images() 
    {
        if($("#publicityimgs")[0].files.length != 4) {
            alert("You must select 4 images");
        } else {
            var total_file=document.getElementById("publicityimgs").files.length;
            $('#fileinput-preview').html("");
            for(var i = 0;i < total_file;i ++)
            {
                $('#fileinput-preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' " + "style='width:200px;height:150px;'" + ">" +"&nbsp");
            }
        }
    }

    function remove() {
        // body...
        $('#fileinput-preview').html("");
    }

    function change() {
        // body...
        console.log("Change");
        $('#fileinput-preview').html("");
    }

    function findFirstName(projectId) {
        var firstProjects = <?php echo json_encode($firstProjects); ?>;
        for (var i = 0; i < firstProjects.length; i ++) {
            if (firstProjects[i][0] == projectId)
                return firstProjects[i][1];
        }
    }

    function findSecondName(projectId) {
        var secondProjects = <?php echo json_encode($secondProjects); ?>;
        for (var i = 0; i < secondProjects.length; i ++) {
            if (secondProjects[i][0] == projectId)
                return secondProjects[i][2];
        }
    }

    function findThirdName(projectId) {
        var thirdProjects = <?php echo json_encode($thirdProjects); ?>;
        for (var i = 0; i < thirdProjects.length; i ++) {
            if (thirdProjects[i][0] == projectId)
                return thirdProjects[i][3];
        }
    }

    function removeService(idx) {
        services = services.slice(0); // make copy
        services.splice(idx, 1);
        document.getElementById('listservice').innerHTML = "";
        displayService();
    }

    function displayService() {
        var html = "";
        for (var i = 0; i < services.length; i ++) {
            var firstName = findFirstName(services[i][0]);
            var secondName = findSecondName(services[i][1]);
            var thirdName = findThirdName(services[i][2]);
            html = html + ('<tr><td>' + (i + 1) + '</td><td>' + firstName + '</td><td>' + secondName + '</td><td>' + thirdName +'</td><td>' + '<a href="javascript:;" onclick="removeService(' + i + ')" class="btn btn-outline black btn-sm">删除</a>' + '</td></tr>');
            document.getElementById('listservice').innerHTML = html;
        } 
    }

    function addService() {
        // body...
        var idx = services.length;
        var j;
        for (j = 0; j < idx; j ++) {
            if (services[j][0] == document.getElementById('firstid').value && services[j][1] == document.getElementById('secondid').value && services[j][2] == document.getElementById('thirdid').value)
            {
                alert("You have already selected this project!");
                break;
            }                
        }
        if (j == idx) {
            document.getElementById('listservice').innerHTML = "";
            services[idx] = new Array(3);
            services[idx][0] = document.getElementById('firstid').value;
            services[idx][1] = document.getElementById('secondid').value;
            services[idx][2] = document.getElementById('thirdid').value;
            displayService();
        }
    }

    function findDoctorName(doctorId) {
        var doctorList = <?php echo json_encode($rowDoctor); ?>;
        for (var i = 0; i < doctorList.length; i ++) {
            if (doctorList[i][0] == doctorId)
                return doctorList[i][1];
        }
    }

    function removeDoctor(idx) {
        doctors.splice(idx, 1);
        console.log(doctors);
        document.getElementById('listdoctor').innerHTML = "";
        displayDoctor();
    }

    function displayDoctor() {
        var html = "";
        for (var i = 0; i < doctors.length; i ++) {
            var doctorName = findDoctorName(doctors[i]);
            html = html + ('<tr><td>' + (i + 1) + '</td><td>' + doctorName + '</td><td>' + '<a href="javascript:;" onclick="removeDoctor(' + i + ')" class="btn btn-outline black btn-sm">删除</a>' + '</td></tr>');
            document.getElementById('listdoctor').innerHTML = html;
        } 
    }

    function addDoctor() {
        // body...
        var idx = doctors.length;
        var j;
        for (j = 0; j < idx; j ++) {
            if (doctors[j] == document.getElementById('doctorid').value)
            {
                alert("You have already selected this doctor!");
                break;
            }                
        }
        if (j == idx) {
            document.getElementById('listdoctor').innerHTML = "";
            doctors[idx] = document.getElementById('doctorid').value;
            displayDoctor();
        }        
    }

    function selFirst(value) {
        // body...
        var secondCnt = 0, thirdCnt = 0;    
        second.innerHTML = '';
        for(var i = 0; i < secondoptions.length; i++) {
            if(secondoptions[i].dataset.option == value) {
                second.appendChild(secondoptions[i]);
                secondCnt ++;
            }
        }

        third.innerHTML = '';
        for(var i = 0; i < thirdoptions.length; i++) {
            if(thirdoptions[i].dataset.option == value) {
                third.appendChild(thirdoptions[i]);
                thirdCnt ++;
            }
        }

        if (secondCnt == 0 || thirdCnt == 0) {
            document.getElementById('addservice').classList.add("disabled");
        } else {
            document.getElementById('addservice').classList.remove("disabled");
        }
    }

    function selSecond(value) {
        // body...
        var thirdCnt = 0;
        third.innerHTML = '';
        for(var i = 0; i < thirdoptions.length; i++) {
            if(thirdoptions[i].dataset.id == value) {
                third.appendChild(thirdoptions[i]);
                thirdCnt ++;
            }
        }
        if (thirdCnt == 0) {
            document.getElementById('addservice').classList.add("disabled");
        } else {
            document.getElementById('addservice').classList.remove("disabled");
        }

    }
    selFirst(firstid.value);

</script>
</body>
</html>
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

    $getTitle = $db->prepare("SELECT * FROM doctor_title ORDER BY id ASC");
    $getTitle->execute();
    $rowTitle = $getTitle->fetchAll();    

    $getNation = $db->prepare("SELECT * FROM nation ORDER BY id ASC");
    $getNation->execute();
    $rowNation = $getNation->fetchAll();    

    $doctorId = $_COOKIE['doctor_id'];
    $getSkills = $db->prepare("SELECT * FROM skill where Doctor_Id = ?");
    $getSkills->execute(array($doctorId));
    $rowSkills = $getSkills->fetchAll();

    $doctorData = $db->prepare('SELECT * FROM doctor WHERE id = ?');
    $doctorData->execute(array($doctorId));
    $rowDoctor = $doctorData->fetch(PDO::FETCH_ASSOC);
    $doctorimg = file_exists("../../images/doctor/".$rowDoctor['Photo']);
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
            <form id="doctorUpdate" enctype="multipart/form-data">
                <div class="portlet light bordered">
                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="name">医生名称 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="id" value="<?php echo $rowDoctor['id'] ?>">
                                <input type="text" id="name" name="name" class="form-control input-sm" data-required="true"
                                    value='<?php echo $rowDoctor["Doctor_Name"] ?>'>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">医生职称 : </label>        
                            </div>
                            
                            <div class="col-sm-2">
                                <select class="form-control" id="titleid" name="titleid">
                                    <?php
                                        foreach ($rowTitle as $title) {
                                                # code...
                                            if ($title['id'] == $rowDoctor['Title_id'])
                                            {
                                    ?>
                                                <option value="<?php echo $title['id'];?>" selected><?php echo $title['Doctor_Title'];?></option>
                                    <?php
                                            }
                                            else {
                                    ?>
                                                <option value="<?php echo $title['id'];?>"><?php echo $title['Doctor_Title'];?></option>       
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
                                <label>医生照片 : </label>
                            </div>
                            <div class="col-sm-9">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img  src='<?php echo ($doctorimg == 1) ? ("../../images/doctor/".$rowDoctor['Photo']) : "https://via.placeholder.com/125x125?text=上传图片"; ?>' alt="上传图片"/>
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> 
                                    </div>
                                    <div>
                                        <span class="btn btn-outline green btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="doctorimg" id="doctorimg"> </span>
                                        <a href="javascript:;" class="btn default fileinput-exists btn-outline" data-dismiss="fileinput"> Remove </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                    注：最多1张，请注意您上传的图片尺寸，1：1
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="slogan">执业年限 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="number" id="length" name="length" class="form-control input-sm" data-required="true"
                                    value='<?php echo $rowDoctor["Length"] ?>'>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="number">资格证号 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <input type="text" id="number" name="number" class="form-control input-sm" data-required="true"
                                    value='<?php echo $rowDoctor["Certi_Number"] ?>'>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-md-line-input form-md-floating-label">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="projectname">所在地址 : </label>        
                            </div>
                            
                            <div class="col-sm-2">
                                <select class="form-control" id="nationid" name="nationid">
                                    <?php
                                        foreach ($rowNation as $nation) {
                                                # code...
                                            if ($nation['id'] == $rowDoctor['Address'])
                                            {
                                    ?>
                                                <option value="<?php echo $nation['id'];?>" selected><?php echo $nation['Nation_Name'];?></option>
                                    <?php
                                            }
                                            else {
                                    ?>
                                                <option value="<?php echo $nation['id'];?>"><?php echo $nation['Nation_Name'];?></option>       
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
                                <label for="projectname">擅长项目 : </label>        
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
                                <select class="form-control" id="thirdid" name="thirdid">
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
                                <a href="javascript:;" onclick="addSkill();" class="btn btn-outline green btn-sm" id="addskill">+</a>&nbsp
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
                                    <tbody id="listskill" style="text-align: center; overflow: auto; overflow-x: hidden; height: 150px;">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <label for="content">医生简介 : </label>        
                            </div>
                            <div class="col-sm-9">
                                <textarea name="profile" id="profile" rows="10" cols="80" value="">
                                    <?php echo str_replace("\n", "", $rowDoctor['Profile']); ?>
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
                                    data-required="true" value='<?php echo $rowDoctor["Sort"] ?>' min="1" max="100">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" onclick="back();return false">返回</button>
                    <button type="submit" class="btn green btn-outline" name="submit" onclick="editDoctor();return false">保存</button>
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
    var skill;
    var first   = document.querySelector('#firstid');
    var second  = document.querySelector('#secondid');
    var third   = document.querySelector('#thirdid');
    var firstoptions = first.querySelectorAll('option');
    var secondoptions = second.querySelectorAll('option');
    var thirdoptions = third.querySelectorAll('option');

    CKEDITOR.editorConfig = function (config) {
       config.extraPlugins = 'confighelper';
    };
    CKEDITOR.replace('profile');


//    $(document).ready(function () {
        skill = new Array();
        var rowSkills = <?php echo json_encode($rowSkills); ?>;
	console.log(rowSkills);
        for (var i = 0; i < rowSkills.length; i ++) {
            skill[i] = new Array();
            skill[i][0] = rowSkills[i][2]
            skill[i][1] = rowSkills[i][3]
            skill[i][2] = rowSkills[i][4]
        }
        displaySkill();
  //  });

    function editDoctor() {
            // Send ajax Request to ajax/add_user.php  to create a user
	console.log(JSON.stringify(skill));
            $.easyAjax({
                url: "../../ajax/doctor/edit_doctor.php",
                type: "POST",
                container: "#doctorUpdate",
                data : {
                    skill    : JSON.stringify(skill),
                    profile  : CKEDITOR.instances.profile.getData()
                },
                file:true,
                success: function(response) {
                    if (response.status == "success") {
                        window.location.href = "doctor.php";
                    }
                }
            });
    }

    function back() {
        window.location.href = "doctor.php";
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

    function removeSkill(idx) {
        console.log(idx);
        skill = skill.slice(0); // make copy
        skill.splice(idx, 1);
        document.getElementById('listskill').innerHTML = "";
        displaySkill();
    }

    function displaySkill() {
        var html = "";
        for (var i = 0; i < skill.length; i ++) {
            var firstName = findFirstName(skill[i][0]);
            var secondName = findSecondName(skill[i][1]);
            var thirdName = findThirdName(skill[i][2]);
            html = html + ('<tr><td>' + (i + 1) + '</td><td>' + firstName + '</td><td>' + secondName + '</td><td>' + thirdName +'</td><td>' + '<a href="javascript:;" onclick="removeSkill(' + i + ')" class="btn btn-outline black btn-sm">删除</a>' + '</td></tr>');
            document.getElementById('listskill').innerHTML = html;
        } 
    }

    function addSkill() {
        // body...
        var idx = skill.length;
        var j;
        for (j = 0; j < idx; j ++) {
            if (skill[j][0] == document.getElementById('firstid').value && skill[j][1] == document.getElementById('secondid').value && skill[j][2] == document.getElementById('thirdid').value)
            {
                alert("You have already selected this project!");
                break;
            }                
        }
        if (j == idx) {
            displaySkill();
            document.getElementById('listskill').innerHTML = "";
            skill[idx] = new Array(3);
            skill[idx][0] = document.getElementById('firstid').value;
            skill[idx][1] = document.getElementById('secondid').value;
            skill[idx][2] = document.getElementById('thirdid').value;
            displaySkill();
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
            document.getElementById('addskill').classList.add("disabled");
        } else {
            document.getElementById('addskill').classList.remove("disabled");
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
            document.getElementById('addskill').classList.add("disabled");
        } else {
            document.getElementById('addskill').classList.remove("disabled");
        }

    }
    selFirst(firstid.value);

</script>
</body>
</html>

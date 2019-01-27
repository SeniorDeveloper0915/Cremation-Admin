<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];
    $input = [];

    $input = [];
    $input['firstid']           = post('firstid');
    $input['secondid']          = post('secondid');
    $input['projectname']       = post('projectname');
    $input['projectalias']      = post('projectalias');
    $input['description']       = post('description');
    $input['features']          = post('features');
    $input['efficiency']        = post('efficiency');
    $input['proposedfrom']      = post('proposedfrom');
    $input['proposedto']        = post('proposedto');
    $input['timeperiod']        = post('timeperiod');
    $input['aesthetic']         = post('aesthetic');
    $input['advantages']        = post('advantages');
    $input['shortcoming']       = post('shortcoming');
    $input['suitable']          = post('suitable');
    $input['warning']           = post('warning');
    $input['precautions']       = post('precautions');
    $input['considerations']    = post('considerations');
    $input['treatment']         = post('treatment');
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $projectId = post('id');

$parameters = '';
if ($_POST) {

    if ($_FILES['beforeimg']['name'] == '' && $_FILES['effectimg']['name'] == '') {
        $query      = 'UPDATE `project` SET First_Project_Id = ?, Second_Project_Id = ?, Project_Name = ?, Project_Alias = ?, Description = ?, Features = ?, Efficiency = ?, Proposed_From = ?, Proposed_To = ?, Time_Period = ?, Aesthetic_standard = ?, Advantages = ?, Shortcoming = ?, Suitable = ?, Risk_Warning = ?, Pre_Precautions = ?, Care_Considerations = ?, Effects_Treatment = ?, Sort = ? where id = ?';


        $parameters = array($input['firstid'], $input['secondid'], $input['projectname'], $input['projectalias'], $input['description'], $input['features'], $input['efficiency'], $input['proposedfrom'], $input['proposedto'], $input['timeperiod'], $input['aesthetic'], $input['advantages'], $input['shortcoming'], $input['suitable'], $input['warning'], $input['precautions'], $input['considerations'], $input['treatment'], $input['sort'], $projectId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }

    else if ($_FILES['beforeimg']['name'] != '' && $_FILES['effectimg']['name'] == '')
    {
        $projectData = $db->prepare('SELECT * FROM project WHERE id = ?');
        $projectData->execute(array($projectId));
        $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

        unlink("../../../images/project/" . $rowProject['Before_Img']);
        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $imageName = generateNewFileName($_FILES['beforeimg']);

        $ext               = end((explode('.', $_FILES['beforeimg']['name'])));
        $path              = "../../images/project/" . $imageName;
        $tmp               = $_FILES['beforeimg']['tmp_name'];

        // Check if uploaded image of the format specified
        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150px', '150px', $ext);
            
            // Insert into database
            $query      = 'UPDATE `project` SET First_Project_Id = ?, Second_Project_Id = ?, Project_Name = ?, Project_Alias = ?, Before_Img = ?, Description = ?, Features = ?, Efficiency = ?, Proposed_From = ?, Proposed_To = ?, Time_Period = ?, Aesthetic_standard = ?, Advantages = ?, Shortcoming = ?, Suitable = ?, Risk_Warning = ?, Pre_Precautions = ?, Care_Considerations = ?, Effects_Treatment = ?, Sort = ? where id = ?';


            $parameters = array($input['firstid'], $input['secondid'], $input['projectname'], $input['projectalias'], $imageName, $input['description'], $input['features'], $input['efficiency'], $input['proposedfrom'], $input['proposedto'], $input['timeperiod'], $input['aesthetic'], $input['advantages'], $input['shortcoming'], $input['suitable'], $input['warning'], $input['precautions'], $input['considerations'], $input['treatment'], $input['sort'], $projectId);

        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }

    else if ($_FILES['effectimg']['name'] != '' && $_FILES['beforeimg']['name'] == '')
    {
        $projectData = $db->prepare('SELECT * FROM project WHERE id = ?');
        $projectData->execute(array($projectId));
        $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

        unlink("../../../images/project/" . $rowProject['Effect_Img']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $imageName = generateNewFileName($_FILES['effectimg']);

        $ext               = end((explode('.', $_FILES['effectimg']['name'])));
        $path              = "../../images/project/" . $imageName;
        $tmp               = $_FILES['effectimg']['tmp_name'];

        // Check if uploaded image of the format specified
        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150px', '150px', $ext);
            
            // Insert into database
            $query      = 'UPDATE `project` SET First_Project_Id = ?, Second_Project_Id = ?, Project_Name = ?, Project_Alias = ?, Effect_Img = ?, Description = ?, Features = ?, Efficiency = ?, Proposed_From = ?, Proposed_To = ?, Time_Period = ?, Aesthetic_standard = ?, Advantages = ?, Shortcoming = ?, Suitable = ?, Risk_Warning = ?, Pre_Precautions = ?, Care_Considerations = ?, Effects_Treatment = ?, Sort = ? where id = ?';


            $parameters = array($input['firstid'], $input['secondid'], $input['projectname'], $input['projectalias'], $imageName, $input['description'], $input['features'], $input['efficiency'], $input['proposedfrom'], $input['proposedto'], $input['timeperiod'], $input['aesthetic'], $input['advantages'], $input['shortcoming'], $input['suitable'], $input['warning'], $input['precautions'], $input['considerations'], $input['treatment'], $input['sort'], $projectId);

        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }

    else if ($_FILES['beforeimg']['name'] != '' && $_FILES['effectimg']['name'] != '')
    {
        $projectData = $db->prepare('SELECT * FROM project WHERE id = ?');
        $projectData->execute(array($projectId));
        $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

        unlink("../../../images/project/" . $rowProject['Before_Img']);
        unlink("../../../images/project/" . $rowProject['Effect_Img']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $beforeName = generateNewFileName($_FILES['beforeimg']);
        $effectName = generateNewFileName($_FILES['effectimg']);

        $ext1              = end((explode('.', $_FILES['beforeimg']['name'])));
        $ext2              = end((explode('.', $_FILES['effectimg']['name'])));

        $path1             = "../../images/project/" . $beforeName;
        $path2             = "../../images/project/" . $effectName;

        $tmp1              = $_FILES['beforeimg']['tmp_name'];
        $tmp2              = $_FILES['effectimg']['tmp_name'];

        // Check if uploaded image of the format specified
        if (!in_array($ext1, $allowedFileTypes) && !in_array($ext2, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp1, $path1);
            $moved = move_uploaded_file($tmp2, $path2);
            // Resize the uploaded avatar
            // resize($path, '150px', '150px', $ext);
            
            // Insert into database
            $query      = 'UPDATE `project` SET First_Project_Id = ?, Second_Project_Id = ?, Project_Name = ?, Project_Alias = ?, Before_Img = ?, Effect_Img = ?, Description = ?, Features = ?, Efficiency = ?, Proposed_From = ?, Proposed_To = ?, Time_Period = ?, Aesthetic_standard = ?, Advantages = ?, Shortcoming = ?, Suitable = ?, Risk_Warning = ?, Pre_Precautions = ?, Care_Considerations = ?, Effects_Treatment = ?, Sort = ? where id = ?';


            $parameters = array($input['firstid'], $input['secondid'], $input['projectname'], $input['projectalias'], $beforeName, $effectName, $input['description'], $input['features'], $input['efficiency'], $input['proposedfrom'], $input['proposedto'], $input['timeperiod'], $input['aesthetic'], $input['advantages'], $input['shortcoming'], $input['suitable'], $input['warning'], $input['precautions'], $input['considerations'], $input['treatment'], $input['sort'], $projectId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }
    }
    $output = responseSuccess('New Project added successfully');
}
echo json_encode($output);
?>

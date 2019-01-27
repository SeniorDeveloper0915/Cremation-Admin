<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['name']                  = post('name');
    $input['titleid']               = post('titleid');
    $input['length']                = post('length');
    $input['number']                = post('number');
    $input['nationid']              = post('nationid');
    $input['profile']               = $_REQUEST['profile'];
    $input['sort']                  = post('sort');
    $input['skill']                 = json_decode($_REQUEST['skill']);

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $doctorId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['doctorimg']['name'] == '') {

        $query      = 'UPDATE `doctor` SET Doctor_Name = ?, Title_Id = ?, Length = ?, Certi_Number = ?, Address = ?, Profile = ?, Sort = ? where id = ?';
        $parameters = array($input['name'], $input['titleid'], $input['length'], $input['number'], $input['nationid'], $input['profile'], $input['sort'], $doctorId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM skill where Doctor_Id = ?";
        $parameters = array($doctorId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        foreach ($input['skill'] as $key) {
            # code...
            $query      = 'INSERT INTO `skill` SET Doctor_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
            $parameters = array($doctorId, $key[0], $key[1], $key[2]);

            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }

    } 
    else if ($_FILES['doctorimg']['name'] != '') {
        $doctorData = $db->prepare('SELECT * FROM doctor WHERE id = ?');
        $doctorData->execute(array($doctorId));
        $rowDoctor = $doctorData->fetch(PDO::FETCH_ASSOC);
        unlink("../../../images/doctor/" . $rowDoctor['Photo']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $imageName = generateNewFileName($_FILES['doctorimg']);

        $ext               = end((explode('.', $_FILES['doctorimg']['name'])));
        $path              = "../../../images/doctor/" . $imageName;
        $tmp               = $_FILES['doctorimg']['tmp_name'];

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

            $query  = 'UPDATE `doctor` SET Doctor_Name = ?, Title_Id = ?, Photo = ?, Length = ?, Certi_Number = ?, Address = ?, Profile = ?, Sort = ? where id = ?';
            $parameters = array($input['name'], $input['titleid'], $imageName, $input['length'], $input['number'], $input['nationid'], $input['profile'], $input['sort'], $doctorId);

            $statement = $db->prepare($query);
            $statement->execute($parameters);

            $query = "DELETE FROM skill where Doctor_Id = ?";
            $parameters = array($doctorId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);


            foreach ($input['skill'] as $key) {
                # code...
                $query      = 'INSERT INTO `skill` SET Doctor_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($doctorId, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

        }   
    }
    
    $output = responseSuccess('Doctor updated successfully');
}
echo json_encode($output);
?>

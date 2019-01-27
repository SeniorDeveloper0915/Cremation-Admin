<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['name']              = post('name');
    $input['slogan']            = post('slogan');
    $input['qualification']     = post('qualification');
    $input['level']             = post('level');
    $input['license']           = post('license');
    $input['address']           = post('address');
    $input['introduction']      = post('introduction');
    $input['sort']              = post('sort');
    $input['services']          = json_decode($_REQUEST['services']);
    $input['doctors']           = json_decode($_REQUEST['doctors']);

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $hospitalId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['logoimg']['name'] == '' && empty(array_filter($_FILES['publicityimgs']['name'])) ) {

        $query      = 'UPDATE `hospital` SET Hospital_Name = ?, Slogan = ?, Qualification = ?, Level = ?, License = ?, Address = ?, Introduction = ?, Sort = ? where id = ?';
        $parameters = array($input['name'], $input['slogan'], $input['qualification'], $input['level'], $input['license'], $input['address'], $input['introduction'], $input['sort'], $hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM service where Hospital_Id = ?";
        $parameters = array($hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM team where Hospital_Id = ?";
        $parameters = array($hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        foreach ($input['services'] as $key) {
            # code...
            $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
            $parameters = array($hospitalId, $key[0], $key[1], $key[2]);

            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }

        foreach ($input['doctors'] as $key) {
            # code...
            $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
            $parameters = array($hospitalId, $key);

            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }

    } 
    else if ($_FILES['logoimg']['name'] != '' && empty(array_filter($_FILES['publicityimgs']['name']))) {
        $hospitalData = $db->prepare('SELECT * FROM hospital WHERE id = ?');
        $hospitalData->execute(array($hospitalId));
        $rowHospital = $hospitalData->fetch(PDO::FETCH_ASSOC);
        unlink("../../../images/hospital/logo/" . $rowHospital['Logo']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $imageName = generateNewFileName($_FILES['logoimg']);

        $ext               = end((explode('.', $_FILES['logoimg']['name'])));
        $path              = "../../images/hospital/logo/" . $imageName;
        $tmp               = $_FILES['logoimg']['tmp_name'];

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

            $query      = 'UPDATE `hospital` SET Hospital_Name = ?, Logo = ?, Slogan = ?, Qualification = ?, Level = ?, License = ?, Address = ?, Introduction = ?, Sort = ? where id = ?';
            $parameters = array($input['name'], $imageName, $input['slogan'], $input['qualification'], $input['level'], $input['license'], $input['address'], $input['introduction'], $input['sort'], $hospitalId);

            $statement = $db->prepare($query);
            $statement->execute($parameters);

            $query = "DELETE FROM service where Hospital_Id = ?";
            $parameters = array($hospitalId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);

            $query = "DELETE FROM team where Hospital_Id = ?";
            $parameters = array($hospitalId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);


            foreach ($input['services'] as $key) {
                # code...
                $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($hospitalId, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

            foreach ($input['doctors'] as $key) {
                # code...
                $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                $parameters = array($hospitalId, $key);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }
        }   
    }

    elseif ($_FILES['logoimg']['name'] == '' && !empty(array_filter($_FILES['publicityimgs']['name']))) {

        $publicityData = $db->prepare('SELECT * FROM publicity_photo WHERE Hospital_Id = ?');
        $publicityData->execute(array($hospitalId));
        $rowPublicity = $publicityData->fetchAll();

        foreach ($rowPublicity as $value) {
            # code...
            unlink("../../../images/hospital/publicity/" . $value['Photos']);
        }
        
        $query      = 'UPDATE `hospital` SET Hospital_Name = ?, Slogan = ?, Qualification = ?, Level = ?, License = ?, Address = ?, Introduction = ?, Sort = ? where id = ?';
        $parameters = array($input['name'], $input['slogan'], $input['qualification'], $input['level'], $input['license'], $input['address'], $input['introduction'], $input['sort'], $hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM service where Hospital_Id = ?";
        $parameters = array($hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM team where Hospital_Id = ?";
        $parameters = array($hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $query = "DELETE FROM publicity_photo where Hospital_Id = ?";
        $parameters = array($hospitalId);
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        foreach ($input['services'] as $key) {
            # code...
            $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
            $parameters = array($hospitalId, $key[0], $key[1], $key[2]);

            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }

        foreach ($input['doctors'] as $key) {
            # code...
            $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
            $parameters = array($hospitalId, $key);

            $statement = $db->prepare($query);
            $statement->execute($parameters);
        }

        foreach($_FILES['publicityimgs']['name'] as $key => $val){
            // File upload path
            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['publicityimgs']['name'][$key]) . ".jpg";
            $ext               = end((explode('.', $_FILES['publicityimgs']['name'][$key])));
            $path              = "../../../images/hospital/publicity/" . $imageName;
            $tmp               = $_FILES['publicityimgs']['tmp_name'][$key];

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

                $query      = 'INSERT INTO `publicity_photo` SET Hospital_Id = ?, Photos = ?';
                $parameters = array($hospitalId, $imageName);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }
        }        
    }
    else {
        $hospitalData = $db->prepare('SELECT * FROM hospital WHERE id = ?');
        $hospitalData->execute(array($hospitalId));
        $rowHospital = $hospitalData->fetch(PDO::FETCH_ASSOC);

        unlink("../../images/hospital/logo/" . $rowHospital['Logo']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

        $imageName = generateNewFileName($_FILES['logoimg']);

        $ext               = end((explode('.', $_FILES['logoimg']['name'])));
        $path              = "../../../images/hospital/logo/" . $imageName;
        $tmp               = $_FILES['logoimg']['tmp_name'];

        // Check if uploaded image of the format specified
        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } 
        else 
        {
            $moved = move_uploaded_file($tmp, $path);
            $query      = 'UPDATE `hospital` SET Hospital_Name = ?, Logo = ?, Slogan = ?, Qualification = ?, Level = ?, License = ?, Address = ?, Introduction = ?, Sort = ? where id = ?';
            $parameters = array($input['name'], $imageName, $input['slogan'], $input['qualification'], $input['level'], $input['license'], $input['address'], $input['introduction'], $input['sort'], $hospitalId);

            $statement = $db->prepare($query);
            $statement->execute($parameters);


            $query = "DELETE FROM service where Hospital_Id = ?";
            $parameters = array($hospitalId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);

            $query = "DELETE FROM team where Hospital_Id = ?";
            $parameters = array($hospitalId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);


            foreach ($input['services'] as $key) {
                # code...
                $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($hospitalId, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

            foreach ($input['doctors'] as $key) {
                # code...
                $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                $parameters = array($hospitalId, $key);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }
            $publicityData = $db->prepare('SELECT * FROM publicity_photo WHERE Hospital_Id = ?');
            $publicityData->execute(array($hospitalId));
            $rowPublicity = $publicityData->fetchAll();

            foreach ($rowPublicity as $value) {
                # code...
                unlink("../../../images/hospital/publicity/" . $value['Photos']);
            }

            $query = "DELETE FROM publicity_photo where Hospital_Id = ?";
            $parameters = array($hospitalId);
            $statement = $db->prepare($query);
            $statement->execute($parameters);
            
            foreach($_FILES['publicityimgs']['name'] as $key => $val) {
                // File upload path
                var_dump("Testing");
                $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

                $imageName = generateNewFileName($_FILES['publicityimgs']['name'][$key]);

                $ext               = end((explode('.', $_FILES['publicityimgs']['name'][$key])));
                $path              = "../../../images/hospital/publicity/" . $imageName;
                $tmp               = $_FILES['publicityimgs']['tmp_name'][$key];

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

                    $query      = 'INSERT INTO `publicity_photo` SET Hospital_Id = ?, Photos = ?';
                    $parameters = array($hospitalId, $imageName);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }
            }
        }
    }
    $output = responseSuccess('Hospital updated successfully');
}
echo json_encode($output);
?>

<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
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

if ($_POST) {

        // When no image is selected
        if ($_FILES['logoimg']['name'] == '' && empty(array_filter($_FILES['publicityimgs']['name'])) ) {
            $query      = "INSERT INTO hospital (Hospital_Name, Slogan, Qualification, Level, License, Address, Introduction, Sort)
                            VALUES ('".$input["name"]."', '".$input["slogan"]."', '".$input["qualification"]."', '".$input["level"]."', '".$input["license"]."', '".$input["address"]."', '".$input["introduction"]."', '".$input["sort"]."')";

            $db->exec($query);
            $id = $db->lastInsertId();

            foreach ($input['services'] as $key) {
                # code...
                $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($id, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

            foreach ($input['doctors'] as $key) {
                # code...
                $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                $parameters = array($id, $key);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }
        } 

        else if ($_FILES['logoimg']['name'] != '' && empty(array_filter($_FILES['publicityimgs']['name']))) {
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

                $query      = "INSERT INTO hospital (Hospital_Name, Logo, Slogan, Qualification, Level, License, Address, Introduction, Sort)
                            VALUES ('".$input["name"]."', '".$imageName."', '".$input["slogan"]."', '".$input["qualification"]."', '".$input["level"]."', '".$input["license"]."', '".$input["address"]."', '".$input["introduction"]."', '".$input["sort"]."')";

                $db->exec($query);
                $id = $db->lastInsertId();


                foreach ($input['services'] as $key) {
                    # code...
                    $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                    $parameters = array($id, $key[0], $key[1], $key[2]);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }

                foreach ($input['doctors'] as $key) {
                    # code...
                    $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                    $parameters = array($id, $key);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }
            }
        }
        elseif ($_FILES['logoimg']['name'] == '' && !empty(array_filter($_FILES['publicityimgs']['name']))) {
            # code...
            $query      = "INSERT INTO hospital (Hospital_Name, Slogan, Qualification, Level, License, Address, Introduction, Sort)
                        VALUES ('".$input["name"]."', '".$input["slogan"]."', '".$input["qualification"]."', '".$input["level"]."', '".$input["license"]."', '".$input["address"]."', '".$input["introduction"]."', '".$input["sort"]."')";

            $db->exec($query);
            $id = $db->lastInsertId();


            foreach ($input['services'] as $key) {
                # code...
                $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($id, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

            foreach ($input['doctors'] as $key) {
                # code...
                $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                $parameters = array($id, $key);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }

            foreach($_FILES['publicityimgs']['name'] as $key => $val){
            // File upload path
                $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
                $imageName = generateNewFileName($_FILES['publicityimgs']['name'][$key]) . ".jpg";
                $ext               = end((explode('.', $_FILES['publicityimgs']['name'][$key])));
                $path              = "../../images/hospital/publicity/" . $imageName;
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
                    $parameters = array($id, $imageName);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }
            }
        }
        else {
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

                $query      = "INSERT INTO hospital (Hospital_Name, Logo, Slogan, Qualification, Level, License, Address, Introduction, Sort)
                            VALUES ('".$input["name"]."', '".$imageName."', '".$input["slogan"]."', '".$input["qualification"]."', '".$input["level"]."', '".$input["license"]."', '".$input["address"]."', '".$input["introduction"]."', '".$input["sort"]."')";

                $db->exec($query);
                $id = $db->lastInsertId();


                foreach ($input['services'] as $key) {
                    # code...
                    $query      = 'INSERT INTO `service` SET Hospital_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                    $parameters = array($id, $key[0], $key[1], $key[2]);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }

                foreach ($input['doctors'] as $key) {
                    # code...
                    $query      = 'INSERT INTO `team` SET Hospital_Id = ?, Doctor_Id = ?';
                    $parameters = array($id, $key);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }

                foreach($_FILES['publicityimgs']['name'] as $key => $val){
                // File upload path
                    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

                    $imageName = generateNewFileName($_FILES['publicityimgs']['name'][$key]) . ".jpg";

                    $ext               = end((explode('.', $_FILES['publicityimgs']['name'][$key])));
                    $path              = "../../images/hospital/publicity/" . $imageName;
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
                        $parameters = array($id, $imageName);

                        $statement = $db->prepare($query);
                        $statement->execute($parameters);
                    }
                }
            }
        }
        $output = responseSuccess('New Hospital added successfully');
}
echo json_encode($output);
?>
<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['name']                  = post('name');
    $input['titleid']               = post('titleid');
    $input['length']                = post('length');
    $input['number']                = post('number');
    $input['nationid']              = post('nationid');
    $profile                        = $_REQUEST['profile'];
    // var_dump($profile);
    // $profile                        = trim($profile);
    // var_dump($profile);
    // $profile                        = stripslashes($profile);
    // var_dump($profile);
    // $profile                        = htmlspecialchars($profile);
    // var_dump($profile);
    $input['profile']               = $profile;
    $input['sort']                  = post('sort');
    $input['skill']                 = json_decode($_REQUEST['skill']);

    $output                         = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        if ($_FILES['doctorimg']['name'] == '') {
            $query      = "INSERT INTO doctor (Doctor_Name, Title_Id, Length, Certi_Number, Address, Profile, Sort)
                            VALUES ('".$input["name"]."', '".$input["titleid"]."', '".$input["length"]."', '".$input["number"]."', '".$input["nationid"]."', '".$input["profile"]."', '".$input["sort"]."')";

            $db->exec($query);
            $id = $db->lastInsertId();

            foreach ($input['skill'] as $key) {
                # code...
                $query      = 'INSERT INTO `skill` SET Doctor_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                $parameters = array($id, $key[0], $key[1], $key[2]);

                $statement = $db->prepare($query);
                $statement->execute($parameters);
            }
        } 

        else if ($_FILES['doctorimg']['name'] != '') {
            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['doctorimg']);

            $ext               = end((explode('.', $_FILES['doctorimg']['name'])));
            $path              = "../../images/doctor/" . $imageName;
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

                $query      = "INSERT INTO doctor (Doctor_Name, Title_Id, Photo, Length, Certi_Number, Address, Profile, Sort)
                            VALUES ('".$input["name"]."', '".$input["titleid"]."', '".$imageName."', '".$input["length"]."', '".$input["number"]."', '".$input["nationid"]."', '".$input["profile"]."', '".$input["sort"]."')";

                $db->exec($query);
                $id = $db->lastInsertId();


                foreach ($input['skill'] as $key) {
                    # code...
                    $query      = 'INSERT INTO `skill` SET Doctor_Id = ?, First_Project_Id = ?, Second_Project_Id = ?, Third_Project_Id = ?';
                    $parameters = array($id, $key[0], $key[1], $key[2]);

                    $statement = $db->prepare($query);
                    $statement->execute($parameters);
                }

            }
        }
        $output = responseSuccess('New Doctor added successfully');
}
echo json_encode($output);
?>
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
    $input['position']          = post('position');
    $input['profile']           = post('profile');
    $input['sort']              = post('sort');


    $output                     = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        if ($_FILES['memberimg']['name'] == '') {
            $query      = 'INSERT INTO `core_team` SET Member_Name = ?, Position = ?, Profile = ?, Sort = ?';
            $parameters = array($input['name'], $input['position'], $input['profile'], $input['sort']);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['memberimg']);

            $ext               = end((explode('.', $_FILES['memberimg']['name'])));
            $path              = "../../images/member/" . $imageName;
            $tmp               = $_FILES['memberimg']['tmp_name'];

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
                $query      = 'INSERT INTO `core_team` SET Member_Name = ?, Position = ?, Profile = ?, Member_Img = ?, Sort = ?';
                $parameters = array($input['name'], $input['position'], $input['profile'], $imageName, $input['sort']);
            }
        }

        $statement = $db->prepare($query);
        $statement->execute($parameters);
        $output = responseSuccess('New Member added successfully');
}
echo json_encode($output);
?>
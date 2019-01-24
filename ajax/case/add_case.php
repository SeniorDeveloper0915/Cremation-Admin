<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['hospitalid']                = post('hospitalid');
    $input['title']                     = post('title');
    $input['casetime']                  = post('casetime');
    $input['doctorid']                  = post('doctorid');
    $input['introduction']              = trim($_REQUEST['content']);
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        if ($_FILES['caseimg']['name'] == '') {
            $query      = 'INSERT INTO `hospital_case` SET Hospital_Id = ?, Title = ?, Time = ?, Doctor_Id = ?, Introduction = ?, Sort = ?';
            $parameters = array($input['hospitalid'], $input['title'], $input['casetime'], $input['doctorid'], $input['introduction'], $input['sort']);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['caseimg']);

            $ext               = end((explode('.', $_FILES['caseimg']['name'])));
            $path              = "../../images/case/" . $imageName;
            $tmp               = $_FILES['caseimg']['tmp_name'];

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
                $query      = 'INSERT INTO `hospital_case` SET Hospital_Id = ?, Case_Img = ?, Title = ?, Time = ?, Doctor_Id = ?, Introduction = ?, Sort = ?';
                $parameters = array($input['hospitalid'], $imageName, $input['title'], $input['casetime'], $input['doctorid'], $input['introduction'], $input['sort']);

            }

        }

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Hospital Case added successfully');
}
echo json_encode($output);
?>
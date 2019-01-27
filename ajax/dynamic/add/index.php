<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['title']             = post('title');
    $input['subtitle']          = post('subtitle');
    $input['content']           = $_REQUEST['content'];
    $input['sort']              = post('sort');


    $output                     = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        if ($_FILES['dynamicimg']['name'] == '') {
            $query      = 'INSERT INTO `dynamic` SET Dynamic_Title = ?, Dynamic_Subtitle=?, Dynamic_content = ?, Sort = ?';
            $parameters = array($input['title'], $input['subtitle'], $input['content'], $input['sort']);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['dynamicimg']);

            $ext               = end((explode('.', $_FILES['dynamicimg']['name'])));
            $path              = "../../../images/dynamic/" . $imageName;
            $tmp               = $_FILES['dynamicimg']['tmp_name'];

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
                $query      = 'INSERT INTO `dynamic` SET Dynamic_Title = ?, Dynamic_Subtitle = ?, Dynamic_Img = ?, Dynamic_Content = ?, Sort = ?';
                $parameters = array($input['title'], $input['subtitle'], $imageName, $input['content'], $input['sort']);

            }

        }

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Company dynamic added successfully');
}
echo json_encode($output);
?>
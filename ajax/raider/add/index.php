<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['categoryid']        = post('categoryid');
    $input['title']             = post('title');
    $input['sectitle']          = post('sectitle');
    $input['content']           = $_REQUEST['content'];
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        if ($_FILES['raiderimg']['name'] == '') {
            $query      = 'INSERT INTO `raider` SET Category_Id = ?, Raider_Title = ?, Raider_Sec_Title = ?, Content = ?, Sort = ?';
            $parameters = array($input['categoryid'], $input['title'], $input['sectitle'], $input['content'], $input['sort']);

            $query1         = 'UPDATE  `raider_category` SET Article_Cnt = Article_Cnt + 1 where id = ?';
            $parameters1    = array($input['categoryid']);

            $statement = $db->prepare($query1);
            $statement->execute($parameters1);

        } else {

            $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');

            $imageName = generateNewFileName($_FILES['raiderimg']);

            $ext               = end((explode('.', $_FILES['raiderimg']['name'])));
            $path              = "../../../images/raider/" . $imageName;
            $tmp               = $_FILES['raiderimg']['tmp_name'];

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
                $query      = 'INSERT INTO `raider` SET Category_Id = ?, Raider_Title = ?, Raider_Sec_Title = ?, Raider_Img = ?, Content = ?, Sort = ?';
                $parameters = array($input['categoryid'], $input['title'], $input['sectitle'], $imageName, $input['content'], $input['sort']);

                $statement = $db->prepare($query);
                $statement->execute($parameters);

                $query1         = 'UPDATE  `raider_category` SET Article_Cnt = Article_Cnt + 1 where id = ?';
                $parameters1    = array($input['categoryid']);

                $statement = $db->prepare($query1);
                $statement->execute($parameters1);
            }
        }
        $output = responseSuccess('New Raider added successfully');
}
echo json_encode($output);
?>
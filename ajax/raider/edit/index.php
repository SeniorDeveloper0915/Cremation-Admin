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
    $input['content']           = trim($_REQUEST['content']);
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $raiderId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['raiderimg']['name'] == '') {

        $query      = 'UPDATE  `raider` SET Category_Id = ?, Raider_Title = ?, Raider_Sec_Title = ?, Content = ?, Sort = ? where id = ?';
        $parameters = array($input['categoryid'], $input['title'], $input['sectitle'], $input['content'], $input['sort'], $raiderId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

    } else {

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['raiderimg']);
        $ext               = end((explode('.', $_FILES['raiderimg']['name'])));
        $path              = "../../../images/raider/" . $imageName;
        $tmp               = $_FILES['raiderimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE  `raider` SET Category_Id = ?, Raider_Title = ?, Raider_Sec_Title = ?, Raider_Img = ?, Content = ?, Sort = ? where id = ?';
            $parameters = array($input['categoryid'], $input['title'], $input['sectitle'], $imageName, $input['content'], $input['sort'], $raiderId);
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);

    }
    $output = responseSuccess('Raider updated successfully');
}
echo json_encode($output);
?>
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
    $input['profile']               = post('profile');
    $input['position']              = post('position');
    $input['sort']                  = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $memberId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['memberimg']['name'] == '') {

        $query      = 'UPDATE  `core_team` SET Member_Name = ?, Position = ?, Profile = ?, Sort = ? where id = ?';
        $parameters = array($input['name'], $input['profile'], $input['position'], $input['sort'], $memberId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

    } else {

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['memberimg']);
        $ext               = end((explode('.', $_FILES['memberimg']['name'])));
        $path              = "../../../images/member/" . $imageName;
        $tmp               = $_FILES['memberimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE `core_team` SET Member_Name = ?, Profile = ?, Position = ?, Member_Img = ?, Sort = ? where id = ?';
            $parameters = array($input['name'], $input['profile'], $input['position'], $imageName, $input['sort'], $memberId);
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }
    $output = responseSuccess('Member updated successfully');
}
echo json_encode($output);
?>
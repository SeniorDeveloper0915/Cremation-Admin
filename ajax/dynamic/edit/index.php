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

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $dynamicId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['dynamicimg']['name'] == '') {

        $query      = 'UPDATE  `dynamic` SET Dynamic_Title = ?, Dynamic_Subtitle = ?, Dynamic_Content = ?, Sort = ? where id = ?';
        $parameters = array($input['title'], $input['subtitle'], $input['content'], $input['sort'], $dynamicId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);
    } else {

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['dynamicimg']);
        $ext               = end((explode('.', $_FILES['dynamicimg']['name'])));
        $path              = "../../../images/dynamic/" . $imageName;
        $tmp               = $_FILES['dynamicimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE `dynamic` SET Dynamic_Title = ?, Dynamic_Subtitle = ?, Dynamic_Img = ?, Dynamic_Content = ?, Sort = ? where id = ?';
            $parameters = array($input['title'], $input['subtitle'], $imageName, $input['content'], $input['sort'], $dynamicId);
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }
    $output = responseSuccess('Dynamic updated successfully');
}
echo json_encode($output);
?>
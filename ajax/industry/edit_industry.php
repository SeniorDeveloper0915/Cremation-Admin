<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../../index.php');
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

    $industryId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['industryimg']['name'] == '') {

        $query      = 'UPDATE  `industry` SET Industry_Title = ?, Industry_Subtitle = ?, Industry_Content = ?, Sort = ? where id = ?';
        $parameters = array($input['title'], $input['subtitle'], $input['content'], $input['sort'], $industryId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

    } else {

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['industryimg']);
        $ext               = end((explode('.', $_FILES['industryimg']['name'])));
        $path              = "../../images/industry/" . $imageName;
        $tmp               = $_FILES['industryimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE `industry` SET Industry_Title = ?, Industry_Subtitle = ?, Industry_Img = ?, Industry_Content = ?, Sort = ? where id = ?';
            $parameters = array($input['title'], $input['subtitle'], $imageName, $input['content'], $input['sort'], $industryId);
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }
    $output = responseSuccess('Industry updated successfully');
}
echo json_encode($output);
?>
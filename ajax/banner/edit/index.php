<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['index'])) {
    header('location:../../../index.php');
}

    $output = [];
    $password = post('passwordUpdate');

    $input = [];
    $input['bannertitle']       = post('bannertitle');
    $input['url']               = post('url');
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $bannerId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['bannerimg']['name'] == '') {

        $query      = 'UPDATE  `banner` SET Banner_Title = ?, URL=?, Sort=? where id=?';
        $parameters = array(post('bannertitle'), post('url'), post('sort'), $bannerId);

    } else {
        $bannerData = $db->prepare('SELECT * FROM banner WHERE id=?');
        $bannerData->execute(array($bannerId));
        $rowBanner = $bannerData->fetch(PDO::FETCH_ASSOC);
        unlink("../../../images/banner/" . $rowBanner['Banner_Img']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['bannerimg']);
        $ext               = end((explode('.', $_FILES['bannerimg']['name'])));
        $path              = "../../../images/banner/" . $imageName;
        $tmp               = $_FILES['bannerimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE `banner` SET Banner_Title = ?, URL = ?, Banner_Img = ?, Sort = ? where id = ?';
            $parameters = array(post('bannertitle'), post('url'), $imageName, post('sort'), $bannerId);
        }

    }

    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Banner updated successfully');

}
echo json_encode($output);
?>
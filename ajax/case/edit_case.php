<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../../index.php');
}

    $output = [];

    $input = [];
    $input['hospitalid']        = post('hospitalid');
    $input['title']             = post('title');
    $input['casetime']          = post('casetime');
    $input['doctorid']          = post('doctorid');
    $input['introduction']      = trim($_REQUEST['introduction']);
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $caseId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    if ($_FILES['caseimg']['name'] == '') {

        $query      = 'UPDATE  `hospital_case` SET Hospital_Id = ?, Title = ?, Time = ?, Doctor_Id = ?, Introduction = ?, Sort = ? where id = ?';
        $parameters = array($input['hospitalid'], $input['title'], $input['casetime'], $input['doctorid'], $input['introduction'], $input['sort'], $caseId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('Hospital Case updated successfully');

    } else {
        $caseData = $db->prepare('SELECT * FROM hospital_case WHERE id = ?');
        $caseData->execute(array($caseId));
        $rowCase = $caseData->fetch(PDO::FETCH_ASSOC);

        unlink("../../images/case/" . $rowCase['Case_Img']);

        $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pjpeg');
        $imageName = generateNewFileName($_FILES['caseimg']);
        $ext               = end((explode('.', $_FILES['caseimg']['name'])));
        $path              = "../../images/case/" . $imageName;
        $tmp               = $_FILES['caseimg']['tmp_name'];

        if (!in_array($ext, $allowedFileTypes)) {

            $output = responseError('You uploaded wrong image format');
            echo json_encode($output);
            exit();

        } else {
            $moved = move_uploaded_file($tmp, $path);
            // Resize the uploaded avatar
            // resize($path, '150', '150', $ext);

            $query      = 'UPDATE `hospital_case` SET Hospital_Id = ?, Case_Img = ?, Title = ?, Time = ?, Doctor_Id = ?, Introduction = ?, Sort = ? where id = ?';
            $parameters = array($input['hospitalid'], $imageName, $input['title'], $input['casetime'], $input['doctorid'], $input['introduction'], $input['sort'], $caseId);
        }
        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('Hospital Case updated successfully');
    }

}
echo json_encode($output);
?>
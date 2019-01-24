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
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $titleId = post('id');

$parameters = '';
if ($_POST) {

    $query      = 'UPDATE  `doctor_title` SET Doctor_Title = ?, Sort=? where id=?';
    $parameters = array(post('title'), post('sort'), $titleId);

    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Doctor Title updated successfully');

}
echo json_encode($output);
?>
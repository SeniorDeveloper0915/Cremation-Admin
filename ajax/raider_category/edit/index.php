<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['name']              = post('name');
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $categoryId = post('id');

$parameters = '';
if ($_POST) {

    $query      = 'UPDATE  `raider_category` SET Category_Name = ?, Sort = ? where id = ?';
    $parameters = array($input['name'], $input['sort'], $categoryId);

    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Raider Category updated successfully');
}
echo json_encode($output);
?>
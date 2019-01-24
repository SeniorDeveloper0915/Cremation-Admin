<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['name']              = post('name');
    $input['sort']              = post('sort');


    $output                     = responseFormErrors($input);

if ($_POST) {

        // When no image is selected
        $query      = 'INSERT INTO `raider_category` SET Category_Name = ?, Sort = ?';
        $parameters = array($input['name'], $input['sort']);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Raider Category added successfully');
}
echo json_encode($output);
?>
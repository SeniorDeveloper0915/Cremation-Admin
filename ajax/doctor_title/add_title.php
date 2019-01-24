<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['title']             = post('title');
    $input['sort']              = post('sort');
    $output                     = responseFormErrors($input);

if ($_POST) {

        $query      = 'INSERT INTO `doctor_title` SET Doctor_Title = ?, Sort = ?';
        $parameters = array($input['title'], $input['sort']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Doctor Title added successfully');
}
echo json_encode($output);
?>
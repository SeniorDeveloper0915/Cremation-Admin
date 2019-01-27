<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['projectname']       = post('projectname');
    $input['sort']              = post('sort');
    $output                     = responseFormErrors($input);

if ($_POST) {

        $query      = 'INSERT INTO `first_project` SET Project_Name = ?, Sort=?';
        $parameters = array($input['projectname'], $input['sort']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Project added successfully');
}
echo json_encode($output);
?>
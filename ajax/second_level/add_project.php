<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $input['firstid']           = post('firstid');
    $input['projectname']       = post('projectname');
    $input['sort']              = post('sort');
    $output                     = responseFormErrors($input);

if ($_POST) {

        $query      = 'INSERT INTO `second_project` SET First_Project_Id = ?, Project_Name = ?, Sort=?';
        $parameters = array($input['firstid'], $input['projectname'], $input['sort']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Project added successfully');
}
echo json_encode($output);
?>
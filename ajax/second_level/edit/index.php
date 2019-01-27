<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];
    $password = post('passwordUpdate');

    $input = [];

    $input['firstid']           = post('firstid');
    $input['projectname']       = post('projectname');
    $input['sort']              = post('sort');

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $projectId = post('id');

$parameters = '';
if ($_POST) {

    $query      = 'UPDATE  `second_project` SET First_Project_Id = ?, Project_Name = ?, Sort=? where id=?';
    $parameters = array(post('firstid'), post('projectname'), post('sort'), $projectId);

    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Project updated successfully');

}
echo json_encode($output);
?>
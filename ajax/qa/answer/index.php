<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $input = [];
    $input['doctorid']              = post('doctorid');
    $input['content']               = trim($_REQUEST['content']);

    $output                     = responseFormErrors($input);

if($output['error']) {

    foreach ($output['errors'] as $key => $out) {
        $output['errors'][$key] = preg_replace('/Update/', '', $out[0]);
    }

    echo json_encode($output);
    die;
}

    $qaId = post('id');

$parameters = '';
if ($_POST) {

    // When no image is selected
    
    $query      = 'UPDATE  `qa` SET Doctor_Id = ?, Answer_Content = ?, Status = !Status where id = ?';
    $parameters = array($input['doctorid'], $input['content'], $qaId);

    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Answer posted successfully');
   
}
echo json_encode($output);
?>
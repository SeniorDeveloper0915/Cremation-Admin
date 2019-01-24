<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../../index.php');
}

    $output = [];

    $hospitalId = get('id');

$parameters = '';

    $query      = 'UPDATE  `hospital` SET Status = !Status where id = ?';
    $parameters = array($hospitalId);

    
    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Hospital Status changed successfully');

echo json_encode($output);
?>
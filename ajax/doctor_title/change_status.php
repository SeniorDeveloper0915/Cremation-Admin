<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../../index.php');
}

    $output = [];

    $bannerId = get('id');

$parameters = '';

    $query      = 'UPDATE  `first_project` SET Status = !Status where id = ?';
    $parameters = array($bannerId);

    
    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Project Status changed successfully');

echo json_encode($output);
?>
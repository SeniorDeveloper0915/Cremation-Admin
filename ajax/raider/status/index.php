<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $raiderId = get('id');

$parameters = '';

    $query      = 'UPDATE  `raider` SET Status = !Status where id = ?';
    $parameters = array($raiderId);

    
    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Raider Status changed successfully');

echo json_encode($output);
?>
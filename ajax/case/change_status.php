<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:../../index.php');
}

    $output = [];

    $caseId = get('id');

$parameters = '';

    $query      = 'UPDATE  `hospital_case` SET Status = !Status where id = ?';
    $parameters = array($caseId);

    
    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Hospital Case Status changed successfully');

echo json_encode($output);
?>
<?php
    session_start();
    include '../../../config/index.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['admin'])) {
    header('location:../../../index.php');
}

    $output = [];

    $categoryId = get('id');

$parameters = '';

    $query      = 'UPDATE  `raider_category` SET Status = !Status where id = ?';
    $parameters = array($categoryId);

    
    $statement = $db->prepare($query);
    $statement->execute($parameters);

    $output = responseSuccess('Raider Category Status changed successfully');

echo json_encode($output);
?>
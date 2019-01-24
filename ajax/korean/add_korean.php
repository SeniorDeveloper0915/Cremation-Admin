<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $koreanId = post('id');
    $input['title']             = post('title');
    $input['content']           = $_REQUEST['content'];
    $output                    = responseFormErrors($input);

if ($_POST) {

    if ($koreanId == '') 
    {
        $query      = 'INSERT INTO `korean_medicine` SET Title = ?, Content = ?';
        $parameters = array($input['title'], $input['content']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Korean Medicine added successfully');
    }
    else 
    {
        $query      = 'UPDATE  `korean_medicine` SET Title = ?, Content = ? where id = ?';
        $parameters = array($input['title'], $input['content'], $koreanId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Korean Medicine  added successfully');
        
    }
}
echo json_encode($output);
?>
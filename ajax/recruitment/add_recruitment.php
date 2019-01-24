<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $recruitmentId = post('id');
    $input['link']             = post('link');
    $output                    = responseFormErrors($input);

if ($_POST) {

    if ($recruitmentId == '') 
    {
        $query      = 'INSERT INTO `recruitment` SET Link = ?';
        $parameters = array($input['link']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Recruitment added successfully');
    }
    else 
    {
        $query      = 'UPDATE  `recruitment` SET Link = ? where id = ?';
        $parameters = array(post('link'), $recruitmentId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Recruitment added successfully');
        
    }
}
echo json_encode($output);
?>
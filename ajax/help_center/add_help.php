<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $helpId              = post('id');
    $input['title']             = post('title');
    $input['content']           = $_REQUEST['content'];
    $output                     = responseFormErrors($input);

if ($_POST) {

    if ($helpId == '') 
    {
        $query      = 'INSERT INTO `help_center` SET Title = ?, Content = ?';
        $parameters = array($input['title'], $input['content']);

        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }
    else 
    {
        $query      = 'UPDATE  `help_center` SET Title = ?, Content = ? where id = ?';
        $parameters = array(post('title'), post('content'), $helpId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);
    }
    $output = responseSuccess('New Help Center added successfully');
}
echo json_encode($output);
?>
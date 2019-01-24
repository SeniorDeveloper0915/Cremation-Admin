<?php
    session_start();
    include '../../config/config.php';

// SESSION CHECK SET OR NOT
if (!isset($_SESSION['username'])) {
    header('location:index.php');
}

    $output = [];

    $input = [];
    $copyrightId                = post('id');
    $input['title']             = post('title');
    $input['content']           = $_REQUEST['content'];
    $output                     = responseFormErrors($input);

if ($_POST) {

    if ($copyrightId == '') 
    {
        $query      = 'INSERT INTO `copy_right` SET Title = ?, Content = ?';
        $parameters = array($input['title'], $input['content']);


        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Copy Right added successfully');
    }
    else 
    {
        $query      = 'UPDATE  `copy_right` SET Title = ?, Content = ? where id = ?';
        $parameters = array(post('title'), post('content'), $copyrightId);

        $statement = $db->prepare($query);
        $statement->execute($parameters);

        $output = responseSuccess('New Copy Right added successfully');
        
    }
}
echo json_encode($output);
?>
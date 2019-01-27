<?php
session_start();
	include '../../../config/index.php';

      // get user id from url to be deleted
      $qaId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['admin']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $query      = 'DELETE FROM `qa` WHERE id=?';
      $parameters = array($qaId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

        $output = responseSuccess('Question And Answer successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

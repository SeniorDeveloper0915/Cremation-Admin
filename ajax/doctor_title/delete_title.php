<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $titleId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $query      = 'DELETE FROM `doctor_title` WHERE id=?';
      $parameters = array($titleId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Doctor Title successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

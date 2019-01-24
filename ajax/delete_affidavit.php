<?php
session_start();
	include '../config/config.php';

      // get user id from url to be deleted
      $userId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $query      = 'DELETE FROM `affidavits` WHERE id=?';
      $parameters = array($userId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

        $output = responseSuccess('Affidavit successfully deleted');

      // output the message in json format
      echo json_encode($output);

?>

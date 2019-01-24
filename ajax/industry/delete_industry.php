<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $industryId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $query      = 'DELETE FROM `industry` WHERE id=?';
      $parameters = array($industryId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

        $output = responseSuccess('Industry successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

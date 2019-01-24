<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $categoryId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $query      = 'DELETE FROM `raider` WHERE Category_Id = ?';
      $parameters = array($categoryId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `raider_category` WHERE id=?';
      $parameters = array($categoryId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Raider Category successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

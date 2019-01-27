<?php
session_start();
	include '../../../config/index.php';

      // get user id from url to be deleted
      $projectId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['admin']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database

      $query      = 'DELETE FROM `second_project` WHERE First_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `project` WHERE First_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `service` WHERE First_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `skill` WHERE First_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `first_project` WHERE id=?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Project successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

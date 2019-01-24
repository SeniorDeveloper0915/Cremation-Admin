<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $projectId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      $query      = 'DELETE FROM `service` WHERE Third_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `skill` WHERE Third_Project_Id = ?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $projectData = $db->prepare('SELECT * FROM project WHERE id = ?');
      $projectData->execute(array($projectId));
      $rowProject = $projectData->fetch(PDO::FETCH_ASSOC);

      unlink("../../images/project/" . $rowProject['Before_Img']);
      unlink("../../images/project/" . $rowProject['Effect_Img']);
      // Delete from database
      $query      = 'DELETE FROM `project` WHERE id=?';
      $parameters = array($projectId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Project successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $doctorId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['username']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database

      $query      = 'DELETE FROM `skill` WHERE Doctor_Id = ?';
      $parameters = array($doctorId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `team` WHERE Doctor_Id = ?';
      $parameters = array($doctorId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $doctorData = $db->prepare('SELECT * FROM doctor WHERE id = ?');
      $doctorData->execute(array($doctorId));
      $rowDoctor = $doctorData->fetch(PDO::FETCH_ASSOC);

      unlink("../../images/doctor/" . $rowDoctor['Photo']);

      $query      = 'DELETE FROM `doctor` WHERE id=?';
      $parameters = array($doctorId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

        $output = responseSuccess('Doctor successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

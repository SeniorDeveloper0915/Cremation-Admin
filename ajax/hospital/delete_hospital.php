<?php
session_start();
	include '../../config/config.php';

      // get user id from url to be deleted
      $hospitalId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['admin']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database

      $query      = 'DELETE FROM `service` WHERE Hospital_Id = ?';
      $parameters = array($hospitalId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `team` WHERE Hospital_Id = ?';
      $parameters = array($hospitalId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $publicityData = $db->prepare('SELECT * FROM publicity_photo WHERE Hospital_Id = ?');
      $publicityData->execute(array($hospitalId));
      $rowPublicity = $publicityData->fetchAll();

      foreach ($rowPublicity as $value) {
        # code...
        unlink("../../images/hospital/publicity/" . $value['Photos']);
      }

      $query      = 'DELETE FROM `publicity_photo` WHERE Hospital_Id = ?';
      $parameters = array($hospitalId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $hospitalData = $db->prepare('SELECT * FROM hospital WHERE id = ?');
      $hospitalData->execute(array($hospitalId));
      $rowHospital = $hospitalData->fetch(PDO::FETCH_ASSOC);

      unlink("../../images/hospital/logo/" . $rowHospital['Logo']);

      $query      = 'DELETE FROM `hospital` WHERE id=?';
      $parameters = array($hospitalId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $query      = 'DELETE FROM `hospital_case` WHERE Hospital_Id = ?';
      $parameters = array($hospitalId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Hospital successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

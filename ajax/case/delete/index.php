<?php
session_start();
	include '../../../config/index.php';

      // get user id from url to be deleted
      $caseId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['admin']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $caseData = $db->prepare('SELECT * FROM hospital_case WHERE id = ?');
      $caseData->execute(array($caseId));
      $rowCase = $caseData->fetch(PDO::FETCH_ASSOC);

      unlink("../../../images/case/" . $rowCase['Case_Img']);

      $query      = 'DELETE FROM `hospital_case` WHERE id=?';
      $parameters = array($caseId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

        $output = responseSuccess('Hospital Case successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

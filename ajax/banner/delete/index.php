<?php
session_start();
	include '../../../config/index.php';

      // get user id from url to be deleted
      $bannerId = get('id');

// Check session of admin.If session is not set die it.
if(!isset($_SESSION['admin']))
{
    $output = responseError('Session is destroyed');

    die(json_encode($output));
}
      // Delete from database
      $bannerData = $db->prepare('SELECT * FROM banner WHERE id=?');
      $bannerData->execute(array($bannerId));
      $rowBanner = $bannerData->fetch(PDO::FETCH_ASSOC);

      unlink("../../../images/banner/" . $rowBanner['Banner_Img']);

      $query      = 'DELETE FROM `banner` WHERE id=?';
      $parameters = array($bannerId);
      $statement  = $db->prepare($query);
      $statement->execute($parameters);

      $output = responseSuccess('Banner successfully deleted');

      // output the message in json format
      echo json_encode($output);
?>

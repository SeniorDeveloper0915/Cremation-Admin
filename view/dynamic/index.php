<?php
    session_start();

    include '../../config/index.php';

    if (isset($_SESSION['admin'])) {
        header('location:../dashboard/table/index.php');
        exit();
    }
    else {
        header('location:../..index.php');
        exit();
    }
?>
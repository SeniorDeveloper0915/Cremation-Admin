<?php

    session_start();
// Destroy the session and redirect to login page
setcookie ('username', null, time() - 3600, '/');
setcookie ('userPassword', null, time() - 3600, '/');
setcookie ('name', null, time() - 3600, '/');
setcookie ('table', null, time() - 3600, '/');
session_destroy();
header('location:../index.php');
?>
<?php
    require_once 'functions.php';
    error_reporting(0);

    /*
   |--------------------------------------------------------------------------
   | Database Connections
   |--------------------------------------------------------------------------
   |
   | Here are the database configuration setting of the application.
   | HOST is the hostname of the mysql. It can be IP address, localhost or 127.0.0.1
   |
   |
   | USERNAME : username of the mysql (It can be root or anything else)
   | PASSWORD : password of the mysql.
   | DATABASE : First create the database using phpmyadmin or mysql and enter the name of database
   |
   */

    $GLOBALS['HOST']     = 'localhost';
    $GLOBALS['USERNAME'] = 'root';
    $GLOBALS['PASSWORD'] = 'root';
    $GLOBALS['DATABASE'] = 'hyzd';


    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL will be used in the emails.
    |
    */

    $baseUrl = 'http://localhost/confirm2me_admin';


    /*
   |--------------------------------------------------------------------------
   | SMTP
   |--------------------------------------------------------------------------
   |
   | if smtp is set true then it will use configuration from
   | smtp.php file. Make sure you have added the details correctly
   |
   */

    $GLOBALS['SMTP'] = true;

    /*
    |--------------------------------------------------------------------------
    | SMTP False
    |--------------------------------------------------------------------------
    |
    | This email details when stmp is set to false and system sends email using mail function
    |
    */

    $fromAddress = 'ajay13@gmail.com';
    $fromName    = 'Ajay';


    /*
    |--------------------------------------------------------------------------
    | Image Path
    |--------------------------------------------------------------------------
    |
    | Path of the avatar image. This needs to have writable permission
    |
    */

    $path = 'images/avatar/';

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | Encryption key.This key is used for the encryption of the keys that are generated
    | Forget Key and Email verification Key
    |
    */

    $encryptionKey = 'o7l8Tvxdq1zE8oa45TiVNMRH05Xe6tqgPZW3+Mcghgk=';


    /*
    |--------------------------------------------------------------------------
    | Google Re captcha Keys
    |--------------------------------------------------------------------------
    |
    | Visit this to generate keys https://www.google.com/recaptcha/intro/index.html
    |
    */


    $siteKey   = '6Le5-_4SAAAAAMe1ItaO1mYVmAiC01xNu08DTAJp';
    $secretKey = '6Le5-_4SAAAAACFxyuNhDrc9cbHxgyUVWT5r1-Qw';

    /*
    |--------------------------------------------------------------------------
    | Email verification
    |--------------------------------------------------------------------------
    |
    | Email verification will allow the application to use email verification. By default it is
    | not enabled. Set true ot make is enable
    |
    */

    $emailVerification = false;


    /*
    |--------------------------------------------------------------------------
    | Password encryption Type
    |--------------------------------------------------------------------------
    |
    | There are 2 types of password encryption.
    | sha1 :  Setting sha1 will set the system to use sha1 encryption type
    | md5 : Setting sha1 will set the system to use sha1 encryption type
    | none : By default the system will not use any encryption and it set to none.
    |
    |
    | Use any of the above to change the encryption type
    */

    $encryptionType = 'sha1';


    /*
    |--------------------------------------------------------------------------
    | Connecting Database
    |--------------------------------------------------------------------------
    |
    | connectDatabase is called to connect to the database
    |
    */


    $db = connectDatabase();

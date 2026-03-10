<?php    
    $hostDB = '127.0.0.1';
    $nameDB = 'tarea2';
    $userDB = 'Daniel';
    $pwDB = '1234';

    $hostPDO = "mysql:host=$hostDB;dbname=$nameDB;charset=utf8";

    $myPDO = new PDO($hostPDO, $userDB, $pwDB);

    $myPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
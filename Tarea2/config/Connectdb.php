<?php    
     $hostDB = '127.0.0.1';
     $nameDB = 'Tarea2';
     $userDB = 'Daniel';
     $pwDB = '12345';

     $hostPDO = "mysql:host=$hostDB; dbname=$nameDB";
     $myPDO = new PDO($hostPDO, $userDB, $pwDB );

     $myQuery = $myPDO->prepare('SELECT * FROM clientes;');
     $myQuery->execute();
     $result = $myQuery->fetchAll();
   ?>
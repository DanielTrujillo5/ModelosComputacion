<html>
<head>
    <title>PHP prueba</title>
</head>
<body></body>
    <h1>Hola Mundo</h1>
    <p>Esta es una prueba de PHP.</p>
    <?php
        echo "¡Bienvenido a PHP!";
    ?>
    <?php
        for ($i = 0; $i <= 10; $i++) {
            echo "hola: " . $i . "<br>";
        }
    ?>
<?php    
     $hostDB = '127.0.0.1';
     $nameDB = 'udenar_db';
     $userDB = 'root';
     $pwDB = '';

     $hostPDO = "mysql:host=$hostDB; dbname=$nameDB";
     $myPDO = new PDO($hostPDO, $userDB, $pwDB );

     $myQuery = $myPDO->prepare('SELECT * FROM student;');
     $myQuery->execute();
     $result = $myQuery->fetchAll();
     foreach($result as $pos => $data){
          echo($data['first_name']."<br>");
     }
   ?>
   
</html>
<?php
require '../config/Connectdb.php';

header('Content-Type: application/json');

$accion = $_POST['accion'] ?? '';

if($accion == "agregar"){

    $sql = "INSERT INTO clientes (nit, first_name, last_name, email, celular)
            VALUES (:nit, :first, :last, :email, :celular)";

    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':nit' => $_POST['nit'],
        ':first' => $_POST['first_name'],
        ':last' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':celular' => $_POST['celular']
    ]);

    echo json_encode(["status"=>"ok"]);
}

if($accion == "eliminar"){

    $sql = "DELETE FROM clientes WHERE nit = :nit";
    $stmt = $myPDO->prepare($sql);
    $stmt->execute([':nit' => $_POST['nit']]);

    echo json_encode(["status"=>"ok"]);
}

if($accion == "editar"){

    $sql = "UPDATE clientes 
            SET first_name=:first,
                last_name=:last,
                email=:email,
                celular=:celular
            WHERE nit=:nit";

    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':nit' => $_POST['nit'],
        ':first' => $_POST['first_name'],
        ':last' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':celular' => $_POST['celular']
    ]);

    echo json_encode(["status"=>"ok"]);
}

if($accion == "buscar"){

    $sql = "SELECT * FROM clientes WHERE nit = :nit";
    $stmt = $myPDO->prepare($sql);
    $stmt->execute([':nit' => $_POST['nit']]);

    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($cliente);
}
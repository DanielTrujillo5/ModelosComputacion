<?php
require '../config/Connectdb.php';

header('Content-Type: application/json');

$accion = $_POST['accion'] ?? '';

/* AGREGAR PEDIDO */
if($accion == "agregar"){

    $sql = "INSERT INTO pedidos (cliente_nit,total,estado)
            VALUES (:cliente,:total,:estado)";

    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':cliente' => $_POST['cliente_nit'],
        ':total' => $_POST['total'],
        ':estado' => $_POST['estado']
    ]);

    echo json_encode(["status"=>"ok"]);
}

/* ELIMINAR PEDIDO */
if($accion == "eliminar"){

    $sql = "DELETE FROM pedidos WHERE id = :id";
    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id']
    ]);

    echo json_encode(["status"=>"ok"]);
}

/* EDITAR PEDIDO */
if($accion == "editar"){

    $sql = "UPDATE pedidos
            SET total=:total,
                estado=:estado
            WHERE id=:id";

    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id'],
        ':total' => $_POST['total'],
        ':estado' => $_POST['estado']
    ]);

    echo json_encode(["status"=>"ok"]);
}

/* BUSCAR PEDIDO */
if($accion == "buscar"){

    $sql = "SELECT * FROM pedidos WHERE id = :id";

    $stmt = $myPDO->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id']
    ]);

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($pedido);
}
<?php
require 'config/Connectdb.php';

$view = $_GET['view'] ?? 'clientes';

if($view == 'clientes'){
    $sql = "SELECT * FROM clientes";
    $stmt = $myPDO->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="layout">
    <div class="sidebar">
        <h2 class="logo">Mi Sistema</h2>
        <ul class="menu">
            <li><a href="?view=clientes"><i class="fa-solid fa-users"></i> Clientes</a></li>
            <li><a href="?view=pedidos"><i class="fa-solid fa-cart-shopping"></i> Pedidos</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">

        <?php if($view == 'clientes'): ?>
            <h2>Lista de Clientes</h2>
            <div class="botones">
                <button type="button" id="agregar" onclick="abrirform('agregar')">
                    <i class="fa-solid fa-plus"></i> Agregar Cliente
                </button>
                <button type="button" id="buscar" onclick="abrirform('buscar')">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nit</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($result)): ?>
                    <?php foreach($result as $data): ?>
                        <tr>
                            <td><?= $data['nit'] ?></td>
                            <td><?= $data['first_name'] ?></td>
                            <td><?= $data['last_name'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['celular'] ?></td>
                            <td class="acciones">
                                <button class="btn-ver" onclick="visualizarCliente('<?= $data['nit'] ?>')">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button class="btn-editar" onclick="abrirform('editar', '<?= $data['nit'] ?>')">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button class="btn-eliminar" onclick="eliminarCliente('<?= $data['nit'] ?>')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay clientes registrados</td></tr>
                <?php endif; ?>
                </tbody>
            </table>

        <?php elseif($view == 'pedidos'): ?>
            <h2>Lista de Pedidos</h2>
            <div class="botones">
                <button type="button" id="agregar" onclick="abrirform('agregarPedido')">
                    <i class="fa-solid fa-plus"></i> Agregar Pedido
                </button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                      <!-- <th>Fecha</th> -->
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT p.*, c.first_name, c.last_name 
                        FROM pedidos p
                        JOIN clientes c ON p.cliente_nit = c.nit";
                $stmt = $myPDO->query($sql);
                if($stmt->rowCount() > 0){
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        // Lógica para asignar clase de color según el estado
                        $estadoRaw = $row['estado'];
                        $claseEstado = 'pendiente'; // default
                        if($estadoRaw == 'En proceso') $claseEstado = 'proceso';
                        if($estadoRaw == 'Entregado') $claseEstado = 'entregado';

                        echo "<tr>";
                        echo "<td>#".$row['id']."</td>";
                        echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
                      //  echo "<td>".$row['fecha']."</td>";
                        echo "<td><strong>$".number_format($row['total'], 0)."</strong></td>";
                        echo "<td><span class='badge {$claseEstado}'>".$estadoRaw."</span></td>";
                        echo "<td class='acciones'>
                                <button type='button' class='btn-editar' onclick=\"abrirform('editarPedido', '".$row['id']."')\">
                                    <i class='fa-solid fa-pen'></i>
                                </button>
                                <button type='button' class='btn-eliminar' onclick=\"eliminarPedido('".$row['id']."')\">
                                    <i class='fa-solid fa-trash'></i>
                                </button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay pedidos registrados</td></tr>";
                }
                ?>
                </tbody>
            </table>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="form" id="form" style="display: none;">
    <div class="form-box">
        <span class="close" id="cerrar">&times;</span>
        <h3 id="tituloform">Formulario</h3>
        <div id="formulario">
            </div> 
    </div>
</div>

<?php
    $sqlC = "SELECT nit, first_name, last_name FROM clientes";
    $stmtC = $myPDO->query($sqlC);
    $listaClientes = $stmtC->fetchAll(PDO::FETCH_ASSOC);
?>
<script id="datos-clientes-json" type="application/json">
    <?= json_encode($listaClientes) ?>
</script>

<script src="assets/js/script.js?v=<?php echo time(); ?>"></script>

</body>
</html>
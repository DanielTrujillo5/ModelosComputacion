<?php
require 'config/Connectdb.php';

$view = $_GET['view'] ?? 'clientes'; // 🔥 DEFINIMOS LA VISTA
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>

    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css?v=2">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="logo">Mi Sistema</h2>
        <ul class="menu">
            <li><a href="?view=clientes">Clientes</a></li>
            <li><a href="?view=gestion">Gestión Clientes</a></li>
        </ul>
    </div>

    <!-- CONTENIDO -->
    <div class="main-content">
        <div class="container">

        <?php if($view == 'clientes'): ?>

            <h2>Lista de Clientes</h2>

            <div class="botones">
                <button id="agregar">
                    <i class="fa-solid fa-plus"></i> Agregar
                </button>

                <button id="buscar">
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
                <?php foreach($result as $data): ?>
                    <tr>
                        <td><?= $data['nit'] ?></td>
                        <td><?= $data['first_name'] ?></td>
                        <td><?= $data['last_name'] ?></td>
                        <td><?= $data['email'] ?></td>
                        <td><?= $data['celular'] ?></td>
                        <td class="acciones">
                            <button class="btn-ver">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn-editar">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            <button class="btn-eliminar">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif($view == 'gestion'): ?>

            <h2>Gestión de Clientes</h2>

            <table>
                <thead>
                    <tr>
                        <th>Nit</th>
                        <th>Nombre Completo</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($result as $row): ?>
                    <tr>
                        <td><?= $row['nit'] ?></td>
                        <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                        <td>
                            <?= $row['email'] ?><br>
                            <?= $row['celular'] ?>
                        </td>
                        <td><span class="estado activo">Activo</span></td>
                        <td>
                            <button class="btn-ver">👁</button>
                            <button class="btn-editar">✏</button>
                            <button class="btn-eliminar">🗑</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>

        </div>
    </div>

</div>

<!-- MODAL -->
<div class="form" id="form">
    <div class="form-box">
        <span class="close" id="cerrar">&times;</span>
        <h3 id="tituloform">Formulario</h3>
        <form id="formulario"></form>
    </div>
</div>

<script src="assets/js/script.js"></script>

</body>
</html>
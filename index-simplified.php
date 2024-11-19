<?php
require 'database-simplified.php';

// Proceso de creación - Requerido por el documento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        if (!empty($_POST["nombre"]) && !empty($_POST["email"])) {
            createWorker($_POST["nombre"], $_POST["email"]);
        } else {
            echo "<script>alert('Nombre y email son requeridos');</script>";
        }
    }
}

// Obtener trabajadores - Requerido por el documento
$workers = getWorkers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Trabajadores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Formulario de creación - Requerido por el documento -->
        <div class="row">
            <div class="col">
                <h2>Agregar trabajador</h2>
                <form method="post" class="mb-4">
                    <div class="form-group">
                        <label>Nombre: <input type="text" name="nombre" class="form-control"></label>
                    </div>
                    <div class="form-group">
                        <label>Email: <input type="email" name="email" class="form-control"></label>
                    </div>
                    <button type="submit" name="create" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>

        <!-- Lista de trabajadores - Requerido por el documento -->
        <h2>Lista de trabajadores</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($workers as $worker): ?>
                <tr>
                    <td><?php echo $worker["id"]; ?></td>
                    <td><?php echo $worker["nombre"]; ?></td>
                    <td><?php echo $worker["email"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

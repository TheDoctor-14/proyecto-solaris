<?php
require 'database-simplified.php';

// Inicializar variables para mensajes
$mensaje = '';
$tipo_mensaje = '';

// Proceso de creación con validación mejorada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["create"])) {
        if (!empty($_POST["nombre"]) && !empty($_POST["email"])) {
            $resultado = createWorker($_POST["nombre"], $_POST["email"]);
            if ($resultado) {
                $mensaje = "Trabajador agregado exitosamente";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "Error al agregar trabajador. Verifique los datos.";
                $tipo_mensaje = "danger";
            }
        } else {
            $mensaje = "Nombre y email son requeridos";
            $tipo_mensaje = "warning";
        }
    }
}

// Obtener lista de trabajadores
$workers = getWorkers();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Trabajadores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php if ($mensaje): ?>
        <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <!-- Formulario de creación -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Agregar trabajador</h2>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" 
                               required pattern="[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+" 
                               title="Solo se permiten letras y espacios">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               required>
                    </div>
                    <button type="submit" name="create" class="btn btn-primary">
                        Agregar
                    </button>
                </form>
            </div>
        </div>

        <!-- Lista de trabajadores -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Lista de trabajadores</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($workers)): ?>
                            <tr>
                                <td colspan="3" class="text-center">
                                    No hay trabajadores registrados
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($workers as $worker): ?>
                                <tr>
                                    <td><?php echo $worker["id"]; ?></td>
                                    <td><?php echo $worker["nombre"]; ?></td>
                                    <td><?php echo $worker["email"]; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios para Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <!-- Validación del formulario -->
    <script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
</body>
</html>
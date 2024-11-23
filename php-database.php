<?php
// Configuración para MySQL 5.6
$mysqli = new mysqli('localhost', 'root', '12345', 'solaris-workers');

// Verificar conexión con manejo de errores específico para PHP 5.6
if ($mysqli->connect_error) {
    die('Error de conexión (' . $mysqli->connect_errno . ') ' 
        . $mysqli->connect_error);
}

// Establecer el conjunto de caracteres (importante para PHP 5.6)
if (!$mysqli->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", 
           $mysqli->error);
    exit();
}

// Create - Función mejorada con validación
function createWorker($nombre, $email) {
    global $mysqli;
    
    // Sanitización básica para PHP 5.6
    $nombre = strip_tags(trim($nombre));
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    
    // Validación adicional
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    $stmt = $mysqli->prepare("INSERT INTO trabajadores (nombre, email) 
                             VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $nombre, $email);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
    return false;
}

// Read - Función mejorada con manejo de errores
function getWorkers() {
    global $mysqli;
    $workers = array();
    
    $result = $mysqli->query("SELECT id, nombre, email 
                             FROM trabajadores 
                             ORDER BY id DESC");
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $workers[] = array(
                'id' => (int)$row['id'],
                'nombre' => htmlspecialchars($row['nombre'], ENT_QUOTES, 'UTF-8'),
                'email' => htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8')
            );
        }
        $result->free();
    }
    
    return $workers;
}

// Función para limpiar recursos al finalizar
function cerrarConexion() {
    global $mysqli;
    if ($mysqli) {
        $mysqli->close();
    }
}

// Registrar función para cerrar conexión al finalizar el script
register_shutdown_function('cerrarConexion');
?>
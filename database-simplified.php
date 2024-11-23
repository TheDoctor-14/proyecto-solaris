<?php
$mysqli = new mysqli('localhost', 'root', '12345', 'proyecto');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Create - Requerido por el documento
function createWorker($nombre, $email) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO trabajadores (nombre, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $email);
    $stmt->execute();
    $stmt->close();
}

// Read - Requerido por el documento
function getWorkers() {
    global $mysqli;
    $result = $mysqli->query("SELECT id, nombre, email FROM trabajadores");
    return $result->fetch_all(MYSQLI_ASSOC);
}

/* Funcionalidad adicional - no requerida por el documento
function getWorker($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT id, nombre, email FROM trabajadores WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Update - no requerido
function updateWorker($id, $nombre, $email) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE trabajadores SET nombre = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nombre, $email, $id);
    $stmt->execute();
    $stmt->close();
}

// Delete - no requerido
function deleteWorker($id) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM trabajadores WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
*/
?>

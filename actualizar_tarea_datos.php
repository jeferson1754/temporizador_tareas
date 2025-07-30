<?php
header('Content-Type: application/json');
include 'bd.php';
// Reemplaza con tu contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$servidor;dbname=$basededatos;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $usuario, $password, $options);
} catch (\PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos: ' . $e->getMessage()]);
    exit;
}
// --------------------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'time', FILTER_VALIDATE_INT);

    // Validar entradas
    if (!$id || !$name || !$time) {
        echo json_encode(['success' => false, 'message' => 'Datos de entrada inválidos.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE tareas SET Nombre = ?, Tiempo = ? WHERE ID = ?");
        $stmt->execute([$name, $time, $id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Tarea actualizada.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'La tarea no existe o no se realizaron cambios.']);
        }
    } catch (\PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la tarea: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}

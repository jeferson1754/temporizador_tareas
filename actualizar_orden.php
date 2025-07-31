<?php
// actualizar_orden.php
// Este script recibe un array JSON con el nuevo orden de las tareas y lo actualiza en la base de datos.

include 'bd.php';

header('Content-Type: application/json; charset=UTF-8');

// Obtiene el cuerpo de la petición y lo decodifica de JSON a un array de PHP
$data = json_decode(file_get_contents('php://input'), true);

if (is_array($data)) {
    // Prepara la consulta SQL para actualizar el campo 'Orden'
    $sql = "UPDATE tareas SET Orden = ? WHERE ID = ?";

    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Inicializa el contador de éxito
        $success_count = 0;

        // Itera sobre el array de datos recibido
        foreach ($data as $task) {
            $id = intval($task['id']);
            $order = intval($task['order']);

            if ($id > 0) {
                // Vincula los parámetros y ejecuta la sentencia para cada tarea
                mysqli_stmt_bind_param($stmt, "ii", $order, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success_count++;
                } else {
                    // Si ocurre un error, loguea el error pero continúa con las demás tareas
                    error_log("Error al actualizar la tarea ID {$id}: " . mysqli_stmt_error($stmt));
                }
            }
        }

        mysqli_stmt_close($stmt);

        // Devuelve una respuesta JSON con el resultado de la operación
        echo json_encode(['success' => true, 'message' => "Se actualizaron {$success_count} tareas."]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al preparar la sentencia: ' . mysqli_error($conexion)]);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos inválidos. Se esperaba un array de tareas.']);
}

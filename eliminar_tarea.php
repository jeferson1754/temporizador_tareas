<?php
// eliminar_tarea.php
// Este script elimina una tarea de la base de datos por su ID.

// Incluye el archivo de conexión a la base de datos
// Asegúrate de que 'bd.php' establece la conexión en la variable $conexion
include 'bd.php';

// Establece las cabeceras para indicar que la respuesta será JSON
header('Content-Type: application/json; charset=UTF-8');

// Verifica si se recibió el ID necesario a través de POST
if (isset($_POST['id'])) {
    // Sanitiza y valida el ID de entrada
    $id = intval($_POST['id']); // Convierte el ID a entero para mayor seguridad

    // Prepara la consulta SQL para eliminar la tarea
    // Usamos una sentencia preparada para prevenir inyecciones SQL
    $sql = "DELETE FROM tareas WHERE ID = ?";

    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Vinculamos el parámetro: 'i' para integer (id)
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Ejecutamos la sentencia
        if (mysqli_stmt_execute($stmt)) {
            // Verifica si alguna fila fue afectada (la tarea realmente se eliminó)
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Éxito: Envía una respuesta JSON indicando éxito
                echo json_encode(['success' => true, 'message' => 'Tarea eliminada correctamente.']);
            } else {
                // La tarea no se encontró (quizás ya fue eliminada o el ID es incorrecto)
                echo json_encode(['success' => false, 'message' => 'La tarea no se encontró o ya estaba eliminada.']);
            }
        } else {
            // Error al ejecutar la sentencia
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la eliminación: ' . mysqli_error($conexion)]);
        }

        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la sentencia
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Error al preparar la sentencia: ' . mysqli_error($conexion)]);
    }
} else {
    // Si no se proporcionó el ID
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'ID de tarea no proporcionado.']);
}

// Opcional: Cierra la conexión a la base de datos si no se cierra automáticamente en 'bd.php'
// if (isset($conexion)) {
//     mysqli_close($conexion);
// }

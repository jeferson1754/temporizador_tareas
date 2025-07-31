<?php
// actualizar_tarea copy.php
// Este script actualiza el estado de una tarea en la base de datos.

// Incluye el archivo de conexión a la base de datos
// Asegúrate de que 'bd.php' establece la conexión en la variable $conexion
// y preferiblemente también la variable $pdo si usas PDO para otras funciones.
include 'bd.php';

// Establece las cabeceras para indicar que la respuesta será JSON
header('Content-Type: application/json; charset=UTF-8');

// Verifica si se recibieron los datos necesarios a través de POST
if (isset($_POST['id']) && isset($_POST['estado'])) {
    // Sanitiza y valida los datos de entrada
    $id = intval($_POST['id']); // Convierte el ID a entero para mayor seguridad

    // Valida que el estado sea 'Hecho' o 'Faltante' para evitar valores inesperados
    $estado = $_POST['estado'] === 'Hecho' ? 'Hecho' : 'Faltante';

    // Prepara la consulta SQL para actualizar el estado de la tarea
    // Usamos una sentencia preparada para prevenir inyecciones SQL
    $sql = "UPDATE tareas SET Estado = ? WHERE ID = ?";

    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $sql)) {
        // Vinculamos los parámetros: 's' para string (estado), 'i' para integer (id)
        mysqli_stmt_bind_param($stmt, "si", $estado, $id);

        // Ejecutamos la sentencia
        if (mysqli_stmt_execute($stmt)) {
            // Verifica si alguna fila fue afectada (la tarea realmente se actualizó)
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Éxito: Envía una respuesta JSON indicando éxito
                echo json_encode(['success' => true, 'message' => 'Estado de la tarea actualizado correctamente.']);
            } else {
                // La tarea no se encontró o el estado ya era el mismo
                echo json_encode(['success' => false, 'message' => 'La tarea no se encontró o el estado ya era el mismo.']);
            }
        } else {
            // Error al ejecutar la sentencia
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Error al ejecutar la actualización: ' . mysqli_error($conexion)]);
        }

        // Cierra la sentencia preparada
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la sentencia
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Error al preparar la sentencia: ' . mysqli_error($conexion)]);
    }
} else {
    // Si no se proporcionaron todos los datos necesarios
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Datos incompletos para la actualización. Se requieren ID y estado.']);
}

// Opcional: Cierra la conexión a la base de datos si no se cierra automáticamente en 'bd.php'
// if (isset($conexion)) {
//     mysqli_close($conexion);
// }

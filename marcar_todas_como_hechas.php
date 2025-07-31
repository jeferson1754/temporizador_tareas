<?php
// marcar_todas_como_hechas.php
// Este script actualiza el estado de todas las tareas pendientes a 'Hecho'.

include 'bd.php'; // Asegúrate de que este archivo conecta a tu base de datos y define $conexion

header('Content-Type: application/json; charset=UTF-8');

// Opcional: Podrías validar aquí si el POST es válido, aunque para esta función no hay datos críticos.
// Una comprobación de método de solicitud podría ser útil.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepara la consulta SQL para actualizar todas las tareas con Estado='Faltante' a 'Hecho'
    // No necesitamos parámetros dinámicos aquí, por lo que una consulta directa es aceptable,
    // pero usar prepared statements es una buena práctica general.
    $sql = "UPDATE tareas SET Estado = 'Faltante' WHERE Estado = 'Hecho'";

    if (mysqli_query($conexion, $sql)) {
        // Obtiene el número de filas afectadas para la respuesta
        $affected_rows = mysqli_affected_rows($conexion);
        echo json_encode(['success' => true, 'message' => "Se marcaron {$affected_rows} tareas como faltantes."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Error al actualizar las tareas: ' . mysqli_error($conexion)]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}

// Cierra la conexión si bd.php no lo hace automáticamente
// if (isset($conexion)) {
//     mysqli_close($conexion);
// }

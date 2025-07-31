<?php
// obtener_todas_las_tareas.php
// Este script devuelve todas las tareas (pendientes y completadas) de la base de datos.

include 'bd.php'; // Asegúrate de que este archivo conecta a tu base de datos y define $conexion

header('Content-Type: application/json; charset=UTF-8');

// Consulta para obtener todas las tareas
$sql = "SELECT ID, Nombre, Tiempo, Estado FROM tareas ORDER BY ID ASC";
$result = mysqli_query($conexion, $sql);

$tasks = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Asegúrate de que 'Tiempo' sea un entero numérico
        $row['Tiempo'] = (int)$row['Tiempo'];
        $tasks[] = $row;
    }
    echo json_encode(['success' => true, 'tasks' => $tasks]);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['success' => false, 'message' => 'Error al obtener las tareas: ' . mysqli_error($conexion)]);
}

// Cierra la conexión si bd.php no lo hace automáticamente
// if (isset($conexion)) {
//     mysqli_close($conexion);
// }

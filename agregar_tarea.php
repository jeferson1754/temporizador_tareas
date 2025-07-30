<?php
// Establecer la cabecera para indicar que la respuesta será JSON
header('Content-Type: application/json');

// Incluir el archivo de conexión a la base de datos
// Asegúrate de que 'bd.php' contenga la inicialización de $conexion
include 'bd.php';

// Verificar si la conexión a la base de datos es válida
if (!isset($conexion) || $conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
    exit; // Terminar la ejecución si no hay conexión
}

// Verificar si se han recibido los datos esperados por POST
if (isset($_POST['nombre']) && isset($_POST['tiempo'])) {
    // Obtener y sanear los datos
    $nombre = $_POST['nombre']; // No es necesario mysqli_real_escape_string con prepared statements
    $tiempo = intval($_POST['tiempo']); // Asegurarse de que sea un entero

    // Validar que el tiempo sea un número positivo y el nombre no esté vacío
    if ($tiempo <= 0 || empty($nombre)) {
        echo json_encode(['success' => false, 'message' => 'El nombre de la tarea no puede estar vacío y el tiempo debe ser un número positivo.']);
        exit;
    }

    // Usar sentencias preparadas para insertar los datos de forma segura
    // La '?' actúa como un placeholder para los valores
    $sql = "INSERT INTO tareas (Nombre, Tiempo, Estado) VALUES (?, ?, 'Faltante')";

    // Preparar la sentencia
    $stmt = $conexion->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conexion->error]);
        exit;
    }

    // Vincular los parámetros (s = string, i = integer, d = double, b = blob)
    // El orden de los tipos ('si') debe coincidir con el orden de los placeholders y variables
    $stmt->bind_param("si", $nombre, $tiempo);

    // Ejecutar la sentencia preparada
    if ($stmt->execute()) {
        // La inserción fue exitosa
        echo json_encode(['success' => true, 'message' => 'Tarea agregada exitosamente.', 'id' => $conexion->insert_id]);
    } else {
        // Hubo un error al ejecutar la sentencia
        echo json_encode(['success' => false, 'message' => 'Error al agregar la tarea: ' . $stmt->error]);
    }

    // Cerrar la sentencia preparada
    $stmt->close();
} else {
    // Si no se recibieron los datos esperados
    echo json_encode(['success' => false, 'message' => 'Datos incompletos. Se requieren "nombre" y "tiempo".']);
}

// Opcional: Cerrar la conexión a la base de datos si no se va a usar más en el script
// $conexion->close();

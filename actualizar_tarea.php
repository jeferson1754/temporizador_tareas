<?php
// Conexión a la base de datos (reemplaza con tus detalles de conexión)
include 'bd.php';

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_POST['nombre']) && isset($_POST['estado'])) {
    $nombre = $_POST['nombre'];
    $estado = $_POST['estado'];

    // Escapar y limpiar los datos antes de la consulta
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $estado = mysqli_real_escape_string($conexion, $estado);

    // Consulta SQL para actualizar el estado en la base de datos
    $sql = "UPDATE tareas SET estado = '$estado' WHERE nombre = '$nombre'";

    if (mysqli_query($conexion, $sql)) {
        echo "Estado actualizado con éxito.";
    } else {
        echo "Error al actualizar el estado: " . mysqli_error($conexion);
    }
}else{
    echo "Consulta no Funciono";
}

<?php
// Conexión a la base de datos (reemplaza con tus detalles de conexión)
include 'bd.php';

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}



// Consulta SQL para obtener las tareas
$sql = "SELECT Tiempo FROM `tareas` where Estado='Faltante' limit 1";
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tiempo_php = $row['Tiempo'];


        echo "<p id='countdown'>";
        echo $tiempo_php . ":00";
        echo "</p>";
    }
} else {
    echo "<h2>Cargando..</h2>";
}

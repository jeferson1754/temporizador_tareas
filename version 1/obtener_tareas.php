<?php
// Conexión a la base de datos (reemplaza con tus detalles de conexión)
include 'bd.php';

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consulta SQL para obtener las tareas
$sql = "SELECT * FROM tareas where Estado='Faltante'";
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h3>Faltantes:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $ID = $row['ID'];
        $nombre = $row['Nombre'];
        $estado = $row['Estado'];
        $tiempo = $row['Tiempo'];

        echo "<div>";
        echo "<input type='checkbox' id='$nombre' onchange='actualizarEstado(\"$nombre\", this.checked ? \"Hecho\" : \"Faltante\")' " . ($estado == "Hecho" ? "checked" : "") . ">";
        echo "<label for='$nombre'>$nombre-$tiempo</label>";
        echo "<button onclick='editarTarea(\"$nombre\", $tiempo)'>Editar</button>";
        echo "</div>";
    }
}

// Consulta SQL para obtener las tareas
$sql = "SELECT * FROM tareas where Estado='Hecho'";
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h3>Hechos:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = $row['Nombre'];
        $estado = $row['Estado'];
        $tiempo = $row['Tiempo'];

        echo "<div>";
        echo "<input type='checkbox' id='$nombre' onchange='actualizarEstado(\"$nombre\", this.checked ? \"Hecho\" : \"Faltante\")' " . ($estado == "Hecho" ? "checked" : "") . ">";
        echo "<label for='$nombre'>$nombre-$tiempo</label>";
        echo "</div>";
    }
}

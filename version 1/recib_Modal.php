<?php
include 'bd.php';
$Nombre       = $_REQUEST['Nombre'];
$Tiempo       = $_REQUEST['Tiempo'];


try {
    $sql = "INSERT INTO `tareas` (`Nombre`,`Tiempo`) VALUES ('" . $Nombre . "', '" . $Tiempo . "');";
    $resultado = mysqli_query($conexion, $sql);
    echo $sql;
} catch (PDOException $e) {
    echo $e;
    echo "<br>";
    echo $sql;
}

header('Location: index.php');
exit;

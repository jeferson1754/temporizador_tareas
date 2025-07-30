<?php
include 'bd.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM tareas WHERE ID=$id";
    mysqli_query($conexion, $sql);
    echo "ok";
} else {
    echo "error";
}
?>
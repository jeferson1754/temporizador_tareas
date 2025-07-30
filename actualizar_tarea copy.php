
<?php
include 'bd.php';

if (isset($_POST['id']) && isset($_POST['estado'])) {
    $id = intval($_POST['id']);
    $estado = $_POST['estado'] === 'Hecho' ? 'Hecho' : 'Faltante';
    $sql = "UPDATE tareas SET Estado='$estado' WHERE ID=$id";
    mysqli_query($conexion, $sql);
    echo "ok";
} else {
    echo "error";
}
?>
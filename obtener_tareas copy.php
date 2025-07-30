<?php
include 'bd.php';
$estado = $_GET['estado'] ?? 'Faltante';
$sql = "SELECT * FROM tareas WHERE Estado='$estado'";
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['ID'];
        $nombre = htmlspecialchars($row['Nombre']);
        $tiempo = $row['Tiempo'];
        $checked = $estado == 'Hecho' ? 'checked' : '';
        echo "<div class='task-item'>
                <input type='checkbox' class='task-checkbox' $checked onchange='toggleTask($id, this.checked ? \"Hecho\" : \"Faltante\")'>
                <div class='task-label " . ($checked ? "completed" : "") . "'>$nombre</div>
                <div class='task-time'>{$tiempo} min</div>";
        echo '<div class="task-actions">';
        // Botón de Edición
        echo '<button class="btn-edit" onclick="showEditTaskModal(' . htmlspecialchars(json_encode($id)) . ', \'' . htmlspecialchars($nombre, ENT_QUOTES) . '\', ' . htmlspecialchars(json_encode($tiempo)) . ')">';
        echo '<i class="fas fa-edit"></i>';
        echo '</button>';

        echo '<button class="btn-edit" style="background: var(--danger-color);" onclick="deleteTask(' . $id . ')"><i class="fas fa-trash"></i></button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<div class='empty-state'>
            <i class='fas fa-clipboard-list'></i>
            <h3>No hay tareas</h3>
            <p>Agrega una nueva tarea para comenzar</p>
        </div>";
}

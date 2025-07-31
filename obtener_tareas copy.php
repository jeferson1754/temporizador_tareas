<?php
// obtener_tareas copy.php
// Este script obtiene y muestra las tareas filtradas por estado.

include 'bd.php';
$estado = $_GET['estado'] ?? 'Faltante';
$sql = "SELECT * FROM tareas WHERE Estado='$estado' ORDER BY Orden ASC";
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['ID'];
        $nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8');
        $tiempo = $row['Tiempo'];
        $checked = ($estado == 'Hecho') ? 'checked' : '';
        // Se añade draggable="true" y los data-attributes
        echo "<div class='task-item' draggable='true' data-id='{$id}' data-name='{$nombre}' data-time='{$tiempo}'>
                <input type='checkbox' class='task-checkbox' {$checked} onchange='toggleTask({$id}, this.checked ? \"Hecho\" : \"Faltante\")'>
                <div class='task-label " . ($checked ? "completed" : "") . "'>{$nombre}</div>
                <div class='task-time'>{$tiempo} min</div>";
        echo '<div class="task-actions">';
        echo '<button class="btn-edit" onclick="showEditTaskModal(' . $id . ', \'' . str_replace("'", "\\'", $nombre) . '\', ' . $tiempo . ')">';
        echo '<i class="fas fa-edit"></i>';
        echo '</button>';
        echo '<button class="btn-edit" style="background: var(--danger-color);" onclick="deleteTask(' . $id . ')"><i class="fas fa-trash"></i></button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<div class='empty-state'>
            <i class='fas fa-clipboard-list'></i>
            <h3 style='margin: 0 auto;'>No hay tareas</h3>
            <p>Agrega una nueva tarea para comenzar</p>
        </div>";
}

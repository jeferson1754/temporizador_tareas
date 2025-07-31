<?php
// obtener_tareas copy.php
include 'bd.php'; // Asegúrate de que este archivo conecta a tu base de datos y define $conexion

$estado = $_GET['estado'] ?? 'Faltante';
$sql = "SELECT * FROM tareas WHERE Estado='$estado' ORDER BY ID ASC"; // Añadir ORDER BY para consistencia
$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['ID'];
        $nombre = htmlspecialchars($row['Nombre'], ENT_QUOTES, 'UTF-8'); // Usar ENT_QUOTES para comillas simples
        $tiempo = (int)$row['Tiempo']; // Asegurar que sea un entero

        $checked = ($estado == 'Hecho') ? 'checked' : '';

        // Añadir data-id, data-name, data-time al div.task-item
        echo "<div class='task-item' data-id='{$id}' data-name='{$nombre}' data-time='{$tiempo}'> 
                <input type='checkbox' class='task-checkbox' {$checked} onchange='toggleTask({$id}, this.checked ? \"Hecho\" : \"Faltante\")'>
                <div class='task-label " . ($checked ? "completed" : "") . "'>{$nombre}</div>
                <div class='task-time'>{$tiempo} min</div>";
        echo '<div class="task-actions">';

        // Botón de Edición
        // Asegurarse de pasar el ID, nombre y tiempo correctamente.
        // name: debe estar doblemente escapado para la cadena de JS en onclick
        echo '<button class="btn-edit" onclick="showEditTaskModal(' . $id . ', \'' . str_replace("'", "\\'", $nombre) . '\', ' . $tiempo . ')">';
        echo '<i class="fas fa-edit"></i>';
        echo '</button>';

        echo '<button class="btn-edit" style="background: var(--danger-color);" onclick="deleteTask(' . $id . ')"><i class="fas fa-trash"></i></button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<div class='empty-state' style='display: flex; flex-direction: column; justify-content: center; align-items: center;'>
    <i class='fas fa-clipboard-list'></i>
    <h3 style='margin-top: 20px; margin-bottom: 10px; color: var(--text-secondary);'>No hay tareas</h3>
    <p style='color: var(--text-muted);'>Agrega una nueva tarea para comenzar</p>
</div>";
}

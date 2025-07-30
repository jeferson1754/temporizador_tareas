<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporizador de Tareas Moderno</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #f56565;
            --bg-primary: #0f0f23;
            --bg-secondary: #1a1a2e;
            --bg-card: #16213e;
            --text-primary: #ffffff;
            --text-secondary: #a0aec0;
            --text-muted: #718096;
            --border-color: #2d3748;
            --shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.4);
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .header p {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .nav-tabs {
            display: flex;
            background: var(--bg-card);
            border-radius: 15px;
            padding: 8px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        .nav-tab {
            flex: 1;
            padding: 15px 20px;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-tab:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .nav-tab.active:before {
            left: 0;
        }

        .nav-tab.active {
            color: white;
            transform: translateY(-2px);
        }

        .nav-tab i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: var(--bg-card);
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .add-task-btn {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .add-task-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            animation: modalShow 0.3s ease;
        }

        @keyframes modalShow {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background: var(--bg-card);
            margin: 10% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow-hover);
            border: 1px solid var(--border-color);
            animation: modalSlide 0.3s ease;
        }

        @keyframes modalSlide {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal h2 {
            margin-bottom: 20px;
            color: var(--text-primary);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .tasks-section {
            margin-bottom: 30px;
        }

        .tasks-section h3 {
            margin-bottom: 20px;
            color: var(--text-primary);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-item {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .task-item:hover {
            transform: translateX(5px);
            background: var(--bg-card);
        }

        .task-checkbox {
            width: 24px;
            height: 24px;
            accent-color: var(--success-color);
            cursor: pointer;
        }

        .task-label {
            flex: 1;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-label.completed {
            text-decoration: line-through;
            opacity: 0.6;
        }

        .task-time {
            background: var(--primary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .task-actions {
            display: flex;
            gap: 10px;
        }

        .btn-edit {
            background: var(--warning-color);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(237, 137, 54, 0.3);
        }

        .timer-display {
            text-align: center;
            margin-bottom: 40px;
        }

        .countdown {
            font-size: 4rem;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            font-family: 'Courier New', monospace;
        }

        .timer-controls {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .timer-btn {
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 120px;
            justify-content: center;
        }

        .timer-btn.start {
            background: var(--success-color);
            color: white;
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
        }

        .timer-btn.start:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.6);
        }

        .timer-btn.reset {
            background: var(--danger-color);
            color: white;
            box-shadow: 0 5px 15px rgba(245, 101, 101, 0.4);
        }

        .timer-btn.reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 101, 101, 0.6);
        }

        .timer-modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
        }

        .timer-modal-content {
            background: var(--bg-card);
            margin: 15% auto;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: var(--shadow-hover);
            border: 1px solid var(--border-color);
            animation: modalSlide 0.3s ease;
        }

        .timer-modal h2 {
            margin-bottom: 20px;
            color: var(--danger-color);
            font-size: 1.8rem;
        }

        .timer-modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: var(--text-secondary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .nav-tab {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .card {
                padding: 20px;
            }

            .countdown {
                font-size: 3rem;
            }

            .timer-controls {
                flex-direction: column;
                align-items: center;
            }

            .timer-btn {
                width: 100%;
                max-width: 200px;
            }

            .task-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .task-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                margin: 5% auto;
                padding: 20px;
            }

            .modal-buttons {
                flex-direction: column;
            }

            .countdown {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-clock"></i> Temporizador de Tareas</h1>
            <p>Organiza tu tiempo y mejora tu productividad</p>
        </div>

        <div class="nav-tabs">
            <div class="nav-tab active" onclick="showTab('tasks')">
                <i class="fas fa-list-check"></i> Tareas
            </div>
            <div class="nav-tab" onclick="showTab('timer')">
                <i class="fas fa-stopwatch"></i> Temporizador
            </div>
        </div>

        <!-- Tab de Tareas -->
        <div id="tasks-tab" class="tab-content active">
            <div class="card">
                <button class="add-task-btn" onclick="showAddTaskModal()">
                    <i class="fas fa-plus"></i> Nueva Tarea
                </button>

                <!-- Cambia la sección de tareas para que se rellene con PHP -->
                <div class="tasks-section" id="pending-tasks">
                    <h3><i class="fas fa-hourglass-half"></i> Tareas Pendientes</h3>
                    <div id="pending-tasks-list"></div>
                </div>
                <div class="tasks-section" id="completed-tasks">
                    <h3><i class="fas fa-check-circle"></i> Tareas Completadas</h3>
                    <div id="completed-tasks-list"></div>
                </div>
            </div>
        </div>

        <!-- Tab del Temporizador -->
        <div id="timer-tab" class="tab-content">
            <div class="card">
                <div class="timer-display">
                    <div class="countdown" id="countdown">25:00</div>
                    <div class="timer-controls">
                        <button class="timer-btn start" id="start-btn" onclick="toggleTimer()">
                            <i class="fas fa-play"></i> Iniciar
                        </button>
                        <button class="timer-btn reset" onclick="resetTimer()">
                            <i class="fas fa-redo"></i> Reiniciar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva Tarea -->
    <div id="task-modal" class="modal">
        <div class="modal-content">
            <h2><i class="fas fa-plus-circle"></i> Nueva Tarea</h2>
            <form id="task-form">
                <div class="form-group">
                    <input type="text" id="task-name" class="form-control" placeholder="Nombre de la tarea" required>
                </div>
                <div class="form-group">
                    <input type="number" id="task-time" class="form-control" placeholder="Tiempo estimado (minutos)" min="1" max="120" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-secondary" onclick="hideAddTaskModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Tiempo Terminado -->
    <div id="timer-modal" class="timer-modal">
        <div class="timer-modal-content">
            <i class="fas fa-bell" style="font-size: 3rem; color: var(--warning-color); margin-bottom: 20px;"></i>
            <h2>¡Tiempo Terminado!</h2>
            <p>Es hora de tomar un descanso</p>
            <div class="timer-modal-buttons">
                <button class="btn btn-primary" onclick="restartTimer()">
                    <i class="fas fa-redo"></i> Reiniciar
                </button>
                <button class="btn btn-secondary" onclick="closeTimerModal()">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Audio para la alarma -->
    <audio id="alarm-sound" preload="auto">
        <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmUdBSuV3++NeiwGLL/M9dR1IAcvvKLyt2MdAzmf2+yvWA4ATKng3KdTFQZLndjq36xNIANHpKXvsHQdB0OZyOzLfyMFK7vH8tKHMAkZZLrh669VFA1Po8ztzHxPGQRMqcnz1IMLEAAiVQCAA" type="audio/wav">
    </audio>

    <script>
        // Estado de la aplicación
        let currentTab = 'tasks';
        let timer = null;
        let timeLeft = 25 * 60; // 25 minutos por defecto
        let isRunning = false;
        let currentTaskTime = 25;

        let editingTaskId = null; // Para saber si estamos editando o añadiendo

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            renderTasks();
            updateTimerDisplay();
        });

        // Gestión de pestañas
        function showTab(tabName) {
            // Ocultar todas las pestañas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Ocultar todos los botones de navegación activos
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            // Mostrar la pestaña seleccionada
            document.getElementById(tabName + '-tab').classList.add('active');
            event.target.classList.add('active');

            currentTab = tabName;
        }


        function showAddTaskModal() {
            editingTaskId = null; // Al abrir para añadir, no estamos editando ninguna tarea
            document.getElementById('task-modal').style.display = 'block';
            document.getElementById('task-name').value = ''; // Limpiar campos
            document.getElementById('task-time').value = '';
            document.getElementById('task-modal').querySelector('h2').innerHTML = '<i class="fas fa-plus-circle"></i> Nueva Tarea'; // Cambiar título del modal
            document.getElementById('task-name').focus();
        }

        function showEditTaskModal(id, name, time) {
            editingTaskId = id; // Guardar el ID de la tarea que estamos editando
            document.getElementById('task-modal').style.display = 'block';
            document.getElementById('task-name').value = name; // Rellenar con los datos de la tarea
            document.getElementById('task-time').value = time;
            document.getElementById('task-modal').querySelector('h2').innerHTML = '<i class="fas fa-edit"></i> Editar Tarea'; // Cambiar título
            document.getElementById('task-name').focus();
        }

        function hideAddTaskModal() {
            document.getElementById('task-modal').style.display = 'none';
            document.getElementById('task-form').reset();
            editingTaskId = null; // Restablecer el ID de edición
        }

        // Asegúrate de que esta variable exista globalmente
        // let currentTaskBeingTimed = null; // ID de la tarea que el temporizador está cronometrando
        // let currentTaskTime = 25; // Tiempo inicial del temporizador (minutos)


        // Manejar formulario de nueva tarea o edición
        document.getElementById('task-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const name = document.getElementById('task-name').value;
            const time = parseInt(document.getElementById('task-time').value);

            let url = '';
            let body = '';
            let method = 'POST';

            if (editingTaskId) {
                // Estamos editando una tarea existente
                url = 'actualizar_tarea_datos.php'; // Tu script para actualizar nombre y tiempo
                body = `id=${editingTaskId}&name=${encodeURIComponent(name)}&time=${time}`;
            } else {
                // Estamos añadiendo una nueva tarea
                url = 'agregar_tarea.php'; // Tu script para añadir
                body = `name=${encodeURIComponent(name)}&time=${time}`;
            }

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: body
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // --- NUEVA LÓGICA AÑADIDA AQUÍ ---
                        // Si la tarea editada es la misma que está siendo cronometrada
                        if (editingTaskId && editingTaskId === currentTaskBeingTimed) {
                            currentTaskTime = time; // Actualiza el tiempo del temporizador con el nuevo tiempo
                            // Opcional: Si el temporizador está corriendo, podrías querer ajustar timeLeft si el nuevo tiempo es menor
                            // if (isRunning && timeLeft > currentTaskTime * 60) {
                            //     timeLeft = currentTaskTime * 60;
                            //     updateTimerDisplay(); // Actualiza inmediatamente la pantalla del temporizador
                            // }
                            // Actualiza el título de la página para reflejar el nuevo nombre y tiempo
                            document.title = `${formatTime(currentTaskTime * 60)} - ${name} - Temporizador`;
                            showNotification(`Tarea "${name}" actualizada en el reloj.`, 'success');

                            // Si quieres que el temporizador también se reinicie con el nuevo tiempo, descomenta lo siguiente:
                            // if (!isRunning) { // Solo si no está corriendo
                            //     timeLeft = currentTaskTime * 60;
                            //     updateTimerDisplay();
                            // }
                        }
                        // --- FIN NUEVA LÓGICA ---

                        renderTasks(); // Recargar las tareas desde el servidor
                        hideAddTaskModal();
                        showNotification(editingTaskId ? 'Tarea actualizada exitosamente' : 'Tarea agregada exitosamente', 'success');
                    } else {
                        showNotification('Error: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error de conexión:', error);
                    showNotification('Error de conexión al procesar la tarea', 'danger');
                });
        });





        // Reemplaza el array de tareas por peticiones AJAX
        function renderTasks() {
            // Cargar tareas pendientes
            fetch('obtener_tareas copy.php?estado=Faltante')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('pending-tasks-list').innerHTML = html;
                });

            // Cargar tareas completadas
            fetch('obtener_tareas copy.php?estado=Hecho')
                .then(res => res.text())
                .then(html => {
                    document.getElementById('completed-tasks-list').innerHTML = html;
                });
        }

        // Al marcar/desmarcar una tarea
        function toggleTask(id, estado) {
            fetch('actualizar_tarea copy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&estado=${estado}`
            }).then(() => {
                renderTasks();
                showNotification('Tarea actualizada', 'success');
            });
        }

        // Eliminar tarea
        function deleteTask(id) {
            fetch('eliminar_tarea.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}`
            }).then(() => {
                renderTasks();
                showNotification('Tarea eliminada', 'info');
            });
        }

        // Gestión del temporizador
        function toggleTimer() {
            if (isRunning) {
                pauseTimer();
            } else {
                startTimer();
            }
        }

        // Modifica showAddTaskModal para permitir "iniciar con esta tarea" o algo similar
        // O añade un botón de "Iniciar Temporizador" en cada tarea de la lista
        // Ejemplo de cómo se vería la llamada (si tuvieras un botón "Iniciar Temporizador" en cada tarea):
        // <button onclick="startTimerForTask(${task.id}, ${task.time})">Iniciar</button>

        let currentTaskBeingTimed = null; // Variable para almacenar el ID de la tarea actual

        function startTimer(taskId = null) { // Acepta un ID de tarea opcional
            if (taskId) {
                currentTaskBeingTimed = taskId;
                // Opcional: obtener el tiempo de la tarea desde el servidor si no lo tienes
                // o asumirlo si es un tiempo fijo como Pomodoro.
                // Para este ejemplo, asumamos que currentTaskTime ya está ajustado si se inició para una tarea.
            } else {
                currentTaskBeingTimed = null; // No hay tarea específica
            }

            if (timeLeft <= 0) {
                timeLeft = currentTaskTime * 60;
            }

            isRunning = true;
            updateStartButton();

            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                updateCountdownColor();
                updatePageTitle();

                if (timeLeft <= 0) {
                    timerComplete();
                }
            }, 1000);
        }

        function pauseTimer() {
            isRunning = false;
            clearInterval(timer);
            updateStartButton();
            document.title = 'Temporizador de Tareas';
        }

        function resetTimer() {
            isRunning = false;
            clearInterval(timer);
            timeLeft = currentTaskTime * 60;
            updateTimerDisplay();
            updateStartButton();
            document.title = 'Temporizador de Tareas';
        }

        function timerComplete() {
            isRunning = false;
            clearInterval(timer);
            updateStartButton();
            document.title = 'Temporizador de Tareas';

            playAlarm();
            document.getElementById('timer-modal').style.display = 'block';

            if (currentTaskBeingTimed) {
                // Si hay una tarea específica, marcarla como completada
                toggleTask(currentTaskBeingTimed, 'Hecho'); // Asumiendo que 'Hecho' es el estado para completado
                currentTaskBeingTimed = null; // Resetear la tarea actual
            } else {
                // Si no hay tarea específica, mostrar solo la notificación de tiempo terminado
                showNotification('¡Tiempo Terminado!', 'warning');
            }
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('countdown').textContent = display;
        }

        function updateStartButton() {
            const btn = document.getElementById('start-btn');
            if (isRunning) {
                btn.innerHTML = '<i class="fas fa-pause"></i> Pausar';
                btn.style.background = 'var(--warning-color)';
            } else {
                btn.innerHTML = '<i class="fas fa-play"></i> Iniciar';
                btn.style.background = 'var(--success-color)';
            }
        }

        function updatePageTitle() {
            if (isRunning) {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                document.title = `${display} - Temporizador`;
            }
        }

        function restartTimer() {
            closeTimerModal();
            resetTimer();
            startTimer();
        }

        function closeTimerModal() {
            document.getElementById('timer-modal').style.display = 'none';
            stopAlarm();
        }

        function playAlarm() {
            const audio = document.getElementById('alarm-sound');
            audio.play().catch(e => {
                // Si no se puede reproducir el audio, mostrar una notificación visual
                showNotification('¡Tiempo terminado!', 'warning');
            });
        }

        function stopAlarm() {
            const audio = document.getElementById('alarm-sound');
            audio.pause();
            audio.currentTime = 0;
        }

        // Sistema de notificaciones
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--${type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'primary'}-color);
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: var(--shadow);
                z-index: 1002;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                font-weight: 500;
            `;

            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check' : type === 'warning' ? 'exclamation' : 'info'}-circle"></i>
                ${message}
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Cerrar modales al hacer clic fuera
        window.onclick = function(event) {
            const taskModal = document.getElementById('task-modal');
            const timerModal = document.getElementById('timer-modal');

            if (event.target === taskModal) {
                hideAddTaskModal();
            }
            if (event.target === timerModal) {
                closeTimerModal();
            }
        }

        // Atajos de teclado
        document.addEventListener('keydown', function(e) {
            // Escape para cerrar modales
            if (e.key === 'Escape') {
                hideAddTaskModal();
                closeTimerModal();
            }

            // Ctrl/Cmd + N para nueva tarea
            if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                e.preventDefault();
                if (currentTab === 'tasks') {
                    showAddTaskModal();
                }
            }

            // Espacio para pausar/iniciar timer
            if (e.code === 'Space' && currentTab === 'timer') {
                e.preventDefault();
                toggleTimer();
            }
        });

        // Animaciones CSS adicionales
        const additionalStyles = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            
            .pulse {
                animation: pulse 2s infinite;
            }
            
            .task-item:hover .task-checkbox {
                transform: scale(1.1);
            }
            
            .countdown.warning {
                color: var(--warning-color) !important;
                animation: pulse 1s infinite;
            }
            
            .countdown.danger {
                color: var(--danger-color) !important;
                animation: pulse 0.5s infinite;
            }
        `;

        const styleSheet = document.createElement('style');
        styleSheet.textContent = additionalStyles;
        document.head.appendChild(styleSheet);

        // Función para cambiar el color del contador según el tiempo restante
        function updateCountdownColor() {
            const countdownElement = document.getElementById('countdown');
            const percentage = (timeLeft / (currentTaskTime * 60)) * 100;

            countdownElement.classList.remove('warning', 'danger');

            if (percentage <= 10) {
                countdownElement.classList.add('danger');
            } else if (percentage <= 25) {
                countdownElement.classList.add('warning');
            }
        }

        // Actualizar la función startTimer para incluir el cambio de color
        const originalStartTimer = startTimer;
        startTimer = function() {
            originalStartTimer();

            // Actualizar el intervalo para incluir el cambio de color
            clearInterval(timer);
            timer = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                updateCountdownColor();
                updatePageTitle();

                if (timeLeft <= 0) {
                    timerComplete();
                }
            }, 1000);
        };

        // Actualizar resetTimer para remover clases de color
        const originalResetTimer = resetTimer;
        resetTimer = function() {
            originalResetTimer();
            document.getElementById('countdown').classList.remove('warning', 'danger');
        };

        // Función para detectar si el usuario está inactivo
        let inactivityTimer;
        let isUserActive = true;

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            isUserActive = true;

            inactivityTimer = setTimeout(() => {
                isUserActive = false;
                if (isRunning) {
                    showNotification('¿Sigues ahí? El temporizador sigue corriendo', 'info');
                }
            }, 300000); // 5 minutos de inactividad
        }

        // Eventos para detectar actividad del usuario
        ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetInactivityTimer, true);
        });

        // Inicializar el temporizador de inactividad
        resetInactivityTimer();

        // Función para exportar tareas
        function exportTasks() {
            const dataStr = JSON.stringify(tasks, null, 2);
            const dataBlob = new Blob([dataStr], {
                type: 'application/json'
            });

            const link = document.createElement('a');
            link.href = URL.createObjectURL(dataBlob);
            link.download = 'tareas_' + new Date().toISOString().split('T')[0] + '.json';
            link.click();

            showNotification('Tareas exportadas exitosamente', 'success');
        }

        // Función para importar tareas
        function importTasks(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const importedTasks = JSON.parse(e.target.result);
                    if (Array.isArray(importedTasks)) {
                        tasks = [...tasks, ...importedTasks];
                        renderTasks();
                        showNotification('Tareas importadas exitosamente', 'success');
                    } else {
                        showNotification('Formato de archivo inválido', 'warning');
                    }
                } catch (error) {
                    showNotification('Error al importar tareas', 'warning');
                }
            };
            reader.readAsText(file);
        }

        // Agregar estadísticas básicas
        function getTaskStats() {
            const total = tasks.length;
            const completed = tasks.filter(t => t.completed).length;
            const pending = total - completed;
            const totalTime = tasks.reduce((sum, task) => sum + task.time, 0);
            const completedTime = tasks.filter(t => t.completed).reduce((sum, task) => sum + task.time, 0);

            return {
                total,
                completed,
                pending,
                totalTime,
                completedTime,
                completionRate: total > 0 ? Math.round((completed / total) * 100) : 0
            };
        }

        // Función para mostrar estadísticas
        function showStats() {
            const stats = getTaskStats();
            const message = `
                📊 Estadísticas de Productividad:
                
                📝 Total de tareas: ${stats.total}
                ✅ Completadas: ${stats.completed}
                ⏳ Pendientes: ${stats.pending}
                🎯 Tasa de completitud: ${stats.completionRate}%
                ⏱️ Tiempo total: ${stats.totalTime} min
                ✨ Tiempo completado: ${stats.completedTime} min
            `;

            alert(message); // Se podría mejorar con un modal personalizado
        }

        // Mejorar la función de renderizado para incluir un botón de estadísticas
        function addStatsButton() {
            const tasksTab = document.getElementById('tasks-tab');
            const card = tasksTab.querySelector('.card');

            if (!document.getElementById('stats-btn')) {
                const statsBtn = document.createElement('button');
                statsBtn.id = 'stats-btn';
                statsBtn.className = 'btn btn-secondary';
                statsBtn.style.cssText = 'margin-left: 10px; padding: 10px 15px;';
                statsBtn.innerHTML = '<i class="fas fa-chart-bar"></i> Estadísticas';
                statsBtn.onclick = showStats;

                const addTaskBtn = document.querySelector('.add-task-btn');
                addTaskBtn.style.display = 'inline-flex';
                addTaskBtn.parentNode.insertBefore(statsBtn, addTaskBtn.nextSibling);
            }
        }

        // Llamar a addStatsButton cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            renderTasks();
            updateTimerDisplay();
            addStatsButton();
        });
    </script>
</body>

</html>
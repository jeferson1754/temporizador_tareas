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

        .add-task-btn,
        .mark-all-btn {
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

        .add-task-btn:hover,
        .mark-all-btn:hover {
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

        /* Styles for the new Stats Modal */
        #stats-modal .modal-content {
            max-width: 800px;
            text-align: left;
            height: 435px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            background: var(--bg-secondary);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item i {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .stat-item h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .stat-item p {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .progress-bar-container {
            width: 80%;
            height: 10px;
            background-color: var(--border-color);
            border-radius: 5px;
            margin: 15px auto 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--gradient);
            border-radius: 5px;
            width: 0%;
            /* Will be set by JS */
            transition: width 0.5s ease-out;
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

        .task-item.is-dragging {
            opacity: 0.5;
            transform: scale(1.05);
            background: rgba(22, 33, 62, 0.7);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            cursor: grabbing;
        }

        .task-item.is-ghost {
            background-color: var(--border-color);
            border: 2px dashed var(--primary-color);
            opacity: 0.8;
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

        <div id="tasks-tab" class="tab-content active">
            <div class="card">
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px;">
                    <button class="add-task-btn" onclick="showAddTaskModal()">
                        <i class="fas fa-plus"></i> Nueva Tarea
                    </button>
                    <button class="mark-all-btn" onclick="markAllTasksAsDone()">
                        <i class="fas fa-check-double"></i> Marcar todas como faltantes
                    </button>
                    <button class="mark-all-btn" style="background: var(--accent-color);" onclick="showStatsModal()">
                        <i class="fas fa-chart-bar"></i> Estadísticas
                    </button>
                </div>

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
    <div id="stats-modal" class="modal">
        <div class="modal-content">
            <h2 style="text-align: center;"><i class="fas fa-chart-line"></i> Estadísticas de Productividad</h2>
            <div class="stats-grid" id="stats-content">
            </div>
            <div class="modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="hideStatsModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        // Estado de la aplicación
        let currentTab = 'tasks';
        let timer = null;
        let timeLeft = 25 * 60; // 25 minutos por defecto
        let isRunning = false;
        let currentTaskTime = 0; // Tiempo en minutos de la tarea actual
        let currentTaskBeingTimed = null; // ID de la tarea que el temporizador está cronometrando
        let editingTaskId = null; // Para saber si estamos editando o añadiendo

        let draggedItem = null; // Variable para almacenar el elemento que se está arrastrando

        // Array de URLs de sonidos de alarma de Freesound (o cualquier otra fuente)
        // **Importante:** Debes obtener las URLs de los archivos de audio por tu cuenta.
        // Aquí hay un ejemplo con URLs de un repositorio de GitHub que tiene sonidos de dominio público.
        const alarmSounds = [
            'https://cdn.freesound.org/previews/818/818114_3162775-lq.mp3',
            'https://cdn.freesound.org/previews/807/807232_2520418-lq.mp3',
            'https://cdn.freesound.org/previews/790/790342_16303686-lq.mp3',
            'https://cdn.freesound.org/previews/788/788862_7258681-lq.mp3'
        ];

        let currentAlarm = null; // Variable para almacenar la instancia de Audio actual


        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            renderTasks();
            updateTimerDisplay();
            // Cargar la primera tarea pendiente en el temporizador al inicio
            loadFirstPendingTaskForTimer();
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
            // 'event.target' es el elemento que fue clickeado, que en este caso es el nav-tab
            // Si la llamada no viene de un evento de click (ej. programática), event.target será undefined
            // Por eso es mejor usar una referencia al elemento del DOM si es posible.
            const clickedTab = document.querySelector(`.nav-tab[onclick*="showTab('${tabName}')"]`);
            if (clickedTab) {
                clickedTab.classList.add('active');
            }


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

        function initializeDragAndDrop() {
            const pendingList = document.getElementById('pending-tasks-list');
            const completedList = document.getElementById('completed-tasks-list');

            // --- Lógica para la lista de TAREAS PENDIENTES ---
            // Evento al empezar a arrastrar un elemento
            pendingList.addEventListener('dragstart', (e) => {
                if (e.target.classList.contains('task-item')) {
                    draggedItem = e.target;
                    setTimeout(() => {
                        e.target.classList.add('is-dragging');
                    }, 0);
                }
            });

            // Evento al terminar de arrastrar un elemento
            pendingList.addEventListener('dragend', (e) => {
                if (e.target.classList.contains('task-item')) {
                    e.target.classList.remove('is-dragging');
                    draggedItem = null;
                }
            });

            // Evento cuando un elemento arrastrado entra sobre la lista
            pendingList.addEventListener('dragover', (e) => {
                e.preventDefault(); // Permite el "drop"
                const afterElement = getDragAfterElement(pendingList, e.clientY);
                const currentDragged = document.querySelector('.is-dragging');
                if (afterElement == null) {
                    pendingList.appendChild(currentDragged);
                } else {
                    pendingList.insertBefore(currentDragged, afterElement);
                }
            });

            // Evento al soltar un elemento
            pendingList.addEventListener('drop', (e) => {
                e.preventDefault();
                const newIndex = Array.from(pendingList.children).indexOf(draggedItem);
                handleTaskReorder(draggedItem, newIndex);
            });

            // --- Lógica para la lista de TAREAS COMPLETADAS (para evitar drops) ---
            completedList.addEventListener('dragover', (e) => {
                e.preventDefault(); // Permite el "drop" visualmente pero no se procesa
            });

            completedList.addEventListener('drop', (e) => {
                e.preventDefault();
                showNotification('No se pueden mover tareas a la lista de completadas de esta forma. Usa el checkbox.', 'warning');
            });
        }

        // Función auxiliar para saber dónde insertar el elemento arrastrado
        function getDragAfterElement(container, y) {
            const draggableElements = [...container.querySelectorAll('.task-item:not(.is-dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closest.offset) {
                    return {
                        offset: offset,
                        element: child
                    };
                } else {
                    return closest;
                }
            }, {
                offset: Number.NEGATIVE_INFINITY
            }).element;
        }

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
                body = `nombre=${encodeURIComponent(name)}&tiempo=${time}`;
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
                        if (editingTaskId && editingTaskId === currentTaskBeingTimed) {
                            currentTaskTime = time;
                            updatePageTitle();
                            showNotification(`Tarea "${name}" actualizada en el reloj.`, 'success');
                        }
                        renderTasks();
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


        // Carga la primera tarea pendiente en el temporizador
        function loadFirstPendingTaskForTimer() {
            fetch('obtener_tareas.php?estado=Faltante')
                .then(res => res.text())
                .then(html => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const firstTaskElement = tempDiv.querySelector('.task-item'); // Obtiene el primer elemento

                    if (firstTaskElement) {
                        const taskId = parseInt(firstTaskElement.getAttribute('data-id'));
                        const taskTime = parseInt(firstTaskElement.getAttribute('data-time'));
                        const taskName = firstTaskElement.querySelector('.task-label').textContent.trim(); // Obtener el nombre

                        currentTaskBeingTimed = taskId;
                        currentTaskTime = taskTime;
                        timeLeft = currentTaskTime * 60;
                        updateTimerDisplay();
                        document.title = `${formatTime(timeLeft)} - ${taskName} - Temporizador`;
                        showNotification(`Temporizador configurado para: "${taskName}" (${taskTime} min)`, 'info');
                    } else {
                        currentTaskBeingTimed = null;
                        currentTaskTime = 25; // Default time
                        timeLeft = currentTaskTime * 60;
                        updateTimerDisplay();
                        document.title = 'Temporizador de Tareas';
                        showNotification('No hay tareas pendientes. Configurando temporizador a 25 min.', 'info');
                    }
                    updateCountdownColor(); // Asegurar que el color se actualice al cargar
                    updateStartButton(); // Asegurar que el botón de inicio se actualice
                })
                .catch(error => {
                    console.error('Error al cargar la primera tarea pendiente:', error);
                    showNotification('Error al cargar la primera tarea. Temporizador a 25 min.', 'danger');
                    currentTaskBeingTimed = null;
                    currentTaskTime = 25; // Default time
                    timeLeft = currentTaskTime * 60;
                    updateTimerDisplay();
                    document.title = 'Temporizador de Tareas';
                    updateCountdownColor();
                    updateStartButton();
                });
        }



        // ...

        // Reemplaza el array de tareas por peticiones AJAX
        async function renderTasks() {
            try {
                const [pendingHtml, completedHtml] = await Promise.all([
                    fetch('obtener_tareas copy.php?estado=Faltante').then(res => res.text()),
                    fetch('obtener_tareas copy.php?estado=Hecho').then(res => res.text())
                ]);

                const pendingList = document.getElementById('pending-tasks-list');
                const completedList = document.getElementById('completed-tasks-list');

                pendingList.innerHTML = pendingHtml;
                completedList.innerHTML = completedHtml;

                initializeDragAndDrop();

            } catch (error) {
                console.error('Error al renderizar las tareas:', error);
                showNotification('Error al cargar las listas de tareas.', 'danger');
            }
        }


        // Nueva función para manejar el reordenamiento
        function handleTaskReorder(draggedItem, newIndex) {
            const listElement = draggedItem.parentNode;
            const tasksInList = Array.from(listElement.querySelectorAll('.task-item'));

            const updatedOrder = tasksInList.map((item, index) => ({
                id: parseInt(item.getAttribute('data-id')),
                order: index + 1
            }));

            // Enviar el nuevo orden al servidor
            fetch('actualizar_orden.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updatedOrder)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Orden de tareas actualizado.', 'success');
                    } else {
                        showNotification('Error al actualizar el orden: ' + data.message, 'danger');
                        renderTasks(); // Re-renderizar para volver al estado anterior
                    }
                })
                .catch(error => {
                    console.error('Error de conexión:', error);
                    showNotification('Error de conexión al actualizar el orden.', 'danger');
                    renderTasks(); // Re-renderizar para volver al estado anterior
                });
        }

        // Al marcar/desmarcar una tarea
        function toggleTask(id, estado) {
            fetch('actualizar_tarea.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}&estado=${estado}`
                }).then(response => response.json()) // Asegurarse de parsear la respuesta JSON
                .then(data => {
                    if (data.success) {
                        renderTasks();
                        showNotification('Tarea actualizada', 'success');

                        // Si la tarea que se acaba de marcar como 'Hecho' era la que se estaba cronometrando
                        if (id === currentTaskBeingTimed && estado === 'Hecho') {
                            // Pausar el temporizador si está corriendo
                            if (isRunning) {
                                pauseTimer();
                            }
                            // Cargar la siguiente tarea pendiente para el temporizador
                            loadFirstPendingTaskForTimer();
                        } else if (id === currentTaskBeingTimed && estado === 'Faltante') {
                            // Si se desmarca la tarea que se estaba cronometrando,
                            // podríamos optar por pausar el temporizador o simplemente dejarlo correr.
                            // Por ahora, no hacemos nada especial aquí, el temporizador seguirá con el tiempo restante.
                            // Si se desea que el temporizador "desvincule" la tarea, se podría resetTimer() aquí.
                            showNotification('Tarea desmarcada. Temporizador no afectado.', 'info');
                        }
                    } else {
                        showNotification('Error al actualizar tarea: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error de conexión al actualizar tarea:', error);
                    showNotification('Error de conexión al actualizar tarea', 'danger');
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
                }).then(response => response.json()) // Asegurarse de parsear la respuesta JSON
                .then(data => {
                    if (data.success) {
                        renderTasks();
                        showNotification('Tarea eliminada', 'info');
                        // Si la tarea eliminada era la que se estaba cronometrando,
                        // cargar la siguiente tarea pendiente
                        if (id === currentTaskBeingTimed) {
                            if (isRunning) pauseTimer(); // Pausar si estaba corriendo
                            loadFirstPendingTaskForTimer();
                        }
                    } else {
                        showNotification('Error al eliminar tarea: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error de conexión al eliminar tarea:', error);
                    showNotification('Error de conexión al eliminar tarea', 'danger');
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

        function startTimer() {
            // Si el temporizador no tiene una tarea asignada, intenta cargar la primera pendiente
            if (currentTaskBeingTimed === null || currentTaskTime === 0) { // Añadimos currentTaskTime === 0
                loadFirstPendingTaskForTimer();
                // Retrasamos el inicio del timer para asegurarnos de que loadFirstPendingTaskForTimer haya cargado
                // Si loadFirstPendingTaskForTimer es asíncrona, el timer no puede iniciar inmediatamente aquí.
                // Podríamos modificar loadFirstPendingTaskForTimer para devolver una promesa.
                // Por ahora, asumimos que se encarga de configurar el estado global.
                // Para evitar un inicio inmediato si loadFirstPendingTaskForTimer es lenta,
                // podrías añadir un setTimeout o una bandera para indicar que está "cargando".
                if (!isRunning) { // Si no está corriendo después de un posible load
                    // Pequeño retraso para que loadFirstPendingTaskForTimer tenga tiempo de ejecutarse
                    setTimeout(() => {
                        if (!isRunning && timeLeft > 0) { // Vuelve a verificar el estado después del retraso
                            _startTimerInternal(); // Llama a la función interna de inicio
                        }
                    }, 100);
                }
                return;
            }
            _startTimerInternal(); // Si ya hay una tarea y tiempo, inicia directamente
        }

        // Función interna para iniciar el temporizador, llamada después de la configuración de la tarea
        function _startTimerInternal() {
            if (isRunning || timeLeft <= 0) {
                if (timeLeft <= 0) {
                    showNotification('No hay tiempo establecido. Asegúrate de tener tareas pendientes o edita el tiempo.', 'warning');
                }
                return;
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
            updatePageTitle(); // Asegurarse de que el título se reinicie al pausar
        }

        function resetTimer() {
            isRunning = false;
            clearInterval(timer);
            // Restablecer el tiempo a la duración original de la tarea actual, no a 25 minutos fijos
            timeLeft = currentTaskTime * 60;
            updateTimerDisplay();
            updateStartButton();
            document.title = 'Temporizador de Tareas';
            document.getElementById('countdown').classList.remove('warning', 'danger'); // Quitar clases de color
        }

        function timerComplete() {
            isRunning = false;
            clearInterval(timer);
            updateStartButton();
            document.title = 'Temporizador de Tareas'; // Restablecer título

            playAlarm();
            document.getElementById('timer-modal').style.display = 'block';

            if (currentTaskBeingTimed) {
                // Si hay una tarea específica, marcarla como completada y cargar la siguiente
                // La función toggleTask ya maneja la actualización del temporizador con la siguiente tarea
                // cuando se marca como 'Hecho'.
                toggleTask(currentTaskBeingTimed, 'Hecho');
            } else {
                // Si no hay tarea específica (ej. se cronometraron 25 minutos por defecto)
                showNotification('¡Tiempo Terminado!', 'warning');
                // Podríamos restablecer el tiempo a 25 min si no había tarea.
                currentTaskTime = 25;
                timeLeft = currentTaskTime * 60;
                updateTimerDisplay();
                updateCountdownColor();
            }
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('countdown').textContent = display;
        }

        // Formatea el tiempo en segundos a "MM:SS"
        function formatTime(totalSeconds) {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
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
            const countdownDisplay = formatTime(timeLeft);
            let title = `${countdownDisplay} - Temporizador`;
            // Si hay una tarea en curso, la incluimos en el título
            if (currentTaskBeingTimed) {
                // Necesitamos el nombre de la tarea. Para obtenerlo de forma fiable,
                // deberíamos pasar el nombre junto con el ID o mantenerlo en una variable.
                // Por ahora, intentamos obtenerlo del DOM si la tarea está visible.
                const taskElement = document.querySelector(`.task-item[data-id="${currentTaskBeingTimed}"] .task-label`);
                if (taskElement) {
                    title = `${countdownDisplay} - ${taskElement.textContent.trim()} - Temporizador`;
                }
            }
            document.title = title;
        }

        function restartTimer() {
            closeTimerModal();
            // Si había una tarea cronometrada, la reiniciamos a su tiempo original.
            // currentTaskTime ya almacena el tiempo original de la tarea.
            resetTimer();
            startTimer();
        }

        function closeTimerModal() {
            document.getElementById('timer-modal').style.display = 'none';
            stopAlarm();
        }

        // -- INICIO CAMBIOS PARA SONIDO ALEATORIO --

        function selectRandomAlarmSound() {
            // Si el array de sonidos está vacío, no hacemos nada
            if (alarmSounds.length === 0) return null; //

            // Seleccionar un índice aleatorio
            const randomIndex = Math.floor(Math.random() * alarmSounds.length); //

            // **NUEVO:** Imprime la URL del sonido seleccionado en la consola
            const randomSoundUrl = alarmSounds[randomIndex];
            console.log("Alarma seleccionada aleatoriamente:", randomSoundUrl);

            return randomSoundUrl;
        }

        function playAlarm() {
            stopAlarm(); // Detenemos cualquier alarma anterior

            const audioUrl = selectRandomAlarmSound();
            if (audioUrl) {
                const audio = new Audio(audioUrl); // Creamos una nueva instancia de Audio
                audio.play().catch(e => {
                    console.error("Error al reproducir el sonido de la alarma:", e);
                    showNotification('¡Tiempo terminado! No se pudo reproducir el audio.', 'warning');
                });
                currentAlarm = audio; // Guardamos la instancia para poder detenerla después
            } else {
                showNotification('¡Tiempo terminado! No hay sonidos de alarma configurados.', 'warning');
            }
        }

        function stopAlarm() {
            if (currentAlarm) {
                currentAlarm.pause();
                currentAlarm.currentTime = 0;
            }
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
            const statsModal = document.getElementById('stats-modal'); // Get the new stats modal

            if (event.target === taskModal) {
                hideAddTaskModal();
            }
            if (event.target === timerModal) {
                closeTimerModal();
            }
            if (event.target === statsModal) { // Handle clicking outside the stats modal
                hideStatsModal();
            }
        }

        // Atajos de teclado
        document.addEventListener('keydown', function(e) {
            // Escape para cerrar modales
            if (e.key === 'Escape') {
                hideAddTaskModal();
                closeTimerModal();
                hideStatsModal(); // Close stats modal on escape
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

        // Para evitar problemas de sobreescritura de funciones
        // Envuelve la lógica del setInterval en una función interna
        const _originalStartTimer = startTimer;
        startTimer = function() {
            _originalStartTimer.apply(this, arguments); // Llama a la función original
            // Mueve el clearInterval y setInterval a _startTimerInternal si es una llamada directa
            // o ajusta la lógica aquí si se usa como un wrapper.
        };


        // Actualizar resetTimer para remover clases de color
        const _originalResetTimer = resetTimer;
        resetTimer = function() {
            _originalResetTimer();
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

        // Las funciones de exportar/importar tareas y estadísticas
        // necesitan acceso a un array de 'tasks'. Dado que tu PHP las carga dinámicamente,
        // tendrías que obtener todas las tareas desde PHP para que estas funciones trabajen con datos completos.
        // Si no usas estas funciones con la BD, se mantienen como están, pero no harán nada útil.

        // Función para exportar tareas (Requiere que 'tasks' sea un array global poblado por PHP)
        // Actualmente, 'tasks' no está definido como un array global. Deberías cargar todas las tareas
        // en un array JavaScript si quieres usar esta función.
        function exportTasks() {
            showNotification('La función de exportar requiere que las tareas estén cargadas en un array JS.', 'warning');
            // const dataStr = JSON.stringify(tasks, null, 2);
            // ... (resto de la función)
        }

        // Función para importar tareas (Requiere que 'tasks' sea un array global poblado por PHP)
        function importTasks(event) {
            showNotification('La función de importar requiere acceso a las tareas cargadas en un array JS.', 'warning');
            // const file = event.target.files[0];
            // ... (resto de la función)
        }

        // Función para obtener estadísticas (Requiere que 'tasks' sea un array global poblado por PHP)
        function getTaskStats() {
            // Actualmente no se accede a las tareas directamente, solo se usa un placeholder para 'tasks'
            return {
                total: 0,
                completed: 0,
                pending: 0,
                totalTime: 0,
                completedTime: 0,
                completionRate: 0
            };
        }

        // Función para obtener todas las tareas desde el servidor
        async function getAllTasksFromServer() {
            try {
                const response = await fetch('obtener_todas_las_tareas.php');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                if (data.success) {
                    return data.tasks; // Asume que el PHP devuelve { success: true, tasks: [...] }
                } else {
                    showNotification('Error al cargar todas las tareas: ' + data.message, 'danger');
                    return [];
                }
            } catch (error) {
                console.error('Error fetching all tasks:', error);
                showNotification('Error de conexión al obtener todas las tareas.', 'danger');
                return [];
            }
        }

        // Función para calcular y mostrar las estadísticas
        async function calculateAndDisplayStats() {
            const allTasks = await getAllTasksFromServer(); // Obtener todas las tareas

            const totalTasks = allTasks.length;
            const completedTasks = allTasks.filter(task => task.Estado === 'Hecho');
            const pendingTasks = allTasks.filter(task => task.Estado === 'Faltante');

            const numCompleted = completedTasks.length;
            const numPending = pendingTasks.length;

            const totalTimeMinutes = allTasks.reduce((sum, task) => sum + parseInt(task.Tiempo), 0); // Asegúrate que 'Tiempo' sea numérico
            const completedTimeMinutes = completedTasks.reduce((sum, task) => sum + parseInt(task.Tiempo), 0);

            const completionRate = totalTasks > 0 ? Math.round((numCompleted / totalTasks) * 100) : 0;
            const averageTimePerTask = numCompleted > 0 ? (completedTimeMinutes / numCompleted).toFixed(1) : 0; // Tiempo promedio por tarea completada

            const statsContent = document.getElementById('stats-content');
            statsContent.innerHTML = `
        <div class="stat-item">
            <i class="fas fa-list-ul"></i>
            <h4>${totalTasks}</h4>
            <p>Total de Tareas</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
            <h4>${numCompleted}</h4>
            <p>Tareas Completadas</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-hourglass-half" style="color: var(--warning-color);"></i>
            <h4>${numPending}</h4>
            <p>Tareas Pendientes</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-chart-pie" style="color: var(--accent-color);"></i>
            <h4>${completionRate}%</h4>
            <p>Tasa de Completitud</p>
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: ${completionRate}%;"></div>
            </div>
        </div>
        <div class="stat-item">
            <i class="fas fa-clock"></i>
            <h4>${totalTimeMinutes} min</h4>
            <p>Tiempo Total Estimado</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-stopwatch" style="color: var(--success-color);"></i>
            <h4>${completedTimeMinutes} min</h4>
            <p>Tiempo Completado</p>
        </div>
        <div class="stat-item">
            <i class="fas fa-tachometer-alt"></i>
            <h4>${averageTimePerTask} min</h4>
            <p>Tiempo Prom. por Tarea Resuelta</p>
        </div>
    `;
        }

        // Nueva función para marcar todas las tareas como hechas
        function markAllTasksAsDone() {
            if (!confirm('¿Estás seguro de que quieres marcar TODAS las tareas hechas como faltantes?')) {
                return;
            }

            fetch('marcar_todas_como_hechas.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'estado=Hecho' // No es estrictamente necesario, pero lo enviamos para claridad.
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderTasks(); // Refrescar listas de tareas
                        loadFirstPendingTaskForTimer(); // Cargar la próxima tarea para el temporizador (si hay)
                        showNotification('Todas las tareas marcadas como faltantes.', 'success');
                    } else {
                        showNotification('Error al marcar tareas: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error de conexión al marcar tareas:', error);
                    showNotification('Error de conexión al procesar la solicitud.', 'danger');
                });
        }

        // Función para mostrar el modal de estadísticas
        async function showStatsModal() {
            await calculateAndDisplayStats(); // Calcular y mostrar antes de abrir el modal
            document.getElementById('stats-modal').style.display = 'flex'; // Usar flex para centrar
        }

        // Función para ocultar el modal de estadísticas
        function hideStatsModal() {
            document.getElementById('stats-modal').style.display = 'none';
        }
    </script>
</body>

</html>
<?php include 'bd.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://db.onlinewebfonts.com/c/84cb021d5f9af287ffff84b61beef6dc?family=clockicons" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=5">
    <script src="https://kit.fontawesome.com/8846655159.js" crossorigin="anonymous"></script>

    <title>Temporizador de 20 minutos</title>
    <script>
        function actualizarEstado(nombre, estado) {
            // Llamada AJAX para actualizar datos en la base de datos
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText); // Respuesta del servidor
                    // Actualizar las tareas nuevamente después de la respuesta
                    actualizarTareas();
                }
            };
            xhttp.open("POST", "actualizar_tarea.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("nombre=" + nombre + "&estado=" + estado);
        }

        function actualizarTareas() {
            // Llamada AJAX para obtener y mostrar las tareas actualizadas
            const tareasContainer = document.getElementById("check");
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    tareasContainer.innerHTML = this.responseText; // Actualizar contenido
                }
            };
            xhttp.open("GET", "obtener_tareas.php", true);
            xhttp.send();
        }

        function actualizarHoras() {
            // Llamada AJAX para obtener y mostrar las tareas actualizadas
            const time = document.getElementById("timex");
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    time.innerHTML = this.responseText; // Actualizar contenido
                }
            };
            xhttp.open("GET", "obtener_tiempo.php", true);
            xhttp.send();
        }

        setInterval(actualizarHoras, 5000); // 5000 milisegundos = 5 segundos
    </script>
</head>

<body>
    <script>
        // Función para mostrar el modal
        function mostrarModal() {
            const modal = document.getElementById("modal");
            modal.style.display = "block";
            document.getElementById("check").style.display = "none";
        }

        // Función para ocultar el modal
        function ocultarModal() {
            const modal = document.getElementById("modal");
            modal.style.display = "none";
            document.getElementById("check").style.display = "block";
        }
    </script>
    <div class="menu-container">
        <div class="menu-options">
            <div class="menu-option" onclick="showOption(1)">
                Tareas
                <div class="menu-line"></div>
            </div>
            <div class="menu-option" onclick="showOption(2)">
                Reloj
            </div>
        </div>

        <!-- Divs de información para cada opción -->
        <div class="info-container mostrar" id="info-option-1">
            <button class="nueva-tarea-btn" onclick="mostrarModal()">Nueva Tarea</button>

            <!-- Modal -->
            <div class="modal" id="modal" style="display:none;">
                <div class="modal-content">
                    <form action="recib_Modal.php" method="POST">
                        <h2>Nueva Tarea</h2>
                        <input type="text" name="Nombre" class="form-control" placeholder="Nombre de la tarea" required>
                        <input type="number" name="Tiempo" min="1" max="60" class="form-control" placeholder="Tiempo estimado(minutos)" required>
                        <div class="modal-buttons">
                            <button onclick="ocultarModal()">Cancelar</button>
                            <button onclick="ocultarModal()" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="check">
                <?php

                // Consulta SQL para obtener las tareas
                $sql = "SELECT * FROM tareas where Estado='Faltante'";
                $result = mysqli_query($conexion, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo "<h3>Tareas:</h3>";
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
                ?>




            </div>
            <div class="modal" id="modalEditar" style="display:none;">
                <div class="modal-content">
                    <form action="editar_tarea.php" method="POST">
                        <h2>Editar Tarea</h2>
                        <input type="hidden" name="tarea_id" id="edit-tarea-id" value="">
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" placeholder="Nombre de la tarea" required>
                        <input type="number" name="tiempo" id="edit-tiempo" min="1" max="60" class="form-control" placeholder="Tiempo estimado (minutos)" required>
                        <div class="modal-buttons">
                            <button onclick="ocultarModalEditar()">Cancelar</button>
                            <button type="submit">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="info-container" id="info-option-2">

            <div id="time">
                <?php
                $sql1 = "SELECT Tiempo FROM `tareas` where Estado='Faltante' limit 1;";


                $result = mysqli_query($conexion, $sql1);
                //echo $sql1;

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $tiempo_php = $row['Tiempo'];

                        echo "<p id='countdown'>";
                        echo $tiempo_php . ":00";
                        echo "</p>";
                    }
                }

                ?>
            </div>
            <button id="Iniciar" onclick="toggleTimer()">Iniciar</button>
            <button onclick="resetTimer()">Reiniciar</button>
            <!-- Elemento de audio para la alarma -->
            <audio id="alarm-sound" src="op.mp4" preload="auto" loop></audio>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal">
        <div id="myModal-content">
            <!--Revisar css para corregir-->
            <span class="modal-text">¡Tiempo terminado!</span>
            <div class="modal-button-container">
                <button class="modal-button" onclick="restartTimer()">Reiniciar</button>
                <button class="modal-button" onclick="closeModal()">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        let selectedOption = 1;

        function showOption(option) {
            if (option !== selectedOption) {
                // Mover la línea debajo de la opción seleccionada
                const menuLine = document.querySelector('.menu-line');
                menuLine.style.transform = `translateX(${(option - 1) * 115}%)`;

                // Ocultar la información de la opción anterior
                const prevInfoContainer = document.querySelector(`#info-option-${selectedOption}`);
                prevInfoContainer.classList.remove('active');
                prevInfoContainer.classList.remove('mostrar');

                // Mostrar la información de la opción seleccionada
                const currentInfoContainer = document.querySelector(`#info-option-${option}`);
                currentInfoContainer.classList.add('active');

                selectedOption = option;
            }
        }


        function editarTarea(nombre, tiempo) {
            const modalEditar = document.getElementById("modalEditar");
            const nombreField = document.getElementById("edit-nombre");
            const tiempoField = document.getElementById("edit-tiempo");

            // Llena los campos del modal con los datos de la tarea seleccionada
            nombreField.value = nombre;
            tiempoField.value = tiempo;

            // Muestra el modal de edición
            modalEditar.style.display = "block";
        }



        // Al cargar la página, mostrar la primera opción por defecto
        showOption(selectedOption);

        let initialTitle = document.title; // Almacena el título original de la página
        let timerInterval;

        let worker = new Worker('timer-worker.js');
        let tiempoPHP = <?php echo $tiempo_php; ?>; // Obtén el tiempo desde PHP
        let display = document.getElementById("countdown");

        worker.onmessage = function(e) {
            if (e.data === 'done') {
                playAlarm();
                showModal();
                worker.postMessage('reset'); // Reiniciar el temporizador
            } else {
                updateDisplay(e.data);
            }
        };

        function updateDisplay(seconds) {
            const minutes = parseInt(seconds / 60, 0);
            const formattedMinutes = minutes < 10 ? "0" + minutes : minutes;
            const formattedSeconds = seconds % 60 < 10 ? "0" + (seconds % 60) : seconds % 60;
            display.textContent = formattedMinutes + ":" + formattedSeconds;
        } // Resto del código permanece igual let timer=<?php echo $tiempo_php; ?> * 60; let isTimerRunning=false; const startButton=document.getElementById("Iniciar"); const alarmSound=document.getElementById("alarm-sound"); const modal=document.getElementById("myModal"); // Función para actualizar el texto del botón function updateButtonLabel() { startButton.textContent=isTimerRunning ? "Pausar" : "Iniciar" ; } // Función para iniciar o pausar el temporizador function toggleTimer() { if (isTimerRunning) { clearInterval(timerInterval); } else { startTimer(); } isTimerRunning=!isTimerRunning; updateButtonLabel(); } // Función para iniciar el temporizador function startTimer() { timerInterval=setInterval(function() { const minutes=parseInt(timer / 60, 0); const seconds=parseInt(timer % 60, 0); const formattedMinutes=minutes < 10 ? "0" + minutes : minutes; const formattedSeconds=seconds < 10 ? "0" + seconds : seconds; display.textContent=formattedMinutes + ":" + formattedSeconds; const timeRemaining=formattedMinutes + ":" + formattedSeconds; document.title=`${timeRemaining} - ${initialTitle}`; if (--timer < 0) { resetTimer(); playAlarm(); showModal(); // Mostrar el modal cuando el temporizador llegue a cero } }, 1000); } // Función para reproducir la alarma function playAlarm() { alarmSound.play(); } // Función para mostrar el modal function showModal() { modal.style.display="block" ; } // Función para cerrar el modal function closeModal() { modal.style.display="none" ; stopAlarm(); // Detener la reproducción de la alarma al cerrar el modal } // Función para detener la reproducción de la alarma function stopAlarm() { alarmSound.pause(); alarmSound.currentTime=0; } // Función para reiniciar el temporizador function resetTimer() { clearInterval(timerInterval); timer=<?php echo $tiempo_php; ?> * 60; display.textContent="<?php echo $tiempo_php; ?>:00" ; isTimerRunning=false; updateButtonLabel(); } // Función para reiniciar el temporizador desde el modal function restartTimer() { closeModal(); resetTimer(); toggleTimer(); } 
    </script>
</body>

</html>
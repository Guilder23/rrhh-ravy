  <h2 class="titulogestion">Licencia por fechas</h2>
    <div class="container mt-5">
        <div><strong>Calendario de Licencias</strong></div>
        
        <!-- Filtrador por año y mes -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="yearSelect">Año:</label>
                <select class="form-control" id="yearSelect">
                    <!-- Opciones de años se generarán dinámicamente -->
                </select>
            </div>
            <div class="col-md-3">
                <label for="monthSelect">Mes:</label>
                <select class="form-control" id="monthSelect">
                    <option value="0">Enero</option>
                    <option value="1">Febrero</option>
                    <option value="2">Marzo</option>
                    <option value="3">Abril</option>
                    <option value="4">Mayo</option>
                    <option value="5">Junio</option>
                    <option value="6">Julio</option>
                    <option value="7">Agosto</option>
                    <option value="8">Septiembre</option>
                    <option value="9">Octubre</option>
                    <option value="10">Noviembre</option>
                    <option value="11">Diciembre</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Lunes</th>
                        <th class="text-center">Martes</th>
                        <th class="text-center">Miércoles</th>
                        <th class="text-center">Jueves</th>
                        <th class="text-center">Viernes</th>
                        <th class="text-center">Sábado</th>
                        <th class="text-center">Domingo</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Las filas del calendario se generarán dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar evento -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Agregar Licencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="mb-3">
                            <label for="employeeName" class="form-label">Nombre del Empleado</label>
                            <input type="text" class="form-control" id="employeeName" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Motivo</label>
                            <input type="text" class="form-control" id="reason" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const calendarBody = document.getElementById("calendar-body");
            const eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
            const yearSelect = document.getElementById("yearSelect");
            const monthSelect = document.getElementById("monthSelect");
            let selectedDay = null;

            // Generar opciones de años
            function generateYearOptions() {
                const currentYear = new Date().getFullYear();
                for (let year = currentYear - 10; year <= currentYear + 10; year++) {
                    const option = document.createElement("option");
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                }
                yearSelect.value = currentYear;
            }

            // Generar el calendario
            function generateCalendar(year, month) {
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const firstDayOfMonth = new Date(year, month, 1).getDay();
                let currentDay = 1;
                let html = "";

                for (let week = 0; week < 6; week++) {
                    html += "<tr>";
                    for (let day = 0; day < 7; day++) {
                        if (week === 0 && day < firstDayOfMonth) {
                            html += `<td class="calendar-day"></td>`;
                        } else if (currentDay <= daysInMonth) {
                            html += `
                                <td class="calendar-day" data-day="${currentDay}">
                                    <div>${currentDay}</div>
                                    <div class="add-event" data-bs-toggle="modal" data-bs-target="#addLicenseModal" onclick="setSelectedDay(${currentDay})">➕</div>
                                    <div class="events"></div>
                                </td>
                            `;
                            currentDay++;
                        } else {
                            html += `<td class="calendar-day"></td>`;
                        }
                    }
                    html += "</tr>";
                }
                calendarBody.innerHTML = html;
            }

            // Función para agregar un evento
            function addEvent(day, employeeName, reason) {
                const dayElement = document.querySelector(`.calendar-day[data-day="${day}"] .events`);
                const eventHtml = `
                    <div class="event-item">
                        ${employeeName} - ${reason}
                        <span class="delete-event" onclick="deleteEvent(this)">❌</span>
                    </div>
                `;
                dayElement.innerHTML += eventHtml;
            }

            // Función para eliminar un evento
            window.deleteEvent = function (element) {
                element.parentElement.remove();
            };

            // Establecer el día seleccionado
            window.setSelectedDay = function (day) {
                selectedDay = day;
            };

            // Guardar evento desde el modal
            document.getElementById("saveEvent").addEventListener("click", function () {
                const employeeName = document.getElementById("employeeName").value;
                const reason = document.getElementById("reason").value;
                if (employeeName && reason && selectedDay) {
                    addEvent(selectedDay, employeeName, reason);
                    eventModal.hide();
                    document.getElementById("eventForm").reset();
                }
            });

            // Actualizar el calendario cuando cambia el año o el mes
            yearSelect.addEventListener("change", updateCalendar);
            monthSelect.addEventListener("change", updateCalendar);

            function updateCalendar() {
                const year = parseInt(yearSelect.value);
                const month = parseInt(monthSelect.value);
                generateCalendar(year, month);
            }

            // Generar opciones de años y el calendario inicial al cargar la página
            generateYearOptions();
            updateCalendar();
        });
    </script>
</body>

<?php include 'modals/fechas/addLicenseModal.php'; ?>

<style>
    .calendar-day {
        height: 120px;
        border: 1px solid #dee2e6;
        padding: 10px;
        position: relative;
    }

    .calendar-day:hover {
        background-color: #f8f9fa;
    }

    .add-event {
        position: absolute;
        bottom: 5px;
        right: 5px;
        cursor: pointer;
    }

    .event-item {
        margin-bottom: 5px;
        font-size: 0.9em;
    }

    .event-item .delete-event {
        cursor: pointer;
        color: red;
        margin-left: 5px;
    }
</style>
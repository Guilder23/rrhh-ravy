<?php
header('Content-Type: text/html; charset=utf-8');
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>

<h2 class="titulogestion">Gestión programar turnos</h2>

<div class="containerOptions">
    <section class="columnear">
        <div class="inputArea">
            <label for="area">Buscar</label>
            <input type="text" id="area" placeholder="Ingrese código" oninput="buscarSugerencias(this.value)">
            <div class="ventanaAbajo" id="sugerencias"></div>
        </div>
    </section>

    <button class="btnOption2" data-bs-toggle="modal" data-bs-target="#addTurn">
        <i class="fas fa-calendar-check"></i> Programar turnos
    </button>
    
    
    <button class="btnOption2"><i class="fas fa-users"></i>Trabajadores</button>
    <button class="btnOption2"><i class="fas fa-calendar-day"></i>Feriados</button>
    <i class="fas fa-sync-alt refresh-icon" onclick="actualizarPagina()"></i>
</div>

<section style="width:100%; padding:0 15px; overflow-x:auto;">
    
    <div style="display:flex; gap:20px; align-items:center; justify-content:center; padding:10px; background:#f9f9f9">
         <button type="button" class="btnOption2 nav-arrow" onclick="navegarTrabajador(1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <p style="display:flex; align-items:center; margin:0;"><b>Codigo:<span id="nameTable"></span></b></p> 
            <button type="button" id="botonAsignarTurno" class="btnOption2" style="display: none;" 
                data-bs-toggle="modal" 
                data-bs-target="#addAsigTurn"
                data-codeworker=""
                data-workercode-display=""
                data-fullname="">
                <i class="fas fa-calendar-plus"></i> Asignar Turno
            </button>
        <button type="button" class="btnOption2 nav-arrow" onclick="navegarTrabajador(1)">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    

    <div class="pestOptions">
        <button type="button" id="btn-mes" class="btnPestana blanco" onclick="verPestana('campoMes','btn-mes')">Mes</button>
        <button type="button" id="btn-fecha" class="btnPestana" onclick="verPestana('campoFechas','btn-fecha')">Fecha</button>
    </div>


    <div class="pestanaOption" id="campoMes" style="display:flex;">
        <div class="elem4">
            <label for="anio">Año</label>
            <input type="number" id="anio" name="anio" value="" min="1900" max="2100" />
        </div>
        <div class="elem4">
            <label for="mes">Mes</label>
            <select id="mes" name="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>
        <button id="buscarMes" class="btnOption2" name="buscarMes" onclick="buscarPorMes()">Buscar</button>
    </div>
    
    <div class="pestanaOption" id="campoFechas" style="display:none;">
        <b>Rango de fechas:</b>
        <div class="elem4">
            <span>Fecha inicio</span>
            <input type="date" id="dateinit" name="dateinit">
        </div>
        <div class="elem4">
            <span>Fecha fin</span>
            <input type="date" id="dateend" name="dateend">
        </div>
        <button id="buscarFecha" class="btnOption2" name="buscarFecha" onclick="buscarPorFecha()">Buscar</button>
    </div>
    
    
    <span><strong>TARJETA DE ASISTENCIA</strong></span>
    <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;"  class="tableColor table-stripedCustom">
        <thead>
            <tr>
                <th>Dia</th>
                <th>Fecha</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Hora Prog.</th>
                <th>Hora Trab.</th>
                <th>Extra</th>
                <th>Rec. Noc.</th>
                <th>Notas</th>
                <th>T.Hrs Trab.</th>
            </tr>
        </thead>
        <tbody id="tablaCuerpo"></tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="font-weight: bold;">Total Horas Trabajadas</td>
                <td style="font-weight: bold;" id="totalHorasTrabajadas">00:00:00</td>
            </tr>
        </tfoot>
    </table>
</section>

<script src="../assets/js/bootstrap.bundle.min.js"></script>

<?php include 'modals/turn/addTurn.php'; ?>
<?php include 'modals/turn/addAsigTurn.php'; ?>
<?php include 'modals/gestionturno/getLicenseModal.php'; ?>
<?php include 'modals/gestionturno/acceptModal.php'; ?>

<script>

function verPestana(campoId, botonId) {
    document.getElementById('campoFechas').style.display = 'none';
    document.getElementById('campoMes').style.display = 'none';
    document.getElementById(campoId).style.display = 'flex';
    document.getElementById('btn-fecha').classList.remove('blanco');
    document.getElementById('btn-mes').classList.remove('blanco');
    document.getElementById(botonId).classList.add('blanco');
}

document.addEventListener('DOMContentLoaded', function() {
    const anioInput = document.getElementById('anio');
    const mesSelect = document.getElementById('mes');
    const fechaActual = new Date();
    const añoActual = fechaActual.getFullYear();
    const mesActual = fechaActual.getMonth() + 1;
    anioInput.value = añoActual;
    mesSelect.value = mesActual;
    anioInput.addEventListener('input', function() {
        const anio = anioInput.value;
        if (anio < 1900 || anio > 2100) {
            alert("Por favor, ingrese un año válido entre 1900 y 2100.");
        }
    });
});

function buscarSugerencias(query) {
    if (query.length === 0) {
        document.getElementById('sugerencias').innerHTML = '';
        return;
    }

    fetch('../routes/turn/getworker.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            document.getElementById('sugerencias').innerHTML = data;
        });
}


function seleccionarSugerencia(valor1, valor2, valor3) {
    const codeworker = valor1;
    const fullname = valor2;
    const workercodeDisplay = valor3;

    document.getElementById('area').value = '';
    
    document.getElementById('nameTable').innerText = workercodeDisplay + " - " + fullname;
    document.getElementById('sugerencias').innerHTML = ''; 
    

    cargarTabla(workercodeDisplay);
    verificarTurnosAsignados(workercodeDisplay, fullname, codeworker);
}

function verificarTurnosAsignados(codeworker, fullname, workercodeDisplay) {
    fetch(`../routes/turn/checkAssignedTurns.php?codeworker=${encodeURIComponent(codeworker)}`)
        .then(response => response.json())
        .then(data => {
            const turnosAsignados = data.turnosAsignados;
            const botonAsignarTurno = document.getElementById('botonAsignarTurno');

            if (turnosAsignados.length === 0) {
                botonAsignarTurno.style.display = 'block';
                botonAsignarTurno.setAttribute('data-codeworker', codeworker);
                botonAsignarTurno.setAttribute('data-workercode-display', workercodeDisplay);
                botonAsignarTurno.setAttribute('data-fullname', fullname);
            } else {
                botonAsignarTurno.style.display = 'none';
                console.log("Turnos asignados:", turnosAsignados);
            }
        })
        .catch(error => {
            console.error('Error al verificar turnos asignados:', error);
        });
}

function determinarTurno(hora) {
    const horaDate = new Date(`1970-01-01T${hora}Z`);
    for (let turno of turnos) {
        const inicio = new Date(`1970-01-01T${turno.inicio}Z`);
        const fin = new Date(`1970-01-01T${turno.fin}Z`);
        if (horaDate >= inicio && horaDate < fin) {
            return turno;
        }
    }
    return turnos[2];
}



//////////////////////////
function calcularHorasTrabajadas(ingreso, salida) {
    const ingresoDate = new Date(`1970-01-01T${ingreso}Z`);
    let salidaDate = new Date(`1970-01-01T${salida}Z`);

    if (salidaDate < ingresoDate) {
        salidaDate.setDate(salidaDate.getDate() + 1);
    }

    let horasTrabajadas = (salidaDate - ingresoDate) / (1000 * 60 * 60); 

    // Calcular reconocimiento nocturno (20:00 - 06:00)
    const inicioNoche = new Date(`1970-01-01T20:00:00Z`);
    const finNoche = new Date(`1970-01-02T06:00:00Z`);


    let horasNoche = 0;
    
    if (
        (ingresoDate >= inicioNoche && ingresoDate < finNoche) || 
        (salidaDate > inicioNoche && salidaDate <= finNoche) || 
        (ingresoDate < inicioNoche && salidaDate > finNoche) //
    ) {
        const inicio = Math.max(ingresoDate, inicioNoche);
        const fin = Math.min(salidaDate, finNoche);
        horasNoche = (fin - inicio) / (1000 * 60 * 60); 
    }

    // Calcular horas extras o descuento
    let extras = 0;
    let tHorasTrabajadas = horasTrabajadas;

    if (horasTrabajadas > 8) {
        extras = horasTrabajadas - 8; 
        tHorasTrabajadas = 8; 
    } else if (horasTrabajadas < 8) {
        extras = horasTrabajadas - 8; 
        tHorasTrabajadas = horasTrabajadas; 
    }

    return {
        horaProg: '08:00:00',
        horaTrab: decimalToTime(horasTrabajadas),
        extras: decimalToTime(extras),
        reconocimientoNocturno: horasNoche > 0 ? decimalToTime(horasNoche) : '00:00:00', 
        tHorasTrabajadas: decimalToTime(tHorasTrabajadas)
    };
}
/////////////////////////
function calcularDescuentoDia(tiempo_ingreso, tiempo_salida) {
    const nearestHourEntrada = new Date(Math.round(tiempo_ingreso.getTime() / 3600000) * 3600000);
    let diffEntrada = (nearestHourEntrada - tiempo_ingreso) / (1000 * 60 * 60);

    const nearestHourSalida = new Date(Math.round(tiempo_salida.getTime() / 3600000) * 3600000);
    let diffSalida = (tiempo_salida - nearestHourSalida) / (1000 * 60 * 60);

    if (tiempo_salida < tiempo_ingreso) {
        diffSalida += 24;
    }

    return diffEntrada + diffSalida;
}

function formatHoursMinutesSeconds(diff) {
    const isNegative = diff < 0;
    diff = Math.abs(diff * 3600); 
    const totalSeconds = Math.floor(diff);
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;
    const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    return isNegative ? `-${formattedTime}` : formattedTime;
}


function isValidTimeFormat(time) {
    const timeRegex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
    return timeRegex.test(time);
}

function timeToDecimal(time) {
    const [hours, minutes, seconds] = time.split(':').map(Number);
    return hours + (minutes / 60) + (seconds / 3600);
}

function decimalToTime(decimalHours) {
    const isNegative = decimalHours < 0;
    decimalHours = Math.abs(decimalHours); 

    const hours = Math.floor(decimalHours);
    const remainingMinutes = (decimalHours - hours) * 60;
    const minutes = Math.floor(remainingMinutes);
    const seconds = Math.round((remainingMinutes - minutes) * 60);

    const formattedHours = String(hours).padStart(2, '0');
    const formattedMinutes = String(minutes).padStart(2, '0');
    const formattedSeconds = String(seconds).padStart(2, '0');

    return `${isNegative ? '-' : ''}${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
}

function obtenerDiaSemana(fecha) {
    const diasSemana = ["lun", "mar", "mié", "jue", "vie", "sáb", "dom"]; // Orden empezando desde lunes
    const fechaDate = new Date(fecha);
    const diaNumero = fechaDate.getDay();
    return diasSemana[diaNumero];
}

function cargarTabla(codeworker, dateinit = null, dateend = null, anio = null, mes = null) {
    let url = `../routes/turn/getdate.php?codeworker=${encodeURIComponent(codeworker)}`;

    if (dateinit && dateend) {
        url += `&dateinit=${dateinit}&dateend=${dateend}`;
    } else if (anio && mes) {
        url += `&anio=${anio}&mes=${mes}`;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || "Error al cargar los datos");
            }

            const tbody = document.getElementById('tablaCuerpo');
            tbody.innerHTML = '';

            let totalHorasTrabajadas = 0;

            // Agrupar registros por fecha
            const registrosAgrupados = {};
            data.data.forEach(row => {
                const fecha = row.tickdate; // Agrupar solo por fecha
                if (!registrosAgrupados[fecha]) {
                    registrosAgrupados[fecha] = [];
                }
                registrosAgrupados[fecha].push(row);
            });

            // Recorrer los registros agrupados
            Object.entries(registrosAgrupados).forEach(([fecha, grupo]) => {
                const tr = document.createElement('tr');

                // Día de la semana
                const tdDia = document.createElement('td');
                tdDia.textContent = obtenerDiaSemana(fecha);
                tr.appendChild(tdDia);

                // Fecha
                const tdFecha = document.createElement('td');
                tdFecha.textContent = fecha;
                tr.appendChild(tdFecha);

                // Obtener la primera hora de ingreso y la última hora de salida
                const primeraEntrada = grupo[0].ticktime_in;
                const ultimaSalida = grupo[grupo.length - 1].ticktime_out;

                // Hora de ingreso
                const tdIngreso = document.createElement('td');
                tdIngreso.textContent = primeraEntrada || '';
                tr.appendChild(tdIngreso);

                // Hora de salida
                const tdSalida = document.createElement('td');
                tdSalida.textContent = ultimaSalida || '';
                tr.appendChild(tdSalida);

                if (primeraEntrada && ultimaSalida) {
                    const { horaProg, horaTrab, extras, reconocimientoNocturno, tHorasTrabajadas } = calcularHorasTrabajadas(primeraEntrada, ultimaSalida);

                    // Hora Prog. (fijo)
                    const tdHoraProg = document.createElement('td');
                    tdHoraProg.textContent = horaProg;
                    tr.appendChild(tdHoraProg);

                    // Hora Trab. (tiempo real trabajado)
                    const tdHoraTrab = document.createElement('td');
                    tdHoraTrab.textContent = horaTrab;
                    tr.appendChild(tdHoraTrab);

                    // Extras
                    const tdExtras = document.createElement('td');
                    tdExtras.textContent = extras;
                    tr.appendChild(tdExtras);

                    // Reconocimiento nocturno
                    const tdRecNoc = document.createElement('td');
                    tdRecNoc.textContent = reconocimientoNocturno;
                    tr.appendChild(tdRecNoc);

                    // Sumar al total de horas trabajadas
                    totalHorasTrabajadas += timeToDecimal(tHorasTrabajadas);
                } else {
                    const tdHoraProg = document.createElement('td');
                    tdHoraProg.textContent = '';
                    tr.appendChild(tdHoraProg);

                    const tdHoraTrab = document.createElement('td');
                    tdHoraTrab.textContent = '';
                    tr.appendChild(tdHoraTrab);

                    const tdExtras = document.createElement('td');
                    tdExtras.textContent = '';
                    tr.appendChild(tdExtras);

                    const tdRecNoc = document.createElement('td');
                    tdRecNoc.textContent = '';
                    tr.appendChild(tdRecNoc);
                }
                // Notas
                const tdNotas = document.createElement('td');
                tdNotas.style.verticalAlign = 'middle';
                
                if (grupo.length > 1) {
                    tr.classList.add('table-warning'); 
                
                    const contenedorNotas = document.createElement('div');
                    contenedorNotas.style.display = 'flex';
                    contenedorNotas.style.alignItems = 'center';
                    contenedorNotas.style.gap = '8px';
                
                    // Texto "Observado"
                    const textoObservado = document.createElement('span');
                    textoObservado.textContent = 'Observado';
                    contenedorNotas.appendChild(textoObservado);
                
                    // Botón de aceptar
                    const botonCheck = crearBoton('btn btn-info btn-sm', 'fa-solid fa-check', '', function () {
                        console.log('Botón de aceptar clickeado');
                    });
                    botonCheck.setAttribute('data-bs-toggle', 'modal');
                    botonCheck.setAttribute('data-bs-target', '#acceptModal');
                    
                    botonCheck.setAttribute('data-fecha', grupo[0].tickdate);
                    botonCheck.setAttribute('data-ticktime-out-1', grupo[0].ticktime_out); // Primer horario de salida
                    botonCheck.setAttribute('data-ticktime-in-2', grupo[1].ticktime_in); // Segundo horario de ingreso
                
                    // Botón de editar
                    const botonEditar = crearBoton('btn btn-warning btn-sm', 'fa-solid fa-pen-to-square', '', function () {
                        console.log('Botón de editar clickeado');
                    });
                    botonEditar.setAttribute('data-bs-toggle', 'modal');
                    botonEditar.setAttribute('data-bs-target', '#getLicenseModal');
                    botonEditar.setAttribute('data-codeworker', codeworker);
                    
                    // Agregar datos adicionales al botón de editar
                    botonEditar.setAttribute('data-fecha', grupo[0].tickdate);
                    botonEditar.setAttribute('data-ticktime-in-1', grupo[0].ticktime_in); // Primer horario de ingreso
                    botonEditar.setAttribute('data-ticktime-out-1', grupo[0].ticktime_out); // Primer horario de salida
                    botonEditar.setAttribute('data-ticktime-in-2', grupo[1].ticktime_in); // Segundo horario de ingreso
                    botonEditar.setAttribute('data-ticktime-out-2', grupo[1].ticktime_out); // Segundo horario de salida
                
                    // Botón de eliminar
                    const botonEliminar = crearBoton('btn btn-danger btn-sm', 'fa-solid fa-xmark', '', function () {
                        console.log('Botón de eliminar clickeado');
                    });
                
                    // Agregar botones al contenedor
                    contenedorNotas.appendChild(botonCheck);
                    contenedorNotas.appendChild(botonEditar);
                    contenedorNotas.appendChild(botonEliminar);
                
                    // Agregar el contenedor al tdNotas
                    tdNotas.appendChild(contenedorNotas);
                } else if (primeraEntrada && ultimaSalida) {
                    // Verificar si es un turno noche
                    const ingresoHora = new Date(`1970-01-01T${primeraEntrada}Z`);
                    const salidaHora = new Date(`1970-01-01T${ultimaSalida}Z`);
                
                    if (salidaHora < ingresoHora) {
                        tdNotas.textContent = 'Turno noche';
                    }
                }
                
                // Agregar la celda de notas a la fila
                tr.appendChild(tdNotas);

                // Botones
                function crearBoton(className, icono, texto, onClick) {
                    const boton = document.createElement('button');
                    boton.type = 'button';
                    boton.className = className;
                    boton.innerHTML = `<i class="${icono}"></i> ${texto}`;
                    boton.onclick = onClick;
                    return boton;
                }

                // Total horas trabajadas (por fila)
                const tdTotalHoras = document.createElement('td');
                if (primeraEntrada && ultimaSalida) {
                    const { tHorasTrabajadas } = calcularHorasTrabajadas(primeraEntrada, ultimaSalida);
                    tdTotalHoras.textContent = tHorasTrabajadas;

                    const esObservado = grupo.length > 1;

                    if (esObservado) {
                        tr.classList.add('custom-style-3'); // Fondo blanco
                    } else if (tHorasTrabajadas === '08:00:00') {
                        tr.classList.add('custom-style-2'); // Fondo celeste claro
                    } else if (tHorasTrabajadas < '08:00:00') {
                        tdTotalHoras.classList.add('custom-style-4'); // Fondo naranja oscuro
                    }
                } else {
                    tdTotalHoras.textContent = '';
                }
                tr.appendChild(tdTotalHoras);

                tbody.appendChild(tr);
            });

            // Actualizar el total de horas trabajadas en el tfoot
            const tfoot = document.querySelector('tfoot');
            if (tfoot) {
                const totalHorasFormateadas = decimalToTime(totalHorasTrabajadas);
                tfoot.querySelector('td:last-child').textContent = totalHorasFormateadas;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
}

function buscarPorFecha() {
    const dateinit = document.getElementById('dateinit').value;
    const dateend = document.getElementById('dateend').value;
    const codeworker = document.getElementById('nameTable').innerText.split(' - ')[0];

    if (!dateinit || !dateend) {
        alert("Por favor, seleccione un rango de fechas válido.");
        return;
    }

    cargarTabla(codeworker, dateinit, dateend);
}

function buscarPorMes() {
    const anio = document.getElementById('anio').value;
    const mes = document.getElementById('mes').value;
    const codeworker = document.getElementById('nameTable').innerText.split(' - ')[0];

    if (!anio || !mes) {
        alert("Por favor, seleccione un año y un mes válidos.");
        return;
    }

    cargarTabla(codeworker, null, null, anio, mes);
}

let addModal = document.getElementById('addAsigTurn');

addModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;

    const codeworker = button.getAttribute('data-codeworker');
    const workercodeDisplay = button.getAttribute('data-workercode-display');
    const fullname = button.getAttribute('data-fullname');

    const inputCodeworker = document.getElementById('codeworkerasig');
    const inputWorkercodeDisplay = document.getElementById('workercodeDisplay');
    const inputFullname = document.getElementById('fullname');
    
    inputCodeworker.value = workercodeDisplay;codeworker
    inputWorkercodeDisplay.value = codeworker;
    inputFullname.value = fullname;

    cargarTurnos();
});


// Datos a enviar al modal
document.addEventListener('DOMContentLoaded', function () {
    const getLicenseModal = document.getElementById('getLicenseModal');

    getLicenseModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const codeworker = button.getAttribute('data-codeworker');
        console.log(codeworker);

        const codeworkerHidden = document.getElementById('codeworkerHidden');

        codeworkerHidden.value = codeworker;

        const fecha = button.getAttribute('data-fecha');
        const ticktimeIn1 = button.getAttribute('data-ticktime-in-1');
        const ticktimeOut1 = button.getAttribute('data-ticktime-out-1');
        const ticktimeIn2 = button.getAttribute('data-ticktime-in-2'); 
        const ticktimeOut2 = button.getAttribute('data-ticktime-out-2'); 

        const horarioTrabajoInicio = ticktimeIn1; 
        const horarioTrabajoFin = ticktimeOut2 || ticktimeOut1; 

        let entradasSalidas = `
            <p><strong>Entrada (I):</strong> ${ticktimeIn1}</p>
        `;

        if (ticktimeIn2) {
            entradasSalidas += `
                <p><strong>Entrada (I):</strong> ${ticktimeIn2}</p>
            `;
        }

        if (ticktimeOut1) {
            entradasSalidas += `
                <p><strong>Salida (S):</strong> ${ticktimeOut1}</p>
            `;
        }
        if (ticktimeOut2 && ticktimeOut2 !== ticktimeOut1) {
            entradasSalidas += `
                <p><strong>Salida (S):</strong> ${ticktimeOut2}</p>
            `;
        }

        const horariosObservacion = document.getElementById('horariosObservacion');
        horariosObservacion.innerHTML = `
            <p><strong>Fecha:</strong> ${fecha}</p>
            <p><strong>Horario de Trabajo:</strong> ${horarioTrabajoInicio} - ${horarioTrabajoFin}</p>    
            ${entradasSalidas}
        `;
    });
});
</script>

<style>


:root {
  --custom-color-1: #FFFFFF; /* Blanco */
  --custom-color-2: #CCFFFF; /* Celeste claro */
  --custom-color-3: #FFCC99; /* Naranja claro */
  --custom-color-4: #FF9966; /* Naranja oscuro */
}

.tableColor {
  --bs-table-color: var(--bs-emphasis-color);
  --bs-table-bg: var(--bs-body-bg);
  --bs-table-border-color: var(--bs-border-color);
  --bs-table-accent-bg: transparent;
  --bs-table-striped-color: var(--bs-emphasis-color);
  --bs-table-striped-bg: rgba(var(--bs-emphasis-color-rgb), 0.05);
  --bs-table-active-color: var(--bs-emphasis-color);
  --bs-table-active-bg: rgba(var(--bs-emphasis-color-rgb), 0.1);
  --bs-table-hover-color: var(--bs-emphasis-color);
  --bs-table-hover-bg: rgba(var(--bs-emphasis-color-rgb), 0.075);
  width: 100%;
  margin-bottom: 1rem;
  vertical-align: top;
  border-color: var(--bs-table-border-color);
}

.table-stripedCustom>tbody>tr:nth-of-type(odd)>* {
  --bs-table-color-type: var(--bs-table-striped-color);
  --bs-table-bg-type: var(--bs-table-striped-bg);
}

/*
.table-stripedCustom>tbody>tr:nth-of-type(odd)>* {
    --bs-table-color-type: var(--bs-table-striped-color);
    --bs-table-bg-type: rgb(253 253 253);
}
*/

.tableColor>:not(caption)>*>* {
  padding: .5rem .5rem;
  color: var(--bs-table-color-state, var(--bs-table-color-type, var(--bs-table-color)));
  background-color: var(--bs-table-bg);
  border-bottom-width: var(--bs-border-width);
  box-shadow: inset 0 0 0 9999px var(--bs-table-bg-state, var(--bs-table-bg-type, var(--bs-table-accent-bg)));
}

.custom-style-1 {
  --bs-table-bg: var(--custom-color-1) !important;
  --bs-table-color: #000000;
}

.custom-style-2 {
  --bs-table-bg: var(--custom-color-2) !important;
  --bs-table-color: #000000;
}

.custom-style-3 {
  --bs-table-bg: var(--custom-color-3) !important;
  --bs-table-color: #000000; 
}

.custom-style-4 {
  --bs-table-bg: var(--custom-color-4) !important;
  --bs-table-color: #000000;
}

.blanco {
    background: white;
    box-shadow: 
        5px 0 5px -5px rgba(0, 0, 0, 0.5),
        -5px 0 5px -5px rgba(0, 0, 0, 0.5), 
        0 -5px 5px -5px rgba(0, 0, 0, 0.5); 
}

.pestOptions {
    display: flex;
}

.btnPestana {
    border: 1px solid #cdcdcd;
    border-bottom: none;
    padding: 7px;
}

.pestanaOption {
    display: flex;
    gap: 20px;
    align-items: center;
    padding: 5px 20px;
}

.btnOptionSolo {
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
}

.inputArea {
    position: relative;
    display: flex;
    gap: 5px;
    width: 150px;
    margin-right: 40px;
    color: white;
}
s
.inputArea input {
    width: 137px;
}

.columnear {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.ventanaAbajo {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: #e0e0e0;
    border: 1px solid #333;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 2;
    max-height: 200px;
    overflow-y: auto;
    color: black;
}

.backgroudTable{
  background-color: $yellow-500;
}
</style>
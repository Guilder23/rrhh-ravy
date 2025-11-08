<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<h2 class="titulogestion">Inicio</h2>
<body style="background:#f9f9f9;">
    
    
    
    
<div class="containerContenido" style="align-items:center;">   
<section class="Cuadrografic" style="width:550px; background:rgb(163, 226, 38);">
    <h2>Ingreso</h2>
    <!-- Reloj -->
    <div class="content_cabecera" id="campoCabecera">
        <div class="lateral-Izq" style="display:flex; flex-direction:column; justify-content:center;">
    
             <div id="reloj-container" style="display:flex; flex-direction:column; justify-content:center; gap:0;">
                <div id="reloj-analogico">
                    <!-- Números del reloj -->
                    <div class="numero numero-12">12</div>
                    <div class="numero numero-1">1</div>
                    <div class="numero numero-2">2</div>
                    <div class="numero numero-3">3</div>
                    <div class="numero numero-4">4</div>
                    <div class="numero numero-5">5</div>
                    <div class="numero numero-6">6</div>
                    <div class="numero numero-7">7</div>
                    <div class="numero numero-8">8</div>
                    <div class="numero numero-9">9</div>
                    <div class="numero numero-10">10</div>
                    <div class="numero numero-11">11</div>
                    
                    <!-- Manecillas -->
                    <div id="horero" class="manecilla"></div>
                    <div id="minutero" class="manecilla"></div>
                    <div id="segundero" class="manecilla"></div>
                    <div class="centro"></div>
                </div>
                
                <div id="fecha-hoy-txt"></div>
                <div class="reloj" id="reloj" style="font-size:1rem; margin:0;">
                    <?php
                    $hora_actual = date("H:i:s");
                    echo $hora_actual;
                    ?>
                </div>
             </div>
            
            <div class="containerElmtns">
                <input type="text" id="buscarInput" placeholder="buscar por nombre..." oninput="buscarFilaCodigo()">
                <select id="filtroEstado" onchange="filtrarPorEstado()">
                    <option value="">Todos</option>
                    <option value="I">I</option>
                    <option value="S">S</option>
                    <option value="A">A</option>
                    <option value="R">R</option>
                    <option value="C">C</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
            
        </div><!--fin container cabecera-->
        
        <div class="containerImage">
            <img src="" alt="" class="imgPerfilUser" id="perfil-work">
        </div>
    </div>
    
    <div class="pestaniaUp" onclick="moverPanel();">
        <i class="fas fa-chevron-up"></i>
        <i class="fas fa-chevron-down"></i>
    </div>
    
    <div class="table-container">
        <table id="tablaDatos" class="tableDatos">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Hora</th>
                    <th>M</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se agregarán dinámicamente aquí -->
            </tbody>
        </table>
    </div>
</section>

<div class="Cuadrografic" style="max-width:370px; padding:10px;
   <div class="calendar-container">
        <div class="calendar-header">
            <h2 id="mes-anio"></h2>
            <div class="calendar-controls">
                <button class="btnVerde" onclick="cambiarMes(-1)"><i class="fas fa-chevron-left"></i></button>
                <select id="mes"></select>
                <select id="anio"></select>
                <button class="btnVerde" onclick="cambiarMes(1)"><i class="fas fa-chevron-right"></i></button>
                <button class="btnVerde" onclick="marcarHoy()">Hoy</button>
            </div>
        </div>
        <div class="calendar-grid" id="dias"></div>
    </div>
</div> <!--finCuadroGrafic-->
    
    
    
    
    
    
<section class="containerCuadrografic">
        
    <div class="Cuadrografic">
        <h2>Porcentaje de asistencias por turnos</h2>
        <div style="width:270px; height:270px; display:flex; justify-content:center; align-items:center;" id="graficoTurnoTotal"></div>
    </div>

    <div class="Cuadrografic">
        <h2>Distribución de género por turno</h2>
        <div style="max-width:270px; overflow-x:auto; height:270px; display:flex; justify-content:center; align-items:center;" id="graficoGeneroPorTurno"></div>
    </div>
     
</section>
   
   
   
   
   
   
   
   
   <div class="horizontal-container">
            <input type="hidden" id="getfecha" name="getfecha">
        
            <section class="cuadro bordeVerde"> 
                <div class="containerAreaIcons upIcons">
                    <i class="fas fa-chart-line iconVerde"></i>
                    <div class="miniCuadro">
                        <h2>Total</h2>    
                        <h3>Total: <span id="total">0</span></h3>
                    </div>
                </div>
                <div class="containerAreaIcons">
                     <div class="areaIcon"><i class="fas fa-male hombre"></i><h3>H:  <span id="totalHombres">0</span></h3></div>
                    <div class="areaIcon"><i class="fas fa-female mujer"></i><h3>M:  <span id="totalMujeres">0</span></h3></div>
                </div>
            </section>
        
            <section class="squareTurn cuadro bordeVerde"> 
               <div class="containerAreaIcons upIcons">
                   <i class="fas fa-chart-line iconVerde"></i>
                    <div class="miniCuadro">
                        <h2>Turno 1</h2>    
                        <h3>Total: <span id="turno1Total">0</span></h3>
                    </div>
                </div>
                <div class="containerAreaIcons">
                    <div class="areaIcon"><i class="fas fa-male hombre"></i><h3>H:  <span id="turno1Hombres">0</span></h3></div>
                    <div class="areaIcon"><i class="fas fa-female mujer"></i><h3>M:  <span id="turno1Mujeres">0</span></h3></div>
                </div>
            </section>
        
            <section class="squareTurn cuadro bordeVerde"> 
              <div class="containerAreaIcons upIcons">
                <i class="fas fa-chart-line iconVerde"></i>
                <div class="miniCuadro">
                    <h2>Turno 2</h2> 
                    <h3>Total: <span id="turno2Total">0</span></h3>
                </div>
              </div>
              <div class="containerAreaIcons">
                <div class="areaIcon"><i class="fas fa-male hombre"></i><h3>H:  <span id="turno2Hombres">0</span></h3></div>
                <div class="areaIcon"><i class="fas fa-female mujer"></i><h3>M:  <span id="turno2Mujeres">0</span></h3> </div>
              </div>
            </section>
        
            <section class="squareTurn cuadro bordeVerde"> 
              <div class="containerAreaIcons upIcons">
                <i class="fas fa-chart-line iconVerde"></i>
                <div class="miniCuadro">
                    <h2>Turno 3</h2>    
                    <h3>Total: <span id="turno3Total">0</span></h3>
                </div>
              </div>
              <div class="containerAreaIcons">
                <div class="areaIcon"><i class="fas fa-male hombre"></i><h3>H:  <span id="turno3Hombres">0</span></h3></div>
                <div class="areaIcon"><i class="fas fa-female mujer"></i><h3>M:  <span id="turno3Mujeres">0</span></h3> </div>
              </div>
            </section>
 </div> 
 
 </div> <!--fin containerContenido-->
</body>

 
<script>
//funcion para mover el panel arriba y abajo
function moverPanel() {
    var elemento = document.getElementById('campoCabecera');
    if (elemento.style.display === 'none') {
        elemento.style.display = 'flex';
    } else {
        elemento.style.display = 'none';
    }
}




//funcion para filtrar por odigo los datos en tiempo real
function buscarFilaCodigo() {
    var input = document.getElementById("buscarInput");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("tablaDatos");
    var tbody = table.getElementsByTagName("tbody")[0];
    var rows = tbody.getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        var cell = rows[i].getElementsByTagName("td")[0];
        if (cell) {
            var txtValue = cell.textContent || cell.innerText;
            // Comparar el valor de la celda con el valor del input
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}
function filtrarPorEstado() {
    var select = document.getElementById("filtroEstado");
    var filtro = select.value.toUpperCase();
    var table = document.getElementById("tablaDatos");
    var tbody = table.getElementsByTagName("tbody")[0];
    var rows = tbody.getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        var cell = rows[i].getElementsByTagName("td")[2];
        if (cell) {
            var estado = cell.textContent || cell.innerText;
            if (filtro === "") {
                rows[i].style.display = "";
            } else if (filtro === "OTROS") {
                if (!["I", "S", "A", "R", "C"].includes(estado)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            } else {
                if (estado.toUpperCase() === filtro) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }
    }
}






    // Función para actualizar el reloj
        function actualizarReloj() {
            const fecha = new Date();
            const horas = fecha.getHours();
            const minutos = fecha.getMinutes();
            const segundos = fecha.getSeconds();
            
            // Actualizar reloj digital
            const relojDigital = document.getElementById('reloj');
            relojDigital.textContent = `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
            
            // Actualizar reloj analógico
            const gradosHoras = (horas % 12) * 30 + minutos * 0.5; // 30 grados por hora + 0.5 grados por minuto
            const gradosMinutos = minutos * 6; // 6 grados por minuto
            const gradosSegundos = segundos * 6; // 6 grados por segundo
            
            document.getElementById('horero').style.transform = `rotate(${gradosHoras}deg)`;
            document.getElementById('minutero').style.transform = `rotate(${gradosMinutos}deg)`;
            document.getElementById('segundero').style.transform = `rotate(${gradosSegundos}deg)`;
        }

        // Actualizar inmediatamente y luego cada segundo
        actualizarReloj();
        setInterval(actualizarReloj, 1000);
        
        

        function cargarDatos() {
            const fechaInput = document.getElementById('getfecha').value;
        
            fetch(`../routes/home/getTick.php?fecha=${fechaInput}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Error al cargar los datos');
                    }
        
                    const tabla = document.getElementById('tablaDatos').getElementsByTagName('tbody')[0];
                    tabla.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos
        
                    // Agregar filas con los datos obtenidos
                    data.data.forEach(fila => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>
                              <button class="btn-invi" onclick="mostrarFoto('${fila.workerimg}', '${fila.fullname}')">${fila.fullname}</button>
                            </td>
                            <td>${fila.hora}</td>
                            <td>${fila.tickstate}</td>
                        `;
                        tabla.appendChild(tr);
                    });
        
                    // Agregar filas vacías si es necesario
                    for (let i = 0; i < 3; i++) {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td></td>
                            <td></td>
                            <td></td>
                        `;
                        tabla.appendChild(tr);
                    }
        
                    // Actualizar la imagen del último registro
                    if (data.data.length > 0) {
                        const ultimoRegistro = data.data[data.data.length - 1];
                        const imgContainer = document.querySelector('.containerImage img');
                        const imgPath = ultimoRegistro.workerimg; // Ruta de la imagen del trabajador
                        const defaultImg = ultimoRegistro.workersex === 'F' 
                            ? '/resource/images/foto-perfil-mujer.avif' 
                            : '/resource/images/foto-perfil-hombre.avif';
        
                        // Verificar si la imagen existe
                        fetch(imgPath)
                            .then(response => {
                                if (response.ok) {
                                    imgContainer.src = imgPath; // Cargar la imagen del trabajador
                                } else {
                                    imgContainer.src = defaultImg; // Cargar la imagen por defecto
                                }
                            })
                            .catch(() => {
                                imgContainer.src = defaultImg; // Cargar la imagen por defecto en caso de error
                            });
                    }
        
                    filtrarPorEstado(); // Aplicar filtros después de cargar los datos
                })
                .catch(error => {
                    console.error('Error:', error);
                    limpiarPerfil();;
                });
        }
        
        setInterval(cargarDatos, 1000);
        
        function mostrarFoto(foto, nombre ){
            console.log(foto);
        }

    function determinarTurno(hora) {
    // Convertir la hora a minutos desde medianoche
        const [hh, mm, ss] = hora.split(':').map(Number);
        const minutosDesdeMedianoche = hh * 60 + mm + ss / 60;
    
        // Definir los puntos de corte en minutos desde medianoche
        const corteManana = 7 * 60 + 0;   // 07:00:00
        const corteTarde = 15 * 60 + 0;   // 15:00:00
        const corteNoche = 23 * 60 + 0;   // 23:00:00
    
        // Calcular la distancia a cada punto de corte
        const distanciaManana = Math.abs(minutosDesdeMedianoche - corteManana);
        const distanciaTarde = Math.abs(minutosDesdeMedianoche - corteTarde);
        const distanciaNoche = Math.abs(minutosDesdeMedianoche - corteNoche);
    
        // Determinar el turno más cercano
        if (distanciaManana <= distanciaTarde && distanciaManana <= distanciaNoche) {
            return 'turno1'; // Mañana
        } else if (distanciaTarde <= distanciaNoche) {
            return 'turno2'; // Tarde
        } else {
            return 'turno3'; // Noche
        }
    }

    function actualizarContadores(datos) {
        let total = 0, totalHombres = 0, totalMujeres = 0;
        let turno1Total = 0, turno1Hombres = 0, turno1Mujeres = 0;
        let turno2Total = 0, turno2Hombres = 0, turno2Mujeres = 0;
        let turno3Total = 0, turno3Hombres = 0, turno3Mujeres = 0;
    
        var calendario = document.getElementById('getfecha');
    
        if (datos.length > 0) {
            calendario.value = datos[0].Fecha;
            console.log(datos[0].Fecha);
            obtenerFechaSeleccionada(datos[0].Fecha); //AQUÍ SE DEBE ENLZAR EL CALENDARIO CON EL CODIGO
        }

        datos.forEach(registro => {
            const hora = registro.Hora;
            const sexo = registro.SexoTrabajador;
            const turno = determinarTurno(hora);
    
            total++;
            if (sexo === 'M') totalHombres++;
            else totalMujeres++;
    
            if (turno === 'turno1') {
                turno1Total++;
                if (sexo === 'M') turno1Hombres++;
                else turno1Mujeres++;
            } else if (turno === 'turno2') {
                turno2Total++;
                if (sexo === 'M') turno2Hombres++;
                else turno2Mujeres++;
            } else if (turno === 'turno3') {
                turno3Total++;
                if (sexo === 'M') turno3Hombres++;
                else turno3Mujeres++;
            }
        });
    
        // Actualizar los elementos del DOM con los resultados
        document.getElementById('total').textContent = total;
        document.getElementById('totalHombres').textContent = totalHombres;
        document.getElementById('totalMujeres').textContent = totalMujeres;
    
        document.getElementById('turno1Total').textContent = turno1Total;
        document.getElementById('turno1Hombres').textContent = turno1Hombres;
        document.getElementById('turno1Mujeres').textContent = turno1Mujeres;
    
        document.getElementById('turno2Total').textContent = turno2Total;
        document.getElementById('turno2Hombres').textContent = turno2Hombres;
        document.getElementById('turno2Mujeres').textContent = turno2Mujeres;
    
        document.getElementById('turno3Total').textContent = turno3Total;
        document.getElementById('turno3Hombres').textContent = turno3Hombres;
        document.getElementById('turno3Mujeres').textContent = turno3Mujeres;
    }









function obtenerFechaSeleccionada(dia, mes, anio) {
    const mesFormateado = (mes + 1) < 10 ? `0${mes + 1}` : mes + 1;
    const diaFormateado = dia < 10 ? `0${dia}` : dia;
    const fechaSeleccionada = `${anio}-${mesFormateado}-${diaFormateado}`;
    console.log(mesFormateado, diaFormateado);
    console.log(`${anio}-${mesFormateado}-${diaFormateado}`);
    console.log("Fecha seleccionada2:", fechaSeleccionada);
    fetch(`../routes/home/getData.php?fecha=${fechaSeleccionada}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                actualizarContadores(data.data);
                obtenerDatoTurnos();
            } else {
                console.log('Error:');
                console.error('Error:', data.message);
            }
        })
        .catch(error => {
            console.error('Error en la solicitud fetch:', error);
        });
}



        
    
        
        
        
        //HENRY
        function obtenerDatoTurnos() {
            const secciones = document.querySelectorAll('.squareTurn');
            const coloresEspecificos = ["#FFD700", "#FF8C00", "#191970"];
            const datosGrafico = {
                labels: [],
                datos: [], 
                colores: [] 
            };
            const datosGenero = {
                labels: [],
                hombres: [],
                mujeres: []
            };
            secciones.forEach((seccion, index) => {
                const nombreTurno = seccion.querySelector('h2').textContent;
                const totalTurno = parseInt(seccion.querySelector('h3').textContent.split(':')[1].trim(), 10);
                const hombres = parseInt(seccion.querySelectorAll('h3')[1].textContent.split(':')[1].trim(), 10);
                const mujeres = parseInt(seccion.querySelectorAll('h3')[2].textContent.split(':')[1].trim(), 10);
                let color;
                if (index < coloresEspecificos.length) {
                    color = coloresEspecificos[index];
                } else {
                    color = generarColorAleatorio();
                }
                datosGrafico.labels.push(nombreTurno);
                datosGrafico.datos.push(totalTurno);
                datosGrafico.colores.push(color);
                datosGenero.labels.push(nombreTurno);
                datosGenero.hombres.push(hombres);
                datosGenero.mujeres.push(mujeres);
            });
            generarGraficoTorta(datosGrafico);
            generarGraficoBarrasApiladas(datosGenero);
            cargarDatos();
        }
        function generarColorAleatorio() {
            return `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`;
        }



function generarGraficoTorta(datos) {
    // Obtener el contenedor del gráfico
    const contenedor = document.getElementById('graficoTurnoTotal');

    // Limpiar el contenedor eliminando todos los elementos hijos
    while (contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }

    // Crear un nuevo elemento canvas
    const ctx = document.createElement('canvas');
    ctx.id = 'myChart';
    contenedor.appendChild(ctx);

    // Crear el gráfico
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: datos.labels,
            datasets: [{
                data: datos.datos,
                backgroundColor: datos.colores,
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Desactiva el comportamiento responsive
            maintainAspectRatio: false, // Permite que el gráfico no mantenga la relación de aspecto
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const porcentaje = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${porcentaje}%)`;
                        }
                    }
                }
            }
        }
    });

    // Establecer el tamaño del canvas
    ctx.style.width = '250px';
    ctx.style.height = '250px';
}



  function generarGraficoBarrasApiladas(datos) {
      
    const contenedor = document.getElementById('graficoGeneroPorTurno');

    // Limpiar el contenedor eliminando todos los elementos hijos
    while (contenedor.firstChild) {
        contenedor.removeChild(contenedor.firstChild);
    }
    
    
            const ctx = document.createElement('canvas');
            ctx.id = 'myBarChart';
            document.getElementById('graficoGeneroPorTurno').appendChild(ctx);
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: datos.labels,
                    datasets: [
                        {
                            label: 'Hombres',
                            data: datos.hombres,
                            backgroundColor: 'rgba(54, 162, 235, 1)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Mujeres',
                            data: datos.mujeres,
                            backgroundColor: 'rgba(255, 99, 132, 1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataset.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const porcentaje = ((value / total) * 100).toFixed(2);
                                    return `${label}: ${value} (${porcentaje}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
        

        
        
        
        
    

    //PARA EL CALENDARIO
    //CODIGO DEL CALENDARIO
          const mesSelect = document.getElementById("mes");
        const anioSelect = document.getElementById("anio");
        for (let i = 0; i < 12; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.text = new Date(2023, i, 1).toLocaleString('es-ES', { month: 'long' });
            mesSelect.appendChild(option);
        }
        const anioActual = new Date().getFullYear();
        for (let i = 1950; i <= anioActual + 10; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.text = i;
            anioSelect.appendChild(option);
        }
        function generarCalendario() {
            const mes = parseInt(mesSelect.value);
            const anio = parseInt(anioSelect.value);
            const hoy = new Date();
            const diaHoy = hoy.getDate();
            const mesHoy = hoy.getMonth();
            const anioHoy = hoy.getFullYear();
            const primerDia = new Date(anio, mes, 1).getDay();
            const diasEnMes = new Date(anio, mes + 1, 0).getDate();
            document.getElementById("mes-anio").innerText = new Date(anio, mes).toLocaleString('es-ES', { month: 'long', year: 'numeric' });
            const contenedorDias = document.getElementById("dias");
            contenedorDias.innerHTML = '';
            const nombresDias = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
            nombresDias.forEach(dia => {
                const diaElem = document.createElement("div");
                diaElem.classList.add("calendar-day-header");
                diaElem.innerText = dia;
                contenedorDias.appendChild(diaElem);
            });
            for (let i = 0; i < primerDia; i++) {
                const espacio = document.createElement("div");
                espacio.classList.add("calendar-day", "empty");
                contenedorDias.appendChild(espacio);
            }
            
            
            for (let i = 1; i <= diasEnMes; i++) {
    const dia = document.createElement("div");
    dia.classList.add("calendar-day");
    dia.innerText = i;

    // Si el día, mes y año coinciden con la fecha actual, añade la clase "today"
    if (i === diaHoy && mes === mesHoy && anio === anioHoy) {
        dia.classList.add("today");
    }

    // Añade un evento de clic a cada día
    dia.addEventListener("click", function() {
        document.querySelectorAll(".calendar-day").forEach(d => d.classList.remove("selected"));
        dia.classList.add("selected");
        obtenerFechaSeleccionada(i, mes, anio);
        const diaFormateado = i < 10 ? `0${i}` : i;
        const mesFormateado = (mes + 1) < 10 ? `0${mes + 1}` : mes + 1;
        const fechaSeleccionada = `${anio}-${mesFormateado}-${diaFormateado}`;
        document.getElementById('getfecha').value = fechaSeleccionada;
    });
    contenedorDias.appendChild(dia);
}


        }
        mesSelect.value = new Date().getMonth();
        anioSelect.value = new Date().getFullYear();
        mesSelect.addEventListener("change", generarCalendario);
        anioSelect.addEventListener("change", generarCalendario);

        generarCalendario();
        marcarHoy();

        function cambiarMes(direccion) {
            let mes = parseInt(mesSelect.value);
            let anio = parseInt(anioSelect.value); 
            mes += direccion; 
            if (mes < 0) {
                mes = 11;
                anio -= 1;
            } else if (mes > 11) {
                mes = 0;
                anio += 1;
            }     
            mesSelect.value = mes;
            anioSelect.value = anio;
            generarCalendario();
        }
        function marcarHoy() {
    const hoy = new Date();
    const diaHoy = hoy.getDate();
    const mesHoy = hoy.getMonth(); // 0-11 (enero=0)
    const anioHoy = hoy.getFullYear();     
    
    mesSelect.value = mesHoy;
    anioSelect.value = anioHoy;
    generarCalendario();
    const dias = document.querySelectorAll(".calendar-day");
    dias.forEach(dia => {
        dia.classList.remove("selected");
        if (parseInt(dia.innerText) === diaHoy) {
            dia.classList.add("selected");
            obtenerFechaSeleccionada(diaHoy, mesHoy, anioHoy);
        }
    });
    asignarTextoHoy(diaHoy, mesHoy, anioHoy);
    limpiarPerfil();
    const diaFormateado = diaHoy < 10 ? `0${diaHoy}` : diaHoy;
    const mesFormateado = (mesHoy + 1) < 10 ? `0${mesHoy + 1}` : mesHoy + 1;
    document.getElementById('getfecha').value = `${anioHoy}-${mesFormateado}-${diaFormateado}`;
}



        function asignarTextoHoy(dia, mes, anio) {
            const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            
            const fecha = new Date(anio, mes, dia);
            const nombreDia = diasSemana[fecha.getDay()];
            const nombreMes = meses[mes];
            
            const textoFecha = `${nombreDia} ${dia} de ${nombreMes} ${anio}`;
            document.getElementById("fecha-hoy-txt").textContent = textoFecha;
        }
        
function limpiarPerfil() {
    const imgContainer = document.querySelector('.containerImage img');
    imgContainer.src = '';
}


</script>







<style>


.containerContenido{
 display:flex;
 flex-wrap:wrap;
 justify-content:center;
 gap:10px;
 padding:10px 30px;
}

    .container {
        padding: 10px;
        margin-bottom: 10px;
    }
    .horizontal-container {
        display: flex;
        flex-wrap:wrap;
        justify-content: center;
        gap:20px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
    
    
    
    

    
    
    /*henry*/
    .cuadro{
        width:250px; 
        border:1px solid #cdcdcd;
        border-radius:15px;
        padding:10px 20px;
        background:white;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
    }
    .cuadro h2{
       font-size: 1.2rem;     
    }
    .cuadro h3{
       font-size:1rem;  
    }
    
    

    .containerAreaIcons{
        display:flex; gap:20px;
        justify-content:center;
        font-size:3rem;
    }

    .areaIcon{
       display:flex; flex-direction:column; justify-content:center; align-items:center; gap:5px;
    }
    .areaIcon h3{
        margin:0;
        font-size:0.8rem;
        color:#333;
    }
    
    .hombre{
        color:blue;
    }
    .mujer{
        color:pink;
    }
    
    
   .iconVerde{
       color: #7fbc03;
   }
   
   .miniCuadro{
       background: rgba(127, 188, 3, 1);
       border-radius:7px;
       padding:5px 10px;
       color:white;
   }
    .miniCuadro h3, .miniCuadro h2{
        margin:0;
    }
   .upIcons{
       display:flex; align-items:center; padding:10px 5px;
   }
   .bordeVerde{
       border: 2px solid #7fbc03;
   }
    
    
    
    
    
    
    
    
    
    
    .containerCuadrografic{
        display:flex; flex-wrap:wrap; gap:20px; justify-content:center;
    }
    .Cuadrografic{
        padding:5px 10px;
        background:white;
        border-radius:15px;
        border: 1px solid #cdcdcd;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
    .Cuadrografic h2{
        text-align:center;
        font-size:1.3rem;
        font-weight:bold;
        margin-top:10px;
        width:300px;
    }
    canvas {
      box-sizing: border-box;
    }

    
    
    
    
/*Calendario*/
.container {
    padding: 10px;
    margin-bottom: 10px;
}
.horizontal-container {
    display: flex;
    flex-wrap:wrap;
    justify-content: center;
    gap:20px;
    margin-bottom: 10px;
    margin-top: 10px;
}
    
.calendar-container {
    max-width: 350px;
    margin: 0 auto;
    padding: 20px;
    background:none;
}
.calendar-header {
    display: flex;
    flex-direction:column;
    align-items: center;
    margin-bottom: 20px;
}
.calendar-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #333;
}
.calendar-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}
.calendar-controls select {
    padding: 2px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 0.9rem;
}
.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}
.calendar-day-header {
    padding: 10px;
    font-weight: bold;
    background-color: rgb(163, 226, 38);
    border-radius: 5px;
    text-align: center;
    color: #555;
}
.calendar-day {
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    border:1px solid rgb(163, 226, 38);;
}
.calendar-day:hover {
    background-color: #f1f1f1;
}
.calendar-day.today {
    background-color: #7fbc03;
    color: white;
    font-weight: bold;
}
.calendar-day.selected {
    background-color: #333;
    color: white;
}
.calendar-day.empty {
    visibility: hidden;
}
.btnVerde{
    background: rgb(163, 226, 38);
    color:white;
    padding:7px;
    border:1px solid #cdcdcd;
    border-radius:7px;
    cursor: pointer;
    font-size: 1rem;
}







    /*estilos de la tabla */
        .content_cabecera{
            display:flex;
            width:100%;
            margin-bottom:7px;
        }
        .lateral-Izq{
            width:60%;
        }
        .containerImage{
            width:35%;
        }
        .imgPerfilUser{
           display:flex;
           margin:auto;
           width:150px;
           height:150px;
           object-fit:cover;
           background: #f0f0f0;
           border:1px solid #f0f0f0;
        }
        
        
        .reloj{
          text-align:center;
          font-size: 1.3rem;
          color:#333;
          font-weight:bold;
        }
        .containerElmtns {
           display:flex; align-items:center; justify-content:center; gap:30px; padding:10px 0; margin:0;
        }
        .containerElmtns input, .containerElmtns select{
            font-size:0.9rem; border-radius:5px; border: 1px solid #cdcdcd; padding:5px;
        }
         .containerElmtns select{
             padding:7px;
        }
 
 
        .pestaniaUp {
          width:100%; text-align:center;
          border-radius:7px 7px 0 0; cursor:pointer;
          border:1px solid #f0f0f0; border-bottom:none;
          box-shadow: 0 -4px 6px -2px rgba(0, 0, 0, 0.3);
          transition: transform 0.3s ease, background 0.3s ease;
          font-size:1.1rem;
        }
       .pestaniaUp:hover{
           background: rgb(194, 236, 115); 
           transform: translateY(-3px);
        }
     /* Estilos generales para la tabla */
     /* Contenedor para la tabla con scroll */
    .table-container {
        max-height: 250px;
        overflow-y: auto;
        border: 1px solid #dddddd;
        margin-bottom: 25px;
        width:100%;
    }
    /* Estilos generales para la tabla */
    .tableDatos {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9em;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-width: 480px;
    }
    
    /* Fijar el encabezado */
    .tableDatos thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    /* Estilos para el encabezado de la tabla */
    .tableDatos thead tr {
        background-color: rgb(163, 226, 38);
        color: #333;
        text-align: left;
    }
    
    /* Estilos para las celdas */
    .tableDatos th,
    .tableDatos td {
        padding: 6px 8px;
        border: 1px solid #dddddd;
    }
    
    /* Estilos para las filas del cuerpo */
    .tableDatos tbody tr {
        background: white;
    }
    
    /* Filas pares */
    .tableDatos tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }
    
    /* Hover en filas */
    .tableDatos tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
    
    /* Última fila */
    .tableDatos tbody tr:last-of-type {
        border-bottom: 2px solid rgb(163, 226, 38);
    }
    
    
    
    
    /*Estilo css del reloj redondo*/
#reloj-container {
    display: flex;
    align-items: center;
    gap: 20px;
}

#reloj-digital {
    font-family: 'Arial', sans-serif;
    font-size: 1.5rem;
    font-weight: bold;
}

#reloj-analogico {
    width: 120px;
    height: 120px;
    border: 5px solid #333;
    border-radius: 50%;
    position: relative;
    background-color: #f8f8f8;
}

.manecilla {
    position: absolute;
    left: 50%;
    bottom: 50%;
    transform-origin: 50% 100%;
    background-color: #333;
}

#horero {
    width: 4px;
    height: 30px;
    margin-left: -2px;
}

#minutero {
    width: 3px;
    height: 48px;
    margin-left: -1.5px;
}

#segundero {
    width: 1px;
    height: 47px;
    margin-left: -0.5px;
    background-color: red;
}

.centro {
    position: absolute;
    width: 8px;
    height: 8px;
    background-color: #333;
    border-radius: 50%;
    left: 50%;
    top: 50%;
    margin-left: -4px;
    margin-top: -4px;
    z-index: 10;
}

.numero {
    position: absolute;
    width: 16px;
    height: 16px;
    text-align: center;
    font-family: Arial, sans-serif;
    font-weight: bold;
    font-size: 12px;
    transform-origin: 50% 50%;
}

.numero-12 { top: 6px; left: 50%; transform: translateX(-50%); }
.numero-1 { top: 12px; right: 30px; }
.numero-2 { top: 30px; right: 15px; }
.numero-3 { top: 50%; right: 6px; transform: translateY(-50%); }
.numero-4 { bottom: 30px; right: 15px; }
.numero-5 { bottom: 12px; right: 30px; }
.numero-6 { bottom: 6px; left: 50%; transform: translateX(-50%); }
.numero-7 { bottom: 12px; left: 30px; }
.numero-8 { bottom: 30px; left: 15px; }
.numero-9 { top: 50%; left: 6px; transform: translateY(-50%); }
.numero-10 { top: 30px; left: 15px; }
.numero-11 { top: 12px; left: 30px; } 

.btn-invi{
    border:none;
    background:none;
    width:100%;
    text-align:start;
}
</style>

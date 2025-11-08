<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>
</head>
<body>
<nav class="menu-lateral">
    <button id="btn-inicio" onclick="link('Inicio');">
        <div class="containerLetraIcon">
            <i class="fas fa-users"></i><span class="letrasBtns">INICIO</span>
        </div>
    </button>
    <button id="btn-trabajadores" onclick="link('trabajadores');">
        <div class="containerLetraIcon">
            <i class="fas fa-users"></i><span class="letrasBtns">TRABAJADORES</span>
        </div>
    </button>

    <button onclick="desplegarSubMenu('organizacion')">
        <div class="containerLetraIcon">
            <i class="fas fa-sitemap"></i><span class="letrasBtns">ORGANIZACION</span>
        </div>
        <span class="arrow" id="arrow-organizacion"><i class="fa-solid fa-caret-right"></i></span>
    </button>
    <ul class="submenu" id="organizacion">
        <button id="btn-area" onclick="link('subviews/area');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">√Årea</span>
            </div>
        </button>
        <button id="btn-cargo" onclick="link('subviews/cargo');">
            <div class="containerLetraIcon">
                <i class="fas fa-user-tie"></i><span class="letrasBtns">Cargo</span>
            </div>
        </button>
        <button id="btn-seccion" onclick="link('subviews/section');">
            <div class="containerLetraIcon">
                <i class="fas fa-layer-group"></i><span class="letrasBtns">Secci√≥n</span>
            </div>
        </button>
    </ul>

    <button onclick="desplegarSubMenu('turnos')">
        <div class="containerLetraIcon">
            <i class="fas fa-calendar-alt"></i><span class="letrasBtns">TURNOS</span>
        </div>
        <span class="arrow" id="arrow-turnos"><i class="fa-solid fa-caret-right"></i></span>
    </button>
    <ul class="submenu" id="turnos">
        <button id="btn-gestionTurnos" onclick="link('gestionturnos');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Tarjeta de Asistencias</span>
            </div>
        </button>
        <button id="btn-progTurnos" onclick="link('turnos');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Prog. Turnos</span>
            </div>
        </button>
        <button id="btn-turnotrabajador" onclick="link('turnotrabajador');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Asig. Turno Trabajador</span>
            </div>
        </button>
        <button id="btn-turnoarea" onclick="link('turnoarea');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Asig. Turno Area</span>
            </div>
        </button>
    </ul>

    <button onclick="desplegarSubMenu('asistencias')">
        <div class="containerLetraIcon">
            <i class="fas fa-sitemap"></i><span class="letrasBtns">ASISTENCIAS</span>
        </div>
        <span class="arrow" id="arrow-asistencias"><i class="fa-solid fa-caret-right"></i></span>
    </button>
    <ul class="submenu" id="asistencias">
        <button id="btn-gestion" onclick="link('asistencias');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Gesti√≥n</span>
            </div>
        </button>
        <button id="btn-approved" onclick="link('subviews/approved');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Aprobados</span>
            </div>
        </button>
        <button id="btn-vacaciones" onclick="link('subviews/vacation');">
            <div class="containerLetraIcon">
                <i class="fas fa-building"></i><span class="letrasBtns">Vacaciones</span>
            </div>
        </button>
        <button id="btn-feriadosfijos" onclick="link('subviews/feriados');">
            <div class="containerLetraIcon">
                <i class="fas fa-user-tie"></i><span class="letrasBtns">Feriados Fijos</span>
            </div>
        </button>

        <button onclick="desplegarSubMenu('licencias')">
            <div class="containerLetraIcon">
                <i class="fas fa-id-card"></i><span class="letrasBtns">Licencias</span>
            </div>
            <span class="arrow" id="arrow-licencias"><i class="fa-solid fa-caret-right"></i></span>
        </button>
            <ul class="submenu2" id="licencias">
                <button id="btn-registrar" onclick="link('subviews/registrar');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-layer-group"></i><span class="letrasBtns">Registrar</span>
                    </div>
                </button>
                <button id="btn-porFechas" onclick="link('subviews/fechas');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-layer-group"></i><span class="letrasBtns">Por fechas</span>
                    </div>
                </button>
                <button id="btn-motivos" onclick="link('subviews/motivos');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-layer-group"></i><span class="letrasBtns">Motivos</span>
                    </div>
                </button>
            </ul>
    </ul><!--fin asistencias-->
    
    
    
    
    
  
    
    
    
    <button onclick="desplegarSubMenu('movimientos')">
        <div class="containerLetraIcon">
            <i class="fas fa-sitemap"></i><span class="letrasBtns">MOVIMIENTOS</span>
        </div>
        <span class="arrow" id="arrow-movimientos"><i class="fa-solid fa-caret-right"></i></span>
    </button>
    <ul class="submenu" id="movimientos">
        <button onclick="desplegarSubMenu('bonos')">
                <div class="containerLetraIcon">
                    <i class="fas fa-id-card"></i><span class="letrasBtns">Bonos</span>
                </div>
                <span class="arrow" id="arrow-bonos"><i class="fa-solid fa-caret-right"></i></span>
        </button>
            <ul class="submenu2" id="bonos">
                <button id="btn-antiguedad" onclick="link('subviews/antiguedad');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-building"></i><span class="letrasBtns">Bono de Antiguedad</span>
                    </div>
                </button>
                <button id="btn-bonotrabajador" onclick="link('subviews/bonotrabajador');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-building"></i><span class="letrasBtns">Bono Trabajador</span>
                    </div>
                </button>
                
                <button id="btn-bonogroup" onclick="link('subviews/bonogroup')"><!--NUEVO AGREGADO-->
                    <div class="containerLetraIcon">
                        <i class="fas fa-building"></i><span class="letrasBtns">Bono por area o seccion</span>
                    </div>
                </button>
                
                <button id="btn-bonoturn" onclick="link('subviews/bonoturn')">
                    <div class="containerLetraIcon">
                        <i class="fas fa-building"></i><span class="letrasBtns">Bono por turnos</span>
                    </div>
                </button>
        
                <button id="btn-bono" onclick="link('subviews/bono')">
                    <div class="containerLetraIcon">
                        <i class="fas fa-building"></i><span class="letrasBtns">Tipos de Bono</span>
                    </div>
                </button>
            </ul>
        <button onclick="desplegarSubMenu('descuentos')">
            <div class="containerLetraIcon">
                <i class="fas fa-id-card"></i><span class="letrasBtns">Descuentos</span>
            </div>
            <span class="arrow" id="arrow-descuentos"><i class="fa-solid fa-caret-right"></i></span>
        </button>
            <ul class="submenu2" id="descuentos">
                <button id="btn-registrardesc" onclick="link('subviews/registrardesc');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-layer-group"></i><span class="letrasBtns">Registrar</span>
                    </div>
                </button>
                <button id="btn-asignardesc" onclick="link('subviews/asignardesc');">
                    <div class="containerLetraIcon">
                        <i class="fas fa-layer-group"></i><span class="letrasBtns">Asignar descuentos</span>
                    </div>
                </button>
            </ul>        
    </ul>


    <button id="btn-usuarios" onclick="link('usuarios');">
        <div class="containerLetraIcon">
            <i class="fas fa-user"></i><span class="letrasBtns">USUARIOS</span>
        </div>
    </button>
</nav>


    

<script>

    //Funcion del boton que actualiza la pagina
    function actualizarPagina() {
        location.reload(); 
    }
    
    
    //funcion para desplegar el menu y pintar el boton que corresponde
    function desplegarSubMenu(id) {
        var submenu = document.getElementById(id);
        var arrow = document.getElementById('arrow-' + id);
        
        if (submenu.style.display === "block") {
            submenu.style.display = "none";
            if (arrow) arrow.classList.remove("rotate");
        } else {
            submenu.style.display = "block";
            if (arrow) arrow.classList.add("rotate");
        }
    }
    function pintar(id) {
        let elemento = document.getElementById(id);
            elemento.classList.add("pintar");
    }
    function link(parametro) {
     location.href = 'index.php?p=' + parametro;
    }

    const botones = {
    'Inicio': 'btn-inicio',
    'trabajadores': 'btn-trabajadores',
    'gestionturnos': 'btn-gestionTurnos',
    'turnos': 'btn-progTurnos',
    'turnotrabajador': 'btn-turnotrabajador',
    'turnoarea': 'btn-turnoarea',
    'subviews/area': 'btn-area',
    'subviews/cargo': 'btn-cargo',
    'subviews/section': 'btn-seccion',
    'asistencias': 'btn-gestion',
    'subviews/approved': 'btn-approved',
    'subviews/vacation': 'btn-vacaciones',
    'subviews/feriados': 'btn-feriadosfijos',
    'subviews/registrar': 'btn-registrar',
    'subviews/fechas': 'btn-porFechas',
    'subviews/motivos': 'btn-motivos',
    'subviews/antiguedad': 'btn-antiguedad',
    'subviews/bonotrabajador': 'btn-bonotrabajador',
    
    'subviews/bonogroup': 'btn-bonogroup',
    'subviews/bonoturn': 'btn-bonoturn',
    'subviews/bono': 'btn-bono',
    'subviews/registrardesc': 'btn-registrardesc',
    'subviews/asignardesc': 'btn-asignardesc',
    'usuarios': 'btn-usuarios',
    };

    // Funci®Æn para resaltar el bot®Æn activo
    function resaltarBoton() {
        const urlParams = new URLSearchParams(window.location.search);
        const parametro = urlParams.get('p');
    
        // Mapeo de par®¢metros a submen®≤s
        const submenuMap = {
            'subviews/area': ['organizacion'],
            'subviews/cargo': ['organizacion'],
            'subviews/section': ['organizacion'],
            'asistencias': ['asistencias'],
            
            'gestionturnos': ['gestionturnos', 'turnos'],
            'turnos': ['gestionturnos', 'turnos'],
            'turnotrabajador': ['gestionturnos', 'turnos'],
            'turnoarea': ['gestionturnos', 'turnos'],
            
            'subviews/vacation': ['asistencias'],
            'subviews/feriados': ['asistencias'],
            'subviews/approved': ['asistencias'],
            'subviews/registrar': ['asistencias', 'licencias'],
            'subviews/fechas': ['asistencias', 'licencias'],
            'subviews/motivos': ['asistencias', 'licencias'],
            
            'subviews/antiguedad': ['movimientos', 'bonos'],
            'subviews/bonotrabajador': ['movimientos', 'bonos'],
            'subviews/bonogroup': ['movimientos', 'bonos'],
            'subviews/bonoturn': ['movimientos', 'bonos'],
            'subviews/bono': ['movimientos', 'bonos'],
            'subviews/registrardesc': ['movimientos', 'descuentos'],
            'subviews/asignardesc': ['movimientos', 'descuentos'],
        };
    
        // Resaltar el bot®Æn correspondiente
        if (botones[parametro]) {
            const boton = document.getElementById(botones[parametro]);
            if (boton) {
                boton.classList.add('pintar');
            }
        }
    
        // Mostrar los submen®≤s correspondientes
        if (submenuMap[parametro]) {
            submenuMap[parametro].forEach(submenuId => {
                const submenu = document.getElementById(submenuId);
                if (submenu) {
                    submenu.style.display = 'block';
                }
            });
        }
    }
    window.onload = resaltarBoton;
</script>



        <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .menu-lateral {
            width: 200px;
            background: #333;
            color: white;
            padding: 15px;
            height: 100%; 
            box-sizing: border-box;
            position: fixed;
            top: 10;
            left: 0;
            overflow-x:auto;
            padding-bottom:70px;
        }

        .menu-lateral button, .submenu button{
            transition: transform 0.3s ease, background 0.2s ease;
            border: none;
            width: 100%;
            color: white;
            text-align: left;
        }
        
        
        .letrasBtns{
           font-size: 13px;
        }
        .menu-lateral button {
            padding: 8px;
            background: #7fbc03;
            border-color: #7fbc03;  
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-lateral button:hover {
            background: rgb(163, 226, 38);
            transform: translateY(-3px);
        }

        .submenu, .submenu2{
            list-style: none;
            display: none;
            padding-left: 15px;
        }
        .submenu {
            background: rgba(51, 51, 51, 0.5);
        }

        .submenu button {
            padding: 8px;
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .submenu button:hover {
            background: rgba(88, 88, 88, 0.5);
            transform: translateY(-3px);
        }

        .submenu2 {
            background: rgba(88, 88, 88, 0.5);
        }


        .arrow {
            transition: transform 0.3s ease;
        }

        .rotate {
            transform: rotate(90deg);
        }

        .containerLetraIcon{
            display:flex;
            gap:20px;
        }
        .containerLetraIcon i{
           font-size:20px;
        }

        .pintar {
            position:relative;
            font-weight: bold;
            transform: scale(1.02);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
            box-shadow: 
                3px 3px 5px rgba(0, 0, 0, 0.7); 
            border-radius: 5px;
        }
        .pintar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(145deg, #444, #111); 
            z-index: -1;
            border-radius: 5px;
            border:2px solid white;
        }
        
        
@media (max-width: 768px) {
    .menu-lateral {
      width: 80px;
      padding:0;
    }
    .letrasBtns{
        display:none;
    }
    .containerLetraIcon i{
        font-size:1.9rem;
    }
}
@media (min-width: 768px) and (max-width: 1024px) {
     .menu-lateral {
      width: 180px;
    }
    .containerLetraIcon, .menu-lateral button{
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }
}

    </style>


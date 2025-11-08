<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/config/database.php');
    $database = new Database('local');
    $conn = $database->getConnection(); 
    if (!$conn) {
        die("Error de conexión a la base de datos.");
    }
    $sqlTurns = "SELECT codeturn, turnname, turnstart, turnend FROM turn WHERE turndelete = 0";
    $stmt = $conn->prepare($sqlTurns);
    $stmt->execute(); 
    $turns = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- Modal -->
<div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="width:96%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agregarWorkerModalLabel">Agregar Trabajador</h1>
                <button type="button" id="btn-cerrar-modal" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
   
                
                
                
<form method="post" id="formTrabajador" enctype="multipart/form-data" >        
     <input type="text" id="code_worker" readonly>
<section class="acordeon">
      <div class="panel">
        <button type="button" class="pestaniaAcordeon" id="pestana2" onclick="desplazarPanel('pestana2')">
            <h3>SECCION AUTOGESTION<span>*</span></h3>
        </button>
        <div class="panel-contenido">
                <div class="separar">
                    <div class="mitad">
                        <div class="elementoForm">
                            <label for="workercode" class="labelForm">Código de Trabajador:</label>
                            <input type="text" name="workercode" id="workercode" class="form-control" required>
                        </div>
                        <div class="elementoForm">
                            <label for="workername1" class="labelForm">Primer Nombre:</label>
                            <input type="text" name="workername1" id="workername1" class="form-control" required>
                        </div>
                        <div class="elementoForm">
                            <label for="workername2" class="labelForm">Segundo Nombre:</label>
                            <input type="text" name="workername2" id="workername2" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workerlastname1" class="labelForm">Primer Apellido:</label>
                            <input type="text" name="workerlastname1" id="workerlastname1" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workerlastname2" class="labelForm">Segundo Apellido:</label>
                            <input type="text" name="workerlastname2" id="workerlastname2" class="form-control">
                        </div>
                        <div class="mb-3 elementoForm">
                            <label for="workerhousbandname" class="labelForm">Nombre del Cónyuge:</label>
                            <input type="text" name="workerhousbandname" id="workerhousbandname" class="form-control">
                        </div>
                        <div class="mb-3 elementoForm">
                            <label for="workerbirthdate" class="labelForm">Fecha de Nacimiento:</label>
                            <input type="date" name="workerbirthdate" id="workerbirthdate" class="form-control">
                        </div>
                        <div class="mb-3 elementoForm">
                            <!--Se cambió el tipo text a combobox-->
                            <label for="workertypedoc" class="labelForm">Tipo de Documento:</label>
                            <select name="workertypedoc" id="workertypedoc" class="form-control">
                                <option value="">Seleccione...</option>
                                <option value="CI">Cédula de Identidad</option>
                                <option value="DNI">Documento Nacional de Identidad</option>
                                <option value="PAS">Pasaporte</option>
                                <option value="RUN">Registro Único Nacional</option>
                                <option value="EXT">Carnet de Extranjería</option>
                            </select>
                        </div>
                        <div class="elementoForm">
                            <label for="workerdocnumber" class="labelForm">Número de Documento:</label>
                            <input type="text" name="workerdocnumber" id="workerdocnumber" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workerdoccity" class="labelForm">Ciudad de Documento:</label>
                            <input type="text" name="workerdoccity" id="workerdoccity" class="form-control">
                        </div>
                        <!--Se agregó el NIT como extra-->
                        <div class="elementoForm">
                            <label for="workernit" class="labelForm">NIT:</label>
                            <input type="text" name="workernit" id="workernit" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workersecurenum" class="labelForm">Número de Seguro Social:</label>
                            <input type="text" name="workersecurenum" id="workersecurenum" class="form-control">
                        </div>
                    </div><!--fin mitad-->
                      
                   <div class="mitad">
                        <div class="elementoForm">
                            <label for="workercuanum" class="labelForm">Número CUA:</label>
                            <input type="text" name="workercuanum" id="workercuanum" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workercity" class="labelForm">Ciudad:</label>
                            <input type="text" name="workercity" id="workercity" class="form-control">
                        </div>
                        <!--Se agregó extra para nacionalidad-->
                        <div class="elementoForm">
                            <label for="workernationality" class="labelForm">Nacionalidad:</label>
                            <select name="workernationality" id="workernationality" class="form-control">
                                <option value="">Seleccione...</option>
                                <option value="Argentina">Argentina</option>
                                <option value="Bolivia">Bolivia</option>
                                <option value="Brasil">Brasil</option>
                                <option value="Canada">Canadá</option>
                                <option value="Chile">Chile</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Costa_Rica">Costa Rica</option>
                                <option value="Cuba">Cuba</option>
                                <option value="Ecuador">Ecuador</option>
                                <option value="El_Salvador">El Salvador</option>
                                <option value="Guatemala">Guatemala</option>
                                <option value="Honduras">Honduras</option>
                                <option value="Mexico">México</option>
                                <option value="Nicaragua">Nicaragua</option>
                                <option value="Panama">Panamá</option>
                                <option value="Paraguay">Paraguay</option>
                                <option value="Peru">Perú</option>
                                <option value="Republica_Dominicana">República Dominicana</option>
                                <option value="Uruguay">Uruguay</option>
                                <option value="USA">Estados Unidos</option>
                                <option value="Venezuela">Venezuela</option>
                                <!-- Europa -->
                                <option value="Espania">España</option>
                                <option value="Italia">Italia</option>
                                <option value="Alemania">Alemania</option>
                                <option value="Francia">Francia</option>
                                <option value="Paises_Bajos">Países Bajos</option>
                                <option value="Reino_Unido">Reino Unido</option>
                                <option value="Portugal">Portugal</option>
                                <option value="Suiza">Suiza</option>
                                <!-- Asia y Oceanía -->
                                <option value="China">China</option>
                                <option value="Japon">Japón</option>
                                <option value="Corea_Sur">Corea del Sur</option>
                                <option value="India">India</option>
                                <option value="Filipinas">Filipinas</option>
                                <option value="Tailandia">Tailandia</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Turquia">Turquía</option>
                                <option value="Australia">Australia</option>
                                <option value="Nueva_Zelanda">Nueva Zelanda</option>
                            </select>
                        </div>
            
                        <div class="elementoForm">
                            <label for="workerphone1" class="labelForm">Teléfono 1:</label>
                            <input type="text" name="workerphone1" id="workerphone1" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workerphone2" class="labelForm">Teléfono 2:</label>
                            <input type="text" name="workerphone2" id="workerphone2" class="form-control">
                        </div>
                         <div class="elementoForm">
                            <label for="workeraddress" class="labelForm">Dirección:</label>
                            <input type="text" name="workeraddress" id="workeraddress" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workeremail" class="labelForm">Correo Electrónico:</label>
                            <input type="email" name="workeremail" id="workeremail" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workersex">Sexo:</label>
                            <select id="workersex" name="workersex">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        
                        <div class="elementoForm">
                            <label for="workerdateinit" class="labelForm">Inicio del Contrato:</label>
                            <input type="date" name="workerdateinit" id="workerdateinit" class="form-control">
                        </div>
                        <div class="elementoForm">
                            <label for="workerdateout" class="labelForm">Fecha Finalización del Contrato:</label>
                            <input type="date" name="workerdateout" id="workerdateout" class="form-control">
                        </div>

                        
                        <div class="elementoForm">
                            <label for="workercivilstatus">Estado Civil:</label>
                            <select id="workercivilstatus" name="workercivilstatus">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="soltero">Soltero/a</option>
                                <option value="casado">Casado/a</option>
                                <option value="divorciado">Divorciado/a</option>
                                <option value="viudo">Viudo/a</option>
                            </select>
                        </div>
                        <!--funciona, pero sería ideal cambiar por el mismo nombre que en la ba se de datos: workerbanknum-->
                        <div class="elementoForm">
                             <label for="accountMain" class="labelForm">Cuenta bancaria:</label>
                             <input type="text" name="accountMain" id="accountMain" class="form-control" placeholder="Cuenta principal" required>
                        </div>
                        
                        <div class="elementoForm">
                            <label for="workerimg" class="campoPerfil">
                                Agregar foto de perfil
                                <img src="../resource/images/foto-perfil-hombre.avif" class="imgProfile" id="imgProfile">
                            </label>
                            <input type="file" name="workerimg" id="workerimg" style="display:none" class="form-control" onchange="vistaPreviaImg('workerimg', 'imgProfile')" accept="image/jpeg, image/png, image/webp, image/jpg">
                        </div>
                        
                    </div><!--fin mitad-->
                </div><!--fin separador-->
        </div><!--fin panel-contenido regitrar tarabajador-->
       </div><!--fin panel-->
       
    <div class="panel">   
        <button type="button" class="pestaniaAcordeon" id="pestana3" onclick="desplazarPanel('pestana3')">
            <h3>SECCION CARGOS EN LA EMPRESA<span>*</span></h3>
        </button>
        <section class="panel-contenido">  
                <div class="containerInptsBusq">
                    <div class="inptBusq">
                        <label for="searchInput" class="labelForm">Área:</label>
                        <input oninput="buscarArea(this.value)" type="text" id="searchInput" placeholder="buscar área..." class="form-control">
                        <input type="hidden" name="codearea" id="codearea" class="form-control">
                        <div id="suggestionsArea"></div>
                    </div>
                    <div class="inptBusq">
                         <label for="namearea" class="labelForm">Área seleccionada:</label>
                        <input type="text" name="namearea" id="namearea" class="form-control" style="background:#f0f0f0" readonly required >
                    </div>
                </div>
                <div class="containerInptsBusq">
                    <div class="inptBusq">
                        <label for="searchInput" class="labelForm">Cargo:</label>
                        <input oninput="buscarOccupation(this.value)" type="text" id="searchInput" placeholder="buscar cargo..." class="form-control">
                        <input type="hidden" name="codeoccupation" id="codeoccupation" class="form-control">
                        <div id="suggestionsOccupation"></div>
                    </div>
                    <div class="inptBusq">      
                        <label for="nameoccupation" class="labelForm">Cargo seleccionado:</label>
                        <input type="text" name="nameoccupation" id="nameoccupation" class="form-control"  style="background:#f0f0f0" readonly required >
                    </div>
                </div>
                <div class="containerInptsBusq">
                    <div class="inptBusq">
                        <label for="searchInput" class="labelForm">Sección:</label>
                        <input oninput="buscarSection(this.value)" type="text" id="searchInput"  placeholder="buscar sección..." class="form-control">
                        <input type="hidden" name="codesection" id="codesection" class="form-control">
                        <div id="suggestionsSection"></div>
                    </div>
                    <div class="inptBusq">  
                        <label for="namesection" class="labelForm">Sección seleccionado:</label>
                        <input type="text" name="namesection" id="namesection" class="form-control" style="background:#f0f0f0"  readonly required >
                    </div>
                </div>
        </section>
    </div><!--fin panel--> 
    
    <div class="panel">
        <button type="button" class="pestaniaAcordeon" id="pestana4" onclick="desplazarPanel('pestana4')">
            <h3>SECCION ASIGNACION DE TURNOS DE TRABAJO</h3>
        </button>
        <section class="panel-contenido">
            <div class="elementoForm dinamic">
                <label for="btnAddTurn">Añadir más turnos</label>
                <button onclick="crearInputTurn()" class="btnOption2" type="button" id="btnAddTurn">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div id="turnos-container">
                <!-- Aquí se agregarán dinámicamente los inputs de turnos -->
            </div>
        </section>
    </div>
    
    
    <div class="panel">   
        <button type="button" class="pestaniaAcordeon" id="pestana5" onclick="desplazarPanel('pestana5')">
            <h3>OTRAS CUENTAS BANCARIAS</h3>
        </button>
        <section class="panel-contenido">  
        
                 <div class="elementoForm dinamic">
                    <label for="btnAddAccountBank">Añadir más cuentas</label>
                    <button onclick="crearInputBank()" class="btnOption2" type="button" id="btnAddAccountBank"><i class="fas fa-plus"></i></button>
                </div>
                <div id="cuentas-container">
                <!-- Aquí se agregarán dinámicamente los inputs -->
                </div>
             
        </section>
    </div><!--fin panel-->   

    <div class="panel">
        <button type="button" class="pestaniaAcordeon" id="pestana9" onclick="desplazarPanel('pestana9')">
            <h3>SECCION FAMILIAR<span>*</span></h3>
        </button>
        <section class="panel-contenido">     
                
                <div class="elementoForm dinamic">
                    <label for="btnAddFamiliar">Añadir familiar</label>
                    <button onclick="crearInputsFamiliares()" class="btnOption2" type="button" id="btnAddFamiliar"><i class="fas fa-plus"></i></button>
                </div>
                <div id="familares-container" class="campoDinamic">
                  <!-- Aquí se agregarán dinámicamente los inputs -->
                </div>
                
         
        </section><!--fin pestania-->
    </div><!--fin panel-->
       
       
   <div class="panel">   
        <button type="button" class="pestaniaAcordeon" id="pestana10" onclick="desplazarPanel('pestana10')">
            <h3>SECCION FORMACION, CURSOS,DOCUMENTACION<span>*</span></h3>
        </button>
        <section class="panel-contenido">  
                <div class="elementoForm dinamic">
                    <label for="btnAddAccountDocument">Añadir Documento:</label>
                    <button onclick="crearInputDocument()" class="btnOption2" type="button" id="btnAddAccountDocument"><i class="fas fa-plus"></i></button>
                </div>
                <div id="documents-container" class="campoDinamic">
                <!-- Aquí se agregarán dinámicamente los inputs -->
                </div>
        </section>
    </div><!--fin panel-->   
</section>                
        <div class="mb-3 text-center containerBtns">
            <button type="button" id="submitBtn"class="btn btn-primary verde" onclick="validarFormularioAcordeon()">
                <i class="fa-solid fa-floppy-disk"></i> Guardar
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
        
</form>
  
  
  
<!--Cierre de los div del modal-->
</div>
</div>
</div>


<script>
function crearInputDocument() {
    let container = document.getElementById("documents-container");
    let divDocument = document.createElement("div");
    divDocument.classList.add("document");

    divDocument.innerHTML = `
    <div style="background:#fdfdfd; margin:5px; border-radius:7px; padding:10px;">
        <button type="button" class="btnOption2" style="display: flex; margin: auto; justify-content: flex-end;" onclick="eliminarDocumento(this)">
            <i class="fas fa-minus"></i>
        </button>
        
        <div class="elementoForm">
            <label for="grado-formacion[]">Grado de formación</label>
            <select name="grado-formacion[]" required>
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="escuela">Escuela</option>
                <option value="colegio">Colegio</option>
                <option value="tecnico">Técnico</option>
                <option value="universidad">Universidad</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div class="elementoForm">
            <label for="titulo[]">Título</label>
            <input type="text" name="titulo[]" placeholder="Ingresa tu título" required />
        </div>

        <div class="elementoForm">
            <label for="foto-certificado[]">Foto del certificado</label>
            <input type="file" name="foto-certificado[]" accept="image/*" required />
        </div>

        <div class="elementoForm">
            <label for="descripcion-curso[]">Descripción del curso</label>
            <textarea name="descripcion-curso[]" placeholder="Describe el curso brevemente" style="width:150px;" required></textarea>
        </div>

        <div class="elementoForm">
            <label for="fecha-cursada[]">Fecha cursada</label>
            <input type="date" name="fecha-cursada[]" required />
        </div>
    </div>
    `;
    container.appendChild(divDocument);
}

function eliminarDocumento(boton) {
    boton.parentElement.parentElement.remove();
}














let contadorInputBank = 1;
function crearInputBank() {
    const nuevoInput = document.createElement('div');
    nuevoInput.classList.add('elementoForm', 'elemDinamico');
    nuevoInput.id = `cuenta_${contadorInputBank}`;

    nuevoInput.innerHTML = `
        <div class="elementoForm">
                <label class="labelForm">Banco:</label>
                <select class="form-control" name="nameBank[]" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="BNB Banco Nacional de Bolivia">BNB Banco Nacional de Bolivia S.A.</option>
                    <option value="BME Banco Mercantil Santa Cruz">BME Banco Mercantil Santa Cruz S.A.</option>
                    <option value="BIS Banco Bisa">BIS Banco Bisa S.A.</option>
                    <option value="BCP Banco de Crédito de Bolivia">BCP Banco de Crédito de Bolivia S.A.</option>
                    <option value="BEC Banco Económico">BEC Banco Económico S.A.</option>
                    <option value="BGA Banco Ganadero">BGA Banco Ganadero S.A.</option>
                    <option value="BSO Banco Solidario">BSO Banco Solidario S.A.</option>
                    <option value="BNA Banco de la Nación Argentina<">BNA Banco de la Nación Argentina</option>
                    <option value="BIE Banco para el Fomento a Iniciativas Económicas">BIE Banco para el Fomento a Iniciativas Económicas S.A.</option>
                    
                    <option value="BFO BFO Banco Fortaleza">BFO Banco Fortaleza S.A.</option>
                    <option value="BPR Banco Prodem">BPR Banco Prodem S.A.</option>
                    <option value="PCO Banco PYME de la Comunidad">PCO Banco PYME de la Comunidad</option>
                    <option value="PEF Banco PYME Ecofuturo">PEF Banco PYME Ecofuturo</option>
                    <option value="BDR Banco de Desarrollo Productivo">BDR Banco de Desarrollo Productivo</option>
                    <option value="BUN Banco Unión">BUN Banco Unión</option>
                    <option value="VL1 La Primera Entidad Financiera de Vivienda">VL1 La Primera Entidad Financiera de Vivienda</option>
                    <option value="VPR La Promotora Entidad Financiera de Vivienda">VPR La Promotora Entidad Financiera de Vivienda</option>
                    <option value="VPG El Progreso Entidad Financiera de Vivienda">VPG El Progreso Entidad Financiera de Vivienda</option>
                    <option value="CJN Cooperativa ‘Jesús Nazareno’">CJN Cooperativa ‘Jesús Nazareno’</option>
                    
                    <option value="CFA Cooperativa ‘Fátima’">CFA Cooperativa ‘Fátima’</option>
                    <option value="CSM Cooperativa ‘San Martín de Porres’">CSM Cooperativa ‘San Martín de Porres’</option>
                    <option value="CSA Cooperativa ‘San Antonio’">CSA Cooperativa ‘San Antonio’</option>
                    <option value="CIH Cooperativa ‘Inca Huasi’">CIH Cooperativa ‘Inca Huasi’</option>
                    <option value="CQC Cooperativa ‘Quillacollo’">CQC Cooperativa ‘Quillacollo’</option>
                    <option value="CJP Cooperativa ‘San José de Punata’">CJP Cooperativa ‘San José de Punata’</option>
                    <option value="CMM Cooperativa ‘Madre y Maestra’">CMM Cooperativa ‘Madre y Maestra’</option>
                    <option value="CLY Cooperativa ‘Loyola’">CLY Cooperativa ‘Loyola’</option>
                    <option value="CPX Cooperativa ‘Pío’ X">CPX Cooperativa ‘Pío’ X</option>
                    <option value="CCR Cooperativa ‘El Chorolque’">CCR Cooperativa ‘El Chorolque’</option>
                    
                    <option value="CSP Cooperativa ‘San Pedro’">CSP Cooperativa ‘San Pedro’</option>
                    <option value="CCP Cooperativa ‘Catedral’">CCP Cooperativa ‘Catedral’</option>
                    <option value="CCM Cooperativa ‘Comarapa’">CCM Cooperativa ‘Comarapa’</option>
                    <option value="CTR Cooperativa ‘Trinidad’">CTR Cooperativa ‘Trinidad’</option>
                    <option value="CEC Cooperativa ‘Educadores Gran Chaco’">CEC Cooperativa ‘Educadores Gran Chaco’</option>
                    <option value="CST Cooperativa ‘San Mateo’">CST Cooperativa ‘San Mateo’</option>
                    <option value="CMG Cooperativa ‘Monseñor Félix Gainza’">CMG Cooperativa ‘Monseñor Félix Gainza’</option>
                    <option value="CMR Cooperativa ‘Magisterio Rural’">CMR Cooperativa ‘Magisterio Rural’</option>
                    <option value="CJB Cooperativa ‘San José de Bermejo’">CJB Cooperativa ‘San José de Bermejo’</option>
                    <option value="CJO Cooperativa ‘San Joaquín’">CJO Cooperativa ‘San Joaquín’</option>
                    
                    <option value="CSR Cooperativa ‘San Roque’">CSR Cooperativa ‘San Roque’</option>
                    <option value="CAS Cooperativa ‘Asunción’">CAS Cooperativa ‘Asunción’</option>
                    <option value="CCA Cooperativa ‘Catedral de Tarija’">CCA Cooperativa ‘Catedral de Tarija’</option>
                    <option value="CME Cooperativa ‘La Merced’">CME Cooperativa ‘La Merced’</option>
                    <option value="CCB Cooperativa ‘San Carlos Borromeo’">CCB Cooperativa ‘San Carlos Borromeo’</option>
                    <option value="CCF Cooperativa ‘CACEF’">CCF Cooperativa ‘CACEF’</option>
                    <option value="CPG Cooperativa ‘Progreso’">CPG Cooperativa ‘Progreso’</option>
                    <option value="CLS Cooperativa ‘La Sagrada Familia’">CLS Cooperativa ‘La Sagrada Familia’</option>
                    <option value="CMD Cooperativa ‘Magisterio Rural de Chuquisaca’">CMD Cooperativa ‘Magisterio Rural de Chuquisaca’</option>
                    <option value="CSN Cooperativa ‘San Martín’">CSN Cooperativa ‘San Martín’</option>
                    
                    <option value="CSQ Cooperativa ‘San Pedro de Aiquile’">CSQ Cooperativa ‘San Pedro de Aiquile’</option>
                    <option value="CVE Cooperativa ‘Virgen de los Remedios’">CVE Cooperativa ‘Virgen de los Remedios’</option>
                    <option value="CLO Cooperativa ‘San Francisco Solano’">CLO Cooperativa ‘San Francisco Solano’</option>
                    <option value="CLC Cooperativa ‘Solucredit San Silvestre’">CLC Cooperativa ‘Solucredit San Silvestre’</option>
                    <option value="COO Cooperativa ‘COOPROLE’">COO Cooperativa ‘COOPROLE’</option>
                    <option value="CEY Cooperativa ‘Cristo Rey Cochabamba’">CEY Cooperativa ‘Cristo Rey Cochabamba’</option>
                    <option value="CPS Cooperativa ‘Paulo VI’">CPS Cooperativa ‘Paulo VI’</option>
                    <option value="CUM Cooperativa ‘Unión Santiago de Machaca USAMA’">CUM Cooperativa ‘Unión Santiago de Machaca USAMA’</option>
                    <option value="CAE Cooperativa ‘Cantera’">CAE Cooperativa ‘Cantera’</option>
                    <option value="CHO Cooperativa ‘Hospicio’">CHO Cooperativa ‘Hospicio’</option>
                    
                    <option value="ICI Institucion Financiera CIDRE">Institución Financiera CIDRE IFD</option>
                    <option value="ICR Institución Financiera CRECER">Institución Financiera CRECER IFD</option>
                    <option value="IDI Institución Financiera DIACONÍA">Institución Financiera DIACONÍA FRID - IFD</option>
                    <option value="IFO Institución Financiera FONDECO">Institución Financiera FONDECO IFD</option>
                    <option value="IFU Institución Financiera FUBODE">Institución Financiera FUBODE IFD</option>
                    <option value="IID Institución Financiera IDEPRO IFD">Institución Financiera IDEPRO IFD</option>
                    <option value="IIM Institución Financiera IMPRO IFD">Institución Financiera IMPRO IFD</option>
                    <option value="IPM Institución Financiera Fundación PRO MUJER IFD">Institución Financiera Fundación PRO MUJER IFD</option>
                    <option value="Otro">Otro</option>
                </select>
             </div>
        <div class="elementoForm">
            <label class="labelForm">Cuenta:</label>
            <input type="text" class="form-control" name="cuentaBank[]" placeholder="Número de cuenta" required>
        </div>
        <div class="elementoForm">
            <button type="button" onclick="eliminarInputBank(${contadorInputBank})" class="btnOption2"><i class="fas fa-minus"></i></button>
        </div>
    `;

    const cuentasContainer = document.getElementById('cuentas-container');
    cuentasContainer.appendChild(nuevoInput);

    contadorInputBank++;
}

function eliminarInputBank(id) {
    const cuentaDiv = document.getElementById(`cuenta_${id}`);
    cuentaDiv.remove();
}
        
        
        
        
        
        
        
        
function mostrarDetallesTurno(codeturn, index) {
    var selectedOption = document.querySelector(`#turno_${index} select[name="codeturn[]"] option[value='${codeturn}']`);
    if (selectedOption) {
        var turnstart = selectedOption.getAttribute('data-start');
        var turnend = selectedOption.getAttribute('data-end');
        document.querySelector(`#turno_${index} input[name="turnstart[]"]`).value = turnstart;
        document.querySelector(`#turno_${index} input[name="turnend[]"]`).value = turnend;
    }
}
function eliminarInputTurn(id) {
    const turnoDiv = document.getElementById(`turno_${id}`);
    turnoDiv.remove();
}
    
document.getElementById('addWorkerModal').addEventListener('shown.bs.modal', () => {
    cargarTrabajadores();
});


function crearInputsFamiliares() {
    let container = document.getElementById("familares-container");

    let divFamiliar = document.createElement("div");
    divFamiliar.classList.add("familiar");

    divFamiliar.innerHTML = `
<div style="background:#fdfdfd; margin:5px; border-radius:7px; padding:10px;">

    
      <button type="button" class="btnOption2" style="display: flex; margin: auto; justify-content: flex-end;" onclick="eliminarFamiliar(this)"><i class="fas fa-minus"></i></button>
    
            <div class="elementoForm">
                <label for="familyname[]">Nombre:</label>
                <input type="text" name="familyname[]" placeholder="Nombre" maxlength="50" required>
            </div>
            <div class="elementoForm">
                <label for="familylastname[]">Apellido:</label>
                <input type="text" name="familylastname[]" placeholder="Apellido" maxlength="50" required>
            </div>
            <div class="elementoForm">
                <label for="familysex[]">Sexo:</label>
                <select name="familysex[]" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
 

            <div class="elementoForm">
                <label for="familyage[]">Edad:</label>
                <input type="text" name="familyage[]" placeholder="Edad" maxlength="10" required>
            </div>
            <div class="elementoForm">
                <label for="familykin[]">Parentesco:</label>
                <select name="familykin[]" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="padre">Padre</option>
                    <option value="madre">Madre</option>
                    <option value="hijo">Hijo</option>
                    <option value="hija">Hija</option>
                    <option value="hermano">Hermano</option>
                    <option value="hermana">Hermana</option>
                    <option value="abuelo">Abuelo</option>
                    <option value="abuela">Abuela</option>
                    <option value="tio">Tío</option>
                    <option value="tia">Tía</option>
                    <option value="sobrino">Sobrino</option>
                    <option value="sobrina">Sobrina</option>
                    <option value="primo">Primo</option>
                    <option value="prima">Prima</option>
                    <option value="padrastro">Padrastro</option>
                    <option value="madrastra">Madrastra</option>
                    <option value="hijastro">Hijastro</option>
                    <option value="hijastra">Hijastra</option>
                    <option value="cuñado">Cuñado</option>
                    <option value="cuñada">Cuñada</option>
                    <option value="yerno">Yerno</option>
                    <option value="nuera">Nuera</option>
                    <option value="suegro">Suegro</option>
                    <option value="suegra">Suegra</option>
                    <option value="padrino">Padrino</option>
                    <option value="madrina">Madrina</option>
                    <option value="ahijado">Ahijado</option>
                    <option value="ahijada">Ahijada</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
</div>
    `;

    container.appendChild(divFamiliar);
}
function eliminarFamiliar(boton) {
    boton.parentElement.remove();
}


let contadorInputTurn = 1;

function crearInputTurn() {
    const nuevoInput = document.createElement('div');
    nuevoInput.classList.add('elementoForm', 'elemDinamico');
    nuevoInput.id = `turno_${contadorInputTurn}`;

    nuevoInput.innerHTML = `
        <div class="elementoForm">
            <label class="labelForm">Turno:</label>
            <select class="form-select" name="codeturn[]" onchange="mostrarDetallesTurno(this.value, ${contadorInputTurn})">
                <option value="" selected>Seleccione una opción</option>
                <?php
                    if (count($turns) > 0) {
                        foreach($turns as $row) {
                            echo "<option value='" . $row['codeturn'] . "' data-start='" . $row['turnstart'] . "' data-end='" . $row['turnend'] . "'>" . $row['turnname'] . " (" . $row['turnstart'] . " - " . $row['turnend'] . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No se encontraron turnos</option>";
                    }
                ?>
            </select>
        <div>
        </div>
        <div class="elementoForm">
            <label class="labelForm">Horario de Inicio de Turno:</label>
            <input type="text" class="form-control" name="turnstart[]" disabled required>
        </div>
        <div class="elementoForm">
            <label class="labelForm">Horario de Fin de Turno:</label>
            <input type="text" class="form-control" name="turnend[]" disabled required>
        </div>
        <div class="elementoForm">
            <button type="button" onclick="eliminarInputTurn(${contadorInputTurn})" class="btnOption2">
                <i class="fas fa-minus"></i>
            </button>
        </div>
        
        </div>
    `;

    const turnosContainer = document.getElementById('turnos-container');
    turnosContainer.appendChild(nuevoInput);

    contadorInputTurn++;
}


  
        
    function buscarArea(query) {
        if (query.length < 2) {
            document.getElementById('suggestionsArea').innerHTML = '';
            return;
        }
    
        fetch('../routes/area/getAreaModal2.php?q=' + query)
            .then(response => response.text())
            .then(data => {
                document.getElementById('suggestionsArea').innerHTML = data;
            });
    }
    
    function seleccionarArea(code, name) {
        document.getElementById('codearea').value = code;
        document.getElementById('namearea').value = name;
        document.getElementById('suggestionsArea').innerHTML = '';
    }
    
    function buscarOccupation(query) {
        if (query.length < 2) {
            document.getElementById('suggestionsOccupation').innerHTML = '';
            return;
        }
    
        fetch('../routes/ocupation/getOcupationModal2.php?q=' + query)
            .then(response => response.text())
            .then(data => {
                document.getElementById('suggestionsOccupation').innerHTML = data;
            });
    }
    
    function seleccionarOccupation(code, name) {
        document.getElementById('codeoccupation').value = code;
        document.getElementById('nameoccupation').value = name;
        document.getElementById('suggestionsOccupation').innerHTML = '';
    }
    
    function buscarSection(query) {
        if (query.length < 2) {
            document.getElementById('suggestionsSection').innerHTML = '';
            return;
        }
    
        fetch('../routes/section/getSectionModal2.php?q=' + query)
            .then(response => response.text())
            .then(data => {
                document.getElementById('suggestionsSection').innerHTML = data;
            });
    }
    
    function seleccionarSection(code, name) {
        document.getElementById('codesection').value = code;
        document.getElementById('namesection').value = name;
        document.getElementById('suggestionsSection').innerHTML = '';
    }
    

function validarFormularioAcordeon() {
    const camposRequeridos = document.querySelectorAll('input[required]');
    let valido = true;
    document.querySelectorAll('.panel').forEach(panel => {
        panel.classList.remove('error');
    });
    camposRequeridos.forEach(campo => {
        const panel = campo.closest('.panel');
        if (!campo.value) {
            valido = false;
            campo.style.border = '1px solid red';
            panel.classList.add('error'); 
        } else {
            campo.style.border = '';
            panel.classList.remove('error'); 
        }
    });
    if (valido) {
        const formData = new FormData(document.getElementById('formTrabajador'));
        let datosForm = {};
        formData.forEach((value, key) => {
            if (datosForm[key]) {
                datosForm[key].push(value);
            } else {
                datosForm[key] = [value];
            }
        });
        console.log("Datos a enviar:", datosForm);
        fetch('routes/workers/addWorker.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert('Datos enviados correctamente');
            console.log(data); 
            
            // Cerrar el modal después de enviar los datos
            document.getElementById('btn-cerrar-modal').click();
        })
        .catch(error => {
            alert('Hubo un error al enviar los datos');
            console.error('Error:', error);
        });
    } else {
        alert('Por favor, complete todos los campos requeridos');
    }
}


    function desplazarPanel(id) {
        const panel = document.getElementById(id).parentElement;
        const estaActivo = panel.classList.contains('active');
        if (estaActivo) {
            document.querySelectorAll('.panel').forEach(p => {
                p.classList.remove('active');
            });
        } else {
            document.querySelectorAll('.panel').forEach(p => {
                p.classList.remove('active');
            });
            panel.classList.add('active');
        }
    }
    
    
    
    
    
    
    function vistaPreviaImg(inputId, imgId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result; 
            };
            reader.readAsDataURL(file); 
        }
    }

</script>
<style>

  /*Seccion del acordion*/
    .acordeon{
       display:flex; 
       flex-direction:column;
       gap:2px;
       background:#333;
       padding: 15px 0;
    }
    

/* Este es el botón */
.pestaniaAcordeon {
  width: 100%;
  display: flex;
  background: #7fbc03;
  border-color: #7fbc03;
  transition: transform 0.3s ease, box-shadow 0.3s ease; 
  color:white;
}
.pestaniaAcordeon:hover {
  background: rgb(163, 226, 38);
  transform: translateY(-5px);  /* Levantar ligeramente el botón */
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}
.pestaniaAcordeon h3{
    margin-left:25px;
}

    
  
  
  
    .panel-contenido {
        padding: 10px;
        background-color: #f9f9f9;
        display: none;
    }
     .panel.active .panel-contenido {
        display: flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
    }

    .panel button.active {
        background-color: #ddd;
    }
     .panel.error {
        border: 2px solid red;
    }
        
        
        
        
        
        
     .elemDinamico{
         display: flex;
         margin: 20px 0;
         background:#f0f0f0;
         border-radius: 7px;
         padding:5px;
     }   
     @media screen and (max-width: 768px) {
       
        .elemDinamico{
          flex-direction: column-reverse;
        }
     }
        
        
        
        
        
  /*Ajustar elemento*/
  .dinamic{
      padding:7px;
      width:220px;
  }
  .campoDinamic{
      background:#cdcdcd;
      width:100%;
      display:flex;
      flex-wrap:wrap;
      justify-content:center;
  }
  
  
  
    
    
    .campoPerfil{
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        margin-top:10px;
        width:100%;
        padding:10px;
        gap:15px;
    }
    .campoPerfil:hover{
        background:#cdcdcd;
    }
    .imgProfile{
        width:150px;
        height:150px;
        object-fit: cover;
        border-radius:100%;
    }
    
    
    
    
    /*Usado en la parte de seccion*/
    .containerInptsBusq{
        width:70%;
        padding:15px;
        display:flex;
        box-sizing:border-box;
        gap:10px;
    } 
    .inptBusq{
        display:flex;
        flex-direction:column;
        justify-content:center;
        width:50%;
    }
   @media screen and (max-width: 768px) {
      .containerInptsBusq{
        width:90%;
       }
   }
    
 </style>
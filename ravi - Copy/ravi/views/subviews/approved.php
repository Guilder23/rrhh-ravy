<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
require 'config/database.php';
$database = new Database('local');
$conn = $database->getConnection();

function obtenerLicenciasAprobadasConDetalles($conn) {
    try {
        $sqlLicencias = "SELECT 
                        l.codelicense,
                        l.licensecode,
                        l.licensename,
                        l.licenselastname,
                        l.licensereason,
                        DATE_FORMAT(l.licensecreate, '%d/%m/%Y %H:%i') as licensecreate,
                        l.licensenro,
                        DATE_FORMAT(l.licenseinit, '%d/%m/%Y %H:%i') as licenseinit,
                        DATE_FORMAT(l.licenseend, '%d/%m/%Y %H:%i') as licenseend,
                        l.licensebonus,
                        l.codeworker,
                        tl.codetlicense,
                        tl.tlicensecode,
                        tl.tlicensename,
                        tl.approval_status,
                        tl.tlicensedelete,
                        DATE_FORMAT(tl.tlicenseapproved, '%d/%m/%Y %H:%i') as tlicenseapproved
                    FROM license l
                    LEFT JOIN tlicense tl ON l.codelicense = tl.tlicensecode
                    WHERE tl.approval_status = 1  -- Solo licencias aprobadas
                    ORDER BY l.licenseinit DESC";
        
        $stmtLicencias = $conn->prepare($sqlLicencias);
        $stmtLicencias->execute();
        $licenciasAprobadas = $stmtLicencias->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($licenciasAprobadas)) {
            return [
                'total_licencias' => 0,
                'trabajadores' => []
            ];
        }
        
        $codeworkers = array_unique(array_column($licenciasAprobadas, 'codeworker'));
        $placeholders = implode(',', array_fill(0, count($codeworkers), '?'));
        
        $sqlTrabajadores = "SELECT 
                            codeworker,
                            workercode,
                            workername1,
                            workername2,
                            workerlastname1,
                            workerlastname2
                        FROM worker
                        WHERE codeworker IN ($placeholders)";
        
        $stmtTrabajadores = $conn->prepare($sqlTrabajadores);
        $stmtTrabajadores->execute(array_values($codeworkers));
        $trabajadores = $stmtTrabajadores->fetchAll(PDO::FETCH_ASSOC);
        
        $infoTrabajadores = [];
        foreach ($trabajadores as $trabajador) {
            $infoTrabajadores[$trabajador['codeworker']] = $trabajador;
        }
        
        $resultado = [];
        foreach ($licenciasAprobadas as $licencia) {
            $codeworker = $licencia['codeworker'];
            if (!isset($resultado[$codeworker])) {
                $resultado[$codeworker] = [
                    'info' => $infoTrabajadores[$codeworker] ?? [
                        'workercode' => 'N/A',
                        'workername1' => 'Trabajador no encontrado',
                        'workername2' => '',
                        'workerlastname1' => '',
                        'workerlastname2' => ''
                    ],
                    'licencias' => []
                ];
            }
            
            $detalleTlicense = [
                'codetlicense' => $licencia['codetlicense'],
                'tlicensecode' => $licencia['tlicensecode'],
                'tlicensename' => $licencia['tlicensename'],
                'approval_status' => $licencia['approval_status'],
                'tlicensedelete' => $licencia['tlicensedelete'],
                'tlicenseapproved' => $licencia['tlicenseapproved']
            ];
            
            $resultado[$codeworker]['licencias'][] = [
                'codelicense' => $licencia['codelicense'],
                'licensecode' => $licencia['licensecode'],
                'licensename' => $licencia['licensename'],
                'licenselastname' => $licencia['licenselastname'],
                'licensereason' => $licencia['licensereason'],
                'licensecreate' => $licencia['licensecreate'],
                'licensenro' => $licencia['licensenro'],
                'licenseinit' => $licencia['licenseinit'],
                'licenseend' => $licencia['licenseend'],
                'licensebonus' => $licencia['licensebonus'],
                'tlicense' => $detalleTlicense
            ];
        }
        
        return [
            'total_licencias' => count($licenciasAprobadas),
            'trabajadores' => array_values($resultado)
        ];
    } catch (PDOException $e) {
        die("Error al obtener licencias: " . $e->getMessage());
    }
}

$data = obtenerLicenciasAprobadasConDetalles($conn);
$totalLicencias = $data['total_licencias'];
$trabajadores = $data['trabajadores'];
?>

<body>
    <h2 class="titulogestion">Reporte de Licencias Aprobadas</h2>  <!-- Cambiado el título -->
    <div style="display:flex; gap:50px;">
        <p><strong>Total de licencias aprobadas:</strong> <?= $totalLicencias ?></p>  <!-- Cambiado el texto -->
        <p><strong>Trabajadores con licencias aprobadas:</strong> <?= count($trabajadores) ?></p>  <!-- Cambiado el texto -->
    </div>
    <?php if ($totalLicencias === 0): ?>
        <p>No se encontraron licencias aprobadas en el sistema.</p>  <!-- Cambiado el mensaje -->
    <?php else: ?>
        <div style="background:#cdcdcd; width:90%; display:flex; margin:auto; overflow:auto; height:30vh;">
        <table id="tablaLicencias">
            <thead>
                <tr>
                    <th>Código Trabajador</th>
                    <th>Nombre Completo</th>
                    <th>Período</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trabajadores as $trabajador): ?>
                    <?php foreach ($trabajador['licencias'] as $licencia): ?>
                    <tr data-licencia='<?= htmlspecialchars(json_encode($licencia), ENT_QUOTES, 'UTF-8') ?>'>
                        <td><?= htmlspecialchars($trabajador['info']['workercode']) ?></td>
                        <td>
                            <?= htmlspecialchars($trabajador['info']['workername1']) ?> 
                            <?= htmlspecialchars($trabajador['info']['workername2']) ?> 
                            <?= htmlspecialchars($trabajador['info']['workerlastname1']) ?> 
                            <?= htmlspecialchars($trabajador['info']['workerlastname2']) ?>
                        </td>
                        <td><?= htmlspecialchars($licencia['licenseinit']) ?> a <?= htmlspecialchars($licencia['licenseend']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div id="detalleLicencia" class="licencia-detalle">
            <h3>Detalle de Licencia Aprobada</h3>  <!-- Cambiado el título -->
            <div>
                <label>Código Licencia:</label>
                <input type="text" id="codelicense" readonly>


                <div class="form-group">
                    <label for="licensename">Nombre Licencia:</label>
                    <input type="text" id="licensename" readonly>
                </div>
                <div class="form-group">
                    <label for="licensenro">Número:</label>
                    <input type="text" id="licensenro" readonly>
                </div>
                
                
                <div class="form-group">
                    <label for="licenseinit">Fecha Inicio:</label>
                    <input type="datetime-local" id="licenseinit" name="licenseinit" class="form-control">
                </div>

                <div class="form-group">
                    <label for="licenseend">Fecha Fin:</label>
                    <input type="datetime-local" id="licenseend" name="licenseend" class="form-control">
                </div>
                
                
                <div class="form-group">
                    <label for="licensebonus">Bonificación:</label>
                    <select id="licensebonus" name="licensebonus" class="form-control">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>



            </div>
            <div style="display:flex; flexwrap:wrap;">
                <div class="form-group">
                    <label for="licensereason">Motivo:</label>
                    <textarea id="licensereason" readonly></textarea>
                </div>
                <div class="form-group">
                    <label for="licensecreate">Fecha creación:</label>
                    <input type="text" id="licensecreate" readonly>
                </div>
            </div>
            
            <h3>Detalle de Aprobación</h3>
            <div style="display:flex; flex-wrap:wrap;">
 
                    <label>Código Aprobación:</label>
                    <input type="text" id="tlicensecode" readonly>
    
                <div class="form-group">
                    <label for="tlicensename">Nombre Aprobación:</label>
                    <input type="text" id="tlicensename" readonly>
                </div>

                <div class="form-group">
                    <label for="approval_status">Estado:</label>
                    <select id="approval_status" name="approval_status" class="form-control">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="0">Reprobado</option>
                        <option value="1">Aprobado</option>
                    </select>
                </div>
        
                <div class="form-group">
                    <label for="tlicensedelete">Eliminado:</label>
                    <select id="tlicensedelete" name="tlicensedelete" class="form-control">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="tlicenseapproved">Fecha Aprobación:</label>
                    <input type="text" id="tlicenseapproved" readonly>
                </div>
            </div>
        </div>
    <?php endif; ?>
<script>
       
document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#tablaLicencias tbody tr');
            const detalleDiv = document.getElementById('detalleLicencia');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    const licenciaData = JSON.parse(this.getAttribute('data-licencia'));
                    document.getElementById('codelicense').value = licenciaData.codelicense;
                    document.getElementById('licensename').value = licenciaData.licensename;
                    document.getElementById('licensereason').value = licenciaData.licensereason;
                    document.getElementById('licensecreate').value = licenciaData.licensecreate;
                    document.getElementById('licensenro').value = licenciaData.licensenro;
    
                // Mostrar en consola las fechas originales
                    console.log("Fecha recibida (init):", licenciaData.licenseinit);
                    console.log("Fecha recibida (end):", licenciaData.licenseend);
                    const formatDateTime = (dateString) => {
                        if (!dateString) return '';
                        const [datePart, timePart] = dateString.trim().split(' ');
                        const [day, month, year] = datePart.split('/');
                        const [hours, minutes] = timePart.split(':');
                        const formattedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}T${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
                        console.log("Fecha formateada:", formattedDate); 
                        return formattedDate;
                    };
                    document.getElementById('licenseinit').value = formatDateTime(licenciaData.licenseinit);
                    document.getElementById('licenseend').value = formatDateTime(licenciaData.licenseend);
                    console.log("Valor asignado a licenseinit:", document.getElementById('licenseinit').value);
                    console.log("Valor asignado a licenseend:", document.getElementById('licenseend').value);
                    
                    document.getElementById('licensebonus').value = licenciaData.licensebonus;
                    const tlicense = licenciaData.tlicense;
                    document.getElementById('tlicensecode').value = tlicense.tlicensecode || 'N/A';
                    document.getElementById('tlicensename').value = tlicense.tlicensename || 'N/A';
                    document.getElementById('approval_status').value= tlicense.approval_status;
                    document.getElementById('tlicensedelete').value = tlicense.tlicensedelete;
                    document.getElementById('tlicenseapproved').value = tlicense.tlicenseapproved || 'N/A';
                    detalleDiv.style.display = 'block';
                    detalleDiv.scrollIntoView({ behavior: 'smooth' });
                });
            });
        });


</script>
    
    
    

<style>
.licencia-detalle h3 {
    margin-top: 0;
    color: #2c3e50;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}
.form-group input, .form-group select, .form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}
.form-group textarea {
    height: 100px;
}
.aprobado { color: #27ae60; }
.pendiente { color: #f39c12; }
.rechazado { color: #e74c3c; }
        
        
        

#tablaLicencias {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  font-family: Arial, sans-serif;
  font-size: 14px;
  color: #333;
  margin:0;
}

#tablaLicencias th,
#tablaLicencias td {
  border: 1px solid #ddd;
  padding: 12px 15px;
  text-align: left;
}

#tablaLicencias th {
  background-color: #7fbc03;
  font-weight: bold;
  color: white;
  position: sticky;
  top: 0;
  z-index:0;
}

#tablaLicencias tr:nth-child(even) {
  background-color: #fafafa;
}

#tablaLicencias tr:hover {
  background-color: #f0f8ff;
}
</style>
</body>


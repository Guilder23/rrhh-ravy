<?php

require '../../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$id = intval($_POST['codeworker']);

$sql = "
    SELECT 
        w.*, 
        a.areaname AS workerarea_name, 
        o.nameoccupation AS workerrol_name, 
        s.namesection AS workersection_name,
        ac.accountbank, 
        ac.accountnro,
        f.familyname,
        f.familylastname,
        f.familysex,
        f.familyage,
        f.familykin,
        t.turnwname,
        t.turnwlastname,
        t.turnwcreate,
        tu.turnname AS turn_name,
        tu.turnstart AS turn_start,
        tu.turnend AS turn_end,
        d.gradoFormacion,
        d.titulo,
        d.urlCertificado,
        d.descripcionCurso,
        d.fechaCursada
    FROM 
        worker w
    LEFT JOIN 
        area a ON w.workerarea = a.codearea
    LEFT JOIN 
        occupation o ON w.workerrol = o.codeoccupation
    LEFT JOIN 
        section s ON w.workersection = s.codesection
    LEFT JOIN 
        account ac ON w.codeworker = ac.codeworker
    LEFT JOIN 
        family f ON w.codeworker = f.codeworker
    LEFT JOIN 
        turnw t ON w.codeworker = t.codeworker
    LEFT JOIN 
        turn tu ON t.codeturn = tu.codeturn
    LEFT JOIN
        documentWorker d ON w.codeworker = d.codeworker
    WHERE 
        w.codeworker = :codeworker
";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':codeworker', $id, PDO::PARAM_INT);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    $workerData = [
        'codeworker' => $results[0]['codeworker'],
        'workername1' => $results[0]['workername1'],
        'workername2' => $results[0]['workername2'],
        'workerlastname1' => $results[0]['workerlastname1'],
        'workerlastname2' => $results[0]['workerlastname2'],
        'workerdocnumber' => $results[0]['workerdocnumber'],
        'workerbirthdate' => $results[0]['workerbirthdate'],
        'workersex' => $results[0]['workersex'],
        'workercity' => $results[0]['workercity'],
        'workernationality' => $results[0]['workernationality'],
        'workercivilstatus' => $results[0]['workercivilstatus'],
        'workerbanknum' => $results[0]['workerbanknum'],
        'workerphone1' => $results[0]['workerphone1'],
        'workerphone2' => $results[0]['workerphone2'],
        'workeraddress' => $results[0]['workeraddress'],
        'workernit' => $results[0]['workernit'],
        'workerimg' => $results[0]['workerimg'],
        'workerdateinit' => $results[0]['workerdateinit'],
        'workerdateout' => $results[0]['workerdateout'],
        'workerarea' => $results[0]['workerarea'],
        'workerrol' => $results[0]['workerrol'],
        'workersection' => $results[0]['workersection'],
        'workerarea_name' => $results[0]['workerarea_name'],
        'workerrol_name' => $results[0]['workerrol_name'],
        'workersection_name' => $results[0]['workersection_name'],
        'accounts' => [],
        'family' => [],
        'turnw' => [],
        'documents' => []
    ];

    // Agregar cuentas bancarias
    foreach ($results as $row) {
        if ($row['accountbank'] !== null) {
            $account = [
                'accountbank' => $row['accountbank'],
                'accountnro' => $row['accountnro']
            ];
            if (!in_array($account, $workerData['accounts'])) {
                $workerData['accounts'][] = $account;
            }
        }

        // Agregar familiares
        if ($row['familyname'] !== null) {
            $family = [
                'familyname' => $row['familyname'],
                'familylastname' => $row['familylastname'],
                'familysex' => $row['familysex'],
                'familyage' => $row['familyage'],
                'familykin' => $row['familykin']
            ];
            if (!in_array($family, $workerData['family'])) {
                $workerData['family'][] = $family;
            }
        }

        // Agregar turnos
        if ($row['turn_name'] !== null) {
            $turnw = [
                'turn_name' => $row['turn_name'],
                'turn_start' => $row['turn_start'],
                'turn_end' => $row['turn_end']
            ];
            if (!in_array($turnw, $workerData['turnw'])) {
                $workerData['turnw'][] = $turnw;
            }
        }
        
        // Agregar documentos
        if ($row['gradoFormacion'] !== null) {
            $document = [
                'gradoFormacion' => $row['gradoFormacion'],
                'titulo' => $row['titulo'],
                'urlCertificado' => $row['urlCertificado'],
                'descripcionCurso' => $row['descripcionCurso'],
                'fechaCursada' => $row['fechaCursada']
            ];
            if (!in_array($document, $workerData['documents'])) {
                $workerData['documents'][] = $document;
            }
        }
    }

    // Devolver los datos en formato JSON
    echo json_encode($workerData, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(['error' => 'Código no encontrado.']);
}
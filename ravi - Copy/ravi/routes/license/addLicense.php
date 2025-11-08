<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        try {
            $conn->beginTransaction();

            $codeworker = $conn->quote($_POST['codeworker']);
            $licensecode = $conn->quote($_POST['licensecode']);
            $licensenro = $conn->quote($_POST['licensenro']);
            $licensename = $conn->quote($_POST['licensename']);
            $licenselastname = $conn->quote($_POST['licenselastname']);
            $licensereason = $conn->quote($_POST['observaciones']);
            $licensevalue = $conn->quote(0.00);
            $goceHaber = $conn->quote($_POST['goceHaber']);
            $tipo = $_POST['tipo'];

            if ($tipo === 'hora') {
                // Licencia por hora: combinar fecha y hora
                $fechaHora = $_POST['fechaHora'];
                $horaInicio = $_POST['horaInicio'];
                $horaFin = $_POST['horaFin'];

                // Crear valores de fecha y hora completos
                $licenseinit = $conn->quote($fechaHora . ' ' . $horaInicio . ':00');
                $licenseend = $conn->quote($fechaHora . ' ' . $horaFin . ':00');
            } else {
                // Licencia por fecha
                $licenseinit = $conn->quote($_POST['fechaInicio'] . ' 00:00:00');
                $licenseend = $conn->quote($_POST['fechaFin'] . '  00:00:00');    //23:59:59
            }

            // Insertar la licencia
            $sqlLicense = "INSERT INTO license (
                            codeworker, licensecode, licensenro, licensename, licenselastname, 
                            licensereason, licensevalue, licenseinit, licenseend, licensebonus
                          ) VALUES (
                            $codeworker, $licensecode, $licensenro, $licensename, $licenselastname, 
                            $licensereason, $licensevalue, $licenseinit, $licenseend, $goceHaber
                          )";

            if ($conn->exec($sqlLicense)) {
                $lastLicenseId = $conn->lastInsertId();

                $tlicensecode = $lastLicenseId;
                $tlicensename = $conn->quote($_POST['observaciones']);
                $tlicensedate = '0000-00-00 00:00:00';

                $sqlTLicense = "INSERT INTO tlicense (
                                    tlicensecode, tlicensename, tlicenseapproved
                                ) VALUES (
                                    $tlicensecode, $tlicensename, '$tlicensedate'
                                )";

                if ($conn->exec($sqlTLicense)) {
                    $conn->commit();
                    $_SESSION['message'] = 'Licencia agregada correctamente';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $conn->rollBack();
                    $_SESSION['message'] = 'Error al agregar la licencia';
                    $_SESSION['message_type'] = 'error';
                }
            } else {
                $conn->rollBack();
                $_SESSION['message'] = 'Error al agregar la licencia';
                $_SESSION['message_type'] = 'error';
            }
        } catch (Exception $e) {
            $conn->rollBack();
            $_SESSION['message'] = 'Error al agregar la licencia: ' . $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error al conectar con la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/registrar");
exit;
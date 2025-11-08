<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codearea = $_POST['areacode'];
        $codeturn = $_POST['codeturn'];
        $turnaname = $_POST['turnaname'];
        $turnalastname = $_POST['turnalastname'];

        $codearea = $conn->quote($codearea);
        $codeturn = $conn->quote($codeturn);
        $turnaname = $conn->quote($turnaname);
        $turnalastname = $conn->quote($turnalastname);

        $sql = "INSERT INTO turna (codearea, codeturn, turnaname, turnalastname) 
                VALUES ($codearea, $codeturn, $turnaname, $turnalastname)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Turno asignado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al asignar el turno';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnoarea");
exit;
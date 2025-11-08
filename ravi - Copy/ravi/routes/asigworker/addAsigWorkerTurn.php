<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $workercode = $_POST['workercode'];
        $codeturn = $_POST['codeturn'];
        $turnwname = $_POST['turnwname'];

        $workercode = $conn->quote($workercode);
        $codeturn = $conn->quote($codeturn);
        $turnwname = $conn->quote($turnwname);

        $sql = "INSERT INTO turnw (codeworker, codeturn, turnwname) 
                VALUES ($workercode, $codeturn, $turnwname)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Turno asignado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al asignar el turno';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error al asignar el turno';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=turnotrabajador");
exit;
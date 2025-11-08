<?php
session_start();

require '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();

    if ($conn) {
        $codeworker = $_POST['workercode']; 
        $codebond = $_POST['codebond'];    
        $bondwname = $_POST['bondwname'];  
        $bondwlastname = $_POST['bondwlastname']; 

        $codeworker = $conn->quote($codeworker);
        $codebond = $conn->quote($codebond);
        $bondwname = $conn->quote($bondwname);
        $bondwlastname = $conn->quote($bondwlastname);

        $sql = "INSERT INTO bondw (codeworker, codebond, bondwname, bondwlastname) 
                VALUES ($codeworker, $codebond, $bondwname, $bondwlastname)";

        if ($conn->exec($sql)) {
            $_SESSION['message'] = 'Bono asignado correctamente';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Error al asignar el bono';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Error de conexión a la base de datos';
        $_SESSION['message_type'] = 'error';
    }
}

header("Location: ../../index.php?p=subviews/bonotrabajador");
exit;
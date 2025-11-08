<?php
session_start();
header("Content-Type: application/json");

require '../../config/database.php';

$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->getConnection();


        $codeturn = $_POST['codeturn'];
        $bondtname = $_POST['bondtname'];
        $bondtlastname = $_POST['bondtlastname'];
        $bonds = $_POST['bonds'];
        
        $sql = "INSERT INTO bondt (codeturn, codebond, bondtname, bondtlastname) 
                VALUES (:codeturn, :codebond, :bondtname, :bondtlastname)";

        $stmt = $conn->prepare($sql);

        $conn->beginTransaction();

        foreach ($bonds as $bond) {
            if (!isset($bond['codebond'])) {
                continue;
            }

            $stmt->bindValue(':codeturn', $codeturn, PDO::PARAM_INT);
            $stmt->bindValue(':codebond', $bond['codebond'], PDO::PARAM_INT);
            $stmt->bindValue(':bondtname', $bondtname, PDO::PARAM_STR);
            $stmt->bindValue(':bondtlastname', $bondtlastname, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                throw new Exception('Error al asignar uno de los bonos');
            }
        }
        
        $conn->commit();

        $response['success'] = true;
        $response['message'] = 'Bonos asignados correctamente al turno';
        
        $_SESSION['message'] = 'Bonos asignados correctamente al turno';
        $_SESSION['message_type'] = 'success';

    } catch (Exception $e) {
        if (isset($conn) && $conn->inTransaction()) {
            $conn->rollBack();
        }

        $response['message'] = $e->getMessage();
        $response['errors'] = $conn->errorInfo() ?? [];
        
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }
} else {
    $response['message'] = 'Método no permitido';
    $_SESSION['message'] = 'Método no permitido';
    $_SESSION['message_type'] = 'error';
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    echo json_encode($response);
    exit;
}

header("Location: ../../index.php?p=subviews/bonoturn");
exit;
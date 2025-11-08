<?php
session_start();

require_once '../../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

$codeturn = isset($_POST['codeturn']) ? intval($_POST['codeturn']) : 0;

$sql = "SELECT turnname, turnstart, turnend, turndelete FROM turn WHERE codeturn = :codeturn";
$stmt = $pdo->prepare($sql);
$stmt->execute([':codeturn' => $codeturn]);
$turno = $stmt->fetch(PDO::FETCH_ASSOC);

if ($turno) {
    echo json_encode([
        'codeturn' => $codeturn,
        'turnname' => $turno['turnname'],
        'turnstart' => $turno['turnstart'],
        'turnend' => $turno['turnend'],
        'turndelete' => (int)$turno['turndelete']
    ]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Turno no encontrado']);
}
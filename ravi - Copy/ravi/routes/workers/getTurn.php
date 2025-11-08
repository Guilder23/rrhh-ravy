<?php
header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require '../../config/database.php';

$db = new Database('local');
$conn = $db->getConnection();

$sql = "SELECT codetturn, tturnname, tturnstart, tturnend FROM tturn WHERE tturndelete = 0";
$stmt = $conn->prepare($sql);
$stmt->execute();
$turnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
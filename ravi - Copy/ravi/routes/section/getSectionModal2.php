<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    include '../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    // Consulta para buscar secciones por nombre o código
    $stmt = $conn->prepare("SELECT codesection, namesection 
                            FROM section 
                            WHERE namesection LIKE ? 
                            AND sectiondelete = 0 
                            LIMIT 10");

    $searchTerm = '%' . $q . '%';
    $stmt->bindParam(1, $searchTerm);
    $stmt->execute();

    // Mostrar resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $sectionInfo = $row['codesection'] . " - " . $row['namesection'];
        echo "<div onclick='seleccionarSection(\"" . $row['codesection'] . "\", \"" . $row['namesection'] . "\")'>" . $sectionInfo . "</div>";
    }
}
?>

<?php
require '../../assets/fpdf186/fpdf.php';
// Recibir datos del formulario
$name = $_POST['name'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$fechaPermiso = $_POST['fechaPermiso'] ?? '';
$fechaHora = $_POST['fechaHora'] ?? '';
$horaInicio = $_POST['horaInicio'] ?? '';
$horaFin = $_POST['horaFin'] ?? '';
$fechaInicio = $_POST['fechaInicio'] ?? '';
$fechaFin = $_POST['fechaFin'] ?? '';
$nombreTrabajador = $_POST['nombreTrabajador'] ?? '';
$cedulaTrabajador = $_POST['cedulaTrabajador'] ?? '';
$motivoSalida = $_POST['motivoSalida'] ?? '';
$seccionSalida = $_POST['seccionSalida'] ?? '';
$observacionSalida = $_POST['observacionSalida'] ?? '';
$codetlicense = $_POST['codetlicense'] ?? '';
$codelicense = $_POST['codelicense'] ?? '';
$codeworker = $_POST['codeworker'] ?? '';

// Cambiado a orientación horizontal ('L') y tamaño media carta apaisado (216x140)
$pdf = new FPDF('L', 'mm', array(216, 140));
$pdf->AddPage();

// Configuración inicial
$pdf->SetMargins(5, 5, 5); // Márgenes izquierdo, superior y derecho
$pdf->SetAutoPageBreak(true, 5); // Margen inferior de 15mm


// Encabezado
$pdf->SetFont('Arial', 'B', 14);



// Encabezado
$pdf->SetFont('Arial', 'B', 14);
$logoWidth = 30; 
$pdf->Image('../../resource/images/logoRavi.png', 15, 10, $logoWidth);
$pdf->SetFont('Arial', '', 7);
$pdf->SetXY(15, 10 + $logoWidth * 0.6);
$pdf->Cell($logoWidth, 4, 'DEPARTAMENTO DE PERSONAL', 0, 0, 'C');

$pdf->SetFont('Arial', 'B', 16);
$pdf->SetY(15);
$pdf->Cell(0, 10, 'ORDEN DE SALIDA', 0, 1, 'C');
$pdf->Ln(10); 



// Escribimos "Motivo:" en negrita
// MOTIVO
// Función para acortar texto si es muy largo
// Configurar márgenes - aumentamos el margen izquierdo para mover todo a la derecha
$marginLeft = 25;  // Aumentado de 15 a 25
$pdf->SetLeftMargin($marginLeft);
$pdf->SetX($marginLeft);

// Anchos de columna (ajustables)
$colWidth = ($pdf->GetPageWidth() - $marginLeft * 2) / 3;

// Función para acortar texto si es muy largo
function shortenText($text, $length) {
    return (strlen($text) > $length) ? substr($text, 0, $length-3).'...' : $text;
}
// Primera columna (Motivo)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 6, 'Motivo:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($colWidth - 15, 6, shortenText($motivoSalida, 25), 0, 0);
// Segunda columna (Sección)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 6, utf8_decode('Sección:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($colWidth - 15, 6, shortenText($seccionSalida, 25), 0, 0);
// Tercera columna (Fecha)
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 6, 'Fecha:', 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($colWidth - 15, 6,$fechaPermiso, 0, 1);

$pdf->Ln(5);



// Función para calcular diferencia de horas
function calcularHoras($horaInicio, $horaFin) {
    $inicio = new DateTime($horaInicio);
    $fin = new DateTime($horaFin);
    if ($fin < $inicio) {
        $fin->modify('+1 day');
    }
    $diferencia = $inicio->diff($fin);
    return $diferencia->format('%H:%I'); // Formato HH:MM
}


$totalHoras = calcularHoras($horaInicio, $horaFin);

// Configuración inicial
$marginLeft = 15;
$colWidth = 50;
$pdf->SetLeftMargin($marginLeft);

// TABLA 1 - Datos del trabajador
// Configuración de bordes
$border = 1; // 1 = mostrar bordes, 0 = sin bordes
$fill = false; // Sin relleno

// TABLA CON BORDES - Datos del trabajador
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($marginLeft);
$pdf->Cell($colWidth, 8, utf8_decode('Código:'), $border, 0, 'L', $fill);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, $cedulaTrabajador, $border, 1, 'L', $fill);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($marginLeft);
$pdf->Cell($colWidth, 8, utf8_decode('Nombre completo:'), $border, 0, 'L', $fill);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 8, utf8_decode($nombreTrabajador), $border, 1, 'L', $fill);
$pdf->Ln(7); // Espacio después de la tabla


// Configuración para 3 columnas
$col1Width = 60; 
$col2Width = 60;
$col3Width = 60;

// TABLA 2 - Horarios (3 columnas x 2 filas)
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($marginLeft);
$pdf->Cell($col1Width, 6, utf8_decode('Hora de salida:'), 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($col2Width, 6, substr($horaInicio, 0, 5), 0, 0); // Columna 1, Fila 1

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($col3Width, 6, utf8_decode('Total horas:'), 0, 1); // Columna 3, Fila 1
$pdf->SetX($marginLeft);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($col1Width, 6, utf8_decode('Hora de regreso:'), 0, 0); // Columna 1, Fila 2
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($col2Width, 6, substr($horaFin, 0, 5), 0, 0); // Columna 2, Fila 2

$pdf->SetFont('Arial', '', 10);
$pdf->Cell($col3Width, 6, $totalHoras, 0, 1); // Columna 3, Fila 2

$pdf->Ln(3);



$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(15); // Asegurar que empiece desde el margen izquierdo
$pdf->Cell(0, 8, 'Observaciones', 0, 1, 'L'); // Cambiado 'C' por 'L' para alinear a la izquierda
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 6, $observacionSalida, 0, 'L');

$pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(37, 6, 'Elaborado por: ' . utf8_decode($name . ' ' . $lastname), 0, 1, 'C');
$pdf->Ln(7);

// Firmas - ajustadas para la orientación horizontal
$pdf->SetFont('Arial', '', 10); // Fuente normal para las líneas
$pdf->Cell(80, 6, '___________________________', 0, 0, 'C');
$pdf->Cell(40, 6, '', 0, 0);

$pdf->SetFont('Arial', 'B', 10); // Cambiamos a negrita para "APROBADO"
$pdf->Cell(80, 6, 'APROBADO', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10); // Volvemos a fuente normal
$pdf->Cell(80, 6, 'Firma del trabajador', 0, 0, 'C');
$pdf->Cell(40, 6, '', 0, 0);
$pdf->Cell(80, 6, utf8_decode('Jefe de Sección'), 0, 1, 'C');

// Salida del PDF
$pdf->Output('I', 'Permiso_Salida_' . $nombreTrabajador . '.pdf');
?>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');

$allowed_pages = ['inicio', 'trabajadores', 'gestionturnos', 'turnos', 'turnotrabajador', 'turnoarea', 'asistencias', 'subviews/approved', 'movimientos', 'usuarios', 'subviews/area', 'subviews/section', 'subviews/cargo', 'subviews/vacation', 'subviews/licencia', 'subviews/falta', 
'subviews/registrar', 'subviews/fechas', 'subviews/motivos', 'subviews/feriados', 'subviews/antiguedad', 'subviews/registrardesc', 'subviews/bono', 'subviews/bonotrabajador', 'subviews/bonoturn', 'subviews/bonogroup'];

$pagina = isset($_GET['p']) ? strtolower($_GET['p']) : 'inicio';
if (!in_array($pagina, $allowed_pages)) {
    $pagina = '404'; 
}

require_once 'views/header.php';

echo '<div class="contenedorCuerpo">';

    echo '<div class="columnaLateral">';
        require_once "views/columns.php";
    echo '</div>';
    
    echo '<div class="contenidoPanel">';
        require_once "views/{$pagina}.php"; 
    echo '</div>';
    
echo '</div>';

//require_once 'views/footer.php';
?>
<style>
 body{
     margin:0;
     padding:0;
 }
 .contenedorCuerpo{
     display: flex;
     flex-wrap: nowrap;
     width: 100%;
 }
 .columnaLateral, .contenidoPanel{
    box-sizing:border-box;
 }
 .columnaLateral{
    width:220px;
    padding:5px;
    margin-right:5px;
    transition: width 0.3s ease;
 }
 .contenidoPanel{
     width: calc(100% - 225px);
     margin:5px; 
     flex: 1 1 100%;
     overflow:auto;
 }
 
 @media (max-width: 768px) {
    .columnaLateral {
        width: 80px;
    }
   
    .contenidoPanel {
        width: calc(100% - 80px);
    }
}
</style>



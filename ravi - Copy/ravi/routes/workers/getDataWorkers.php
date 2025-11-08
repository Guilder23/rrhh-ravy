<?php
require_once '../../config/database.php';

$database = new Database();
$conn = $database->getConnection();

/*
obtener los datos de la tabla worker que contiene las columnas:
    codeworker (aqui identificamos la fila con el id recibido), workercode, workername1, workername2, workerlastname1, workerlastname2, workerhousbandname, workerbirthdate, workertypedoc, workerdoccity, workerdocnumber, 
    
*/
?>
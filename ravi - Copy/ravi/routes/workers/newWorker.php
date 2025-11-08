<?php
session_start();
require '../config/database.php';

$database = new Database('local');
$conn = $database->getConnection();

$workercode = $conn->real_escape_string($_POST['workercode']);
$workername1 = $conn->real_escape_string($_POST['workername1']);
$workername2 = $conn->real_escape_string($_POST['workername2']);
$workerlastname1 = $conn->real_escape_string($_POST['workerlastname1']);
$workerlastname2 = $conn->real_escape_string($_POST['workerlastname2']);
$workerhousbandname = $conn->real_escape_string($_POST['workerhousbandname']);
$workerbirthdate = $conn->real_escape_string($_POST['workerbirthdate']);
$workertypedoc = $conn->real_escape_string($_POST['workertypedoc']);
$workerdoccity = $conn->real_escape_string($_POST['workerdoccity']);
$workerdocnumber = $conn->real_escape_string($_POST['workerdocnumber']);
$workersecurenum = $conn->real_escape_string($_POST['workersecurenum']);
$workercuanum = $conn->real_escape_string($_POST['workercuanum']);
$workerbanknum = $conn->real_escape_string($_POST['workerbanknum']);
$workercity = $conn->real_escape_string($_POST['workercity']);
$workeremail = $conn->real_escape_string($_POST['workeremail']);
$workerphone1 = $conn->real_escape_string($_POST['workerphone1']);
$workerimg = "default_image.webp";

// Insertar el trabajador en la base de datos
$sql = "INSERT INTO worker (workercode, workername1, workername2, workerlastname1, workerlastname2, workerhousbandname, workerbirthdate, workertypedoc, workerdoccity, workerdocnumber, workersecurenum, workercuanum, workerbanknum, workercity, workeremail, workerphone1, workerimg) 
VALUES ('$workercode', '$workername1', '$workername2', '$workerlastname1', '$workerlastname2', '$workerhousbandname', '$workerbirthdate', '$workertypedoc', '$workerdoccity', '$workerdocnumber', '$workersecurenum', '$workercuanum', '$workerbanknum', '$workercity', '$workeremail', '$workerphone1', '$workerimg')";

if ($conn->query($sql)) {
    $id = $conn->insert_id;

    $_SESSION['color'] = "success";
    $_SESSION['msg'] = "Trabajador guardado";

    if ($_FILES['workerimg']['error'] == UPLOAD_ERR_OK) {
        $permitidos = array("image/jpg", "image/jpeg", "image/png", "image/webp");

        if (in_array($_FILES['workerimg']['type'], $permitidos)) {
            $dir = "../resourse/worker/";
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $info_img = pathinfo($_FILES['workerimg']['name']);
            $extension = $info_img['extension'];

            if ($extension == 'jpeg' || $extension == 'jpg') {
                $imageResource = imagecreatefromjpeg($_FILES['workerimg']['tmp_name']);
            } elseif ($extension == 'png') {
                $imageResource = imagecreatefrompng($_FILES['workerimg']['tmp_name']);
            }

            $imagenWebp = $dir . $id . '.webp';

            if ($imageResource && imagewebp($imageResource, $imagenWebp, 80)) {
                imagedestroy($imageResource);

                $sqlUpdate = "UPDATE worker SET workerimg = '$imagenWebp' WHERE codeworker = $id";
                if (!$conn->query($sqlUpdate)) {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Error al actualizar la imagen en la base de datos";
                }
            } else {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Error al convertir la imagen a formato .webp";
            }
        } else {
            $_SESSION['color'] = "danger";
            $_SESSION['msg'] .= "<br>Formato de imagen no permitido";
        }
    }
} else {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error al guardar trabajador";
}

header('Location: ../index.php?p=worker');
exit;

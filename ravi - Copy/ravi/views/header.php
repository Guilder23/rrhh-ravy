<?php
include($_SERVER['DOCUMENT_ROOT'] . '/config/sessionController.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/css/styleRecursive.css">
    
    
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <title>rrhh</title>
</head>

<body>

<?php
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    
    echo "<div class='message $message_type notification verde'>$message</div>";
    
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>

<div class="containerCabeceraUp">
<section class="cabeceraUp">
    <h3 class="tituloSistema">SISTEMA DE RRHH</h3>
    
    <section class="nameUserbtnCerrar">
        <div class="me-3 text-end">
            <span class="d-block fw-bold text-primary">
            <?php echo htmlspecialchars($_SESSION["username"], ENT_QUOTES, 'UTF-8'); ?>
            </span>
        </div> 
        <button onclick="window.location.href='../config/logoutController.php'" class="btnCerrarSesion">
            <span>Salir</span>
        </button>
    </section>
</section>
</div>      


<style>
.notification {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(120deg, #7fbc03, gold);
    color:#333;
    font-weight:bold;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    text-align: center;
    animation: slide-up 0.5s ease, fade-out 7.5s ease 1.5s forwards;
    z-index: 9999; 
    pointer-events: none;
}
/* Animación para que aparezca desde abajo */
@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}
/* Animación para desvanecerse después de un tiempo */
@keyframes fade-out {
    to {
        opacity: 0;
    }
}




/* Global styles */
html, body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}
.containerCabeceraUp{
    position:relative;
   padding-bottom:35px;
   z-index:100;
}
.cabeceraUp{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    display:flex; 
    background: rgb(163, 226, 38);
    justify-content:space-between;
    padding:2px 15px;
    align-items:center;
    margin-bottom:5px;
    z-index:1000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.nameUserbtnCerrar{
  display:flex;
  gap:20px;
  align-items:center;
  background: rgb(192, 243, 90);
  padding:1px 20px;
  border-radius:7px;
}
.optionsLeft {
  display: flex;
  flex-direction: column;
  background: #333;
  width: 200px;
  height: 70vh;
  padding: 0; 
  margin: 0; 
}

.optionOnly {
  display: flex;
  list-style: none;
  background: #7fbc03;
  border-color: #7fbc03;
  padding: 10px;
  margin-bottom: 7px;
  transition: transform 0.3s ease;
  border-radius: 5px;
  margin-left:10px;
  margin-right:10px;
}


.option_a {
    display:flex;
    gap:7px;
    text-decoration: none;
    color: white;
    margin-left:0;
}

.optionOnly:hover {
    background: rgb(163, 226, 38);
    transform: scale(1.1);
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}


.btnCerrarSesion{
    padding: 2px 15px;
    color:white;
    background:#333;
    border:none;
    display:flex;
    justify-content:center;
    align-items:center;
    border-radius: 5px;
    width:70px;
}
.btnCerrarSesion:hover{
    background:rgb(221, 0, 0);
    cursor: pointer; 
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}
.tituloSistema{
    font-size: 1rem;
    margin:0;
    font-weight:bold;
}
</style>
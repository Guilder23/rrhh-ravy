<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require_once '../config/database.php';
require_once '../models/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userlogin = $_POST['username'] ?? '';
    $userpassword = $_POST['password'] ?? '';

    $database = new Database('local');
    $db = $database->getConnection();
    $userModel = new User($db);

    $stmt = $userModel->findByUsername($userlogin);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $userpassword == $user['userpassword']) { 
        $_SESSION['codeuser'] = $user['codeuser'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['userlastname'] = $user['userlastname'];
        $_SESSION['usertype'] = $user['usertype'];
        $_SESSION['userci'] = $user['userci'];
        $_SESSION['userphone'] = $user['userphone'];
        $_SESSION['useraddress'] = $user['useraddress'];
        $_SESSION['userstate'] = $user['userstate'];
        $_SESSION['useraccess'] = $user['useraccess'];

        header("Location: ../index.php?p=Inicio");
        exit();
    } else {
        header("Location: login.php?error=" . urlencode("Usuario o contraseña incorrectos."));
        exit();
    }
} else {
    header("Location: views/login.php");
    exit();
}
?>




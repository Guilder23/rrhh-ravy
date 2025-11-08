<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>

<body>

<img src="../resource/images/fondoRavi.avif" class="fondoLogin">

    <main class="login-container">
        <img src="../resource/images/logoRavi.png" class="logoEmpresa">
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <p><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>

        <form action="entrar.php" method="POST" class="login-form">
            <div class="input-container">
                <input type="text" id="username" name="username" placeholder="Nombre de usuario" required>
            </div>

            <div class="input-container">
                <input type="password" id="password" name="password" placeholder="Contrasena" required>
            </div>

            <button type="submit">Iniciar sesión</button>
        </form>
    </main>
</body>

 <style>
        body {
            margin: 0;
            padding: 0;
        } 
        .logoEmpresa{
            width:250px;
        }
        .fondoLogin{
           width:100%;
           height:100vh;
           overflow:hidden;
           position:absolute;
           z-index:-1;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width:350px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .input-container {
            margin-bottom: 15px;
        }

        input {
            font-size:1rem;
            width: 96%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: rgb(163, 226, 38);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size:1rem;
        }

        button:hover {
            background: rgb(133, 196, 8);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>

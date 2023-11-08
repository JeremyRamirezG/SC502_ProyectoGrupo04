<?php
session_start();
// Verificar si el usuario ha iniciado sesión
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <script src="https://kit.fontawesome.com/ca4d4e6a64.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nuosu+SIL&family=Oswald:wght@200&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Inicio</title>

</head>
<body>

   <div class="head">

        <div class="logo">
            <a href="#">Aplicación Citas Médicas</a> 
        </div>

        <nav class="navbar">
            <a href="index.php">Inicio</a>
            <a href="login.php">Inicio Sesión</a>
            <a href="register.php">Registro</a>
            <a href="Reservaciones.php">Reservaciones Citas Médicas</a>
            <a href="ContactoEmergencia.php">Contacto De Emergencia</a>
            <a href="Comentarios.php">Comentarios</a>
            <a href="ChatAyuda.php">Chat de Ayuda</a>
                 <?php if (isset($_SESSION['correo'])) { ?>
            <a href="../PHP/perfil.php">Perfil</a> <!--FALTA-->
                <?php } else { ?>
            <a href="../PHP/Registro.php">Registro</a>
                <?php } ?>
                <?php if (!$logged_in && !isset($_SESSION['correo'])) { ?>
            <a href="InicioSesion.html">Iniciar sesión</a>
                <?php } ?>
        </nav>

    </div>

    <header class="content header">
        
        <h2 class="title">BIENVENIDO</h2>
        <p>
            Descubre todos los beneficios que obtendras en nuestra app.
        </p>

        <div class="btn-home">
            <a href="../PHP/Registro.php" class="btn">Registro</a>
            <a href="login.html" class="btn">Iniciar Sesión</a>
        </div>
    </header>

    <footer class="piePagina">
    <div class="grupo1">

         <div class="box">
            <figure>
                <a href="../HTML/index.php">
                    <img src="../IMG/Logo.jpg" alt="Logo">
                </a>
            </figure>
         </div>
         <div class="box">
            <h2>Síguenos</h2>
            <div class="redsocial">
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-instagram"></a>
                <a href="#" class="fa fa-linkedin"></a>
                <a href="#" class="fa fa-twitter"></a>
            </div>
         </div>
         
    </div>

    <div class="grupo2">
        <small>&copy;2023 <b>Aplicación Citas Médicas</b> Todos los Derechos de Autor Reservados.</small>
    </div>

    <div class="grupo3">

    </div>
    
    </footer>
    
    
</body>
</html>

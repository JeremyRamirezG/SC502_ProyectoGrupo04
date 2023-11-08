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
    <link rel="stylesheet" href="CSS/index.css">
    <script src="https://kit.fontawesome.com/ca4d4e6a64.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nuosu+SIL&family=Oswald:wght@200&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
    <title>Inicio</title>

</head>

<body>
    <div class="head">
        <nav>
            <a href="index.html"><img src="IMG/Logo.jpg"></a>
            <div class="nav-links" id="navLinks">
                <ul>
                    <li><a href="index.php">INICIO</a></li>
                    <li><a href="reservar.php">RESERVAR CITAS MEDICAS</a></li>
                    <li><a href="contacto.php">CONTACTO EMERGENCIA</a></li>
                    <li><a href="register.php">REGISTRO</a></li>
                    <li><a href="login.php">INICIO SESIÓN</a></li>
                    <li><a href="comentarios.php">COMENTARIOS</a></li>
                    <li><a href="chatAyuda.php">CHAT DE AYUDA</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <header class="content header">

        <h2 class="title">BIENVENIDO</h2>
        <div class="feature-box"> 
            <h2>
            Descubre todos los beneficios que obtendrás en nuestra app.<!--AGREGAR ALGO MAS-->
            </h2>
        </div>
    </header>
    </section>
    <!--Sobre la empresa-->
    <section class="content-about">
        <div class="text-box">
            <br />
            <br />
            <h1>¿Quiénes Somos?</h1>
            <br />
            <br />
            <br />
            <br />
            <br />
            <p></p>
            <br />
            <p></p>
            <br />
            <p></p>
        </div>
    </section>
    <!--Otra Informacion-->
    <section class="content-sau">
        <br />
        <h1>Otra Informacion</h1>
        <br />
        <br />
        <div class="box-container">
            <div class="box">
                <h2>Informacion</h2>
                <br />
                <br />
                <br />
                <p></p>
            </div>
            <div class="box">
                <h2>Informacion</h2>
                <br />
                <br />
                <br />
                <p></p>
            </div>
        </div>
    </section>
    <!--Galeria-->
    <section class="content-photos">
        <br />
        <h2>Galería de Imágenes</h2>
        <div class="content-photo">
        </div>
        </div>
    </section>
    <!--Contactenos-->
    <section class="content-service ">
        <br />
        <h1>Contáctenos</h1>
        <p> Ofrece sus servicios en Costa Rica</p>
        <div class="box-container">
            <div class="box2">
                <br />
                <h3>Correo Electrónico</h3>
                <br />
                <br />
                <p>??????</p>
            </div>
            <div class="box2">
                <br />
                <h3>Números de Teléfono</h3>
                <br />
                <br />
                <p>777-1000</p>
                <p>+506 2299-5800</p>
                <p>+506 2668-0095</p>
                <p>Emergencias 9-1-1</p>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="piePagina">
        <div class="grupo1">

            <div class="box">
                <figure>
                    <a href="../HTML/index.php">
                        <img src="IMG/Logo.jpg" alt="Logo">
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
                <div class="derechos">
                <small>&copy;2023 <b>App Citas Medicas</b> Todos los Derechos de Autor Reservados.</small>
                </div>
            </div>

        </div>

    </footer>
</body>

</html>
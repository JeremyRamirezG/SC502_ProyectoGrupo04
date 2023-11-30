<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit();
}

// Incluye la conexión a la base de datos y las funciones necesarias
require_once "dbCRUD/conexion.php";
require_once "dbCRUD/datosCRUD.php";

// Obtén la cédula del usuario desde la sesión
$cedula = $_SESSION['id'];

// Realiza una consulta para obtener el avatar del usuario
$query = "SELECT Avatar FROM tab_usuarios WHERE Cédula = $cedula";
$resultado = getDatosArray($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class='header'>
    <a href='index.php'>
        <img class='header__logo' src='img/logo.png' alt='Logotipo'>
    </a>
</header>

<nav class='navegacion-vertical'>
<p></p>
    <p></p>
    <a class='navegacion__links' href='index.php'>Inicio</a>
    <p></p>
    <p></p>
    <a class='navegacion__links' href='servicios.php'>Servicios</a>
    <p></p>
    <p></p>
    <a class='navegacion__links' href='citas.php'>Citas</a>
    <p></p>
    <p></p>
    <a class='navegacion__links' href='soporteFeedback.php'>Soporte & Feedback</a>
    <p></p>
    <p></p>
    <a class='navegacion__links' href='chat.php'>Chat en Línea</a>
    <p></p>
    <p></p>
    <a class='navegacion__links' href='dashboard.php'>Dashboard para Administrador</a>

    <?php if (!empty($resultado[0]['Avatar'])): ?>
    <a class='navegacion__imagenes' href='perfil.php'><img src='data:image/png;base64,<?= base64_encode($resultado[0]['Avatar']) ?>' alt='Avatar'></a>
<?php else: ?>
    <a class='navegacion__imagenes' href='perfil.php'><img src='IMG/perfilChat.png' alt='Avatar Predeterminado'></a>
<?php endif; ?>
</nav>

</body>
</html>
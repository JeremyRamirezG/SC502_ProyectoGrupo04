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

// Muestra la barra de navegación
echo "<body>";
echo "<header class='header'>";
echo "<a href='index.php'>";
echo "<img class='header__logo' src='img/logo.png' alt='Logotipo'>";
echo "</a>";
echo "</header>";
echo "<nav class='navegacion'>";
echo "<a class='navegacion__links' href='index.php'>Inicio</a>";
echo "<a class='navegacion__links' href='servicios.php'>Servicios</a>";
echo "<a class='navegacion__links' href='citas.php'>Citas</a>";
echo "<a class='navegacion__links' href='soporteFeedback.php'>Soporte & Feedback</a>";
echo "<a class='navegacion__links' href='chat.php'>Chat en Línea</a>";

if (!empty($resultado[0]['Avatar'])) {
    echo "<a class='navegacion__imagenes' href='perfil.php'><img src='data:image/png;base64," . base64_encode($resultado[0]['Avatar']) . "' alt='Avatar'></a>";
}

echo "</nav>";
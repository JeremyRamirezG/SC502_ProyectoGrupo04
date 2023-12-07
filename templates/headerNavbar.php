<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit();
}

// Se incluye la conexion de la base de datos
require_once "dbCRUD/conexion.php";
require_once "dbCRUD/datosCRUD.php";
require_once "templates/validarRol.php";

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
echo "<input type='checkbox' id='check'>";
echo "<label for='check' class='menu__btn'>";
echo "<img src='IMG/menu.png' alt='Menu'>";
echo "</label>";
echo "<ul id='lista__nav'>";
echo "<li><a class='navegacion__links' href='index.php'>Inicio</a></li>";
echo "<li><a class='navegacion__links' href='servicios.php'>Servicios</a></li>";
echo "<li><a class='navegacion__links' href='citas.php'>Citas</a></li>";
echo "<li><a class='navegacion__links' href='soporteFeedback.php'>Feedback</a></li>";
echo "<li><a class='navegacion__links' href='chatEnLinea.php'>Chat en Línea</a></li>";
if($_SESSION["rol"]=="Administrador"){
    echo "<li><a class='navegacion__links' href='dashboard.php'>Dashboard Admin</a></li>";
}

if (!empty($resultado[0]['Avatar'])) {
    echo "<li><a class='navegacion__imagenes' href='perfil.php'><img src='data:image/png;base64," . base64_encode($resultado[0]['Avatar']) . "' alt='Avatar'></a></li>";
}else{
    echo "<li><a class='navegacion__imagenes' href='perfil.php'><img src='IMG/perfilChat.png' alt='Avatar Predeterminado'></a></li>";
}
echo "</ul>";

echo "</nav>";
<?php
    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
?>
<?php
// Verifica si el usuario está autenticado
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    // Si no está autenticado, redirige al inicio de sesión
    header('Location: login.php');
    exit();
}

// Incluye la cabecera y cualquier otro elemento de la interfaz de usuario necesario
require_once "templates/head.php";

// Incluye el archivo de conexión a la base de datos y las funciones necesarias
require_once "dbCRUD/conexion.php";
require_once "dbCRUD/datosCRUD.php";

// Obtén la cédula del usuario desde la sesión
$cedula = $_SESSION['id'];

// Realiza una consulta para obtener el resto de los datos del usuario
$query = "SELECT * FROM tab_usuarios WHERE Cédula = $cedula";
$resultado = getDatosArray($query);

// Muestra el perfil del usuario
echo "<body>";
echo "<div class='contenedor__pagina'>";
echo "<div class='contenedor__form'>";
echo "<h2>Bienvenido a tu perfil</h2>";
echo "<p>Información de tu perfil:</p>";
if (!empty($resultado)) {
    // Muestra los detalles del perfil del usuario
    foreach ($resultado as $usuario) {
        echo "<ul>";
        echo "<li>Cédula: " . $usuario['Cédula'] . "</li>";
        echo "<li>Nombre: " . $usuario['PrimerNombre'] . "</li>";
        echo "<li>Apellidos: " . $usuario['PrimerApellido'] .'  '. $usuario['SegundoApellido']."</li>";
        echo "<li>Teléfono: " . $usuario['Teléfono'] . "</li>";
        echo "<li>Correo: " . $usuario['Correo'] . "</li>";
        echo "</ul>";
    }
} else {
    echo "<p>No se encontraron detalles del perfil.</p>";
}


echo "<p><a class='usuario__links' href='cerrarsesion.php'>Cerrar Sesión</a></p>"; // Enlace para cerrar sesión
echo "<p><a class='usuario__links' href='agregarperfil.php'>Agregar más datos</a></p>";
echo "</div>";
echo "</div>";
echo "</body>";
?>
<?php
    require_once "templates/footer.php";
?>
<?php
    session_start();
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
        // Si no está autenticado, redirige al inicio de sesión
        header('Location: login.php');
    }

    // Incluye la cabecera y cualquier otro elemento de la interfaz de usuario necesario

    // Incluye el archivo de conexión a la base de datos y las funciones necesarias
    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
    require_once "dbCRUD/conexion.php";
    require_once "dbCRUD/datosCRUD.php";

?>
<main>
<?php
// Obtén la cédula del usuario desde la sesión
$cedula = $_SESSION['id'];

// Realiza una consulta para obtener el resto de los datos del usuario
$query = "SELECT * FROM tab_usuarios WHERE Cédula = $cedula";
$resultado = getDatosArray($query);

$queryAlergias = "SELECT a.Nombre FROM tab_alergias a
LEFT JOIN tab_alergiasusuario au ON au.CodAlergia = a.CodAlergia
WHERE au.Cédula = $cedula";
$alergias = getDatosArray($queryAlergias);

$queryEnfermedades = "SELECT e.Enfermedad FROM tab_historialmedico e
LEFT JOIN tab_historialmedicousuario eu ON eu.CodHistorial = e.CodHistorial
WHERE eu.Cédula = $cedula";
$enfermedades = getDatosArray($queryEnfermedades);

// Muestra el perfil del usuario
echo "<div class='contenedor__perfil'>";
echo "<h2>Bienvenido a tu perfil</h2>";
echo "<p>Información de tu perfil:</p>";
if (!empty($resultado)) {
    // Muestra los detalles del perfil del usuario
    foreach ($resultado as $usuario) {
        echo "<ul class='perfil-ul'>";
        echo "<li>Cédula: " . $usuario['Cédula'] . "</li>";
        echo "<li>Nombre: " . $usuario['PrimerNombre'] . "</li>";
        echo "<li>Apellidos: " . $usuario['PrimerApellido'] .'  '. $usuario['SegundoApellido']."</li>";
        echo "<li>Teléfono: " . $usuario['Teléfono'] . "</li>";
        echo "<li>Correo: " . $usuario['Correo'] . "</li>";
        echo "<li>Enfermedades: ";
        if(!empty($enfermedades)){
            foreach ($enfermedades as $enfermedad) {
                echo "<br>".$enfermedad['Enfermedad'];
            }
        }
        else {
            echo "No hay enfermedades registradas.";
        }
        echo "</li>";
        echo "<li>Alergias: ";
        if(!empty($alergias)){
            foreach ($alergias as $alergia) {
                echo "<br>".$alergia['Nombre'];
            }
        }
        else {
            echo "No hay alergias registradas.";
        }
        echo "</li>";
        echo "</ul>";
    }
} else {
    echo "<p>No se encontraron detalles del perfil.</p>";
}


echo "<p><a class='usuario___links' href='cerrarsesion.php'>Cerrar Sesión</a></p>"; // Enlace para cerrar sesión
echo "<p><a class='usuario___links' href='agregarperfil.php'>Agregar más datos</a></p>";
echo "</div>";
?>
</main>
<?php
    require_once "templates/footer.php";
?>
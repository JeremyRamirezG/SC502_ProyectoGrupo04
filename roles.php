<?php
require_once "templates/head.php";
require_once "templates/headerNavbar.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
}

require_once "dbCRUD/conexion.php";

$conexion = Conecta();

if ($conexion === null) {
    die("Error al conectar a la base de datos");
}

$sql = "SELECT tab_usuarios.Cédula, tab_usuarios.PrimerNombre, tab_usuarios.PrimerApellido, 
        IFNULL(GROUP_CONCAT(tab_roles.Descripción SEPARATOR ', '), 'Sin roles asignados') AS Roles
        FROM tab_usuarios
        LEFT JOIN tab_rolesusuario ON tab_usuarios.Cédula = tab_rolesusuario.Cédula
        LEFT JOIN tab_roles ON tab_rolesusuario.CodRol = tab_roles.CodRol
        GROUP BY tab_usuarios.Cédula";

$result = mysqli_query($conexion, $sql);

if ($result->num_rows > 0) {
    echo "<table border='1' style='width: 80%; margin: 0 auto; font-size: 18px; text-align: center;'>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Roles</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["Cédula"] . "</td>
                <td>" . $row["PrimerNombre"] . " " . $row["PrimerApellido"] . "</td>
                <td>" . $row["Roles"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron resultados";
}

mysqli_close($conexion); ?>

<?php
require_once "templates/footer.php";
?>
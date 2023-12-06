<?php
require_once "templates/head.php";
require_once "templates/headerNavbar.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Citas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h2 class="titulo__animacion">Lista de Citas</h2>
    <?php
    require_once "dbCRUD/conexion.php";

    $conexion = Conecta();

    if ($conexion === null) {
        die("Error al conectar a la base de datos");
    }

    $sql = "SELECT * FROM tab_citas";

    $result = mysqli_query($conexion, $sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Fecha</th>
                    <th>Especialidad</th>
                    <th>Método de Reserva</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Fecha"] . "</td>
                    <td>" . $row["Especialidad"] . "</td>
                    <td>" . $row["MétodoReserva"] . "</td>
                    <td>" . $row["Descripción"] . "</td>
                    <td>" . $row["Estado"] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='no-citas'>No hay citas registradas</p>";
    }

    mysqli_close($conexion);
    ?>
</body>

</html>
<?php
require_once "templates/footer.php";
?>
<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";

    $cliente_id = $_SESSION['id'];
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $empleado_id = '';
    } else {
        header("Location: index.php");
    }

    //Se selecciona un empleado random para asistir
    $queryEmpleado = "SELECT u.Cédula, u.PrimerNombre, u.PrimerApellido, u.Correo FROM tab_usuarios u
                      LEFT JOIN tab_rolesusuario ru ON u.Cédula = ru.Cédula
                      WHERE u.Cédula != $cliente_id AND ru.CodRol = 2";
    $empleados = getDatosArray($queryEmpleado);
    $random = array_rand($empleados);

    $empleado_id = $empleados[$random];

    //echo $empleado_id['Correo'];
?>

<?php
    require_once "templates/footer.php";
?>
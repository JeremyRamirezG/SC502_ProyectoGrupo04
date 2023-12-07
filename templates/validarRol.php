<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
    header("location: login.php");
    exit;
}

$cliente_idIni = $_SESSION['id'];

$queryUsuarioIni = "SELECT u.Cédula, u.PrimerNombre, u.PrimerApellido, u.Correo, ru.CodRol FROM tab_usuarios u
                  LEFT JOIN tab_rolesusuario ru ON u.Cédula = ru.Cédula
                  WHERE u.Cédula = $cliente_idIni";
$usuarioRolesIni = getDatosArray($queryUsuarioIni);

if(!isset($_SESSION["rol"]) || !($_SESSION["rol"] === true)){
    foreach ($usuarioRolesIni as &$usuarioRolIni) {
        if($usuarioRolIni['CodRol'] == 1){
            $_SESSION["rol"]='Cliente';
        } else if ($usuarioRolIni['CodRol'] == 2) {
            $_SESSION["rol"]='Empleado';
        } else if ($usuarioRolIni['CodRol'] == 3) {
            $_SESSION["rol"]='Administrador';
        }
    }
}
<?php
try{
    //Primero se inicia la sesión y se valida si ya se ha ingresado.
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    //Incluir el archivo para realizar la conexion a la base de datos
    require_once "../dbCRUD/conexion.php";

    $nombre_err = $telefono_err = $ubicacion_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $objDatos = new stdClass();
        
        $objDatos-> Nombre = $nombre_val = recogePost('Nombre');
        $objDatos-> Telefono = $telefono_val = recogePost('Telefono');
        $objDatos-> Ubicacion = $ubicacion_val = recogePost('Ubicacion');
        $objDatos-> Cedula = $_SESSION['id'];

        if(empty($nombre_val)||empty($telefono_val)||empty($ubicacion_val))
        {
            $nombre_err = $telefono_err = $ubicacion_err = 'Algún dato requerido se encuentra vacío.';
            header("Location: ../servicios.php");
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = ingresoDatos('tab_contactoemergencia',$objDatos);
            if($resultado!=''){
                header("Location: ../servicios.php");
            }
        }
    } else {
        header("Location: ../servicios.php");
    }

} catch(Throwable $th) {
    error_log($th, 0);
}
?>
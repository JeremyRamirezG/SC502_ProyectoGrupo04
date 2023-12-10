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
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$codigo_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../servicios.php';}, 2000);</script>";
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = ingresoDatos('tab_contactoemergencia',$objDatos);
            if($resultado!=''){
                echo "<script>window.location.href='../servicios.php';</script>";
            }
        }
    } else {
        echo "<script>window.location.href='../servicios.php';</script>";
    }

} catch(Throwable $th) {
    error_log($th, 0);
    echo "<span class='errores'>Ocurrio un error en el sistema.<br></span><span class='errores'>Redireccionando a página principal.</span>";
    echo "<script>setTimeout(() => {window.location.href='../servicios.php';}, 2000);</script>";
}
?>
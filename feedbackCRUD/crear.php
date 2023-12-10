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

    $titulo_err = $area_err = $calificacion_err = $desc_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $objDatos = new stdClass();
        
        $objDatos-> Titulo = $titulo_val = recogePost('titulo');
        $objDatos-> Area = $area_val = recogePost('area');
        $objDatos-> Descripcion = $desc_val = recogePost('descripcion');
        $objDatos-> Calificacion = $calificacion_val = recogePost('calificacion');

        if(empty($titulo_val)||empty($area_val)||empty($calificacion_val)||empty($desc_val))
        {
            $titulo_err = $area_err = $calificacion_err = $desc_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$titulo_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../soporteFeedback.php';}, 2000);</script>";
        }
        if ($calificacion_val < 1 || $calificacion_val > 10)
        {
            $calificacion_err = 'La calificacion no es correcta.';
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$calificacion_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../soporteFeedback.php';}, 2000);</script>";
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = ingresoDatos('tab_feedback',$objDatos);
            echo "<script>window.location.href='../soporteFeedback.php';</script>";
        }
    } else {
        echo "<script>window.location.href='../soporteFeedback.php';</script>";
    }

} catch(Throwable $th) {
    error_log($th, 0);
    echo "<span class='errores'>Ocurrio un error en el sistema.<br></span><span class='errores'>Redireccionando a página principal.</span>";
    echo "<script>setTimeout(() => {window.location.href='../soporteFeedback.php';}, 2000);</script>";
}
?>
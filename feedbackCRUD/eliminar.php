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
    require_once '../dbCRUD/datosCRUD.php';
    require_once "../templates/validarRol.php";

    $codigo_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION["rol"]=="Administrador") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $codigo_val = recogePost('CodFeedback');
        $query = "DELETE FROM tab_feedback WHERE CodFeedback=$codigo_val";

        if(empty($codigo_val))
        {
            $codigo_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$codigo_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../soporteFeedback.php';}, 2000);</script>";
        }
        else
        {
            $resultado = borrarDatos($query);
            if($resultado!=''){
                echo "<script>window.location.href='../soporteFeedback.php';</script>";
            }
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

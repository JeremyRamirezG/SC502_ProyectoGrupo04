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
            echo "<span class='errores'>$codigo_err<br>Redireccionando a página principal.</span>";
            sleep(2);
            echo "<script>window.location.href='../soporteFeedback.php';</script>";
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
}
?>

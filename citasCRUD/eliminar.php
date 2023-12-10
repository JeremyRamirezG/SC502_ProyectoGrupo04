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

    $codigo_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $codigo_val = recogePost('CodCita');
        $query = "DELETE FROM tab_citas WHERE CodCita=$codigo_val";

        if(empty($codigo_val))
        {
            $codigo_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span class='errores'>$codigo_err<br>Redireccionando a página principal.</span>";
            sleep(2);
            echo "<script>window.location.href='../citas.php';</script>";
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = borrarDatos($query);
            if($resultado!=''){
                echo "<script>window.location.href='../citas.php';</script>";
            }
        }
    } else {
        echo "<script>window.location.href='../citas.php';</script>";
    }

} catch(Throwable $th) {
    error_log($th, 0);
    echo "<span class='errores'>Ocurrio un error en el sistema.<br>Redireccionando a página principal.</span>";
    sleep(2);
    echo "<script>window.location.href='../citas.php';</script>";
}
?>

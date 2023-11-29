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
            header("Location: ../citas.php");
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = borrarDatos($query);
            if($resultado!=''){
                header("Location: ../citas.php");
            }
        }
    } else {
        header("Location: ../citas.php");
    }

} catch(Throwable $th) {
    error_log($th, 0);
}
?>

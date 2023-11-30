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

    $estado_err = $codigo_err = $tipo_err = $fecha_err = $desc_err = $resultado_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $objDatos = new stdClass();
        
        $codigo_val = recogePost('CodExamen');
        $objDatos-> Tipo = $tipo_val = recogePost('Tipo');
        $objDatos-> Fecha = $fecha_val = recogePost('Fecha');
        $objDatos-> Resultado = $resultado_val = recogePost('Resultado');
        $objDatos-> Descripcion = $desc_val = recogePost('Descripcion');
        $objDatos-> Estado = $estado_val = recogePost('Estado');

        if(empty($codigo_val)||empty($tipo_val)||empty($fecha_val)||empty($resultado_val)||empty($desc_val)||empty($estado_val))
        {
            $estado_err = $codigo_err = $tipo_err = $fecha_err = $desc_err = $resultado_err = 'Algún dato requerido se encuentra vacío.';
            header("Location: ../servicios.php");
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = actualizarDatos('tab_examenesmedicos',$objDatos,$codigo_val);
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
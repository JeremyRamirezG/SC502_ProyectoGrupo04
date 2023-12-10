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
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$estado_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../servicios.php';}, 2000);</script>";
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = actualizarDatos('tab_examenesmedicos',$objDatos,$codigo_val);
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
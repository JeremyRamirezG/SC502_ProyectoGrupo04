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

    $tipo_err = $fecha_err = $desc_err = $resultado_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $objDatos = new stdClass();
        
        $objDatos-> Tipo = $tipo_val = recogePost('Tipo');
        $objDatos-> Fecha = $fecha_val = recogePost('Fecha');
        $objDatos-> Resultado = $resultado_val = recogePost('Resultado');
        $objDatos-> Descripcion = $desc_val = recogePost('Descripcion');
        $objDatos-> Estado = 'Pendiente';

        if(empty($tipo_val)||empty($fecha_val)||empty($resultado_val)||empty($desc_val))
        {
            $tipo_err = $fecha_err = $desc_err = $resultado_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span class='errores'>$tipo_err<br>Redireccionando a página principal.</span>";
            sleep(2);
            header("Location: ../servicios.php");
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = ingresoDatos('tab_examenesmedicos',$objDatos);
            if($resultado!=''){
                $objAsociacion = new stdClass();
                $objAsociacion->CodExamen = $resultado;
                $objAsociacion->Cedula = $_SESSION['id'];
                if(ingresoDatos('tab_examenesmedicosusuario',$objAsociacion)!=''){
                    header("Location: ../servicios.php");
                }
            }
        }
    } else {
        header("Location: ../servicios.php");
    }

} catch(Throwable $th) {
    error_log($th, 0);
    echo "<span class='errores'>Ocurrio un error en el sistema.<br>Redireccionando a página principal.</span>";
    sleep(2);
    header("Location: ../servicios.php");
}
?>
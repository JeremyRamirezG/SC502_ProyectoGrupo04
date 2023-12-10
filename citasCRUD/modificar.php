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

    $codigo_err = $estado_err = $especialidad_err = $fecha_err = $metodo_err = $desc_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "../templates/recoge.php";

        $objDatos = new stdClass();
        
        $codigo_val = recogePost('CodCita');
        $objDatos-> Especialidad = $especialidad_val = recogePost('Especialidad');
        $objDatos-> Fecha = $fecha_val = recogePost('Fecha');
        $objDatos-> MetodoReserva = $metodo_val = recogePost('Reserva');
        $objDatos-> Descripcion = $desc_val = recogePost('Descripcion');
        $objDatos-> Estado = $estado_val = recogePost('Estado');

        if(empty($especialidad_val)||empty($fecha_val)||empty($metodo_val)||empty($desc_val)||empty($codigo_val)||empty($estado_val))
        {
            $codigo_err = $estado_err = $especialidad_err = $fecha_err = $metodo_err = $desc_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span class='errores'>$codigo_err<br>Redireccionando a página principal.</span>";
            sleep(2);
            header("Location: ../citas.php");
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $resultado = actualizarDatos('tab_citas',$objDatos,$codigo_val);
            if($resultado!=''){
                header("Location: ../citas.php");
            }
        }
    } else {
        header("Location: ../citas.php");
    }

} catch(Throwable $th) {
    error_log($th, 0);
    echo "<span class='errores'>Ocurrio un error en el sistema.<br>Redireccionando a página principal.</span>";
    sleep(2);
    header("Location: ../citas.php");
}
?>
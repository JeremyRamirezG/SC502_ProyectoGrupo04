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
        $motivo_val = recogePost('Motivo');

        if(empty($codigo_val))
        {
            $codigo_err = 'Algún dato requerido se encuentra vacío.';
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $query = "SELECT c.CodCita, c.Fecha, c.Especialidad, c.MétodoReserva, c.Descripción, c.Estado FROM tab_citas c WHERE c.CodCita = $codigo_val";
            $citas = getDatosArray($query);
            $objDatos = new stdClass();

            if(!empty($citas)){
                foreach($citas as $cita){
                    $objDatos-> Especialidad = $especialidad_val = $cita['Especialidad'];
                    $objDatos-> Fecha = $fecha_val = $cita['Fecha'];
                    $objDatos-> MetodoReserva = $metodo_val = $cita['MétodoReserva'];
                    $objDatos-> Descripcion = $desc_val = $cita['Descripción'];
                    $objDatos-> Estado = $estado_val = 'Cancelada';
                }
            }

            if(empty($especialidad_val)||empty($fecha_val)||empty($metodo_val)||empty($desc_val)||empty($estado_val))
            {
                $codigo_err = $estado_err = $especialidad_err = $fecha_err = $metodo_err = $desc_err = 'Algún dato requerido se encuentra vacío.';
                echo "<span class='errores'>$codigo_err<br>Redireccionando a página principal.</span>";
                sleep(2);
                echo "<script>window.location.href='../citas.php';</script>";
                //header("Location: ../citas.php");
            }
            else
            {
                $resultado = actualizarDatos('tab_citas',$objDatos,$codigo_val);
                if($resultado!=''){
                    $txt = "CodCita= {$codigo_val}, Motivo= {$motivo_val} \n";
                    $fp = fopen('../data/citasCanceladas.txt', 'a');
                    fwrite($fp, $txt);  
                    fclose($fp);  
                    echo "<script>window.location.href='../citas.php';</script>";
                }
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
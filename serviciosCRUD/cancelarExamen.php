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

        $codigo_val = recogePost('CodExamen');
        $motivo_val = recogePost('Motivo');

        if(empty($codigo_val))
        {
            $codigo_err = 'Algún dato requerido se encuentra vacío.';
            echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$codigo_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
            echo "<script>setTimeout(() => {window.location.href='../servicios.php';}, 2000);</script>";
        }
        else
        {
            require_once "../dbCRUD/datosCRUD.php";
            $query = "SELECT e.CodExamen, e.Fecha, e.Tipo, e.Resultado, e.Descripción, e.Estado FROM tab_examenesmedicos e WHERE e.CodExamen = $codigo_val";
            $examenes = getDatosArray($query);
            $objDatos = new stdClass();

            if(!empty($examenes)){
                foreach($examenes as $examen){
                    $objDatos-> Tipo = $tipo_val = $examen['Tipo'];
                    $objDatos-> Fecha = $fecha_val = $examen['Fecha'];
                    $objDatos-> Resultado = $resultado_val = $examen['Resultado'];
                    $objDatos-> Descripcion = $desc_val = $examen['Descripción'];
                    $objDatos-> Estado = $estado_val = 'Cancelado';
                }
            }

            if(empty($tipo_val)||empty($fecha_val)||empty($resultado_val)||empty($desc_val)||empty($estado_val))
            {
                $codigo_err = $estado_err = $especialidad_err = $fecha_err = $metodo_err = $desc_err = 'Algún dato requerido se encuentra vacío.';
                echo "<span style='color: #8B0000;font-size: large;padding: 10px;'>$codigo_err<br></span><span style='color: #8B0000;font-size: large;padding: 10px;'>Redireccionando a página principal.</span>";
                echo "<script>setTimeout(() => {window.location.href='../servicios.php';}, 2000);</script>";
            }
            else
            {
                $resultado = actualizarDatos('tab_examenesmedicos',$objDatos,$codigo_val);
                if($resultado!=''){
                    $txt = "CodExamen= {$codigo_val}, Motivo= {$motivo_val} \n";
                    $fp = fopen('../data/examenesCancelados.txt', 'a');
                    fwrite($fp, $txt);  
                    fclose($fp);  
                    echo "<script>window.location.href='../servicios.php';</script>";
                }
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
<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
        exit;
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
?>

<main class = "contenedor">
    <?php
    try {
        include_once "dbCRUD/datosCRUD.php";
        $query = "SELECT CodCita, Fecha, Especialidad, MétodoReserva, Descripción, Estado FROM tab_citas";
        $citas = getDatosArray($query);
        $citasPendientes = array();

        echo "<div class = 'contenido__historialCitas'>";
        echo "<div class = 'contenido__encabezado'>\n
                <h2>Historia de citas</h2>\n
                <div>\n
                <a href='' class = 'btn__accion'>Crear cita</a>\n
                <a href='' class = 'btn__accion'>Cancelar cita</a>\n
                </div>\n
            </div>";
        echo "<div class = 'contenido__tabla'>";
        if(!empty($citas)){
            echo "<table id = 'tabla__datos' class = 'table table-stripped'>";
            echo "<thead>";
            echo "<tr>\n
                    <th>Código</th>\n
                    <th>Fecha</th>\n
                    <th>Especialidad</th>\n
                    <th>Método de reserva</th>\n
                    <th>Descripción</th>\n
                    <th>Estado</th>\n
                    <th></th>\n
                    <th></th>\n
                </tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach($citas as $cita){
                echo "<tr>";
                echo "<td>{$cita['CodCita']}</td>";
                echo "<td>{$cita['Fecha']}</td>";
                echo "<td>{$cita['Especialidad']}</td>";
                echo "<td>{$cita['MétodoReserva']}</td>";
                echo "<td>{$cita['Descripción']}</td>";
                echo "<td>{$cita['Estado']}</td>";
                echo "<td>Futuro modificar</td>";
                echo "<td>Futuro eliminar</td>";
                echo "</tr>";
                if($cita['Estado'] == "Pendiente"){
                    array_push($citasPendientes, $cita);
                }
            }
            echo "</tbody>";
            echo "</table>";
        }
        else{
            echo "No hay citas!";
        }
        echo "</div>";
        echo "</div>";

        echo "<div class = 'contenido__pendientesCitas'>\n
            <div class = 'contenido__encabezado'>\n
                <h2>Citas pendientes</h2>\n
            </div>\n
            <div class = 'contenido__tabla'>";

        if(!empty($citasPendientes)){
            echo "<table id = 'tabla__datos__secundaria' class = 'table table-stripped'>";
            echo "<thead>";
            echo "<tr>\n
                    <th>Código</th>\n
                    <th>Fecha</th>\n
                    <th>Especialidad</th>\n
                </tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach($citasPendientes as $cita){
                echo "<tr>";
                echo "<td>{$cita['CodCita']}</td>";
                echo "<td>{$cita['Fecha']}</td>";
                echo "<td>{$cita['Especialidad']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        else{
            echo "No hay citas pendientes!";
        }
        echo "</div>";
        echo "<script src='https://code.jquery.com/jquery-3.7.0.js'></script>\n
                <script src='https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js'></script>\n
                <script src='https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'></script>\n
                <script src='scripts/table.js'></script>";
    } catch(Throwable $th) {
        error_log($th, 0);
    }
    ?>     
</main>


<?php
    require_once "templates/footer.php";
?>
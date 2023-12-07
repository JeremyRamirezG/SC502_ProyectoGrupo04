<?php
require_once "templates/head.php";
require_once "templates/headerNavbar.php";
require_once "templates/validarRol.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header('Location: login.php');
    exit();
}
?>

<main class="contenedor">
    <div class="contenido__feedback">
        <div class="contenido__encabezado">
            <h2>Deja tu Feedback</h2>
        </div>
        <div class="contenido__form__oculto">
            <div class="contenedor__form__oculto">
                <form action="feedbackCRUD/crear.php" method="POST">
                    <label for="titulo">Título</label>
                    <input class="form-control" type="text" id="titulo" name="titulo" required>
                    <label for="area">Área</label>
                    <select class="form-control" name="area" id="area" required>
                        <option selected value = ""></option>
                        <option value = "Soporte">Soporte</option>
                        <option value = "Caja">Caja</option>
                        <option value = "Doctores">Doctores</option>
                    </select>
                    <label for="calificacion">Calificación del 1 al 10</label>
                    <input class="form-control" type="number" id="calificacion" name="calificacion" min="1" max="10" required>
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    <input type="submit" value="Enviar Feedback">
                </form>
            </div>
        </div>
    </div>
    <div class="contenido__feedback" id="contenido__feedback">
        <div class="contenido__encabezado">
            <h2>Feedback</h2>
        </div>
        <div class = 'contenido__tabla'>
            <div class='table-responsive'>
                <?php
                try {
                    $query = "SELECT CodFeedback, Titulo, Area, Descripción, Calificacion FROM tab_feedback";
                    
                    $feedbacks = getDatosArray($query);

                    if(!empty($feedbacks)){
                        echo "<table id = 'tabla__datos' class = 'table table-stripped'>";
                        echo "<thead>";
                        echo "<tr>\n
                                <th>Código</th>\n
                                <th>Titulo</th>\n
                                <th>Area</th>\n
                                <th>Descripción</th>\n
                                <th>Calificacion</th>\n";
                        if($_SESSION["rol"]=="Administrador"){echo "<th></th>\n";}
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        foreach($feedbacks as $feedback){
                            echo "<tr>";
                            echo "<td id='codigo'>{$feedback['CodFeedback']}</td>";
                            echo "<td id='titulo'>{$feedback['Titulo']}</td>";
                            echo "<td id='area'>{$feedback['Area']}</td>";
                            echo "<td id='descripcion'>{$feedback['Descripción']}</td>";
                            echo "<td id='calificacion'>{$feedback['Calificacion']}</td>";
                            if($_SESSION["rol"]=="Administrador"){echo "<td><a id='btn__borrar' href='#form__eliminarfeedback'>Eliminar</a></td>";}
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
                    else{
                        echo "No hay feedback!";
                    }
                } catch(Throwable $th) {
                    error_log($th, 0);
                }
            ?>
        </div>
    </div>
    <div class = "form__oculto" id = "form__eliminarfeedback">
        <div class="wrapper__form__oculto">
            <h2>¿Esta seguro que desea eliminar este feedback?</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="feedbackCRUD/eliminar.php" method="POST">
                        <input name="CodFeedback"  id="codigo"  type="hidden" value="">
                        <input class="form-control" type="submit" value="Sí, acepto borrar el feedback.">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
    <script src='https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'></script>
    <script src='scripts/table.js'></script>
    <script src='scripts/feedback.js'></script>
</main>
<?php
require_once "templates/footer.php";
?>
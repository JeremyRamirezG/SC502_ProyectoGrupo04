<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
?>

<main class = "contenedor">
    <div class = 'contenido__historialCitas'>
        <div class = 'contenido__encabezado'>
            <h2>Historial de citas</h2>
            <div>
            <a href='#form__crear' class = 'btn__accion'>Crear cita</a>
            <a href='#form__cancelar' class = 'btn__accion'>Cancelar cita</a>
            </div>
        </div>
        <div class = 'contenido__tabla'>
        <?php
            try {
                include_once "dbCRUD/datosCRUD.php";

                $idUsuarioEnSesion = $_SESSION['id'];
                $queryRole = "SELECT CodRol FROM tab_rolesusuario WHERE Cédula = $idUsuarioEnSesion";
                $roles = getDatosArray($queryRole);

                $query = "SELECT c.CodCita, c.Fecha, c.Especialidad, c.MétodoReserva, c.Descripción, c.Estado FROM tab_citas c 
                        LEFT JOIN tab_citasusuario cu ON c.CodCita = cu.CodCita
                        LEFT JOIN tab_usuarios u ON u.Cédula = cu.Cédula
                        WHERE u.Cédula = $idUsuarioEnSesion";

                foreach($roles as $rol){
                    if($rol['CodRol'] == "3"){
                        $query = "SELECT c.CodCita, c.Fecha, c.Especialidad, c.MétodoReserva, c.Descripción, c.Estado FROM tab_citas c";
                    }
                }
                
                $citas = getDatosArray($query);
                $citasPendientes = array();

                if(!empty($citas)){
                    echo "<div class='table-responsive'>";
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
                        echo "<td id='codigo'>{$cita['CodCita']}</td>";
                        echo "<td id='fecha'>{$cita['Fecha']}</td>";
                        echo "<td id='especialidad'>{$cita['Especialidad']}</td>";
                        echo "<td id='reserva'>{$cita['MétodoReserva']}</td>";
                        echo "<td id='descripcion'>{$cita['Descripción']}</td>";
                        echo "<td id='estado'>{$cita['Estado']}</td>";
                        echo "<td><a id='btn__modificar' href='#form__modificar'>Modificar</a></td>";
                        echo "<td><a id='btn__borrar' href='#form__eliminar'>Eliminar</a></td>";
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
                echo "</div>";

                echo "<div class = 'contenido__pendientesCitas'>\n
                    <div class = 'contenido__encabezado'>\n
                        <h2>Citas pendientes</h2>\n
                    </div>\n
                    <div class = 'contenido__tabla'>";
                    echo "<div class='table-responsive'>";

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
            } catch(Throwable $th) {
                error_log($th, 0);
            }
        ?>     
    </div>
    <div class = "form__oculto" id = "form__cancelar">
        <div class="wrapper__form__oculto">
            <h2>Cancelar Cita</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="citasCRUD/cancelar.php" method="POST">
                        <select class="form-control" name="CodCita">
                            <option selected value = "">Código Cita</option>
                            <?php
                            try {
                                foreach($citasPendientes as $cita){
                                    echo "<option value='{$cita['CodCita']}'>{$cita['CodCita']}</option>";
                                }
                            } catch(Throwable $th) {
                                error_log($th, 0);
                            }
                            ?>
                        </select>
                        <textarea class="form-control" placeholder="Descripción del Motivo" name="Motivo"></textarea>
                        <input class="form-control" type="submit" value="Cancelar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__crear">
        <div class="wrapper__form__oculto">
            <h2>Crear Cita</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="citasCRUD/crear.php" method="POST">
                        <select class="form-control" name="Especialidad">
                            <option selected value = "">Especialidad</option>
                            <option value = "General">General</option>
                            <option value = "Cardiología">Cardiología</option>
                            <option value = "Pedicurista">Pedicurista</option>
                        </select>
                        <input class="form-control" placeholder="Fecha" type="date" name="Fecha">
                        <select class="form-control" name="Reserva">
                            <option selected value = "">Método de Reserva</option>
                            <option value = "Telefono">Teléfono</option>
                            <option value = "Correo">Correo</option>
                            <option value = "App">Aplicación</option>
                        </select>
                        <textarea class="form-control" placeholder="Descripción del Motivo" name="Descripcion"></textarea>
                        <input class="form-control" type="submit" value="Crear">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__eliminar">
        <div class="wrapper__form__oculto">
            <h2>¿Esta seguro que desea eliminar esta cita?</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="citasCRUD/eliminar.php" method="POST">
                        <input name="CodCita"  id="codigo"  type="hidden" value="">
                        <input class="form-control" type="submit" value="Sí, acepto borrar la cita.">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__modificar">
        <div class="wrapper__form__oculto">
            <h2>Modificar Cita</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="citasCRUD/modificar.php" method="POST">
                        <input name="CodCita" id="codigo" type="hidden" value="">
                        <!--<input class="form-control" placeholder="Especialidad" id="especialidad" type="text" value="">-->
                        <select class="form-control" name="Especialidad" id="especialidad" >
                            <option selected value = "">Especialidad</option>
                            <option value = "General">General</option>
                            <option value = "Cardiología">Cardiología</option>
                            <option value = "Pedicurista">Pedicurista</option>
                        </select>
                        <input class="form-control" placeholder="Fecha" id="fecha" type="date" name="Fecha" value="">
                        <!--<input class="form-control" placeholder="Método de Reserva" id="reserva" type="text" value="">-->
                        <select class="form-control" name="Reserva" id="reserva">
                            <option selected value = "">Método de Reserva</option>
                            <option value = "Telefono">Teléfono</option>
                            <option value = "Correo">Correo</option>
                            <option value = "App">Aplicación</option>
                        </select>
                        <select class="form-control" name="Estado" id="estado">
                            <option selected value = "">Estado de cita</option>
                            <option value = "Pendiente">Pendiente</option>
                            <option value = "Completada">Completada</option>
                            <option value = "Cancelada">Cancelada</option>
                        </select>
                        <textarea class="form-control" name="Descripcion" placeholder="Descripción del Motivo" id="descripcion" value=""></textarea>
                        <input class="form-control" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
    <script src='https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'></script>
    <script src='scripts/table.js'></script>
    <script src='scripts/citas.js'></script>
</main>


<?php
    require_once "templates/footer.php";
?>
<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
?>
<main class = "contenedor">
    <div class = "contenido__examenes" id="contenido__examenes">
        <div class = 'contenido__encabezado'>
            <h2>Exámenes Médicos</h2>
            <div>
            <a id='agendarexamen' href='#form__crearexamen' class = 'btn__accion'>Agendar</a>
            <a id='cancelarexamen' href='#form__cancelarexamen' class = 'btn__accion'>Cancelar</a>
            </div>
        </div>
        <div class = 'contenido__tabla'>
        <div class='table-responsive'>
        <?php
            try {
                include_once "dbCRUD/datosCRUD.php";

                $idUsuarioEnSesion = $_SESSION['id'];
                $queryRole = "SELECT CodRol FROM tab_rolesusuario WHERE Cédula = $idUsuarioEnSesion";
                $roles = getDatosArray($queryRole);

                $queryex = "SELECT e.CodExamen, e.Fecha, e.Tipo, e.Resultado, e.Descripción, e.Estado FROM tab_examenesmedicos e 
                        LEFT JOIN tab_examenesmedicosusuario eu ON e.CodExamen = eu.CodExamen
                        LEFT JOIN tab_usuarios u ON u.Cédula = eu.Cédula
                        WHERE u.Cédula = $idUsuarioEnSesion";

                foreach($roles as $rol){
                    if($rol['CodRol'] == "3"){
                        $queryex = "SELECT e.CodExamen, e.Fecha, e.Tipo, e.Resultado, e.Descripción, e.Estado FROM tab_examenesmedicos e";
                    }
                }
                
                $examenes = getDatosArray($queryex);
                $examenesPendientes = array();

                if(!empty($examenes)){
                    echo "<table id = 'tabla__datos' class = 'table table-stripped'>";
                    echo "<thead>";
                    echo "<tr>\n
                            <th>Código</th>\n
                            <th>Fecha</th>\n
                            <th>Tipo</th>\n
                            <th>Resultado</th>\n
                            <th>Descripción</th>\n
                            <th>Estado</th>\n
                            <th></th>\n
                            <th></th>\n
                        </tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach($examenes as $examen){
                        echo "<tr>";
                        echo "<td id='codigo'>{$examen['CodExamen']}</td>";
                        echo "<td id='fecha'>{$examen['Fecha']}</td>";
                        echo "<td id='tipo'>{$examen['Tipo']}</td>";
                        echo "<td id='resultado'>{$examen['Resultado']}</td>";
                        echo "<td id='descripcion'>{$examen['Descripción']}</td>";
                        echo "<td id='estado'>{$examen['Estado']}</td>";
                        echo "<td><a id='btn__modificar' href='#form__modificarexamen'>Modificar</a></td>";
                        echo "<td><a id='btn__borrar' href='#form__eliminarexamen'>Eliminar</a></td>";
                        echo "</tr>";
                        if($examen['Estado'] == "Pendiente"){
                            array_push($examenesPendientes, $examen);
                        }
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                else{
                    echo "No hay exámenes!";
                }
            } catch(Throwable $th) {
                error_log($th, 0);
            }
        ?>
        </div>
        </div>
    </div>
    <div class = "contenido__contactosemergencia" id="contenido__contactosemergencia">
        <div class = 'contenido__encabezado'>
            <h2>Contactos de Emergencia</h2>
            <div>
            <a id='agregarcontacto' href='#form__crearcontacto' class = 'btn__accion'>Agregar</a>
            </div>
        </div>
        <div class = 'contenido__tabla'>
        <div class='table-responsive'>
        <?php
            try {
                $querycon = "SELECT c.CodContacto, c.Nombre, c.Ubicacion, c.Telefono, c.Cédula FROM tab_contactoemergencia c 
                        LEFT JOIN tab_usuarios u ON u.Cédula = c.Cédula
                        WHERE c.Cédula = $idUsuarioEnSesion";

                foreach($roles as $rol){
                    if($rol['CodRol'] == "3"){
                        $querycon = "SELECT c.CodContacto, c.Nombre, c.Ubicacion, c.Telefono, c.Cédula FROM tab_contactoemergencia c";
                    }
                }
                
                $contactos = getDatosArray($querycon);

                if(!empty($contactos)){
                    echo "<table id = 'tabla__datos' class = 'table table-stripped'>";
                    echo "<thead>";
                    echo "<tr>\n
                            <th>Código</th>\n
                            <th>Nombre</th>\n
                            <th>Ubicación</th>\n
                            <th>Teléfono</th>\n
                            <th></th>\n
                            <th></th>\n
                        </tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach($contactos as $contacto){
                        echo "<tr>";
                        echo "<td id='codigo'>{$contacto['CodContacto']}</td>";
                        echo "<td id='nombre'>{$contacto['Nombre']}</td>";
                        echo "<td id='ubicacion'>{$contacto['Ubicacion']}</td>";
                        echo "<td id='telefono'>{$contacto['Telefono']}</td>";
                        echo "<td><a id='btn__modificar' href='#form__modificarcontacto'>Modificar</a></td>";
                        echo "<td><a id='btn__borrar' href='#form__eliminarcontacto'>Eliminar</a></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                else{
                    echo "No hay contactos de emergencia!";
                }
            } catch(Throwable $th) {
                error_log($th, 0);
            }
        ?>
        </div>
        </div>
    </div>
    <div class = "contenido__serviciosemergencia" id="contenido__serviciosemergencia">
        <div class = 'contenido__encabezado'>
            <h2>Servicios de emergencia</h2>
        </div>
        <div class = 'contenido__carrusel' id= 'carrusel'>
            <div class= 'atras' id="atras">
                <img id="atras"src="img/atras.svg" alt="atras" loading="lazy">
            </div>

            <div class = "imagenes" >
                <div id="img">
                    <img class="img"src="img/911.webp" alt="Referencia al 911" style="margin-right: 20px; margin-left: 20px;">
                </div>
                <div id="texto" class="texto__servicios">
                    <h3>Servicio de emergencias 911</h3>
                    <p>Servicio de emergencias público, en casos de emergencia no dude en marcar.</p>
                    <a onclick="window.open('tel:911');">Llamar <b id="llamar">911</b></a>
                </div>
            </div>

            <div class="adelante" id="adelante">
                <img id="adelante"src="img/adelante.svg" alt="adelante" loading="lazy">
            </div>
        </div>

        <div class="puntos" id="puntos"></div>
    </div>
    <div class = "form__oculto" id = "form__cancelarexamen">
        <div class="wrapper__form__oculto">
            <h2>Cancelar Examen</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/cancelarExamen.php" method="POST">
                        <select class="form-control" name="CodExamen">
                            <option selected value = "">Código Examen</option>
                            <?php
                            try {
                                foreach($examenesPendientes as $examen){
                                    echo "<option value='{$examen['CodExamen']}'>{$examen['CodExamen']}</option>";
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
    <div class = "form__oculto" id = "form__crearexamen">
        <div class="wrapper__form__oculto">
            <h2>Agendar Examen</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/crearExamen.php" method="POST">
                        <select class="form-control" name="Tipo">
                            <option selected value = "">Tipo</option>
                            <option value = "Orina">Orina</option>
                            <option value = "Heces">Heces</option>
                            <option value = "Sangre">Sangre</option>
                            <option value = "Venereas">Venereas</option>
                        </select>
                        <input class="form-control" placeholder="Fecha" type="date" name="Fecha">
                        <input name="Resultado"  id="resultado"  type="hidden" value="N/A">
                        <textarea class="form-control" placeholder="Descripción del Motivo" name="Descripcion"></textarea>
                        <input class="form-control" type="submit" value="Crear">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__eliminarexamen">
        <div class="wrapper__form__oculto">
            <h2>¿Esta seguro que desea eliminar este examen?</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/eliminarExamen.php" method="POST">
                        <input name="CodExamen"  id="codigo"  type="hidden" value="">
                        <input class="form-control" type="submit" value="Sí, acepto borrar el examen.">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__modificarexamen">
        <div class="wrapper__form__oculto">
            <h2>Modificar Examen</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/modificarExamen.php" method="POST">
                        <input name="CodExamen" id="codigo" type="hidden" value="">
                        <!--<input class="form-control" placeholder="Especialidad" id="especialidad" type="text" value="">-->
                        <select class="form-control" name="Tipo" id="tipo">
                            <option selected value = "">Tipo</option>
                            <option value = "Orina">Orina</option>
                            <option value = "Heces">Heces</option>
                            <option value = "Sangre">Sangre</option>
                            <option value = "Venereas">Venereas</option>
                        </select>
                        <input class="form-control" placeholder="Fecha" id="fecha" type="date" name="Fecha" value="">
                        <!--<input class="form-control" placeholder="Método de Reserva" id="reserva" type="text" value="">-->
                        <select class="form-control" name="Estado" id="estado">
                            <option selected value = "">Estado de examen</option>
                            <option value = "Pendiente">Pendiente</option>
                            <option value = "Completado">Completado</option>
                            <option value = "Cancelado">Cancelado</option>
                        </select>
                        <textarea class="form-control" name="Resultado" placeholder="Resultado" id="resultado" value=""></textarea>
                        <textarea class="form-control" name="Descripcion" placeholder="Descripción del Motivo" id="descripcion" value=""></textarea>
                        <input class="form-control" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class = "form__oculto" id = "form__crearcontacto">
        <div class="wrapper__form__oculto">
            <h2>Agregar contacto de emergencia</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/crearContacto.php" method="POST">
                        <input class="form-control" placeholder="Nombre" type="text" name="Nombre">
                        <input class="form-control" placeholder="Telefono" type="text" name="Telefono">
                        <textarea class="form-control" placeholder="Ubicación" name="Ubicacion"></textarea>
                        <input class="form-control" type="submit" value="Crear">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__eliminarcontacto">
        <div class="wrapper__form__oculto">
            <h2>¿Esta seguro que desea eliminar este contacto de emergencia?</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/eliminarContacto.php" method="POST">
                        <input name="CodContacto"  id="codigo"  type="hidden" value="">
                        <input class="form-control" type="submit" value="Sí, acepto borrar el contacto de emergencia.">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class = "form__oculto" id = "form__modificarcontacto">
        <div class="wrapper__form__oculto">
            <h2>Modificar Contacto</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
            <div class="contenido__form__oculto">
                <div class="contenedor__form__oculto">
                    <form action="serviciosCRUD/modificarContacto.php" method="POST">
                        <input name="CodContacto" id="codigo" type="hidden" value="">
                        <!--<input class="form-control" placeholder="Especialidad" id="especialidad" type="text" value="">-->
                        <input class="form-control" placeholder="Nombre" type="text" name="Nombre" id="nombre">
                        <input class="form-control" placeholder="Telefono" type="text" name="Telefono" id="telefono">
                        <textarea class="form-control" placeholder="Ubicación" name="Ubicacion" id="ubicacion"></textarea>
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
    <script src='scripts/servicios.js'></script>
</main>
<?php
    require_once "templates/footer.php";
?>
<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";
    require_once "templates/validarRol.php";

    if(!$_SESSION["rol"]=="Administrador"){
        header("location: index.php");
    }

    $cedula = $_SESSION['id'];
?>
    <main class="contenedor__dashboard">
        <div class="contenido__usuarios" id="contenido__usuarios">
            <div class="contenido__tabla">
                <div class='table-responsive'>
                <?php
                    try {
                        $query = "SELECT Cédula, PrimerNombre, PrimerApellido, Teléfono, Correo FROM tab_usuarios";
                        $rolUsuario = "";
                        $usuarios = getDatosArray($query);

                        if(!empty($usuarios)){
                            echo "<table id = 'tabla__datos' class = 'table table-stripped'>";
                            echo "<thead>";
                            echo "<tr>\n
                                    <th>Cédula</th>\n
                                    <th>Nombre</th>\n
                                    <th>Teléfono</th>\n
                                    <th>Correo</th>\n
                                    <th>Rol</th>\n";
                            if($_SESSION["rol"]=="Administrador"){echo "<th></th>\n";}
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach($usuarios as $usuario){
                                echo "<tr>";
                                echo "<td id='codigo'>{$usuario['Cédula']}</td>";
                                echo "<td id='nombre'>{$usuario['PrimerNombre']} {$usuario['PrimerApellido']}</td>";
                                echo "<td id='telefono'>{$usuario['Teléfono']}</td>";
                                echo "<td id='correo'>{$usuario['Correo']}</td>";

                                $queryRoles = "SELECT ru.CodRol FROM tab_usuarios u
                                LEFT JOIN tab_rolesusuario ru ON u.Cédula = ru.Cédula
                                WHERE u.Cédula = {$usuario['Cédula']}";

                                $roles = getDatosArray($queryRoles);

                                foreach ($roles as &$rol) {
                                    if($rol['CodRol']== 1){
                                        $rolUsuario = 'Cliente';
                                    } else if ($rol['CodRol'] == 2) {
                                        $rolUsuario = 'Empleado';
                                    } else if ($rol['CodRol'] == 3) {
                                        $rolUsuario = 'Administrador';
                                    }
                                }

                                echo "<td id='rol'>{$rolUsuario}</td>";


                                if($_SESSION["rol"]=="Administrador"){echo "<td><a id='btn__borrar' href='#form__eliminarusuario'>Eliminar</a></td>";}
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        }
                        else{
                            echo "No hay usuarios!";
                        }
                    } catch(Throwable $th) {
                        error_log($th, 0);
                    }
                ?>
                </div>
            </div>
        </div>
        <div class="contenido__admin">
            <a href="citas.php"><img src="img/citas.png" alt="Icono citas."></a>
        </div>
        <div class="contenido__admin">
            <a href="servicios.php"><img src="img/servicios.png" alt="Icono servicios."></a>
        </div>
        <div class="contenido__admin">
            <a href="soporteFeedback.php"><img src="img/feedback.png" alt="Icono feedback."></a>
        </div>
        <div class="contenido__admin">
            <a href="chatEnLinea.php"><img src="img/chat.png" alt="Chat en linea."></a>
        </div>
        <div class="contenido__admin">
            <a href="perfil.php"><img src="img/perfil.png" alt="Icono perfil."></a>
        </div>
        <div class = "form__oculto" id = "form__eliminarusuario">
            <div class="wrapper__form__oculto">
                <h2>¿Esta seguro que desea eliminar este usuario?</h2><button type="button" class="btn-close" aria-label="Close" onclick="location.href='#'"></button>
                <div class="contenido__form__oculto">
                    <div class="contenedor__form__oculto">
                        <form action="usuariosCRUD/eliminar.php" method="POST">
                            <input name="Cédula"  id="codigo"  type="hidden" value="">
                            <input class="form-control" type="submit" value="Sí, acepto borrar el usuario.">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src='https://code.jquery.com/jquery-3.7.0.js'></script>
        <script src='https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js'></script>
        <script src='https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js'></script>
        <script src='scripts/table.js'></script>
        <script src='scripts/dashboard.js'></script>
    </main>

<?php
    require_once "templates/footer.php";
?>

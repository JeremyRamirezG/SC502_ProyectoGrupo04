<?php
try {
    //Incluir el archivo para realizar la conexion a la base de datos
    require_once "dbCRUD/conexion.php";
    require_once "dbCRUD/datosCRUD.php";
    require_once "templates/head.php";

    $cedula_err = $correo_err = $telefono_err = $primerNombre_err = $segundoNombre_err = $apellidoPaterno_err = $apellidoMaterno_err = $contrasena_err = $confirmarContrasena_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "templates/recoge.php";
        $objDatos = new stdClass();

        $objDatos->Cedula = $cedula_val = recogePost('cedula');
        $objDatos->Correo = $correo_val = recogePost('correo');
        $objDatos->Telefono = $telefono_val = recogePost('telefono');
        $objDatos->PrimerNombre = $primerNombre_val = recogePost('primerNombre');
        $objDatos->SegundoNombre = $segundoNombre_val = recogePost('segundoNombre');
        $objDatos->PrimerApellido = $apellidoPaterno_val = recogePost('primerApellido');
        $objDatos->SegundoApellido = $apellidoMaterno_val = recogePost('segundoApellido');
        $objDatos->Contrasena = $contrasena_val = password_hash(recogePost('contrasena'), PASSWORD_DEFAULT);
        $confirmarContrasena_val = recogePost('confirmarContrasena');

        //Validación de que los datos estén llenos.
        if (empty($cedula_val) || empty($correo_val) || empty($telefono_val) || empty($primerNombre_val) || empty($segundoNombre_val) || empty($apellidoPaterno_val) || empty($apellidoMaterno_val) || empty($contrasena_val) || empty($confirmarContrasena_val)) {
            $cedula_err = $correo_err = $primerNombre_err = $segundoNombre_err = $apellidoPaterno_err = $apellidoMaterno_err = $contrasena_err = $confirmarContrasena_err = 'Algún dato requerido se encuentra vacío.';
        } else {
            //Validación que la cédula, correo y contraseña tengan el formato correcto.
            if (!preg_match('/^[1-9][0-9]*$/', $cedula_val)) {
                $cedula_err = 'El formato de la cédula no es válido.';
            } else if (!preg_match('/^[1-9][0-9]*$/', $telefono_val)) {
                $telefono_err = 'El formato del teléfono no es válido.';
            } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $correo_val)) {
                $correo_err = 'El formato del correo electrónico no es válido.';
            } else if ((strlen($contrasena_val) < 6) || (!password_verify($confirmarContrasena_val, $contrasena_val))) {
                $confirmarContrasena_err = $contrasena_err = 'El fomato de la contraseña no es válido, recuerde que la confirmación debe ser igual y debe tener mas de seis dígitos.';
            } else {
                //Validación de que la cédula no esté registrada en el sistema.
                $query = "SELECT Cédula FROM tab_usuarios WHERE Cédula = $cedula_val";
                if (!empty(getDatosArray($query))) {
                    $cedula_err = 'La cédula ingresada ya está registrada en el sistema.';
                }
            }
        }

        //Confirmar que la validación no detectó ningún error.
        if (empty($cedula_err) && empty($correo_err) && empty($telefono_err) && empty($primerNombre_err) && empty($segundoNombre_err) && empty($apellidoPaterno_err) && empty($apellidoMaterno_err) && empty($contrasena_err) && empty($confirmarContrasena_err)) {
            if (ingresoDatos('tab_usuarios', $objDatos)!='') {
                $objRole = new stdClass();
                $objRole->Cedula = $cedula_val;
                $objRole->CodRol = "1";
                if (ingresoDatos('tab_rolesusuario', $objRole)!='') {
                    header("Location: login.php");
                }
            }
        }
    }
} catch (Throwable $th) {
    error_log($th, 0);
}
?>

<body>
    <div class="contenedor__pagina">
        <div class="contenedor__form">
            <img class="form__logo" src="img/logo.png" alt="Logotipo">
            <h2>Registro de usuarios</h2>
            <p>Ingrese los siguientes datos acorde a su información.</p>
            <form class="form__datos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="contenedor__form__grid">
                    <div class="usuario__data">
                        <input type="number" name="cedula" id="cedula">
                        <span></span>
                        <label for="cedula">Cédula usuario:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="text" name="primerNombre" id="primerNombre">
                        <span></span>
                        <label for="primerNombre">Primer nombre:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="text" name="segundoNombre" id="segundoNombre">
                        <span></span>
                        <label for="segundoNombre">Segundo nombre:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="text" name="primerApellido" id="primerApellido">
                        <span></span>
                        <label for="primerApellido">Primer apellido:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="text" name="segundoApellido" id="segundoApellido">
                        <span></span>
                        <label for="segundoApellido">Segundo apellido:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="email" name="correo" id="correo">
                        <span></span>
                        <label for="correo">Correo usuario:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="number" name="telefono" id="telefono">
                        <span></span>
                        <label for="telefono">Teléfono usuario:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="password" name="contrasena" id="contrasena">
                        <span></span>
                        <label for="contrasena">Contraseña:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="password" name="confirmarContrasena" id="confirmarContrasena">
                        <span></span>
                        <label for="confirmarContrasena">Confirmar contraseña:</label>
                    </div>
                </div>
                <input type="submit" value="Registrar">
            </form>
            <p><a class="usuario__links" href="login.php">Si ya tiene una cuenta, inicie sesión.</a></p>
        </div>
    </div>
</body>

</html>
<?php
try{
    //Primero se inicia la sesión y se valida si ya se ha ingresado.
    session_start();
    if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
        header("location: index.php");
    }

    //Incluir el archivo para realizar la conexion a la base de datos
    require_once "dbCRUD/conexion.php";
    include_once "dbCRUD/datosCRUD.php";
    require_once "templates/head.php";
    require_once "templates/recoge.php";

    $sys_err = $contrasena_err = $email_err = '';
    $email = base64_decode(recogeGet('secret'));

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oConexion = Conecta();

        try {
            //Proceso de validacion de los diferentes valores insertados por el cliente

            $email_val = recogePost('email');
            $contrasena_val = password_hash(recogePost('contrasena'), PASSWORD_DEFAULT);
            $confirmarContrasena_val = recogePost('confirmarContrasena');
            $queryEmail = "SELECT Correo FROM tab_usuarios WHERE Correo = '$email_val'";
            $validarEmail = getDatosArray($queryEmail);

            //Validación de que los datos estén llenos.
            if (empty($email_val) || empty($contrasena_val) || empty($confirmarContrasena_val)) {
                $contrasena_err = $email_err = 'Algún dato requerido se encuentra vacío.';
            } else {
                //Validación que la cédula, correo y contraseña tengan el formato correcto.
                if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $correo_val)) {
                    $correo_err = 'El formato del correo electrónico no es válido.';
                }
                if ((strlen($contrasena_val) < 6) || (!password_verify($confirmarContrasena_val, $contrasena_val))) {
                    $confirmarContrasena_err = $contrasena_err = 'El fomato de la contraseña no es válido, recuerde que la confirmación debe ser igual y debe tener mas de seis dígitos.';
                }
            }

            if($email_err==''&&$contrasena_err=='')
            {
                $stmt = $oConexion->prepare("update tab_usuarios set Contraseña = ? where Correo = ?");
                $stmt->bind_param("ss", $iContraseña, $iCorreo);

                //set parametros y luego ejecutarl
                $iCorreo = $email_val;
                $iContraseña = $contrasena_val;

                if($stmt->execute()){
                    echo "<script>window.location.href='login.php';</script>";
                } else {
                    $sys_err = 'Ocurrio un error en el sistema.';
                }
                
            }
        }catch(Throwable $th) {
            error_log($th, 0);
            $sys_err = 'Ocurrio un error en el sistema.';
        }
        finally {
            Desconecta($oConexion);
        }
    }
    //header("location: index.php");

} catch(Throwable $th) {
    error_log($th, 0);
    $sys_err = 'Ocurrio un error en el sistema.';
}

?>
    <body>
        <div class="contenedor__pagina">
            <div class="contenedor__form">
                <img class="form__logo" src="img/logo.png" alt="Logotipo">
                <h2>Reinicio de contraseña</h2>
                <?php
                if($contrasena_err!=='')
                {
                    echo "<span class='errores'>$contrasena_err</span>";
                }
                if ($email_err!=='' && $contrasena_err!=='')
                {
                    echo "<br>";
                }
                if ($contrasena_err!=='')
                {
                    if($contrasena_err!==$email_err)
                    {
                        echo "<span class='errores'>$contrasena_err</span>";
                    }
                }
                if ($sys_err!=='')
                {
                    echo "<span class='errores'>$sys_err</span>";
                }
                ?>
                <form class="form__datos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                    <div class="usuario__data">
                        <input type="password" name="contrasena" id="contrasena" required>
                        <span></span>
                        <label for="contrasena">Nueva contraseña:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="password" name="confirmarContrasena" id="confirmarContrasena" required>
                        <span></span>
                        <label for="confirmarContrasena">Confirmar nueva contraseña:</label>
                    </div>
                    <input type="submit" value="Recuperar contraseña">
                </form>
            </div>
        </div>
    </body>
</html>
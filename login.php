<?php
try{
    //Primero se inicia la sesión y se valida si ya se ha ingresado.
    session_start();
    if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
        header("location: index.php");
    }

    //Incluir el archivo para realizar la conexion a la base de datos
    require_once "dbCRUD/conexion.php";
    require_once "dbCRUD/datosCRUD.php";
    require_once "templates/head.php";

    $sys_err = $cedula_err = $contrasena_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "templates/recoge.php";

        $cedula_val = recogePost('cedula');
        $confirmarContrasena_val = recogePost('contrasena');

        if($cedula_val=="")
        {
            $cedula_err = 'Ingrese su cédula.';
        } 
        else
        {
            if(!preg_match('/^[1-9][0-9]*$/', $cedula_val))
            {
                $cedula_err = 'El formato de la cédula no es válido.';
            }
        }
        if($confirmarContrasena_val=="")
        {
            $contrasena_err = 'Ingrese su contraseña.';
        }
        if($cedula_err==''&&$contrasena_err=='')
        {
            $query = "SELECT Cédula, Contraseña FROM tab_usuarios WHERE Cédula = $cedula_val";
            $arrayValidar = getDatosArray($query);
            if(!empty($arrayValidar))
            {
                foreach ($arrayValidar as $value)
                {
                    $contrasena_val = $value['Contraseña'];
                }
                if (password_verify($confirmarContrasena_val, $contrasena_val)) 
                {
                    session_start();
                    $_SESSION["logged"] = true;
                    $_SESSION["id"] = $cedula_val;
                    //header("Location:https://proyecto.jeremys.site/index.php");
                    echo "<script>window.location.href='index.php';</script>";
                    exit;
                }
                else
                {
                    $cedula_err = $contrasena_err = 'Error al iniciar sesión.';
                }
            }
            else
            {
                $cedula_err = $contrasena_err = 'Error al iniciar sesión.';
            }
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
                <h2>Inicio de sesión</h2>
                <?php
                    if($cedula_err!=='')
                    {
                        echo "<span class='errores'>$cedula_err</span>";
                    }
                    if ($cedula_err!=='' && $contrasena_err!=='')
                    {
                        echo "<br>";
                    }
                    if ($contrasena_err!=='')
                    {
                        if($contrasena_err!==$cedula_err)
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
                    <div class="usuario__data">
                        <input type="number" name="cedula" id="cedula" required>
                        <span></span>
                        <label for="cedula">Cédula usuario:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="password" name="contrasena" id="contrasena" required>
                        <span></span>
                        <label for="contrasena">Contraseña:</label>
                    </div>
                    <input type="submit" value="Iniciar Sesión">
                </form>
                <a class="usuario__links" href="register.php">Si no tiene una cuenta, registrece.</a>
            </div>
        </div>
    </body>
</html>
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

    $cedula_err = $contrasena_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "templates/recoge.php";

        $cedula_val = recogePost('cedula');
        $confirmarContrasena_val = recogePost('contrasena');

        if(empty($cedula_val)||empty($confirmarContrasena_val))
        {
            $cedula_err = $contrasena_err = 'Algún dato requerido se encuentra vacío.';
        }
        else
        {
            if(!preg_match('/^[1-9][0-9]*$/', $cedula_val))
            {
                $cedula_err = 'El formato de la cédula no es válido.';
            }
        }
        if(empty($cedula_err)&&empty($contrasena_err))
        {
            $query = "SELECT Cédula, Contraseña FROM tab_usuarios WHERE Cédula = $cedula_val";
            $arrayValidar = getDatosArray($query);
            if(!empty($arrayValidar))
            {
                foreach ($arrayValidar as $value) {
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
}

?>
    <body>
        <div class="contenedor__pagina">
            <div class="contenedor__form">
                <img class="form__logo" src="img/logo.png" alt="Logotipo">
                <h2>Inicio de sesión</h2>
                <span class="error">Ocurrio un error al iniciar sesión, por favor intente de nuevo:<br><?php echo $cedula_err."<br>".$contrasena_err?></span>
                <form class="form__datos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="usuario__data">
                        <input type="number" name="cedula" id="cedula">
                        <span></span>
                        <label for="cedula">Cédula usuario:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="password" name="contrasena" id="contrasena">
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
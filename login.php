<?php
try{
    //Primero se inicia la sesión y se valida si ya se ha ingresado.
    session_start();
    if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
        header("location: index.php");
        exit;
    }

    //Incluir el archivo para realizar la conexion a la base de datos
    require_once "dbCRUD/conexion.php";
    require_once "dbCRUD/datosCRUD.php";

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
                    header("location: index.php");
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

} catch(Throwable $th) {
    error_log($th, 0);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <div>
        <h2>Inicio de sesión</h2>
        <p>Ingrese los siguientes datos acorde a su información.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <label for="cedula">Cédula usuario:</label>
                <input type="number" name="cedula" id="cedula" placeholder="Digite su cédula">
            </div>
            <div>
                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Digite su contraseña">
            </div>
            <input type="submit" value="Iniciar Sesión">
        </form>
        <p><a href="register.php">Si no tiene una cuenta, registrece.</a></p>
    </div>   
</body>
</html>
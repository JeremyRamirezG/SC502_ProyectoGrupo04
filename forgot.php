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

    $resultado = $email_err = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Proceso de validacion de los diferentes valores insertados por el cliente
        require_once "templates/recoge.php";

        $email_val = recogePost('email');
        $queryEmail = "SELECT Correo FROM tab_usuarios WHERE Correo = '$email_val'";
        $validarEmail = getDatosArray($queryEmail);

        if($email_val=="")
        {
            $email_err = 'Ingrese su correo.';
        }
        else 
        {
            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email_val))
            {
                $email_err = 'El formato del correo electrónico no es válido.';
            }
            if (empty($validarEmail))
            {
                $email_err = 'El correo electrónico no es válido, confirme que se encuentra registrado.';
            }
        }

        if($email_err=='')
        {
            $body = '<div>
                    <h1>Reinicio de contrasena</h1>
                    <p><br><b>Hola!</b> este correo esta siendo recibido ya que usted solicitó reiniciar su contrasena, porfavor haga click en el boton para reiniciar.<br></p>
                    <p><button class="btn btn-primary"><a href="http://proyecto.jeremys.site/reset.php?secret='.base64_encode($email_val).'">Reiniciar contrasena</a></button><br></p>
                    </div>';
            
            include_once('smtp/class.phpmailer.php');
            include_once('smtp/class.smtp.php');

            $email = $email_val; 
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;                 
            $mail->SMTPSecure = "tls";      
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587; 
            $mail->Username = "jrgg7350@gmail.com";   //Enter your username/emailid
            $mail->Password = "incdftbvopeqwzxn";   //Enter your password
            $mail->FromName = "Centro RAS";
            $mail->AddAddress($email);
            $mail->Subject = "Reiniciar Contrasena";
            $mail->isHTML( TRUE );
            $mail->Body =$body;

            if($mail->send())
            {
                $resultado = "Se envió un link para reiniciar la contraseña a su correo!";
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
                <h2>Reinicio de contraseña</h2>
                <?php
                if($email_err!=='')
                {
                    echo "<span class='errores'>$email_err</span>";
                }
                if($resultado!=='')
                {
                    echo "<span class='informacion'>$resultado</span>";
                }
                ?>
                <form class="form__datos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="usuario__data">
                        <input type="email" name="email" id="email" required>
                        <span></span>
                        <label for="email">Correo usuario:</label>
                    </div>
                    <input type="submit" value="Recuperar contraseña">
                </form>
                <a class="usuario__links" href="login.php">Si ya tiene una cuenta y sabe su contraseña, inicie sesión.</a>
                <a class="usuario__links" href="register.php">Si no tiene una cuenta, registrece.</a>
            </div>
        </div>
    </body>
</html>
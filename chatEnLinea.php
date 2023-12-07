<?php
    session_start();
    if(!isset($_SESSION["logged"]) || !($_SESSION["logged"] === true)){
        header("location: login.php");
    }

    require_once "templates/head.php";
    require_once "templates/headerNavbar.php";

    $cliente_id = $_SESSION['id'];

    $queryUsuario = "SELECT u.Cédula, u.PrimerNombre, u.PrimerApellido, u.Correo, ru.CodRol FROM tab_usuarios u
                      LEFT JOIN tab_rolesusuario ru ON u.Cédula = ru.Cédula
                      WHERE u.Cédula = $cliente_id";
    $usuarioRoles = getDatosArray($queryUsuario);

    $usuarioData = new stdClass();

    if(!isset($_SESSION["rol"]) || !($_SESSION["rol"] === true) || empty($usuarioData->ID) || !isset($_SESSION["nombreCompleto"]) || !($_SESSION["nombreCompleto"] === true) ){
        foreach ($usuarioRoles as &$usuario) {

            $usuarioData = new stdClass();
        
            $usuarioData-> PrimerNombre = $usuario['PrimerNombre'];
            $usuarioData-> PrimerApellido = $usuario['PrimerApellido'];
            $usuarioData-> Correo = $usuario['Correo'];
            $usuarioData-> ID = $usuario['Cédula'];

            $_SESSION["nombreCompleto"]=$usuario['PrimerNombre']." ".$usuario['PrimerApellido'];

            if($usuario['CodRol'] == 1){
                $_SESSION["rol"]='Cliente';
                $usuarioData-> Rol = 'Cliente';
            } else if ($usuario['CodRol'] == 2) {
                $_SESSION["rol"]='Empleado';
                $usuarioData-> Rol = 'Empleado';
            } else if ($usuario['CodRol'] == 3) {
                $_SESSION["rol"]='Administrador';
                $usuarioData-> Rol = 'Administrador';
            }

        }
    }
    
    //Se selecciona un empleado random para asistir
    

    //echo $empleado_seleccionado['Correo'];
?>
<main class="contenedor__chat">
    <div class="info__chat">
        <h3>Bienvenido/a <?php echo $usuarioData-> PrimerNombre; echo ' '; echo $usuarioData-> PrimerApellido;?>.</h3>
    </div>
    <div class="contenido__chat">
    <?php
	if(file_exists("chatCRUD/chat.html") && filesize("chatCRUD/chat.html") > 0){
		$handle = fopen("chatCRUD/chat.html", "r");
		$contents = fread($handle, filesize("chatCRUD/chat.html"));
		fclose($handle);
		
		echo $contents;
	}
	?>
    </div>
    <form name="mensaje" class="control__chat" action = "">
        <input class="input__chat" type="text" name="msj__usr" id="msj__usr" size="63" />
        <input class="btn__chat" type="submit" name="env__msj" id="env__msj" value="Enviar" />
    </form>
</main>
<script src='https://code.jquery.com/jquery-3.7.0.js'></script>
<script type="text/javascript" src="scripts/chat.js"></script>

<?php
    require_once "templates/footer.php";
?>
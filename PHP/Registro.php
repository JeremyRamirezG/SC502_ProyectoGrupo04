<?php 
session_start();
$message='';
if(isset($_SESSION['email_alert'])){
    $message='El correo ya existe';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge>">
  <meta name="viewport" content="width=device-width, initial-scale">
  <link href="https://fonts.googleapis.com/css2?family=Nuosu+SIL&family=Oswald:wght@200&family=Roboto+Condensed:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/Registro.css">
  
  <title>Registro</title>
</head>

<body>
    
    <div class="contenedor">
        <h2>Registro</h2>
        
       
        <form action="BD.php" method="post">
            <div class="usuario">
                <input type="text" name="nombre" required>
                <label>Nombre</label>
            </div>
            <div class="usuario">
                <input type="text" name="apellido_paterno" required>
                <label>Primer Apellido</label>
            </div>
            <div class="usuario">
                <input type="text" name="apellido_materno" required>
                <label>Segundo Apellido</label>
            </div>
            <div class="usuario">
                <input type="text" name="correo" id="correo" required >
                <label>Correo</label>
                <h4> <?php echo $message; ?></h4>

            </div>   <?php unset($_SESSION['email_alert']);?>
            <div class="usuario">
                <input type="password" name="contrasena" required>
                <label>Contraseña</label>
            </div>
            <div class="usuario">
                <input type="password" name="confirmar_contrasena" required>
                <label>Confirmar Contraseña</label>
                <span id="error-contrasena" class="errorp">Las contraseñas no coinciden.</span>
                <span id="error-contrasena" class="errorp">La contraseña no es segura</span>
            </div>
            <button type="submit" class="boton">Registrar</button>
            <script src="../JS/confirmar.js"></script>
           

        </form>
    </div>

</body>

</html>






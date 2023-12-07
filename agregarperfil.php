<?php
try {
    // Verificar si el usuario está en sesión
    session_start();
    if (!isset($_SESSION['id'])) {
        // Redirigir o mostrar mensaje de error si el usuario no está en sesión
        header("Location: login.php");
    }

    // Incluir el archivo para realizar la conexión a la base de datos
    require_once "dbCRUD/conexion.php";
    require_once "dbCRUD/datosCRUD.php";
    require_once "templates/head.php";
    
    $oConexion = Conecta();
    $tipoSangre_err = $estatura_err = $peso_err = $avatar_err = '';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once "templates/recoge.php";
        $objDatos = new stdClass();
        $objDatosEnfermedad = new stdClass();
        $objDatosAlergia = new stdClass();
        $alergias_arr = [];
        $enfermedades_arr = [];
        
        // Obtener el ID del usuario en sesión
        $idUsuarioEnSesion = $_SESSION["id"];
        
        $objDatos->TipoSangre = $tipoSangre_val = recogePost('tipoSangre');
        $objDatos->Estatura = $estatura_val = recogePost('estatura');
        $objDatos->Peso = $peso_val = recogePost('peso');

        $enfermedades_arr = $_POST['enfermedades'];
        $alergias_arr  = $_POST['alergias'];

        // Validación de los nuevos campos
        if (empty($tipoSangre_val) || empty($estatura_val) || empty($peso_val)) {
            $tipoSangre_err = $estatura_err = $peso_err = 'Algún dato requerido se encuentra vacío.';
        }

        // Procesar el archivo de Avatar si se ha proporcionado
        if (isset($_FILES['avatar']) && $_FILES['avatar']['size'] > 0) {
            // Leer el contenido del archivo en forma de binario
            $imagenBinaria = file_get_contents($_FILES['avatar']['tmp_name']);
            $objDatos->Avatar = $imagenBinaria;
        } else {
            $objDatos->Avatar = null;
        }

        // Confirmar que la validación no detectó ningún error
        if (empty($tipoSangre_err) && empty($estatura_err) && empty($peso_err)) {
            $stmt = $oConexion->prepare("UPDATE tab_usuarios SET TipoSangre = ?, Estatura = ?, Peso = ?, Avatar = ? WHERE Cédula = ?");
            $stmt->bind_param("sssss", $objDatos->TipoSangre, $objDatos->Estatura, $objDatos->Peso, $objDatos->Avatar, $idUsuarioEnSesion);

            if ($stmt->execute()) {
                echo "Datos actualizados correctamente.";
            } else {
                echo "Error al actualizar los datos del usuario.";
            }
        }

        if ($enfermedades_arr!=[]){
            $queryED = "DELETE FROM tab_historialmedicousuario WHERE Cédula=$idUsuarioEnSesion";
            borrarDatos($queryED);

            foreach($enfermedades_arr as $enfermedad_val){
                $objDatosEnfermedad->Cedula = $idUsuarioEnSesion;
                $objDatosEnfermedad->CodHistorial = $enfermedad_val;
    
                $resultado = ingresoDatos('tab_historialmedicousuario',$objDatosEnfermedad);
            }
        }
        if ($alergias_arr!=[]){
            $queryAD = "DELETE FROM tab_alergiasusuario WHERE Cédula=$idUsuarioEnSesion";
            borrarDatos($queryAD);

            foreach($alergias_arr as $alergia_val){
    
                $objDatosAlergia->Cedula = $idUsuarioEnSesion;
                $objDatosAlergia->CodAlergia = $alergia_val;
    
                $resultado = ingresoDatos('tab_alergiasusuario',$objDatosAlergia);
            }
        }
        //header("Location:https://proyecto.jeremys.site/perfil.php");
        echo "<script>window.location.href='target.php';</script>";
        exit;

    }
    //header("location: perfil.php");
} catch (Throwable $th) {
    error_log($th, 0);
}
?>

<body>
    <div class="contenedor__pagina">
        <div class="contenedor__form">
            <img class="form__logo" src="img/logo.png" alt="Logotipo">
            <h2>Actualizar Datos</h2>
            <p>Ingrese los siguientes datos para actualizar su información.</p>
            <form class="form__datos" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="contenedor__form__grid">
                    <div class="usuario__data">
                        <input type="text" name="tipoSangre" id="tipoSangre">
                        <span><?php echo $tipoSangre_err; ?></span>
                        <label for="tipoSangre">Tipo de sangre:</label>
                    </div>
                    <div class="usuario__data">
                        <input type="number" name="estatura" id="estatura">
                        <span><?php echo $estatura_err; ?></span>
                        <label for="estatura">Estatura (cm):</label>
                    </div>
                    <div class="usuario__data">
                        <input type="number" name="peso" id="peso">
                        <span><?php echo $peso_err; ?></span>
                        <label for="peso">Peso (kg):</label>
                    </div>
                    <div class="usuario__data__avatar">
                        <input type="file" name="avatar" id="avatar" onchange="displayFileName()">
                        <span><?php echo $avatar_err; ?></span>
                        <label for="avatar">Subir Avatar</label>
                        <span id="fileName" style="font-size: large; color: var(--primario); max-width: 20px;"></span>
                    </div>
                    <select class="form-control" name="enfermedades[]" id="enfermedades" multiple="multiple" style="font-size: 1.8rem;">
                        <?php
                        try {
                            $queryE = "SELECT CodHistorial, Enfermedad FROM tab_historialmedico";
                            $enfermedades = getDatosArray($queryE);

                            foreach($enfermedades as $enfermedad){
                                echo "<option value='{$enfermedad['CodHistorial']}'>{$enfermedad['Enfermedad']}</option>";
                            }
                        } catch(Throwable $th) {
                            error_log($th, 0);
                        }
                        ?>
                    </select>
                    <select class="form-control" name="alergias[]" id="alergias" multiple="multiple"style="font-size: 1.8rem;">
                        <?php
                        try {
                            $queryA = "SELECT CodAlergia, Nombre FROM tab_alergias";
                            $alergias = getDatosArray($queryA);

                            foreach($alergias as $alergia){
                                echo "<option value='{$alergia['CodAlergia']}'>{$alergia['Nombre']}</option>";
                            }
                        } catch(Throwable $th) {
                            error_log($th, 0);
                        }
                        ?>
                    </select>
                </div>
                <input type="submit" value="Actualizar Datos">
            </form>
            <a class="usuario__links" href="perfil.php">Volver al perfil</a>
        </div>
    </div>
</body>
</html>
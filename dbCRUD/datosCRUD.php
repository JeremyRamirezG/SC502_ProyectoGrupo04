<?php

use PSpell\Config;

require_once "conexion.php";

function getDatosArray($sql) {
    $retorno = array();
    try {
        $oConexion = Conecta();

        //formato datos utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            
            if(!$result = mysqli_query($oConexion, $sql)) die(); //cancelamos el programa


            while ($row = mysqli_fetch_array($result)) {
                $retorno[] = $row;
            }
        }

    } catch (Throwable $th) {
        error_log($th, 0);
    }finally{
        Desconecta($oConexion);
    }

    return $retorno;
}

function getDatosObject($sql) {
    $retorno = null;
    try {
        $oConexion = Conecta();

        //formato datos utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            
            if(!$result = mysqli_query($oConexion, $sql)) die(); //cancelamos el programa

            while ($row = mysqli_fetch_array($result)) {
                $retorno = $row;
            }
        }

    } catch (Throwable $th) {
        error_log($th, 0);
    }finally{
        Desconecta($oConexion);
    }

    return $retorno;
}

function borrarDatos($sql) {
    $retorno = false;

    try {
        $oConexion = Conecta();

        //formato datos utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            if($result = mysqli_query($oConexion, $sql)){
                $retorno = true;
            } else{
                die();//cancelamos el programa
            }
        }

    } catch (Throwable $th) {
        error_log($th, 0);
    }finally{
        Desconecta($oConexion);
    }

    return $retorno;
}

function ingresoDatos($table, $pObject) {
    $retorno = false;
    $last_id = '';

    /* Para declarar los parametros para el query SQL enviamos un objeto y se referencian dependiendo de la tabla a actualizar. Ejemplo:
    $pObject = new stdClass();
    $pObject->cedula = "118420454";
    $pObject->primerNombre = "Jeremy";
    $pObject->segundoNombre = "Andres";
    ...
    var_dump($pObject);
    $iNombre = $pObject->primerNombre; */

    try {
        $oConexion = Conecta();

        //formato datos utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            switch ($table) {
                case "tab_alergias":
                    $stmt1 = $oConexion->prepare("insert into tab_alergias (Nombre, Descripción, Tipo) values (?, ?, ?)");
                    $stmt1->bind_param("sss", $iNombre, $iDescripcion, $iTipo);

                    //set parametros y luego ejecutarl
                    $iNombre = $pObject->Nombre;
                    $iDescripcion = $pObject->Descripcion;
                    $iTipo = $pObject->Tipo;

                    if($stmt1->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_alergiasusuario":
                    $stmt2 = $oConexion->prepare("insert into tab_alergiasusuario (CodAlergia, Cédula) values (?, ?)");
                    $stmt2->bind_param("ss", $iCodAlergia, $iCédula);

                    //set parametros y luego ejecutarl
                    $iCodAlergia = $pObject->CodAlergia;
                    $iCédula = $pObject->Cedula;

                    if($stmt2->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_citas":
                    $stmt3 = $oConexion->prepare("insert into tab_citas (Fecha, Especialidad, MétodoReserva, Descripción, Estado) values (?, ?, ?, ?, ?)");
                    $stmt3->bind_param("sssss", $iFecha, $iEspecialidad, $iMétodoReserva, $iDescripción, $iEstado);

                    //set parametros y luego ejecutarl
                    $iFecha = $pObject->Fecha;
                    $iEspecialidad = $pObject->Especialidad;
                    $iMétodoReserva = $pObject->MetodoReserva;
                    $iDescripción = $pObject->Descripcion;
                    $iEstado = $pObject->Estado;

                    if($stmt3->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_citasusuario":
                    $stmt4 = $oConexion->prepare("insert into tab_citasusuario (CodCita, Cédula) values (?, ?)");
                    $stmt4->bind_param("ss", $iCodCita, $iCédula);

                    //set parametros y luego ejecutarl
                    $iCodCita = $pObject->CodCita;
                    $iCédula = $pObject->Cedula;

                    if($stmt4->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_contactoemergencia":
                    $stmt5 = $oConexion->prepare("insert into tab_contactoemergencia (Nombre, Ubicacion, Telefono, Cédula) values (?, ?, ?, ?)");
                    $stmt5->bind_param("ssss", $iNombre, $iUbicacion, $iTelefono, $iCedula);

                    //set parametros y luego ejecutarl
                    $iNombre = $pObject->Nombre;
                    $iUbicacion = $pObject->Ubicacion;
                    $iTelefono = $pObject->Telefono;
                    $iCedula = $pObject->Cedula;

                    if($stmt5->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_examenesmedicos":
                    $stmt6 = $oConexion->prepare("insert into tab_examenesmedicos (Fecha, Tipo, Resultado, Descripción, Estado) values (?, ?, ?, ?, ?)");
                    $stmt6->bind_param("sssss", $iFecha, $iTipo, $iResultado, $iDescripcion, $iEstado);

                    //set parametros y luego ejecutarl
                    $iFecha = $pObject->Fecha;
                    $iTipo = $pObject->Tipo;
                    $iResultado = $pObject->Resultado;
                    $iDescripcion = $pObject->Descripcion;
                    $iEstado = $pObject->Estado;

                    if($stmt6->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_examenesmedicosusuario":
                    $stmt7 = $oConexion->prepare("insert into tab_examenesmedicosusuario (CodExamen, Cédula) values (?, ?)");
                    $stmt7->bind_param("ss", $iCodExamen, $iCédula);

                    //set parametros y luego ejecutarl
                    $iCodExamen = $pObject->CodExamen;
                    $iCédula = $pObject->Cedula;

                    if($stmt7->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_feedback":
                    $stmt8 = $oConexion->prepare("insert into tab_feedback (Titulo, Area, Descripción, Calificacion) values (?, ?, ?, ?)");
                    $stmt8->bind_param("ssss", $iTitulo, $iArea, $iDescripción, $iCalificación);

                    //set parametros y luego ejecutarl
                    $iTitulo = $pObject->Titulo;
                    $iArea = $pObject->Area;
                    $iDescripción = $pObject->Descripcion;
                    $iCalificación = $pObject->Calificacion;

                    if($stmt8->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_historialmedico":
                    $stmt9 = $oConexion->prepare("insert into tab_historialmedico (Enfermedad, Descripción, Tipo) values (?, ?, ?)");
                    $stmt9->bind_param("sss", $iEnfermedad, $iDescripcion, $iTipo);

                    //set parametros y luego ejecutarl
                    $iEnfermedad = $pObject->Enfermedad;
                    $iDescripcion = $pObject->Descripcion;
                    $iTipo = $pObject->Tipo;

                    if($stmt9->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_historialmedicousuario":
                    $stmt10 = $oConexion->prepare("insert into tab_historialmedicousuario (CodHistorial, Cédula) values (?, ?)");
                    $stmt10->bind_param("ss", $iCodHistorial, $iCédula);

                    //set parametros y luego ejecutarl
                    $iCodHistorial = $pObject->CodHistorial;
                    $iCédula = $pObject->Cedula;

                    if($stmt10->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_roles":
                    $stmt11 = $oConexion->prepare("insert into tab_roles (Descripción) values (?)");
                    $stmt11->bind_param("s", $iDescripción);

                    //set parametros y luego ejecutarl
                    $iDescripción = $pObject->Descripcion;

                    if($stmt11->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_rolesusuario":
                    $stmt12 = $oConexion->prepare("insert into tab_rolesusuario (CodRol, Cédula) values (?, ?)");
                    $stmt12->bind_param("ss", $iCodRol, $iCédula);

                    //set parametros y luego ejecutarl
                    $iCodRol = $pObject->CodRol;
                    $iCédula = $pObject->Cedula;

                    if($stmt12->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                case "tab_usuarios":
                    $stmt13 = $oConexion->prepare("insert into tab_usuarios (Cédula, PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Teléfono, Correo, Contraseña, TipoSangre, Estatura, Peso) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt13->bind_param("sssssssssss", $iCédula, $iPrimerNombre, $iSegundoNombre, $iPrimerApellido, $iSegundoApellido, $iTeléfono, $iCorreo, $iContraseña, $iTipoSangre, $iEstatura, $iPeso);

                    //set parametros y luego ejecutarl
                    $iCédula = $pObject->Cedula;
                    $iPrimerNombre = $pObject->PrimerNombre;
                    $iSegundoNombre = $pObject->SegundoNombre;
                    $iPrimerApellido = $pObject->PrimerApellido;
                    $iSegundoApellido = $pObject->SegundoApellido;
                    $iTeléfono = $pObject->Telefono;
                    $iCorreo = $pObject->Correo;
                    $iContraseña = $pObject->Contrasena;
                    $iTipoSangre = $pObject->TipoSangre;
                    $iEstatura = $pObject->Estatura;
                    $iPeso = $pObject->Peso;
                    

                    if($stmt13->execute()){
                        $last_id = $oConexion->insert_id;
                        $retorno = true;
                    }
                    break;
                default:
                    break;
            }

        }

    } catch (Throwable $th) {
        error_log($th, 0);
    }finally{
        Desconecta($oConexion);
    }

    return $last_id;
}

function actualizarDatos($table, $pObject, $pId) {
    $retorno = false;

    /* Para declarar los parametros para el query SQL enviamos un objeto y se referencian dependiendo de la tabla a actualizar. Ejemplo:
    $pObject = new stdClass();
    $pObject->cedula = "118420454";
    $pObject->primerNombre = "Jeremy";
    $pObject->segundoNombre = "Andres";
    ...
    var_dump($pObject);
    $iNombre = $pObject->primerNombre; */

    try {
        $oConexion = Conecta();

        //formato datos utf8
        if(mysqli_set_charset($oConexion, "utf8")){
            switch ($table) {
                case "tab_alergias":
                    $stmt1 = $oConexion->prepare("update tab_alergias set Nombre = ?, Descripción = ?, Tipo = ? where CodAlergia = ?");
                    $stmt1->bind_param("sss", $iNombre, $iDescripcion, $iTipo, $iId);

                    //set parametros y luego ejecutarl
                    $iNombre = $pObject->Nombre;
                    $iDescripcion = $pObject->Descripcion;
                    $iTipo = $pObject->Tipo;
                    $iId = $pId;

                    if($stmt1->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_citas":
                    $stmt3 = $oConexion->prepare("update tab_citas set Fecha = ?, Especialidad = ?, MétodoReserva = ?, Descripción = ?, Estado = ? where CodCita = ?");
                    $stmt3->bind_param("ssssss", $iFecha, $iEspecialidad, $iMétodoReserva, $iDescripción, $iEstado, $iId);

                    //set parametros y luego ejecutarl
                    $iFecha = $pObject->Fecha;
                    $iEspecialidad = $pObject->Especialidad;
                    $iMétodoReserva = $pObject->MetodoReserva;
                    $iDescripción = $pObject->Descripcion;
                    $iEstado = $pObject->Estado;
                    $iId = $pId;

                    if($stmt3->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_contactoemergencia":
                    $stmt5 = $oConexion->prepare("update tab_contactoemergencia set Nombre = ?, Ubicacion = ?, Telefono = ? where CodContacto = ?");
                    $stmt5->bind_param("ssss", $iNombre, $iUbicacion, $iTelefono, $iId);

                    //set parametros y luego ejecutarl
                    $iNombre = $pObject->Nombre;
                    $iUbicacion = $pObject->Ubicacion;
                    $iTelefono = $pObject->Telefono;
                    $iId = $pId;

                    if($stmt5->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_examenesmedicos":
                    $stmt6 = $oConexion->prepare("update tab_examenesmedicos set Fecha = ?, Tipo = ?, Resultado = ?, Descripción = ?, Estado = ? where CodExamen = ?");
                    $stmt6->bind_param("ssssss", $iFecha, $iTipo, $iResultado, $iDescripcion, $iEstado, $iId);

                    //set parametros y luego ejecutarl
                    $iFecha = $pObject->Fecha;
                    $iTipo = $pObject->Tipo;
                    $iResultado = $pObject->Resultado;
                    $iDescripcion = $pObject->Descripcion;
                    $iEstado = $pObject->Estado;
                    $iId = $pId;

                    if($stmt6->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_feedback":
                    $stmt8 = $oConexion->prepare("update tab_feedback set Titulo = ?, Area = ?, Descripción = ?, Calificación = ? where CodFeedback = ?");
                    $stmt8->bind_param("sssss", $iTitulo, $iArea, $iDescripción, $iCalificación, $iId);

                    //set parametros y luego ejecutarl
                    $iTitulo = $pObject->Titulo;
                    $iArea = $pObject->Area;
                    $iDescripción = $pObject->Descripcion;
                    $iCalificación = $pObject->Calificacion;
                    $iId = $pId;

                    if($stmt8->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_historialmedico":
                    $stmt9 = $oConexion->prepare("update tab_historialmedico set Enfermedad = ?, Descripción = ?, Tipo = ? where CodHistorial = ?");
                    $stmt9->bind_param("ssss", $iEnfermedad, $iDescripcion, $iTipo, $iId);

                    //set parametros y luego ejecutarl
                    $iEnfermedad = $pObject->Enfermedad;
                    $iDescripcion = $pObject->Descripcion;
                    $iTipo = $pObject->Tipo;
                    $iId = $pId;

                    if($stmt9->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_roles":
                    $stmt11 = $oConexion->prepare("update tab_roles set Descripción = ? where CodRol = ?");
                    $stmt11->bind_param("ss", $iDescripción, $iId);

                    //set parametros y luego ejecutarl
                    $iDescripción = $pObject->Descripcion;
                    $iId = $pId;

                    if($stmt11->execute()){
                        $retorno = true;
                    }
                    break;
                case "tab_usuarios":
                    $stmt13 = $oConexion->prepare("update tab_usuarios set PrimerNombre = ?, SegundoNombre = ?, PrimerApellido = ?, SegundoApellido = ?, Teléfono = ?, Correo = ?, Contraseña = ?, TipoSangre = ?, Estatura = ?, Peso = ? where Cédula = ?");
                    $stmt13->bind_param("sssssssssss", $iPrimerNombre, $iSegundoNombre, $iPrimerApellido, $iSegundoApellido, $iTeléfono, $iCorreo, $iContraseña, $iTipoSangre, $iEstatura, $iPeso, $iId);

                    //set parametros y luego ejecutarl
                    $iPrimerNombre = $pObject->PrimerNombre;
                    $iSegundoNombre = $pObject->SegundoNombre;
                    $iPrimerApellido = $pObject->PrimerApellido;
                    $iSegundoApellido = $pObject->SegundoApellido;
                    $iTeléfono = $pObject->Telefono;
                    $iCorreo = $pObject->Correo;
                    $iContraseña = $pObject->Contrasena;
                    $iTipoSangre = $pObject->TipoSangre;
                    $iEstatura = $pObject->Estatura;
                    $iPeso = $pObject->Peso;
                    $iId = $pId;

                    if($stmt13->execute()){
                        $retorno = true;
                    }
                    break;
                default:
                    break;
            }

        }

    } catch (Throwable $th) {
        error_log($th, 0);
    }finally{
        Desconecta($oConexion);
    }

    return $retorno;
}
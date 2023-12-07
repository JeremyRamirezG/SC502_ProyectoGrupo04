<?php

function Conecta() {
    try{
        $server = "v-jeremyrtests.mysql.database.azure.com";
        $user = "JeremyR";
        $password = "Tttt@restt2001"; //Tttt@restt2001
        $dataBase = "centrodesalud";

        $conexion = mysqli_connect($server, $user, $password, $dataBase);

        if(!$conexion){
            echo "Ocurrió un error al establecer la conexión " . mysqli_connect_error();
        }

        return $conexion;
    } catch(Throwable $th) {
        error_log($th, 0);
    }
}

function Desconecta($conexion) {
    try{
        mysqli_close($conexion);
    } catch(Throwable $th) {
        error_log($th, 0);
    }
}